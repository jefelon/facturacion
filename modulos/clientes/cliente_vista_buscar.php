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
<title>Clientes</title>
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

function cliente_filtro(){			
	$.ajax({						
		url: "cliente_filtro.php",
		async:true,
		dataType: "html",                      
		data: ({
		}),
		beforeSend: function() {
			$('#div_cliente_filtro').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_cliente_filtro').html(html);
		},
		complete: function(){			
			$('#div_cliente_filtro').removeClass("ui-state-disabled");
			cliente_tabla();
		}
	});        
}
function cliente_tabla(){			
	$.ajax({	
		type: "POST",					
		url: "../clientes/cliente_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			//cli_id: $("#hdd_fil_cli_id").val()
		}),
		beforeSend: function() {
			$('#div_cliente_tabla').addClass("ui-state-disabled");
    },
		success: function(html){
			$('#div_cliente_tabla').html(html);
		},
		complete: function(){			
			$('#div_cliente_tabla').removeClass("ui-state-disabled");
		}
	});        
}
	
function cliente_form(act,idf){
	$.ajax({
		type: "POST",
		url: "cliente_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			cli_id:	idf,
			vista:	'cliente_tabla'
		}),
		beforeSend: function() {
			$('#msj_cliente').hide();
			$('#div_cliente_form').dialog("open");
			$('#div_cliente_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_cliente_form').html(html);				
		}
	});
}

function eliminar_cliente(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "cliente_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				cli_id:		id
			}),
			beforeSend: function() {
				$('#msj_cliente').html("Cargando...");
				$('#msj_cliente').show(100);
			},
			success: function(html){
				$('#msj_cliente').html(html);
				$('#msj_cliente').show();
			},
			complete: function(){
				cliente_tabla();
			}
		});
	}
}

function venta_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../venta/venta_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ven_id:	idf,
			vista:	'administrador'
		}),
		beforeSend: function() {
			$('#msj_venta').hide();
			$('#div_venta_form').dialog("open");
			$('#div_venta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_form').html(html);				
		}
	});
}

function ventas_por_cliente(cli_id){		
	$.ajax({		
		type: "POST",				
		url: "venta_por_cliente.php",
		async:true,
		dataType: "html",                      
		data: ({
			cli_id: cli_id
		}),
		beforeSend: function() {
			$('#div_venta_por_cliente').dialog("open");
			$('#div_venta_por_cliente').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');						
        },
		success: function(html){			
			$('#div_venta_por_cliente').html(html);
		},
		complete: function(){			
			$('#div_venta_por_cliente').removeClass("ui-state-disabled");
		}
	});        
}

function venta_impresion(idf){
	$.ajax({
		type: "POST",
		url: "../venta/venta_preimpresion.php",
		async:true,
		dataType: "html",                      
		data: ({
			ven_id:	idf
		}),
		beforeSend: function() {
			$('#div_venta_impresion').dialog("open");
			$('#div_venta_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_impresion').html(html);				
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
	
	cliente_filtro();
   	$( "#div_cliente_form" ).dialog({
		title:'Busqueda del cliente',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 530,
		modal: false,
		position: 'center',
		buttons: {
			Guardar: function() {
				$("#for_cli").submit();
			},
			Cancelar: function() {
				$('#for_cli').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
				$( "#div_cliente_form" ).html('cliente');
		}
	});
	
	$( "#div_venta_por_cliente" ).dialog({
		title:'Información de Ventas Por Cliente',
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
		},
		close: function() {
				$( "#div_venta_por_cliente" ).html('venta_cliente');
		}
	});
	
	$( "#div_venta_form" ).dialog({
		title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 550,
		width: 940,
		modal: false,
		position: "top",
		closeOnEscape: false,
		buttons: {
			/*Guardar: function() {
				if($('#hdd_ven_numite').val()>0)
				{
					venta_check();
				}
				else{
				$("#for_ven").submit();
				}
			},
			Cancelar: function() {
				$('#for_ven').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}*/
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
				$( "#div_venta_form" ).html('venta');
		}
	});
	
	$( "#div_venta_impresion" ).dialog({
		title:'Desea Imprimir Documento?',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 370,
		modal: true
	});

    cliente_form('insertar');
	
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
<!--            <table align="center" class="tabla_cont">-->
<!--                  <tr>-->
<!--                    <td class="caption_cont">CLIENTES</td>-->
<!--                  </tr>-->
<!--                  <tr>-->
<!--                    <td align="right" class="cont_emp">--><?php //echo $_SESSION['empresa_nombre']?><!--</td>-->
<!--                  </tr>-->
<!--                  <tr>-->
<!--                    <td>-->
<!--                    <table width="100%" border="0" cellspacing="0" cellpadding="0">-->
<!--                    <tr>-->
<!--                      <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="cliente_form('insertar')">Agregar</a></td>-->
<!--                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>-->
<!--                      <td align="left" valign="middle">&nbsp;</td>-->
<!--                      <td align="right"><div id="msj_cliente" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>-->
<!--                    </tr>-->
<!--                  </table>-->
<!--                    </td>-->
<!--                  </tr>-->
<!--                  <tr>-->
<!--                    <td>-->
<!--                    </td>-->
<!--                  </tr>-->
<!--              </table>-->
			</div>
<!--      	<div id="div_cliente_filtro">-->
<!--        </div>-->
        <div id="div_cliente_form">
        </div>
<!--        <div id="div_venta_por_cliente">-->
<!--        </div> -->
        <div id="div_venta_form">
        </div>
        <div id="div_venta_impresion">
        </div>
<!--        <div id="div_cliente_tabla" class="contenido_tabla">-->
<!--        </div>-->
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>