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
	
	//$punven_id=$_SESSION['puntoventa_id'];
	
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

function cmb_fil_ven_ven()
{	
	$.ajax({
		type: "POST",
		url: "../usuarios/cmb_use_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			usugru_id: '2,3'
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_ven').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_ven_ven').html(html);
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
	cmb_fil_ven_ven();
	cmb_punven_id(<?php echo $punven_id?>);
	
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

    $( "#txt_fil_ven_numdoc" ).autocomplete({
        minLength: 1,
        source: "../venta/venta_complete_numdoc.php",
        select: function(event, ui){
            $("#hdd_fil_ven_numdoc").val(ui.item.label);
            venta_tabla();
        }
    });

    $("#txt_fil_ven_numdoc").change(function(){
        var numdoc=$("#txt_fil_ven_numdoc").val();
        if(numdoc=="")$("#hdd_fil_ven_numdoc").val('');
        venta_tabla();
    });
	
	$('#cmb_fil_ven_doc').change(function(e) {
        venta_tabla();
    });
	$('#cmb_fil_ven_ven').change(function(e) {
        venta_tabla();
    });
	$('#cmb_fil_ven_punven').change(function(e) {
        venta_tabla();
    });
	$('#cmb_fil_ven_est').change(function(e) {
        venta_tabla();
    });
	
	$('#chk_ven_anu').change( function() {
		venta_tabla();
	});
    $('#cmb_destino_id').change(function(e) {
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
<form name="for_fil_ven" id="for_fil_ven" target="_blank" action="" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="venta_manifiestoarmar_tabla_enc.php">
<fieldset><legend>Filtro de Manifiesto</legend>
	
    <label for="txt_fil_ven_fec1">Fecha entre:</label>
    <input name="txt_fil_ven_fec1" type="text" id="txt_fil_ven_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_ven_fec2">-</label>
    <input name="txt_fil_ven_fec2" type="text" id="txt_fil_ven_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
    <input type="hidden" id="hdd_fil_cho_id" name="hdd_fil_cho_id" />
    <input type="hidden" id="hdd_fil_cli_id" name="hdd_fil_cli_id" />
    <label for="txt_fil_cli">Num. Doc:</label>
    <input type="text" id="txt_fil_ven_numdoc" name="txt_fil_ven_numdoc" size="7" />
    <input type="hidden" id="hdd_fil_ven_numdoc" name="hdd_fil_ven_numdoc">

    <label for="txt_fil_cli">Cliente:</label>
    <input type="text" id="txt_fil_cli" name="txt_fil_cli" size="25" />

    <label for="cmb_fil_ven_ven">Vendedor:</label>
	<select name="cmb_fil_ven_ven" id="cmb_fil_ven_ven">
    </select>
    <label for="cmb_destino_id">Destino:</label>
    <select name="cmb_destino_id" id="cmb_destino_id" style="width: 150px">
    </select>

    <a href="#" onClick="venta_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="venta_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>