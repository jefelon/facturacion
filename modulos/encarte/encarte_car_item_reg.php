<?php 
	session_start();
	require_once ("../formatos/formato.php");
	
	//descuento porcentaje		
	$_SESSION['encarte_despor'][$_POST['hdd_catalogo_id']]=$_POST['txt_item_despor'];
	
	//utilidad 2
	$_SESSION['encarte_uti2'][$_POST['hdd_catalogo_id']]=$_POST['txt_item_uti2'];
	
	//preven 2
	$_SESSION['encarte_preven2'][$_POST['hdd_catalogo_id']]=$_POST['txt_item_preven2'];
	
	$data['ite_msj'] = "ok";
	echo json_encode($data);
?>