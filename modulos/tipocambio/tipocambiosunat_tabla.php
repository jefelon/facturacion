<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
?>
<script type="text/javascript">
$(function() {	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_tipocambiosunat").tablesorter({
		headers: {
			0: {sorter: 'shortDate' },
			2: {sorter: false }
			},
		//sortForce: [[0,0]],
		sortList: [[0,1]]
    });
}); 
</script>
<?php

$mesElegido=$_POST['mesElegido'];
$anioElegido=$_POST['anioElegido'];
$mes=$_POST['mes'];
$anho=$_POST['anho'];
$sUrl = "http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias?mesElegido=$mesElegido&anioElegido=2017&mes=$mes&anho=$anho&accion=init&email='";
$sContent = file_get_contents($sUrl);
$doc = new DOMDocument();
$doc->loadHTML($sContent);
$xpath = new DOMXPath($doc);
$tablaTC = $xpath->query("//table[@class='class=\"form-table\"']"); //obtenemos la tabla TC
$filas = [];

echo "<table> <thead><tr><td>DIA</td><td>COMPRA</td><td>VENTA</td></tr></thead>";
foreach($tablaTC as $fila){
    $filas = $fila->getElementsByTagName("tr"); //obtiene todas las tr de la tabla de TC
}

$tcs = array(); //array de tcs, por dia como clave

foreach($filas as $fila){//recorremos cada tr
    $tds = [];
    $tds = $fila->getElementsByTagName("td");
    $i = 0;
    $j = 0;
    $arr = [];
    $dia = "";
    foreach($tds as $td){//recorremos cada td
        if($j == 3){
            $j = 0;
            $arr = [];
        }
        if($j == 0){
            $dia = trim(preg_replace("/[\r\n]+/", " ", $td->nodeValue));
            $tcs[$dia] = [];
        }
        if($j > 0 && $j < 3){
            $tcs[$dia][] = trim(preg_replace("/[\r\n]+/", " ", $td->nodeValue));
            if($dia>0 && $tcs[$dia][1]!='')// SI HAY DIAS Y SI EL TIPO DE CAMBIO TIENE VENTAS
            {
                echo "<tr><td><p style='width: 70px;padding: 0;margin: 0;'><input type='text' name='txt_tipcam_dolsunfecha[]' value='".$dia."-".$mes."-".$anho."'/></p></td><td width='10'><input type='text' name='txt_tipcam_dolsunc[]' value='".$tcs[$dia][0]."'/></td><td width='10'><input type='text' name='txt_tipcam_dolsunv[]' value='".$tcs[$dia][1]."'/></td></tr>";
            }
        }
        $j++;

    }
}
echo "</table>";
?>