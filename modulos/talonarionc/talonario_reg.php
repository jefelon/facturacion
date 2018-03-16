<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cTalonario.php");
$oTalonario = new cTalonario();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once ("../documento/cDocumento.php");
$oDocumento = new cDocumento();


if($_POST['action_talonario']=="insertar")
{
	$cst1 = $oTalonario->verifica_talonario($_POST['hdd_tal_id'],$_POST['cmb_punven_id'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est']);
	$rst1= mysql_num_rows($cst1);
	
	if($rst1>0)
	{
		//punto de venta
			$dts=$oPuntoventa->mostrarUno($_POST['cmb_punven_id']);
		$dt = mysql_fetch_array($dts);
			$punven_nom=$dt['tb_puntoventa_nom'];
			$alm_id=$dt['tb_almacen_id'];
		mysql_free_result($dts);
		
		//documento
			$dts=$oDocumento->mostrarUno($_POST['cmb_doc_id']);
		$dt = mysql_fetch_array($dts);
			$doc_tip=$dt['tb_documento_tip'];
			$doc_abr=$dt['tb_documento_abr'];
			$doc_nom=$dt['tb_documento_nom'];
			$doc_def=$dt['tb_documento_def'];
		mysql_free_result($dts);
	
		echo "No se puede agregar, existe Talonario ".$_POST['cmb_tal_est']." para $doc_nom de $punven_nom.";
	}
	else
	{
		if(!empty($_POST['cmb_doc_id']))
		{
			$oTalonario->insertar($_POST['txt_tal_ser'], $_POST['txt_tal_ini'],$_POST['txt_tal_fin'],$_POST['txt_tal_num'],$_POST['cmb_punven_id'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est'],$_SESSION['empresa_id']);
			echo 'Se registró talonario correctamente.';
		}
		else
		{
			echo 'Intentelo nuevamente.';
		}
	}
}

if($_POST['action_talonario']=="editar")
{
	$cst1 = $oTalonario->verifica_talonario($_POST['hdd_tal_id'],$_POST['cmb_punven_id'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est']);
	$rst1= mysql_num_rows($cst1);
	
	if($rst1>0)
	{
		//punto de venta
			$dts=$oPuntoventa->mostrarUno($_POST['cmb_punven_id']);
		$dt = mysql_fetch_array($dts);
			$punven_nom=$dt['tb_puntoventa_nom'];
			$alm_id=$dt['tb_almacen_id'];
		mysql_free_result($dts);
		
		//documento
			$dts=$oDocumento->mostrarUno($_POST['cmb_doc_id']);
		$dt = mysql_fetch_array($dts);
			$doc_tip=$dt['tb_documento_tip'];
			$doc_abr=$dt['tb_documento_abr'];
			$doc_nom=$dt['tb_documento_nom'];
			$doc_def=$dt['tb_documento_def'];
		mysql_free_result($dts);
	
		echo "No se puede modificar, existe Talonario ".$_POST['cmb_tal_est']." para $doc_nom de $punven_nom.";
	}
	else
	{
		if(!empty($_POST['cmb_doc_id']))
		{
			$oTalonario->modificar($_POST['hdd_tal_id'],$_POST['txt_tal_ser'], $_POST['txt_tal_ini'],$_POST['txt_tal_fin'],$_POST['txt_tal_num'],$_POST['cmb_punven_id'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est']);
			echo 'Se registró talonario correctamente.';
		}
		else
		{
			echo 'Intentelo nuevamente.';
		}
	}

}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
		$cst1 = $oTalonario->verifica_talonario_tabla($_POST['id'],'tb_talonario');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' Ventas';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			//$oTalonario->eliminar($_POST['id']);
			echo 'Se eliminó talonario correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>