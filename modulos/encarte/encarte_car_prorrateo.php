<?php 
	session_start();
	require_once ("../formatos/formato.php");
	
	$_SESSION['encarte_general_des'] = $_POST['enc_des'];
	$_SESSION['encarte_general_fle'] = $_POST['enc_fle'];
	$_SESSION['encarte_general_tipfle'] = $_POST['enc_tipfle'];
	
	$_SESSION['encarte_ajupos'] = $_POST['enc_ajupos'];
	$_SESSION['encarte_ajuneg'] = $_POST['enc_ajuneg'];
	
	$data['msj'] = " ok";
	echo json_encode($data);
?>