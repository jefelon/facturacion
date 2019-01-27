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
	
	//almacen
	$dts=$oAlmacen->mostrarUno($alm_id);
	$dt = mysql_fetch_array($dts);
		$alm_nom=$dt['tb_almacen_nom'];
		$alm_ven=$dt['tb_almacen_ven'];
	mysql_free_result($dts);
	$_SESSION['almacen_id']=$alm_id;
	$_SESSION['almacen_nom']=$alm_nom;
	
	//horario
	$_SESSION['horario_id']=$hor_id;
	$dts= $oHorario->mostrarUno($hor_id);
	$dt = mysql_fetch_array($dts);
		$hor_nom	=$dt['tb_horario_nom'];
		$fecini	=mostrarFecha($dt['tb_horario_fecini']);
		$fecfin	=mostrarFecha($dt['tb_horario_fecfin']);
		$hor_est	=$dt['tb_horario_est'];
		
		$lun	=$dt['tb_horario_lun'];
		$mar	=$dt['tb_horario_mar'];
		$mie	=$dt['tb_horario_mie'];
		$jue	=$dt['tb_horario_jue'];
		$vie	=$dt['tb_horario_vie'];
		$sab	=$dt['tb_horario_sab'];
		$dom	=$dt['tb_horario_dom'];
		
		$horini1	=formato_hora($dt['tb_horario_horini1']);
		$horfin1	=formato_hora($dt['tb_horario_horfin1']);
		$horini2	=formato_hora($dt['tb_horario_horini2']);
		$horfin2	=formato_hora($dt['tb_horario_horfin2']);
	mysql_free_result($dts);

//acceso a ventas
if($punven_id==0){
	$aut=1;
	$mm.="No se asignó Punto de Venta. ";
}
if($hor_id==0){
	$aut=1;
	$valhor=1;
	$mm.="No se asignó Horario. ";
}

if($hor_est=='INACTIVO'){
	$aut=1;
	$valhor=1;
	$mm.="Horario inactivo! ";
}

if($valhor!=1)
{
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	$fecha_actual=date('d-m-Y');
	$dif1=restaFechas($fecha_actual, $fecini);
	$dif2=restaFechas($fecfin, $fecha_actual);
	
	if($dif1>0 or $dif2>0){
		$aut=1;
		$mm.="Fecha de validez de horario incorrecto! ";
	}
	
	$nombre_dia=nombre_dia($fecha_actual);
	
	if($nombre_dia=='Lunes' and $lun!=1){
		$aut=1;
		$mm.="Horario no le permite ingresar el día: $nombre_dia. ";
	}
	if($nombre_dia=='Martes' and $mar!=1){
		$aut=1;
		$mm.="Horario no le permite ingresar el día: $nombre_dia. ";
	}
	if($nombre_dia=='Miercoles' and $mie!=1){
		$aut=1;
		$mm.="Horario no le permite ingresar el día: $nombre_dia. ";
	}
	if($nombre_dia=='Jueves' and $jue!=1){
		$aut=1;
		$mm.="Horario no le permite ingresar el día: $nombre_dia. ";
	}
	if($nombre_dia=='Viernes' and $vie!=1){
		$aut=1;
		$mm.="Horario no le permite ingresar el día: $nombre_dia. ";
	}
	if($nombre_dia=='Sabado' and $sab!=1){
		$aut=1;
		$mm.="Horario no le permite ingresar el día: $nombre_dia. ";
	}
	if($nombre_dia=='Domingo' and $dom!=1){
		$aut=1;
		$mm.="Horario no le permite ingresar el día: $nombre_dia. ";
	}
	
	$hora_actual=date('H:i');
	$ha = strtotime($hora_actual);
	
	$hi1 = strtotime($horini1);
	$hf1 = strtotime($horfin1);
	$hi2 = strtotime($horini2);
	$hf2 = strtotime($horfin2);
	
	if(($ha>=$hi1 and $ha<$hf1) or ($ha>=$hi2 and $ha<$hf2) ){
	}
	else
	{
		$aut=1;
		$mm.="Se encuentra fuera de las horas permitida en su horario. ";
	}

}//fin valhor


if($aut==1){
	$_SESSION["autentificado"]="NO";
	session_destroy();
	header("location: ../usuarios/acceso.php?mm=$mm"); 
	exit();
}
else
{
    header("location: ../puntoventa/puntoventa_seleccionar.php");
}
?>