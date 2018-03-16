<?php 
	session_start();
	require_once ("../formatos/formato.php");
	
	$_SESSION['traspaso_car'][$_POST['hdd_catalogo_id']] = $_POST['txt_item_can'];
	
	$data['ite_msj'] = "ok";
	echo json_encode($data);
?>