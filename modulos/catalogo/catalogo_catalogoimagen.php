<script type="text/javascript">
function catalogo_catalogoimagen_filtro()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_catalogoimagen_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_catalogo_catalogoimagen_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_catalogoimagen_filtro').html(html);
		},
		complete: function(){
			//catalogo_catalogoimagen_tabla();
		}
	});
}

function catalogo_catalogoimagen_tabla()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_catalogoimagen_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_nom:	$('#txt_fil_pro_nom').val(),
			pro_cod:	$('#txt_fil_pro_cod').val(),
			pro_cat:	$('#cmb_fil_pro_cat').val(),
			pro_mar:	$('#cmb_fil_pro_mar').val(),
			pro_est:	$('#cmb_fil_pro_est').val(),
			limit: 		$("#cmb_fil_pro_lim").val(),
			tippre:		$('#cmb_com_tippre').val(),
			mon:		$('#cmb_com_mon').val(),
			tipcam:		$('#txt_com_tipcam').val()	
		}),
		beforeSend: function() {
			$('#msj_catalogo').html("Cargando...");
			$('#msj_catalogo').show(100);
			$('#div_catalogo_catalogoimagen_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_catalogo_catalogoimagen_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogo_catalogoimagen_tabla').removeClass("ui-state-disabled");
			$('#msj_catalogo').hide();
		}
	});     
}

$(function() {	
	catalogo_catalogoimagen_filtro();
});
</script>
<div id="div_catalogo_catalogoimagen_filtro">
</div>
<div id="div_catalogo_catalogoimagen_tabla">
</div>