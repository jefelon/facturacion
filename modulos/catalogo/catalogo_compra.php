<script type="text/javascript">
function catalogo_compra_filtro()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_compra_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_catalogo_compra_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_compra_filtro').html(html);
		},
		complete: function(){
			//catalogo_compra_tabla();
		}
	});
}

function catalogo_compra_tabla()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_compra_tabla.php",
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
			$('#div_catalogo_compra_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_catalogo_compra_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogo_compra_tabla').removeClass("ui-state-disabled");
			$('#msj_catalogo').hide();
            $('#tabla_producto tbody tr.:first-child .focus_precom').focus();
		}
	});     
}

$(function() {	
	catalogo_compra_filtro();
});
</script>
<div id="div_catalogo_compra_filtro">
</div>
<div id="div_catalogo_compra_tabla">
</div>