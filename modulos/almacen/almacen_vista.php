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
<title>Almacén</title>
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

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
function almacen_tabla()
{	
	$.ajax({
		type: "POST",
		url: "almacen_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			//pro_est:	$('#cmb_fil_pro_est').val()
		}),
		beforeSend: function() {
			$('#div_almacen_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_almacen_tabla').html(html);
		},
		complete: function(){			
			$('#div_almacen_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function almacen_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "almacen_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			alm_id:	idf,
			vista:	'almacen_tabla'
		}),
		beforeSend: function() {
			$('#msj_almacen').hide();
			$('#div_almacen_form').dialog("open");
			$('#div_almacen_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_almacen_form').html(html);				
		}
	});
}

function eliminar_almacen(id)
{   
	$('#msj_almacen').hide();   
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "almacen_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				alm_id:		id
			}),
			beforeSend: function() {
				$('#msj_almacen').html("Cargando...");
				$('#msj_almacen').show(100);
			},
			success: function(html){
				$('#msj_almacen').html(html);
			},
			complete: function(){
				almacen_tabla();
			}
		});
	}
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

	almacen_tabla();
	
	$( "#div_almacen_form" ).dialog({
		title:'Información de Almacén',
		autoOpen: false,
		resizable: false,
		height: 180,
		width: 500,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_alm").submit();
			},
			Cancelar: function() {
				$('#for_alm').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
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
                    <td class="caption_cont">ALMACENES</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="almacen_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right"><div id="msj_almacen" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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
        	<div id="div_almacen_form">
			</div>
        	<div id="div_almacen_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>