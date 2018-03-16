<?php
require_once("../../config/Cado.php");
require_once("cUsuario.php");
$oUsuario = new cUsuario();
require_once ("cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();

$emp=$_POST['hdd_emp'];
$emp=1;

$url_web		='www.m-trainingperu.com';
$url_web_sis	='www.m-trainingperu.com/sistema/';
$email_soporte	='inscripciones@m-trainingperu.com';
$email_respuesta='inscripciones@m-trainingperu.com';


if($_POST['action'] == 'insertar'){
	if($_POST['txt_use']!="" and $_POST['txt_pas']!="" and $_POST['txt_ema']!="" and $_POST['txt_apepat']!="" and $_POST['txt_apemat']!="" and $_POST['txt_nom']!="")
	{
		
		$result = $oUsuario->verificaUsuario($_POST['txt_use']);
		$fila = mysql_fetch_array($result);
		
		if($fila[1] !="")
		{
			echo "0-El Nombre de Usuario '".$_POST['txt_use']."' no está disponible.";
		}
		else
		{
			$oUsuario->insertar($_POST['txt_use'],$_POST['txt_pas'],$_POST['txt_apepat'],$_POST['txt_apemat'],$_POST['txt_nom'],$_POST['txt_ema'],$_POST['cmb_usugru'],$emp);
			
				$dts=$oUsuario->ultimoInsert();
				$dt = mysql_fetch_array($dts);
			$id=$dt['last_insert_id()'];
				mysql_free_result($dts);
			
			if($id>0)$oUsuariodetalle->insertar($id);
			
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
				$mensaje.= "CLAVE: ".$_POST['txt_pas']."\n";
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
				$mensaje.= "http://".$url_web_sis."\n";
				$mensaje.= "                               \n";
				$mensaje.= "---------------------------------- \n";
				$mensaje.= "                               \n";
				$mensaje.= "Nuestra web: \n";
				$mensaje.= "http://".$url_web."\n";
				$mensaje.= "                               \n";
				$mensaje.= "---------------------------------- \n";
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
					$aviso2 = "Mensaje enviado correctamente";
				} else {
					$aviso2 = "Error de envío de mensaje.";
				}
				
				//Warning: mail() [function.mail]: Failed to connect to mailserver at "localhost" port 25, verify your "SMTP" and "smtp_port" setting in php.ini or use ini_set() in
			
			}
			//email/*

		echo $id.'-'.$aviso1.'. '.$aviso2;
		}//else
	
	}
	else
	{
		echo "0-No se pudo registar Faltan Datos";	
	}
}


if($_POST['action'] == 'editar'){
	if(!empty($_POST['hdd_usu_id']) and $_POST['txt_ema']!="" and $_POST['txt_apepat']!="" and $_POST['txt_apemat']!="" and $_POST['txt_nom']!="")
	{
		$oUsuario->modificar_sup($_POST['hdd_usu_id'],$_POST['txt_apepat'],$_POST['txt_apemat'],$_POST['txt_nom'],$_POST['txt_ema'],$_POST['cmb_usugru'],$emp);
		
		$oUsuariodetalle->modificar_sup($_POST['hdd_usu_id'],$_POST['txt_dni']);
			
		echo "0-Se modificó correctamente";
	}
	else{
		echo "0-No se pudo registar.";	
	}
}

?>