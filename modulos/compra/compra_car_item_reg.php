<?php 
	session_start();
	require_once ("../formatos/formato.php");
	
	$igv_dato=0.18;
	
	$_SESSION['compra_car'][$_POST['hdd_catalogo_id']] = moneda_mysql($_POST['txt_item_can']);
	$_SESSION['compra_linea_des'][$_POST['hdd_catalogo_id']] = $_POST['txt_item_des'];
	$_SESSION['compra_linea_fle'][$_POST['hdd_catalogo_id']] = $_POST['txt_item_fle'];
	
	//precio unitario de compra sin IGV
	if($_SESSION['compra_linea_tippre'][$_POST['hdd_catalogo_id']]==1)
	{
		$precio_unitario=moneda_mysql($_POST['txt_item_precom']);
	}
	
	if($_SESSION['compra_linea_tippre'][$_POST['hdd_catalogo_id']]==2)
	{
		$precio_unitario=moneda_mysql($_POST['txt_item_precom'])/(1+$igv_dato);
	}
	
	$_SESSION['compra_linea_preuni'][$_POST['hdd_catalogo_id']]=$precio_unitario;//id cat - precio unitario
	
	$data['ite_msj'] = "ok";
	echo json_encode($data);
?>