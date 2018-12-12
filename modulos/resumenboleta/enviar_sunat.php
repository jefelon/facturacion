<?php 
require_once('../../cpegeneracion/sunat/funciones.php');
require_once('../../cpegeneracion/sunat/toarray.php');
require_once('../../cpegeneracion/sunat/toxml.php');
require_once('../../config/datos.php');


//EMPRESA
//$empresa[] = array();
$empresa[0]['certificado']			= $certificado;
$empresa[0]['clave_certificado']	= $clave_certificado;
$empresa[0]['usuario_sunat']		= $usuario_sunat ;
$empresa[0]['clave_sunat']			= $clave_sunat;
$empresa[0]['idempresa']			= $idempresa;
$empresa[0]['signature_id']			= $signature_id;
$empresa[0]['signature_id2']		= $signature_id2;
$empresa[0]['razon']				= $razon;
$empresa[0]['idtipodni']			= $idtipodni;
$empresa[0]['nomcomercial']			= $nomcomercial;
$empresa[0]['iddistrito']			= $iddistrito;
$empresa[0]['direccion']			= $direccion;
$empresa[0]['subdivision']			= $subdivision;
$empresa[0]['departamento']			= $departamento;
$empresa[0]['provincia']			= $provincia;
$empresa[0]['distrito']				= $distrito;

$empresa = json_decode(json_encode($empresa));

//================================================================================================
require_once ("../../config/Cado.php");
require_once ("../resumenboleta/cVenta.php");
$oVenta = new cVenta();

$id = $_POST['resbol_id'];

$dts = $oVenta->mostrarUno($id);
while($dt = mysql_fetch_array($dts))
{
	$fec 	=$dt["tb_resumenboleta_fec"];
	$fecref =$dt["tb_resumenboleta_fecref"];

	$cod 	=$dt["tb_resumenboleta_cod"];
}
mysql_free_result($dts);

$header[0]['issuedate']		=$fec;//GENERACION DEL RESUMEN
$header[0]['id']			=$cod;//resumen
$header[0]['referencedate']	=$fecref;//EMISION DOCUMENTOS

$header = json_decode(json_encode($header));

//===============================================================================================
$autoin=0;
$dts = $oVenta->listar_resumenboleta_detalle($id);
while($dt = mysql_fetch_array($dts))
{

	$detalle[$autoin]['nro']				=$dt["tb_resumenboletadetalle_num"];
	$detalle[$autoin]['idcomprobante']		=$dt["cs_tipodocumento_cod"];//cat01 01/03/07/08
	$detalle[$autoin]['serie']				=$dt["tb_resumenboletadetalle_ser"];
	$detalle[$autoin]['numero']				=$dt["tb_resumenboletadetalle_cor"];

	if($dt["tb_cliente_tip"]==1)$idtipodni=1;
	if($dt["tb_cliente_tip"]==2)$idtipodni=6;
	$detalle[$autoin]['identidad']			=$dt["tb_cliente_doc"];
	$detalle[$autoin]['idtipodni'] 			=$idtipodni;

	$detalle[$autoin]['conditioncode']		=$dt["tb_resumenboletadetalle_est"];

	$detalle[$autoin]['isomoneda']			="PEN";

	$detalle[$autoin]['importetotal']		=$dt["tb_resumenboletadetalle_imptot"];

	$detalle[$autoin]['totopgra']			=$dt["tb_resumenboletadetalle_opegra"];
	$detalle[$autoin]['totopexo']			=$dt["tb_resumenboletadetalle_opeexo"];
	$detalle[$autoin]['totopina']			=$dt["tb_resumenboletadetalle_opeina"];
	$detalle[$autoin]['tototroca']			=$dt["tb_resumenboletadetalle_otrcar"];
	$detalle[$autoin]['totisc']				=$dt["tb_resumenboletadetalle_isc"];
	$detalle[$autoin]['totigv']				=$dt["tb_resumenboletadetalle_igv"];
	
	$detalle[$autoin]['invoicedocumentreference']		=$dt["tb_resumenboletadetalle_docrelser"].'-'.$dt["tb_resumenboletadetalle_docrelcor"];
	$detalle[$autoin]['documenttypecode']				=$dt["tb_resumenboletadetalle_tipdocrel"];
	$autoin++;
}
mysql_free_result($dts);

$detalle = json_decode(json_encode($detalle));
//===============================================================================================

$r = run(datatoarray($header, $detalle, $empresa, 'SummaryDocuments'), "../../cperepositorio/send/", "../../cperepositorio/cdr/", $nodo="", "SummaryDocuments", true);

/*echo $r['faultcode'].'<br>';
echo $r['digvalue'].'<br>';
echo $r['signvalue'].'<br>';
echo $r['valid'].'<br>';*/

//var_dump($header);
//var_dump($detalle);
//$r['faultcode'] = 0;

if($r['faultcode']=='0')
{
	$data['msj']='Enviado Correctamente a SUNAT';
	$estado = 1;
}else{
	$data['msj']='Error: '.$r['faultcode'];
	$estado = 0;
}

$oVenta->actualizar_sunat($id,$r['ticket'],$r['faultcode'],$r['digvalue'],$r['signvalue'],$r['valid'],$estado);

echo json_encode($data);
?>