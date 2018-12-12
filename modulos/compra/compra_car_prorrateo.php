<?php 
	session_start();
	require_once ("../formatos/formato.php");
	
	$_SESSION['compra_general_des'] = $_POST['com_des'];
	$_SESSION['compra_general_fle'] = $_POST['com_fle'];
	$_SESSION['compra_general_tipfle'] = $_POST['com_tipfle'];
	
	$_SESSION['compra_ajupos'] = $_POST['com_ajupos'];
	$_SESSION['compra_ajuneg'] = $_POST['com_ajuneg'];
	
	$data['msj'] = " ok";
	echo json_encode($data);
?>