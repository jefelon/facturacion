<script type="text/javascript">
function catalogo_servicio_filtro()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_servicio_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_catalogo_servicio_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_servicio_filtro').html(html);
		},
		complete: function(){
			//catalogo_servicio_tabla();
		}
	});
}

function catalogo_servicio_tabla(){
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_servicio_compra_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			ser_nom:	$('#txt_fil_ser_nom').val(),			
			ser_cat:	$('#cmb_fil_ser_cat').val(),			
			ser_est:	$('#cmb_fil_ser_est').val(),
			limit: 		$("#cmb_fil_ser_lim").val()	
		}),
		beforeSend: function() {
			$('#msj_catalogo_servicio').html("Cargando...");
			$('#msj_catalogo_servicio').show(100);
			$('#div_catalogo_servicio_tabla').addClass("ui-state-disabled");
        },
		success: function(html){				
			$('#div_catalogo_servicio_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogo_servicio_tabla').removeClass("ui-state-disabled");
			$('#msj_catalogo_servicio').hide();
		}
	});     
}

$(function() {
	catalogo_servicio_filtro();
});
</script>
<div id="div_catalogo_servicio_filtro">
</div>
<div id="div_catalogo_servicio_tabla">
</div>