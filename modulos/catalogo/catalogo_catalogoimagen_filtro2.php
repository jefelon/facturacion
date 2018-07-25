<script type="text/javascript">
	$('#btn_venta_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_pro_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
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

function nueva_busqueda()
{
	$("#txt_fil_pro_nom").val('');
	$("#txt_fil_pro_cod").val('');
	$("#txt_fil_pro_codbar").val('');
	$("#txt_fil_pro_codbar").focus();
}

$(function() {
	
	$("#txt_fil_pro_codbar").focus();
	
	//cmb_fil_pro_cat();
	//cmb_fil_pro_mar();
	
	/*$('#cmb_com_tippre').change(function(e) {
        catalogo_venta_tabla();
    });*/
	
	/*$('#cmb_fil_pro_cat').change(function(e) {
        catalogo_venta_tabla();
    });
	
	$('#cmb_fil_pro_mar').change(function(e) {
        catalogo_venta_tabla();
    });*/
	$('#cmb_fil_pro_lim').change(function(e) {
        catalogo_catalogoimagen_tabla();
    });

	$( "#txt_fil_pro_nom" ).autocomplete({
   		minLength: 2,
			delay: 10,
   		source: "../producto/producto_complete_nom.php",
		select: function( event, ui ) {
			$("#txt_fil_pro_nom").val(ui.item.label)
			catalogo_catalogoimagen_tabla();
		}
    });
	
	$( "#txt_fil_pro_cod" ).autocomplete({
   		minLength: 1,
   		delay:10,
   		source: "../producto/presentacion_complete_cod.php",
			select: function(){
			catalogo_catalogoimagen_tabla();
		}
    });

    $("#txt_fil_pro_codbar").keypress(function(e){
      if(e.which==13){
      	catalogo_catalogoimagen_tabla();
      	$(this).val('');
		//$(this).focus();
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
<?php /*?><fieldset><legend>Filtro de producto</legend><?php */?>

  <label for="txt_fil_pro_codbar">Cód. Barras:</label>
  <input name="txt_fil_pro_codbar" type="text" id="txt_fil_pro_codbar" size="18">

  <label for="txt_fil_pro_nom">Producto:</label>
  <input name="txt_fil_pro_nom" type="text" id="txt_fil_pro_nom" size="45">

  <label for="txt_fil_pro_cod">Código:</label>
  <input name="txt_fil_pro_cod" type="text" id="txt_fil_pro_cod" size="12">

	<?php /*?><label for="txt_fil_pro_cod">Código:</label>
  <input name="txt_fil_pro_cod" type="text" id="txt_fil_pro_cod" size="20"><?php */?>
  
  <?php /*?><label for="cmb_fil_pro_lim">N° Filas:</label><?php */?>
  <select name="cmb_fil_pro_lim" id="cmb_fil_pro_lim">
  		<option value="">Todos</option>
        <option value="10" selected="selected">10</option>
        <option value="20">20</option>
        <option value="50">50</option> 
        <option value="100">100</option>
  </select>
<?php /*?>
  <label for="cmb_fil_pro_cat">Categoría:</label>
  <select name="cmb_fil_pro_cat" id="cmb_fil_pro_cat">
  </select>
  
  <label for="cmb_fil_pro_mar">Marca:</label>
  <select name="cmb_fil_pro_mar" id="cmb_fil_pro_mar">
  </select>
<?php */?>
  <?php /*?><label for="cmb_fil_pro_est">Estado:</label>
  <select name="cmb_fil_pro_est" id="cmb_fil_pro_est">
  		<option value="">-</option>
        <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
        <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option> 
  </select><?php */?>
  <a href="#" onClick="catalogo_catalogoimagen_tabla()" id="btn_venta_filtrar">Filtrar</a>
  <a href="#" onClick="catalogo_catalogoimagen_filtro()" id="btn_pro_resfil">Restablecer</a>
  <br><br>
  <div id="msj_catalogo" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
<?php /*?></fieldset><?php */?>