<script type="text/javascript">
function catalogo_producto_filtro()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_seleccionar_producto_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_catalogo_producto_historial_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_producto_historial_filtro').html(html);
		},
		complete: function(){
			//catalogo_producto_tabla();
		}
	});
}

function catalogo_producto_tabla(){	
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_seleccionar_producto_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_nom:	$('#txt_fil_pro_nom').val(),
			pro_cod:	$('#txt_fil_pro_cod').val(),
			pro_cat:	$('#cmb_fil_pro_cat').val(),
			pro_mar:	$('#cmb_fil_pro_mar').val(),
			pro_est:	$('#cmb_fil_pro_est').val(),
			limit: 		$("#cmb_fil_pro_lim").val()
			
		}),
		beforeSend: function() {
			$('#div_catalogo_producto_historial_tabla').addClass("ui-state-disabled");
        },
		success: function(html){				
			$('#div_catalogo_producto_historial_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogo_producto_historial_tabla').removeClass("ui-state-disabled");
		}
	});     
}

$(function() {
	catalogo_producto_filtro();
});
</script>
<div id="div_catalogo_producto_historial_filtro">
</div>
<div id="div_catalogo_producto_historial_tabla">
</div>