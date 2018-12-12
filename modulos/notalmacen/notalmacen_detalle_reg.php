<?php
require_once ("../../config/Cado.php");
require_once("../notalmacen/cNotalmacendetalle.php");
$oNotalmacendetalle = new cNotalmacendetalle();

require_once("../formatos/formato.php");

if($_POST['action_notalmacen_detalle']=="editar")
{
	if(!empty($_POST['hdd_notalmdet_id']))
	{
		$oNotalmacendetalle->modificar(
			$_POST['hdd_notalmdet_id'],
			$_POST['txt_notalmdet_can'],
			moneda_mysql($_POST['txt_notalmdet_cos']),
			moneda_mysql($_POST['txt_notalmdet_pre'])
		);
		
		$data['notalm_msj']='Se registró detalle correctamente.';
		echo json_encode($data);
	}
	else
	{
		$data['notalm_msj']='Intentelo nuevamente.';
		echo json_encode($data);
	}
}
?>