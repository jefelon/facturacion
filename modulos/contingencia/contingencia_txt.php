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

// Tipo MIME del archivo
header('Content-Type: text/plain');
// Indica que lo descargue
header('Content-Disposition: attachment; filename="'.$cod.'.txt"');

// Registro ficticio para la prueba
print("$txt");

?>