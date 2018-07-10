<?php 
	session_start();
	require_once ("../formatos/formato.php");
	
	$_SESSION['venta_general_des'] = $_POST['ven_des'];

	$data['msj'] = " ok";
	echo json_encode($data);
?>