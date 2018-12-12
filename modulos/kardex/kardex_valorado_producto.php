<?php
session_start();
$alm_id=$_SESSION['almacen_id'];
$fec_ini = date('01-01-Y');
$fec_fin= date('d-m-Y');

?>
<script type="text/javascript">
    $( "#txt_kar_fecini, #txt_kar_fecfin" ).datepicker({
        minDate: new Date((new Date()).getFullYear(), 0, 1),
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
    $('#btn_filtrar').button({
        icons: {primary: "ui-icon-search"},
        text: true
    });
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
            var fec_ini = $("#txt_kar_fecini").val();
            var fec_fin = $("#txt_kar_fecfin").val();
            kardex_valorado_tabla(cat_id, alm_id, fec_ini, fec_fin);
		}
	});
}

$("#cmb_almacen").change(function(){
	var alm_id = $("#cmb_almacen").val();
	var cat_id = $("#hdd_cat_sel_id").val();
    var fec_ini = $("#txt_kar_fecini").val();
    var fec_fin = $("#txt_kar_fecfin").val();
	kardex_valorado_tabla(cat_id, alm_id, fec_ini, fec_fin);
});


$(function(){
	kardex_datos();
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
        <label for="txt_kar_fecini">Fecha Inicio:</label>
        <input name="txt_kar_fecini" type="text" class="fecha" id="txt_kar_fecini" value="<?php echo $fec_ini?>" size="10" maxlength="10">
        <label for="txt_kar_fecfin">Fecha Fin:</label>
        <input name="txt_kar_fecfin" type="text" class="fecha" id="txt_kar_fecfin" value="<?php echo $fec_fin?>" size="10" maxlength="10">
        <a href="#" onClick="kardex_valorado_tabla($('#hdd_cat_sel_id').val(), $('#cmb_almacen').val(), $('#txt_kar_fecini').val(), $('#txt_kar_fecfin').val());" id="btn_filtrar">Filtrar</a>
    </fieldset>
</div>