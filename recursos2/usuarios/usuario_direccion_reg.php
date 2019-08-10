<?php
require_once ("../../config/Cado.php");
require_once("cDireccion.php");
$oDireccion = new cDireccion();

$ubigeo=''.$_POST['cmb_ubigeo_dep'].$_POST['cmb_ubigeo_pro'].$_POST['cmb_ubigeo_dis'].'';

if($_POST['action']=="insertar")
{
	if(!empty($_POST['txt_dir']))
	{
		$oDireccion->insertar($_POST['txt_dir'], $ubigeo,$_POST['hdd_usu_id']);
		echo 'Se registró correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="editar")
{
	if(!empty($_POST['txt_dir']))
	{
		$oDireccion->modificar($_POST['hdd_dir_id'],$_POST['txt_dir'], $ubigeo);
		echo 'Se registró correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
		$oDireccion->eliminar($_POST['id']);
		echo 'Se eliminó correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}
?>