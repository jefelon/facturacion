<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cTipoperacion.php");
$oTipoperacion = new cTipoperacion();

if($_POST['action_tipoperacion']=="insertar")
{
	if(!empty($_POST['txt_tipope_nom']))
	{
		$man=1;
		$oTipoperacion->insertar(strip_tags($_POST['txt_tipope_nom']),$_POST['cmb_tip'],$man);
		echo 'Se registró tipo de operación correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_tipoperacion']=="editar")
{
	if(!empty($_POST['txt_tipope_nom']))
	{
		$oTipoperacion->modificar($_POST['hdd_tipope_id'],strip_tags($_POST['txt_tipope_nom']),$_POST['cmb_tip']);
		echo 'Se registró tipo de operación correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['tipope_id']))
	{
		$cst1 = $oTipoperacion->verifica_tipoperacion_tabla($_POST['tipope_id'],'tb_puntoventa');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Punto de venta';
		
		$cst2 = $oTipoperacion->verifica_tipoperacion_tabla($_POST['tipope_id'],'tb_compra');
		$rst2= mysql_num_rows($cst2);
		if($rst2>0)$msj2=' - Compra';
		
		$cst3 = $oTipoperacion->verifica_tipoperacion_tabla($_POST['tipope_id'],'tb_stock');
		$rst3= mysql_num_rows($cst3);
		if($rst3>0)$msj3=' - Stock por almacén';
		
		if($rst1>0 or $rst2>0 or $rst3>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.$msj3.".";
		}
		else
		{
			//$oTipoperacion->eliminar($_POST['tipope_id']);
			echo 'Se eliminó tipo de operación correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>