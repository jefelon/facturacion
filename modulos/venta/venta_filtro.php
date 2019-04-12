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
		text: false
	});
	$('#btn_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
	
function cmb_fil_cli_id()
{	
	$.ajax({
		type: "POST",
		url: "../clientes/cmb_cli_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			//cli_id: "<?php //echo $cli_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_cli_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_cli_id').html(html);
		}
	});
}
function cmb_ven_doc()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'2',
			doc_id: '<?php echo $doc_id?>',
			vista:	'<?php echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_doc').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_fil_ven_doc').html(html);
		}
	});
}
$(function() {
	
	var dates = $( "#txt_fil_ven_fec1, #txt_fil_ven_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_ven_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	//cmb_fil_cli_id();
	
	cmb_ven_doc();
	
	$( "#txt_fil_cli" ).autocomplete({
   		minLength: 1,
   		source: "../clientes/cliente_complete_nom.php",
		select: function(event, ui){
			$("#hdd_fil_cli_id").val(ui.item.id);														
		}
    });
	
	$("#txt_fil_cli").change(function(){
		var cli=$("#txt_fil_cli").val();
		if(cli=="")$("#hdd_fil_cli_id").val('');
	});
	$('#cmb_fil_ven_doc').change(function(e) {
        venta_tabla();
    });
	$('#cmb_fil_ven_est').change(function(e) {
        venta_tabla();
    });
	$('#chk_ven_anu').change( function() {
		venta_tabla();
	});
	
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_ven" id="for_fil_ven" target="_blank" action="venta_reporte.php" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="venta_tabla.php">
<fieldset><legend>Filtro de Venta</legend>
    <label for="txt_fil_ven_fec1">Fecha:</label>
    <input name="txt_fil_ven_fec1" type="text" id="txt_fil_ven_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_ven_fec2">-</label>
    <input name="txt_fil_ven_fec2" type="text" id="txt_fil_ven_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <!--<label for="cmb_fil_cli_id">Cliente:</label>
	<select name="cmb_fil_cli_id" id="cmb_fil_cli_id">
    </select>-->
    
    <label for="cmb_fil_ven_doc">Doc:</label>
    <select name="cmb_fil_ven_doc" id="cmb_fil_ven_doc">
    </select>
    
    <input type="hidden" id="hdd_fil_cli_id" name="hdd_fil_cli_id" />
    
    <label for="txt_fil_cli">Cliente:</label>
    <input type="text" id="txt_fil_cli" name="txt_fil_cli" size="40" />
    
    <label for="cmb_fil_ven_est">Estado:</label>
	<select name="cmb_fil_ven_est" id="cmb_fil_ven_est">
	  <option value="">-</option>
	  <option value="CANCELADA" selected>CANCELADA</option>
	  <option value="ANULADA">ANULADA</option>
    </select>
    <label for="chk_fil_ven_may" title="Venta Mayorista">Venta Mayorista<input name="chk_fil_ven_may" id="chk_fil_ven_may" type="checkbox" value="1"></label>
    <label for="chk_ven_anu" title="Activar para anular venta.">Anular Venta<input name="chk_ven_anu" id="chk_ven_anu" type="checkbox" value="1"></label>
  	<a href="#" onClick="venta_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="venta_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>