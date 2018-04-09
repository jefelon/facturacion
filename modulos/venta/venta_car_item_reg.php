<?php 
session_start();
require_once ("../formatos/formato.php");

$unico_id=$_POST['unico_id'];

if($_POST['action_item']=="editar_producto"){
		
	$_SESSION['venta_car'][$unico_id][$_POST['hdd_catalogo_id']] = $_POST['txt_item_can'];
	
	$_SESSION['venta_preven'][$unico_id][$_POST['hdd_catalogo_id']]=moneda_mysql($_POST['txt_item_preven']);

	$_SESSION['venta_serial'][$unico_id][$_POST['hdd_catalogo_id']] = $_POST['txt_item_serie'];
	
	$_SESSION['venta_tipdes'][$unico_id][$_POST['hdd_catalogo_id']] = $_POST['rad_tip_des'];
	
	//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
	$tipdes = $_POST['rad_tip_des'];				
	if($tipdes == 1){
		$des = $_POST['txt_item_des'];//Descuento Venta Detalle
	}
	
	if($tipdes == 2){
		$des = $_POST['txt_item_des'];//Descuento Venta Detalle	
	}
	
	$_SESSION['venta_des'][$unico_id][$_POST['hdd_catalogo_id']] = moneda_mysql($des);
}

if($_POST['action_item']=="editar_servicio"){
		
	$_SESSION['servicio_car'][$unico_id][$_POST['hdd_servicio_id']] = $_POST['txt_item_can'];
	
	$_SESSION['servicio_preven'][$unico_id][$_POST['hdd_servicio_id']]=moneda_mysql($_POST['txt_item_preven']);
	
	$_SESSION['servicio_tipdes'][$unico_id][$_POST['hdd_servicio_id']] = $_POST['rad_tip_des'];
	
	//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
	$tipdes = $_POST['rad_tip_des'];				
	if($tipdes == 1){
		$des = $_POST['txt_item_des'];//Descuento Venta Detalle
	}
	
	if($tipdes == 2){
		$des = $_POST['txt_item_des'];//Descuento Venta Detalle	
	}
	
	$_SESSION['servicio_des'][$unico_id][$_POST['hdd_servicio_id']] = moneda_mysql($des);
}
	
	$data['ite_msj'] = "ok";
	echo json_encode($data);
?>