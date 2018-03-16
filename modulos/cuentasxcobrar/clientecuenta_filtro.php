<?php 

$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="01-$m-$y";
	
	//$d=ultimoDia($m,$y);
	$fec2="$d-$m-$y";
?>
<script type="text/javascript">
	$('#btn_cliente_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_cliente_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
	$(function(){
		
		var dates = $( "#txt_fil_ven_fec1, #txt_fil_ven_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_ven_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
		
		$( "#txt_fil_cli_nom" ).autocomplete({
			minLength: 1,
			source: "../clientes/cliente_complete_nom.php",
			select: function(event, ui){			
				$("#hdd_fil_cli_id").val(ui.item.id);							
				$("#txt_fil_cli_doc").val(ui.item.documento);
				$("#txt_fil_cli_dir").val(ui.item.direccion);
				clientecuenta_tabla()	
			}
		});
		
		$( "#txt_fil_cli_doc" ).autocomplete({
			minLength: 1,
			source: "../clientes/cliente_complete_doc.php",
			select: function(event, ui){			
				$("#hdd_fil_cli_id").val(ui.item.id);							
				$("#txt_fil_cli_nom").val(ui.item.nombre);
				$("#txt_fil_cli_dir").val(ui.item.direccion);		
				clientecuenta_tabla()
			}
		});	
	});	
</script>
<form name="for_fil_clicue" id="for_fil_clicue" target="_blank" action="" method="post">
<fieldset>
	<legend>Filtro</legend>
  <label for="txt_fil_ven_fec1">Fecha entre:</label>
    <input name="txt_fil_ven_fec1" type="text" id="txt_fil_ven_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_ven_fec2">-</label>
    <input name="txt_fil_ven_fec2" type="text" id="txt_fil_ven_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <input type="hidden" id="hdd_fil_cli_id" name="hdd_fil_cli_id" />
    <label for="txt_fil_cli_doc">RUC/DNI:</label>
    <input type="text" id="txt_fil_cli_doc" name="txt_fil_cli_doc" size="20" /> 
    <label for="txt_fil_cli_nom">Cliente:</label>
    <input type="text" id="txt_fil_cli_nom" name="txt_fil_cli_nom" size="40" />
    <?php /*?><label for="txt_fil_cli_dir">Dirección:</label>
    <input type="text" id="txt_fil_cli_dir" name="txt_fil_cli_dir" size="40" readonly /><?php */?>
    <a href="#" onClick="clientecuenta_tabla()" id="btn_cliente_filtrar">Filtrar</a>
	<a href="#" onClick="clientecuenta_filtro()" id="btn_cliente_resfil">Restablecer</a>
</fieldset>
</form>