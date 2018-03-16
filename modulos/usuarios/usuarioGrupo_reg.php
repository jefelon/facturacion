<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cUsuariogrupo.php");
$oUsuariogrupo = new cUsuariogrupo();

if($_POST['action']=="insertar")
{
	if(!empty($_POST['txt_usugru_nom']))
	{
		$oUsuariogrupo->insertar($_POST['txt_usugru_nom'],$_POST['txt_usugru_des']);
		echo 'Se registró correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="editar")
{
	if(!empty($_POST['txt_usugru_nom']))
	{
		$oUsuariogrupo->modificar($_POST['hdd_usugru_id'],$_POST['txt_usugru_nom'],$_POST['txt_usugru_des']);
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
		$oUsuariogrupo->eliminar($_POST['id']);
		echo 'Se eliminó correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}
?>