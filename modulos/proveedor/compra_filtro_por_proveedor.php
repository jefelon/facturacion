<?php
//require_once ("../formatos/formatos.php");
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="01-01-$y";
	
	//$d=ultimoDia($m,$y);
	$fec2="$d-$m-$y";
	//$fec2="$d-$m-$y";
	
?>
<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: true
	});
	$('#btn_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
	

$(function() {
	
	var dates = $( "#txt_fil_com_fec1, #txt_fil_com_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_com_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});	
});


</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_com" id="for_fil_com">
<fieldset><legend>Filtro de Compra por Proveedor</legend>
	
    <label for="txt_fil_com_fec1">Fecha entre:</label>
    <input name="txt_fil_com_fec1" type="text" id="txt_fil_com_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_com_fec2">-</label>
    <input name="txt_fil_com_fec2" type="text" id="txt_fil_com_fec2" value="<?php echo $fec2?>" size="8" readonly>   
    
  	<a href="#" onClick="compra_tabla_por_proveedor()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="compra_filtro_por_proveedor()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>