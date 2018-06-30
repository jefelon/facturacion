<script type="text/javascript">
	$('#btn_compra_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_pro_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});

    function producto_form(act,idf){
        $.ajax({
            type: "POST",
            url: "../producto/producto_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                pro_id:		idf,
                tipo:		'',
                pro_nom: $('#txt_fil_pro_nom').val(),
                vista:	'compra_filtro'
            }),
            beforeSend: function() {
                $('#msj_producto').hide();
                $('#div_producto_form').dialog("open");
                $('#div_producto_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_producto_form').html(html);
            }
        });
    }

function cmb_fil_pro_cat()
{	
	$.ajax({
		type: "POST",
		url: "../categoria/cmb_cat_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			//cat_id: "<?php //echo $cat_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_pro_cat').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_pro_cat').html(html);
		}
	});
}

function cmb_fil_pro_mar()
{	
	$.ajax({
		type: "POST",
		url: "../marca/cmb_mar_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			//cat_id: "<?php //echo $cat_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_pro_mar').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_pro_mar').html(html);
		}
	});
}

$(function() {

	$("#txt_fil_pro_nom").focus();
		
	cmb_fil_pro_cat();
	cmb_fil_pro_mar();
	
	$('#cmb_com_tippre').change(function(e) {
        catalogo_compra_tabla();
    });
	
	$('#cmb_fil_pro_cat').change(function(e) {
        catalogo_compra_tabla();
    });
	
	$('#cmb_fil_pro_mar').change(function(e) {
        catalogo_compra_tabla();
    });
	
	$( "#txt_fil_pro_nom" ).autocomplete({
   		minLength: 2,
   		source: "../producto/producto_complete_nom.php",
		select: function( event, ui ) {
            if (ui.item.value===""){
                producto_form('insertar',"nuevo producto");
                $("#txt_bus_pro_nom").val();
            }else{
                $("#txt_fil_pro_nom").val(ui.item.label);
                catalogo_compra_tabla();
            }
		}
    });

    $( "#div_producto_form" ).dialog({
        title:'Información de Producto',
        autoOpen: false,
        resizable: false,
        height: 'auto',
        width: 990,
        modal: true,
        position: 'top',
        buttons: {
            Guardar: function() {
                $("#for_pro").submit();
            },
            Cancelar: function() {
                $('#for_pro').each (function(){this.reset();});
                $( this ).dialog("close");
            }
        },
        close: function()
        {
            $("#div_producto_form").html('Cargando...');
        }
    });
	
	$( "#txt_fil_pro_cod" ).autocomplete({
   		minLength: 1,
   		source: "../producto/presentacion_complete_cod.php",
		select: function(){
			catalogo_compra_tabla();
		}
    });
	
	$(document).shortkeys({
		'Enter':       function () { catalogo_compra_tabla();}
	});
	
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<fieldset><legend>Filtro de producto</legend>

  <label for="txt_fil_pro_nom">Nombre:</label>
  <input name="txt_fil_pro_nom" type="text" id="txt_fil_pro_nom" size="50">
  
<?php /*?>  <label for="txt_fil_pro_cod">Código:</label>
  <input name="txt_fil_pro_cod" type="text" id="txt_fil_pro_cod" size="20"><?php */?>
  
  <label for="cmb_fil_pro_lim">N° Filas:</label>
  <select name="cmb_fil_pro_lim" id="cmb_fil_pro_lim">
  		<option value="">-Todos-</option>
        <option value="10">10</option>
        <option value="20" selected="selected">20</option>
        <option value="50">50</option> 
        <option value="100">100</option>
  </select>
  <?php /*?><label for="cmb_com_tippre">Mostrar  con:</label>  
  <select name="cmb_com_tippre" id="cmb_com_tippre">
    <option value="1" selected="selected">Valor Venta</option>
    <option value="2">Precio Venta</option>
  </select> <?php */?>
<br>
  <label for="cmb_fil_pro_cat">Categoría:</label>
  <select name="cmb_fil_pro_cat" id="cmb_fil_pro_cat">
  </select>
  
  <label for="cmb_fil_pro_mar">Marca:</label>
  <select name="cmb_fil_pro_mar" id="cmb_fil_pro_mar">
  </select>
  
  <?php /*
  OCULTANDO ESTADO
  ?><label for="cmb_fil_pro_est">Estado:</label>
  <select name="cmb_fil_pro_est" id="cmb_fil_pro_est">
  		<option value="">-</option>
        <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
        <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option> 
  </select><?php */?>
  <a href="#" onClick="catalogo_compra_tabla()" id="btn_compra_filtrar">Filtrar</a>
  <a href="#" onClick="catalogo_compra_filtro()" id="btn_pro_resfil">Restablecer</a>

  <div id="msj_catalogo" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
  <a target="_blank" href="../producto/">Agregar Nuevo Producto</a>
</fieldset>

<div id="div_producto_form">

</div>