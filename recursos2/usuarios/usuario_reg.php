<?php
require_once("../../config/Cado.php");
require_once("cUsuario.php");
$oUsuario = new cUsuario();

$url_web		='www.holdingengin.com';
$email_soporte	='soporte@holdingengin.com';
$email_respuesta='soporte@holdingengin.com';

if($_POST['action'] == 'insertar'){
	if($_POST['txt_use']!="" and $_POST['txt_pas']!="" and $_POST['txt_ema']!="" and $_POST['txt_apepat']!="" and $_POST['txt_apemat']!="" and $_POST['txt_nom']!="")
	{
		$result = $oUsuario->verificaUsuario($_POST['txt_use']);
		$fila = mysql_fetch_array($result);
		
		if($fila[1] !="")
		{
			echo "El Nombre de Usuario '".$_POST['txt_use']."' no está disponible.";
		}
		else
		{
			$oUsuario->insertar($_POST['txt_use'],$_POST['txt_pas'],$_POST['txt_apepat'],$_POST['txt_apemat'],$_POST['txt_nom'],$_POST['txt_ema'],$_POST['cmb_usugru'],$_POST['hdd_emp']);
			
				$dts=$oUsuario->ultimoInsert();
				$dt = mysql_fetch_array($dts);
			$id=$dt['last_insert_id()'];
				mysql_free_result($dts);
			
			$aviso1="Se agregó correctamente al usuario: ".$_POST['txt_use'];
			
			//email
			$aviso2 = "";
			if ($_POST['txt_ema'] != "")
			{
				// email de destino
				$email = $_POST['txt_ema'];
			   
				// asunto del email
				$subject = "Registro de Usuario, ".$url_web;
			   
				// Cuerpo del mensaje
				$mensaje = "Hola ".$_POST['txt_nom'].", \n";
				$mensaje.= "Queremos comunicarte que hemos registrado\n";
				$mensaje.= "tus datos en nuestro Sistema.\n";
				$mensaje.= "                               \n";
				$mensaje.= "Porfavor revisa si son correctos \n";
				$mensaje.= "                               \n";
				$mensaje.= "---------------------------------- \n";
				$mensaje.= "         Datos de Usuario          \n";
				$mensaje.= "---------------------------------- \n";
				$mensaje.= "USUARIO:    ".$_POST['txt_use']."\n";
				$mensaje.= "CONTRASE�A: ".$_POST['txt_pas']."\n";
				$mensaje.= "                               \n";
				$mensaje.= "APELLIDOS:  ".$_POST['txt_apepat']." ".$_POST['txt_apemat']."\n";
				$mensaje.= "NOMBRES:    ".$_POST['txt_nom']."\n";
				$mensaje.= "EMAIL:      ".$_POST['txt_ema']."\n";
				//$mensaje.= "TELEFONO:   ".$_POST['txt_tel']."\n";
				//$mensaje.= "FECHA:      ".date("d/m/Y")."\n";
				//$mensaje.= "HORA:       ".date("h:i:s a")."\n";
				//$mensaje.= "IP:       ".$_SERVER['REMOTE_ADDR']."\n\n";
				$mensaje.= "---------------------------------- \n\n";
				//$mensaje.= $_POST['mensaje']."\n\n";
				$mensaje.= "                               \n";
				$mensaje.= "Ingresar al Sistema: \n";
				$mensaje.= "---------------------------------- \n";
				$mensaje.= "http://".$url_web."\n";
				$mensaje.= "                               \n";
				$mensaje.= "                               \n";
				$mensaje.= "Si tienes alguna consulta escribir a: ".$email_soporte."\n";
				$mensaje.= "Gracias.\n";
				$mensaje.= "---------------------------------- \n";
			   
				
				// headers del email
				//email de respuesta
				$emailres=$email_respuesta;
				$headers = "From: ".$emailres."\r\n";
			   
				// Enviamos el mensaje
				if (mail($email, $subject, utf8_encode($mensaje), $headers)) {
					$aviso2 = "Mensaje enviado correctamente a: ".$_POST['txt_ema'];
				} else {
					$aviso2 = "Error de envío de mensaje.";
				}
				
				//Warning: mail() [function.mail]: Failed to connect to mailserver at "localhost" port 25, verify your "SMTP" and "smtp_port" setting in php.ini or use ini_set() in
			}
			//email/*

		echo 'editar'.'-'.$id.'-'.$aviso1.'-'.$aviso2;
		}//else
	}
	else{
		echo "insertar-0-No se pudo registar Faltan Datos-";	
	}
}

?>