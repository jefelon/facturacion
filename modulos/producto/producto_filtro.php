<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_resfil').button({
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
	
	cmb_fil_pro_cat();
	cmb_fil_pro_mar();
	
	$( "#txt_fil_pro_nom" ).autocomplete({
   		minLength: 1,
   		source: "../producto/producto_complete_nom.php",
		select: function() {
			producto_tabla();
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
<form name="for_fil_pro" id="for_fil_pro">
<fieldset><legend>Filtro de producto</legend>

  <label for="txt_fil_pro_nom">Nombre:</label>
  <input name="txt_fil_pro_nom" type="text" id="txt_fil_pro_nom" size="50">

  <label for="cmb_fil_pro_mar">Marca:</label>
  <select name="cmb_fil_pro_mar" id="cmb_fil_pro_mar">
  </select>
<br>  
  <label for="cmb_fil_pro_cat">Categoría:</label>
  <select name="cmb_fil_pro_cat" id="cmb_fil_pro_cat">
  </select>
  
  <label for="cmb_fil_pro_est">Estado:</label>
  <select name="cmb_fil_pro_est" id="cmb_fil_pro_est">
  		<option value="">-</option>
        <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
        <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option> 
  </select>
  
  <label for="cmb_fil_lim">N° Filas:</label>
  <select name="cmb_fil_lim" id="cmb_fil_lim">
  		<option value="">-Todos-</option>
        <option value="10">10</option>
        <option value="20" selected="selected">20</option>
        <option value="50">50</option> 
        <option value="100">100</option>
  </select>
  
  <label for="cmb_fil_ordby">Orden:</label>
  <select name="cmb_fil_ordby" id="cmb_fil_ordby">
        <option value="tb_producto_nom">Nombre</option>
        <option value="tb_producto_mod DESC" selected="selected">Modificación</option>
  </select>
  
  <a href="#" onClick="producto_tabla()" id="btn_filtrar">Filtrar</a>
  <a href="#" onClick="producto_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>