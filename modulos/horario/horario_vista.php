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
<title>Horario</title>
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

<script src="../../js/jquery-ui-datepicker-lite/dependancies/jquery.glob.js"></script>
<script src="../../js/jquery-ui-datepicker-lite/date.js"></script>

<script src="../../js/timepicker/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<script src="../../js/jquery-ui/development-bundle/external/jquery.metadata.js"></script>
<script src="../../js/Moneda/autoNumeric.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript" src="../../js/jquery-shortkeys/shortkeys.js"></script>

<script type="text/javascript">
function horario_filtro()
{
	$.ajax({
		type: "POST",
		url: "horario_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//horario: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_horario_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_horario_filtro').html(html);
		},
		complete: function(){
			horario_tabla();
		}
	});
}

function horario_tabla()
{
	$.ajax({
		type: "POST",
		url: "horario_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			hor_fec1:	$('#txt_fil_hor_fec1').val(),
			hor_fec2:	$('#txt_fil_hor_fec2').val(),
			pro_id:		$('#cmb_fil_hor_pro').val()	
		}),
		beforeSend: function() {
			$('#div_horario_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_horario_tabla').html(html);
		},
		complete: function(){			
			$('#div_horario_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function horario_form(act,idf){
	$.ajax({
		type: "POST",
		url: "horario_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			hor_id:	idf
		}),
		beforeSend: function() {
			$('#msj_horario').hide();
			$('#div_horario_form').dialog("open");
			$('#div_horario_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_horario_form').html(html);				
		}
	});
}
	
function eliminar_horario(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "horario_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				hor_id:		id
			}),
			beforeSend: function() {
				$('#msj_horario').html("Cargando...");
				$('#msj_horario').show(100);
			},
			success: function(html){
				$('#msj_horario').html(html);
				$('#msj_horario').show();
			},
			complete: function(){
				horario_tabla();
			}
		});
	}
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
		
	//horario_filtro();	
	horario_tabla();	
	
	$( "#div_horario_form" ).dialog({
		title:'Información de Horario',
		autoOpen: false,
		resizable: false,
		height: 350,
		width: 640,
		modal: true,
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_hor").submit();
			},
			Cancelar: function() {
				$('#for_hor').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$(document).shortkeys({
	  'a+g':       function () { horario_form('insertar') }
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
                    <td class="caption_cont">HORARIOS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" title="Agregar (A+G)" href="#" onClick="horario_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right">
                      <div id="msj_horario" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_horario_filtro" class="contenido_tabla">
      		</div>
            <div id="div_horario_form">
			</div>
            <div id="div_horario_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>