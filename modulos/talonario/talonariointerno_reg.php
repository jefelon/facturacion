<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cTalonariointerno.php");
$oTalonariointerno = new cTalonariointerno();


if($_POST['action_talonario']=="insertar")
{
	if($_POST['cmb_doc_id']==1)
	{
		$rst1=0;
		$cst1 = $oTalonariointerno->verifica_talonario_notven($_POST['hdd_tal_id'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est'],$_POST['cmb_punven_id'],$_SESSION['empresa_id']);
		$rst1= mysql_num_rows($cst1);
	}
	if($_POST['cmb_doc_id']==2 or $_POST['cmb_doc_id']==3)
	{
		$cst1 = $oTalonariointerno->verifica_talonario_tra($_POST['hdd_tal_id'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est'],$_POST['cmb_alm_id'],$_SESSION['empresa_id']);
		$rst1= mysql_num_rows($cst1);
	}
	
	if($rst1>0)
	{
		//documento
		if($_POST['cmb_doc_id']==1)$doc_nom = 'NOTA DE VENTA';
		if($_POST['cmb_doc_id']==2)$doc_nom = 'TRANSFERENCIA';
		if($_POST['cmb_doc_id']==3)$doc_nom = 'NOTA DE ALMACEN'; 
	
		echo "No se puede agregar, existe Talonario ".$_POST['cmb_tal_est']." para $doc_nom.";
	}
	else
	{
		if(!empty($_POST['cmb_doc_id']))
		{
			$oTalonariointerno->insertar($_POST['txt_tal_ser'], $_POST['txt_tal_ini'],$_POST['txt_tal_fin'],$_POST['txt_tal_num'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est'],$_POST['cmb_alm_id'],$_POST['cmb_punven_id'],$_SESSION['empresa_id']);
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
	if($_POST['cmb_doc_id']==1)
	{
		$rst1=0;
		$rst1=0;
		$cst1 = $oTalonariointerno->verifica_talonario_notven($_POST['hdd_tal_id'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est'],$_POST['cmb_punven_id'],$_SESSION['empresa_id']);
		$rst1= mysql_num_rows($cst1);
	}
	if($_POST['cmb_doc_id']==2)
	{
		$cst1 = $oTalonariointerno->verifica_talonario_tra($_POST['hdd_tal_id'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est'],$_POST['cmb_alm_id'],$_SESSION['empresa_id']);
		$rst1= mysql_num_rows($cst1);
	}
	
	if($_POST['cmb_doc_id']==3)
	{
		$cst1 = $oTalonariointerno->verifica_talonario_tra($_POST['hdd_tal_id'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est'],$_POST['cmb_alm_id'],$_SESSION['empresa_id']);
		$rst1= mysql_num_rows($cst1);
		$rst1=5;
	}
	
	if($rst1>0)
	{
		//documento
		if($_POST['cmb_doc_id']==1)$doc_nom = 'NOTA DE VENTA';
		if($_POST['cmb_doc_id']==2)$doc_nom = 'TRANSFERENCIA';
		if($_POST['cmb_doc_id']==3)$doc_nom = 'NOTA DE ALMACEN'; 
	
		if($_POST['cmb_doc_id']!=3)echo "No se puede modificar, existe Talonario ".$_POST['cmb_tal_est']." para $doc_nom.";
		if($_POST['cmb_doc_id']==3)echo 'No se puede modificar NOTA DE ALMACEN.';
	}
	else
	{
		if(!empty($_POST['cmb_doc_id']))
		{
			$oTalonariointerno->modificar($_POST['hdd_tal_id'],$_POST['txt_tal_ser'], $_POST['txt_tal_ini'],$_POST['txt_tal_fin'],$_POST['txt_tal_num'],$_POST['cmb_doc_id'],$_POST['cmb_tal_est'],$_POST['cmb_alm_id'],$_POST['cmb_punven_id']);
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
	if(!empty($_POST['tal_id']))
	{
		$cst1 = $oTalonariointerno->verifica_talonario_tabla($_POST['tal_id'],'tb_talonariointerno');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' Operaciones';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			//$oTalonariointerno->eliminar($_POST['tal_id']);
			echo 'Se eliminó talonario correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>