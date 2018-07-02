<?php
require_once('../../config/datos.php');
function responder($estado=false, $mensaje='', $datos=[])
{
	header('Content-Type: application/json');
	echo json_encode([
		'est' => $estado,
		'msj' => $mensaje,
		'dat' => $datos,
	]);
	exit;
}

require_once('../../cpegeneracion/sunat/funciones.php');
require_once('../../cpegeneracion/sunat/toarray.php');
require_once('../../cpegeneracion/sunat/toxml.php');

require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();

	$id=$_POST['id'];
	$ticket=$_POST['ticket'];

	if($ticket=="")responder(false, 'Valor Ticket vacío.',[]);


	$file = "none";
	$arr = array('usuario_sunat' => $cpe_usuario_sunat, 'clave_sunat' => $cpe_clave_sunat);

	$res = send_sunat($file, $ticket, $arr, "../../cperepositorio/cdr/", "getStatus","");
	
	if($res=='0')
	{
		$msj.=" ACEPTADO";
		$estado_envsun2=1;
		$estado=true;
	}
	elseif($res=='98')
	{
		$msj.=" EN PROCESO.";
		$estado_envsun2=1;
		$estado='';
	}
	elseif($res=='99')
	{
		$msj.=" PROCESO CON ERRORES.";
		$estado_envsun2=1;
		$estado='';
	}
	else
	{
		$msj.=" CODE: ".$res;
		$estado_envsun2=0;
		$estado=false;
	}


	$dts = $oVenta->mostrarUno($id);
	while($dt = mysqli_fetch_array($dts))
	{
		$faucod2 	=$dt["tb_resumenboleta_faucod2"];
	}
	mysqli_free_result($dts);


	//if($faucod2!="0")
	//{
		$oVenta->actualizar_sunat2($id,$res,$estado_envsun2);
	//}
	
	
	responder($estado, $msj, $data);
?>