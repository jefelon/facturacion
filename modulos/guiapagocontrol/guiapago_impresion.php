<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../guiapagocontrol/cGuiapago.php");
$oGuiapago = new cGuiapago();

require_once("../formatos/formato.php");

	$dts= $oGuiapago->mostrarUno($_POST['guipag_id']);
	$dt = mysql_fetch_array($dts);
		$fecreg   =mostrarFechaHora($dt['tb_guiapago_fecreg']);
	    $fecmod   =mostrarFechaHora($dt['tb_guiapago_fecmod']);
	    $usureg   =$dt['tb_guiapago_usureg'];
	    $usumod   =$dt['tb_guiapago_usumod'];
	    
	    $cli_id =$dt['tb_cliente_id'];
	    $est    =$dt['tb_guiapago_est'];
	    $pag    =$dt['tb_guiapago_pag'];

	    $per    =$dt['tb_periodo_id'];
	    $per    =str_pad($per, 2, "0", STR_PAD_LEFT);
	    $eje    =$dt['tb_ejercicio_id'];

	    $codtri =$dt['tb_guiapago_codtri'];
	    $imppag =formato_money($dt['tb_guiapago_imppag']);

	    $codtriaso =$dt['tb_guiapago_codtriaso'];
	    $numdoc =$dt['tb_guiapago_numdoc'];
	mysql_free_result($dts);
	
	//if($doc_nom=='FACTURA')$archivo_destino='../venta/venta_impresion_gra_factura.php';
	$archivo_destino='../guiapagocontrol/guiapago_impresion_formato.php';

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
	$('#div_guiapago_impresion').dialog('close');
}
/*
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
}*/
$(function() {
	$('#imprimir').focus();
	//consultar_impresion_rapida();
	
	//$( "#rad_formato" ).buttonset();

});
</script>
<div style="font-size:14px; text-align:center">
<?php echo"$doc_nom N° $numdoc"?>
</div>
<form id="for_preimp" target="_blank" action="<?php echo $archivo_destino?>" method="post">
<input name="guipag_id" id="guipag_id" type="hidden" value="<?php echo $_POST['guipag_id']?>">
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
        <a id="imprimir" class="btn_imprimir" title="Imprimir" href="#print" onClick="imprimir()">Imprimir</a>
        <a class="btn_canimp" href="#printc" onClick="$('#div_guiapago_impresion').dialog('close');">Cancelar</a>
    </div>
</form>
