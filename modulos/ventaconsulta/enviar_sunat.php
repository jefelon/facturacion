<?php 
/*require_once('../../facturasunat/sunat/funciones.php');
require_once('../../facturasunat/sunat/toarray.php');
require_once('../../facturasunat/sunat/toxml.php');*/

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

//================================================================================================
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/numletras.php");

$id = $_POST['ven_id'];
//$id = '11118';
$dts = $oVenta->mostrarUno($id);
while($dt = mysql_fetch_array($dts)){
	$ser=$dt["tb_venta_ser"];
	$num=$dt["tb_venta_num"];

	$identidad=$dt["tb_cliente_doc"];
	$razon=$dt["tb_cliente_nom"];
	$fechadoc=$dt["tb_venta_fec"];

	$toigv=$dt["tb_venta_igv"];
	$importetotal=$dt["tb_venta_tot"];
	$totopgra=$dt["tb_venta_valven"];
}

$AdditionalProperty_Value = numtoletras_2($importetotal);

$header[0]['idcomprobante']		="1";//1FACTURA 3BOLETA 7NCREDITO 8NDEBITO
$header[0]['serie']				=$ser;
$header[0]['numero']			=$num;

$header[0]['fechadoc']			=$fechadoc;

$header[0]['identidad']			=$identidad;
$header[0]['idtipodni']			="6";
$header[0]['razon']				=$razon;

$header[0]['isomoneda']			="PEN";

$header[0]['totopgra']			=$totopgra;
$header[0]['totopina']			="0.00";
$header[0]['totopexo']			="0.00";
$header[0]['totopgrat']			="0.00";
$header[0]['totdescto']			="0.00";//descto linea (o) + dscto global
//sumatorias
$header[0]['totigv']			=$toigv;
$header[0]['totisc']			="0.00";
$header[0]['tototh']			="0.00";//sumatoria otros tributos
$header[0]['desctoglobal']		="0.00";//descuentos globales
$header[0]['tototroca']			="0.00";//otros cargos
$header[0]['importetotal']		=$importetotal;

$header[0]['idtoperacion']		="1";//VENTA INTERNA

$header[0]['totanti']			="0.00";//si es mayor a cero concidera
$header[0]['iddoctributario']	="";//CATALOGO 12
$header[0]['iddoctriref']		="";

$header[0]['AdditionalProperty_Value']=$AdditionalProperty_Value;

$header = json_decode(json_encode($header));

//===============================================================================================
$dts = $oVenta->mostrar_venta_detalle_ps($id);
$autoin = 0;
while($dt = mysql_fetch_array($dts)){
	if($dt["tb_ventadetalle_tipven"]==1){
		$detalle[$autoin]['idafectaciond']			="10"; //10AFECTO 20EXONERADO 31BONO
		$detalle[$autoin]['nro']					=$autoin+1;
	
		$detalle[$autoin]['idmedida']				="NIU";

		$detalle[$autoin]['cantidad']				=$dt["tb_ventadetalle_can"];
		$detalle[$autoin]['idproducto']				=$dt["tb_catalogo_id"];
		$detalle[$autoin]['codigo']					=$dt["tb_catalogo_id"];
		$detalle[$autoin]['detalle']				=null;
		$detalle[$autoin]['cdsc']					=$dt["tb_producto_nom"];

		$IGV 										=$dt["tb_ventadetalle_igv"] / $dt["tb_ventadetalle_can"];
		$detalle[$autoin]['precio']					=$dt["tb_ventadetalle_preuni"];
		$detalle[$autoin]['valorref']				=($dt["tb_ventadetalle_valven"]+$dt["tb_ventadetalle_igv"])/$dt["tb_ventadetalle_can"];// precio de venta

		$detalle[$autoin]['igv']					=$dt["tb_ventadetalle_igv"];//sumatoria con cantidad
		$detalle[$autoin]['valorventa']				=$dt["tb_ventadetalle_valven"]+$dt["tb_ventadetalle_igv"];//sumatoria con cantidad
		$detalle[$autoin]['descto']					="0.00";

		$detalle[$autoin]['idtiposcisc']			="0";
		$detalle[$autoin]['isc']					="0.00";
	}else{
		$detalle[$autoin]['idafectaciond']			="10"; //10AFECTO 20EXONERADO 31BONO
		$detalle[$autoin]['nro']					=$autoin+1;
	
		$detalle[$autoin]['idmedida']				="ZZ";

		$detalle[$autoin]['cantidad']				=$dt["tb_ventadetalle_can"];
		$detalle[$autoin]['idproducto']				=$dt["tb_servicio_id"];
		$detalle[$autoin]['codigo']					=$dt["tb_servicio_id"];
		$detalle[$autoin]['detalle']				=null;
		$detalle[$autoin]['cdsc']					=$dt["tb_servicio_nom"];

		$IGV 										=$dt["tb_ventadetalle_preunilin"] / $dt["tb_ventadetalle_can"];
		$detalle[$autoin]['precio']					=$dt["tb_ventadetalle_preunilin"];
		$detalle[$autoin]['valorref']				=($dt["tb_ventadetalle_valven"]+$dt["tb_ventadetalle_igv"])/$dt["tb_ventadetalle_can"];// precio de venta

		$detalle[$autoin]['igv']					=$dt["tb_ventadetalle_igv"];//sumatoria con cantidad
		$detalle[$autoin]['valorventa']				=$dt["tb_ventadetalle_valven"]+$dt["tb_ventadetalle_igv"];//sumatoria con cantidad
		$detalle[$autoin]['descto']					="0.00";

		$detalle[$autoin]['idtiposcisc']			="0";
		$detalle[$autoin]['isc']					="0.00";
	}
	$autoin++;
}

$detalle = json_decode(json_encode($detalle));
//===============================================================================================

/*$r = run(datatoarray($header, $detalle, $empresa, 'Invoice'), $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/send/", $_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/facturasunat/sunat/cdr/", $nodo="", "Invoice", true);

echo $r['faultcode'].'<br>';
echo $r['digvalue'].'<br>';
echo $r['signvalue'].'<br>';
echo $r['valid'].'<br>';*/

//var_dump($header);
//var_dump($detalle);
$data['msj']='esto es una prueba '.$id;
echo json_encode($data);

?>