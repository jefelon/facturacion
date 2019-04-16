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
	
function cmb_fil_pro_id()
{	
	$.ajax({
		type: "POST",
		url: "../proveedor/cmb_pro_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			//pro_id: "<?php //echo $pro_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_pro_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_pro_id').html(html);
		}
	});
}


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
	
	//cmb_fil_pro_id();
	
	$( "#txt_fil_pro" ).autocomplete({
   		minLength: 1,
   		source: "../proveedor/proveedor_complete_nom.php",
		select: function(event, ui){
			$("#hdd_fil_pro_id").val(ui.item.id);														
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
<form name="for_fil_com" id="for_fil_com" target="_blank" action="../encarte/compra_reporte.php" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="compra_tabla.php">
<fieldset><legend>Filtro de Compra</legend>
	
    <label for="txt_fil_com_fec1">Fecha entre:</label>
    <input name="txt_fil_com_fec1" type="text" id="txt_fil_com_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_com_fec2">-</label>
    <input name="txt_fil_com_fec2" type="text" id="txt_fil_com_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <input type="hidden" id="hdd_fil_pro_id" name="hdd_fil_pro_id" />
    <label for="txt_fil_pro">Proveedor:</label>
    <input type="text" id="txt_fil_pro" name="txt_fil_pro" size="40" />
	<!--<select name="cmb_fil_pro_id" id="cmb_fil_pro_id">
    </select>-->

	<input type="hidden" id="cmb_fil_com_mon" value="" name="cmb_fil_com_mon" size="40" />
	<input type="hidden" id="cmb_fil_com_est" value="" name="cmb_fil_com_est" size="40" />
    <div>
  	<a href="#" onClick="compra_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="compra_filtro()" id="btn_resfil">Restablecer</a>
    </div>
</fieldset>
</form>