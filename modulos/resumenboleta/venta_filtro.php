<?php
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="$d-$m-$y";

	if($_POST['fecha'])
    {
        $fec1=$_POST['fecha'];
    }
	
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
function cmb_punven_id(idf)
{	
	$.ajax({
		type: "POST",
		url: "../puntoventa/cmb_punven_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			punven_id: idf
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_punven').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_ven_punven').html(html);
		},
		complete: function(){
			//venta_tabla();
		}
	});
}
$(function() {
	cmb_punven_id();
	var dates = $( "#txt_fil_ven_fec1" ).datepicker({
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
			venta_tabla();
			resumenboleta_tabla();
		}
	});
	
	//cmb_ven_doc();

	$('#cmb_fil_ven_doc, #cmb_fil_ven_punven').change(function(e) {
        venta_tabla();
        resumenboleta_tabla();
    });

	
});
</script>
<style>
</style>
<form name="for_fil_ven" id="for_fil_ven" target="_blank" action="venta_reporte.php" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="venta_tabla.php">
<fieldset><legend>Filtrar por</legend>
    <label for="txt_fil_ven_fec1">Fecha:</label>
    <input name="txt_fil_ven_fec1" type="text" id="txt_fil_ven_fec1" value="<?php echo $fec1 ?>" size="8" readonly>
    <?PHP /*?><label for="cmb_fil_ven_doc">Doc:</label>
    <select name="cmb_fil_ven_doc" id="cmb_fil_ven_doc">
    	<option value="3">BV | BOLETA</option>
    </select>

    <label for="cmb_fil_ven_punven">Punto Venta:</label>
    <select name="cmb_fil_ven_punven" id="cmb_fil_ven_punven">
    	
    </select>
    
    <input type="hidden" id="hdd_fil_cli_id" name="hdd_fil_cli_id" /><?PHP */?>

  	<a href="#" onClick="venta_tabla(),resumenboleta_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="venta_filtro(),resumenboleta_tabla()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>