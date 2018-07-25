<script type="text/javascript">
function catalogo_notalmacen_filtro()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_notalmacen_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_catalogo_notalmacen_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){			
			$('#div_catalogo_notalmacen_filtro').html(html);
		},
		complete: function(){
			//catalogo_notalmacen_tabla();
		}
	});
}

function catalogo_notalmacen_tabla()
{
	if($('#chk_fil_catven').is(':checked')) {  
		datven=1;
	} else {  
		datven=0;
	}
	if($('#chk_fil_catcom').is(':checked')) {  
		datcom=1;
	} else {  
		datcom=0;
	}
	if($('#chk_fil_unibas').is(':checked')) {  
		dunibas=1;
	} else {  
		dunibas=0;
	}
		
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_notalmacen_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_nom:	$('#txt_fil_pro_nom').val(),
			pro_cod:	$('#txt_fil_pro_cod').val(),
			pro_cat:	$('#cmb_fil_pro_cat').val(),
			pro_mar:	$('#cmb_fil_pro_mar').val(),
			pro_est:	$('#cmb_fil_pro_est').val(),
			alm_id:		$('#cmb_alm_id').val(),
			tipo:		$('#cmb_notalm_tip').val(),
			verven:		datven,
			vercom:		datcom,
			unibas:		dunibas,
			limit:		$("#cmb_fil_pro_lim").val()
			
		}),
		beforeSend: function() {
			$('#div_catalogo_notalmacen_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_catalogo_notalmacen_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogo_notalmacen_tabla').removeClass("ui-state-disabled");
		}
	});     
}

$(function() {
	catalogo_notalmacen_filtro();
});
</script>
<div id="div_catalogo_notalmacen_filtro">
</div>
<div id="div_catalogo_notalmacen_tabla">
</div>