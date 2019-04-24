<?php
session_start();
$alm_id=$_SESSION['almacen_id'];
?>
<script type="text/javascript">
function kardex_datos(){	
	$.ajax({
		type: "POST",
		url: "../kardex/kardex_producto_datos.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id: '<?php echo $_POST["cat_id"]?>'
		}),
		beforeSend: function() {
			//$('#div_catalogo_venta_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_producto_kardex_datos').html(html);
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
			kardex_tabla(cat_id, alm_id);
		}
	});
}

$("#cmb_almacen").change(function(){
	var alm_id = $("#cmb_almacen").val();
	var cat_id = $("#hdd_cat_sel_id").val();		
	kardex_tabla(cat_id, alm_id);
});


$(function(){
	kardex_datos();
    $('#btn_imp_xls').button({
        icons: {primary: "ui-icon-print"},
        text: true
    });
});
</script>
<div id="div_producto_kardex_datos">
</div>
<div>
	<fieldset>
        <legend>Almacen</legend>
        <label for="cmb_almacen">Almacen:</label>
        <select name="cmb_almacen" id="cmb_almacen">
            <option value="">-</option>              
        </select>
        <a class="btn_imp_xls" id="btn_imp_xls" href="#" onClick="karde_valorado_reporte_xls()" title="Imprimir en Excel">Excel</a>
        <form action="kardex_reporte_valorado_xls.php" method="post" target="_blank" id="for_rep_valorado_xls">
            <input type="hidden" id="hdd_tabla_valorada" name="hdd_tabla_valorada" />
        </form>
    </fieldset>
</div>