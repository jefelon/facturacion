<?php
require_once ("../../config/Cado.php");
require_once("cDocumento.php");
$oDocumento = new cDocumento();

if($_POST['action_documento']=="insertar")
{
	if(!empty($_POST['txt_doc_nom']))
	{
		$xac=1;
		$oDocumento->insertar($xac,$_POST['txt_doc_abr'], $_POST['txt_doc_nom'], $_POST['cmb_doc_tip'],$_POST['chk_doc_def']);
		echo 'Se registró documento correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_documento']=="editar")
{
	if(!empty($_POST['txt_doc_nom']))
	{
		$oDocumento->modificar($_POST['hdd_doc_id'],$_POST['txt_doc_abr'],$_POST['txt_doc_nom'], $_POST['cmb_doc_tip'],$_POST['chk_doc_def'],$_POST['chk_doc_mos']);
		echo 'Se registró documento correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
		$cst1 = $oDocumento->verifica_documento_tabla($_POST['id'],'tb_compra');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Compras';
		
		$cst2 = $oDocumento->verifica_documento_tabla($_POST['id'],'tb_venta');
		$rst2= mysql_num_rows($cst2);
		if($rst2>0)$msj2=' - Ventas';
		
		if($rst1>0 or $rst2>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.".";
		}
		else
		{
			$oDocumento->eliminar($_POST['id']);
			echo 'Se eliminó documento correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>