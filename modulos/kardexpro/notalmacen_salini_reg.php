<?php
require_once ("../../config/Cado.php");
require_once("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();

require_once("../formatos/formato.php");

if($_POST['action']=="actualizar_saldo_inicial")
{
	if($_POST['can']>=0)
	{
		$oNotalmacen->actualizar_salini(
			$_POST['notalmdet_id'],
			$_POST['can']
		);
		//echo $_POST['notalmdet_id'].'|'.$_POST['can'];
		$data['notalm_msj']='Se registró stock saldo inicial correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

?>