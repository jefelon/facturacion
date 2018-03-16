<?php
require_once ("../../config/Cado.php");
require_once ("cTransferencia.php");
$oTransferencia = new cTransferencia();
require_once ("../form/cForm.php");
$oForm = new cForm();
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
		text: false
	});
	$('#btn_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
function cmb_fil_caj_id_ori(ids)
{	
	$.ajax({
		type: "POST",
		url: "../caja/cmb_caj_id_tra.php",
		async:true,
		dataType: "html",                      
		data: ({
			caj_id: ids
		}),
		beforeSend: function() {
			$('#cmb_fil_caj_id_ori').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_caj_id_ori').html(html);
		}
	});
}	
function cmb_fil_caj_id_des(ids)
{	
	$.ajax({
		type: "POST",
		url: "../caja/cmb_caj_id_tra.php",
		async:true,
		dataType: "html",                      
		data: ({
			caj_id: ids,
			caj_id_ori: $('#cmb_fil_caj_id_ori').val()
		}),
		beforeSend: function() {
			$('#cmb_fil_caj_id_des').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_caj_id_des').html(html);
		}
	});
}

$(function() {

	cmb_fil_caj_id_ori();
	
	$('#cmb_fil_caj_id_ori').change(function(){
		cmb_fil_caj_id_des(<?php echo $caj_id_des?>);
	});
	
	var dates = $( "#txt_fil_tra_fec1, #txt_fil_tra_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_tra_fec1" ? "minDate" : "maxDate",
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
<form name="for_fil_tra" id="for_fil_tra" target="_blank" action="<?php echo $_POST['act']?>" method="post">
<fieldset><legend>Filtro de Transferencias</legend>
	<label for="txt_fil_tra_fec1">Fecha entre:</label>
    <input name="txt_fil_tra_fec1" type="text" id="txt_fil_tra_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_tra_fec2">-</label>
    <input name="txt_fil_tra_fec2" type="text" id="txt_fil_tra_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <label for="txt_fil_tra_cod">Código:</label>
    <input name="txt_fil_tra_cod" type="text" id="txt_fil_tra_cod" size="10" maxlength="15">

    <?php /*?><label for="cmb_fil_cli_id">Cliente:</label>
	<select name="cmb_fil_cli_id" id="cmb_fil_cli_id">
    </select><?php */?>
    
    <label for="cmb_fil_caj_id_ori">Origen:</label>
    <select name="cmb_fil_caj_id_ori" id="cmb_fil_caj_id_ori">
    </select>
    
    <label for="cmb_fil_caj_id_des">Destino:</label>
    <select name="cmb_fil_caj_id_des" id="cmb_fil_caj_id_des">
    </select>

		<label for="cmb_fil_mon_id">Moneda:</label>
    <select name="cmb_fil_mon_id" id="cmb_fil_mon_id">
    <option value="">-</option>
     <option value="1">NUEVO SOL | S/.</option>
     <option value="2">DOLAR AME | US$</option>
    </select>
    
	<a href="#" onClick="transferencia_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="transferencia_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>