<?php
session_start();
$d_dominio="www.a-zetasoft.com";
$d_dominio_app=$_SERVER['SERVER_NAME'];
$d_documentos_app=$_SERVER['SERVER_NAME']."/recursos/venta/";
$d_email_emp=$_SESSION['empresa_ema'];
$d_email_soporte="soporte@aqpfact.pe";
$d_resolucion="";

$certificado = $_SESSION['empresa_certificado'];
$clave_certificado = $_SESSION['empresa_clave_certificado'];
$usuario_sunat = $_SESSION['empresa_ruc'].$_SESSION['empresa_usuario_sunat'];
$clave_sunat = $_SESSION['empresa_clave_sunat'];
$idempresa = $_SESSION['empresa_ruc'];
$signature_id = "SignAQPFACT_".$_SESSION['empresa_ruc'];
$signature_id2 = "IdSignAQPFACT_".$_SESSION['empresa_ruc'];
$razon = $_SESSION['empresa_razsoc'];
$idtipodni = "6";
$nomcomercial = $_SESSION['empresa_nomcom'];
$iddistrito = $_SESSION['empresa_iddistrito'];
$direccion = $_SESSION['empresa_direccion'];
$subdivision = $_SESSION['empresa_subdivision'];
$departamento = $_SESSION['empresa_departamento'];
$provincia = $_SESSION['empresa_provincia'];
$distrito = $_SESSION['empresa_distrito'];
?>