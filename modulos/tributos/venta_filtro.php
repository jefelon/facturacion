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

    $('.moneda').autoNumeric({
        aSep: ',',
        aDec: '.',
        //aSign: 'S/. ',
        //pSign: 's',
        vMin: '0.000',
        vMax: '1'
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
<fieldset><legend>Filtro Cuadro De Tributos</legend>
    <label for="cmb_ano">Año:</label>
	<select name="cmb_ano" id="cmb_ano">
	  <option value="">-</option>
	  <option value="2018">2018</option>
	  <option value="2019" selected>2019</option>
    </select>
    <label for="txt_coeficiente">Coeficiente:</label> <input name="txt_coeficiente" type="text" id="txt_coeficiente" class="moneda" style="text-align:right" size="10" maxlength="9" value="0.015">
  	<a href="#" onClick="venta_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="venta_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>