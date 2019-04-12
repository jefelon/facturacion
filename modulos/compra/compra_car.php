<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../formatos/formato.php");
require_once ("../servicio/cServicio.php");
$oServicio = new cServicio();

$igv_dato=0.18;

if($_POST['com_tipper']==1)$percepcion_dato=0.02;
if($_POST['com_tipper']==0)$percepcion_dato=0;

$unico_id=$_POST['unico_id'];

//agregar a cesta
if($_POST['action']=='agregar')
{
	if($_POST['cat_can']>0)
	{
		//producto por catalogo y stock y almacen
		$dts= $oCatalogoproducto->presentacion_catalogo($_POST['cat_id']);
		$dt = mysql_fetch_array($dts);
			$pro_nom=$dt['tb_producto_nom'];
			$pre_nom=$dt['tb_presentacion_nom'];
			$pre_id	=$dt['tb_presentacion_id'];
			$sto_num=$dt['tb_stock_num'];
			$cat_mul=$dt['tb_catalogo_mul'];
			$nombre_producto=$pro_nom.' '.$pre_nom;
		mysql_free_result($dts);
		
		//verificar si el producto se encuentra en el carrito de compra, con otra presentacion
		$num=0;
		if(isset($_SESSION['compra_car']))
		{
			foreach($_SESSION['compra_car'] as $indice=>$linea_cantidad){
				if(($_POST['cat_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$indice]))
				{
					$num++;
				}
			}
		}
		
		if($num==0 or $num==1)
		{
			//IDENTIFICADOR CATALOGO Y CANTIDAD			
			$_SESSION['compra_car'][$_POST['cat_id']]=moneda_mysql($_POST['cat_can']);

			//$_SESSION['compra_igv'][$_POST['cat_id']]=$_POST['cat_igv'];
			
			//DESCUENTO 0.00 - 99.99
			$_SESSION['compra_linea_des'][$_POST['cat_id']]=$_POST['cat_des'];
			if($_POST['cat_des']=="")$_SESSION['compra_linea_des'][$_POST['cat_id']]=0;
			
			//FLETE
			$_SESSION['compra_linea_fle'][$_POST['cat_id']]=moneda_mysql($_POST['cat_fle']);
			if($_POST['cat_fle']=="")$_SESSION['compra_linea_fle'][$_POST['cat_id']]=0;
			
			//-------------------------PRECIO----------------------------------------
			//PRECIO DE COMPRA INGRESADO
			$_SESSION['compra_linea_precom'][$_POST['cat_id']]=moneda_mysql($_POST['cat_precom']);


			
			//TIPO DE PRECIO: VALOR VENTA=1 PRECIO VENTA=2
			$_SESSION['compra_linea_tippre'][$_POST['cat_id']]=$_POST['tipo_precio'];


            //TIPO BONIFICACIón
            $_SESSION['compra_linea_tip_bon'][$_POST['cat_id']]=$_POST['cmb_afec_id'];


			//PRECIO UNITRIO DE COMPRA SIN IGV
			if($_POST['tipo_precio']==1)
			{
				$precio_unitario=moneda_mysql($_POST['cat_precom']);
			}
			
			if($_POST['tipo_precio']==2)
			{
				$precio_unitario=moneda_mysql($_POST['cat_precom'])/(1+$igv_dato);
			}


			//PRECIO UNITARIO
			$_SESSION['compra_linea_preuni'][$_POST['cat_id']]=$precio_unitario;
			//-----------------------------------------------------------------------
			
			//PRESENTACION para verificar si ingresa otra unidad de la misma presentacion
			$_SESSION['presentacion_id'][$_POST['cat_id']]=$pre_id;
		}
		
		if($num>1)
		{
			$msj='No se permite agregar más de 2 unidades de una sola presentación de producto.';
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
if($_POST['action']=='quitar')
{
	unset($_SESSION['compra_car'][$_POST['cat_id']]);
	//unset($_SESSION['compra_igv'][$_POST['cat_id']]);
	unset($_SESSION['compra_linea_precom'][$_POST['cat_id']]);
	unset($_SESSION['compra_linea_tippre'][$_POST['cat_id']]);
    unset($_SESSION['compra_linea_tip_bon'][$_POST['cat_id']]);
	unset($_SESSION['compra_linea_preuni'][$_POST['cat_id']]);
	unset($_SESSION['compra_linea_des'][$_POST['cat_id']]);
	unset($_SESSION['compra_linea_fle'][$_POST['cat_id']]);
	unset($_SESSION['compra_linea_per'][$_POST['cat_id']]);
	unset($_SESSION['compra_linea_cos'][$_POST['cat_id']]);
	unset($_SESSION['presentacion_id'][$_POST['cat_id']]);
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
	unset($_SESSION['compra_car']);
	//unset($_SESSION['compra_igv']);
	unset($_SESSION['compra_linea_precom']);
	unset($_SESSION['compra_linea_tippre']);
    unset($_SESSION['compra_linea_tip_bon']);
	unset($_SESSION['compra_linea_preuni']);
	unset($_SESSION['compra_linea_des']);
	unset($_SESSION['compra_linea_fle']);
	unset($_SESSION['compra_linea_per']);
	unset($_SESSION['compra_linea_cos']);
	unset($_SESSION['presentacion_id']);
	
	unset($_SESSION['compra_general_des']);
	unset($_SESSION['compra_general_fle']);
	unset($_SESSION['compra_general_tipfle']);
	
	unset($_SESSION['compra_ajupos']);
	unset($_SESSION['compra_ajuneg']);

    unset($_SESSION['servicio_car']);
    unset($_SESSION['servicio_preven']);
    unset($_SESSION['servicio_tipdes']);
    unset($_SESSION['servicio_des']);
    unset($_SESSION['servicio_tip']);
}

if(isset($_SESSION['compra_car']) or isset($_SESSION['servicio_car'][$unico_id]))
{
    if(isset($_SESSION['compra_car'])){
        $num_rows=count($_SESSION['compra_car']);
        //total de las cantidades
        foreach($_SESSION['compra_car'] as $indice=>$linea_cantidad){
            $total_cantidad+=$linea_cantidad;
        }
    }else{
        $num_rows=0;
    }
    if(isset($_SESSION['servicio_car'])){
        $num_rows2=count($_SESSION['servicio_car']);
    }else{
        $num_rows2=0;
    }


    $filas=$num_rows+$num_rows2;
}
else
{
    $filas="";
}
?>
<script type="text/javascript">
$('.moneda2').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.0000',
	vMax: '9999.9999'
});
$('.porcentaje_car').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.0000',
	vMax: '99.9999'
});
$('.btn_rest_car').button({
	icons: {
		//primary: "ui-icon-cart"//,
		secondary: "ui-icon-cart"
	},
	text: true
});
$('.btn_rest_act').button({
	icons: {
		//primary: "ui-icon-cart"//,
		secondary: "ui-icon-refresh"
	},
	text: false
});

$('.btn_agregar_producto').button({
	icons: {
		primary:  "ui-icon-plus"
	},
	text: true
});

$('.btn_quitar').button({
	icons: {primary: "ui-icon-minus"},
	text: false
});
	
$('.btn_item').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});
$(".btn_preven").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('.btn_tabla_lote').button({
    icons: {primary: "ui-icon-newwin"},
    text: false
});

$(function() {
    $('#hdd_cant_filas').val($('#tabla_compra_car>tbody>tr').length);
	/*if($('#hdd_com_numite').val()>0)
	{
		$('#cmb_com_mon').attr('disabled', 'disabled');
	}
	else
	{
		$('#cmb_com_mon').removeAttr('disabled', 'disabled');
	}*/
	
	$("#tabla_compra_car").tablesorter({
		widgets : ['zebra'],
		//headers: {
			//0: {sorter: false },
			//8: {sorter: false }
			//},
		//sortForce: [[0,0]],	
		//sortList: [[2,0]]
    });
	
	$('#txt_com_des').change(function(e) {
        compra_car_prorrateo()
    });
	$('#txt_com_fle').change(function(e) {
        compra_car_prorrateo()
    });
	$('#cmb_com_tipfle').change(function(e) {
        compra_car_prorrateo()
    });
	
	$("#txt_com_ajupos" ).change(function(e) {
			compra_car_prorrateo()
	});
	
	$("#txt_com_ajuneg" ).change(function(e) {
			compra_car_prorrateo()
	});

});

// function cambiar_costo_unitario(cost_uni,n) {
//     $("#cost_uni"+n).html(cost_uni);
// }
</script>
<input name="hdd_com_numite" id="hdd_com_numite" type="hidden" value="<?php echo $filas?>">
<fieldset><legend>Detalle de Compra</legend>
<a class="btn_agregar_producto" title="Agregar Producto" href="#" onClick="catalogo_compra_tab()">Agregar</a>
<!--    <a class="btn_agregar_producto" title="Agregar Producto y/o Servicio (A+P)" href="#" onClick="catalogo_compra_tab()">Agregar</a>-->
<a class="btn_rest_car" href="#" onClick="compra_car('restablecer')">Vaciar</a>
<a class="btn_rest_act" href="#" onClick="compra_car('actualizar')">Actualizar</a>

<div id="msj_compra_car" class="ui-state-error ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php if($msj!=""){echo 'block';} else{ echo 'none';}?>"><?php echo $msj?></div>

<div id="msj_compra_car_item" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>

<div style="width:auto; float:right;">
<?php 
	if($filas=="" or $filas==0)echo 'Ningún ítem agregado.';
	if($filas==1)echo $filas.' ítem agregado.';
	if($filas>=2)echo $filas.' ítems agregados.';
?>
</div>
</fieldset>
        <table cellspacing="1" id="tabla_compra_car" class="tablesorter">
            <thead>
                <tr>
                    <th align="right" title="CANTIDAD">CANT</th>
                    <th title="UNIDAD">UNID</th>
                  	<th>CODIGO</th>
                    <th>PRODUCTO</th>
                    <!--<th>PRESENTACION</th>-->
                    <th align="right" title="PRECIO UNITARIO">VALOR UNIT</th>
                    <th align="right" title="PRECIO EXONERADO">P. EXO S/.</th>
                    <th align="right" title="COSTO UNITARIO EN SOLES">COSTO UN S/.</th>
                    <th align="right" title="DESCUENTO %">DSCTO %</th>
                    <th align="right" title="DESCUENTOS VALOR">VALOR COMPRA</th>
                    <!--<th align="right">IGV</th>-->
                    <th align="right">FLETE</th>
                    <th align="right">IMPORTE</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
<?php
if($num_rows>0){
?>
            <tbody>
            <?php
            $total_opegrav = 0;
            $total_opeexo = 0;

            $cont_prod=0;
			foreach($_SESSION['compra_car'] as $indice=>$linea_cantidad){
				
				//consulta de datos			
				$dts1=$oCatalogoproducto->presentacion_catalogo($indice);
				$dt1 = mysql_fetch_array($dts1);

                $tipo_item	=$_SESSION['compra_linea_tip_bon'][$indice];
				
				//tipo de cambio
				$mul_tipo_cambio=$_POST['tipo_cambio'];
				
				//precio unitario
				$linea_preuni=$_SESSION['compra_linea_preuni'][$indice];
				//descuento
				$linea_des=$_SESSION['compra_linea_des'][$indice];
				//flete
				$linea_fle=$_SESSION['compra_linea_fle'][$indice];
				if($linea_fle=="")$linea_fle=0;
				
				//descuento para prorrateo
				if($_SESSION['compra_general_des']=="")
				{
					$general_des=0;
				}
				else
				{
					$general_des=moneda_mysql($_SESSION['compra_general_des']);
				}
				
				//flete para prorrateo
				if($_SESSION['compra_general_fle']=="")
				{
					$general_fle=0;
				}
				else
				{
					//con igv - afecta a compra
					if($_SESSION['compra_general_tipfle']==1 or $_SESSION['compra_general_tipfle']==3)
					{
						$general_fle=moneda_mysql($_SESSION['compra_general_fle']);
						$general_fle_uni=formato_moneda($general_fle/(1+$igv_dato));
					}
					
					//sin igv - afecta a compra
					if($_SESSION['compra_general_tipfle']==2 or $_SESSION['compra_general_tipfle']==4)
					{
						$general_fle=moneda_mysql($_SESSION['compra_general_fle'])*(1+$igv_dato);
						$general_fle_uni=moneda_mysql($_SESSION['compra_general_fle']);
					}
					
				}
				
				
				//descuento por linea
				$linea_calculo_des=1-($linea_des)/100;
				
				//importe por linea
				$linea_importe=$linea_preuni*$linea_cantidad;
			
				//igv por linea
				$linea_igv=$linea_importe*$igv_dato;

				
				//flete por linea
				$linea_calculo_fle=$linea_fle/$linea_cantidad;
				
				
				//flete prorrateo
				$linea_prorrateo_fle=($general_fle/$total_cantidad);
				
				//percepcion por linea
				$linea_percepcion=($linea_importe + $linea_igv)*$percepcion_dato;
				$_SESSION['compra_linea_per'][$indice] = $linea_percepcion;
				
				
				//COSTO
				//calculo de descuento para costo con prorrateo

                $linea_prorrateo_des=(1-$linea_des/100)*(1-$general_des/100);



				//calculo de importe PARA COSTO multiplicado por el tipo de cambio para soles
				//(se necesita dato en soles)
				$linea_calculo_importe=($linea_preuni*$linea_cantidad*$linea_prorrateo_des)*$mul_tipo_cambio;
				//$linea_calculo_importe=($linea_preuni*$linea_cantidad*$linea_prorrateo_des);
				
				//calculo igv para costo
				$linea_calculo_igv=$linea_calculo_importe*$igv_dato;
				
				//
				//CALCULO DE PRECEPCION
				//monto total de percepcion
				$linea_percepcion_soles=($linea_calculo_importe + $linea_calculo_igv)*$percepcion_dato;
				//percepción por linea
				$linea_calculo_percepcion=$linea_percepcion_soles/$linea_cantidad;
				
				//COSTO
				$linea_calculo_cos = ($linea_calculo_importe + $linea_calculo_igv)/$linea_cantidad + $linea_calculo_fle + $linea_prorrateo_fle+$linea_calculo_percepcion;

                $_SESSION['compra_linea_cos'][$indice] = $linea_calculo_cos;

				if($tipo_item==9){
                    $linea_preuni=$linea_preuni*1.18;
                    $valor_venta = $linea_preuni*$linea_cantidad;
                    $total_opeexo = $total_opeexo+$valor_venta-($valor_venta*($general_des/100));
                }elseif ($tipo_item==6){
                    $valor_venta = $linea_preuni*$linea_cantidad;
                }elseif ($tipo_item==1){
                        $valor_venta = $linea_preuni*$linea_cantidad;
                        $total_opegrav =$total_opegrav+$valor_venta-($valor_venta*($general_des/100));
                }


				//ajustes
				$ajuste_positivo=$_SESSION['compra_ajupos'];
				$ajuste_negativo=$_SESSION['compra_ajuneg'];
				//flete incluido
				if($_SESSION['compra_general_tipfle']==3 or $_SESSION['compra_general_tipfle']==4)
				{
					$incluir_flete=$general_fle_uni;
				}

				$total_igv			=formato_moneda($total_opegrav*$igv_dato);
				
				$total_percepcion+=$linea_percepcion;


				$valor_venta_bruto = $valor_venta;
                $desc_x_item=$valor_venta-$valor_venta*$linea_calculo_des;

                $valor_venta_x_item = $valor_venta * $linea_calculo_des;
                if(!$tipo_item==6) {
                    $valor_venta_x_item_total += $valor_venta_x_item;
                }
                $desc_x_item_total+=$desc_x_item;


                if($tipo_item==9) {
                    $igv_linea=0;
                    $total_operaciones_exoneradas += $valor_venta_x_item;

                }elseif ($tipo_item==1){
                    if($_POST['cmb_com_doc']=='19'){
                        $igv_linea=0;
                        $total_operaciones_gravadas += $valor_venta_x_item;
                    }else{
                        $igv_linea = ($valor_venta * $linea_calculo_des) * 0.18;
                        $total_operaciones_gravadas += $valor_venta_x_item;
                    }
                }
                $linea_importe= $linea_calculo_cos * $linea_cantidad;

                $total_igv_grav+=$igv_linea;


				?>
                        <tr>
                          	<!--<td><a class="btn_preven" href="#" onClick="precioventa_form('<?php //echo $dt1['tb_presentacion_id']?>','<?php //echo $dt1['tb_producto_nom']?>')">Actualizar Precios de Venta</a></td>-->

                            <td align="right"><?php echo $linea_cantidad?></td>
                            <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                          	<td><?php echo $dt1['tb_presentacion_cod']?></td>
                            <td><?php echo $dt1['tb_producto_nom']?></td>
                            <!--<td><?php //echo $dt1['tb_presentacion_nom']?></td>-->

                            <td align="right"><?php echo formato_decimal($linea_preuni,3)?></td>

                            <?php if ($tipo_item==9){ ?>
                                <td align="right" id="cost_uni<?php echo $cont_prod ?>"><?php echo formato_decimal($linea_calculo_cos, 3)?></td>
                                <td align="right"></td>
                            <?php } else{ ?>
                                <td align="right"></td>
                                <td align="right" id="cost_uni<?php echo $cont_prod ?>"><?php echo formato_decimal($linea_calculo_cos, 3)?></td>
                            <?php } ?>
                            <td align="right"><?php echo formato_decimal($linea_des, 3)?></td>
                            <td align="right"><?php echo formato_decimal($valor_venta_x_item, 3)?></td>

                            <!--<td align="right"><?php //echo formato_money($linea_igv)?></td>-->
                            <td align="right"><?php echo formato_decimal($linea_fle, 3)?></td>
                            <td align="right"><?php echo formato_decimal($linea_importe, 3)?></td>

                            <?php /*?><td align="right"><?php echo $linea_prorrateo_des.'|'.$linea_calculo_importe.'|'.$linea_calculo_igv.'|'.$linea_calculo_fle?></td><?php */?>
                            <td align="center" nowrap="nowrap">
                                <a class="btn_item" href="#" onClick="editar_datos_item('<?php echo $dt1['tb_catalogo_id']?>','<?php echo $dt1['tb_producto_nom']?>')">Actualizar Datos de Item</a>
                                <a class="btn_quitar" href="#" onClick="compra_car('quitar','<?php echo $dt1['tb_catalogo_id']?>')">Quitar</a>
                                <a class="btn_tabla_lote" onClick="lote_car('',<?php echo $dt1['tb_catalogo_id'] ?>,<?php echo $linea_cantidad?>)">Ver Lote</a>
                            </td>
                        </tr>
            <?php
                mysql_free_result($dts1);
                $cont_prod++;
			}	
            ?>
<?php
}
else
{
?>

<?php
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
        <td align="right"><?php echo $cantidad?></td>
        <td>ZZ</td>
        <td>Servicio Gravado</td>
        <td><?php echo $_SESSION['servicio_nom'][$unico_id][$indice] ?></td>
        <!--            <td>--><?php //echo $dt['tb_unidad_abr'];?><!--</td>-->
        <td align="right"><?php echo formato_decimal($linea_valor_unitario,3)?></td>
        <td></td>
        <td align="right"><?php echo formato_decimal($precio_unitario,3)?></td>
        <td align="right">
            0.000
        </td>
        <td align="right">
            <?php
            echo formato_decimal($linea_valor_venta_x_item,3);
            ?>
        </td>
        <td align="right">
            0.000
        </td>
        <td align="right"><?php echo formato_decimal($precio_venta,3)?></td>
        <td align="center" nowrap="nowrap">
            <?php if($_POST['vista']!='cange'){?>
                <a class="btn_item" href="#" onClick="editar_datos_item('editar_servicio','<?php echo $dt1['tb_servicio_id']?>')">Actualizar Datos de Item</a><a class="btn_quitar" href="#" onClick="compra_car_servicio('quitar_servicio','<?php echo $dt1['tb_servicio_id']?>')">Quitar</a>
            <?php }?>
        </td>
    </tr>
    <?php
    mysql_free_result($dts1);
}
?>
            <tr>
                <td colspan="12">&nbsp;</td>
                <!--<td>&nbsp;</td>-->
            </tr>
</tbody>
</table>

<?php

$igv_total = $ope_gravadas_total*0.18;
$importe_total=$ope_gravadas_total+$ope_exoneradas_total+$igv_total;

$total_operaciones_exoneradas = $total_operaciones_exoneradas-$total_operaciones_exoneradas*($general_des/100);
$total_operaciones_gravadas=$total_operaciones_gravadas-$total_operaciones_gravadas*($general_des/100) + $ajuste_positivo-$ajuste_negativo;
$total_operaciones_gravadas_productos=$total_operaciones_gravadas;
if($_POST['cmb_com_doc']=='19'){
    $igv_total_gravados=0;
}else{
    $igv_total_gravados=$total_operaciones_gravadas*18/100;
}


$importe_total_venta = $total_operaciones_exoneradas + $total_operaciones_gravadas + $igv_total_gravados;
$descuento_global = $valor_venta_x_item_total*($general_des/100);
$descuento_total=$descuento_global+$desc_x_item_total;

//servicios + productos
$total_operaciones_gravadas+=$ope_gravadas_total;
$importe_total_venta += $importe_total;
$igv_total_gravados += $igv_total;

$total_operaciones_gravadas_productos = $total_operaciones_gravadas_productos * 1.18;
$cont=0;
foreach($_SESSION['compra_car'] as $indice=>$linea_cantidad) {
    $linea_preuni = $_SESSION['compra_linea_preuni'][$indice];
    $linea_importe = ($linea_preuni * $linea_cantidad) * 1.18;
    $factor = $linea_importe / $total_operaciones_gravadas_productos;

    $costo = 0;
    if ($num_rows2 > 0) foreach ($_SESSION['servicio_car'][$unico_id] as $indice2 => $cantidad) {
        $precio_unitario = $_SESSION['servicio_preven'][$unico_id][$indice2];
        $linea_importe_servicio = $precio_unitario * $cantidad;
        $costo += $linea_importe_servicio * $factor;
    }
    $imp_dols = $_POST['imp_dol'];
    foreach ($imp_dols as $imp_dol) {
        $costo += $imp_dol * $factor;
    }
    $costo_total=$costo+$linea_importe;
    $costo_unitario=$costo_total/$linea_cantidad;
    ?>
    <script>
        //cambiar_costo_unitario(<?php //echo  formato_decimal($costo_unitario,3);?>//, <?php //echo  $cont;?>//);
    </script>
    <?php
    $cont++;
}


?>
<div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <fieldset><legend>Aplicar a filas</legend>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="80"><label for="txt_com_des">DSCTO %</label></td>
        <td><input name="txt_com_des" type="text" id="txt_com_des" style="text-align:right" value="<?php echo formato_decimal($general_des, 3)?>" size="10" maxlength="5" class="porcentaje_car"></td>
      </tr>
      <tr>
        <td><label for="txt_com_fle">FLETE S/.</label></td>
        <td nowrap="nowrap"><input name="txt_com_fle" type="text" id="txt_com_fle" style="text-align:right" value="<?php echo formato_decimal($_SESSION['compra_general_fle'], 3)?>" size="10" maxlength="8" class="moneda2">
          <label for="cmb_com_tipfle"></label>
          <select name="cmb_com_tipfle" id="cmb_com_tipfle">
            <option value="1"<?php if($_SESSION['compra_general_tipfle']==1)echo 'selected'?>>Con IGV</option>
            <option value="2"<?php if($_SESSION['compra_general_tipfle']==2)echo 'selected'?>>Sin IGV</option>
            <option value="3"<?php if($_SESSION['compra_general_tipfle']==3)echo 'selected'?>>Con IGV afecta Compra</option>
            <option value="4"<?php if($_SESSION['compra_general_tipfle']==4)echo 'selected'?>>Sin IGV afecta Compra</option>
          </select>
		</td>
      </tr>
    </table>
    </fieldset>
    </td>
    <td valign="top">
    <div style="margin-left:20px; float:right">
    <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td width="110"><label for="txt_com_subtot">SUB TOTAL</label></td>
        <td width="190"><input name="txt_com_subtot" type="text" id="txt_com_subtot" value="<?php echo formato_decimal($valor_venta_x_item_total,3)?>" readonly style="text-align:right"></td>
      </tr>
      <tr>
        <td><label for="txt_com_descal">DESCUENTO GLOBAL</label></td>
        <td><input type="text" name="txt_com_descal" id="txt_com_descal" value="<?php echo formato_decimal($descuento_global, 3)?>" readonly style="text-align:right"></td>
      </tr>
        <tr>
            <td><label for="txt_com_destotal">TOTAL DESCUENTOS</label></td>
            <td><input type="text" name="txt_com_destotal" id="txt_com_destotal" value="<?php echo formato_decimal($descuento_total,3)?>" readonly style="text-align:right"></td>
        </tr>
      <tr>
        <td title="AJUSTE APLICADO AL VALOR VENTA">AJUSTE*</td>
        <td>
        <label for="txt_com_ajupos">+</label><input name="txt_com_ajupos" type="text" id="txt_com_ajupos" style="text-align:right" value="<?php echo $_SESSION['compra_ajupos']?>" size="6" maxlength="6" class="moneda2">
|        
<label for="txt_com_ajuneg">-</label><input name="txt_com_ajuneg" type="text" id="txt_com_ajuneg" style="text-align:right" value="<?php echo $_SESSION['compra_ajuneg']?>" size="6" maxlength="6" class="moneda2">
        </td>
      </tr>
    </table>
    </div>
    </td>
    <td valign="top">
    	<div style="margin-right:50px; float:right">
<table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td width="110">VALOR VENTA</td>
    <td width="140" align="right"><input type="text" name="txt_com_valven" id="txt_com_valven" value="<?php echo formato_decimal($total_operaciones_gravadas, 3)?>" readonly style="text-align:right"></td>
  </tr>
  <tr>
    <td><label for="txt_com_igv">IGV</label></td>
    <td align="right"><input type="text" name="txt_com_igv" id="txt_com_igv" value="<?php echo formato_decimal($igv_total_gravados,3)?>" readonly style="text-align:right"></td>
  </tr>
    <tr>
        <td width="110">OPE. EXO.</td>
        <td width="140" align="right"><input type="text" name="txt_com_opexo" id="txt_com_opexo" value="<?php echo formato_decimal($total_operaciones_exoneradas,3)?>" readonly style="text-align:right"></td>
    </tr>
  <tr>
  <?php if($_POST['com_tipper']==1){?>
    <td><label for="txt_com_per">PERCEPCION(2%)</label></td>
    <td align="right"><input type="text" name="txt_com_per" id="txt_com_per" value="<?php echo formato_decimal($total_percepcion, 3)?>" readonly style="text-align:right"></td>
  </tr>
  <?php }?>
  <tr>
    <td><label for="txt_com_tot"><strong>TOTAL</strong></label></td>
    <td align="right"><input type="text" name="txt_com_tot" id="txt_com_tot" value="<?php echo formato_decimal($importe_total_venta, 3)?>" readonly style="text-align:right"></td>
  </tr>
    <input type="hidden" name="hdd_cant_filas" id="hdd_cant_filas" value="<?php echo $num_rows ?>">
</table>
</div>
    </td>
  </tr>
</table>
</div>

