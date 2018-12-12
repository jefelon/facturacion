<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("../../Clases/cLinea.php");
$oLinea = new cLinea();
require_once ("../../Clases/cTema.php");
$oTema = new cTema();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Categorías</title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.position.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.dialog.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.effects.core.js"></script>

<script src="../../js/vistaButton.js"></script>

<script src="../../js/formButton.js"></script>
<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>


<script type="text/javascript">
function actualizarArbol()
{	
	$.ajax({
		type: "POST",
		url: "tema_arbol.php",
		async:true,
		dataType: "html",                      
		/*data: ({
			cen: "<?php //echo $cen?>"
		})*/
		success: function(html){
			//$( "#i_loader" ).dialog( "open" );
			$('#div_tema_arbol').html(html);
			//$( "#i_loader" ).dialog( "close" );
		}/*,
		complete: function(){	
			$( "#i_loader" ).dialog( "close" );
		}*/
	});       
}

function insertarLinea()
{
	$.ajax({
		type: "POST",
		url: "linea_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "insertar"
		}),
		success: function(html){
			$('#div_linea_form').html(html);
		},
		complete: function(){			
			$( "#div_linea_form" ).dialog( "open" );
		}
	});
}

function editarLinea(id)
{
	$.ajax({
		type: "POST",
		url: "linea_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "editar",
			id: id
		}),
		success: function(html){
			$('#div_linea_form').html(html);
		},
		complete: function(){			
			$( "#div_linea_form" ).dialog( "open" );
		}
	});
}

function eliminarLinea(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "linea_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			success: function(html){
				//$('#i_loader').html(html);
				//$( "#i_loader" ).dialog( "close" );
			},
			complete: function(){			
				actualizarArbol();
			}
		});
	}
}

function insertarTema()
{
	$.ajax({
		type: "POST",
		url: "tema_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "insertar",
			lin:	$('#hdd_lin').val()
		}),
		success: function(html){
			$('#div_tema_form').html(html);
		},
		complete: function(){			
			$( "#div_tema_form" ).dialog( "open" );
		}
	});
}

function editarTema(id)
{
	$.ajax({
		type: "POST",
		url: "tema_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "editar",
			id: id
		}),
		success: function(html){
			$('#div_tema_form').html(html);
		},
		complete: function(){			
			$( "#div_tema_form" ).dialog( "open" );
		}
	});
}

function eliminarTema(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "tema_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			success: function(html){
				//$('#i_loader').html(html);
				//$( "#i_loader" ).dialog( "close" );
			},
			complete: function(){			
				actualizarArbol();
			}
		});
	}
}

function accionLinea(id,nom)
{
	$("#hdd_lin").attr('value',id);
	$("#txt_lin").attr('value',nom);
	$( "#div_linea_accion" ).dialog( "open" );
}

function accionTema(id,nom)
{
	$("#hdd_tem").attr('value',id);
	$("#txt_tem").attr('value',nom);
	$( "#div_tema_accion" ).dialog( "open" );
}

//
$(function() {

	actualizarArbol();
	
	$( "#btn_agregar" ).button().click(function() {
		insertarLinea();
	});
	
	$( "#div_linea_form" ).dialog({
		title:'Form Línea de Capacitación',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 'auto',
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_lin").submit();
			},
			Cancelar: function() {
				$('#for_lin').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			actualizarArbol();
		}
	});
	
	$( "#div_linea_accion" ).dialog({
		title:'Línea de Capacitación',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 'auto',
		modal: true,
		buttons: {
			'Modificar': function() {
				editarLinea($('#hdd_lin').val());
				$( this ).dialog( "close" );
			},
			'Agregar Tema': function() {
				insertarTema();
			},
			'Eliminar': function() {
				eliminarLinea($('#hdd_lin').val());
				$( this ).dialog( "close" );
			},
			'Cancelar': function() {
				$( this ).dialog( "close" );
			}
		}/*,
		close: function() {
			//actualizarArbol();
		}*/
	});	
	
	$( "#div_tema_form" ).dialog({
		title:'Form Tema de Capacitación',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 'auto',
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_tem").submit();
			},
			Cancelar: function() {
				$('#for_tem').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			actualizarArbol();
		}
	});
	
	$( "#div_tema_accion" ).dialog({
		title:'Tema de Capacitación',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 'auto',
		modal: true,
		buttons: {
			'Modificar': function() {
				editarTema($('#hdd_tem').val());
				$( this ).dialog( "close" );
			},
			'Eliminar': function() {
				eliminarTema($('#hdd_tem').val());
				$( this ).dialog( "close" );
			},
			'Cancelar': function() {
				$( this ).dialog( "close" );
			}
		}/*,
		close: function() {
			//actualizarArbol();
		}*/
	});	
	
	
	
	// cargar
	$( "#i_loader" ).dialog({
		autoOpen: false,
		minHeight: false,                  
		modal: true,
		resizable:false             
    });
	
});
</script>
<!--	<script type="text/javascript" src="jstree/_lib/jquery.cookie.js"></script>
	<script type="text/javascript" src="jstree/_lib/jquery.hotkeys.js"></script>
	<script type="text/javascript" src="jstree/jquery.jstree.js"></script>
	<link type="text/css" rel="stylesheet" href="jstree/_docs/syntax/!style.css"/>  
	<link type="text/css" rel="stylesheet" href="jstree/_docs/!style.css"/> 
	<script type="text/javascript" src="jstree/_docs/syntax/!script.js"></script>-->
</head>

<body>
<div id="div_linea_form">
</div>
<div id="div_tema_form">
</div>
<div id="div_linea_accion">
<input name="hdd_lin" id="hdd_lin" type="hidden" value="">
<input name="txt_lin" type="text" id="txt_lin" value="" size="50" readonly>
</div>
<div id="div_tema_accion">
<input name="hdd_tem" id="hdd_tem" type="hidden" value="">
<input name="txt_tem" type="text" id="txt_tem" value="" size="50" readonly>
</div>
<div class="container">
	<header>
    	<?php echo $oContenido->print_header()?>
	</header>
    <article class="content">
    	<div class="contenido">
		<section>
            <div class="contenido_des">
            <table align="center" class="tabla_cont">
                  <tr>
                    <td class="caption_cont">LINEA Y TEMA DE CAPACITACION</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle"><button id="btn_agregar">Agregar Línea</button> <button id="btn_actualizar">Actualizar</button></td>
                      <td width="25" align="left" valign="middle"></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right">&nbsp;</td>
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
		</section>
        <section>
        	<div style="margin-left:12px">
        		<div id="div_tema_arbol">
      			</div>
            </div>
        </section>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>