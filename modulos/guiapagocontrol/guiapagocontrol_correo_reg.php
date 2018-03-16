<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../../config/datos.php");
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
/*require_once ("../guiapagonota/cGuiapagonota.php");
$oGuiapagonota = new cGuiapagonota();*/

require_once("../formatos/formato.php");

//usuarios
if($_SESSION['usuario_id']>0)
{
	$dts=$oUsuario->mostrarUno($_SESSION['usuario_id']);
	$dt = mysql_fetch_array($dts);
		$usugru		=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$usu_nom	=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$usu_ema	=$dt['tb_usuario_ema'];
	mysql_free_result($dts);
	$usuario_reg="$usu_nom $apepat $apemat";
}


//require("../../libreriasphp/phpmailer/class.phpmailer.php");
require '../../libreriasphp/phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer();
//$mail->PluginDir = "../../libreriasphp/phpmailer/";

if($_POST['action_correo']=='enviar' or $_POST['action_correo']=='reenviar')
{

$mail->setLanguage('es','../../libreriasphp/phpmailer/language');
$mail->CharSet = "UTF­8";
//$mail->Encoding = "quoted­printable";

$mail->IsSMTP();
$mail->SMTPDebug = 0;//Enable SMTP debugging // 0 = off (for production use) // 1 = client messages // 2 = client and server messages 
$mail->Debugoutput = 'html';//Ask for HTML-friendly debug output  
$mail->Host = $d_sc_Host;//Set the hostname of the mail server  
$mail->Port = $d_sc_Port;//Set the SMTP port number - likely to be 25, 465 or 587  
$mail->SMTPAuth = $d_sc_SMTPAuth;//Whether to use SMTP authentication 
$mail->SMTPSecure = $d_sc_SMTPSecure;
$mail->Username = $d_sc_Username; //Username to use for SMTP authentication 
$mail->Password = $d_sc_Password; //Password to use for SMTP authentication
//$mail->Timeout=30;

//$mail->setFrom('soporte@estudiovidalcontadores.com', 'Sistema Web | Estudiovidalcontadores.com'); //correo envío
//$mail->addReplyTo('gerencia@estudiovidalcontadores.com', 'Gerencia | Estudiovidalcontadores.com'); //Responder a correo

$usu_ema_nom="$usu_nom $apepat | Estudiovidalcontadores.com";

$mail->setFrom($usu_ema,$usu_ema_nom); //correo envío
$mail->addReplyTo($usu_ema,$usu_ema_nom); //Responder a correo

$mail->addAddress(trim($_POST['txt_cli_ema']),trim($_POST['txt_cli_con'])); //Destinatario
$mail->addCC(trim($_POST['txt_cli_emacop']),trim($_POST['txt_cli_concop'])); //con copia
//$mail->addBCC('soporte@estudiovidalcontadores.com', 'Sistema Web | Estudiovidalcontadores.com'); //copia oculta

$asunto=trim($_POST['txt_cor_asu']);

//php+5.3
//'=?UTF-8?Q?' . quoted_printable_encode($subject) . '?=';
$asunto=utf8_encode("=?UTF-8?B?".base64_encode($asunto)."?=");
$mail->Subject = $asunto; //Asunto

//$mail->IsHTML(true);
//Read an HTML message body from an external file, convert referenced images to embedded, //convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__)); 
$mail->AltBody = 'Su gestor de correo electrónico no soporta mensajes en HTML. Por lo tanto no podrá ver el contenido.'; //Replace the plain text body with one created manually 

$num_archivos=count($_FILES['fil_cor_adj']['name']);
if($num_archivos>0)
{
	foreach ($_FILES['fil_cor_adj']['name'] as $i => $name){
		$nombre_adjunto=$_FILES['fil_cor_adj']['name'][$i];
		$nombre_adjunto=utf8_encode("=?UTF-8?B?".base64_encode($nombre_adjunto)."?=");

		$mail->addAttachment($_FILES['fil_cor_adj']['tmp_name'][$i], $nombre_adjunto);
		if($num_archivos>=2 and $i>=1)$archivos.=", ";
		$archivos.=$_FILES['fil_cor_adj']['name'][$i];
	}
}
//$archivo = $_FILES['fil_cor_adj'];
//$mail->addAttachment($archivo['tmp_name'], $archivo['name']);
//$mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file 
//send the message, check for errors

$body.=$_POST['txt_cor_men'];

$mail->Body = $body; // Mensaje a enviar

/*if (!$mail->send()){ $resultado="Error: " . $mail->ErrorInfo; }
else {
	$xac=1;
	$tip=2;//1nota,2email
	$oGuiapagonota->insertar(
		$xac,
		$_POST['hdd_cli_id'], 
		$_POST['hdd_per_id'],
		$_POST['hdd_eje_id'],
		$tip,
		$usu_ema,
		trim($_POST['txt_cli_ema']),
		trim($_POST['txt_cli_emacop']),
		trim($_POST['txt_cor_asu']),
		$body,
		$archivos
	);
  	*/
  	$resultado="Se ha enviado el mensaje."; 
//} 

$data['guipagnot_cor_msj']=$resultado;
echo json_encode($data);

}//fin if
?>