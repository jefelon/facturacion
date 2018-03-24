<?php
	require_once ("../../config/Cado.php");
	require_once ("..cotizacion/cCotizacion.php");
    $oCotizacion = new cCotizacion();

	$id = $_GET['id_factura'];
	$dts = $oCotizacion->mostrarUno($id);
	while($dt = mysql_fetch_array($dts)){
		$doc = $dt['cs_tipodocumento_id'];
		$ser = $dt['tb_venta_ser'];
		$num = $dt['tb_venta_num'];
	}

	$xml="20479676861-0".$doc."-".$ser."-".$num;
	header("Content-disposition: attachment; filename=".$xml.".zip");
	header("Content-type: application/zip");
	readfile("../../cperepositorio/send/".$xml.".zip");
?>