<?php 
require_once('funciones.php');
require_once('toarray.php');
require_once('toxml.php');

//EMPRESA
//$empresa[] = array();
$empresa[0]['certificado']			="MPS20161024377100.pfx";
$empresa[0]['clave_certificado']	="9c96HxNhqRq0";

// $empresa[0]['usuario_sunat']		="20479676861MODDATOS";
// $empresa[0]['clave_sunat']			="moddatos";
$empresa[0]['usuario_sunat']		="20479676861EXCATUD1";
$empresa[0]['clave_sunat']			="GRANAD204796";

$empresa[0]['idempresa']			="20479676861";
$empresa[0]['signature_id']			="SignGRANADOS";
$empresa[0]['signature_id2']		="IdSignGRANADOS";
$empresa[0]['razon']				="IMPORTACIONES Y DISTRIBUCIONES GRANADOS SRL";
$empresa[0]['idtipodni']			="6";
$empresa[0]['nomcomercial']			="IDIGRA SRL";
$empresa[0]['iddistrito']			="140105";
$empresa[0]['direccion']			="AV. AUGUSTO B. LEGUIA NRO. 1160";
$empresa[0]['subdivision']			="URB. SAN LORENZO";
$empresa[0]['departamento']			="LAMBAYEQUE";
$empresa[0]['provincia']			="JOSE LEONARDO ORTIZ";
$empresa[0]['distrito']				="JOSE LEONARDO ORTIZ";

$empresa = json_decode(json_encode($empresa));

//VENTA
//$header = array();

//RESUMEN
$header[0]['issuedate']		="2016-11-07";//GENERACION DEL RESUMEN
$header[0]['id']			="RC-20161107-1";//resumen
$header[0]['referencedate']	="2016-11-07";//EMISION DOCUMENTOS

$header = json_decode(json_encode($header));



//resumen

$detalle[0]['nro']					="1";
$detalle[0]['idcomprobante']		="3";//cat01 03/07/08
$detalle[0]['serie']				="B002";
$detalle[0]['startdocumentnumberid']="1";
$detalle[0]['enddocumentnumberid']	="3";

$detalle[0]['isomoneda']			="PEN";
$detalle[0]['totopgra']				="4932.21";
$detalle[0]['totopexo']				="0.00";
$detalle[0]['totopina']				="0.00";
$detalle[0]['tototroca']			="0.00";
$detalle[0]['totisc']				="0.00";
$detalle[0]['totigv']				="887.79";
$detalle[0]['importetotal']			="5820.00";

/*
$detalle[1]['nro']					="1";
$detalle[1]['idcomprobante']		="3";//cat01 03/07/08
$detalle[1]['serie']				="B001";
$detalle[1]['startdocumentnumberid']="3";
$detalle[1]['enddocumentnumberid']	="5";

$detalle[1]['isomoneda']			="PEN";
$detalle[1]['totopgra']				="354.00";
$detalle[1]['totopexo']				="0.00";
$detalle[1]['totopina']				="0.00";
$detalle[1]['tototroca']			="0.00";
$detalle[1]['totisc']				="0.00";
$detalle[1]['totigv']				="54.00";
$detalle[1]['importetotal']			="354.00";


$detalle[2]['nro']					="1";
$detalle[2]['idcomprobante']		="3";//cat01 03/07/08
$detalle[2]['serie']				="B001";
$detalle[2]['startdocumentnumberid']="3";
$detalle[2]['enddocumentnumberid']	="5";

$detalle[2]['isomoneda']			="PEN";
$detalle[2]['totopgra']				="354.00";
$detalle[2]['totopexo']				="0.00";
$detalle[2]['totopina']				="0.00";
$detalle[2]['tototroca']			="0.00";
$detalle[2]['totisc']				="0.00";
$detalle[2]['totigv']				="54.00";
$detalle[2]['importetotal']			="354.00";


$detalle[3]['nro']					="1";
$detalle[3]['idcomprobante']		="3";//cat01 03/07/08
$detalle[3]['serie']				="B001";
$detalle[3]['startdocumentnumberid']="3";
$detalle[3]['enddocumentnumberid']	="5";

$detalle[3]['isomoneda']			="PEN";
$detalle[3]['totopgra']				="354.00";
$detalle[3]['totopexo']				="0.00";
$detalle[3]['totopina']				="0.00";
$detalle[3]['tototroca']			="0.00";
$detalle[3]['totisc']				="0.00";
$detalle[3]['totigv']				="54.00";
$detalle[3]['importetotal']			="354.00";


$detalle[4]['nro']					="1";
$detalle[4]['idcomprobante']		="3";//cat01 03/07/08
$detalle[4]['serie']				="B001";
$detalle[4]['startdocumentnumberid']="3";
$detalle[4]['enddocumentnumberid']	="5";

$detalle[4]['isomoneda']			="PEN";
$detalle[4]['totopgra']				="354.00";
$detalle[4]['totopexo']				="0.00";
$detalle[4]['totopina']				="0.00";
$detalle[4]['tototroca']			="0.00";
$detalle[4]['totisc']				="0.00";
$detalle[4]['totigv']				="54.00";
$detalle[4]['importetotal']			="354.00";*/



$detalle = json_decode(json_encode($detalle));


$r = run(datatoarray($header, $detalle, $empresa, 'SummaryDocuments'), $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/send/", $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/cdr/", $nodo="", "SummaryDocuments", true);


echo $r['faultcode'].'<br>';
echo $r['digvalue'].'<br>';
echo $r['signvalue'].'<br>';
echo $r['valid'].'<br>';
echo $r['ticket'].'<br>';

/*

?>