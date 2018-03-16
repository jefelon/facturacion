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
<title>Ingresos - Caja Terceros</title>
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
function ingreso_filtro()
{
	$.ajax({
		type: "POST",
		url: "ingreso_filtro.php",
		async:true,
		dataType: "html",                      
		data: ({
			act: 'ingreso_reporte.php'
		}),
		beforeSend: function() {
			$('#div_ingreso_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_ingreso_filtro').html(html);
		},
		complete: function(){
			ingreso_tabla();
		}
	});
}

function ingreso_tabla()
{
	$.ajax({
		type: "POST",
		url: "ingreso_tabla.php",
		async:true,
		dataType: "html",                      
		data: $("#for_fil_ing").serialize(),
		beforeSend: function() {
			$('#div_ingreso_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_ingreso_tabla').html(html);
		},
		complete: function(){			
			$('#div_ingreso_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function ingreso_form(act,idf){
	$.ajax({
		type: "POST",
		url: "ingreso_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ing_id:	idf,
			vista: 'ingreso_tabla'
		}),
		beforeSend: function() {
			$('#msj_ingreso').hide();
			$('#msj_ingreso_factura').hide();
			$('#div_ingreso_form').dialog("open");
			$('#div_ingreso_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_ingreso_form').html(html);				
		}
	});
}

function ingreso_eliminar(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "ingreso_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				ing_id:		id
			}),
			beforeSend: function() {
				$('#msj_ingreso').html("Cargando...");
				$('#msj_ingreso').show(100);
			},
			success: function(html){
				$('#msj_ingreso').html(html);
				$('#msj_ingreso').show();
			},
			complete: function(){
				ingreso_tabla();
			}
		});
	}
}

function factura_form(act,idf){
	$('#div_ingreso_form').dialog("close");
	$('#div_ingreso_form').html('ingreso');
	$.ajax({
		type: "POST",
		url: "factura_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			fac_id:	idf
		}),
		beforeSend: function() {
			$('#msj_ingreso_factura').hide();
			$('#div_ingreso_factura_form').dialog("open");
			$('#div_ingreso_factura_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_ingreso_factura_form').html(html);				
		}
	});
}

function ingreso_reporte()
{	
	$("#for_fil_ing").submit();
}

function ingreso_reporte_xls(){
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_ingreso").eq(0).clone()).html()); 
	$("#for_rep_xls").submit();
}

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
	
	$('#btn_imprimir_pdf').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
	
	$('#btn_imprimir_xls').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
		
	ingreso_filtro();		
	
	$( "#div_ingreso_form" ).dialog({
		title:'Información de Ingreso',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 800,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_ing").submit();
			},
			Cancelar: function() {
				$('#for_ing').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_ingreso_factura_form" ).dialog({
		title:'Información de Factura',
		autoOpen: false,
		resizable: false,
		height: 500,
		width: 940,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_fac").submit();
			},
			Cancelar: function() {
				$('#for_fac').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$(document).shortkeys({
	  'a+g':       function () { ingreso_form('insertar') }
	});
		
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
                    <td class="caption_cont">INGRESOS - CAJA TERCEROS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="6%" align="left" valign="middle"><a id="btn_agregar" title="Agregar (A+G)" href="#" onClick="ingreso_form('insertar')">Agregar</a></td>
                      <td width="6%" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle"><a class="btn_imprimir_pdf" id="btn_imprimir_pdf" href="#" onClick="ingreso_reporte()" title="Imprimir en Pdf">Pdf</a></td>
                      <td width="6%" align="left" valign="middle">
                      <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="ingreso_reporte_xls()" title="Imprimir en Excel">Excel</a>
                      <form action="../ingreso_r/ingreso_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
						<input type="hidden" id="hdd_tabla" name="hdd_tabla" /> 
						</form> 
                      </td>
                      <td align="right" width="72%">
                      <div id="msj_ingreso" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                      <div id="msj_ingreso_factura" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                      </td>
                    </tr>
                  </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    </td>
                  </tr>
              </table>
			</div>
        	<div id="div_ingreso_filtro" class="contenido_tabla">
      		</div>
            <div id="div_ingreso_form">
			</div>
            <div id="div_ingreso_factura_form">
			</div>
            <div id="div_ingreso_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>