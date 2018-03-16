<?php
	session_start();
	if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
	require_once ("../../config/Cado.php");
	
	require_once ("../contenido/contenido.php");
	$oContenido = new cContenido();

	$eje_id=$_GET['eje'];
	$cro_id=$_GET['cro'];
	$per_id=$_GET['per'];
	$dig_id=$_GET['dig'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Control-Guía de Pagos</title>
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

<link rel="stylesheet" href="style_table.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script src="../../js/ckeditor/ckeditor-standar/jquery.min.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/ckeditor.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/adapters/jquery.js"></script>
<script> var $j = jQuery.noConflict(true); </script>

<script type="text/javascript">

function guiapagocontrol_filtro(){			
	$.ajax({
		type: "POST",					
		url: "guiapagocontrol_filtro.php",
		async:true,
		dataType: "html",                      
		data: ({
			eje_id	: '<?php echo $eje_id?>',
			cro_id	: '<?php echo $cro_id?>',
			per_id	: '<?php echo $per_id?>',
			dig_id	: '<?php echo $dig_id?>',
			modo: 'guiapagocontrol_tabla.php'
		}),
		beforeSend: function() {
			$('#div_guiapagocontrol_filtro').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_guiapagocontrol_filtro').html(html);
		},
		complete: function(){			
			$('#div_guiapagocontrol_filtro').removeClass("ui-state-disabled");
			guiapagocontrol_tabla();
		}
	});        
}
function guiapagocontrol_tabla(){			
	$.ajax({	
		type: "POST",					
		url: $('#hdd_modo').val(),
		async:true,
		dataType: "html",                      
		data: $("#for_fil_con").serialize(),
		beforeSend: function() {
			$('#msj_guiapagocontrol_tabla').html("Cargando...");
			$('#msj_guiapagocontrol_tabla').show(100);
			$('#div_guiapagocontrol_tabla').addClass("ui-state-disabled");
    },
		success: function(html){
			$('#div_guiapagocontrol_tabla').html(html);
		},
		complete: function(){			
			$('#div_guiapagocontrol_tabla').removeClass("ui-state-disabled");
			$('#msj_guiapagocontrol_tabla').hide();
		}
	});        
}

function guiapago_form(act,idf,cli,per,eje,tip){
	$.ajax({
		type: "POST",
		url: "guiapago_form.php",
		async:true,
		dataType: "html",
		data: ({
			action: act,
			guipag_id: idf,
			cli_id:	cli,
			per_id: per,
			eje_id: eje,
			tip: tip
		}),
		beforeSend: function() {
			$('#msj_guiapagocontrol').hide();
			$('#div_guiapago_form').dialog("open");
			$('#div_guiapago_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_guiapago_form').html(html);				
		}
	});
}


function correo_form(act,idf,cli,per,eje){
	if($("#hdd_fil_cli_id").val()>0)
	{
		$.ajax({
			type: "POST",
			url: "guiapagocontrol_correo_form.php",
			async:true,
			dataType: "html",
			//data: $("#for_fil_dec").serialize(),                   
			data: ({
				action: act,
				guipagnot_id: idf,
				cli_id:	cli,
				per_id: per,
				eje_id: eje
			}),
			beforeSend: function() {
				$('#msj_guiapagocontrol').hide();
				$('#div_guiapagocontrol_correo_form').dialog("open");
				$('#div_guiapagocontrol_nota').dialog("close");
				$('#div_guiapagocontrol_correo_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
	        },
			success: function(html){
				$('#div_guiapagocontrol_correo_form').html(html);				
			}
		});
	}
	else
	{
		alert('Seleccione un Cliente para poder envíar reporte por correo.');
	}
}
function guiapagonota_form(act,cli,probalite,per,eje){
	if($("#hdd_fil_cli_id").val()>0)
	{
		$.ajax({
			type: "POST",
			url: "../guiapagonota/guiapagonota_form.php",
			async:true,
			dataType: "html",
			//data: $("#for_fil_dec").serialize(),                   
			data: ({
				action: act,
				cli_id:	cli,
				probalite_id: probalite,
				per_id: per,
				eje_id: eje
			}),
			beforeSend: function() {
				$('#msj_guiapagocontrol').hide();
				$('#div_guiapagonota_form').dialog("open");
				$('#div_guiapagonota_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
	        },
			success: function(html){
				$('#div_guiapagonota_form').html(html);				
			}
		});
	}
	else
	{
		alert('Seleccione un Cliente para poder registar nota.');
	}
}
function guiapagocontrol_nota(cli,per,eje,tip){
	$.ajax({
		type: "POST",
		url: "guiapagocontrol_nota.php",
		async:true,
		dataType: "html",
		data: ({
			cli_id:	cli,
			per_id: per,
			eje_id: eje,
			tip: tip
		}),
		beforeSend: function() {
			$('#msj_guiapagocontrol').hide();
			$('#div_guiapagocontrol_nota').dialog("open");
			$('#div_guiapagocontrol_nota').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_guiapagocontrol_nota').html(html);				
		}
	});
}

function guiapago_impresion(idf){
	$.ajax({
		type: "POST",
		url: "../guiapagocontrol/guiapago_impresion.php",
		async:true,
		dataType: "html",                      
		data: ({
			guipag_id:	idf
		}),
		beforeSend: function() {
			$('#div_guiapago_impresion').dialog("open");
			$('#div_guiapago_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_guiapago_impresion').html(html);				
		}
	});
}

function guiapago_eliminar(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../guiapagocontrol/guiapago_reg.php",
			async:true,
			dataType: "json",
			data: ({
				action: "eliminar",
				guipag_id:		id
			}),
			beforeSend: function() {
				$('#msj_guiapagocontrol').html("Cargando...");
				$('#msj_guiapagocontrol').show(100);
			},
			success: function(data){
				$('#msj_guiapagocontrol').html(data.guipag_msj);
				$('#msj_guiapagocontrol').show();
			},
			complete: function(){
				guiapagocontrol_tabla();
			}
		});
	}
}

function guiapago_envcor(dat,id)
{      
	//if(confirm("Realmente desea eliminar?")){
	$.ajax({
		type: "POST",
		url: "../guiapagocontrol/guiapago_reg.php",
		async:true,
		dataType: "json",
		data: ({
			action: "correo",
			guipag_envcor:	dat,
			guipag_id:	id
		}),
		beforeSend: function() {
			$('#msj_guiapagocontrol').html("Cargando...");
			$('#msj_guiapagocontrol').show(100);
		},
		success: function(data){
			$('#msj_guiapagocontrol').html(data.guipag_msj);
			$('#msj_guiapagocontrol').show();
		},
		complete: function(){
			guiapagocontrol_tabla();
		}
	});
	//}
}

function modo(url){
	$('#hdd_modo').val(url);
	guiapagocontrol_tabla();
};

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

	$('.btn_accion').button({
		//icons: {primary: "ui-icon-plus"},
		text: true
	});
	
	guiapagocontrol_filtro();
		
	$( "#div_guiapagocontrol_correo_form" ).dialog({
		title:'Enviar por correo',
		autoOpen: false,
		resizable: false,
		//height: 600,
		width: 990,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Enviar: function() {
				if(confirm("Confirmar envío de correo?")){
					$("#for_procon_cor").submit();
				}
			},
			Cancelar: function() {
				$('#for_procon_cor').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});

	$( "#div_guiapagonota_form" ).dialog({
		title:'Información de Nota',
		autoOpen: false,
		resizable: false,
		//height: 400,
		width: 900,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_guipagnot").submit();
			},
			Cancelar: function() {
				$('#for_guipagnot').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});

	$( "#div_guiapago_form" ).dialog({
		title:'Información de Guía de Pago',
		autoOpen: false,
		resizable: false,
		//height: 400,
		width: 980,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_guipag").submit();
			},
			Cancelar: function() {
				$('#for_guipag').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});

	$( "#div_guiapagocontrol_nota" ).dialog({
		title:'Detalle de Notas',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 990,
		modal: true,
		position: "top",
		closeOnEscape: true,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});

	$( "#div_guiapago_impresion" ).dialog({
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
                    <td class="caption_cont">CONTROL - GUÍAS DE PAGOS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <?php /*?>
                      <td valign="top"><a id="btn_agregar" href="#" onClick="guiapagocontrol_form('insertar')">Agregar</a></td>
                      <td valign="top"><a href="#" onClick="modo('guiapagocontrol_tabla.php')" class="btn_accion" title="Modo Vista Contactos">General</a>
                      </td>
                      <td valign="top"><a href="#" onClick="modo('guiapagocontrol_tabla_ope.php')" class="btn_accion" title="Modo Vista Operaciones en Linea">Operaciones Línea</a>
                      </td>
                      <?php */?>
                      <td valign="top"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="right">
                      <div id="msj_guiapagocontrol" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                      <div id="msj_guiapagocontrol_tabla" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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
      	<div id="div_guiapagocontrol_filtro">
        </div>
        <div id="div_guiapagocontrol_tabla" class="contenido_tabla">
        </div>
		<div id="div_guiapagocontrol_correo_form">
        </div>
        <div id="div_guiapagonota_form">
        </div>
        <div id="div_guiapago_form">
        </div>
        <div id="div_guiapagocontrol_nota">
        </div>
        <div id="div_guiapago_impresion"></div>

      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>