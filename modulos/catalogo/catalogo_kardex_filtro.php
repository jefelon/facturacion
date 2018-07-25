<script type="text/javascript">
	$('#btn_compra_filtrar').button({
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

$(function() {
	
	$("#txt_fil_pro_nom").focus();
	
	cmb_fil_pro_cat();
	cmb_fil_pro_mar();
	
	$('#cmb_fil_pro_cat').change(function(e) {
        catalogo_kardex_tabla();
    });
	
	$('#cmb_fil_pro_mar').change(function(e) {
        catalogo_kardex_tabla();
    });
	
	$( "#txt_fil_pro_nom" ).autocomplete({
   		minLength: 1,
   		source: "../producto/producto_complete_nom.php",
		select: function( event, ui ) {
			$("#txt_fil_pro_nom").val(ui.item.label)
			catalogo_kardex_tabla();
		}
    });
	
	$( "#txt_fil_pro_cod" ).autocomplete({
   		minLength: 1,
   		source: "../producto/presentacion_complete_cod.php",
		select: function(){
			catalogo_kardex_tabla();
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
<fieldset><legend>Filtro de producto</legend>

  <label for="txt_fil_pro_nom">Nombre:</label>
  <input name="txt_fil_pro_nom" type="text" id="txt_fil_pro_nom" size="50">

	<label for="txt_fil_pro_cod">Código:</label>
  <input name="txt_fil_pro_cod" type="text" id="txt_fil_pro_cod" size="20">
  
  <label for="cmb_fil_pro_lim">N° Filas:</label>
  <select name="cmb_fil_pro_lim" id="cmb_fil_pro_lim">
  		<option value="">-Todos-</option>
        <option value="10">10</option>
        <option value="20" selected="selected">20</option>
        <option value="50">50</option> 
        <option value="100">100</option>
  </select>
<br>

  <label for="cmb_fil_pro_cat">Categoría:</label>
  <select name="cmb_fil_pro_cat" id="cmb_fil_pro_cat">
  </select>
  
  <label for="cmb_fil_pro_mar">Marca:</label>
  <select name="cmb_fil_pro_mar" id="cmb_fil_pro_mar">
  </select>

  <label for="cmb_fil_pro_est">Estado:</label>
  <select name="cmb_fil_pro_est" id="cmb_fil_pro_est">
  		<option value="">-</option>
        <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
        <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option> 
  </select>
  <a href="#" onClick="catalogo_kardex_tabla()" id="btn_compra_filtrar">Filtrar</a>
  <a href="#" onClick="catalogo_kardex_filtro()" id="btn_pro_resfil">Restablecer</a>
</fieldset>