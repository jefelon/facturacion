<?php
session_start();
	if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
	require_once ("../../config/Cado.php");
	
	require_once ("../contenido/contenido.php");
	$oContenido = new cContenido();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Compras</title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery-ui-1.8.16.custom.js"></script>
<script src="../../js/jquery-ui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.position.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.dialog.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.tabs.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.autocomplete.js"></script>

<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/i18n/jquery.ui.datepicker-es.js"></script>

<script src="../../js/jquery-ui/development-bundle/external/jquery.metadata.js"></script>
<script src="../../js/Moneda/autoNumeric.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript" src="../../js/jquery-shortkeys/shortkeys.js"></script>

<script type="text/javascript">
function compra_filtro()
{
	$.ajax({
		type: "POST",
		url: "compra_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//compra: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_compra_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_compra_filtro').html(html);
		},
		complete: function(){
			compra_tabla();
		}
	});
}

function compra_tabla()
{
	$.ajax({
		type: "POST",
		url: $('#hdd_modo').val(),
		async:true,
		dataType: "html",                      
		data: ({
			com_fec1:	$('#txt_fil_com_fec1').val(),
			com_fec2:	$('#txt_fil_com_fec2').val(),
			com_mon:	$('#cmb_fil_com_mon').val(),
			pro_id:		$('#hdd_fil_pro_id').val(),
			com_est:	$('#cmb_fil_com_est').val()
			
		}),
		beforeSend: function() {
			$('#div_compra_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_compra_tabla').html(html);
		},
		complete: function(){			
			$('#div_compra_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function compra_form(act,idf){
	$.ajax({
		type: "POST",
		url: "compra_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			com_id:	idf
		}),
		beforeSend: function() {
			$('#msj_compra').hide();
			$('#div_compra_form').dialog("open");
			$('#div_compra_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_compra_form').html(html);				
		}
	});
}

function compra_precios(act){
	$.ajax({
		type: "POST",
		url: "compra_precios.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act
		}),
		beforeSend: function() {
			//$('#msj_compra').hide();
			$('#div_compra_precios').dialog("open");
			$('#div_compra_precios').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_compra_precios').html(html);				
		}
	});
}

function compra_precio_form(act,comid){
	$.ajax({
		type: "POST",
		url: "compra_precio_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			com_id: comid
		}),
		beforeSend: function() {
			//$('#msj_compra').hide();
			$('#div_compra_precios').dialog("open");
			$('#div_compra_precios').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_compra_precios').html(html);				
		}
	});
}

function compra_anular(id)
{
	$('#msj_compra').hide();     
	if(confirm("Realmente desea anular compra, se actualizará el stock. Desea continuar?")){
		$.ajax({
			type: "POST",
			url: "compra_anular.php",
			async:true,
			dataType: "json",
			data: ({
				action: "anular",
				com_id:		id
			}),
			beforeSend: function() {
				$('#msj_compra').html("Cargando...");
				$('#msj_compra').show(100);
			},
			success: function(data){
				if(data.act!='correcto')
				{
					$('#div_compra_anular').dialog("open");
					$('#div_compra_anular').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
					$('#div_compra_anular').html(data.htm);
				}
				$('#msj_compra').html(data.msj);
			},
			complete: function(){
				compra_tabla();
			}
		});
	}
}
	
function eliminar_compra(id)
{    
	$('#msj_compra').hide();  
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "compra_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				com_id:		id
			}),
			beforeSend: function() {
				$('#msj_compra').html("Cargando...");
				$('#msj_compra').show(100);
			},
			success: function(html){
				$('#msj_compra').html(html);
				$('#msj_compra').show();
			},
			complete: function(){
				compra_tabla();
			}
		});
	}
}

function compra_reporte()
{	
	$("#for_fil_com").submit();
}

function compra_reporte_xls(){
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_compra").eq(0).clone()).html()); 
	$("#for_rep_xls").submit();
}

function modo(url){
	$('#hdd_modo').val(url);
	compra_tabla();
};

$(function() {
	
	$('#btn_actualizar').button({
		icons: {primary: "ui-icon-arrowrefresh-1-e"},
		text: true
		}).click(function() {
		location.reload();
	});
	
	$('#btn_agregar').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});
	
	$('.btn_modo').button({
		icons: {primary: "ui-icon-document"},
		text: true
	});
	
	$('#btn_imprimir_pdf').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
	
	$('#btn_imprimir_xls').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
		
	compra_filtro();		
	
	$( "#div_compra_form" ).dialog({
		title:'Información de Compra | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 980,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_com").submit();
			},
			Cancelar: function() {
				$('#for_com').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$('#div_catalogo_compra').dialog( "close" );
			$('#div_compra_form').html('compra_form');
		}
	});
	
	$( "#div_compra_precios" ).dialog({
		title:'Actualización de Precios de Venta',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 980,
		modal: true,
		position: "top",
		closeOnEscape: false,
        open: function(event, ui) {
            $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
        },
		buttons: {
			//Guardar: function() {
			//	$("#for_com_pre").submit();
			//},
			Terminar: function() {
				$('#for_com_pre').each (function(){this.reset();});
				$( this ).dialog( "close" );

                $(location).attr('href',"compra_vista_adm_registro.php");
			}
		}
	});
	
	$( "#div_compra_anular" ).dialog({
		title:'Anular Compra',
		autoOpen: false,
		resizable: false,
		height: 270,
		width: 520,
		modal: true,
		buttons: {
			OK: function() {
				//$('#for_com').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$(document).shortkeys({
	  'a+g':       function () { compra_form('insertar') }
	});

    compra_form('insertar');
		
});
</script>

</head>

<body>

<div class="container">
	<header>
    	<?php echo $oContenido->print_header()?>
  </header>
    <article class="content">
    	<div class="contenido">
            <div class="contenido_des">
            <table align="center" class="tabla_cont">
                  <tr>
                    <td class="caption_cont">COMPRAS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    </td>
                  </tr>
              </table>
			</div>
            <div id="div_compra_form">
			</div>
            <div id="div_compra_precios">
			</div>
            <div id="div_compra_anular">
			</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>