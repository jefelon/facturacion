<?php
require_once("../../config/Cado.php");
require_once("cUsuario.php");
$oUsuario = new cUsuario();
require_once ("cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();

$emp=$_POST['hdd_emp'];
$emp=1;

if($_POST['action'] == 'editar'){
	if(!empty($_POST['hdd_usu_id']) and $_POST['txt_ema']!="" and $_POST['txt_apepat']!="" and $_POST['txt_apemat']!="" and $_POST['txt_nom']!="")
	{
		$oUsuario->modificar_datos($_POST['hdd_usu_id'],$_POST['txt_apepat'],$_POST['txt_apemat'],$_POST['txt_nom'],$_POST['txt_ema']);
		
		$oUsuariodetalle->modificar_datos($_POST['hdd_usu_id'],$_POST['txt_dni']);
		
		//cargar nuevos datos
		session_start();
		$_SESSION['usuario_nombre']		=$_POST['txt_apepat']." ".$_POST['txt_apemat']." ".$_POST['txt_nom'];
			
		echo "Se modificó sus datos correctamente.";
	}
	else{
		echo "No se pudo registar, intentelo nuevamente.";	
	}
}

?>