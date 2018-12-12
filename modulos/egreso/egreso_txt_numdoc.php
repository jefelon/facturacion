<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../talonario/cTalonario.php");
$oTalonario= new cTalonario();

$dts= $oTalonario->correlativo($_POST['doc_id']);
$num_rows= mysql_num_rows($dts);
if($num_rows>0)
{
		$dt = mysql_fetch_array($dts);
	$talser=$dt['tb_talonario_ser'];
	$talnum=$dt['tb_talonario_num'];
	$talfin=$dt['tb_talonario_fin'];
		mysql_free_result($dts);

	$largo=strlen($talfin);
	$talnum=str_pad($talnum,$largo, "0", STR_PAD_LEFT);
	
	if($talser!="")$data['correlativo']=$talser.'-'.$talnum;
	
	$data['msj']='';
	echo json_encode($data);
}
else
{
	$data['msj']='Debe actualizar talonario.';
	echo json_encode($data);
}
?>