<?php
require_once ("../../config/Cado.php");
require_once("cStock.php");
$oStock = new cStock();

if($_POST['action_stock']=="insertar"){
	if(!empty($_POST['hdd_pre_id']))
	{
		$oStock->insertar(
			$_POST["hdd_alm_id"],
			$_POST['hdd_pre_id'],
			$_POST["txt_sto_num"]
		);
		echo 'Se actualizó stock correctamente.';
	}
	else{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_stock']=="editar")
{
	if(!empty($_POST['hdd_pre_id']))
	{
		$oStock->modificar(
			$_POST["hdd_sto_id"],
			$_POST["txt_sto_num"]
		);

		echo 'Se actualizó stock correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="actualizar_stock")
{
	if($_POST['tipo']=='insertar')
	{
		$oStock->insertar(
			$_POST["alm_id"],
			$_POST['pre_id'],
			$_POST["sto_num"]
		);

		echo 'Ok';
	}
	else
	{
		echo 'Error';
	}
}

?>