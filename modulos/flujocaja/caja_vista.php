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
<title>Consulta Caja General</title>
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
function caja_filtro()
{
	$.ajax({
		type: "POST",
		url: "caja_filtro.php",
		async:true,
		dataType: "html",                      
		data: ({
			
		}),
		beforeSend: function() {
			$('#div_caja_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_caja_filtro').html(html);
		},
		complete: function(){
			caja_tabla();
		}
	});
}

function caja_tabla()
{
	if($('#cmb_fil_caj_id').val()>0)
	{
		ingreso_tabla();
		egreso_tabla();
		saldo_tabla();
	}
	else
	{
		$('#div_ingreso_tabla').html('');
		$('#div_egreso_tabla').html('');
		$('#div_saldo_tabla').html('');
		alert('Seleccione una Caja para mostrar información.');
	}
}

function ingreso_tabla()
{
	$.ajax({
		type: "POST",
		url: "caja_tabla_ingreso.php",
		async:true,
		dataType: "html",                      
		data: $("#for_fil_caj").serialize(),
		beforeSend: function() {
			$('#div_ingreso_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_ingreso_tabla').html(html);
		},
		complete: function(){
			saldo_tabla()		
			$('#div_ingreso_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function ingreso_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../ingreso/ingreso_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ing_id:	idf,
			caj_id: $('#cmb_fil_caj_id').val(),
			vista: 'ingreso_tabla'
		}),
		beforeSend: function() {
			$('#msj_ingreso').hide();
			$('#div_egreso_form').html('');
			
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
			url: "../ingreso/ingreso_reg.php",
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
				saldo_tabla()
			}
		});
	}
}

function ingreso_impresion(idf){
	$.ajax({
		type: "POST",
		url: "../ingreso/ingreso_impresion.php",
		async:true,
		dataType: "html",                      
		data: ({
			ing_id:	idf
		}),
		beforeSend: function() {
			$('#div_ingreso_impresion').dialog("open");
			$('#div_ingreso_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_ingreso_impresion').html(html);				
		}
	});
}

function egreso_tabla()
{
	$.ajax({
		type: "POST",
		url: "caja_tabla_egreso.php",
		async:true,
		dataType: "html",                      
		data: $("#for_fil_caj").serialize(),
		beforeSend: function() {
			$('#div_egreso_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_egreso_tabla').html(html);
		},
		complete: function(){
			saldo_tabla()			
			$('#div_egreso_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function egreso_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../egreso/egreso_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			egr_id:	idf,
			caj_id: $('#cmb_fil_caj_id').val(),
			vista: 'egreso_tabla'
		}),
		beforeSend: function() {
			$('#msj_egreso').hide();
			$('#div_ingreso_form').html('');
			
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
			url: "../egreso/egreso_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				gas_id:		id
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
				saldo_tabla()
			}
		});
	}
}
function egreso_impresion(idf){
	$.ajax({
		type: "POST",
		url: "../egreso/egreso_impresion.php",
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

function transferencia_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../transferencia/transferencia_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			tra_id:	idf,
			caj_id: $('#cmb_fil_caj_id').val(),
			vista: 'caja_tabla'
		}),
		beforeSend: function() {
			$('#msj_transferencia').hide();
			$('#div_transferencia_form').dialog("open");
			$('#div_transferencia_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_transferencia_form').html(html);				
		}
	});
}
function saldo_tabla()
{
	$.ajax({
		type: "POST",
		url: "caja_tabla_saldo.php",
		async:true,
		dataType: "html",                      
		data: $("#for_fil_caj").serialize(),
		beforeSend: function() {
			$('#div_saldo_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_saldo_tabla').html(html);
		},
		complete: function(){			
			$('#div_saldo_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function caja_reporte(url)
{	
	$("#for_fil_caj").attr("action", url);
	$("#for_fil_caj").submit();
}

$(function() {
	
	$('#btn_actualizar').button({
		icons: {primary: "ui-icon-arrowrefresh-1-e"},
		text: true
		}).click(function() {
		location.reload();
	});
	
	$('#btn_agregar_ing').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});
	$('#btn_agregar_gas').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});
	$('#btn_agregar_tra').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});
	$('.imprimir_pdf').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
		
	caja_filtro();		
	
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
			<?php //if($_SESSION['usuariogrupo_id']==3){?>
			Guardar: function() {
				$("#for_ing").submit();
			},
			<?php //}?>
			Cancelar: function() {
				$('#for_ing').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	$( "#div_egreso_form" ).dialog({
		title:'Información de Egreso',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 750,
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
	
	$( "#div_transferencia_form" ).dialog({
		title:'Información de Transferencia',
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
				$("#for_tra").submit();
			},
			<?php //}?>
			Cancelar: function() {
				$('#for_tra').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});

	$( "#div_ingreso_impresion" ).dialog({
		title:'Desea Imprimir Documento?',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 370,
		modal: true,
		position: 'top'
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
                    <td class="caption_cont">CONSULTA CAJA GENERAL</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10%" align="left" valign="middle"><a id="btn_agregar_ing" href="#" onClick="ingreso_form('insertar')">Ingreso</a></td>
                      <td width="10%" align="left" valign="middle"><a id="btn_agregar_gas" href="#" onClick="egreso_form('insertar')">Egreso</a></td>
                      <td width="10%" align="left" valign="middle">
						<?php /*?>
                      <a id="btn_agregar_tra" href="#" onClick="transferencia_form('insertar')">Transferencia</a>
						<?php */?>
                      </td>
                      <td width="6%" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle"></td>
                      <td width="6%" align="left" valign="middle"><a class="imprimir_pdf" id="btn_imprimir_pdf" href="#" onClick="caja_reporte('caja_reporte.php')" title="Imprimir en Pdf">Reporte</a></td>
                      <td width="6%" align="left" valign="middle"></td>
                      <td align="right" width="72%">
                      <div id="msj_ingreso" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                      <div id="msj_egreso" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                      <div id="msj_transferencia" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_caja_filtro" class="contenido_tabla">
      		</div>
            <div id="div_ingreso_form">
			</div>
			<div id="div_ingreso_impresion">
			</div>
            <div id="div_egreso_form">
			</div>
			<div id="div_egreso_impresion">
			</div>
            <div id="div_transferencia_form">
			</div>
            
            <div class="ui-widget-header ui-corner-all" style="width:auto; padding:2px; margin:3px">INGRESOS</div>
            <div id="div_ingreso_tabla" class="contenido_tabla">
      		</div>
            </br>
            
            <div class="ui-widget-header ui-corner-all" style="width:auto; padding:2px; margin:3px">EGRESOS</div>
            <div id="div_egreso_tabla" class="contenido_tabla">
      		</div>
            </br>
            
            <div class="ui-widget-header ui-corner-all" style="width:auto; padding:2px; margin:3px">CONSULTA SALDO CAJA</div>
            <div id="div_saldo_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>