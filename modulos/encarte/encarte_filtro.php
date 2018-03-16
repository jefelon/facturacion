<?php
//require_once ("../formatos/formatos.php");
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="01-$m-$y";
	
	//$d=ultimoDia($m,$y);
	$fec2="$d-$m-$y";
	//$fec2="$d-$m-$y";
	
?>
<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
$(function() {
	
	var dates = $( "#txt_fil_enc_fec1, #txt_fil_enc_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_enc_fec1" ? "minDate" : "maxDate",
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
<form name="for_fil_enc" id="for_fil_enc" target="_blank" action="../encarte/encarte_reporte.php" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="encarte_tabla.php">
<fieldset><legend>Filtro de Encarte</legend>
	
<?php /*?>    <label for="txt_fil_enc_fec1">Fecha inicio:</label>
    <input name="txt_fil_enc_fec1" type="text" id="txt_fil_enc_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_enc_fec2">-</label>
    <input name="txt_fil_enc_fec2" type="text" id="txt_fil_enc_fec2" value="<?php echo $fec2?>" size="8" readonly><?php */?>
    
    <label for="cmb_fil_enc_est">Estado:</label>
	<select name="cmb_fil_enc_est" id="cmb_fil_enc_est">
	  <option value="">-</option>
	  <option value="ACTIVO" selected="selected">ACTIVO</option>
    <option value="INACTIVO">INACTIVO</option>
    </select>
  	<a href="#" onClick="encarte_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="encarte_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>