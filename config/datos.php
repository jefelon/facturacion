<?php
session_start();
$d_dominio="www.a-zetasoft.com";
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
$direccion = "CAL. OCTAVIO MUÑOZ NAJAR 223 OF. 238";
$subdivision = "URB. CERCADO";
$departamento = "AREQUIPA";
$provincia = "AREQUIPA";
$distrito = "CERCADO";
?>