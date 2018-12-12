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
<title>Guías de Remisión</title>
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
<!--<script type="text/javascript" src="../../js/autofocus/autofocus.js"></script>-->

<script type="text/javascript">
function guia_filtro()
{
	$.ajax({
		type: "POST",
		url: "guia_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//guia: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_guia_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_guia_filtro').html(html);
		},
		complete: function(){
			guia_tabla();
		}
	});
}

function guia_tabla(){	
	$.ajax({
		type: "POST",
		url: "guia_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			gui_fec1:	$('#txt_fil_gui_fec1').val(),
			gui_fec2:	$('#txt_fil_gui_fec2').val(),
			con_id:		$('#txt_fil_con_id').val(),//Conductor
			tra_id:		$('#txt_fil_tra_id').val(),//Transporte			
			gui_est:	$('#cmb_fil_gui_est').val()//Estados			
		}),
		beforeSend: function() {
			$('#div_guia_tabla').addClass("ui-state-disabled");
        },
		success: function(html){			
			$('#div_guia_tabla').html(html);
		},
		complete: function(){						
			$('#div_guia_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function guia_form(act,idf){
	$.ajax({
		type: "POST",
		url: "guia_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			gui_id:	idf
		}),
		beforeSend: function() {
			$('#msj_guia').hide();
			$('#div_guia_form').dialog("open");
			$('#div_guia_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_guia_form').html(html);				
		}
	});
}

function guia_anular(id)
{      
	if(confirm("Realmente desea anular guia, se actualizará el stock. Continuar?")){
		$.ajax({
			type: "POST",
			url: "guia_anular.php",
			async:true,
			dataType: "json",
			data: ({
				action: "anular",
				gui_id:		id
			}),
			beforeSend: function() {
				$('#msj_guia').html("Cargando...");
				$('#msj_guia').show(100);
			},
			success: function(data){
				if(data.act!='correcto')
				{
					$('#div_guia_anular').dialog("open");
					$('#div_guia_anular').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
					$('#div_guia_anular').html(data.htm);
				}
				$('#msj_guia').html(data.msj);
			},
			complete: function(){
				guia_tabla();
			}
		});
	}
}
	
function eliminar_guia(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "guia_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				gui_id:		id
			}),
			beforeSend: function() {
				$('#msj_guia').html("Cargando...");
				$('#msj_guia').show(100);
			},
			success: function(html){
				$('#msj_guia').html(html);
				$('#msj_guia').show();
			},
			complete: function(){
				guia_tabla();
			}
		});
	}
}

function guia_reporte()
{	
	$("#for_fil_gui").submit();
}

function guia_reporte_xls(){
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_guia").eq(0).clone()).html()); 
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
		
	guia_filtro();		
	
	$( "#div_guia_form" ).dialog({
		title:'Información de Guía',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 940,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_gui").submit();
			},
			Cancelar: function() {
				$('#for_gui').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_guia_anular" ).dialog({
		title:'Anular Guía',
		autoOpen: false,
		resizable: false,
		height: 270,
		width: 520,
		modal: true,
		buttons: {
			OK: function() {
				//$('#for_gui').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$(document).shortkeys({
	  'a+g':       function () { guia_form('insertar') }
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
                    <td class="caption_cont">GUÍA DE REMISIÓN</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="6%" align="left" valign="middle"><a id="btn_agregar" title="Agregar (A+G)" href="#" onClick="guia_form('insertar')">Agregar</a></td>
                      <td width="6%" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle"><a class="btn_imprimir_pdf" id="btn_imprimir_pdf" href="#" onClick="guia_reporte()" title="Imprimir en Pdf">Pdf</a></td>
                      <td width="6%" align="left" valign="middle">
                      <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="guia_reporte_xls()" title="Imprimir en Excel">Excel</a>
                      <form action="guia_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
						<input type="hidden" id="hdd_tabla" name="hdd_tabla" /> 
						</form> 
                      </td>
                      <td align="right" width="72%">
                      <div id="msj_guia" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_guia_filtro" class="contenido_tabla">
      		</div>
            <div id="div_guia_form">
			</div>
            <div id="div_guia_anular">
			</div>
            <div id="div_guia_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>