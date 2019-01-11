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
<title>Proveedores</title>
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

function proveedor_filtro(){			
	$.ajax({						
		url: "../proveedor/proveedor_filtro.php",
		async:true,
		dataType: "html",                      
		data: ({
		}),
		beforeSend: function() {
			$('#div_proveedor_filtro').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_proveedor_filtro').html(html);
		},
		complete: function(){			
			$('#div_proveedor_filtro').removeClass("ui-state-disabled");
			proveedor_tabla();
		}
	});        
}

function proveedor_tabla(){			
	$.ajax({						
		url: "proveedor_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
		}),
		beforeSend: function() {
			$('#div_proveedor_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_proveedor_tabla').html(html);
		},
		complete: function(){			
			$('#div_proveedor_tabla').removeClass("ui-state-disabled");
		}
	});        
}
	
function proveedor_form(act,idf){
	$.ajax({
		type: "POST",
		url: "proveedor_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			pro_id:	idf,
			vista:	'proveedor_tabla'
		}),
		beforeSend: function() {
			$('#msj_proveedor').hide();
			$('#div_proveedor_form').dialog("open");
			$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_proveedor_form').html(html);				
		}
	});
}

function eliminar_proveedor(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "proveedor_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				pro_id:		id
			}),
			beforeSend: function() {
				$('#msj_proveedor').html("Cargando...");
				$('#msj_proveedor').show(100);
			},
			success: function(html){
				$('#msj_proveedor').html(html);
				$('#msj_proveedor').show();
			},
			complete: function(){
				proveedor_tabla();
			}
		});
	}
}

function compras_por_proveedor(pro_id){		
	$.ajax({		
		type: "POST",				
		url: "compra_por_proveedor.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id: pro_id
		}),
		beforeSend: function() {
			$('#div_compra_por_proveedor').dialog("open");
			$('#div_compra_por_proveedor').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');						
        },
		success: function(html){				
			$('#div_compra_por_proveedor').html(html);
		},
		complete: function(){			
			$('#div_compra_por_proveedor').removeClass("ui-state-disabled");
		}
	});        
}

function compra_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../compra/compra_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			com_id:	idf
		}),
		beforeSend: function() {
			$('#msj_compra').hide();
			$('#div_compra_form').dialog("open");
			$('#div_compra_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_compra_form').html(html);				
		}
	});
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
	
	proveedor_tabla();
		
	$( "#div_proveedor_form" ).dialog({
		title:'Información Proveedor',
		autoOpen: false,
		resizable: false,
		height: 320,
		width: 530,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_pro").submit();
			},
			Cancelar: function() {
				$('#for_pro').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_compra_por_proveedor" ).dialog({
		title:'Información de Compras Por Proveedor',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 980,
		modal: true,
		position: 'top',
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_compra_form" ).dialog({
		title:'Información de Compra | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 980,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Cerrar: function() {
				$('#for_com').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$('#div_catalogo_compra').dialog( "close" );
			$('#div_compra_form').html('compra_form');
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
                    <td class="caption_cont">PROVEEDORES</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="proveedor_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right"><div id="msj_proveedor" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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
      <div id="div_proveedor_filtro">
      </div>
      <div id="div_proveedor_form">
			</div>
      <div id="div_compra_por_proveedor">
      </div>
      <div id="div_compra_form">
      </div>
      <div id="div_proveedor_tabla" class="contenido_tabla">
      </div>
      </div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>