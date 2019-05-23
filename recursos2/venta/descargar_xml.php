<?php
    session_start();
	require_once ("../../config/Cado.php");
    require_once ("../../config/datos.php");
	require_once ("../venta/cVenta.php");
    require_once ("../../modulos/formatos/numletras.php");
    require_once ("../../modulos/formatos/formato.php");
	require_once ("../../modulos/empresa/cEmpresa.php");
	$oVenta = new cVenta();

function decrypt($string, $key) {
    $result = '';
    $string = base64_decode($string);
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
    }
    return $result;
}

$cadena_recibida =$_GET['action'];
$cadena_desencriptada = decrypt($cadena_recibida,'l09=4di_-T==');

$array=explode('=',$cadena_desencriptada);

    $id = $array[1];

    $dts = $oVenta->mostrarUno($id);
    while($dt = mysql_fetch_array($dts)){
        $id = $dt["tb_venta_id"];
    }

    $dts = $oVenta->mostrarUno($id);
    while($dt = mysql_fetch_array($dts)){
        $doc = $dt['cs_tipodocumento_id'];
        $ser = $dt['tb_venta_ser'];
        $num = $dt['tb_venta_num'];
    }

    $oEmpresa = new cEmpresa();
    $dts = $oEmpresa->mostrarUno($_SESSION['empresa_id']);
    $dt = mysql_fetch_array($dts);
    $ruc_empresa=$dt['tb_empresa_ruc'];

	$xml=$ruc_empresa."-0".$doc."-".$ser."-".$num;
	header("Content-disposition: attachment; filename=".$xml.".zip");
	header("Content-type: application/zip");
	readfile("../../cperepositorio/send/".$xml.".zip");
?>