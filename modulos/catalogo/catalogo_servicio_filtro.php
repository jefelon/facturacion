<script type="text/javascript">
	$('#btn_servicio_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_ser_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
	$('#btn_ser_form_agregar').button({
		icons: {primary: "ui-icon-plus"},
		text: false
	});
//categoria
function cmb_fil_ser_cat(){	
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

function servicio_form_i(act,idf){
	$.ajax({
		type: "POST",
		url: "../servicio/servicio_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: 		act,
			ser_id:			idf,
			aut: 			1,
			vista:			'hdd_ser_id'
		}),
		beforeSend: function(a) {
			$("#btn_ser_form_agregar").click(function(e){
			  x=e.pageX+5;
			  y=e.pageY+15;
			  $('#div_servicio_form').dialog({ position: [x,y] });
			  $('#div_servicio_form').dialog("open");
		    });

			$('#div_servicio_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_servicio_form').html(html);					
		},
		complete: function(){
			/*if(act=='insertar' & $('#hdd_ven_ser_id').val()=="")
			{
				$('#txt_ser_doc').val($('#txt_ven_ser_doc').val());
				$('#txt_ser_nom').val($('#txt_ven_ser_nom').val());
			}*/
			
		}
	});
}

$(function() {
	
	$("#txt_fil_ser_nom").focus();
	
	cmb_fil_ser_cat();//categoria
	
	$('#cmb_fil_ser_cat').change(function(e) {
        catalogo_servicio_tabla();
    });
	
	$( "#txt_fil_ser_nom" ).autocomplete({
   		minLength: 1,
   		source: "../servicio/servicio_complete_nom.php",
		select: function( event, ui ) {
			$("#txt_fil_ser_nom").val(ui.item.label)
			catalogo_servicio_tabla();
		}
    });

    $( "#div_servicio_form" ).dialog({
		title:'Información de Servicio',
		autoOpen: false,
		resizable: false,
		height: 300,
		width: 530,
		zIndex: 4,
		//modal: true,
		buttons: {
			Guardar: function() {
				$("#for_ser").submit();
			},
			Cancelar: function() {
				$('#for_ser').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
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
<fieldset><legend>Filtro de Servicio</legend>
<div id="div_servicio_form">
	</div>

  <label for="txt_fil_ser_nom">Nombre:</label>
  <input name="txt_fil_ser_nom" type="text" id="txt_fil_ser_nom" size="50">
  
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
  <a href="#" onClick="catalogo_servicio_tabla()" id="btn_servicio_filtrar">Filtrar</a>
  <a href="#" onClick="catalogo_servicio_filtro()" id="btn_ser_resfil">Restablecer</a>
  <a id="btn_ser_form_agregar" href="#" onClick="servicio_form_i('insertar')">Agregar Servicio</a>
  
  <div id="msj_catalogo_servicio" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
</fieldset>