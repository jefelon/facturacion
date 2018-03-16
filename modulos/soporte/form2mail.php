<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../../config/Cado.php");
require_once("cSoporte.php");
$oSoporte = new cSoporte();

if($_POST['btn_enviar'])
{
$est='Pendiente';
$vis='1';
$oSoporte->insertar($_POST['Usuario'],$_POST['Empresa'],$_POST['Email'],$_POST['Asunto'],$_POST['Tema'],$_POST['Ubicacion'],$_POST['Mensaje'],$est,$vis);
}
else{
	exit();	
}

//datos de usuario
$nombre_usuario=$_SESSION["usuario_nombre"];
$empresa=$_SESSION['empresa_nombre'];

$correo=$_POST['Email'];
$asunto=$_POST['Asunto'];
$tema=$_POST['Tema'];
$ubicacion=$_POST['Ubicacion'];
$mensaje=$_POST['Mensaje'];

//solicitando nombre y mail origen
$Nombre = $_POST['Nombre'];
$Email = $_POST['Email'];

# You can use this script to submit your forms or to receive orders by email.
$MailDestino = "soporte@m-trainingperu.com"; // your email address
//$redirectURL = "http://www.web4future.com/thankyou.htm"; // the URL of the thank you page.
$redirectURL = "mensaje.php?vista=mail"; // the URL of the thank you page.
$MailAsunto = "Soporte m-trainingperu.com - ".$_POST['Asunto']; // the subject of the email
$sendHTML = FALSE; //set to "false" to receive Plain TEXT e-mail
$serverCheck = TRUE; // if, for some reason you can't send e-mails, set this to "false"

# copyright 2006 Web4Future.com =================== READ THIS ===================================================

# If you are asking for a name and an email address in your form, you can name the input fields "name" and "email".
# If you do this, the message will apear to come from that email address and you can simply click the reply button to answer it.

# To block an IP, simply add it to the blockip.txt text file.
# CHMOD 777 the blockip.txt file (run "CHMOD 777 blockip.txt", without the double quotes) 
# This is needed because the script tries to block the IP that tried to hack it

# If you have a multiple selection box or multiple checkboxes, you MUST name the multiple list box or checkbox as "name[]" instead of just "name" 
# you must also add "multiple" at the end of the tag like this: <select name="myselectname[]" multiple> 
# you have to do the same with checkboxes

/*****************************************************************

	Web4Future Easiest Form2Mail (GPL).
	Copyright (C) 1998-2006 Web4Future.com All Rights Reserved. 
	http://www.Web4Future.com/
	This script was written by George L. & Calin S. from Web4Future.com

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

*****************************************************************/

# DO NOT EDIT BELOW THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING ===================================================
$w4fver =  "2.2";
$ip = ($_SERVER['HTTP_X_FORWARDED_FOR'] == "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']);
//function blockIP
function blockip($ip) {
	$handle = @fopen("blockip.txt", 'a');
	@fwrite($handle, $ip."\n");
	@fclose($handle); 
}
$w4fx = stristr(file_get_contents('blockip.txt'),getenv('REMOTE_ADDR'));

if ($serverCheck) { 
	if (preg_match ("/".str_replace("www.", "", $_SERVER["SERVER_NAME"])."/i", $_SERVER["HTTP_REFERER"])) { $w4fy = TRUE; } else { $w4fy = FALSE; }
} else { $w4fy = TRUE; }
if (($w4fy === TRUE) && ($w4fx === FALSE)) {
$w4fMessage = "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//ES\" \"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
</head>
<body>
<font face=verdana size=3><b><strong>$empresa</strong></b></font>
<br><br>
<font face=verdana size=3><b>De: $nombre_usuario $correo</b></font>
<br>
<font face=verdana size=3><b>Asunto: $asunto</b></font>
<font face=verdana size=3><b>Tema: $tema</b></font>
<font face=verdana size=3><b>Ubicación: $ubicacion</b></font>
<br>
<font face=verdana size=3><b>$mensaje</b></font>
<br>
<font face=3Dverdana size=3D2>";
/*
if (count($_GET) >0) {
	reset($_GET);
	while(list($key, $val) = each($_GET)) {
		$GLOBALS[$key] = $val;
		if (is_array($val)) { 
			$w4fMessage .= "<b>$key:</b> ";
			foreach ($val as $vala) { 
				$vala =stripslashes($vala);
				$vala = htmlspecialchars($vala);
				if (trim($vala)) { if (stristr($vala,"Content-Type:") || stristr($vala,"MIME-Version") || stristr($vala,"Content-Transfer-Encoding") || stristr($vala,"bcc:")) { blockip($ip); die("SE DETECTO UNA EJECUCION ILEGAL!"); }	}
				$w4fMessage .= "$vala, ";
			} 
			$w4fMessage .= "<br>\n";
		} 	
		else {
			$val = stripslashes($val);
			if (trim($val)) { if (stristr($val,"Content-Type:") || stristr($val,"MIME-Version") || stristr($val,"Content-Transfer-Encoding") || stristr($val,"bcc:")) { blockip($ip); die("SE DETECTO UNA EJECUCION ILEGAL!"); }	}
			if (($key == "Submit") || ($key == "submit")) { } 	
			else { 	if ($val == "") { $w4fMessage .= "$key: - <br>\n"; }
					else { $w4fMessage .= "<b>$key:</b> $val<br>\n"; }
			}
		}
	} // end while
}//end if
else {
	reset($_POST);
	while(list($key, $val) = each($_POST)) {
		$GLOBALS[$key] = $val;
		
		if (is_array($val)) { 
			$w4fMessage .= "<b>$key:</b> ";
			foreach ($val as $vala) { 
				$vala =stripslashes($vala);
				$vala = htmlspecialchars($vala);
				if (trim($vala)) { if (stristr($vala,"Content-Type:") || stristr($vala,"MIME-Version") || stristr($vala,"Content-Transfer-Encoding") || stristr($vala,"bcc:")) {blockip($ip); die("SE DETECTO UNA EJECUCION ILEGAL!"); }	}				
				$w4fMessage .= "$vala, ";
			} 
			$w4fMessage .= "<br>\n";
		} 	
		else {
			$val = stripslashes($val);
			if (trim($val)) { if (stristr($val,"Content-Type:") || stristr($val,"MIME-Version") || stristr($val,"Content-Transfer-Encoding") || stristr($val,"bcc:")) {blockip($ip); die("SE DETECTO UNA EJECUCION ILEGAL!"); }	}
			if (($key == "Submit") || ($key == "submit")) { } 	
			else { 	if ($val == "") { $w4fMessage .= "$key: - <br>\n"; }
					else { $w4fMessage .= "<b>$key:</b> $val<br>\n"; }
			}
		}
	} // end while
	}//end else
	*/
	$w4fMessage .= "<font size=2D1><br><br>\nEnviado desde IP: ".$ip."</font>
	</font>
	</body>
	</html>";
    
	$w4f_what = array("/To:/i", "/Cc:/i", "/Bcc:/i","/Content-Type:/i","/\n/");
	
	
	$Nombre = preg_replace($w4f_what, "", $Nombre);
	$Email = preg_replace($w4f_what, "", $Email);
	
if (!$Email) {$Email = $MailDestino;}
	$mailHeader = "From: $Nombre <$Email>\r\n";
	$mailHeader .= "Reply-To: $Nombre <$Email>\r\n";
	$mailHeader .= "Message-ID: <". md5(rand()."".time()) ."@". ereg_replace("www.","",$_SERVER["SERVER_NAME"]) .">\r\n";
	$mailHeader .= "MIME-Version: 1.0\r\n";
	if ($sendHTML) {
		$mailHeader .= "Content-Type: multipart/alternative;";			
		$mailHeader .= " 	boundary=\"----=_NextPart_000_000E_01C5256B.0AEFE730\"\r\n";					
	}
	$mailHeader .= "X-Priority: 3\r\n";
	$mailHeader .= "X-Mailer: PHP/" . phpversion()."\r\n";
	$mailHeader .= "X-MimeOLE: Produced By Web4Future Easiest Form2Mail $w4fver\r\n";
	if ($sendHTML) { 
		$mailMessage = "This is a multi-part message in MIME format.\r\n\r\n"; 
		$mailMessage .= "------=_NextPart_000_000E_01C5256B.0AEFE730\r\n";
		$mailMessage .= "Content-Type: text/plain;   charset=\"utf-8\"\r\nContent-Transfer-Encoding: quoted-printable\r\n\r\n";			
		$mailMessage .= trim(strip_tags($w4fMessage))."\r\n\r\n";			
		$mailMessage .= "------=_NextPart_000_000E_01C5256B.0AEFE730\r\n";			
		$mailMessage .= "Content-Type: text/html;   charset=\"utf-8\"\r\nContent-Transfer-Encoding: quoted-printable\r\n\r\n";			
		$mailMessage .= "$w4fMessage\r\n\r\n";			
		$mailMessage .= "------=_NextPart_000_000E_01C5256B.0AEFE730--\r\n";			
	}
	if ($sendHTML === FALSE) {
		$mailHeader .= "Content-Type: text/plain;   charset=\"utf-8\"\r\nContent-Transfer-Encoding: quoted-printable\r\n\r\n";			
		$mailMessage .= trim(strip_tags($w4fMessage))."\r\n\r\n";			
	}

	if (!mail($MailDestino, $MailAsunto, $mailMessage,$mailHeader)) { echo "Error enviando e-mail!";}
	else { header("Location: ".$redirectURL); }	
} else { echo "<center><font face=verdana size=3 color=red><b>SE DETECTO UNA EJECUCION ILEGAL!</b></font></center>";}
?>
