<?php
session_start();
require_once ("Cado.php");




//$d_dominio="www.aqpfact.pe.com";
//$d_dominio_app="www.ssdhosting.com.pe/facturacion/";
//$d_documentos_app="www.ssdhosting.com.pe/facturacion/recursos/venta/";
$d_dominio_app=$_SERVER['SERVER_NAME'];
$d_documentos_app=$_SERVER['SERVER_NAME']."/recursos/venta/";
$d_email_emp=$_SESSION['empresa_ema'];
$d_email_soporte="soporte@aqpfact.pe";
$d_resolucion="";

$certificado = "20601411076.pfx";
$clave_certificado = "20agosto2011";
$usuario_sunat = "20601411076MODDDATOS";
$clave_sunat = "MODDATOS";
$idempresa = $_SESSION['empresa_ruc'];
$signature_id = "SignAQPFACT_".$_SESSION['empresa_ruc'];
$signature_id2 = "IdSignAQPFACT_".$_SESSION['empresa_ruc'];
$razon = $_SESSION['empresa_razsoc'];
$idtipodni = "6";
$nomcomercial = $_SESSION['empresa_nomcom'];
$iddistrito = "040102";
$direccion = $_SESSION['empresa_dir'];
$subdivision = "URB. CERCADO";
$departamento = "AREQUIPA";
$provincia = "AREQUIPA";
$distrito = "CERCADO";

mysql_free_result($dts);
?>