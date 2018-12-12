<script type="text/javascript">
	$('#btn_notalmacen_filtrar').button({
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
        catalogo_notalmacen_tabla();
    });
	
	$('#cmb_fil_pro_mar').change(function(e) {
        catalogo_notalmacen_tabla();
    });
	
	$( "#txt_fil_pro_nom" ).autocomplete({
   		minLength: 1,
   		source: "../producto/producto_complete_nom.php",
		select: function( event, ui ) {
			$("#txt_fil_pro_nom").val(ui.item.label)
			catalogo_notalmacen_tabla();
		}
    });
	
	$( "#txt_fil_pro_cod" ).autocomplete({
   		minLength: 1,
   		source: "../producto/presentacion_complete_cod.php",
		select: function(){
			catalogo_notalmacen_tabla();
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
<br>

  <label for="cmb_fil_pro_cat">Categoría:</label>
  <select name="cmb_fil_pro_cat" id="cmb_fil_pro_cat">
  </select>
  
  <label for="cmb_fil_pro_mar">Marca:</label>
  <select name="cmb_fil_pro_mar" id="cmb_fil_pro_mar">
  </select>
  
  <label for="cmb_fil_pro_lim">N° Filas:</label>
  <select name="cmb_fil_pro_lim" id="cmb_fil_pro_lim">
  		<option value="">-Todos-</option>
        <option value="10">10</option>
        <option value="20" selected="selected">20</option>
        <option value="50">50</option> 
        <option value="100">100</option>
  </select>

  <?php /*?><label for="cmb_fil_pro_est">Estado:</label>
  <select name="cmb_fil_pro_est" id="cmb_fil_pro_est">
  		<option value="">-</option>
        <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
        <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option> 
  </select><?php */?>
  <a href="#" onClick="catalogo_notalmacen_tabla()" id="btn_notalmacen_filtrar">Filtrar</a>
  <a href="#" onClick="catalogo_notalmacen_filtro()" id="btn_pro_resfil">Restablecer</a>
  </br>
  <!--<div id="format_checks" style="float:right">-->
  <label for="chk_fil_catven">Catálogo de Venta</label>
  <input name="chk_fil_catven" id="chk_fil_catven" type="checkbox" value="1" checked>
  <label for="chk_fil_catcom">Catálogo de Compra</label>
  <input name="chk_fil_catcom" id="chk_fil_catcom" type="checkbox" value="1" checked>
  <label for="chk_fil_unibas">Unidad Base</label>
  <input name="chk_fil_unibas" id="chk_fil_unibas" type="checkbox" value="1">
  <!--</div>-->
  
</fieldset>