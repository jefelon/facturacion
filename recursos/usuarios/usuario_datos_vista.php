<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../../config/Cado.php");
//if($_SESSION['usergrupo_id']> 2){ header("location: inicioEjec.php"); exit();}

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Mis datos</title>
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

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
//cargas

function cargar_usuario_detalle()
{
	$.ajax({
		type: "POST",
		url: "usuario_datos_detalle.php",
		async:true,
		dataType: "html",                      
		data: ({
			id: <?php echo $_SESSION['usuario_id']?>
		}),
		beforeSend: function() {
			$('#div_usuario_detalle').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        }, 
		success: function(html){
			$('#div_usuario_detalle').html(html);
		}
	});
}

function editar_usuario(id)
{
	$.ajax({
		type: "POST",
		url: "usuario_datos_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "editar",
			id: id
		}),
		beforeSend: function() {
			$( "#div_usuario_form" ).dialog( "open" );
			$('#div_usuario_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_usuario_form').html(html);
		}
	});
}
function editar_usuario_pass(id){		
	$.ajax({
		type: "POST",
		url: "usuario_pass_form.php",
		async:true,
		dataType: "html",                      
		data: ({					
			id:		id		
		}),
		beforeSend: function() {
			$( "#div_usuario_pass_form" ).dialog( "open" );
			$('#div_usuario_pass_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){				
			$('#div_usuario_pass_form').html(html);
		}
	});
}

function editar_usuario_user(id){		
	$.ajax({
		type: "POST",
		url: "usuario_user_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: 'editar',					
			id:		id		
		}),
		beforeSend: function() {
			$( "#div_usuario_user_form" ).dialog( "open" );
			$('#div_usuario_user_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){				
			$('#div_usuario_user_form').html(html);
		}
	});
}

//
$(function() {
	
//botones
	$('.btn_editar_datos').button({
		icons: {primary: "ui-icon-pencil"},
		text: true
	});
	$('.btn_editar_use').button({
		icons: {primary: "ui-icon-person"},
		text: true
	});
	$('.btn_editar_pas').button({
		icons: {primary: "ui-icon-key"},
		text: true
	});
	
	$('#btn_actualizar').button({icons: {primary: "ui-icon-arrowrefresh-1-e"}}).click(function() {
		location.reload();
	});

	cargar_usuario_detalle();
	//dialogo
	
	$( "#div_usuario_form" ).dialog({
		title:'Registro de Usuario',
		autoOpen: false,
		resizable: false,
		height: 500,
		width: 850,
		modal: true,
		buttons: {
			'Guardar': function() {
				$("#for_usu").submit();
			},
			'Cancelar': function() {
				$('#for_usu').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_usuario_pass_form" ).dialog({
		title:'Cambiar Contraseña',
		autoOpen: false,
		resizable: false,
		height: 200,
		width: 450,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_usu_pas").submit();
			},
			Cancelar: function() {
				$('#for_usu_pas').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_usuario_user_form" ).dialog({
		title:'Cambiar Nombre de Usuario',
		autoOpen: false,
		resizable: false,
		height: 200,
		width: 450,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_usu_use").submit();
			},
			Cancelar: function() {
				$('#for_usu_use').each (function(){this.reset();});
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
<div id="div_usuario_pass_form">
</div>
<div id="div_usuario_user_form">
</div>
<div class="container">
	<header>
    	<?php echo $oContenido->print_header()?>
	</header>
    <article class="content">
    	<div class="contenido">
            <div class="contenido_des">
			<table align="center" class="tabla_cont">
      <tr>
        <td class="caption_cont">MIS DATOS</td>
      </tr>
      <tr>
        <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
      </tr>
      <tr>
        <td>
        <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="middle"><a class="btn_editar_datos" href="#" onClick="editar_usuario('<?php echo $_SESSION['usuario_id']?>')">Modificar Datos</a></td>
          <td><a class="btn_editar_pas" href="#" onClick="editar_usuario_pass('<?php echo $_SESSION['usuario_id']?>')">Cambiar Contraseña</a></td>
          <td><a class="btn_editar_use" href="#" onClick="editar_usuario_user('<?php echo $_SESSION['usuario_id']?>')">Cambiar Nombre de Usuario</a></td>
          <td align="left" valign="middle"><button id="btn_actualizar">Actualizar</button></td>
          <td align="right">&nbsp;</td>
        </tr>
      </table>
      <div id="msj_usuario" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
        </td>
      </tr>
      <tr>
        <td>
        </td>
      </tr>
  </table>
			</div>
            <div id="div_usuario_detalle" style="padding:20px">
            </div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>