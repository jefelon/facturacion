<?php
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/formatos.php");

$dts= $oVenta->mostrarUno($_GET['con_id']);
$dt = mysql_fetch_array($dts);
	
	$cod	=$dt['tb_contingencia_cod'];
	$txt	=$dt['tb_contingencia_txt'];
mysql_free_result($dts);


$zip = new ZipArchive;
$res = $zip->open($cod.'.zip', ZipArchive::CREATE);
if ($res === TRUE) {
    $zip->addFromString($cod.'.txt', $txt);
    $zip->close();
    //echo 'Creado Correctamente.';
} else {
    //echo 'Error al crear zip.';
}
header("Content-type: application/zip");
header('Content-Disposition: attachment; filename="'.$cod.'.zip"');
//header("Cache-Control: no-cache, must-revalidate");
//header("Expires: 0");

// leemos el archivo creado
readfile($cod.'.zip');
// Por último eliminamos el archivo temporal creado
unlink($cod.'.zip');//Destruyearchivo temporal
?>