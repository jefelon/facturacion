<?php
require_once ("../../config/Cado.php");

require_once ("cUsuario.php");
$oUsuario = new cUsuario();

require_once ("../formatos/formatos.php");

$url_web		='www.m-trainingperu.com';
$email_soporte	='soporte@m-trainingperu.com';
$email_respuesta='inscripciones@m-trainingperu.com';

$email_c=$_GET['e'];
$email_c=ereg_replace("%40","@",$email_c);

$codigo=$_GET['c'];
$tipo=$_GET['t'];

//validar el email de confirmacion con el registro de datos
$result = $oUsuario->verificar_restabclave($email_c,$codigo);
$fila = mysql_fetch_array($result);
	
if($fila['tb_restabclave_ema']!="")
{
	$restc_id=$fila['tb_restabclave_id'];
	
	if($tipo=="confirm")
	{
		$est_r="Confirmado";
		$oUsuario->modificar_restabclave($restc_id,$est_r);
	}
	if($tipo=="cancel")
	{
		$est_r="Cancelado";
		$oUsuario->modificar_restabclave($restc_id,$est_r);
	}
	
	if($fila['tb_usuario_id']!="" and $tipo=="confirm")
	{
		$use_id=$fila['tb_usuario_id'];
		
		$dts=$oUsuario->mostrarUno($use_id);
		$dt = mysql_fetch_array($dts);
			$usugru	=$dt['tb_usuariogrupo_id'];
			$nom	=$dt['tb_usuario_nom'];
			$apepat	=$dt['tb_usuario_apepat'];
			$apemat	=$dt['tb_usuario_apemat'];
			$use	=$dt['tb_usuario_use'];
			$usu_ema	=$dt['tb_usuario_ema'];
			$ultvis	=$dt['tb_usuario_ultvis'];
			
			$apenom=$apepat.' '.$apemat.' '.$nom;
		mysql_free_result($dts);
		
		
		//email indicando datos participante
			$clave=GeneraPassword(6);
			
			$oUsuario->modificar_clave($use_id,$clave);
			
			$aviso1 = "";
			if ($usu_ema != "")
			{
				// email de destino
				$email = $usu_ema;
			   
				// asunto del email
				$subject = "Restablecimiento de clave. ".$url_web;
			   
				// Cuerpo del mensaje
				$mensaje = "Hola, ".$nom.": \n";
				$mensaje.= "Hemos recibido una solicitud de restablecimiento de contraseña.\n";
				$mensaje.= "                               \n";
				$mensaje.= "---------------------------------- \n";
				$mensaje.= "         Datos de Usuario          \n";
				$mensaje.= "---------------------------------- \n";
				$mensaje.= "USUARIO:    ".$use."\n";
				$mensaje.= "CLAVE:      ".$clave."\n";
				$mensaje.= "                               \n";
				$mensaje.= "APELLIDOS:  ".$apepat." ".$apemat."\n";
				$mensaje.= "NOMBRES:    ".$nom."\n";
				$mensaje.= "EMAIL:      ".$usu_ema."\n";
				//$mensaje.= "TELEFONO:   ".$_POST['txt_tel']."\n";
				//$mensaje.= "FECHA:      ".date("d/m/Y")."\n";
				//$mensaje.= "HORA:       ".date("h:i:s a")."\n";
				//$mensaje.= "IP:       ".$_SERVER['REMOTE_ADDR']."\n\n";
				$mensaje.= "---------------------------------- \n\n";
				//$mensaje.= $_POST['mensaje']."\n\n";
				$mensaje.= "                               \n";
				$mensaje.= "Portal Web: \n";
				$mensaje.= "---------------------------------- \n";
				$mensaje.= "http://".$url_web."\n";
				$mensaje.= "                               \n";
				$mensaje.= "                               \n";
				$mensaje.= "Si tienes alguna consulta escribir a: ".$email_respuesta."\n";
				$mensaje.= "Gracias.\n";
				$mensaje.= "---------------------------------- \n";
			   
				$mensaje=utf8_decode($mensaje);
				
				// headers del email
				//email de respuesta
				$emailres=$email_respuesta;
				$headers = "From: ".$emailres."\r\n";
			   
				// Enviamos el mensaje
				if (mail($email, $subject, utf8_encode($mensaje), $headers)) {
					$aviso1 = "Revisar bandeja de entrada. ".$usu_ema.".";
				} else {
					$aviso1 = "No se pudo enviar mensaje. Intente restablecer nuevamente su contraseña.";
				}
				
				//Warning: mail() [function.mail]: Failed to connect to mailserver at "localhost" port 25, verify your "SMTP" and "smtp_port" setting in php.ini or use ini_set() in
			
			}
			//email
		header("Location: login.php?mm=".$aviso1."..");
	}
	else
	{
		$aviso2="Se ha cancelado la operacion. Ingresar.";
		header("Location: login.php?mm=".$aviso2."..");
	}
}
else
{
	$aviso3="ERROR. Enlace alterado.";
	header("Location: login.php?mm=".$aviso3."..");
}
?>