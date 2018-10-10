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

require_once ("../lote/cLote.php");
$oLote = new cLote();

$igv_dato=0.18;

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
        //$estado='CANCELADA';

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
                $_POST['cmb_com_tip']
            );
            //ultima compra
            $dts = $oCompra->ultimoInsert();
            $dt = mysql_fetch_array($dts);
            $com_id = $dt['last_insert_id()'];
            mysql_free_result($dts);

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
                $linea_preuni = $_SESSION['compra_linea_preuni'][$indice];
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
                $linea_igv = $linea_importe * $igv_dato;

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
                    $linea_igv,
                    $tipo_item,
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