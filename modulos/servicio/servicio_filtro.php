<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
	
function cmb_fil_ser_cat()
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
			$('#cmb_fil_ser_cat').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_ser_cat').html(html);
		}
	});
}
/*function cmb_fil_ser_mar()
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
			$('#cmb_fil_ser_mar').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_ser_mar').html(html);
		}
	});
}*/

$(function() {
	
	cmb_fil_ser_cat();
	//cmb_fil_ser_mar();
	
	$( "#txt_fil_ser_nom" ).autocomplete({
   		minLength: 1,
   		source: "servicio_complete_nom.php"
    });
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_ser" id="for_fil_ser">
<fieldset><legend>Filtro de servicio</legend>

  <label for="txt_fil_ser_nom">Nombre:</label>
  <input name="txt_fil_ser_nom" type="text" id="txt_fil_ser_nom" size="50">

  <!--<label for="cmb_fil_ser_mar">Marca:</label>
  <select name="cmb_fil_ser_mar" id="cmb_fil_ser_mar">
  </select>
-->
  <label for="cmb_fil_ser_lim">N° Filas:</label>
  <select name="cmb_fil_ser_lim" id="cmb_fil_ser_lim">
  		<option value="">-Todos-</option>
        <option value="10">10</option>
        <option value="20" selected="selected">20</option>
        <option value="50">50</option> 
        <option value="100">100</option>
  </select>	
<br>
  <label for="cmb_fil_ser_cat">Categoría:</label>
  <select name="cmb_fil_ser_cat" id="cmb_fil_ser_cat">
  </select>

  <?php /*?><label for="cmb_fil_ser_est">Estado:</label>
  <select name="cmb_fil_ser_est" id="cmb_fil_ser_est">
  		<option value="">-</option>
        <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
        <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option> 
  </select><?php */?>
  <a href="#" onClick="servicio_tabla()" id="btn_filtrar">Filtrar</a>
  <a href="#" onClick="servicio_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>