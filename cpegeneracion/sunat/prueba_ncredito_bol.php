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

$header[0]['idcomprobante']		="7";//1FACTURA 3BOLETA 7NCREDITO 8NDEBITO
$header[0]['serie']				="B001";
$header[0]['numero']			="1";

$header[0]['fechadoc']			="2016-10-19";

$header[0]['identidad']			="70051387";
$header[0]['idtipodni']			="1";
$header[0]['razon']				="CARLOS ALBERTO PEREZ PEREZ";

$header[0]['isomoneda']			="PEN";

$header[0]['totopgra']			="236.00";
$header[0]['totopina']			="0.00";
$header[0]['totopexo']			="0.00";
$header[0]['totopgrat']			="0.00";
$header[0]['totdescto']			="0.00";//descto linea (o) + dscto global
//sumatorias
$header[0]['totigv']			="36.00";
$header[0]['totisc']			="0.00";
$header[0]['tototh']			="0.00";//sumatoria otros tributos
$header[0]['desctoglobal']		="0.00";//descuentos globales
$header[0]['tototroca']			="0.00";//otros cargos
$header[0]['importetotal']		="236.00";

$header[0]['idtoperacion']		="1";//VENTA INTERNA

$header[0]['totanti']			="0.00";//si es mayor a cero concidera
$header[0]['iddoctributario']	="";//CATALOGO 12
$header[0]['iddoctriref']		="";

//$header[0]['AdditionalProperty_Value']="DOSCIENTOS TREINTA Y SEIS Y 00/100";

//NOTA CREDITO Y DEBITO
$header[0]['issuedate']				="2016-10-19";

$header[0]['referencedocumenttypecode']="3";
$header[0]['referenceid']			="B001-2";//factura

$header[0]['idtiponotacredito']		="7";//cat 09
$header[0]['description']			="PRODUCTO DEFECTUOSO";


$header = json_decode(json_encode($header));

//NOTA CREDITO Y DEBITO
// $header[0]['issuedate']		="2016-10-18";
// $header[0]['referenceid']			="";
// $header[0]['idtiponotacredito']	="";
// $header[0]['description']			="";
// $header[0]['referencedocumenttypecode']="";


//RESUMEN Y BAJA
//$header[0]['referencedate']	="";

//DETALLE
//$detalle = array();

$detalle[0]['idafectaciond']	="10"; //10AFECTO 20EXONERADO 31BONO
$detalle[0]['nro']				="1";
$detalle[0]['idmedida']			="NIU";
$detalle[0]['cantidad']			="2";
$detalle[0]['idproducto']		="123";
$detalle[0]['codigo']			="123";
$detalle[0]['detalle']			=null;
$detalle[0]['cdsc']				="LLANTA BRIDGESTONE M01";

$detalle[0]['precio']			="118.00";
$detalle[0]['valorref']			="100.00";// si tiene igv es el precio sin igv //para items gratuitos

$detalle[0]['igv']				="36.00";
$detalle[0]['valorventa']		="200.00";
$detalle[0]['descto']			="0.00";

$detalle[0]['idtiposcisc']		="0";
$detalle[0]['isc']				="0.00";

$detalle = json_decode(json_encode($detalle));

//echo count($detalle);

// foreach ($detalle as $row => $item) {
// 	//echo $item->idafectaciond;
// 	echo $item->cdsc;
// }
//var_dump($detalle);


//resumen
// $header[0]['id']="id";//resumen
// $detalle[0]['nro']=$nro;
// $detalle[0]['lineid']=$lineid;
// $detalle[0]['idcomprobante']=$idcomprobante;
// $detalle[0]['serie']=$serie;
// $detalle[0]['numdoc']=$numdoc;
// $detalle[0]['voidreasondescription']=$voidreasondescription;

// $detalle[0]['startdocumentnumberid']=$startdocumentnumberid;
// $detalle[0]['enddocumentnumberid']=$enddocumentnumberid;
// $detalle[0]['importetotal']=$importetotal;
// $detalle[0]['isomoneda']=$isomoneda;
// $detalle[0]['totopgra']=$totopgra;
// $detalle[0]['totopexo']=$totopexo;
// $detalle[0]['totopina']=$totopina;
// $detalle[0]['tototroca']=$tototroca;
// $detalle[0]['totisc']=$totisc;
// $detalle[0]['totigv']=$totigv;

//echo $_SERVER['DOCUMENT_ROOT'];

$r = run(datatoarray($header, $detalle, $empresa, 'CreditNote'), $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/send/", $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/cdr/", $nodo="", "CreditNote", true);

//$r = run(datatoarray($venta, $detalle, $empresa, 'Invoice'), $_SERVER['DOCUMENT_ROOT'] ."sunat/send/", $_SERVER['DOCUMENT_ROOT'] ."sunat/cdr/", $nodo="", "Invoice", true);

//$post = array('ventaid' => $vidventa, 'faultcode' => $r['faultcode'], 'digestvalue' => $r['digvalue'], 'signaturevalue' => $r['signvalue'], 'valid' => $r['valid'], 'update' => 'true');

echo $r['faultcode'].'<br>';
echo $r['digvalue'].'<br>';
echo $r['signvalue'].'<br>';
echo $r['valid'].'<br>';
?>