<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../talonario/cTalonario.php");
$oTalonario= new cTalonario();

$dts= $oTalonario->verifica_talonario_venta($_SESSION['puntoventa_id'],$_POST['doc_id'],$_POST['ven_est'],$_POST['numdoc']);
$num_rows= mysql_num_rows($dts);

if($num_rows>0)
{
		$dt = mysql_fetch_array($dts);
	$doc_nom=$dt['tb_documento_nom'];
		mysql_free_result($dts);
		
	$data['valor']='';
	$html='EXISTE REGISTRO PARA '.$doc_nom.' DE VENTA </br> N°: '.$_POST['numdoc'].' | Con Estado: '.$_POST['ven_est'].'</br></br>';
	$html.='<a target="_blank" title="" href="../talonario/">Modificar Talonario y Actualizar.</a>';
	
	$data['msj']=$html;
	echo json_encode($data);
}
else
{
	$data['valor']=1;
	$data['msj']='';
	echo json_encode($data);
}
//<a title="" href="../talonario/" onClick="$('#div_catalogo_venta').dialog('open')">Actualizar Talonario.</a>
?>