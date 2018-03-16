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
require_once("../traspaso/cTraspaso.php");
$oTraspaso = new cTraspaso();

require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();
require_once("../producto/cStock.php");
$oStock = new cStock();

require_once("../kardex/cKardex.php");
$oKardex = new cKardex();

require_once("../formatos/formato.php");


if($_POST['action_traspaso']=="insertar")
{
	
	if(!empty($_POST['txt_tra_fec']))
	{
		$doc_id=2;
		
			$dts= $oTalonariointerno->correlativo_tra($_POST['cmb_tra_alm_ori'],$doc_id);
			$dt = mysql_fetch_array($dts);
		$tal_id=$dt['tb_talonario_id'];
		$tal_ser=$dt['tb_talonario_ser'];
		$tal_fin=$dt['tb_talonario_fin'];
		$tal_num=$dt['tb_talonario_num'];
			mysql_free_result($dts);
	
		$numero=$tal_num+1;
		$largo=strlen($tal_fin);
		
		$correlativo=str_pad($numero,$largo, "0", STR_PAD_LEFT);
		
		$cod=$tal_ser.'-'.$correlativo;
		
		//insertamos traspaso
		$act=1;
		$oTraspaso->insertar(
			fecha_mysql($_POST['txt_tra_fec']),
			$_POST['cmb_tra_doc'],
			$cod,
			$_POST['cmb_tra_alm_ori'],
			$_POST['cmb_tra_alm_des'],
			$_POST['txt_tra_ref'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_emp_id'],
			$act
		);
		//ultima traspaso
			$dts=$oTraspaso->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$tra_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		//actualizamos talonario
		$estado='ACTIVO';
		if($numero==$tal_fin)$estado='INACTIVO';
		$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$numero,$estado);
		
		
		//registro de kardex SALIDA
		$xac=1;
		$tipo_registro=1;//1 automatico 2 manual
		$kar_tip=2;//1 entrada 2 salida
		$tipope_id=4;//4 transferencia salida
		$kar_des='TRASPASO';
		$operacion_id=$tra_id;//id de la operacion(modulo compras, ventas, etc)
		$emp_id=$_SESSION['empresa_id'];
		
		//insertamos kardex
		$oKardex->insertar(
			$xac,
			$tipo_registro,
			$codigo,
			fecha_mysql($_POST['txt_tra_fec']),
			$kar_tip,
			$_POST['cmb_tra_doc'],
			$cod,
			$tipope_id,
			$kar_des,
			$operacion_id,
			$_POST['cmb_tra_alm_ori'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_emp_id']
		);
		//ultimo kardex
			$dts=$oKardex->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$kar_id1=$dt['last_insert_id()'];
			mysql_free_result($dts);

		$oKardex->modificar_codigo($kar_id1,$kar_id1);

		//registro de kardex ENTRADA
		$xac=1;
		$tipo_registro=1;//1 automatico 2 manual
		$kar_tip=1;//1 entrada 2 salida
		$tipope_id=4;//4 transferencia
		$kar_des='TRASPASO';
		$operacion_id=$tra_id;//id de la operacion(modulo compras, ventas, etc)
		$emp_id=$_SESSION['empresa_id'];
		
		//insertamos kardex
		$oKardex->insertar(
			$xac,
			$tipo_registro,
			$codigo,
			fecha_mysql($_POST['txt_tra_fec']),
			$kar_tip,
			$_POST['cmb_tra_doc'],
			$cod,
			$tipope_id,
			$kar_des,
			$operacion_id,
			$_POST['cmb_tra_alm_des'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_emp_id']
		);
		//ultimo kardex
			$dts=$oKardex->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$kar_id2=$dt['last_insert_id()'];
			mysql_free_result($dts);

		$oKardex->modificar_codigo($kar_id2,$kar_id2);
		
		//___________________________________________________________________
		
		
		//detalle de productos
		foreach($_SESSION['traspaso_car'] as $indice=>$cantidad){			
			
			//registro detalle de traspaso
			$oTraspaso->insertar_detalle(
				$indice,
				$cantidad,
				$tra_id
			);
			
			// Presentacion catalogo
			$dts=$oCatalogoproducto->presentacion_catalogo($indice);
				$dt = mysql_fetch_array($dts);
					$pre_id=	$dt['tb_presentacion_id'];
					$sto_num	=0;
					$mul		=$dt['tb_catalogo_mul'];
				mysql_free_result($dts);
			
			//conversion a la minima unidad
			$cantidad_traspaso=$cantidad*$mul;

			//unidad base
			$dts=$oKardex->presentacion_buscar_unidad_base($pre_id);
			$dt = mysql_fetch_array($dts);
				$cat_id		=$dt['tb_catalogo_id'];
				$cat_precos	=$dt['tb_catalogo_precos'];
				$cat_preven	=$dt['tb_catalogo_preven'];
			mysql_free_result($dts);

			//registro detalle de kardex
			$precio=0;
			$oKardex->insertar_detalle(
				$cat_id,
				$cantidad_traspaso,
				$cat_precos,
				$cat_preven,
				$kar_id1
			);

			$precio=0;
			$oKardex->insertar_detalle(
				$cat_id,
				$cantidad_traspaso,
				$cat_precos,
				$cat_preven,
				$kar_id2
			);

			//------------------------------
			
			//datos presentacion catalogo almacen origen
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($indice,$_POST['cmb_tra_alm_ori']);
			$dt = mysql_fetch_array($dts);
				$sto_id_ori=	$dt['tb_stock_id'];
				$sto_num_ori	=$dt['tb_stock_num'];
				$mul_ori		=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);
			
			//conversion a la minima unidad
			$cantidad_traspaso_ori=$cantidad*$mul_ori;
			
			//actualizacion de stock de almacen origen
			$stock_nuevo_ori=$sto_num_ori-$cantidad_traspaso_ori;
			$dts=$oStock->modificar($sto_id_ori,$stock_nuevo_ori);
			
			
			//datos presentacion catalogo almacen destino
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($indice,$_POST['cmb_tra_alm_des']);
			$dt = mysql_fetch_array($dts);
				$sto_id_des=	$dt['tb_stock_id'];
				$sto_num_des	=$dt['tb_stock_num'];
				$mul_des		=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);
			
			//conversion a la minima unidad
			$cantidad_traspaso_des=$cantidad*$mul_des;
			
			//actualizacion de stock
			$stock_nuevo_des=$sto_num_des+$cantidad_traspaso_des;
			//$dts=$oStock->modificar($sto_id_des,$stock_nuevo_des);
			
			//verificar si tiene registro en stock		
			if(isset($sto_id_des) and $sto_id_des>0)
			{
				$oStock->modificar($sto_id_des,$stock_nuevo_des);
			}
			else
			{
				$dts=$oCatalogoproducto->presentacion_catalogo($indice);
				$dt = mysql_fetch_array($dts);
					$pre_id		=$dt['tb_presentacion_id'];
					$sto_num_des=0;
					$mul_des	=$dt['tb_catalogo_mul'];
				mysql_free_result($dts);
				
				//conversion a la minima unidad
				$cantidad_traspaso_des=$cantidad*$mul_des;
				
				//actualizacion de stock
				$stock_nuevo_des=$sto_num_des+$cantidad_traspaso_des;
			
				$oStock->insertar($_POST['cmb_tra_alm_des'],$pre_id,$stock_nuevo_des);
			}
			
        }
		
		unset($_SESSION['traspaso_car']);
		unset($_SESSION['presentacion_id']);
		unset($_SESSION['catalogo_mul']);
		
		$data['tra_id']=$tra_id;
		if($_POST['chk_imprimir']==1)$data['tra_act']='imprime';
		$data['tra_msj']='Se registró traspaso correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_traspaso']=="editar")
{
	if(!empty($_POST['txt_tra_fec']))
	{
		$oTraspaso->modificar(
			$_POST['hdd_tra_id'],
			fecha_mysql($_POST['txt_tra_fec']),
			$_POST['txt_tra_ref']
		);

		$data['tra_msj']='Se registró traspaso correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['tra_id']))
	{
//		$result = $oTraspaso->verifica_traspaso_producto($_POST['tra_id']);
//		$fila = mysql_fetch_array($result);
//		
//		if($fila[1] !="")
//		{
			echo "No se puede eliminar, afecta información de productos.";
//		}
//		else
//		{
//			$oTraspaso->eliminar($_POST['tra_id']);
//		echo 'Se eliminó traspaso correctamente.';
//		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>