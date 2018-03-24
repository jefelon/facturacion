<?php 
//require_once($_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/cpegeneracion/sunat/".'funciones.php');
require_once('../../cpegeneracion/sunat/funciones.php');
require_once('../../cpegeneracion/sunat/toarray.php');
require_once('../../cpegeneracion/sunat/toxml.php');
require_once('../../config/datos.php');

//EMPRESA
//$empresa[] = array();
 $empresa[0]['certificado']			= "ECIMPORT.pfx";
 $empresa[0]['clave_certificado']	= "3C1m9OR7=!";
$empresa[0]['usuario_sunat']		="20434814953USER3454 ";
$empresa[0]['clave_sunat']			="ER35645f";
$empresa[0]['idempresa']			= $idempresa;
$empresa[0]['signature_id']			= $signature_id;
$empresa[0]['signature_id2']		= $signature_id2;
$empresa[0]['razon']				= $razon;
$empresa[0]['idtipodni']			= $idtipodni;
$empresa[0]['nomcomercial']			= $nomcomercial;
$empresa[0]['iddistrito']			= $iddistrito;
$empresa[0]['direccion']			= $direccion;
$empresa[0]['subdivision']			= $subdivision;
$empresa[0]['departamento']			= $departamento;
$empresa[0]['provincia']			= $provincia;
$empresa[0]['distrito']				= $distrito;

$empresa = json_decode(json_encode($empresa));

//================================================================================================
require_once ("../../config/Cado.php");
require_once ("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();
require_once ("../formatos/numletras.php");

$ven_id=$_POST['ven_id'];

$dts = $oCotizacion->mostrarUno($ven_id);
while($dt = mysql_fetch_array($dts)){
	
	$idcomprobante=$dt["cs_tipodocumento_cod"];

	$ser=$dt["tb_venta_ser"];
	$num=$dt["tb_venta_num"];
	
	$fechadoc=$dt["tb_venta_fec"];
	
	$identidad=$dt["tb_cliente_doc"];
	if($dt["tb_cliente_tip"]==1)$idtipodni=1;
	if($dt["tb_cliente_tip"]==2)$idtipodni=6;
	$razon=$dt["tb_cliente_nom"];


	$valven=$dt["tb_venta_valven"];
	$des=$dt["tb_venta_des"];
	$igv=$dt["tb_venta_igv"];
	$tot=$dt["tb_venta_tot"];

	$gra=$dt["tb_venta_gra"];
	$ina=$dt["tb_venta_ina"];
	$exo=$dt["tb_venta_exo"];
	$grat=$dt["tb_venta_grat"];
	$isc=$dt["tb_venta_isc"];
	$otrtri=$dt["tb_venta_otrtri"];
	$otrcar=$dt["tb_venta_otrcar"];
	$desglo=$dt["tb_venta_desglo"];
	

	$idtoperacion=$dt["cs_tipooperacion_id"];

	$numpla=$dt["tb_venta_lab1"];

}
mysql_free_result($dts);

$total_letras = numtoletras($tot,0);


$header[0]['idcomprobante']		=$idcomprobante;//1FACTURA 3BOLETA 7NCREDITO 8NDEBITO
$header[0]['serie']				=$ser;
$header[0]['numero']			=$num;

$header[0]['fechadoc']			=$fechadoc;

$header[0]['identidad']			=$identidad;
$header[0]['idtipodni']			=$idtipodni;
$header[0]['razon']				=$razon;

$header[0]['isomoneda']			="PEN";

$header[0]['totopgra']			=$gra;
$header[0]['totopina']			=$ina;
$header[0]['totopexo']			=$exo;
$header[0]['totopgrat']			=$grat;
$header[0]['totdescto']			=$des;//descto linea (o) + dscto global
//sumatorias
$header[0]['totigv']			=$igv;
$header[0]['totisc']			=$isc;
$header[0]['tototh']			=$otrtri;//sumatoria otros tributos
$header[0]['desctoglobal']		=$desglo;//descuentos globales
$header[0]['tototroca']			=$otrcar;//otros cargos
$header[0]['importetotal']		=$tot;

$header[0]['idtoperacion']		=$idtoperacion;//VENTA INTERNA

$header[0]['totanti']			="0.00";//si es mayor a cero concidera
$header[0]['iddoctributario']	="";//CATALOGO 12
$header[0]['iddoctriref']		="";

$header[0]['nroplaca']			=$numpla;//placa

$header[0]['AdditionalProperty_Value']=$total_letras;

$header = json_decode(json_encode($header));


//===============================================================================================
$autoin=0;
$dts = $oCotizacion->mostrar_venta_detalle_ps($ven_id);
while($dt = mysql_fetch_array($dts))
{

	if($dt["tb_ventadetalle_tipven"]==1)
	{
		$codigo=$dt["tb_catalogo_id"];
	}
	if($dt["tb_ventadetalle_tipven"]==2)
	{
		$codigo=$dt["tb_servicio_id"];
	}


	$detalle[$autoin]['idafectaciond']			=$dt["cs_tipoafectacionigv_cod"]; //10AFECTO 20EXONERADO 31BONO
	$detalle[$autoin]['nro']					=$dt["tb_ventadetalle_nro"];

	$detalle[$autoin]['idmedida']				=$dt["cs_tipounidadmedida_cod"];

	$detalle[$autoin]['cantidad']				=$dt["tb_ventadetalle_can"];
	$detalle[$autoin]['idproducto']				=$codigo;
	$detalle[$autoin]['codigo']					=$codigo;
	$detalle[$autoin]['detalle']				=null;
	$detalle[$autoin]['cdsc']					=$dt["tb_ventadetalle_nom"];

	//$igv 										=$dt["tb_ventadetalle_igv"] / $dt["tb_ventadetalle_can"];
	$detalle[$autoin]['precio']					=$dt["tb_ventadetalle_preuni"];
	//oculto ya se calcula en base datos
	//$detalle[$autoin]['valorref']				=($dt["tb_ventadetalle_valven"]+$dt["tb_ventadetalle_igv"])/$dt["tb_ventadetalle_can"];// precio de venta	
	$detalle[$autoin]['valorref']				=$dt["tb_ventadetalle_preunilin"];

	$detalle[$autoin]['igv']					=$dt["tb_ventadetalle_igv"];//sumatoria con cantidad
	$detalle[$autoin]['valorventa']				=$dt["tb_ventadetalle_valven"];//sumatoria con cantidad
	$detalle[$autoin]['descto']					=$dt["tb_ventadetalle_des"];

	$detalle[$autoin]['idtiposcisc']			=$dt["cs_tiposistemacalculoisc_id"];
	$detalle[$autoin]['isc']					=$dt["tb_ventadetalle_isc"];

	$autoin++;

}
mysql_free_result($dts);

$detalle = json_decode(json_encode($detalle));
//===============================================================================================

if($idcomprobante==1)//FACTURA
{
	$enviar=true;
	$r = run(datatoarray($header, $detalle, $empresa, 'Invoice'), "../../cperepositorio/send/", "../../cperepositorio/cdr/", $nodo="", "Invoice", $enviar);

	if($r['faultcode']=='0')
	{
        $data['msj']=$documento.' enviado a SUNAT.';
		$estado=true;
		$estado_envsun = 1;
	}
	else
	{
		$estado=false;

		if($r['faultcode']=='HTTP')
		{
			$enviar_doble=1;
            $data['msj']=$documento.' No pudo hacer conexión.';
			$estado_envsun = '';
		}
		else
		{
            $data['msj']=$documento.' Error: '.$r['faultcode'];
			$estado_envsun = 0;
		}

	}

    $oCotizacion->actualizar_sunat($ven_id,$r['faultcode'],$r['digvalue'],$r['signvalue'],$r['valid'],$estado_envsun);

}

if($idcomprobante==3)//BOLETA
{
	$enviar=false;
	$r = run(datatoarray($header, $detalle, $empresa, 'Invoice'), "../../cperepositorio/send/", "../../cperepositorio/cdr/", $nodo="", "Invoice", $enviar);

	$estado_envsun='10';
	$estado=true;
    $data['msj']=$documento.' registrado.';
    $oCotizacion->actualizar_sunat($ven_id,$r['faultcode'],$r['digvalue'],$r['signvalue'],$r['valid'],$estado_envsun);
}

echo json_encode($data);
?>