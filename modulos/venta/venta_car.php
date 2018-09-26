<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoProducto = new cCatalogoProducto();
require_once ("../servicio/cServicio.php");
$oServicio = new cServicio();
require_once ("../formatos/formato.php");

$igv_dato=0.18;
$almacen_venta=$_SESSION['almacen_id'];

$unico_id=$_POST['unico_id'];

if ($_POST['cot_id']!='') {
//    $dts = $oCotizacion->mostrarUno($_POST['cot_id']);
//    $dt = mysql_fetch_array($dts);

$dtscot1=$oCotizacion->mostrar_venta_detalle($_POST['cot_id']);
//$num_rows3= mysql_num_rows($dtscot1);

$dtscot2=$oCotizacion->mostrar_venta_detalle_servicio($_POST['cot_id']);
    while($dtcot1 = mysql_fetch_array($dtscot1)) {
            if($dtcot1['tb_cotizaciondetalle_can']>0){
                //producto por catalogo y stock y almacen
                $dts= $oCatalogoProducto->presentacion_catalogo_stock_almacen($dtcot1['tb_catalogo_id'],$almacen_venta);
                $dt = mysql_fetch_array($dts);
                $pro_nom=$dt['tb_producto_nom'];
                $pre_nom=$dt['tb_presentacion_nom'];
                $pre_id	=$dt['tb_presentacion_id'];
                $sto_num=$dt['tb_stock_num'];
                $cat_mul=$dt['tb_catalogo_mul'];
                $nombre_producto=$pro_nom.' '.$pre_nom;
                mysql_free_result($dts);

                $num=0;
                if(isset($_SESSION['venta_car'][$unico_id])){
                    foreach($_SESSION['venta_car'][$unico_id] as $indice=>$cantidad){
                        if(($dtcot1['tb_catalogo_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$unico_id][$indice])){
                            $num++;
                        }
                    }
                }

                if($num==0){
                    //IDENTIFICADOR CATALOGO Y CANTIDAD
                    $_SESSION['venta_car'][$unico_id][$dtcot1['tb_catalogo_id']]=$dtcot1['tb_cotizaciondetalle_can'];

                    //PRECIO DE VENTA
                    $_SESSION['venta_preven'][$unico_id][$dtcot1['tb_catalogo_id']]=moneda_mysql($dtcot1['tb_cotizaciondetalle_preuni']);

                    //TIPO DE DESCUENTO  1 PORCENTAJE	2 SOLES
                    $_SESSION['venta_tipdes'][$unico_id][$dtcot1['tb_catalogo_id']]=$dtcot1['tb_cotizaciondetalle_des'];

                    //DESCUENTO
                    $_SESSION['venta_des'][$unico_id][$dtcot1['tb_catalogo_id']]=moneda_mysql($dtcot1['tb_cotizaciondetalle_des']*$dtcot1['tb_cotizaciondetalle_can']);

                    //GRAVADO/EXONERADO/INAFECTO
                    $_SESSION['venta_tip'][$unico_id][$dtcot1['tb_catalogo_id']]=$_POST['cat_tip'];

                    $_SESSION['venta_nom'][$unico_id][$dtcot1['tb_catalogo_id']]=$pro_nom;

                    //IGV
                    //$_SESSION['venta_igv'][$unico_id][$_POST['cat_id']]=$_POST['cat_igv'];

                    ////PRESENTACION para verificar si ingresa otra unidad de la misma presentacion
                    $_SESSION['presentacion_id'][$unico_id][$dtcot1['tb_catalogo_id']]=$pre_id;

                    //CATALOGO MULTIPLO para calculo de cantidades
                    $_SESSION['catalogo_mul'][$unico_id][$dtcot1['tb_catalogo_id']]=$cat_mul;
                }

                if($num==1){
                    foreach($_SESSION['venta_car'][$unico_id] as $indice=>$cantidad){
                        // diferente unidad y misma presentacion
                        if(($dtcot1['tb_catalogo_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$unico_id][$indice])){
                            $t1=$cat_mul*$dtcot1['tb_cotizaciondetalle_can'];//cantidad que ingresa
                            $t2=$_SESSION['catalogo_mul'][$unico_id][$indice]*$_SESSION['venta_car'][$unico_id][$indice];//cantidad q hay en carrito
                            //echo 'N='.$_POST['cat_id'].' nN='.$t1.'<br>';
                            //echo 'S='.$indice.' nS='.$t2.'<br>';
                            //echo 'stock='.$sto_num.'<br>';

                            $ped=$t1+$t2;//sumatoria total de cantidad en unidad base
                            $dif=$ped-$sto_num;
                            //echo 'pedido='.$ped.'<br>';

                            //verificando el mayor multiplo
                            if($cat_mul>$_SESSION['catalogo_mul'][$unico_id][$indice])
                            {
                                //echo 'El mayor mul es N'.$cat_mul;
                                if($dif>0){
                                    $st_uni=floor($sto_num/$cat_mul);
                                    $st_res=$sto_num%$cat_mul;
                                }

                                if($ped<=$sto_num)
                                {
                                    $st_uni=floor($ped/$cat_mul);
                                    $st_res=$ped%$cat_mul;
                                }

                                //unidad nueva agregar a carrito

                                $_SESSION['venta_car'][$unico_id][$dtcot1['tb_catalogo_id']]=$st_uni;//id cat - cantidad
                                $_SESSION['venta_des'][$unico_id][$dtcot1['tb_catalogo_id']]=moneda_mysql($dtcot1['tb_cotizaciondetalle_des']);//id cat - descuento
                                $_SESSION['venta_tip'][$unico_id][$dtcot1['tb_catalogo_id']]=$_POST['cat_tip'];

                                $_SESSION['venta_nom'][$unico_id][$dtcot1['tb_catalogo_id']]=$pro_nom;
                                $_SESSION['venta_tipdes'][$unico_id][$dtcot1['tb_catalogo_id']]=$_POST['cat_tipdes'];
                                //$_SESSION['venta_igv'][$unico_id][$_POST['cat_id']]=$_POST['cat_igv'];//id cat - igv
                                $_SESSION['venta_preven'][$unico_id][$dtcot1['tb_catalogo_id']]=moneda_mysql($dtcot1['tb_cotizaciondetalle_preuni']);//id cat - precio venta
                                $_SESSION['presentacion_id'][$unico_id][$dtcot1['tb_catalogo_id']]=$pre_id;//id cat-presentacion - pre_id
                                $_SESSION['catalogo_mul'][$unico_id][$dtcot1['tb_catalogo_id']]=$cat_mul;//id cat-presentacion - mul

                                //unidad en sesion.... agregar o eliminar del carrito
                                if($st_res>0)
                                {
                                    $_SESSION['venta_car'][$unico_id][$indice]=$st_res;
                                }
                                else
                                {
                                    unset($_SESSION['venta_car'][$unico_id][$indice]);
                                    unset($_SESSION['venta_des'][$unico_id][$indice]);
                                    unset($_SESSION['venta_tip'][$unico_id][$indice]);
                                    unset($_SESSION['venta_nom'][$unico_id][$indice]);
                                    unset($_SESSION['venta_tipdes'][$unico_id][$indice]);
                                    //unset($_SESSION['venta_igv'][$unico_id][$indice]);
                                    unset($_SESSION['venta_preven'][$unico_id][$indice]);
                                    unset($_SESSION['presentacion_id'][$unico_id][$indice]);
                                    unset($_SESSION['catalogo_mul'][$unico_id][$indice]);
                                }
                                $msj='Se ajustó automaticamente cantidad de '.$nombre_producto;
                                if($dif>0)$msj.=' desface en '.$dif.'.';
                            }
                            else
                            {
                                //echo 'El mayor mul es S'.$_SESSION['catalogo_mul'][$unico_id][$indice];
                                if($dif>0){
                                    $st_uni=floor($sto_num/$_SESSION['catalogo_mul'][$unico_id][$indice]);
                                    $st_res=$sto_num%$_SESSION['catalogo_mul'][$unico_id][$indice];
                                }

                                if($ped<=$sto_num)
                                {
                                    $st_uni=floor($ped/$_SESSION['catalogo_mul'][$unico_id][$indice]);
                                    $st_res=$ped%$_SESSION['catalogo_mul'][$unico_id][$indice];
                                }

                                //unidad en sesion
                                if($st_res>0)
                                {
                                    //unidad nueva
                                    $_SESSION['venta_car'][$unico_id][$dtcot1['tb_catalogo_id']]=$st_res;//id cat - cantidad
                                    $_SESSION['venta_tipdes'][$unico_id][$dtcot1['tb_catalogo_id']]=$_POST['cat_tipdes'];//id cat - tipodescuento
                                    $_SESSION['venta_des'][$unico_id][$dtcot1['tb_catalogo_id']]=$dtcot1['tb_cotizaciondetalle_des'];//id cat - descuento
                                    $_SESSION['venta_tip'][$unico_id][$dtcot1['tb_catalogo_id']]=$_POST['cat_tip'];//id cat - descuento

                                    $_SESSION['venta_nom'][$unico_id][$dtcot1['tb_catalogo_id']]=$pro_nom;
                                    //$_SESSION['venta_igv'][$unico_id][$_POST['cat_id']]=$_POST['cat_igv'];//id cat - igv
                                    $_SESSION['venta_preven'][$unico_id][$dtcot1['tb_catalogo_id']]=$dtcot1['tb_cotizaciondetalle_preuni'];//id cat - precio venta
                                    $_SESSION['presentacion_id'][$unico_id][$dtcot1['tb_catalogo_id']]=$pre_id;//id cat-presentacion - pre_id
                                    $_SESSION['catalogo_mul'][$unico_id][$dtcot1['tb_catalogo_id']]=$cat_mul;//id cat-presentacion - mul
                                }

                                $_SESSION['venta_car'][$unico_id][$indice]=$st_uni;

                                $msj='Se ajustó automaticamente cantidad de '.$nombre_producto;
                                if($dif>0)$msj.=' desface en '.$dif.'.';
                            }
                        } //fin if
                    }//fin foreach venta_car
                }

                if($num>1)
                {
                    $msj='No se permite agregar mas de 2 unidades de una sola presentación de producto.';
                }

            }
    }
}
//$num_rows_2= mysql_num_rows($dtscot2);
//End Cotización

//Venta

//agregar a cesta
if($_POST['action']=='agregar'){
    if($_POST['cat_can']>0){
        //producto por catalogo y stock y almacen
        $dts= $oCatalogoProducto->presentacion_catalogo_stock_almacen($_POST['cat_id'],$almacen_venta);
        $dt = mysql_fetch_array($dts);
        $pro_nom=$dt['tb_producto_nom'];

        $pre_nom=$dt['tb_presentacion_nom'];
        $pre_id	=$dt['tb_presentacion_id'];
        $sto_num=$dt['tb_stock_num'];
        $cat_mul=$dt['tb_catalogo_mul'];
        $nombre_producto=$pro_nom.' '.$pre_nom;
        mysql_free_result($dts);

        $num=0;
        if(isset($_SESSION['venta_car'][$unico_id])){
            foreach($_SESSION['venta_car'][$unico_id] as $indice=>$cantidad){
                if(($_POST['cat_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$unico_id][$indice])){
                    $num++;
                }
            }
        }

        if($num==0){
            //IDENTIFICADOR CATALOGO Y CANTIDAD
            $_SESSION['venta_car'][$unico_id][$_POST['cat_id']]=$_POST['cat_can'];

            //PRECIO DE VENTA
            $_SESSION['venta_preven'][$unico_id][$_POST['cat_id']]=moneda_mysql($_POST['cat_preven']);

            //TIPO DE DESCUENTO  1 PORCENTAJE	2 SOLES
            $_SESSION['venta_tipdes'][$unico_id][$_POST['cat_id']]=$_POST['cat_tipdes'];

            //DESCUENTO
            $_SESSION['venta_des'][$unico_id][$_POST['cat_id']]=moneda_mysql($_POST['cat_des']);

            //GRAVADO/EXONERADO/INAFECTO
            $_SESSION['venta_tip'][$unico_id][$_POST['cat_id']]=$_POST['cat_tip'];

            $_SESSION['venta_nom'][$unico_id][$_POST['cat_id']]=$pro_nom;

            $_SESSION['venta_serial'][$unico_id][$_POST['cat_id']] = '';

            //IGV
            //$_SESSION['venta_igv'][$unico_id][$_POST['cat_id']]=$_POST['cat_igv'];

            ////PRESENTACION para verificar si ingresa otra unidad de la misma presentacion
            $_SESSION['presentacion_id'][$unico_id][$_POST['cat_id']]=$pre_id;

            //CATALOGO MULTIPLO para calculo de cantidades
            $_SESSION['catalogo_mul'][$unico_id][$_POST['cat_id']]=$cat_mul;
        }

        if($num==1){
            foreach($_SESSION['venta_car'][$unico_id] as $indice=>$cantidad){
                // diferente unidad y misma presentacion
                if(($_POST['cat_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$unico_id][$indice])){
                    $t1=$cat_mul*$_POST['cat_can'];//cantidad que ingresa
                    $t2=$_SESSION['catalogo_mul'][$unico_id][$indice]*$_SESSION['venta_car'][$unico_id][$indice];//cantidad q hay en carrito
                    //echo 'N='.$_POST['cat_id'].' nN='.$t1.'<br>';
                    //echo 'S='.$indice.' nS='.$t2.'<br>';
                    //echo 'stock='.$sto_num.'<br>';

                    $ped=$t1+$t2;//sumatoria total de cantidad en unidad base
                    $dif=$ped-$sto_num;
                    //echo 'pedido='.$ped.'<br>';

                    //verificando el mayor multiplo
                    if($cat_mul>$_SESSION['catalogo_mul'][$unico_id][$indice])
                    {
                        //echo 'El mayor mul es N'.$cat_mul;
                        if($dif>0){
                            $st_uni=floor($sto_num/$cat_mul);
                            $st_res=$sto_num%$cat_mul;
                        }

                        if($ped<=$sto_num)
                        {
                            $st_uni=floor($ped/$cat_mul);
                            $st_res=$ped%$cat_mul;
                        }

                        //unidad nueva agregar a carrito

                        $_SESSION['venta_car'][$unico_id][$_POST['cat_id']]=$st_uni;//id cat - cantidad
                        $_SESSION['venta_des'][$unico_id][$_POST['cat_id']]=moneda_mysql($_POST['cat_des']);//id cat - descuento
                        $_SESSION['venta_tip'][$unico_id][$_POST['cat_id']]=$_POST['cat_tip'];

                        $_SESSION['venta_nom'][$unico_id][$_POST['cat_id']]=$pro_nom;
                        $_SESSION['venta_serial'][$unico_id][$_POST['cat_id']] = '';
                        $_SESSION['venta_tipdes'][$unico_id][$_POST['cat_id']]=$_POST['cat_tipdes'];
                        //$_SESSION['venta_igv'][$unico_id][$_POST['cat_id']]=$_POST['cat_igv'];//id cat - igv
                        $_SESSION['venta_preven'][$unico_id][$_POST['cat_id']]=moneda_mysql($_POST['cat_preven']);//id cat - precio venta
                        $_SESSION['presentacion_id'][$unico_id][$_POST['cat_id']]=$pre_id;//id cat-presentacion - pre_id
                        $_SESSION['catalogo_mul'][$unico_id][$_POST['cat_id']]=$cat_mul;//id cat-presentacion - mul

                        //unidad en sesion.... agregar o eliminar del carrito
                        if($st_res>0)
                        {
                            $_SESSION['venta_car'][$unico_id][$indice]=$st_res;
                        }
                        else
                        {
                            unset($_SESSION['venta_car'][$unico_id][$indice]);
                            unset($_SESSION['venta_des'][$unico_id][$indice]);
                            unset($_SESSION['venta_tip'][$unico_id][$indice]);
                            unset($_SESSION['venta_nom'][$unico_id][$indice]);
                            unset($_SESSION['venta_serial'][$unico_id][$indice]);
                            unset($_SESSION['venta_tipdes'][$unico_id][$indice]);
                            //unset($_SESSION['venta_igv'][$unico_id][$indice]);
                            unset($_SESSION['venta_preven'][$unico_id][$indice]);
                            unset($_SESSION['presentacion_id'][$unico_id][$indice]);
                            unset($_SESSION['catalogo_mul'][$unico_id][$indice]);
                        }
                        $msj='Se ajustó automaticamente cantidad de '.$nombre_producto;
                        if($dif>0)$msj.=' desface en '.$dif.'.';
                    }
                    else
                    {
                        //echo 'El mayor mul es S'.$_SESSION['catalogo_mul'][$unico_id][$indice];
                        if($dif>0){
                            $st_uni=floor($sto_num/$_SESSION['catalogo_mul'][$unico_id][$indice]);
                            $st_res=$sto_num%$_SESSION['catalogo_mul'][$unico_id][$indice];
                        }

                        if($ped<=$sto_num)
                        {
                            $st_uni=floor($ped/$_SESSION['catalogo_mul'][$unico_id][$indice]);
                            $st_res=$ped%$_SESSION['catalogo_mul'][$unico_id][$indice];
                        }

                        //unidad en sesion
                        if($st_res>0)
                        {
                            //unidad nueva
                            $_SESSION['venta_car'][$unico_id][$_POST['cat_id']]=$st_res;//id cat - cantidad
                            $_SESSION['venta_tipdes'][$unico_id][$_POST['cat_id']]=$_POST['cat_tipdes'];//id cat - tipodescuento
                            $_SESSION['venta_des'][$unico_id][$_POST['cat_id']]=$_POST['cat_des'];//id cat - descuento
                            $_SESSION['venta_tip'][$unico_id][$_POST['cat_id']]=$_POST['cat_tip'];//id cat - descuento

                            $_SESSION['venta_nom'][$unico_id][$_POST['cat_id']]=$pro_nom;
                            $_SESSION['venta_serial'][$unico_id][$_POST['cat_id']] = '';
                            //$_SESSION['venta_igv'][$unico_id][$_POST['cat_id']]=$_POST['cat_igv'];//id cat - igv
                            $_SESSION['venta_preven'][$unico_id][$_POST['cat_id']]=$_POST['cat_preven'];//id cat - precio venta
                            $_SESSION['presentacion_id'][$unico_id][$_POST['cat_id']]=$pre_id;//id cat-presentacion - pre_id
                            $_SESSION['catalogo_mul'][$unico_id][$_POST['cat_id']]=$cat_mul;//id cat-presentacion - mul
                        }

                        $_SESSION['venta_car'][$unico_id][$indice]=$st_uni;

                        $msj='Se ajustó automaticamente cantidad de '.$nombre_producto;
                        if($dif>0)$msj.=' desface en '.$dif.'.';
                    }
                } //fin if
            }//fin foreach venta_car
        }

        if($num>1)
        {
            $msj='No se permite agregar mas de 2 unidades de una sola presentación de producto.';
        }

    }
}

//agregar servicio
if($_POST['action']=='agregar_servicio'){
    $_SESSION['servicio_car'][$unico_id][$_POST['ser_id']]		= $_POST['ser_can'];//id servicio - cantidad
    $_SESSION['servicio_preven'][$unico_id][$_POST['ser_id']]	= moneda_mysql($_POST['ser_pre']);//id servicio - precio
    $_SESSION['servicio_tipdes'][$unico_id][$_POST['ser_id']]	= $_POST['ser_rad_tipdes'];//id servicio - tipodescuento (1 ó 2)
    $_SESSION['servicio_des'][$unico_id][$_POST['ser_id']]		= moneda_mysql($_POST['ser_des']);//id servicio - descuento
    $_SESSION['servicio_tip'][$unico_id][$_POST['ser_id']]		= $_POST['ser_tip'];
    switch ($_POST['ser_tip']) {
        case '1':
            $tipo_item_txt = "";
            break;
        case '2':
            $tipo_item_txt = "***PREMIO***";
            break;
        case '3':
            $tipo_item_txt = "***DONACIÓN***";
            break;
        case '4':
            $tipo_item_txt = "***RETIRO***";
            break;
        case '5':
            $tipo_item_txt = "***PUBLICIDAD***";
            break;
        case '6':
            $tipo_item_txt = "***BONIFICACIÓN***";
            break;
        case '7':
            $tipo_item_txt = "***ENTREGA A TRABAJADORES***";
            break;
    }
    $_SESSION['servicio_nom'][$unico_id][$_POST['ser_id']]		= $_POST['ser_nom'] . ' ' . $tipo_item_txt;
}


//quitar valores del array
if($_POST['action']=='quitar'){
    unset($_SESSION['venta_car'][$unico_id][$_POST['cat_id']]);
    unset($_SESSION['venta_preven'][$unico_id][$_POST['cat_id']]);
    unset($_SESSION['venta_nom'][$unico_id][$_POST['cat_id']]);
    unset($_SESSION['venta_serial'][$unico_id][$_POST['cat_id']]);
    unset($_SESSION['venta_tipdes'][$unico_id][$_POST['cat_id']]);
    unset($_SESSION['venta_des'][$unico_id][$_POST['cat_id']]);
    unset($_SESSION['venta_tip'][$unico_id][$_POST['cat_id']]);
    //unset($_SESSION['venta_igv'][$unico_id][$_POST['cat_id']]);
    unset($_SESSION['presentacion_id'][$unico_id][$_POST['cat_id']]);
    unset($_SESSION['catalogo_mul'][$unico_id][$_POST['cat_id']]);
}

if($_POST['action']=='quitar_servicio'){
    unset($_SESSION['servicio_car'][$unico_id][$_POST['ser_id']]);
    unset($_SESSION['servicio_preven'][$unico_id][$_POST['ser_id']]);
    unset($_SESSION['servicio_tipdes'][$unico_id][$_POST['ser_id']]);
    unset($_SESSION['servicio_des'][$unico_id][$_POST['ser_id']]);
    unset($_SESSION['servicio_tip'][$unico_id][$_POST['ser_id']]);
    unset($_SESSION['servicio_nom'][$unico_id][$_POST['ser_id']]);
}


//restablecer o eliminar array
if($_POST['action']=='restablecer')
{
    unset($_SESSION['venta_car'][$unico_id]);
    unset($_SESSION['venta_des'][$unico_id]);
    unset($_SESSION['venta_tip'][$unico_id]);
    unset($_SESSION['venta_tipdes'][$unico_id]);
    //unset($_SESSION['venta_igv'][$unico_id]);
    unset($_SESSION['venta_preven'][$unico_id]);
    unset($_SESSION['presentacion_id'][$unico_id]);
    unset($_SESSION['catalogo_mul'][$unico_id]);
    unset($_SESSION['venta_descuento'][$unico_id]);
    unset($_SESSION['venta_general_des']);

    unset($_SESSION['servicio_car'][$unico_id]);
    unset($_SESSION['servicio_preven'][$unico_id]);
    unset($_SESSION['servicio_tipdes'][$unico_id]);
    unset($_SESSION['servicio_des'][$unico_id]);
    unset($_SESSION['servicio_tip'][$unico_id]);
}


if(isset($_SESSION['venta_car'][$unico_id]) or isset($_SESSION['servicio_car'][$unico_id]))
{
    if(isset($_SESSION['venta_car'][$unico_id]))	$num_rows=count($_SESSION['venta_car'][$unico_id]);
    if(isset($_SESSION['servicio_car'][$unico_id]))$num_rows2=count($_SESSION['servicio_car'][$unico_id]);

    $filas=$num_rows+$num_rows2;
    if($filas==0)$num_rows="";
}
else
{
    $filas="";
}
?>
<script type="text/javascript">

    $('.btn_rest_act').button({
        icons: {
            //primary: "ui-icon-cart"//,
            secondary: "ui-icon-refresh"
        },
        text: false
    });

    $('.btn_rest_car').button({
        icons: {
            //primary: "ui-icon-cart"//,
            secondary: "ui-icon-cart"
        },
        text: true
    });

    $('.btn_agregar_producto').button({
        icons: {
            primary:  "ui-icon-plus"
        },
        text: true
    });

    $('.btn_item').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });

    $('.btn_quitar').button({
        icons: {primary: "ui-icon-minus"},
        text: false
    });

    $('.moneda2').autoNumeric({
        aSep: ',',
        aDec: '.',
        //aSign: 'S/. ',
        //pSign: 's',
        vMin: '0.00',
        vMax: '9999.99'
    });



    function calcular_vuelto(){
        var importe = $("#txt_importe_cliente").val();
        var total = $('#txt_ven_tot').val();
        $.ajax({
            type: "POST",
            url: "../venta/venta_vuelto.php",
            async:true,
            dataType: "html",
            data: ({
                importe: importe,
                total:	total
            }),
            beforeSend: function(){

            },
            success: function(vuelto){
                $('#lbl_ven_vuelto').val(vuelto);
            }
        });
    }

    $('#txt_ven_des').change(function(e) {
        venta_car_prorrateo()
    });

    $(function() {
        $("#txt_importe_cliente").keyup(function() {
            calcular_vuelto();
        });

        $("#tabla_venta_car").tablesorter({
            widgets: ['zebra'],
            headers: {
                //7: {sorter: false }
            },
            //sortForce: [[0,0]],
            //sortList: [[1,0]]
        });

    });
</script>
<input name="hdd_ven_numite" id="hdd_ven_numite" type="hidden" value="<?php echo $filas?>">
<fieldset><legend>Agregar Servicios</legend>
<?php if($_POST['vista']!='cange'){?>
<a class="btn_agregar_producto" title="Agregar Producto y/o Servicio (A+P)" href="#" onClick="catalogo_venta_tab()">Agregar</a>
<a class="btn_rest_car" href="#" onClick="venta_car('restablecer')">Vaciar</a>
<?php }?>
<a class="btn_rest_act" href="#" onClick="venta_car('actualizar')">Actualizar</a>
<div id="msj_ventanota_car" class="ui-state-error ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php if($msj!=""){echo 'block';} else{ echo 'none';}?>"><?php echo $msj?></div>
<div id="msj_venta_check" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>

</fieldset>

<?php
if($filas=="" or $filas==0) echo 'Ningún ítem agregados.';


if($filas==1)echo $filas.' ítem agregado.';
if($filas>=2)echo $filas.' ítems agregados.';
?>
<table cellspacing="1" id="tabla_venta_car" class="tablesorter">
    <thead>
    <tr>
        <th>TIPOs</th>
        <th>G/E/I</th>
        <th>CODIGO</th>
        <th>ARTICULO</th>
        <!--<th>PRESENTACION</th>-->
        <th align="left" title="UNIDAD">UNID</th>
        <th align="right" title="CANTIDAD">CANT</th>
        <th align="right" title="VALOR UNITARIO">VALOR UNIT</th>
        <th align="right" title="PRECIO UNITARIO">PRECIO UNIT</th>
        <th align="right" title="PRECIO EXONERADO">P. EXONERADO</th>
        <th align="right" title="DESCUENTO">DSCTO</th>
        <th align="right" nowrap="nowrap" title="VALOR VENTA">VALOR VEN</th>
        <th align="right" nowrap="nowrap" title="PRECIO VENTA">PREC VENTA</th>
        <!--<th align="right">IGV</th>-->
        <th width="25">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sub_total = 0;
    $valor_venta_total = 0;
    $ope_exoneradas_total = 0;
    $ope_gravadas_total = 0;
    $ope_gratuitas_total = 0;
    $desc_x_item_total=0;
    if($_SESSION['venta_general_des']=="")
    {
        $general_des=0;
    }
    else
    {
        $general_des=moneda_mysql($_SESSION['venta_general_des']);
    }
    if($num_rows>0)foreach($_SESSION['venta_car'][$unico_id] as $indice=>$cantidad){
        $dts1=$oCatalogoProducto->presentacion_catalogo_stock_almacen($indice,$almacen_venta);
        $dt1 = mysql_fetch_array($dts1);

        //precio de venta ingresado
        $precio_unitario = $_SESSION['venta_preven'][$unico_id][$indice];
        if($_SESSION['venta_des'][$unico_id][$indice]=="")
        {
            $linea_desc_x_item_percent=0;
        }
        else
        {
            $linea_desc_x_item_percent = $_SESSION['venta_des'][$unico_id][$indice];
        }


        $tipo_item	=$dt1['tb_afectacion_id'];

        if ($tipo_item==9) {
            $linea_valor_unitario = $precio_unitario;
        }else{
            $linea_valor_unitario = $precio_unitario / 1.18;
        }

        $linea_valor_venta_bruto=$linea_valor_unitario*$cantidad;

        $linea_desc_x_item=$linea_valor_venta_bruto*$linea_desc_x_item_percent/100;
        $linea_valor_venta_x_item = $linea_valor_venta_bruto-$linea_desc_x_item;
        $desc_x_item_total+=$linea_desc_x_item;
        $linea_igv=$linea_valor_venta_x_item*0.18;


        //tipo g/e/i ingresado
//    if ($tipo_item==9) {
        $precio_unitario = $precio_unitario - $precio_unitario * ($linea_desc_x_item_percent / 100);
//    }
//    else if($tipo_item==1){
        $precio_unitario = $precio_unitario - $precio_unitario * ($general_des / 100);
//    }

        if ($tipo_item==9){
            $tipo_pro='Exonerado';
            $valor_venta_unitario = $precio_unitario;
            $valor_venta = $valor_venta_unitario * $cantidad;
            $precio_venta = $precio_unitario * $cantidad;
            $ope_exoneradas_total += $valor_venta;

        }else if($tipo_item==1){
            $tipo_pro='Gravado';
            $valor_venta_unitario = $precio_unitario/(1+$igv_dato);
            $valor_venta = $valor_venta_unitario * $cantidad;
            $precio_venta = $precio_unitario * $cantidad;
            $ope_gravadas_total += $valor_venta;
        }else if($tipo_item==2 or $tipo_item==3 or $tipo_item==4 or $tipo_item==5 or $tipo_item==6 or $tipo_item==7){
            $tipo_pro='Gratuito';
            $valor_venta_unitario = $precio_unitario/(1+$igv_dato);
            $valor_venta = $valor_venta_unitario * $cantidad;
            $precio_venta = $precio_unitario * $cantidad;
            $ope_gratuitas_total += $valor_venta;
        }

        //Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
        $tipdes = $_SESSION['venta_tipdes'][$unico_id][$indice];


        //sumatoria factura
        if($tipo_item==1 || $tipo_item==9){
            $sub_total = $sub_total + $linea_valor_venta_x_item;
        }

        ?>
        <tr>
            <td>Producto </td>
            <td>
            <?php echo $tipo_pro?>
            </td>
            <td><?php echo $dt1['tb_presentacion_cod']?></td>
            <td><?php echo $_SESSION['venta_nom'][$unico_id][$indice];
                if ($_SESSION['venta_serial'][$unico_id][$indice]!=''){
                    echo ' - '.$_SESSION['venta_serial'][$unico_id][$indice];
                }
                ?>
            </td>
            <!--<td><?php //echo $dt1['tb_presentacion_nom']?></td>-->
            <td align="left" title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
            <td align="right"><?php echo $cantidad?></td>
            <td align="right"><?php echo formato_money($linea_valor_unitario)?></td>
            <?php if ($tipo_item==9){ ?>
                <td align="right"></td>
                <td align="right"><?php echo formato_money($precio_unitario)?></td>
            <?php } else{ ?>
                <td align="right"><?php echo formato_money($precio_unitario)?></td>
                <td align="right"></td>
            <?php } ?>
            <td align="right">
                <?php echo formato_money($linea_desc_x_item_percent/100*($linea_valor_unitario*$cantidad))?>
            </td>
            <td align="right">
                <?php
                    echo formato_money($linea_valor_venta_x_item);
                ?>
            </td>
            <td align="right">
                <?php echo formato_money($precio_venta)?>

            </td>
            <!--<td align="right"><?php //echo formato_money($igv)?></td>-->
            <td align="center" nowrap="nowrap">
                <?php if($_POST['vista']!='cange'){?>
                    <a class="btn_item" href="#" onClick="editar_datos_item('editar_producto','<?php echo $dt1['tb_catalogo_id']?>')">Actualizar Datos de Item</a><a class="btn_quitar" href="#" onClick="venta_car('quitar','<?php echo $dt1['tb_catalogo_id']?>')">Quitar</a>
                <?php }?>
            </td>
        </tr>
        <?php
        mysql_free_result($dts1);
    }
    ?>

    <?php
    if($num_rows2>0)foreach($_SESSION['servicio_car'][$unico_id] as $indice=>$cantidad){
        $dts1=$oServicio->mostrarUno($indice);
        $dt1 = mysql_fetch_array($dts1);

        $precio_unitario	=$_SESSION['servicio_preven'][$unico_id][$indice];


        //tipo g/e/i ingresado
        $tipo_item	= 1;
        $linea_valor_unitario = $precio_unitario / 1.18;

        $linea_valor_venta_bruto=$linea_valor_unitario*$cantidad;
        $linea_desc_x_item_percent=0;
        $linea_desc_x_item=$linea_valor_venta_bruto*$linea_desc_x_item_percent/100;
        $linea_valor_venta_x_item = $linea_valor_venta_bruto-$linea_desc_x_item;
        $linea_igv=$linea_valor_venta_x_item*0.18;


        //tipo g/e/i ingresado
        $precio_unitario=$precio_unitario-$precio_unitario*($general_des/100);

        $tipo_pro='Gravado';
        $valor_venta_unitario = $precio_unitario/(1+$igv_dato);
        $valor_venta = $valor_venta_unitario * $cantidad;
        $precio_venta = $precio_unitario * $cantidad;
        $ope_gravadas_total += $valor_venta;

        $valor_venta_unitario = $precio_unitario/(1+$igv_dato);
        $precio_venta = $precio_unitario * $cantidad;
        $valor_venta = $valor_venta_unitario * $cantidad;


        //Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
        $tipdes = $_SESSION['servicio_tipdes'][$unico_id][$indice];
        $descuento_linea = $_SESSION['servicio_des'][$unico_id][$indice];

        //sumatoria factura
        if($tipo_item==1){
            $sub_total = $sub_total + $linea_valor_venta_x_item;
        }
        ?>
        <tr>
            <td>Servicio</td>
            <td>Gravado</td>
            <td>&nbsp;</td>
            <td><?php echo $_SESSION['servicio_nom'][$unico_id][$indice] ?></td>
<!--            <td>--><?php //echo $dt['tb_unidad_abr'];?><!--</td>-->
            <td>ZZ</td>
            <td align="right"><?php echo $cantidad?></td>
            <td align="right"><?php echo formato_money($linea_valor_unitario)?></td>
            <td align="right"><?php echo formato_money($precio_unitario)?></td>
            <td align="right">
            </td>
            <td align="right">
            </td>
            <td align="right">
                <?php
                    echo formato_money($linea_valor_venta_x_item);
                ?>
            </td>
            <td align="right"><?php echo formato_money($precio_venta)?></td>
            <td align="center" nowrap="nowrap">
                <?php if($_POST['vista']!='cange'){?>
                    <a class="btn_item" href="#" onClick="editar_datos_item('editar_servicio','<?php echo $dt1['tb_servicio_id']?>')">Actualizar Datos de Item</a><a class="btn_quitar" href="#" onClick="venta_car_servicio('quitar_servicio','<?php echo $dt1['tb_servicio_id']?>')">Quitar</a>
                <?php }?>
            </td>
        </tr>
        <?php
        mysql_free_result($dts1);
    }
    ?>
    </tbody>
</table>
<?php
$igv_total = $ope_gravadas_total*0.18;
$importe_total=$ope_gravadas_total+$ope_exoneradas_total+$igv_total;
$descuento_global=$sub_total*($general_des/100);
$descuento_total= $descuento_global + $desc_x_item_total;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <div id="div_calcular_vuelto">
                <fieldset><legend>Aplicar a filas</legend>
                    <table><tr>
                            <td width="80"><label for="txt_ven_des">DSCTO %</label></td>
                            <td><input name="txt_ven_des" type="text" id="txt_ven_des" style="text-align:right" value="<?php echo formato_money($general_des)?>" size="10" maxlength="5" class="porcentaje_car"></td>

                    </table>
                </fieldset>
                <fieldset style="width:200px">
                    <legend>Calcular Vuelto</legend>
                    <table>
                        <tr>
                            <td align="right"><label style="font-size:12px">Paga con:</label></td>
                            <td align="right"><input type="text" name="txt_importe_cliente" id="txt_importe_cliente" size="10" style="text-align:right; font-size:14px" class="moneda2" /></td>
                        </tr>
                        <tr>
                            <td align="right"><label for="lbl_ven_vuelto" style="font-size:12px">Vuelto:</label></td>
                            <td align="right"><input type="text" name="lbl_ven_vuelto" id="lbl_ven_vuelto" readonly size="10" style="text-align:right; font-size:14px" class="moneda2" /></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
        </td>
        <td valign="top">
            <div style="margin-right:53px; margin-top:10px;">
                <table>
                    <tr>
                        <td nowrap="nowrap"><label for="txt_ven_subtot" style="font-size:12px;margin-right: 10px;"><strong>SUB TOTAL VENTAS:</strong></label></td>
                        <td align="right"><input name="txt_ven_subtot" type="text" id="txt_ven_subtot" style="text-align:right; font-size:14px" value="<?php echo formato_money($sub_total)?>" size="15" readonly></td>
                    </tr>
                    <tr>
                        <td><label for="txt_ven_desglob" style="font-size:12px"><strong>DESCUENTO GLOBAL:</strong></label></td>
                        <td align="right"><input name="txt_ven_desglob" type="text" id="txt_ven_desglob" style="text-align:right; font-size:14px;" value="<?php echo formato_money($descuento_global)?>" size="15" readonly></td>
                    </tr>
                    <tr>
                        <td><label for="txt_com_destotal" style="font-size:12px"><strong>TOTAL DESCUENTOS</strong></label></td>
                        <td align="right"><input name="txt_com_destotal" type="text" id="txt_com_destotal" style="text-align:right; font-size:14px;" value="<?php echo formato_money($descuento_total)?>" size="15" readonly></td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap"><strong>OPERACIONES GRATUITAS:</strong></td>
                        <td align="right"><input name="txt_ven_opegra" type="text" id="txt_ven_opegra" style="text-align:right; font-size:14px" value="<?php echo formato_money($ope_gratuitas_total)?>" size="15" readonly>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td valign="top">
            <div style="margin-right:53px; margin-top:10px;">
                <table border="0" align="right" cellpadding="0" cellspacing="0">

                    <tr>
                        <td width="120"><label for="txt_ven_valven" style="font-size:12px"><strong>VALOR VENTA:</strong></label></td>
                        <td width="140" align="right">
                            <input name="txt_ven_valven" type="text" id="txt_ven_valven" style="text-align:right; font-size:14px" value="<?php echo formato_money($ope_gravadas_total)?>" size="15" readonly></td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap"><strong>OPERACIONES EXONERADAS:</strong></td>
                        <td align="right"><input name="txt_ven_opeexo" type="text" id="txt_ven_opeexo" style="text-align:right; font-size:14px" value="<?php echo formato_money($ope_exoneradas_total)?>" size="15" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="txt_ven_igv" style="font-size:12px"><strong>IGV (18%):</strong></label>
                        </td>
                        <td align="right"><input name="txt_ven_igv" type="text" id="txt_ven_igv" style="text-align:right; font-size:14px" value="<?php echo formato_money($igv_total)?>" size="15" readonly></td>
                    </tr>
                    <?php /*?>
		  <tr>
		    <td><label for="txt_ven_otrcar" style="font-size:12px"><strong>OTROS CARGOS:</strong></label></td>
		    <td align="right"><input name="txt_ven_otrcar" type="text" id="txt_ven_otrcar" style="text-align:right; font-size:14px" value="<?php echo formato_money($otr_car)?>" size="15" readonly></td>
		  </tr>
		  <tr>
		    <td><label for="txt_ven_otrtri" style="font-size:12px"><strong>OTROS TRIBUTOS:</strong></label></td>
		    <td align="right"><input name="txt_ven_otrtri" type="text" id="txt_ven_otrtri" style="text-align:right; font-size:14px" value="<?php echo formato_money($otr_tri)?>" size="15" readonly></td>
		  </tr><?php */?>
                    <tr>
                        <td><label for="txt_ven_tot" style="font-size:12px"><strong>IMPORTE TOTAL:</strong></label></td>
                        <td align="right"><input name="txt_ven_tot" type="text" id="txt_ven_tot" style="text-align:right; font-size:14px; font-weight:bold;" value="<?php echo formato_money($importe_total)?>" size="13" readonly></td>

                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
<script type="text/javascript">
    $(function() {
        //lenar monto de pagos
        var total= $('#txt_ven_tot').autoNumericGet();
        $('#txt_venpag_mon').autoNumericSet(total);
        $('#txt_venpag_mon').change();
    });
</script>