<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../ventanota/cVentanota.php");
$oVentanota = new cVentanota();

require_once("../formatos/formato.php");

$ven_id=$_POST['ven_id'];

	$dts= $oVentanota->mostrarUno($ven_id);
	$dt = mysql_fetch_array($dts);
		$fec	=mostrarFecha($dt['tb_venta_fec']);
		
		$doc_id	=$dt['tb_documento_id'];
		$doc_nom=$dt['tb_documento_nom'];
		$numdoc	=$dt['tb_venta_numdoc'];
		
		$cli_id	=$dt['tb_cliente_id'];
		$cli_nom=$dt['tb_cliente_nom'];
		$cli_doc=$dt['tb_cliente_doc'];
		
		$valven	=$dt['tb_venta_valven'];
		$igv	=$dt['tb_venta_igv'];
		$tot	=$dt['tb_venta_tot'];
	mysql_free_result($dts);
	
	if($doc_nom=='NOTA DE VENTA')$archivo_destino='../ventanota/venta_impresion_gra_factura.php';
	
	//if($doc_nom=='BOLETA')$archivo_destino='venta_impresion_boleta.php';
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
	$('#div_ventanota_impresion').dialog('close');
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
<?php echo"$doc_nom N° $numdoc"?>
</div>
<form id="for_preimp" target="_blank" action="<?php echo $archivo_destino?>" method="post">
<input name="ven_id" type="hidden" value="<?php echo $ven_id?>">
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
        <a class="btn_canimp" href="#printc" onClick="$('#div_ventanota_impresion').dialog('close');">Cancelar</a>
    </div>
</form>
