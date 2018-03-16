<?php
session_start();

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
require_once("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();

require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();

require_once("../producto/cStock.php");
$oStock = new cStock();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();

require_once("../formatos/formato.php");

if($_POST['action_notalmacen']=="insertar")
{
	
	if(!empty($_POST['txt_notalm_fec']))
	{
		$doc_id=3;//nota de almacen
		
		$dts= $oTalonariointerno->correlativo_tra($_POST['cmb_alm_id'],$doc_id);
		$dt = mysql_fetch_array($dts);
		
		$tal_id=$dt['tb_talonario_id'];
		$tal_ser=$dt['tb_talonario_ser'];
		$tal_num=$dt['tb_talonario_num'];
		$tal_fin=$dt['tb_talonario_fin'];
			mysql_free_result($dts);
		$numero=$tal_num+1;
		$largo=strlen($tal_fin);
		$correlativo=str_pad($numero,$largo, "0", STR_PAD_LEFT);
		$serie=$tal_ser;
		
		if($tal_ser!="")$numdoc=$serie.'-'.$correlativo;
		

		$doc_id=5;
		//insertamos nota almacen
		$oNotalmacen->insertar(
			fecha_mysql($_POST['txt_notalm_fec']),
			$_POST['cmb_notalm_tip'],
			$doc_id,
			$numdoc,
			$_POST['cmb_tipope_id'],
			$_POST['txt_notalm_des'],
			$_POST['cmb_alm_id'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_emp_id']
		);
		//ultimo nota de almacen
			$dts=$oNotalmacen->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$notalm_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		//actualizamos talonario
		$estado='ACTIVO';
		if($numero==$tal_fin)$estado='INACTIVO';
		$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$numero,$estado);


		//registro de kardex
		$xac=1;
		$tipo_registro=1;//1 automatico 2 manual
		$kar_tip=$_POST['cmb_notalm_tip'];//1 entrada 2 salida
		$tipope_id=9;//9 nota de almacen
		$kar_des='NOTA DE ALMACEN';
		$operacion_id=$notalm_id;//id de la operacion(modulo compras, ventas, etc)
		$emp_id=$_SESSION['empresa_id'];
		
		//insertamos kardex
		$oKardex->insertar(
			$xac,
			$tipo_registro,
			$cod,
			fecha_mysql($_POST['txt_notalm_fec']),
			$kar_tip,
			$doc_id,
			$numdoc,
			$tipope_id,
			$kar_des,
			$operacion_id,
			$_POST['cmb_alm_id'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_emp_id']
		);
		//ultimo kardex
			$dts=$oKardex->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$kar_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		$oKardex->modificar_codigo($kar_id,$kar_id);
		
		
		//detalle de productos
		foreach($_SESSION['notalmacen_car'] as $indice=>$cantidad){			
			
			//registro detalle de notalmacen
			$oNotalmacen->insertar_detalle(
				$indice,
				$cantidad,
				$costo,
				$precio,
				$notalm_id
			);
			
			//datos presentacion catalogo almacen
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($indice,$_POST['cmb_alm_id']);
			$dt = mysql_fetch_array($dts);
				$pre_id		=$dt['tb_presentacion_id'];
				$sto_id		=$dt['tb_stock_id'];
				$sto_num	=$dt['tb_stock_num'];
				$mul		=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);
			
			//conversion a la minima unidad
			$cantidad_notalmacen=$cantidad*$mul;
			
			//actualizacion de stock
			if($_POST['cmb_notalm_tip']==1)
			{
				if(isset($sto_id))
				{
					//actualizacion de stock
					$stock_nuevo=$sto_num+$cantidad_notalmacen;
					
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
					$cantidad_notalmacen=$cantidad*$mul;
					
					//actualizacion de stock
					$stock_nuevo=$sto_num+$cantidad_notalmacen;
				
					$oStock->insertar($_POST['cmb_alm_id'],$pre_id,$stock_nuevo);
				}
			}
			
			if($_POST['cmb_notalm_tip']==2)
			{				
				$stock_nuevo=$sto_num-$cantidad_notalmacen;
				$dts=$oStock->modificar($sto_id,$stock_nuevo);
			}

			//unidad base
			$dts=$oKardex->presentacion_buscar_unidad_base($pre_id);
			$dt = mysql_fetch_array($dts);
				$cat_id		=$dt['tb_catalogo_id'];
				$costo		=$dt['tb_catalogo_precos'];
				$precio		=$dt['tb_catalogo_preven'];
			mysql_free_result($dts);

			//registro detalle de kardex
			$oKardex->insertar_detalle(
				$cat_id,
				$cantidad_notalmacen,
				$costo,
				$precio,
				$kar_id
			);
			
			//------------------------------------

        }
		
		unset($_SESSION['notalmacen_car']);
		unset($_SESSION['presentacion_id']);
		unset($_SESSION['catalogo_mul']);
		
		$data['notalm_id']=$notalm_id;
		if($_POST['chk_imprimir']==1)$data['notalm_act']='imprime';
		$data['notalm_msj']='Se registró nota de almacén correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_notalmacen']=="editar")
{
	if(!empty($_POST['txt_notalm_fec']))
	{
		/*$oNotalmacen->modificar(
			$_POST['hdd_notalm_id'],
			fecha_mysql($_POST['txt_notalm_fec']),
			$_POST['txt_notalm_des']
		);*/
		
		//$data['notalm_msj']='Se registró nota de almacén correctamente.';
		$data['notalm_msj']='Consulte si puede realizar modificaciones a notas de almacén.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['notalm_id']))
	{
//		$result = $oNotalmacen->verifica_notalmacen_producto($_POST['notalm_id']);
//		$fila = mysql_fetch_array($result);
//		
//		if($fila[1] !="")
//		{
			echo "No se puede eliminar, afecta información de productos.";
//		}
//		else
//		{
		//$oNotalmacen->eliminar_notalmacen($_POST['notalm_id']);
//		echo 'Se eliminó notalmacen correctamente.';
//		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>