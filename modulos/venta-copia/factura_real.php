<?php 
require_once('../../cpegeneracion/sunat/funciones.php');
require_once('../../cpegeneracion/sunat/toarray.php');
require_once('../../cpegeneracion/sunat/toxml.php');
require_once ("../formatos/numletras.php");


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
$header[0]['idcomprobante']		="3";//1FACTURA 3BOLETA 7NCREDITO 8NDEBITO
$header[0]['serie']				="B001";
$header[0]['numero']			="00000001";

$header[0]['fechadoc']			="2016-11-28";

$header[0]['identidad']			="17633467";
$header[0]['idtipodni']			="1";
$header[0]['razon']				="OSBER MONTEZA BENAVIDES";

$header[0]['isomoneda']			="PEN";

$header[0]['totopgra']			="182.20";//total grav - dscto global
$header[0]['totopina']			="0.00";//total inaf - dscto global
$header[0]['totopexo']			="0.00";//total exon - dscto global
$header[0]['totopgrat']			="0.00";//total grat - dscto global
$header[0]['totdescto']			="0.00";//descto linea (o) + dscto global
//sumatorias
$header[0]['totigv']			="32.80";//tot ope grav *18%
$header[0]['totisc']			="0.00";
$header[0]['tototh']			="0.00";//sumatoria otros tributos
$header[0]['desctoglobal']		="0.00";//descuentos globales
$header[0]['tototroca']			="0.00";//otros cargos
$header[0]['importetotal']		="215.00";

$header[0]['idtoperacion']		="1";//VENTA INTERNA

$header[0]['totanti']			="0.00";//si es mayor a cero concidera
$header[0]['iddoctributario']	="";//CATALOGO 12
$header[0]['iddoctriref']		="";

$header[0]['AdditionalProperty_Value']=numtoletras_2(215.00);

$header = json_decode(json_encode($header));


// //DETALLE

$detalle[0]['idafectaciond']	="10"; //10AFECTO 20EXONERADO 31BONO
$detalle[0]['nro']				="1";
$detalle[0]['idmedida']			="NIU";
$detalle[0]['cantidad']			="1";
$detalle[0]['idproducto']		="0";
$detalle[0]['codigo']			="";
$detalle[0]['detalle']			=null;
$detalle[0]['cdsc']				="LLANTA 195R15C MR-100 MIRAGE 106/104R CH";

$detalle[0]['precio']			="182.20";//valor unitario
$detalle[0]['valorref']			="215.00";// precio unitario de venta //para items gratuitos es =

$detalle[0]['igv']				="32.80";
$detalle[0]['descto']			="0.00";
$detalle[0]['valorventa']		="182.20";//valor de venta por item=cantidad*valor unitario

$detalle[0]['idtiposcisc']		="0";
$detalle[0]['isc']				="0.00";


$detalle = json_decode(json_encode($detalle));

//$r = run(datatoarray($header, $detalle, $empresa, 'Invoice'), "../../cperepositorio/send/", "../../cperepositorio/cdr/", $nodo="", "Invoice", true);

 echo $r['faultcode'].'<br>';
 echo $r['digvalue'].'<br>';
 echo $r['signvalue'].'<br>';
 echo $r['valid'].'<br>';

 //var_dump($res);
 //var_dump($header);
 //var_dump($detalle);

/*
0
D5HlgGT9HZzxjnwbG0J+0Z1J4zE=
E4Bh0SUv/s8idn1z4uueh+HO+6xFaLRquLY15MqRqSEH4nIDl2LcLU8Pnts/cyuJIEtcroMZVpBTWCnnVMuHZqA7D8C9w9I66WYG119GCUA5wxi3/YP195gV9OfoSKtM3pUrwEDpgNi8zcf2hGZqlsmEIoJEa663dZ0ZZwKPEwO8rkl0hUYPe+uxAMVep82UFClBO2daOsXkTnVum0fuBLjcYwtcStPd9TCTT3MMOlD6IVUVrIlZSkJjnYGwl1HDouyB8V/n224pr7c12Be+5AWrBXEZYy6biXWXGU+RmXYKZUpH+2SUqYzcgMkR8nMK86a1vFhffZa3OacVITyuWQ==
1*/
?>