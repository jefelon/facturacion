<?php 
require_once('../../config/datos.php');

function responder($estado=false, $mensaje='', $datos=[])
{
	header('Content-Type: application/json');
	echo json_encode([
		'est' => $estado,
		'msj' => $mensaje,
		'dat' => $datos,
	]);
	exit;
}

require_once('../../cpegeneracion/sunat/funciones.php');

require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/numletras.php");

//EMPRESA
$empresa[0]['certificado']			=$certificado;
$empresa[0]['clave_certificado']	=$clave_certificado;

$empresa[0]['usuario_sunat']		=$usuario_sunat;
$empresa[0]['clave_sunat']			=$clave_sunat;

$empresa[0]['idempresa']			=$idempresa;
$empresa[0]['signature_id']			=$signature_id;
$empresa[0]['signature_id2']		=$signature_id2;
$empresa[0]['razon']				=$razon;
$empresa[0]['idtipodni']			=$idtipodni;
$empresa[0]['nomcomercial']			=$nomcomercial;
$empresa[0]['iddistrito']			=$iddistrito;
$empresa[0]['direccion']			=$direccion;
$empresa[0]['subdivision']			=$subdivision;
$empresa[0]['departamento']			=$departamento;
$empresa[0]['provincia']			=$provincia;
$empresa[0]['distrito']				=$distrito;

$empresa = json_decode(json_encode($empresa));
//var_dump($empresa);

//=================================================================
// $mod_id=3;//venta
// $dts = $oVenta->obtener_por_modulo($mod_id,$_POST['ven_id']);
// while($dt = mysqli_fetch_array($dts)){
//     $fe_comprobante_id = $dt["fe_comprobante_id"];
// }
// mysqli_free_result($dts);

$comprobante_id=$_POST['ecom_id'];

$dts = $oVenta->mostrarUno($comprobante_id);
$dt = mysqli_fetch_array($dts);

	$documento_cod	=$dt["cs_tipodocumento_cod"];
	$serie 			=$dt["tb_venta_ser"];
	$correlativo	=$dt["tb_venta_"];
	$documento 		=$dt["tb_venta_ser"].'-'.$dt["tb_venta_num"];

	$faucod 		=$dt["tb_venta_faucod"];
	$val 			=$dt["tb_venta_val"];
	$estsun			=$dt["tb_venta_estsun"];
	$est 			=$dt["tb_venta_est"];
mysqli_free_result($dts);

$header = json_decode(json_encode($header));
//var_dump($header);
//=====================================================================

//if($faucod=='0')responder(false, 'Comprobante ya generado.', []);


//if($documento_cod==1 or $documento_cod==3 or $documento_cod==7 or $documento_cod==8)
//{
	$tipocomprobante='0'.$documento_cod;
	$arr = array('usuario_sunat' => $empresa[0]->usuario_sunat , 'clave_sunat' => $empresa[0]->clave_sunat);

	$res = send_sunat2($empresa[0]->idempresa, $tipocomprobante, $serie, $correlativo, $arr, "../../cperepositorio/cdr/", "getStatusCdr");

	$fcode = $res;
    if($documento_cod=='1' || $documento_cod=='3')
    {
        if($res=='0127')
        {
           $fcode = -1;
        }
    }

    //fcode es el mismo campop de fault_code
    // aca modifica de acuerdo a su base de datos

	$oVenta->actualizar_sunat_cdr($comprobante_id,$fcode,$estado_envsun);


responder($estado, $msj,[
		'ecom_id' => $comprobante_id,
		'enviar' => $enviar_doble
		]);	
