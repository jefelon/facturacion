<?php
require_once ("../../config/Cado.php");
require_once("cCuenta.php");
$oCuenta = new cCuenta();

if($_GET['action']=="insertar1")
{
	if(!empty($_POST['txt_cod']) and !empty($_POST['txt_des']))
	{
		$oCuenta->insertar($_POST['txt_cod'],$_POST['txt_des'],$_POST['txt_ord'],$_POST['hdd_ele']);
		header("Location: manCuentas.php?alerta1=1");
	}
	else
	{
		header("Location: manCuentas.php?alerta1=4");
	}
}

if($_GET['action']=="editar1")
{
	if(!empty($_POST['txt_cod']) and !empty($_POST['txt_des']))
	{
		$oCuenta->modificar($_POST['hdd_id'],$_POST['txt_cod'],$_POST['txt_des'],$_POST['txt_ord'],$_POST['hdd_ele']);
		header("Location: manCuentas.php?alerta1=2");
	}
	else
	{
		header("Location: manCuentas.php?alerta1=4");
	}
}
?>