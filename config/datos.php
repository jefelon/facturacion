<?php
session_start();
require_once ("../config/Cado.php");
require_once ("../modulos/empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
//
$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$d_dominio=$dt['tb_dominio'];
//$d_dominio_app="www.ssdhosting.com.pe/facturacion/";
//$d_documentos_app="www.ssdhosting.com.pe/facturacion/recursos/venta/";
$d_dominio_app=$dt['tb_dominio_app'];
$d_documentos_app=$dt['tb_documentos_app'];
$d_email_emp=$dt['tb_email_emp'];
$d_email_soporte=$dt['tb_email_soporte'];
$d_resolucion="";

$certificado = $dt['tb_certificado'];;
$clave_certificado = $dt['tb_clave_certificado'];;
$usuario_sunat = $dt['tb_usuario_sunat'];
$clave_sunat = $dt['tb_clave_sunat'];;
$idempresa = $dt['tb_idempresa'];
$signature_id = $dt['tb_firma1'];
$signature_id2 = $dt['tb_firma2'];
$razon = $dt['empresa_razsoc'];
$idtipodni = $dt['tb_idtipodni'];
$nomcomercial = $dt['tb_nomcomercial'];
$iddistrito = $dt['tb_iddistrito'];
$direccion = $dt['tb_direccion'];
$subdivision = $dt['tb_subdivision'];
$departamento = $dt['tb_departamento'];
$provincia = $dt['tb_provincia'];
$distrito = $dt['tb_distrito'];
?>