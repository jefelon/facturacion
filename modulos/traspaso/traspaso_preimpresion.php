<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("cTraspaso.php");
$oTraspaso = new cTraspaso();

require_once("../formatos/formato.php");

$tra_id=$_POST['tra_id'];

$dts= $oTraspaso->mostrarUno($tra_id);
$dt = mysql_fetch_array($dts);
	$fec		=mostrarFecha($dt['tb_traspaso_fec']);
	$alm_id_ori	=$dt['tb_almacen_id_ori'];
	$alm_id_des	=$dt['tb_almacen_id_des'];
	$cod=str_pad($dt['tb_traspaso_cod'],4, "0", STR_PAD_LEFT);

mysql_free_result($dts);
?>
<script type="text/javascript">
$('.btn_imprimir').button({
	icons: {primary: "ui-icon-print"},
	text: true
});
$('.btn_canimp').button({
	icons: {primary: "ui-icon-cancel"},
	text: true
});

function imprimir()
{	
	$("#for_preimp").submit();
	$('#div_traspaso_impresion').dialog('close');
}
$(function() {
	$(document).shortkeys({
	  'Shift+I': function () { imprimir(); }
	});
});
</script>
<div style="font-size:14px; text-align:center">
<?php echo"Código: $cod"?>
</div>
<form id="for_preimp" target="_blank" action="traspaso_impresion.php" method="post">
<input name="tra_id" type="hidden" value="<?php echo $tra_id?>">
<br>
<br>
<br>
	<div style="text-align:center">
        <a class="btn_imprimir" title="Imprimir (Shift+I)" href="#imprimir" onClick="imprimir()">Imprimir</a>
        <a class="btn_canimp" href="#" onClick="$('#div_traspaso_impresion').dialog('close');">Cancelar</a>
    </div>
</form>
