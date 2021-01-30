<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../../config/datos.php");
require_once ("../venta/cVentacorreo.php");
$oVentacorreo = new cVentacorreo();
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once("../formatos/formato.php");

require_once ("../../modulos/empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
$dts = $oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$usu_ema_nom=$dt['tb_empresa_ema'];
$usu_ema=$dt['tb_empresa_nomcom'];
$ruc_empresa=$dt['tb_empresa_ruc'];

$vts = $oVenta->mostrarUno($_POST['hdd_ven_id']);
while($vt = mysql_fetch_array($vts))
{
    $idcomprobante=$vt["cs_tipodocumento_cod"];

    $serie=$vt["tb_venta_ser"];
    $numero=$vt["tb_venta_num"];

    $ruc=$vt["tb_cliente_doc"];

}


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
    $mail->Host = 'mail.aqpfact.pe';//Set the hostname of the mail server
    $mail->Port = '465';//Set the SMTP port number - likely to be 25, 465 or 587
    $mail->SMTPAuth = true;//Whether to use SMTP authentication
    $mail->SMTPSecure = 'ssl';
    $mail->Username = 'cpe@aqpfact.pe'; //Username to use for SMTP authentication
    $mail->Password = 'srWcF9vWrd-K'; //Password to use for SMTP authentication
//$mail->Timeout=30;

//$mail->setFrom('soporte@estudiovidalcontadores.com', 'Sistema Web | Estudiovidalcontadores.com'); //correo envío
//$mail->addReplyTo('gerencia@estudiovidalcontadores.com', 'Gerencia | Estudiovidalcontadores.com'); //Responder a correo

//$usu_ema_nom="$usu_nom $apepat | Estudiovidalcontadores.com";

    $mail->setFrom('cpe@aqpfact.pe','cpe@aqpfact.pe'); //correo envío
    $mail->addReplyTo('cpe@aqpfact.pe','cpe@aqpfact.pe'); //Responder a correo

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

    $path = "../../cperepositorio/send";
    $filename_pdf = ''.$serie.'-'.$numero.'.pdf';
    $full_path_pdf = $path . '/' .$ruc_empresa.'-0'.$idcomprobante.'-'. $filename_pdf;
    $filename_xml = $ruc_empresa.'-'. str_pad($idcomprobante, 2, '0', STR_PAD_LEFT) .'-'. $serie .'-'. $numero.'.xml';
    $full_path_xml=$path . '/' .$filename_xml;

    try {
        $mail->AddAttachment($full_path_pdf, $filename_pdf);
        $mail->AddAttachment($full_path_xml, $filename_xml);
    } catch (phpmailerException $e) {
    }

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

    if (!$mail->send()){ $resultado="Error: " . $mail->ErrorInfo; }
    else {
        $xac=1;
        $tip=1;//1 email
        $oVentacorreo->insertar(
            $xac,
            $_SESSION['usuario_id'],
            $_POST['hdd_cli_id'],
            $_POST['hdd_ven_id'],
            $tip,
            $usu_ema,
            trim($_POST['txt_cli_ema']),
            trim($_POST['txt_cli_emacop']),
            trim($_POST['txt_cor_asu']),
            $body,
            $archivos
        );

        $resultado="Se ha enviado el mensaje.";
    }

    $data['ven_cor_msj']=$resultado;
    echo json_encode($data);

}//fin if
?>