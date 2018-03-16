<?php
require_once ("../../config/Cado.php");
require_once ("../ingreso_r/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../form/cForm.php");
$oForm = new cForm();
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="$d-$m-$y";
	
	//$d=ultimoDia($m,$y);
	$fec2="$d-$m-$y";
	//$fec2="$d-$m-$y";
	
	$caj_id=1;
	
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
		url: "../caja_r/cmb_caj_id.php",
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
function cmb_fil_cli_id()
{	
	$.ajax({
		type: "POST",
		url: "../clientes/cmb_cli_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			//pro_id: "<?php //echo $pro_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_cli_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_cli_id').html(html);
		}
	});
}

function cmb_fil_entfin_id()
{	
	$.ajax({
		type: "POST",
		url: "../entfinanciera/cmb_entfin_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			//pro_id: "<?php //echo $pro_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_entfin_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_entfin_id').html(html);
		}
	});
}

function cmb_fil_cue_id()
{	
	$.ajax({
		type: "POST",
		url: "../cuentas_r/cmb_cue_id.php",
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
		url: "../cuentas_r/cmb_subcue_id.php",
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
	
	cmb_fil_cli_id();
	cmb_fil_entfin_id();
	cmb_fil_cue_id();
	cmb_fil_caj_id(<?php echo $caj_id?>);
	
	$("#cmb_fil_caj_id").change(function(){
		caja_tabla();
	});
	
	$('#cmb_fil_cue_id').change(function(){
		cmb_fil_subcue_id($('#cmb_fil_cue_id').val());
	});	
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_caj" id="for_fil_caj" target="_blank" action="<?php echo $_POST['../flujocaja - Copia/act']?>" method="post">
<fieldset><legend>Filtro de Caja</legend>
	<label for="txt_fil_caj_fec1">Fecha entre:</label>
    <input name="txt_fil_caj_fec1" type="text" id="txt_fil_caj_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_caj_fec2">-</label>
    <input name="txt_fil_caj_fec2" type="text" id="txt_fil_caj_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <?php /*?><label for="cmb_fil_cue_id">Cuenta:</label>
    <select name="cmb_fil_cue_id" id="cmb_fil_cue_id">
    </select>
    <label for="cmb_fil_subcue_id">Sub Cuenta:</label>
    <select name="cmb_fil_subcue_id" id="cmb_fil_subcue_id">
    </select><?php */?>
    
    <?php /*?><label for="cmb_fil_cli_id">Cliente:</label>
	<select name="cmb_fil_cli_id" id="cmb_fil_cli_id">
    </select><?php */?>
    
    <?php /*?><label for="cmb_fil_entfin_id">Entidad Financiera:</label>
    <select name="cmb_fil_entfin_id" id="cmb_fil_entfin_id">
    </select><?php */?>
    
    <?php /*?><label for="cmb_fil_ing_est">Estado:</label>
    <select name="cmb_fil_ing_est" id="cmb_fil_ing_est">
    <option value="">-</option>
    <?php
    $rws=$oForm->mostrarTodos_des_ord('Ingresos','Estado','ord');
    while($rw = mysql_fetch_array($rws))
    {
    ?>
    <option value="<?php echo $rw['tb_form_des']?>" <?php if($rw['tb_form_des']==$estado)echo 'selected'?>><?php echo $rw['tb_form_des']?></option>
    <?php 
    }
    mysql_free_result($rws);
    ?>
    </select><?php */?>
    
    <label for="cmb_fil_caj_id">Caja:</label>
    <select name="cmb_fil_caj_id" id="cmb_fil_caj_id">
    </select>
	<a href="#" onClick="caja_tabla();" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="caja_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>