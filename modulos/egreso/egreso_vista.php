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
<title>Egresos - Caja</title>
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

<script type="text/javascript">
function egreso_filtro()
{
	$.ajax({
		type: "POST",
		url: "egreso_filtro.php",
		async:true,
		dataType: "html",                      
		data: ({
		}),
		beforeSend: function() {
			$('#div_egreso_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_egreso_filtro').html(html);
		},
		complete: function(){
			egreso_tabla();
		}
	});
}

function egreso_tabla()
{
	$.ajax({
		type: "POST",
		url: "egreso_tabla.php",
		async:true,
		dataType: "html",                      
		data: $("#for_fil_egr").serialize(),
		beforeSend: function() {
			$('#msj_egreso_tabla').html("Cargando...");
			$('#msj_egreso_tabla').show(100);
			$('#div_egreso_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_egreso_tabla').html(html);
		},
		complete: function(){			
			$('#div_egreso_tabla').removeClass("ui-state-disabled");
			$('#msj_egreso_tabla').hide();
		}
	});     
}
	
function egreso_form(act,idf){
	$.ajax({
		type: "POST",
		url: "egreso_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			egr_id:	idf,
			vista: 'egreso_tabla'
		}),
		beforeSend: function() {
			$('#msj_egreso').hide();
			$('#msj_egreso_factura').hide();
			$('#div_egreso_form').dialog("open");
			$('#div_egreso_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_egreso_form').html(html);				
		}
	});
}

function egreso_eliminar(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "egreso_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				egr_id:		id
			}),
			beforeSend: function() {
				$('#msj_egreso').html("Cargando...");
				$('#msj_egreso').show(100);
			},
			success: function(html){
				$('#msj_egreso').html(html);
				$('#msj_egreso').show();
			},
			complete: function(){
				egreso_tabla();
			}
		});
	}
}

function egreso_impresion(idf){
	$.ajax({
		type: "POST",
		url: "egreso_impresion.php",
		async:true,
		dataType: "html",                      
		data: ({
			egr_id:	idf
		}),
		beforeSend: function() {
			$('#div_egreso_impresion').dialog("open");
			$('#div_egreso_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_egreso_impresion').html(html);				
		}
	});
}

function egreso_reporte(url)
{	
	$("#for_fil_egr").attr("action", url);
	$("#for_fil_egr").submit();
}

function egreso_reporte_xls(){
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_egreso").eq(0).clone()).html()); 
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
		
	egreso_filtro();		
	
	$( "#div_egreso_form" ).dialog({
		title:'Información de Egreso',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 800,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			<?php //if($_SESSION['usuariogrupo_id']==3){?>
			Guardar: function() {
				$("#for_egr").submit();
			},
			<?php //}?>
			Cancelar: function() {
				$('#for_egr').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_egreso_impresion" ).dialog({
		title:'Desea Imprimir Documento?',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 370,
		modal: true,
		position: 'top'
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
                    <td class="caption_cont">EGRESOS - CAJA</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="6%" align="left" valign="middle"><a id="btn_agregar" title="Agregar (A+G)" href="#" onClick="egreso_form('insertar')">Agregar</a></td>
                      <td width="6%" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle"><a class="btn_imprimir_pdf" id="btn_imprimir_pdf" href="#" onClick="egreso_reporte('egreso_reporte.php')" title="Imprimir en Pdf">Pdf</a></td>
                      <td width="6%" align="left" valign="middle">
                      <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="egreso_reporte_xls()" title="Imprimir en Excel">Excel</a>
                      <form action="egreso_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
						<input type="hidden" id="hdd_tabla" name="hdd_tabla" /> 
						</form> 
                      </td>
                      <td align="right" width="72%">
                      <div id="msj_egreso" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                      <div id="msj_egreso_tabla" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_egreso_filtro" class="contenido_tabla">
      		</div>
            <div id="div_egreso_form">
			</div>
            <div id="div_egreso_impresion">
			</div>
            <div id="div_egreso_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>