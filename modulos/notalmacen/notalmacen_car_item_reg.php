<?php 
	session_start();
	require_once ("../formatos/formato.php");
	
	$_SESSION['notalmacen_car'][$_POST['hdd_catalogo_id']] = moneda_mysql($_POST['txt_item_can']);
	
	$data['ite_msj'] = "ok";
	echo json_encode($data);
?>