<?php
require_once ("../../config/Cado.php");
require_once("cSubcuenta.php");
$oSubcuenta = new cSubcuenta();

if($_GET['action']=="insertar2")
{
	if(!empty($_POST['txt_cod']) and !empty($_POST['txt_des']) and !empty($_POST['hdd_cue']))
	{
		$oSubcuenta->insertar($_POST['txt_cod'],$_POST['txt_des'],$_POST['txt_ord'],$_POST['hdd_cue']);
		header("Location: manCuentas.php?alerta2=1");
	}
	else
	{
		header("Location: manCuentas.php?alerta2=4");
	}
}

if($_GET['action']=="editar2")
{
	if(!empty($_POST['txt_cod']) and !empty($_POST['txt_des']) and !empty($_POST['hdd_cue']))
	{
		$oSubcuenta->modificar($_POST['hdd_id'],$_POST['txt_cod'],$_POST['txt_des'],$_POST['txt_ord'],$_POST['hdd_cue']);
		header("Location: manCuentas.php?alerta2=2");
	}
	else
	{
		header("Location: manCuentas.php?alerta2=4");
	}
}
?>