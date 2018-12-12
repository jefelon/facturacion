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

//VENTA
//$header = array();

//RESUMEN
$header[0]['issuedate']		="2016-12-12";//GENERACION DEL RESUMEN
$header[0]['id']			="RC-20161212-3";//resumen
$header[0]['referencedate']	="2016-12-12";//EMISION DOCUMENTOS

$header = json_decode(json_encode($header));



//resumen

$detalle[0]['nro']					="1";
$detalle[0]['idcomprobante']		="3";//cat01 03/07/08
$detalle[0]['serie']				="B001";
$detalle[0]['startdocumentnumberid']="28";
$detalle[0]['enddocumentnumberid']	="29";

$detalle[0]['isomoneda']			="PEN";
$detalle[0]['totopgra']				="334.74";
$detalle[0]['totopexo']				="0.00";
$detalle[0]['totopina']				="0.00";
$detalle[0]['tototroca']			="0.00";
$detalle[0]['totisc']				="0.00";
$detalle[0]['totigv']				="60.26";
$detalle[0]['importetotal']			="395.00";


$detalle = json_decode(json_encode($detalle));

//$r = run(datatoarray($header, $detalle, $empresa, 'SummaryDocuments'), "../../cperepositorio/send/", "../../cperepositorio/cdr/", $nodo="", "SummaryDocuments", true);


echo $r['faultcode'].'<br>';
echo $r['digvalue'].'<br>';
echo $r['signvalue'].'<br>';
echo $r['valid'].'<br>';
echo $r['ticket'].'<br>';

/*
0
3dSkkXvwZ64jgMFxkmGZbFjgIw0=
XeFNG3EiThELCkux2K7UlZxqrxFdw21+4gVkTkgMBcCe2X4c9FXAZISO318cNtUufR6HDIMfT1LAXtpZO2m4SQ16TN/6KxO5p8MMd8t7ehloAIOAmaOfXwUrzyYuKog5fQsmo4KwbVmOltldUdecdqq0W7vzSpSvcfWDxWj1nnFAAwh1IpPxFrCpKmxQbGfdR5Ak58emebz6HmppB8cqcROQpz7ahn1uJ6ijvxgHKV5CMFTxThBcHV0fxqlcL2NxOoP+G8iaHp1pkkW4vLr5ihoJNpU2yjhnqEBdV712B9zykjsv44uvt1lBLRrXEMVqX6YK7N6yMm7d6TJXZJ1cnA==
1
201600623682405*/
?>