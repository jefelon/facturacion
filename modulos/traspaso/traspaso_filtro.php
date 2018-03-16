<?php
session_start();
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
	
function cmb_tra_alm_ori()
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
			$('#cmb_fil_tra_alm_ori').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_tra_alm_ori').html(html);
		}
	});
}
function cmb_tra_alm_des()
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
			$('#cmb_fil_tra_alm_des').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_tra_alm_des').html(html);
		}
	});
}

$(function() {
	
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
	
	cmb_tra_alm_ori();
	cmb_tra_alm_des();
	
	$('#chk_tra_anu').change( function() {
		traspaso_tabla();
	});
	
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_tra" id="for_fil_tra">
<fieldset><legend>Filtro de Transferencia</legend>
	
    <label for="txt_fil_tra_fec1">Fecha entre:</label>
    <input name="txt_fil_tra_fec1" type="text" id="txt_fil_tra_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_tra_fec2">-</label>
    <input name="txt_fil_tra_fec2" type="text" id="txt_fil_tra_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <label for="cmb_fil_tra_alm_ori">Almacén Origen:</label>
    <select name="cmb_fil_tra_alm_ori" id="cmb_fil_tra_alm_ori">
    </select>
    <label for="cmb_fil_tra_alm_des">Almacén Destino:</label>
    <select name="cmb_fil_tra_alm_des" id="cmb_fil_tra_alm_des">
    </select>
    <?php if($_SESSION['usuariogrupo_id']==2){?>
    <label for="chk_tra_anu" title="Activar para anular transferencia.">Anular<input name="chk_tra_anu" id="chk_tra_anu" type="checkbox" value="1"></label>
    <?php }?>
<a href="#" onClick="traspaso_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="traspaso_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>