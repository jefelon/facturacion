<?php
require_once('../../cpeconfig/datos.php');
require_once('funciones.php');
require_once('toarray.php');
require_once('toxml.php');

//EMPRESA
$empresa[0]['certificado']			=$cpe_certificado;
$empresa[0]['clave_certificado']	=$cpe_clave_certificado;

$empresa[0]['usuario_sunat']		=$cpe_usuario_sunat;
$empresa[0]['clave_sunat']			=$cpe_clave_sunat;

$empresa[0]['idempresa']			=$cpe_idempresa;
$empresa[0]['signature_id']			=$cpe_signature_id;
$empresa[0]['signature_id2']		=$cpe_signature_id2;
$empresa[0]['razon']				=$cpe_razon;
$empresa[0]['idtipodni']			=$cpe_idtipodni;
$empresa[0]['nomcomercial']			=$cpe_nomcomercial;
$empresa[0]['iddistrito']			=$cpe_iddistrito;
$empresa[0]['direccion']			=$cpe_direccion;
$empresa[0]['subdivision']			=$cpe_subdivision;
$empresa[0]['departamento']			=$cpe_departamento;
$empresa[0]['provincia']			=$cpe_provincia;
$empresa[0]['distrito']				=$cpe_distrito;

$empresa = json_decode(json_encode($empresa));

//VENTA
//$header = array();

$header[0]['idcomprobante']		="1";//1FACTURA 3BOLETA 7NCREDITO 8NDEBITO
$header[0]['serie']				="F001";
$header[0]['numero']			="34";

$header[0]['fechadoc']			="2016-10-18";

$header[0]['identidad']			="20488140001";
$header[0]['idtipodni']			="6";
$header[0]['razon']				="INTICAP SRL";

$header[0]['isomoneda']			="PEN";

$header[0]['totopgra']			="200.00";//total grav - dscto global
$header[0]['totopina']			="0.00";//total inaf - dscto global
$header[0]['totopexo']			="0.00";//total exon - dscto global
$header[0]['totopgrat']			="0.00";//total grat - dscto global
$header[0]['totdescto']			="0.00";//descto linea (o) + dscto global
//sumatorias
$header[0]['totigv']			="36.00";//tot ope grav *18%
$header[0]['totisc']			="0.00";
$header[0]['tototh']			="0.00";//sumatoria otros tributos
$header[0]['desctoglobal']		="0.00";//descuentos globales
$header[0]['tototroca']			="0.00";//otros cargos
$header[0]['importetotal']		="236.00";

$header[0]['idtoperacion']		="1";//VENTA INTERNA

$header[0]['totanti']			="0.00";//si es mayor a cero concidera
$header[0]['iddoctributario']	="";//CATALOGO 12
$header[0]['iddoctriref']		="";

$header[0]['AdditionalProperty_Value']="DOSCIENTOS TREINTA Y SEIS Y 00/100";

$header = json_decode(json_encode($header));


//DETALLE
//$detalle = array();

$detalle[0]['idafectaciond']	="10"; //10AFECTO 20EXONERADO 31BONO
$detalle[0]['nro']				="1";
$detalle[0]['idmedida']			="NIU";
$detalle[0]['cantidad']			="2";
$detalle[0]['idproducto']		="0";//catalogo_id //si es servicio 0
$detalle[0]['codigo']			="";//es el mismo idproducto
$detalle[0]['detalle']			=null;
$detalle[0]['cdsc']				="LLANTA BRIDGESTONE M01";

$detalle[0]['precio']			="100.00";//valor unitario
$detalle[0]['valorref']			="118.00";// precio unitario de venta //para items gratuitos es =

$detalle[0]['igv']				="36.00";
$detalle[0]['descto']			="0.00";
$detalle[0]['valorventa']		="200.00";//valor de venta=cantidad*valor unitario-descuento item


$detalle[0]['idtiposcisc']		="0";
$detalle[0]['isc']				="0.00";

$detalle = json_decode(json_encode($detalle));


//$r = run(datatoarray($header, $detalle, $empresa, 'Invoice'), $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/send/", $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/cdr/", $nodo="", "Invoice", true);

$enviar=true;
$r = run(datatoarray($header, $detalle, $empresa, 'Invoice'), "../../cperepositorio/send/", "../../cperepositorio/cdr/", $nodo="", "Invoice", $enviar);

echo $r['faultcode'].'<br>';
echo $r['digvalue'].'<br>';
echo $r['signvalue'].'<br>';
echo $r['valid'].'<br>';
?>