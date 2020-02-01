<?php
require_once("../../config/Cado.php");
require_once("cUsuario.php");
$oUsuario = new cUsuario();

if($_POST['action'] == 'editar'){
	if(!empty($_POST['hdd_usu_id']) and $_POST['txt_use']!="")
	{
		$result = $oUsuario->verificaUsuario($_POST['txt_use']);
		$fila = mysql_fetch_array($result);
		
		if($fila[1] !="")
		{
			echo "El Nombre de Usuario '".$_POST['txt_use']."' no está disponible.";
		}
		else
		{
			$oUsuario->modificar_nombreusuario($_POST['hdd_usu_id'],$_POST['txt_use']);
			echo "Se cambió nombre de usuario correctamente.";
		}
	}
	else{
		echo "No se pudo registar.";	
	}
}

?>