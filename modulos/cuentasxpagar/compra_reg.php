<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once("../compra/cCompra.php");
$oCompra = new cCompra();
require_once("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../producto/cStock.php");
$oStock = new cStock();
require_once("../formatos/formato.php");

require_once("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();

$igv_dato=0.18;

if($_POST['action_compra']=="insertar")
{
	if(!empty($_POST['txt_com_fec']))
	{
		//$estado='CANCELADA';
		
		//insertamos compra
		$oCompra->insertar(
			fecha_mysql($_POST['txt_com_fec']),
			fecha_mysql($_POST['txt_com_fecven']),
			$_POST['cmb_com_doc'],
			$_POST['txt_com_numdoc'],
			$_POST['cmb_com_mon'],
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
			moneda_mysql($_POST['txt_com_igv']),
			moneda_mysql($_POST['txt_com_tot']),
			$_POST['cmb_com_alm_id'],
			$_POST['cmb_com_est'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_emp_id']
		);
		//ultima compra
			$dts=$oCompra->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$com_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		//nota de almacen/_____________________________________________________
		$doc_id=3;//nota de almacen
		
		$dts= $oTalonariointerno->correlativo_tra($_POST['cmb_com_alm_id'],$doc_id);
		$dt = mysql_fetch_array($dts);
		
		$tal_id=$dt['tb_talonario_id'];
		$tal_ser=$dt['tb_talonario_ser'];
		$tal_num=$dt['tb_talonario_num'];
		$tal_fin=$dt['tb_talonario_fin'];
			mysql_free_result($dts);
		$numero=$tal_num+1;
		$largo=strlen($tal_fin);
		
		$correlativo=str_pad($numero,$largo, "0", STR_PAD_LEFT);
		
		$y=date('Y');
		
		$cod_almacen=str_pad($_POST['cmb_com_alm_id'],2, "0", STR_PAD_LEFT);
	
		$codigo="$cod_almacen-$y-$correlativo";
		
		//registro de nota
		$tipo_registro=1;//1 automatico 2 manual
		$notalm_tip=1;//1 entrada 2 salida
		$tipope_id=2;//2 compra
		$notalm_des='COMPRA';
		$operacion_id=$com_id;//id de la operacion(modulo compras, ventas, etc)
		
		//insertamos nota almacen
		$oNotalmacen->insertar(
			$tipo_registro,
			$codigo,
			fecha_mysql($_POST['txt_com_fec']),
			$notalm_tip,
			$_POST['cmb_com_doc'],
			$_POST['txt_com_numdoc'],
			$tipope_id,
			$notalm_des,
			$operacion_id,
			$_POST['cmb_com_alm_id'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_emp_id']
		);
		//ultima nota de almacen
			$dts=$oNotalmacen->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$notalm_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		//actualizamos talonario de nota de almacen
		$estado='ACTIVO';
		if($numero==$tal_fin)$estado='INACTIVO';
		$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$numero,$estado);
		
		//___________________________________________________________________
		
		
		//detalle productos
		foreach($_SESSION['compra_car'] as $indice=>$linea_cantidad){
			
			//variable session de catalogo para actualizacion de precios de venta
			$_SESSION['precio_car'][]=$indice;		
			
			//precio unitario
			$linea_preuni=$_SESSION['compra_linea_preuni'][$indice];
			//descuento
			$linea_des=$_SESSION['compra_linea_des'][$indice];
			if($linea_des=="")$linea_des=0;
			//flete
			$linea_fle=$_SESSION['compra_linea_fle'][$indice];
			if($linea_fle=="")$linea_fle=0;
		
			//descuento por linea
			$linea_calculo_des=1-($linea_des)/100;
			
			//importe por linea
			$linea_importe=$linea_preuni*$linea_cantidad*$linea_calculo_des;
		
			//igv por linea
			$linea_igv=$linea_importe*$igv_dato;
						
			$linea_calculo_cos=$_SESSION['compra_linea_cos'][$indice];
			
			$linea_calculo_cos_dolar=formato_money($linea_calculo_cos/$_POST['txt_com_tipcam']);
				
			//___________________________________________________
			//registro detalle de compra
			$oCompra->insertar_detalle(
				$indice,
				$linea_cantidad,
				$linea_preuni,
				$linea_des,
				$linea_importe,
				$linea_igv,
				$linea_fle,
				$linea_calculo_cos,
				$com_id
			);
			
			///-----------------------------------
			//registro detalle de notalmacen
			$precio=0;
			$oNotalmacen->insertar_detalle(
				$indice,
				$linea_cantidad,
				$linea_calculo_cos,
				$precio,
				$notalm_id
			);
			//------------------------------------
			
			
			//presentacion catalogo / consulta para el stock
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($indice,$_POST['cmb_com_alm_id']);
			$dt = mysql_fetch_array($dts);
				$pre_id		=$dt['tb_presentacion_id'];
				$sto_id		=$dt['tb_stock_id'];
				$sto_num	=$dt['tb_stock_num'];
				$mul		=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);
			
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
			
			//actualizacion de /precio unitario de compra/ y precio costo /
			$precio_unitario=$linea_preuni*$_POST['txt_com_tipcam'];
			$dts= $oCatalogoproducto->actualizar_precio_compra($indice,$precio_unitario,$linea_calculo_cos);
			
			//actualizacion en dolares
			if($_POST['cmb_com_mon']==2)
			{
				$dts= $oCatalogoproducto->actualizar_precio_compra_dolar($indice,$_POST['txt_com_tipcam'],$linea_calculo_cos_dolar);
			}
			
        }
		
		unset($_SESSION['compra_car']);
		//unset($_SESSION['compra_igv']);
		unset($_SESSION['compra_linea_precom']);
		unset($_SESSION['compra_linea_tippre']);
		unset($_SESSION['compra_linea_preuni']);
		unset($_SESSION['compra_linea_des']);
		unset($_SESSION['compra_linea_fle']);
		unset($_SESSION['compra_linea_cos']);
		unset($_SESSION['presentacion_id']);
		
		unset($_SESSION['compra_general_des']);
		unset($_SESSION['compra_general_fle']);
		unset($_SESSION['compra_general_tipfle']);
		
		unset($_SESSION['compra_ajupos']);
		unset($_SESSION['compra_ajuneg']);
		
		echo 'Se registró compra correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_compra']=="editar")
{
	if(!empty($_POST['hdd_com_id']))
	{
		$oCompra->modificar_estado(
			$_POST['hdd_com_id'],
			$_POST['cmb_com_est']
		);
		
		echo 'Se registró compra correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
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