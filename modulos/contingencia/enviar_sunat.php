<?php 
require_once('../../cpegeneracion/sunat/funciones.php');
require_once('../../cpegeneracion/sunat/toarray.php');
require_once('../../cpegeneracion/sunat/toxml.php');

//EMPRESA
//$empresa[] = array();
$empresa[0]['certificado']			="MPS20161024377100.pfx";
$empresa[0]['clave_certificado']	="9c96HxNhqRq0";

// $empresa[0]['usuario_sunat']		="20479676861MODDATOS";
// $empresa[0]['clave_sunat']			="moddatos";
$empresa[0]['usuario_sunat']		="20479676861EXCATUD2";
$empresa[0]['clave_sunat']			="GR676861";

$empresa[0]['idempresa']			="20479676861";
$empresa[0]['signature_id']			="SignGRANADOS_20479676861";
$empresa[0]['signature_id2']		="IdSignGRANADOS_20479676861";
$empresa[0]['razon']				="IMPORTACIONES Y DISTRIBUCIONES GRANADOS SRL";
$empresa[0]['idtipodni']			="6";
$empresa[0]['nomcomercial']			="IDIGRA SRL";
$empresa[0]['iddistrito']			="140105";
$empresa[0]['direccion']			="AV. AUGUSTO B. LEGUIA NRO. 1160";
$empresa[0]['subdivision']			="URB. SAN LORENZO";
$empresa[0]['departamento']			="LAMBAYEQUE";
$empresa[0]['provincia']			="CHICLAYO";
$empresa[0]['distrito']				="JOSE LEONARDO ORTIZ";

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
	$detalle[$autoin]['startdocumentnumberid']	=$dt["tb_resumenboletadetalle_ini"];
	$detalle[$autoin]['enddocumentnumberid'] 	=$dt["tb_resumenboletadetalle_fin"];

	$detalle[$autoin]['isomoneda']			="PEN";
	$detalle[$autoin]['totopgra']			=$dt["tb_resumenboletadetalle_opegra"];
	$detalle[$autoin]['totopexo']			=$dt["tb_resumenboletadetalle_opeexo"];
	$detalle[$autoin]['totopina']			=$dt["tb_resumenboletadetalle_opeina"];
	$detalle[$autoin]['tototroca']			=$dt["tb_resumenboletadetalle_otrcar"];
	$detalle[$autoin]['totisc']				=$dt["tb_resumenboletadetalle_isc"];
	$detalle[$autoin]['totigv']				=$dt["tb_resumenboletadetalle_igv"];
	$detalle[$autoin]['importetotal']		=$dt["tb_resumenboletadetalle_imptot"];

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