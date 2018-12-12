<?php 
session_start();
$alm_id=$_SESSION['almacen_id'];

$fec=date('d-m-Y');

if($_SESSION['usuariogrupo_id']==2)$modo='catalogo_tabla.php';
if($_SESSION['usuariogrupo_id']==3)$modo='catalogo_impresion.php';
if($_SESSION['usuariogrupo_id']==4)$modo='catalogo_tabla_ven.php';
?>
<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: true
	});
	$('#btn_pro_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});

$( "#txt_fil_inv_fec" ).datepicker({
	minDate: "01-01-2016", 
	maxDate:"+0D",
	yearRange: 'c-0:c+0',
	changeMonth: true,
	changeYear: false,
	dateFormat: 'dd-mm-yy',
	//altField: fecha,
	//altFormat: 'yy-mm-dd',
	showOn: "button",
	buttonImage: "../../images/calendar.gif",
	buttonImageOnly: true
});

function cmb_fil_pro_alm()
{	
	$.ajax({
		type: "POST",
		url: "../almacen/cmb_alm_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			alm_id: '<?php echo $alm_id?>'
		}),
		beforeSend: function() {
			$('#cmb_fil_pro_alm').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_pro_alm').html(html);
		},
		complete: function(){
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

function atributo_lista(cat_id){	
	/*$.ajax({
		type: "POST",
		url: "../atributo/atributo_lista.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id: cat_id
		}),
		beforeSend: function() {
			$('#div_atributo_lista').html('Cargando...');
        },
		success: function(html){			
			$('#div_atributo_lista').html(html);
			if($("#hdd_atr_numfil").val() == 0){
				<!--$('#div_atributo_lista').html("La categoría no tiene atributos...");-->
				$('#div_atributo_lista').html("");				
			}
			if($("#hdd_atr_numfil").val() > 0){
				$('#div_atributo_lista').html(html);				
			}
		}
	});*/
}


function mensaje()
{
    $( "#txt_fil_pro_nom" ).focus(function() {
        alert( "Handler for .focus() called." );
    });
}
$(function() {
	
	//$("#txt_fil_pro_nom").focus();
	cmb_fil_pro_alm();
	cmb_fil_pro_cat();
	cmb_fil_pro_mar();
	
	//$( "#format_checks" ).buttonset();
	
	$( "#txt_fil_pro_nom" ).autocomplete({
   		minLength: 1,
   		source: "../producto/producto_complete_nom.php",
		select: function( event, ui ) {
			$("#txt_fil_pro_nom").val(ui.item.label)
			catalogo_tabla();
		}
    });
	
	$( "#txt_fil_pro_cod" ).autocomplete({
   		minLength: 1,
   		source: "../producto/presentacion_complete_cod.php",
		select: function() {
			catalogo_tabla();
		}
    });
	
	//para que no se precion el el enter
	$("#txt_fil_pro_nom").keypress(function(e){
		if(e.which == 13){
		  return false;
		}
	});


	
	$('#cmb_fil_pro_cat2').change(function() {
		var cat_id = $('#cmb_fil_pro_cat').val();
		if(cat_id == ""){
			//$("#div_atributo_lista").html("Seleccione Categoría...");
			$("#div_atributo_lista").html("");
		}else{
			atributo_lista(cat_id);	
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
<div>
<form name="for_fil_cat" id="for_fil_cat" target="_blank" action="<?php echo $modo?>" method="post">
<fieldset><legend>Filtro de producto</legend>
<input name="hdd_modo" id="hdd_modo" type="hidden" value="<?php echo $modo?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><label for="txt_fil_pro_nom">Nombre:</label>
      <input name="txt_fil_pro_nom" type="text" id="txt_fil_pro_nom" size="50"></td>
    <td><label for="txt_fil_pro_cod">Código:</label>
      <input name="txt_fil_pro_cod" type="text" id="txt_fil_pro_cod" size="20"></td>
    <td><div id="div_modo"></div></td>
  </tr>
  <tr>
    <td colspan="3"><label for="cmb_fil_pro_mar">Marca:</label>
      <select name="cmb_fil_pro_mar" id="cmb_fil_pro_mar">
        </select>
      <label for="cmb_fil_pro_cat">Categoría:</label>
      <select name="cmb_fil_pro_cat" id="cmb_fil_pro_cat">
      </select></td>
    <td><div id="div_atributo_lista" class="atributo_lista">  	
    </div></td>
  </tr>
  <tr>
    <td><?php /*?><label for="cmb_fil_pro_est">Estado:</label>
      <select name="cmb_fil_pro_est" id="cmb_fil_pro_est">
        <option value="">-</option>
        <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
        <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option>
      </select><?php */?>
      <label for="cmb_fil_pro_alm">Almacén:</label>
      <select name="cmb_fil_pro_alm" id="cmb_fil_pro_alm">
        </select>
        </td>
    <td><div id="div_fecha" style="display:none">
        <label for="txt_fil_inv_fec">Fecha Inventario:</label>
          <input name="txt_fil_inv_fec" type="text" class="fecha" id="txt_fil_inv_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly>
          </div></td>
    <td><div id="format_checks">
      <label for="chk_fil_catven">Catálogo de Venta</label>
      <input name="chk_fil_catven" id="chk_fil_catven" type="checkbox" value="1" checked>
      <label for="chk_fil_catcom">Catálogo de Compra</label>
      <input name="chk_fil_catcom" id="chk_fil_catcom" type="checkbox" value="1" checked>
      </div></td>
    <td><div id="format_checks">
      <label for="chk_fil_unibas">Unidad Base</label>
      <input name="chk_fil_unibas" id="chk_fil_unibas" type="checkbox" value="1">
    </div></td>
  </tr>
  <tr>
    <td colspan="2">
    <a href="#" onClick="catalogo_tabla()" id="btn_filtrar">Filtrar</a> 
    <a href="#" onClick="catalogo_filtro()" id="btn_pro_resfil">Restablecer</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</fieldset>
</form>

