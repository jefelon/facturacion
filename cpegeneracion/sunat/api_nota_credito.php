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


$header[0]['idcomprobante']		=$_POST["tipo_de_comprobante"];//1FACTURA 3BOLETA 7NCREDITO 8NDEBITO
$header[0]['serie']				=$_POST['serie'];
$header[0]['numero']			=$_POST['numero'];

//$header[0]['fechadoc']			=$fechadoc;

$header[0]['identidad']			=$_POST['cliente_numero_de_documento'];
$header[0]['idtipodni']			=$_POST['cliente_tipo_de_documento'];
$header[0]['razon']				=$_POST['cliente_razon_social'];;

$header[0]['isomoneda']			=$_POST['tipo_de_moneda'];;

$header[0]['totopgra']			=$_POST['total_operaciones_gravadas'];
$header[0]['totopina']			=$_POST['total_operaciones_inafectas'];
$header[0]['totopexo']			=$_POST['total_operaciones_exoneradas'];
$header[0]['totopgrat']			=$_POST['total_operaciones_gratuitas'];
$header[0]['totdescto']			=$_POST['total_descuento'];
//sumatorias
$header[0]['totigv']			=$_POST['total_igv'];
$header[0]['totisc']			=$_POST['total_impuesto_selectivo_al_consumo'];
$header[0]['tototh']			=$_POST['total_otros_tributos'];//sumatoria otros tributos
$header[0]['desctoglobal']		=$_POST['descuento_global'];//descuentos globales
$header[0]['tototroca']			=$_POST['total_otros_cargos'];;//otros cargos
$header[0]['importetotal']		=$_POST['importe_total'];

//$header[0]['idtoperacion']		=$idtoperacion;//VENTA INTERNA

$header[0]['totanti']			=$_POST['total_anticipos'];//si es mayor a cero concidera
$header[0]['iddoctributario']	=$_POST['serie_y_numero_de_documento_que_se_realizo_el_anticipo'];;//CATALOGO 12
$header[0]['iddoctriref']		=$_POST['tipo_de_comprobante_que_se_realizo_el_anticipo'];

//$header[0]['nroplaca']			=$numpla;//placa

$header[0]['AdditionalProperty_Value']=$_POST['AdditionalProperty_Value'];

//NOTA CREDITO
$header[0]['issuedate']				=$_POST['fecha_de_generacion'];//fecha nota credito

$header[0]['referencedocumenttypecode']=$_POST['código_de_tipo_de_documento_de_referencia'];//ID DOCUMENT
$header[0]['referenceid']			=$_POST['referenceid'];//factura

$header[0]['idtiponotacredito']		=$_POST['tipo_de_nota_de_credito'];;//cat 09
$header[0]['description']			=$_POST['descripcion_motivo'];

$header = json_decode(json_encode($header));


//===============================================================================================
$autoin=0;

$detalle[$autoin]['idafectaciond']			=$_POST["tipo_de_afectacion"]; //10AFECTO 20EXONERADO 31BONO
$detalle[$autoin]['nro']					=$_POST["nro"];

$detalle[$autoin]['idmedida']				=$_POST["unidad_de_medida"];

$detalle[$autoin]['cantidad']				=$_POST["cantidad"];
$detalle[$autoin]['idproducto']				=$_POST["idproducto"];
$detalle[$autoin]['codigo']					=$_POST["codigo"];;
$detalle[$autoin]['detalle']				=$_POST["descripcion"];
$detalle[$autoin]['cdsc']					=$_POST["impuesto_selectivo_al_consumo"];

//$igv 										=$dt["tb_ventadetalle_igv"] / $dt["tb_ventadetalle_can"];
$detalle[$autoin]['precio']					=$_POST["valor_unitario"];
//oculto ya se calcula en base datos
//$detalle[$autoin]['valorref']				=($dt["tb_ventadetalle_valven"]+$dt["tb_ventadetalle_igv"])/$dt["tb_ventadetalle_can"];// precio de venta
$detalle[$autoin]['valorref']				=$_POST["precio_unitario"];

$detalle[$autoin]['igv']					=$_POST["igv"];//sumatoria con cantidad
$detalle[$autoin]['valorventa']				=$_POST["valor_de_venta"];//sumatoria con cantidad
$detalle[$autoin]['descto']					=$_POST["descuento"];

$detalle[$autoin]['idtiposcisc']			=$_POST["tipo_de_sistema_de_impuesto_selectivo_al_consumo"];
$detalle[$autoin]['isc']					=$_POST["impuesto_selectivo_al_consumo"];

$detalle = json_decode(json_encode($detalle));
//===============================================================================================

$r = run(datatoarray($header, $detalle, $empresa, 'CreditNote'), "../../cperepositorio/send/", "../../cperepositorio/cdr/", $nodo="", "CreditNote", true);

$data['tipo_de_comprobante'] = $_POST['tipo_de_comprobante'];
$data['serie'] = $_POST['serie'];
$data['numero'] = $_POST['numero'];
if ($r['faultcode']==0){
    $data['aceptado_por_sunat'] = true;
}else{
    $data['aceptado_por_sunat'] = false;
}
$data['sunat_responsecode'] = $r['faultcode'];
$data['digvalue'] = $r['digvalue'];
$data['signvalue'] = $r['signvalue'];
$data['valid'] = $r['valid'];
$data['cadena_para_codigo_qr'] = $_POST['ruc_empresa'].'|'.$_POST["tipo_de_comprobante"].'|'.$_POST['serie'].'|'.$_POST['numero'].'|'.$_POST['total_igv'].'|'.$_POST['importe_total'].'|'.$_POST['fecha_de_emision'].'|'.$_POST['cliente_tipo_de_documento'].'|'.$_POST['cliente_numero_de_documento'].'|';
$data['enlace_del_pdf'] = $d_dominio_app . 'cperepositorio/pdf/' . $nombre_archivo;
$data['enlace_del_cdr'] = $d_dominio_app . 'cperepositorio/cdr/'.'R-'. $_POST['empresa_ruc']."-".$_POST["tipo_de_comprobante"]."-".$_POST['serie']."-".$_POST['numero'].'.xml';
$data['enlace_del_xml'] = $d_dominio_app . 'cperepositorio/send/'.$_POST['empresa_ruc']."-".$_POST["tipo_de_comprobante"]."-".$_POST['serie']."-".$_POST['numero'].'.xml';
echo json_encode($data,JSON_UNESCAPED_SLASHES);
?>

