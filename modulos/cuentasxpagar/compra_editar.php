<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once("../compra/cCompra.php");
$oCompra = new cCompra();
require_once("../formatos/formato.php");


if($_POST['action']=="cambio2")
{
	if(!empty($_POST['com_id']))
	{
		$oCompra->modificar_cambio2(
			$_POST['com_id'],
			$_POST['tipcam2']
		);
		
		echo 'Se registró tipo cambio correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}