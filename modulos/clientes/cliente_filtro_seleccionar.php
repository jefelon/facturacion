<script type="text/javascript">
	$('#btn_cliente_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_cliente_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
	$(function(){
		$( "#txt_fil_cli_nom" ).autocomplete({
			minLength: 1,
			source: "../clientes/cliente_complete_nom.php",
			select: function(event, ui){			
				$("#hdd_fil_cli_id").val(ui.item.id);							
				$("#txt_fil_cli_doc").val(ui.item.documento);
				$("#txt_fil_cli_dir").val(ui.item.direccion);
				//cliente_tabla_seleccionar();	
				seleccionar_cliente($("#hdd_fil_cli_id").val());	
			}
		});
		
		$( "#txt_fil_cli_doc" ).autocomplete({
			minLength: 1,
			source: "../clientes/cliente_complete_doc.php",
			select: function(event, ui){			
				$("#hdd_fil_cli_id").val(ui.item.id);							
				$("#txt_fil_cli_nom").val(ui.item.nombre);
				$("#txt_fil_cli_dir").val(ui.item.direccion);		
				//cliente_tabla_seleccionar();
				seleccionar_cliente($("#hdd_fil_cli_id").val());
			}
		});	
	});	
</script>

<fieldset>
	<legend>Filtro</legend>
    <input type="hidden" id="hdd_fil_cli_id" name="hdd_fil_cli_id" />
    <label for="txt_fil_cli_doc">RUC/DNI:</label>
    <input type="text" id="txt_fil_cli_doc" name="txt_fil_cli_doc" size="20" /> 
    <label for="txt_fil_cli_nom">Cliente:</label>
    <input type="text" id="txt_fil_cli_nom" name="txt_fil_cli_nom" size="40" />
    <label for="txt_fil_cli_dir">Dirección:</label>
    <input type="text" id="txt_fil_cli_dir" name="txt_fil_cli_dir" size="40" readonly />
    <!--<a href="#" onClick="cliente_tabla_seleccionar()" id="btn_cliente_filtrar">Filtrar</a>-->
	<a href="#" onClick="cliente_filtro_seleccionar()" id="btn_cliente_resfil">Restablecer</a>
</fieldset>
