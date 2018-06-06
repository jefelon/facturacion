<?php
//require_once($_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/cpegeneracion/sunat/".'funciones.php');
require_once('../../cpegeneracion/sunat/funciones.php');
require_once('../../cpegeneracion/sunat/toarray.php');
require_once('../../cpegeneracion/sunat/toxml.php');
require_once('../../config/datos.php');
require_once ("../../modulos/formatos/formatos.php");

$_POST = json_decode(file_get_contents("php://input"), true);

////EMPRESA
//$empresa[] = array();
$empresa[0]['certificado']			= $_POST['empresa_certificado'];
$empresa[0]['clave_certificado']	= $_POST['empresa_clave_certificado'];
$empresa[0]['usuario_sunat']		= $_POST['empresa_usuario_sunat'];
$empresa[0]['clave_sunat']			= $_POST['empresa_clave_sunat'];
$empresa[0]['idempresa']			= $_POST['empresa_ruc'];
$empresa[0]['signature_id']			= $_POST['empresa_signature_id'];
$empresa[0]['signature_id2']		= $_POST['empresa_signature_id2'];
$empresa[0]['razon']				= $_POST['empresa_razon_social'];
$empresa[0]['idtipodni']			= $_POST['empresa_tipo_de_documento'];
$empresa[0]['nomcomercial']			= $_POST['empresa_nombre_comercial'];
$empresa[0]['iddistrito']			= $_POST['empresa_numero_de_distrito'];
$empresa[0]['direccion']			= $_POST['empresa_direccion'];
$empresa[0]['subdivision']			= $_POST['empresa_subdivision'];
$empresa[0]['departamento']			= $_POST['empresa_departamento'];
$empresa[0]['provincia']			= $_POST['empresa_provincia'];
$empresa[0]['distrito']				= $_POST['empresa_distrito'];

$empresa = json_decode(json_encode($empresa));

//================================================================================================
require_once ("../../config/Cado.php");
require_once ("../../modulos/venta/cVenta.php");
require_once ("../../modulos/formatos/numletras.php");

$header[0]['issuedate']		=$_POST['fecha_de_generacion'];//GENERACION DEL RESUMEN
$header[0]['id']			=$_POST['codigo_de_resumen'];//resumen
$header[0]['referencedate']	=$_POST['referencedate'];//EMISION DOCUMENTOS

$header = json_decode(json_encode($header));


//===============================================================================================
$autoin=0;

$dts = $_POST["items"];
foreach ($dts as $key => $dt)
{

    $detalle[$autoin]['nro']				=$dt["nro"];
    $detalle[$autoin]['idcomprobante']		=$dt["tipo_de_comprobante"];//cat01 01/03/07/08
    $detalle[$autoin]['serie']				=$dt["serie"];
    $detalle[$autoin]['numero']				=$dt["numero_de_documento"];

    $detalle[$autoin]['identidad']			=$dt["cliente_numero_de_documento"];
    $detalle[$autoin]['idtipodni'] 			=$dt["cliente_tipo_de_documento"];

    $detalle[$autoin]['conditioncode']		=$dt["conditioncode"];

    $detalle[$autoin]['isomoneda']			=$dt["tipo_de_moneda"];

    $detalle[$autoin]['importetotal']		=$dt["importe_total"];

    $detalle[$autoin]['totopgra']			=$dt["total_operaciones_gravadas"];
    $detalle[$autoin]['totopexo']			=$dt["total_operaciones_exoneradas"];
    $detalle[$autoin]['totopina']			=$dt["total_operaciones_inafectas"];
    $detalle[$autoin]['tototroca']			=$dt["total_otros_cargos"];
    $detalle[$autoin]['totisc']				=$dt["total_impuesto_selectivo_al_consumo"];
    $detalle[$autoin]['totigv']				=$dt["total_igv"];

    $detalle[$autoin]['invoicedocumentreference']		=$dt["invoicedocumentreference"];
    $detalle[$autoin]['documenttypecode']				=$dt["documenttypecode"];

    $autoin++;
}

mysql_free_result($dts);

$detalle = json_decode(json_encode($detalle));
//===============================================================================================
$r = run(datatoarray($header, $detalle, $empresa, 'SummaryDocuments'), "../../cperepositorio/send/", "../../cperepositorio/cdr/", $nodo="", "SummaryDocuments", true);


if ($r['faultcode']==0){
    $data['aceptado_por_sunat'] = true;
}else{
    $data['aceptado_por_sunat'] = false;
}
$data['$autoin'] = $autoin;
$data['sunat_responsecode'] = $r['faultcode'];
$data['fecha_de_generacion'] = $_POST['fecha_de_generacion'];
$data['digvalue'] = $r['digvalue'];
$data['signvalue'] = $r['signvalue'];
$data['valid'] = $r['valid'];

$data['enlace_del_cdr'] = $d_dominio_app . 'cperepositorio/cdr/'.$_POST['empresa_ruc'].'-'.$_POST['codigo_de_resumen'].'.xml';
$data['enlace_del_xml'] = $d_dominio_app . 'cperepositorio/send/'.$_POST['empresa_ruc'].'-'.$_POST['codigo_de_resumen'].'.xml';
echo json_encode($data,JSON_UNESCAPED_SLASHES);
?>
