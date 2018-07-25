<?php
session_start();
require_once ("../../config/Cado.php");

$y=date('Y');
$m=date('m');
$d=date('d');

$fec1="$d-$m-$y";

//$d=ultimoDia($m,$y);
$fec2="$d-$m-$y";
//$fec2="$d-$m-$y";

$caj_id=$_SESSION['caja_id'];
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
function cmb_fil_caj_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../caja/cmb_caj_id.php",
		async:false,
		dataType: "html",                      
		data: ({
			caj_id: ids
		}),
		beforeSend: function() {
			$('#cmb_fil_caj_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_caj_id').html(html);
		}
	});
}	


$(function() {
	
	var dates = $( "#txt_fil_caj_fec1, #txt_fil_caj_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_caj_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	cmb_fil_caj_id(<?php echo $caj_id?>);
	
	$("#cmb_fil_caj_id").change(function(){
		caja_tabla();
	});
	
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_caj" id="for_fil_caj" target="_blank" action="<?php echo $_POST['act']?>" method="post">
<fieldset><legend>Filtro de Caja</legend>
	<label for="txt_fil_caj_fec1">Fecha entre:</label>
    <input name="txt_fil_caj_fec1" type="text" id="txt_fil_caj_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_caj_fec2">-</label>
    <input name="txt_fil_caj_fec2" type="text" id="txt_fil_caj_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <label for="cmb_fil_caj_id">Caja:</label>
    <select name="cmb_fil_caj_id" id="cmb_fil_caj_id">
    </select>
	<a href="#" onClick="caja_tabla();" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="caja_filtro();" id="btn_resfil">Restablecer</a>
</fieldset>
</form>