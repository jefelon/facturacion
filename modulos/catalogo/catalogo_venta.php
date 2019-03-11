<script type="text/javascript">
function catalogo_venta_filtro()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_venta_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_catalogo_venta_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_venta_filtro').html(html);
		},
		complete: function(){
			catalogo_venta_tabla();
		}
	});
}

function catalogo_venta_tabla(){	
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_venta_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_nom:	$('#txt_fil_pro_nom').val(),
			pro_cod:	$('#txt_fil_pro_cod').val(),
			pro_cat:	$('#cmb_fil_pro_cat').val(),
			pro_mar:	$('#cmb_fil_pro_mar').val(),
			pro_est:	$('#cmb_fil_pro_est').val(),
            cbox1:	    $('#cbox1').prop('checked'),
            cbox2:	    $('#cbox2').prop('checked'),
			limit: 		$("#cmb_fil_pro_lim").val()
			
		}),
		beforeSend: function() {
			$('#msj_catalogo').html("Cargando...");
			$('#msj_catalogo').show(100);
			$('#div_catalogo_venta_tabla').addClass("ui-state-disabled");
        },
		success: function(html){				
			$('#div_catalogo_venta_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogo_venta_tabla').removeClass("ui-state-disabled");
			$('#msj_catalogo').hide();
		}
	});     
}

$(function() {
	catalogo_venta_filtro();
});
</script>
<div id="div_catalogo_venta_filtro">
</div>
<div id="div_catalogo_venta_tabla">
</div>