<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
//if($_SESSION['usergrupo_id']> 2){ header("location: inicioEjec.php"); exit();}

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Lista de Usuarios</title>
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
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.tabs.js"></script>

<script src="../../js/vistaButton.js"></script>

<script src="../../js/formButton.js"></script>
<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
function cargar_tabla_usuario()
{	
	$.ajax({
		type: "POST",
		url: "usuario_tabla_sup.php",
		async:true,
		dataType: "html",                      
		/*data: ({
			fun: "<?php //echo $fun?>"
		})*/
		success: function(html){
			//$( "#i_loader" ).dialog( "open" );
			$('#div_usuario_tabla').html(html);
			//$( "#i_loader" ).dialog( "close" );
		}/*,
		complete: function(){	
			$( "#i_loader" ).dialog( "close" );
		}*/
	});       
}

function insertar_usuario()
{
	$.ajax({
		type: "POST",
		url: "usuario_form_sup.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "insertar"
		}),
		success: function(html){
			$('#div_usuario_form').html(html);
		},
		complete: function(){			
			$( "#div_usuario_form" ).dialog( "open" );
		}
	});
}

function editar_usuario(id)
{
	$.ajax({
		type: "POST",
		url: "usuario_form_sup.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "editar",
			id: id
		}),
		success: function(html){
			$('#div_usuario_form').html(html);
		},
		complete: function(){			
			$( "#div_usuario_form" ).dialog( "open" );
		}
	});
}

function eliminar_usuario(id)
{     
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "usuario_reg_eliminar.php",
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
				cargar_tabla_usuario();
			}
		});
	}
}


//
$(function() {

	cargar_tabla_usuario();
	
	$( "#btn_agregar" ).button().click(function() {
		insertar_usuario();
	});
	
	
	//dialogo
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	$( "#div_usuario_form" ).dialog({
		title:'Form Usuario',
		autoOpen: false,
		resizable: false,
		minheight: 400,
		//width: 'auto',
		width: 750,
		modal: true,
		buttons: {
			'Guardar': function() {
				$("#for_usu").submit();
			},
			'Cancelar': function() {
				$('#for_usu').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			cargar_tabla_usuario();
		}
	});
	
	// cargar
	$( "#i_loader" ).dialog({
		autoOpen: false,
		minHeight: false,                  
		modal: true,
		resizable:false,
		buttons: {
			Aceptar: function() {
				$( this ).dialog( "close" );
			}
		}          
    });
	
});

</script>
</head>
<body>
<div id="div_usuario_form">
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
        <td class="caption_cont">LISTA DE USUARIOS - SUPER USUARIO</td>
      </tr>
      <tr>
        <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" align="left" valign="middle"><button id="btn_agregar">Agregar</button></td>
          <td width="25" align="left" valign="middle"><button id="btn_actualizar">Actualizar</button></td>
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
        	<div id="div_usuario_tabla" class="contenido_tabla">
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