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
		url: "usuario_tabla_adm.php",
		async:true,
		dataType: "html",                      
		data: ({
			//fun: "<?php //echo $fun?>"
		}),
		beforeSend: function() {
			$('#div_usuario_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_usuario_tabla').html(html);
		},
		complete: function(){			
			$('#div_usuario_tabla').removeClass("ui-state-disabled");
		}
	});       
}

function insertar_usuario()
{
	$.ajax({
		type: "POST",
		url: "usuario_form_adm.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "insertar"
		}),
		beforeSend: function() {
			$('#msj_usuario').hide();
			$('#div_usuario_form').dialog( "open" );
			$('#div_usuario_form').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_usuario_form').html(html);
		},
		complete: function(){			
			btn_usuario_form('Guardar y Continuar');
		}
	});
}

function editar_usuario(id,nt)
{
	$.ajax({
		type: "POST",
		url: "usuario_form_adm.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "editar",
			id: id,
			ntab:nt
		}),
		beforeSend: function() {
			$('#msj_usuario').hide();
			$('#div_usuario_form').dialog( "open" );
			$('#div_usuario_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_usuario_form').html(html);
		},
		complete: function(){			
			btn_usuario_form('Guardar');
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
			beforeSend: function() {
				$('#msj_usuario').html("Cargando...");
				$('#msj_usuario').show(100);
			},
			success: function(html){
				$('#msj_usuario').html(html);
			},
			complete: function(){			
				cargar_tabla_usuario();
			}
		});
	}
}

function btn_usuario_form(btn1)
{     
	$( "#div_usuario_form" ).dialog({
		buttons: [
			{
				text: btn1,
				click: function() { $("#for_usu").submit(); }
			},
			{
				text: "Cancelar",
				click: function() { 
					$('#for_usu').each (function(){this.reset();});
					$(this).dialog("close"); 
				}
			}
		]
	});
}
function blok_usuario_form()
{     
	$( "#div_usuario_form" ).dialog({
		buttons: []
	});
}

//
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

	cargar_tabla_usuario();
	
	
	//dialogo
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	$( "#div_usuario_form" ).dialog({
		title:'Información de Usuario',
		autoOpen: false,
		resizable: false,
		height: 450,
		width: 750,
		modal: true,
		close: function() {
			blok_usuario_form();
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
        <td class="caption_cont">LISTA DE USUARIOS - ADMINISTRADOR</td>
      </tr>
      <tr>
        <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="insertar_usuario()">Agregar</a></td>
          <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
          <td align="left" valign="middle">&nbsp;</td>
          <td align="right"><div id="msj_usuario" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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