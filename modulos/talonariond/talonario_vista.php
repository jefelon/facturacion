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
<title>Talonarios</title>
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

<script src="../../js/jquery-ui/development-bundle/external/jquery.metadata.js"></script>
<script src="../../js/Moneda/autoNumeric.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
function talonario_filtro(){			
	$.ajax({						
		url: "talonario_filtro.php",
		async:true,
		dataType: "html",                      
		data: ({
		}),
		beforeSend: function() {
			$('#div_talonario_filtro').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_talonario_filtro').html(html);
		},
		complete: function(){			
			$('#div_talonario_filtro').removeClass("ui-state-disabled");
			talonario_tabla();
		}
	});        
}
function talonario_tabla()
{	
	$.ajax({
		type: "POST",
		url: "talonario_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			punven_id:	$('#cmb_fil_punven_id').val(),
			doc_id:	$('#cmb_fil_doc_id').val()
		}),
		beforeSend: function() {
			$('#div_talonario_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_talonario_tabla').html(html);
		},
		complete: function(){			
			$('#div_talonario_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function talonario_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "talonario_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			tal_id:	idf
		}),
		beforeSend: function() {
			$('#msj_talonario').hide();
			$('#div_talonario_form').dialog("open");
			$('#div_talonario_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_talonario_form').html(html);				
		}
	});
}

function eliminar_talonario(id)
{   
	$('#msj_talonario').hide();   
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "talonario_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			beforeSend: function() {
				$('#msj_talonario').html("Cargando...");
				$('#msj_talonario').show(100);
			},
			success: function(html){
				$('#msj_talonario').html(html);
			},
			complete: function(){
				talonario_tabla();
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

	talonario_filtro();
	
	$( "#div_talonario_form" ).dialog({
		title:'Información de Talonario',
		autoOpen: false,
		resizable: false,
		height: 250,
		width: 500,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_tal").submit();
			},
			Cancelar: function() {
				$('#for_tal').each (function(){this.reset();});
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
                    <td class="caption_cont">TALONARIOS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="talonario_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right"><div id="msj_talonario" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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
        	<div id="div_talonario_filtro">
			</div>
          <div id="div_talonario_form">
			</div>
        	<div id="div_talonario_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>