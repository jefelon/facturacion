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
<title>Servicios</title>
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

<script src="../../js/jquery-ui/development-bundle/external/jquery.metadata.js"></script>
<script src="../../js/Moneda/autoNumeric.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<script src="../../js/timepicker/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
function servicio_filtro()
{
	$.ajax({
		type: "POST",
		url: "servicio_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//servicio: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_servicio_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_servicio_filtro').html(html);
		},
		complete: function(){
			servicio_tabla();
		}
	});
}

function servicio_tabla()
{
	$.ajax({
		type: "POST",
		url: "servicio_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			ser_nom:	$('#txt_fil_ser_nom').val(),
			ser_cat:	$('#cmb_fil_ser_cat').val(),			
			ser_est:	$('#cmb_fil_ser_est').val(),
			limit: 		$("#cmb_fil_ser_lim").val()	
			
		}),
		beforeSend: function() {
			$('#div_servicio_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_servicio_tabla').html(html);
		},
		complete: function(){			
			$('#div_servicio_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function servicio_form(act,idf){
	$.ajax({
		type: "POST",
		url: "servicio_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ser_id:		idf,
			vista:	'servicio_tabla'
		}),
		beforeSend: function() {
			$('#msj_servicio').hide();
			$('#div_servicio_form').dialog("open");
			$('#div_servicio_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_servicio_form').html(html);				
		}
	});
}
	
function eliminar_servicio(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "servicio_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				ser_id:		id
			}),
			beforeSend: function() {
				$('#msj_servicio').html("Cargando...");
				$('#msj_servicio').show(100);
			},
			success: function(html){
				$('#msj_servicio').html(html);
				$('#msj_servicio').show();
			},
			complete: function(){
				servicio_tabla();
			}
		});
	}
}

function presentacion_vista(serid){
	$.ajax({
		type: "POST",
		url: "presentacion_vista.php",
		async:true,
		dataType: "html",                      
		data: ({
			ser_id:	serid,
			vista:	'Presentacion'
		}),
		beforeSend: function() {
			$('#div_presentacion_vista').dialog("open");
			$('#div_presentacion_vista').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_presentacion_vista').html(html);				
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
		
	servicio_filtro();		
	
	$( "#div_servicio_form" ).dialog({
		title:'Información de Servicio',
		autoOpen: false,
		resizable: false,
		height: 270,
		width: 480,
		modal: true,		
		buttons: {
			Guardar: function() {
				$("#for_ser").submit();
			},
			Cancelar: function() {
				$('#for_ser').each (function(){this.reset();});
				$( this ).dialog("close");
			}
		},
		close: function() 
		{
			$("#div_servicio_form").html('Cargando...');
		}
	});
	$( "#div_presentacion_vista" ).dialog({
		title:'',
		autoOpen: false,
		//resizable: true,
		height: 550,
		width: 680,
		modal: true,
		position: 'top',
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() 
		{
			$("#div_presentacion_vista").html('Cargando...');
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
                    <td class="caption_cont">SERVICIOS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="servicio_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right">
                      <div id="msj_servicio" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_servicio_filtro" class="contenido_tabla">
      		</div>
            <div id="div_servicio_form">
			</div>
            <div id="div_servicio_tabla" class="contenido_tabla">
      		</div>
			<div id="div_presentacion_vista">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer></body>
</html>