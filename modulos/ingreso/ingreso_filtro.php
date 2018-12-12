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

$caja_id=$_SESSION['caja_id'];
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
function cmb_fil_doc_id(tipo,docid,vis)
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	tipo,
			doc_id: 	docid,
			vista:		vis
		}),
		beforeSend: function() {
			$('#cmb_fil_doc_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_fil_doc_id').html(html);
		},
		complete: function(){
		}
	});
}
function cmb_fil_cue_id()
{	
	$.ajax({
		type: "POST",
		url: "../cuentas/cmb_cue_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			elemento:"1",
			orden: "ord",
			cue_id: "<?php echo $cue_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_cue_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_cue_id').html(html);
		}
	});
}

function cmb_fil_subcue_id(cuenta_id)
{	
	$.ajax({
		type: "POST",
		url: "../cuentas/cmb_subcue_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			cue_id: cuenta_id,
			subcue_id: "<?php echo $subcue_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_subcue_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_subcue_id').html(html);
		}
	});
}


$(function() {

	cmb_fil_caj_id('<?php echo $caja_id?>');

	$( "#txt_fil_cli" ).autocomplete({
   		minLength: 1,
   		source: "../cliente/cliente_complete_nom.php",
		select: function(event, ui){
			$("#hdd_fil_cli_id").val(ui.item.id);
			ingreso_tabla();													
		}
    });	
	$("#txt_fil_cli").change(function(){
		var cli=$("#txt_fil_cli").val();
		if(cli=="")$("#hdd_fil_cli_id").val('');
	});

	cmb_fil_doc_id('6','doc_id','vista');

	cmb_fil_cue_id();
	$('#cmb_fil_cue_id').change(function(){
		cmb_fil_subcue_id($('#cmb_fil_cue_id').val());
	});
	
	var dates = $( "#txt_fil_ing_fec1, #txt_fil_ing_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_ing_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		},
	    onClose: function( selectedDate ) {
	        ingreso_tabla();
	    }
	});

	$("#txt_fil_cli,#cmb_fil_caj_id,#cmb_fil_doc_id,#txt_fil_ing_numdoc,#cmb_fil_cue_id, #cmb_fil_subcue_id, #cmb_fil_ing_est").change(function()
	{
		ingreso_tabla();
	});
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_ing" id="for_fil_ing" target="_blank" action="" method="post">
<fieldset><legend>Filtro de Ingresos</legend>
	<label for="txt_fil_ing_fec1">Fecha entre:</label>
    <input name="txt_fil_ing_fec1" type="text" id="txt_fil_ing_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_ing_fec2">-</label>
    <input name="txt_fil_ing_fec2" type="text" id="txt_fil_ing_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <label for="cmb_fil_caj_id">Caja:</label>
    <select name="cmb_fil_caj_id" id="cmb_fil_caj_id">
    </select>

	<input type="hidden" id="hdd_fil_cli_id" name="hdd_fil_cli_id" />
    <label for="txt_fil_cli_id">Cliente:</label>
    <input type="text" id="txt_fil_cli" name="txt_fil_cli" size="40" />

    <label for="cmb_fil_ing_est">Estado:</label>
    <select name="cmb_fil_ing_est" id="cmb_fil_ing_est">
    <option value="">-</option>
    <option value="1" <?php if($est==1)echo 'selected'?>>CANCELADO</option>
    <option value="2" <?php if($est==2)echo 'selected'?>>EMITIDO</option>
    </select>
<br>
<?php /*?>
	<label for="cmb_fil_doc_id">Documento:</label>
    <select name="cmb_fil_doc_id" id="cmb_fil_doc_id"></select>
<?php */?>
	<label for="txt_fil_ing_numdoc">N° Doc:</label>
    <input name="txt_fil_ing_numdoc" type="text" id="txt_fil_ing_numdoc" size="15" maxlength="15">

    <label for="cmb_fil_cue_id">Cuenta:</label>
    <select name="cmb_fil_cue_id" id="cmb_fil_cue_id">
    </select>
    <label for="cmb_fil_subcue_id">Sub Cuenta:</label>
    <select name="cmb_fil_subcue_id" id="cmb_fil_subcue_id">
    </select>
    
	<a href="#" onClick="ingreso_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="ingreso_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>