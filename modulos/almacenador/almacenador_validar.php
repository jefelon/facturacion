<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../usuarios/cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once("../horario/cHorario.php");
$oHorario = new cHorario();

require_once ("../formatos/formato.php");
require_once ("../formatos/operaciones.php");

//verificar punto de venta y horario
$dts=$oUsuario->mostrarUno($_SESSION['usuario_id']);
$dt = mysql_fetch_array($dts);
	$usugru		=$dt['tb_usuariogrupo_id'];
	$usugru_nom	=$dt['tb_usuariogrupo_nom'];
	$nom		=$dt['tb_usuario_nom'];
	$apepat		=$dt['tb_usuario_apepat'];
	$apemat		=$dt['tb_usuario_apemat'];
	$use		=$dt['tb_usuario_use'];
	$ema		=$dt['tb_usuario_ema'];

mysql_free_result($dts);

$dts=$oUsuariodetalle->mostrarUno($_SESSION['usuario_id']);
$dt = mysql_fetch_array($dts);

	$dni		=$dt['tb_usuario_dni'];
	$punven_id	=$dt['tb_puntoventa_id'];
	$hor_id		=$dt['tb_horario_id'];

	mysql_free_result($dts);
    //punto de venta
	$dts=$oPuntoventa->mostrarUno($punven_id);
	$dt = mysql_fetch_array($dts);
		$punven_nom=$dt['tb_puntoventa_nom'];
		$alm_id=$dt['tb_almacen_id'];
	mysql_free_result($dts);
	$_SESSION['puntoventa_id']=$punven_id;
	$_SESSION['puntoventa_nom']=$punven_nom;

    //	almacen
	$dts=$oAlmacen->mostrarUno($alm_id);
	$dt = mysql_fetch_array($dts);
		$alm_nom=$dt['tb_almacen_nom'];
		$alm_ven=$dt['tb_almacen_ven'];
	mysql_free_result($dts);
	$_SESSION['almacen_id']=$alm_id;
	$_SESSION['almacen_nom']=$alm_nom;



if($aut==1){
	$_SESSION["autentificado"]="NO";
	session_destroy();
	header("location: ../usuarios/acceso.php?mm=$mm");
	exit();
}
else
{
	header("location: ../almacenador/index.php");
}
?>