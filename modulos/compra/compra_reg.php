<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}

function responder($estado=false, $mensaje='', $datos=[])
{
	header('Content-Type: application/json');
	echo json_encode([
		'est' => $estado,
		'msj' => $mensaje,
		'dat' => $datos,
	]);
	exit;
}
// Valida sesion
if( $_POST['hdd_usu_id']!==$_SESSION['usuario_id'] ||
	$_POST['hdd_punven_id']!==$_SESSION['puntoventa_id'] ||
	$_POST['hdd_emp_id']!==$_SESSION['empresa_id'])
{
	echo json_encode(['redireccionar'=>true]);
	exit();
}

require_once ("../../config/Cado.php");
require_once("cCompra.php");
$oCompra = new cCompra();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../producto/cStock.php");
$oStock = new cStock();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once("../formatos/formato.php");
require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();
require_once ("../lote/cLote.php");
$oLote = new cLote();
require_once ("../lote/cCompraDetalleLote.php");
$oCompraDetalleLote = new cCompraDetalleLote();


$igv_dato=0.18;

$unico_id=$_POST['unico_id'];

if ($_POST['action_compra'] == "insertar") {
    if (!empty($_POST['txt_com_fec'])) {
        //documento
        $dts = $oDocumento->mostrarUno($_POST['cmb_com_doc']);
        $dt = mysql_fetch_array($dts);
        $documento = $dt['tb_documento_abr'];
        $documento_ele = $dt['tb_documento_ele'];
        $documento_tipdoc = $dt['cs_tipodocumento_id'];
        $documento_cod = $dt['cs_tipodocumento_cod'];
        mysql_free_result($dts);
        //$estado='CONTADO';

        if ($_POST['cmb_com_doc'] == '20' || $_POST['cmb_com_doc'] == '21') {
            if ($_POST['cmb_com_tip'] == '1'){
                $dts = $oCompra->verificar_compra($_POST['txt_com_ser_nota'].'-'.$_POST['txt_com_num_nota']);
                $dt = mysql_fetch_array($dts);
                $com_id = $dt['tb_compra_id'];
                $fec_mod = $dt['tb_compra_fec'];
                mysql_free_result($dts);
            }else{
                $com_id=1;
            }
        }else{
            $com_id=1;
        }

        if ($com_id > 0) {
            //insertamos compra
            if ($_POST['cmb_com_doc']==19) {
                 $tipo_renta=$_POST['cmb_tiporenta_id'];
            }
            $oCompra->insertar(
                fecha_mysql($_POST['txt_com_fec']),
                fecha_mysql($_POST['txt_com_fecven']),
                $_POST['cmb_com_doc'],
                $_POST['txt_com_numdoc'],
                $_POST['cmb_com_mon'],
                $_POST['txt_com_tipcam'],
                $_POST['txt_com_tipcam'],
                $_POST['hdd_com_pro_id'],
                moneda_mysql($_POST['txt_com_subtot']),
                moneda_mysql($_POST['txt_com_des']),
                moneda_mysql($_POST['txt_com_descal']),
                moneda_mysql($_POST['txt_com_fle']),
                $_POST['cmb_com_tipfle'],
                moneda_mysql($_POST['txt_com_ajupos']),
                moneda_mysql($_POST['txt_com_ajuneg']),
                moneda_mysql($_POST['txt_com_valven']),
                moneda_mysql($_POST['txt_com_opexo']),
                moneda_mysql($_POST['txt_com_valven']),
                moneda_mysql($_POST['txt_com_igv']),
                moneda_mysql($_POST['txt_com_tot']),
                $_POST['chk_com_tipper'],
                moneda_mysql($_POST['txt_com_per']),
                $_POST['cmb_com_alm_id'],
                $_POST['cmb_com_est'],
                $_POST['hdd_usu_id'],
                $_POST['hdd_emp_id'],
                $_POST['txt_com_numorden'],
                $documento_tipdoc,
                $fec_mod,
                $_POST['txt_com_ser_nota'],
                $_POST['txt_com_num_nota'],
                $_POST['cmb_com_tip'],
                $_POST['cmb_tiporenta_id'],
                $tipo_renta
            );
            //ultima compra
            $dts = $oCompra->ultimoInsert();
            $dt = mysql_fetch_array($dts);
            $com_id = $dt['last_insert_id()'];
            mysql_free_result($dts);


            if ($_POST['cmb_com_doc']==19){
                $_POST['dua'];
                $duas = $_POST['dua'];
                $cont = 0;
                foreach ($duas as $dua) {
                    if(in_array($cont, $_POST['chk_invoice'])){
                    $oCompra->insertar(
                        fecha_mysql($_POST['fec_ser'][$cont]),
                        fecha_mysql($_POST['txt_com_fecven']),
                        1,// tipo documento factura 1 invoice 19
                        $dua,
                        $_POST['cmb_com_mon'],
                        $_POST['txt_com_tipcam'],
                        $_POST['txt_com_tipcam'],
                        $_POST['proveedor'][$cont],
                        moneda_mysql(0),
                        moneda_mysql(0),
                        moneda_mysql(0),
                        moneda_mysql(0),
                        $_POST['cmb_com_tipfle'],
                        moneda_mysql(0),
                        moneda_mysql(0),
                        moneda_mysql($_POST['imp_sol'][$cont] / 1.18),
                        moneda_mysql($_POST['txt_com_opexo']),
                        moneda_mysql($_POST['imp_sol'][$cont] / 1.18),
                        moneda_mysql($_POST['txt_com_igv']),
                        moneda_mysql($_POST['imp_sol'][$cont]),
                        $_POST['chk_com_tipper'],
                        moneda_mysql($_POST['txt_com_per']),
                        $_POST['cmb_com_alm_id'],
                        $_POST['cmb_com_est'],
                        $_POST['hdd_usu_id'],
                        $_POST['hdd_emp_id'],
                        $_POST['txt_com_numorden'],
                        $documento_tipdoc,
                        $fec_mod,
                        $_POST['txt_com_ser_nota'],
                        $_POST['txt_com_num_nota'],
                        $_POST['cmb_com_tip']
                    );
                    //ultima compra
                    $dts = $oCompra->ultimoInsert();
                    $dt = mysql_fetch_array($dts);
                    $comcosto_id = $dt['last_insert_id()'];


                    $oCompra->insertar_detalle(
                        0,
                        1,
                        $dua / 1.18,
                        0,
                        $dua,
                        1,
                        $dua * 0.18,
                        0,
                        0,
                        $dua,
                        $comcosto_id,
                        $_POST['servicio'][$cont]
                    );

                    $oCompra->insertar_compra_costo($com_id, $comcosto_id);
                    }
                    $cont++;
                }
            }


            if ($_POST['cmb_com_doc']==23){
                $_POST['dua'];
                $duas = $_POST['dua'];
                $cont = 0;
                foreach ($duas as $dua) {
                    if(in_array($cont, $_POST['chk_invoice'])){
                        $oCompra->insertar(
                            fecha_mysql($_POST['fec_ser'][$cont]),
                            fecha_mysql($_POST['txt_com_fecven']),
                            1,// tipo documento factura 1 invoice 19
                            $dua,
                            $_POST['cmb_com_mon'],
                            $_POST['txt_com_tipcam'],
                            $_POST['txt_com_tipcam'],
                            $_POST['proveedor'][$cont],
                            moneda_mysql(0),
                            moneda_mysql(0),
                            moneda_mysql(0),
                            moneda_mysql(0),
                            $_POST['cmb_com_tipfle'],
                            moneda_mysql(0),
                            moneda_mysql(0),
                            moneda_mysql($_POST['imp_sol'][$cont]),
                            moneda_mysql($_POST['txt_com_opexo']),
                            moneda_mysql($_POST['imp_sol'][$cont]),
                            moneda_mysql(0.00),
                            moneda_mysql($_POST['imp_sol'][$cont]),
                            $_POST['chk_com_tipper'],
                            moneda_mysql($_POST['txt_com_per']),
                            $_POST['cmb_com_alm_id'],
                            $_POST['cmb_com_est'],
                            $_POST['hdd_usu_id'],
                            $_POST['hdd_emp_id'],
                            $_POST['txt_com_numorden'],
                            $documento_tipdoc,
                            $fec_mod,
                            $_POST['txt_com_ser_nota'],
                            $_POST['txt_com_num_nota'],
                            $_POST['cmb_com_tip']
                        );
                        //ultima compra
                        $dts = $oCompra->ultimoInsert();
                        $dt = mysql_fetch_array($dts);
                        $comcosto_id = $dt['last_insert_id()'];


                        $oCompra->insertar_detalle(
                            0,
                            1,
                            $dua / 1.18,
                            0,
                            $dua,
                            1,
                            $dua * 0.18,
                            0,
                            0,
                            $dua,
                            $comcosto_id,
                            $_POST['servicio'][$cont]
                        );

                        $oCompra->insertar_compra_costo($com_id, $comcosto_id);
                    }
                    $cont++;
                }
            }

            if($_POST['cmb_com_doc']=='20' or $_POST['cmb_com_doc']=='21'){
                if ($_POST['cmb_com_tip'] == '9' ) {
                }elseif ($_POST['cmb_com_tip'] == '6'){
                    //registro de kardex
                    $xac = 1;
                    $tipo_registro = 1;//1 automatico 2 manual
                    $kar_tip = 2;//1 entrada 2 salida
                    $tipope_id = 2;//2 compra
                    $kar_des = 'COMPRA';
                    $operacion_id = $com_id;//id de la operacion(modulo compras, ventas, etc)
                    $emp_id = $_SESSION['empresa_id'];

                    //insertamos kardex
                    $oKardex->insertar(
                        $xac,
                        $tipo_registro,
                        $codigo,
                        fecha_mysql($_POST['txt_com_fec']),
                        $kar_tip,
                        $_POST['cmb_com_doc'],
                        $_POST['txt_com_numdoc'],
                        $tipope_id,
                        $kar_des,
                        $operacion_id,
                        $_POST['cmb_com_alm_id'],
                        $_POST['hdd_usu_id'],
                        $_POST['hdd_emp_id']
                    );
                    //ultimo kardex
                    $dts = $oKardex->ultimoInsert();
                    $dt = mysql_fetch_array($dts);
                    $kar_id = $dt['last_insert_id()'];
                    mysql_free_result($dts);

                    $oKardex->modificar_codigo($kar_id, $kar_id);
                }
            }elseif ($_POST['cmb_com_doc']=='1' or $_POST['cmb_com_doc']=='7' or $_POST['cmb_com_doc']=='17' or $_POST['cmb_com_doc']=='18' or $_POST['cmb_com_doc']=='19'){
                //registro de kardex
                $xac = 1;
                $tipo_registro = 1;//1 automatico 2 manual
                $kar_tip = 1;//1 entrada 2 salida
                $tipope_id = 2;//2 compra
                $kar_des = 'COMPRA';
                $operacion_id = $com_id;//id de la operacion(modulo compras, ventas, etc)
                $emp_id = $_SESSION['empresa_id'];

                //insertamos kardex
                $oKardex->insertar(
                    $xac,
                    $tipo_registro,
                    $codigo,
                    fecha_mysql($_POST['txt_com_fec']),
                    $kar_tip,
                    $_POST['cmb_com_doc'],
                    $_POST['txt_com_numdoc'],
                    $tipope_id,
                    $kar_des,
                    $operacion_id,
                    $_POST['cmb_com_alm_id'],
                    $_POST['hdd_usu_id'],
                    $_POST['hdd_emp_id']
                );
                //ultimo kardex
                $dts = $oKardex->ultimoInsert();
                $dt = mysql_fetch_array($dts);
                $kar_id = $dt['last_insert_id()'];
                mysql_free_result($dts);

                $oKardex->modificar_codigo($kar_id, $kar_id);
            }


            //___________________________________________________________________


            //detalle productos
            foreach ($_SESSION['compra_car'] as $indice => $linea_cantidad) {

                //variable session de catalogo para actualizacion de precios de venta
                $_SESSION['precio_car'][] = $indice;

                //precio unitario
                if($_POST['cmb_com_doc']=='19') {
                    $linea_preuni = ($_SESSION['compra_linea_preuni'][$indice])*1.18;
                }else{
                    $linea_preuni = $_SESSION['compra_linea_preuni'][$indice];
                }
                //descuento
                $linea_des = $_SESSION['compra_linea_des'][$indice];
                if ($linea_des == "") $linea_des = 0;
                //flete
                $linea_fle = $_SESSION['compra_linea_fle'][$indice];
                if ($linea_fle == "") $linea_fle = 0;
                //percepcion
                $linea_per = $_SESSION['compra_linea_per'][$indice];
                if ($linea_per == "") $linea_per = 0;

                //descuento por linea
                $linea_calculo_des = 1 - ($linea_des) / 100;

                //importe por linea
                $linea_importe = $linea_preuni * $linea_cantidad * $linea_calculo_des;

                //igv por linea
                if($_POST['cmb_com_doc']=='19') {
                    $linea_igv = 0;
                }else{
                    $linea_igv = $linea_importe * $igv_dato;
                }

                $linea_calculo_cos = $_SESSION['compra_linea_cos'][$indice];

                $linea_calculo_cos_dolar = formato_money($linea_calculo_cos / $_POST['txt_com_tipcam']);


                ///-----------------------------------

                //presentacion catalogo / consulta para el stock
                $dts = $oCatalogoproducto->presentacion_catalogo_stock_almacen($indice, $_POST['cmb_com_alm_id']);
                $dt = mysql_fetch_array($dts);
                $pre_id = $dt['tb_presentacion_id'];
                $sto_id = $dt['tb_stock_id'];
                $sto_num = $dt['tb_stock_num'];
                $mul = $dt['tb_catalogo_mul'];
                $tipo_item = $dt['tb_afectacion_id'];



                $costo = $linea_preuni;
                //___________________________________________________
                //registro detalle de compra
                $oCompra->insertar_detalle(
                    $indice,
                    $linea_cantidad,
                    $linea_preuni,
                    $linea_des,
                    $linea_importe,
                    $tipo_item,
                    $linea_igv,
                    $linea_fle,
                    $linea_per,
                    $linea_calculo_cos,
                    $com_id
                );
                mysql_free_result($dts);


                $dts = $oCompra->ultimoInsert();
                $dt = mysql_fetch_array($dts);
                $comdet_id = $dt['last_insert_id()'];
                mysql_free_result($dts);

                if (!$_POST['cmb_com_tip'] == '6'){

                    foreach($_SESSION['lote_car'][$indice] as $indice_lote) {
                        $lts=$oLote->mostrarUnoLoteNumero($indice, $_SESSION['lote_car'][$indice][$indice_lote], $_POST['cmb_com_alm_id']);
                        $lt = mysql_fetch_array($lts);
                        $nro_rows = mysql_num_rows($lts);

                        if ($nro_rows>0){
                            $nuevo_stock = $_SESSION['lote_sto_num'][$indice][$indice_lote]+$lt['tb_lote_exisact'];
                            $oLote->modificar_stock($indice, $_SESSION['lote_car'][$indice][$indice_lote],$_POST['cmb_com_alm_id'], $nuevo_stock);
                        }elseif ($nro_rows==0){
                            $oLote->insertar($_SESSION['lote_car'][$indice][$indice_lote],$indice,fecha_mysql($_SESSION['lote_fecfab'][$indice][$indice_lote]),fecha_mysql($_SESSION['lote_fecven'][$indice][$indice_lote]),$_SESSION['lote_sto_num'][$indice][$indice_lote],$_SESSION['lote_estado'][$indice][$indice_lote],$_POST['cmb_com_alm_id']);
                        }

                        $oCompraDetalleLote->insertar($comdet_id, fecha_mysql($_SESSION['lote_fecfab'][$indice][$indice_lote]), fecha_mysql($_SESSION['lote_fecven'][$indice][$indice_lote]),$_SESSION['lote_sto_num'][$indice][$indice_lote], $_SESSION['lote_car'][$indice][$indice_lote]);
                    }
                }

                if($_POST['cmb_com_doc']=='20' or $_POST['cmb_com_doc']=='21'){
                    if ($_POST['cmb_com_tip'] == '9' ) {

                    //------------------------------------
                    }elseif ($_POST['cmb_com_tip'] == '6') {

                        //conversion a la minima unidad
                        $cantidad_compra = $linea_cantidad * $mul;

                        //actualizacion de stock
                        $stock_nuevo = $sto_num - $cantidad_compra;

                        if (isset($sto_id) and $sto_id > 0) {
                            $oStock->modificar($sto_id, $stock_nuevo);
                        } else {
                            $dts = $oCatalogoproducto->presentacion_catalogo($indice);
                            $dt = mysql_fetch_array($dts);
                            $pre_id = $dt['tb_presentacion_id'];
                            $sto_num = 0;
                            $mul = $dt['tb_catalogo_mul'];
                            mysql_free_result($dts);

                            //conversion a la minima unidad
                            $cantidad_compra = $linea_cantidad * $mul;

                            //actualizacion de stock
                            $stock_nuevo = $sto_num + $cantidad_compra;

                            $oStock->insertar($_POST['cmb_com_alm_id'], $pre_id, $stock_nuevo);


                        }

                        foreach($_SESSION['lote_car'][$indice] as $indice_lote) {
                            $lts=$oLote->mostrarUnoLoteNumero($indice, $_SESSION['lote_car'][$indice][$indice_lote], $_POST['cmb_com_alm_id']);
                            $lt = mysql_fetch_array($lts);
                            $nro_rows = mysql_num_rows($lts);

                            if ($nro_rows>0){
                                $nuevo_stock = $lt['tb_lote_exisact']-$_SESSION['lote_sto_num'][$indice][$indice_lote];
                                $oLote->modificar_stock($indice, $_SESSION['lote_car'][$indice][$indice_lote],$_POST['cmb_com_alm_id'], $nuevo_stock);
                            }elseif ($nro_rows==0){
                                $oLote->insertar($_SESSION['lote_car'][$indice][$indice_lote],$indice,fecha_mysql($_SESSION['lote_fecfab'][$indice][$indice_lote]),fecha_mysql($_SESSION['lote_fecven'][$indice][$indice_lote]),$_SESSION['lote_sto_num'][$indice][$indice_lote],$_SESSION['lote_estado'][$indice][$indice_lote],$_POST['cmb_com_alm_id']);
                            }

                            $oCompraDetalleLote->insertar($comdet_id, fecha_mysql($_SESSION['lote_fecfab'][$indice][$indice_lote]), fecha_mysql($_SESSION['lote_fecven'][$indice][$indice_lote]),$_SESSION['lote_sto_num'][$indice][$indice_lote], $_SESSION['lote_car'][$indice][$indice_lote]);
                        }

                        //unidad base
                        $dts = $oKardex->presentacion_buscar_unidad_base($pre_id);
                        $dt = mysql_fetch_array($dts);
                        $cat_id = $dt['tb_catalogo_id'];
                        mysql_free_result($dts);

                        //registro detalle de kardex
                        $precio = 0;
                        $oKardex->insertar_detalle(
                            $cat_id,
                            $cantidad_compra,
                            $costo,
                            $precio,
                            $kar_id
                        );
                    }
                }elseif ($_POST['cmb_com_doc']=='1' or $_POST['cmb_com_doc']=='7' or $_POST['cmb_com_doc']=='17' or $_POST['cmb_com_doc']=='18' or $_POST['cmb_com_doc']=='19') {
                    //conversion a la minima unidad
                    $cantidad_compra=$linea_cantidad*$mul;

                    //actualizacion de stock
                    $stock_nuevo=$sto_num+$cantidad_compra;

                    if(isset($sto_id) and $sto_id>0)
                    {
                        $oStock->modificar($sto_id,$stock_nuevo);
                    }
                    else
                    {
                        $dts=$oCatalogoproducto->presentacion_catalogo($indice);
                        $dt = mysql_fetch_array($dts);
                        $pre_id=	$dt['tb_presentacion_id'];
                        $sto_num	=0;
                        $mul		=$dt['tb_catalogo_mul'];
                        mysql_free_result($dts);

                        //conversion a la minima unidad
                        $cantidad_compra=$linea_cantidad*$mul;

                        //actualizacion de stock
                        $stock_nuevo=$sto_num+$cantidad_compra;

                        $oStock->insertar($_POST['cmb_com_alm_id'],$pre_id,$stock_nuevo);


                    }

                    //unidad base
                    $dts=$oKardex->presentacion_buscar_unidad_base($pre_id);
                    $dt = mysql_fetch_array($dts);
                    $cat_id		=$dt['tb_catalogo_id'];
                    mysql_free_result($dts);

                    //registro detalle de kardex
                    $precio=0;
                    $oKardex->insertar_detalle(
                        $cat_id,
                        $cantidad_compra,
                        $costo,
                        $precio,
                        $kar_id
                    );
                }
                //actualizacion de /precio unitario de compra/ y precio costo /
                $precio_unitario = $linea_preuni * $_POST['txt_com_tipcam'];
                $dts = $oCatalogoproducto->actualizar_precio_compra($indice, $precio_unitario, $costo);

                //actualizacion en dolares
                if ($_POST['cmb_com_mon'] == 2) {
                    $dts = $oCatalogoproducto->actualizar_precio_compra_dolar($indice, $_POST['txt_com_tipcam'], $costo);
                }

            }





            unset($_SESSION['compra_car']);
            //unset($_SESSION['compra_igv']);
            unset($_SESSION['compra_linea_precom']);
            unset($_SESSION['compra_linea_tippre']);
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

            //detalle de servicios
            if(isset($_SESSION['servicio_car'][$unico_id]))foreach($_SESSION['servicio_car'][$unico_id] as $indice=>$cantidad)
            {
                $autoin++;

                //precio de venta ingresado
                $precio_unitario_linea = $_SESSION['servicio_preven'][$unico_id][$indice];

                //precio unitario de venta
                $valor_unitario_linea=$precio_unitario_linea/(1+$igv_dato);

                $nom = $_SESSION['servicio_nom'][$unico_id][$indice];

                //Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
                $tipdes = $_SESSION['servicio_tipdes'][$unico_id][$indice];
                $descuento_numero_linea = formato_money($_SESSION['servicio_des'][$unico_id][$indice]);
                $descuento_porcentaje_linea = $descuento_numero_linea/100;
                //descuento en porcentaje

                $valor_venta_bruto_linea=$valor_unitario_linea*$cantidad;

                //igv
                $descuento_x_item_linea = $valor_venta_bruto_linea*$descuento_porcentaje_linea;
                $valor_venta_x_item_linea = $valor_venta_bruto_linea-$descuento_x_item_linea;

                $igv_linea=$valor_venta_x_item_linea*$igv_dato;

                $tipo_venta=2;
                $cat_id=0;
                $afeigv_id=1;
                $unimed_id=13;//ZZ

                $linea_fle=0;
                $linea_per=0;

                //////////////////////
                //registro detalle de venta de servicio

                $desc_percentage = $_POST['txt_ven_des'];

                $linea_importe = $precio_unitario_linea * $cantidad;

                //registro detalle de compra
                $oCompra->insertar_detalle(
                    0,
                    $cantidad,
                    $valor_unitario_linea,
                    $descuento_x_item_linea,
                    $linea_importe,
                    $afeigv_id,
                    $igv_linea,
                    $linea_fle,
                    $linea_per,
                    $precio_unitario_linea,
                    $com_id,
                    $_SESSION['servicio_car'][$unico_id][$indice]
                );
                mysql_free_result($dts);
            }

            if(isset($_SESSION['servicio_car'][$unico_id])){
                unset($_SESSION['servicio_car'][$unico_id]);
                unset($_SESSION['servicio_preven'][$unico_id]);
                unset($_SESSION['servicio_tipdes'][$unico_id]);
                unset($_SESSION['servicio_des'][$unico_id]);
                unset($_SESSION['servicio_nom'][$unico_id]);
            }


            $data['com_id'] = $com_id;
            $data['com_msj'] = 'Se registró compra correctamente.';
            echo json_encode($data);
        } else {
            $data['com_msj'] = 'Error: No se encontro el documento para la nota.';
            echo json_encode($data);
        }

    } else {
        $data['com_msj'] = 'Intentelo nuevamente.';
        echo json_encode($data);
    }
}

if($_POST['action_compra']=="editar")
{
	if(!empty($_POST['txt_com_fec']))
	{
        //documento
        $dts= $oDocumento->mostrarUno($_POST['cmb_com_doc']);
        $dt = mysql_fetch_array($dts);
        $documento=$dt['tb_documento_abr'];
        $documento_ele=$dt['tb_documento_ele'];
        $documento_tipdoc=$dt['cs_tipodocumento_id'];
        $documento_cod=$dt['cs_tipodocumento_cod'];
        mysql_free_result($dts);

		$oCompra->modificar(
			$_POST['hdd_com_id'],
			fecha_mysql($_POST['txt_com_fec']),
			fecha_mysql($_POST['txt_com_fecven']),
			$_POST['cmb_com_doc'],
			$_POST['txt_com_numdoc'],
			$_POST['hdd_com_pro_id'],
			$_POST['cmb_com_est'],
            $_POST['txt_com_numorden'],
            $documento_tipdoc
		);
		
		$data['com_msj']='Se registró compra correctamente.';
		echo json_encode($data);
	}
	else
	{
		$data['com_msj']='Intentelo nuevamente.';
		echo json_encode($data);
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['com_id']))
	{
//		$result = $oCompra->verifica_compra_producto($_POST['com_id']);
//		$fila = mysql_fetch_array($result);
//		
//		if($fila[1] !="")
//		{
			echo "No se puede eliminar, afecta información de productos.";
//		}
//		else
//		{
//			$oCompra->eliminar($_POST['com_id']);
//		echo 'Se eliminó compra correctamente.';
//		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>