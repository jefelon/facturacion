<script type="text/javascript">
	$('#btn_cliente_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_cliente_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});

    $('#chk_cobrar_varios').change( function() {
        if($(this).attr('checked')){
            $(this).val('1');
        }else{
            $(this).val('0');
        }
        seleccionar_cliente($("#hdd_fil_cli_id").val());
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

        $('#chk_cobrar_varios').change( function() {
            $('input[type=checkbox]:checked').each(function() {
                console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") Seleccionado");
            });
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
    <label for="txt_fil_cli_dir">Cobrar Varios Documentos:</label>
    <input name="chk_cobrar_varios" id="chk_cobrar_varios" type="checkbox" value="0">
    <a class="btn_pagar" id="cuentas_marcados" href="#pagar" onClick="clientecuenta_form_pago('insertar_pago','pago_insertar','<?php echo $dt['tb_clientecuenta_id']?>')">Pagar</a>
</fieldset>
