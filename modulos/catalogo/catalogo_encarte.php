<script type="text/javascript">
function catalogo_encarte_filtro()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_encarte_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_catalogo_encarte_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_encarte_filtro').html(html);
		},
		complete: function(){
			//catalogo_encarte_tabla();
		}
	});
}

function catalogo_encarte_tabla()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_encarte_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_nom:	$('#txt_fil_pro_nom').val(),
			pro_cod:	$('#txt_fil_pro_cod').val(),
			pro_cat:	$('#cmb_fil_pro_cat').val(),
			pro_mar:	$('#cmb_fil_pro_mar').val(),
			pro_est:	$('#cmb_fil_pro_est').val(),
			limit: 		$("#cmb_fil_pro_lim").val(),
			enc_despor: 		$("#txt_enc_despor").val()
		}),
		beforeSend: function() {
			$('#msj_catalogo').html("Cargando...");
			$('#msj_catalogo').show(100);
			$('#div_catalogo_encarte_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_catalogo_encarte_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogo_encarte_tabla').removeClass("ui-state-disabled");
			$('#msj_catalogo').hide();
		}
	});     
}

$(function() {	
	catalogo_encarte_filtro();
});
</script>
<div id="div_catalogo_encarte_filtro">
</div>
<div id="div_catalogo_encarte_tabla">
</div>