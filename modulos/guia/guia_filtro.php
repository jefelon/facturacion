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
	$('#btn_guia_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_guia_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
	
function cmb_fil_tra_id()
{	
	$.ajax({
		type: "POST",
		url: "../transporte/cmb_tra_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			//tra_id: "<?php //echo $tra_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_tra_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_tra_id').html(html);
		}
	});
}


$(function() {
	
	var dates = $( "#txt_fil_guia_fec1, #txt_fil_guia_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_guia_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	//cmb_fil_tra_id();
	
	$( "#txt_fil_tra" ).autocomplete({
   		minLength: 1,
   		source: "../transporte/transporte_complete_razsoc.php",
		select: function(event, ui){
			$("#txt_fil_tra_id").val(ui.item.id);
			$("#txt_fil_con").removeAttr("disabled");//Habilito Caja autocompletar conductor														
		}
    });
	
	$( "#txt_fil_con" ).autocomplete({
   		minLength: 1,
   		//source: "../conductor/conductor_complete_nom.php",
		source: function(request, response){						
			$.ajax({
				url: "../conductor/conductor_complete_nom.php",
				dataType: "json",
				data:{
					term: request.term,
					tra_id: $("#txt_fil_tra_id").val()
				},
				success: function(data){
					response(data);
				}
			});		
		},
		select: function(event, ui){
			$("#txt_fil_con_id").val(ui.item.id);														
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
<form name="for_fil_gui" id="for_fil_gui" target="_blank" action="guia_reporte.php" method="post">
<fieldset><legend>Filtro Guía de Remisión</legend>
	
    <label for="txt_fil_gui_fec1">Fecha entre:</label>
    <input name="txt_fil_gui_fec1" type="text" id="txt_fil_gui_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_gui_fec2">-</label>
    <input name="txt_fil_gui_fec2" type="text" id="txt_fil_gui_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <label for="txt_fil_tra">Transporte:</label>
    <input type="hidden" id="txt_fil_tra_id" name="txt_fil_tra_id" />
    <input type="text" id="txt_fil_tra" name="txt_fil_tra" size="40" />
    
    <label for="txt_fil_con">Conductor:</label>
    <input type="hidden" id="txt_fil_con_id" name="txt_fil_con_id" />
    <input type="text" id="txt_fil_con" name="txt_fil_con" size="40" disabled="disabled" /><br />
    
    <label for="cmb_fil_gui_est">Estado:</label>
	<select name="cmb_fil_gui_est" id="cmb_fil_gui_est">
	  <option value="">-</option>
	  <option value="CONCLUIDA" selected>CONCLUIDA</option>
	  <option value="PROCESANDO">PROCESANDO</option>
    </select>
  	<a href="#" onClick="guia_tabla()" id="btn_guia_filtrar">Filtrar</a>
    <a href="#" onClick="guia_filtro()" id="btn_guia_resfil">Restablecer</a>
</fieldset>
</form>