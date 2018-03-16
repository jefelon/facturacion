<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();

	$dts= $oTalonariointerno->correlativo_tra($_POST['alm_id'],$_POST['doc_id']);
	$num_rows= mysql_num_rows($dts);
if($num_rows>0)
{
		$dt = mysql_fetch_array($dts);
	$ser=$dt['tb_talonario_ser'];
	$num=$dt['tb_talonario_num'];
	$fin=$dt['tb_talonario_fin'];
		mysql_free_result($dts);
	$num=$num+1;
	$largo=strlen($fin);
	$num=str_pad($num,$largo, "0", STR_PAD_LEFT);
	
	if($ser!="")$data['numero']=$ser.'-'.$num;
	
	$data['msj']='';
	echo json_encode($data);
}
else
{
	$data['msj']='Debe actualizar talonario.';
	echo json_encode($data);
}
?>