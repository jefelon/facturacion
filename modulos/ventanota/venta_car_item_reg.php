<?php 
session_start();
require_once ("../formatos/formato.php");

if($_POST['action_item']=="editar_producto"){
		
	$_SESSION['ventanota_can'][$_POST['hdd_item_id']] = $_POST['txt_item_can'];
	
	$_SESSION['ventanota_preven'][$_POST['hdd_item_id']]=moneda_mysql($_POST['txt_item_preven']);
	
	$_SESSION['ventanota_tipdes'][$_POST['hdd_item_id']] = $_POST['rad_tip_des'];
	
	//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
	$tipdes = $_POST['rad_tip_des'];				
	if($tipdes == 1){
		$des = $_POST['txt_item_des'];//Descuento Venta Detalle
	}
	
	if($tipdes == 2){
		$des = $_POST['txt_item_des'];//Descuento Venta Detalle	
	}
	
	$_SESSION['ventanota_des'][$_POST['hdd_item_id']] = moneda_mysql($des);
}

if($_POST['action_item']=="editar_servicio"){
		
	$_SESSION['vn_servicio_can'][$_POST['hdd_servicio_id']] = $_POST['txt_item_can'];
	
	$_SESSION['vn_servicio_preven'][$_POST['hdd_servicio_id']]=moneda_mysql($_POST['txt_item_preven']);
	
	$_SESSION['vn_servicio_tipdes'][$_POST['hdd_servicio_id']] = $_POST['rad_tip_des'];
	
	//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
	$tipdes = $_POST['rad_tip_des'];				
	if($tipdes == 1){
		$des = $_POST['txt_item_des'];//Descuento Venta Detalle
	}
	
	if($tipdes == 2){
		$des = $_POST['txt_item_des'];//Descuento Venta Detalle	
	}
	
	$_SESSION['vn_servicio_des'][$_POST['hdd_servicio_id']] = moneda_mysql($des);
}
	
	$data['ite_msj'] = "ok";
	echo json_encode($data);
?>