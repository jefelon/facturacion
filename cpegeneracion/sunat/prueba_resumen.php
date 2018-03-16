<?php 
require_once('funciones.php');
require_once('toarray.php');
require_once('toxml.php');

//EMPRESA
//$empresa[] = array();
$empresa[0]['certificado']			="DEMO-20479676861.pfx";
$empresa[0]['clave_certificado']	="123456789";
$empresa[0]['usuario_sunat']		="20479676861MODDATOS";
$empresa[0]['clave_sunat']			="moddatos";
$empresa[0]['idempresa']			="20479676861";
$empresa[0]['signature_id']			="SignGRANADOS";
$empresa[0]['signature_id2']		="IdSignGRANADOS";
$empresa[0]['razon']				="IMPORTACIONES Y DISTRIBUCIONES GRANADOS SRL";
$empresa[0]['idtipodni']			="6";
$empresa[0]['nomcomercial']			="IDIGRA SRL";
$empresa[0]['iddistrito']			="140101";
$empresa[0]['direccion']			="AV. AUGUSTO B. LEGUIA NRO. 1160";
$empresa[0]['subdivision']			="URB. SAN LORENZO";
$empresa[0]['departamento']			="LAMBAYEQUE";
$empresa[0]['provincia']			="JOSE LEONARDO ORTIZ";
$empresa[0]['distrito']				="JOSE LEONARDO ORTIZ";

$empresa = json_decode(json_encode($empresa));

//VENTA
//$header = array();

//RESUMEN
$header[0]['issuedate']		="2016-10-19";//GENERACION DEL RESUMEN
$header[0]['id']			="RC-20161019-2";//resumen
$header[0]['referencedate']	="2016-10-19";//EMISION DOCUMENTOS

$header = json_decode(json_encode($header));



//resumen

$detalle[0]['nro']					="1";

$detalle[0]['idcomprobante']		="3";//cat01 03/07/08
$detalle[0]['serie']				="B001";
$detalle[0]['startdocumentnumberid']="3";
$detalle[0]['enddocumentnumberid']	="5";

$detalle[0]['importetotal']			="354.00";
$detalle[0]['isomoneda']			="PEN";

$detalle[0]['totopgra']				="354.00";
$detalle[0]['totopexo']				="0.00";
$detalle[0]['totopina']				="0.00";
$detalle[0]['tototroca']			="0.00";
$detalle[0]['totisc']				="0.00";
$detalle[0]['totigv']				="54.00";

//$detalle[0]['lineid']="1";
//$detalle[0]['numdoc']=$numdoc;
//$detalle[0]['voidreasondescription']=$voidreasondescription;

$detalle = json_decode(json_encode($detalle));

//NOTA CREDITO Y DEBITO
// $header[0]['issuedate']		="2016-10-18";
// $header[0]['referenceid']			="";
// $header[0]['idtiponotacredito']	="";
// $header[0]['description']			="";
// $header[0]['referencedocumenttypecode']="";


//DETALLE
//$detalle = array();

// $detalle[0]['idafectaciond']	="10"; //10AFECTO 20EXONERADO 31BONO
// $detalle[0]['nro']				="1";
// $detalle[0]['idmedida']			="NIU";
// $detalle[0]['cantidad']			="2";
// $detalle[0]['idproducto']		="123";
// $detalle[0]['codigo']			="123";
// $detalle[0]['detalle']			=null;
// $detalle[0]['cdsc']				="LLANTA BRIDGESTONE M01";

// $detalle[0]['precio']			="118.00";
// $detalle[0]['valorref']			="100.00";// si tiene igv es el precio sin igv //para items gratuitos

// $detalle[0]['igv']				="36.00";
// $detalle[0]['valorventa']		="200.00";
// $detalle[0]['descto']			="0.00";

// $detalle[0]['idtiposcisc']		="0";
// $detalle[0]['isc']				="0.00";



//echo count($detalle);

// foreach ($detalle as $row => $item) {
// 	//echo $item->idafectaciond;
// 	echo $item->cdsc;
// }
//var_dump($detalle);


//echo $_SERVER['DOCUMENT_ROOT'];

$r = run(datatoarray($header, $detalle, $empresa, 'SummaryDocuments'), $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/send/", $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/cdr/", $nodo="", "SummaryDocuments", true);

//$r = run(datatoarray($venta, $detalle, $empresa, 'Invoice'), $_SERVER['DOCUMENT_ROOT'] ."sunat/send/", $_SERVER['DOCUMENT_ROOT'] ."sunat/cdr/", $nodo="", "Invoice", true);

//$post = array('ventaid' => $vidventa, 'faultcode' => $r['faultcode'], 'digestvalue' => $r['digvalue'], 'signaturevalue' => $r['signvalue'], 'valid' => $r['valid'], 'update' => 'true');

echo $r['faultcode'].'<br>';
echo $r['digvalue'].'<br>';
echo $r['signvalue'].'<br>';
echo $r['valid'].'<br>';
echo $r['ticket'].'<br>';
?>