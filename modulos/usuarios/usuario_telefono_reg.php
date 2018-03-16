<?php
require_once ("../../config/Cado.php");
require_once("cTelefono.php");
$oTelefono = new cTelefono();

if($_POST['action']=="insertar")
{
	if(!empty($_POST['txt_tel_num']))
	{
		$oTelefono->insertar($_POST['cmb_tel_tip'], $_POST['cmb_tel_ope'], $_POST['txt_tel_num'], $_POST['hdd_usu_id']);
		echo 'Se registró correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="editar")
{
	if(!empty($_POST['txt_tel_num']))
	{
		$oTelefono->modificar($_POST['hdd_tel_id'],$_POST['cmb_tel_tip'], $_POST['cmb_tel_ope'], $_POST['txt_tel_num']);
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
		$oTelefono->eliminar($_POST['id']);
		echo 'Se eliminó correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}
?>