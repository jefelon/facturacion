<?php
//require_once ("../formatos/formatos.php");
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="$d-$m-$y";
	
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
	
function cmb_notalm_alm()
{	
	$.ajax({
		type: "POST",
		url: "../almacen/cmb_alm_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			alm_id: '<?php echo $alm_id?>'
		}),
		beforeSend: function() {
			$('#cmb_fil_notalm_alm').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_notalm_alm').html(html);
		}
	});
}

$(function() {
	
	var dates = $( "#txt_fil_notalm_fec1, #txt_fil_notalm_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_notalm_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	cmb_notalm_alm();
	
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_notalm" id="for_fil_notalm">
<fieldset>
  <legend>Filtro de Nota de Almacén</legend>
  <label for="txt_fil_notalm_fec1">Fecha entre:</label>
    <input name="txt_fil_notalm_fec1" type="text" id="txt_fil_notalm_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_notalm_fec2">-</label>
    <input name="txt_fil_notalm_fec2" type="text" id="txt_fil_notalm_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <label for="cmb_fil_notalm_alm">Almacén</label>
    <select name="cmb_fil_notalm_alm" id="cmb_fil_notalm_alm">
    </select>
    <label for="cmb_fil_notalm_tip">Tipo:</label>
    <select name="cmb_fil_notalm_tip" id="cmb_fil_notalm_tip">
      <option value="">-</option>
      <option value="1" <?php if($tip==1)echo 'selected'?>>ENTRADA</option>
      <option value="2" <?php if($tip==2)echo 'selected'?>>SALIDA</option>
      </select>
<a href="#" onClick="notalmacen_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="notalmacen_filtro()" id="btn_resfil">Restablecer</a>
</legend></fieldset>
</form>