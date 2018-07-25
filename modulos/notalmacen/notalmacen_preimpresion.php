<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("cNotalmacen.php");
$oNotalmacen = new cNotalmacen();

require_once("../formatos/formato.php");

$notalm_id=$_POST['notalm_id'];

$dts= $oNotalmacen->mostrarUno($notalm_id);
$dt = mysql_fetch_array($dts);
	$fec		=mostrarFecha($dt['tb_notalmacen_fec']);
	$cod	=str_pad($dt['tb_notalmacen_cod'],4, "0", STR_PAD_LEFT);
	$tip	=$dt['tb_notalmacen_tip'];
	$obs	=$dt['tb_notalmacen_obs'];
	$alm_id	=$dt['tb_almacen_id'];

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
	$('#div_notalmacen_impresion').dialog('close');
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
<form id="for_preimp" target="_blank" action="notalmacen_impresion.php" method="post">
<input name="notalm_id" type="hidden" value="<?php echo $notalm_id?>">
<br>
<br>
<br>
	<div style="text-align:center">
        <a class="btn_imprimir" title="Imprimir (Shift+I)" href="#" onClick="imprimir()">Imprimir</a>
        <a class="btn_canimp" href="#" onClick="$('#div_notalmacen_impresion').dialog('close');">Cancelar</a>
    </div>
</form>
