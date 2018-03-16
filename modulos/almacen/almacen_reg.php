<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cAlmacen.php");
$oAlmacen = new cAlmacen();

if($_POST['action_almacen']=="insertar")
{
	if(!empty($_POST['txt_alm_nom']))
	{
		$oAlmacen->insertar($_POST['txt_alm_nom'],$_POST['chk_alm_ven'],$_SESSION['empresa_id']);
		echo 'Se registró almacén correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_almacen']=="editar")
{
	if(!empty($_POST['txt_alm_nom']))
	{
		$oAlmacen->modificar($_POST['hdd_alm_id'],$_POST['txt_alm_nom'],$_POST['chk_alm_ven']);
		echo 'Se registró almacén correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['alm_id']))
	{
		$cst1 = $oAlmacen->verifica_almacen_tabla($_POST['alm_id'],'tb_puntoventa');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Punto de venta';
		
		$cst2 = $oAlmacen->verifica_almacen_tabla($_POST['alm_id'],'tb_compra');
		$rst2= mysql_num_rows($cst2);
		if($rst2>0)$msj2=' - Compra';
		
		$cst3 = $oAlmacen->verifica_almacen_tabla($_POST['alm_id'],'tb_stock');
		$rst3= mysql_num_rows($cst3);
		if($rst3>0)$msj3=' - Stock por almacén';
		
		if($rst1>0 or $rst2>0 or $rst3>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.$msj3.".";
		}
		else
		{
			$oAlmacen->eliminar($_POST['alm_id']);
			echo 'Se eliminó almacén correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>