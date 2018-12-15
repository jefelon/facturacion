<?php
require_once ("../../config/Cado.php");

require_once ("cUsuario.php");
$oUsuario = new cUsuario();

require_once ("../formatos/formatos.php");

$url_web		='www.m-trainingperu.com';
$email_soporte	='soporte@m-trainingperu.com';
$email_respuesta='inscripciones@m-trainingperu.com';


if($_POST['email']!="")
{
	$result = $oUsuario->mostrar_usuario_con_email($_POST['email']);
	$fila = mysql_fetch_array($result);
	
	if($fila['tb_usuario_id']!="")
	{
		$usu_id=$fila['tb_usuario_id'];
		
		$dts=$oUsuario->mostrarUno($usu_id);
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
		
		//codigo de confiracion
		$cod=GeneraPassword(32);
		$est_res='Espera';
		
		//guardar datos de restablecimiento de contraseña
		$dts=$oUsuario->insertar_restabclave($usu_ema,$cod,$est_res,$usu_id);
		
		//email de confirmacion de restablecimiento de contraseña
			
			$aviso1 = "";
			if ($usu_ema != "")
			{
				// email de destino
				//ereg_replace("@","%40",$usu_ema)
				$email = $usu_ema;
			   
				// asunto del email
				$subject = "Confirmar restablecimiento de clave. ".$url_web;
			   
				// Cuerpo del mensaje
				$mensaje = "Hola, ".$nom.": \n";
				$mensaje.= "Hemos recibido una solicitud de restablecimiento de contraseña.\n";
				$mensaje.= "Se ha proporcionado el siguiente email:                        \n";
				$mensaje.= "EMAIL:      ".$usu_ema."\n";
				$mensaje.= "--------------------------------------------- \n\n";
				$mensaje.= "                               \n";
				$mensaje.= "Para completar el proceso de restablecimiento de contraseña, sigue este enlace: \n";
				$mensaje.= "------------------- \n";
				$mensaje.= "http://".$url_web."/sistema/restablecerpas_operacion.php?e=".$usu_ema."&c=".$cod."&t=confirm\n";
				$mensaje.= "------------------- \n";
				$mensaje.= "Codigo de confirmacion: ".$cod."                         \n";
				$mensaje.= "--------------------------------------------- \n\n";
				$mensaje.= "                               \n";
				$mensaje.= "No solicitaste restablecer tu contraseña.\n";
				$mensaje.= "Para cancelar el proceso, sigue este enlace: \n";
				$mensaje.= "-------------------- \n";
				$mensaje.= "http://".$url_web."/sistema/restablecerpas_operacion.php?e=".$usu_ema."&c=".$cod."&t=cancel\n";
				$mensaje.= "-------------------- \n";
				$mensaje.= "                               \n";
				$mensaje.= "Gracias.\n";
				$mensaje.= " \n";
			   
				$mensaje=utf8_decode($mensaje);
				
				// headers del email
				//email de respuesta
				$emailres=$email_respuesta;
				$headers = "From: ".$emailres."\r\n";
			   
				// Enviamos el mensaje
				if (mail($email, $subject, utf8_encode($mensaje), $headers)) {
					$aviso1 = "Se envió mensaje correctamente a: ".$usu_ema.". ";
				} else {
					$aviso1 = "Error de envío de mensaje. ";
				}
				
				//Warning: mail() [function.mail]: Failed to connect to mailserver at "localhost" port 25, verify your "SMTP" and "smtp_port" setting in php.ini or use ini_set() in
			
			}
			//email
		
		echo $aviso1;
	}
	else
	{
		echo "No se ha encontrado ninguna cuenta con esa dirección de correo electrónico.";
	}
}
else
{
	echo "Ingrese correo electrónico";
}
?>