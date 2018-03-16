<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();

require_once("../formatos/formato.php");

$clicue_id=$_POST['clicue_id'];

$dts=$oClientecuenta->mostrarUno($_POST['clicue_id']);
	$dt = mysql_fetch_array($dts);
		$clicue_fec	=$dt['tb_clientecuenta_fec'];
		$clicue_glo	=$dt['tb_clientecuenta_glo'];
		$clicue_tip	=$dt['tb_clientecuenta_tip'];//Tipo
		$clicue_mon	=$dt['tb_clientecuenta_mon'];//Monto
		$clicue_est	=$dt['tb_clientecuenta_est'];//Estado
		$ven_id		=$dt['tb_venta_id'];
		
		$forpag_id	=$dt['tb_formapago_id'];
		$modpag_id	=$dt['tb_modopago_id'];
		$tar_id		=$dt['tb_tarjeta_id'];
		$numope		=$dt['tb_clientecuenta_numope'];
		$numdia		=$dt['clientecuenta_numdia'];
		$fecven		=$dt['tb_clientecuenta_fecven'];		
		
		$cli_id		=$dt['tb_cliente_id'];
		$cli_nom		=$dt['tb_cliente_nom'];
		$cli_doc		=$dt['tb_cliente_doc'];
		
		$clicue_ver	=$dt['tb_clientecuenta_ver'];
		
	mysql_free_result($dts);
	
	$archivo_destino='recibo_impresion.php';

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
	$('#div_recibo_impresion').dialog('close');
}
function consultar_impresion_rapida(){
	$.ajax({
		type: "POST",
		url: "../formula/formula_reg.php",
		async:true,
		dataType: "json",                      
		data: ({
			action: 'consultar_dato_formula',
			ide: 'VEN_TIPO_IMPRESION'
		}),
		beforeSend: function() {			
			//$('#div_tipocambio_form').dialog("open");
			//$('#div_tipocambio_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(data){					
			if(data.dato == 1){
				imprimir();
			}		
		}
	});
}
$(function() {
	$('#imprimir').focus();
	consultar_impresion_rapida();
	
	$( "#rad_formato" ).buttonset();
	
	$(document).shortkeys({
	  'Shift+I': function () { imprimir(); }
	});
});
</script>
<div style="font-size:14px; text-align:center">
<?php echo"Recibo de Pago: $clicue_id"?>
</div>
<form id="for_preimp" target="_blank" action="<?php echo $archivo_destino?>" method="post">
<input name="clicue_id" type="hidden" value="<?php echo $clicue_id?>">
<br>
<div id="rad_formato">
<!--<p align="center">Formato de Impresión: 
    <input type="radio" name="rad_formato" value="A4" id="rad_formato_0">
    <label for="rad_formato_0">A4</label>
    <input name="rad_formato" type="radio" id="rad_formato_1" value="A5" checked>
    <label for="rad_formato_1">A5</label>
    <input type="radio" name="rad_formato" value="A6" id="rad_formato_2">
   <label for="rad_formato_2"> A6</label>
</p>--> 
</div>

<br>
<br>
	<div style="text-align:center">
        <a id="imprimir" class="btn_imprimir" title="Imprimir (Shift+I)" href="#print" onClick="imprimir()">Imprimir</a>
        <a class="btn_canimp" href="#printc" onClick="$('#div_recibo_impresion').dialog('close');">Cancelar</a>
    </div>
</form>
