<?php
session_start();
$alm_id=$_SESSION['almacen_id'];
?>
<script type="text/javascript">
function producto_datos(){	
	$.ajax({
		type: "POST",
		url: "../kardex/producto_historial_datos.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id: '<?php echo $_POST["cat_id"]?>'
		}),
		beforeSend: function() {
			//$('#div_catalogo_venta_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_producto_datos').html(html);
		},
		complete: function(){
			cmb_seleccionar_alm();
		}
	});
}

function cmb_seleccionar_alm(){	
	$.ajax({
		type: "POST",
		url: "../almacen/cmb_alm_id.php",
		async:false,
		dataType: "html",                      
		data: ({
			alm_id: '<?php echo $alm_id?>'
		}),
		beforeSend: function() {
			$('#cmb_almacen').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_almacen').html(html);
		},
		complete: function(){
			var alm_id = $("#cmb_almacen").val();
			var cat_id = $("#hdd_cat_sel_id").val();
			historial_tabla(cat_id, alm_id);
		}
	});
}

$("#cmb_almacen").change(function(){
	var alm_id = $("#cmb_almacen").val();
	var cat_id = $("#hdd_cat_sel_id").val();
	historial_tabla(cat_id, alm_id);
});

$(function(){
	producto_datos();
});
</script>
<div id="div_producto_datos">
</div>
<div>
	<fieldset>
        <legend>Almacén</legend>
        <label for="cmb_almacen">Almacén:</label>
        <select name="cmb_almacen" id="cmb_almacen">
            <option value="">-</option>              
        </select>
    </fieldset>
    <div id="msj_notalmacen" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
</div>
