<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();

if($_POST['alm_id']!="" and $_POST['doc_id']!="")
{

	$dts= $oTalonariointerno->correlativo_tra($_POST['alm_id'],$_POST['doc_id']);
	$num_rows= mysql_num_rows($dts);
	if($num_rows>0)
	{
		$dt = mysql_fetch_array($dts);
		$tal_id=$dt['tb_talonario_id'];
		$tal_ser=$dt['tb_talonario_ser'];
		$tal_num=$dt['tb_talonario_num'];
		$tal_fin=$dt['tb_talonario_fin'];
		mysql_free_result($dts);
		
		$numero=$tal_num+1;
		$largo=strlen($tal_fin);
		$correlativo=str_pad($numero,$largo, "0", STR_PAD_LEFT);
		$serie=$tal_ser;

		$numdoc=$serie.'-'.$correlativo;
		if($tal_ser!="")$data['numero']=$numdoc;
		$data['msj']='';
		
	}
	else
	{
		$data['numero']="";
		$data['msj']='Debe actualizar talonario.';
		//echo json_encode($data);
	}
}
else
{
	$data['numero']="";
	$data['msj']='';

}
echo json_encode($data);
?>