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
<title>Notas de Almacén</title>
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
function notalmacen_filtro()
{
	$.ajax({
		type: "POST",
		url: "../notalmacen/notalmacen_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//notalmacen: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_notalmacen_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_notalmacen_filtro').html(html);
		},
		complete: function(){
			notalmacen_tabla();
		}
	});
}

function notalmacen_tabla()
{
	$.ajax({
		type: "POST",
		url: "../notalmacen/notalmacen_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			notalm_fec1:	$('#txt_fil_notalm_fec1').val(),
			notalm_fec2:	$('#txt_fil_notalm_fec2').val(),
			alm_id:			$('#cmb_fil_notalm_alm').val(),
			notalm_tip:		$('#cmb_fil_notalm_tip').val()
			
		}),
		beforeSend: function() {
			$('#div_notalmacen_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_notalmacen_tabla').html(html);
		},
		complete: function(){			
			$('#div_notalmacen_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function notalmacen_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../notalmacen/notalmacen_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			notalm_id:	idf
		}),
		beforeSend: function() {
			$('#msj_notalmacen').hide();
			$('#div_notalmacen_form').dialog("open");
			$('#div_notalmacen_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_notalmacen_form').html(html);				
		}
	});
}

function notalmacen_check(){
	$.ajax({
		type: "POST",
		url: "../notalmacen/notalmacen_check.php",
		async:true,
		dataType: "html",                      
		data: ({
			alm_id: $('#cmb_alm_id').val()
		}),
		beforeSend: function() {
			txt_notalm_cod();
			$('#msj_notalmacen_car').hide();
			$('#msj_notalmacen_check').html("Verificando...");
			$('#msj_notalmacen_check').show(100);
        },
		success: function(html){
			if(html!='correcto')
			{
				$('#div_notalmacen_check').dialog("open");
				$('#div_notalmacen_check').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
				$('#div_notalmacen_check').html(html);
			}
			else
			{
				$("#for_notalm").submit();
			}
		},
		complete: function(){
			$('#msj_notalmacen_check').hide();
		}
		
	});
}

function notalmacen_impresion(idf){
	$.ajax({
		type: "POST",
		url: "../notalmacen/notalmacen_preimpresion.php",
		async:true,
		dataType: "html",                      
		data: ({
			notalm_id:	idf
		}),
		beforeSend: function() {
			$('#div_notalmacen_impresion').dialog("open");
			$('#div_notalmacen_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_notalmacen_impresion').html(html);				
		}
	});
}
	
function eliminar_notalmacen(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../notalmacen/notalmacen_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				notalm_id:		id
			}),
			beforeSend: function() {
				$('#msj_notalmacen').html("Cargando...");
				$('#msj_notalmacen').show(100);
			},
			success: function(html){
				$('#msj_notalmacen').html(html);
				$('#msj_notalmacen').show();
			},
			complete: function(){
				notalmacen_tabla();
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
		
	notalmacen_filtro();		
	
	$( "#div_notalmacen_form" ).dialog({
		title:'Información de Nota de Almacén | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 980,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				if($('#hdd_notalm_numite').val()>0 & $('#cmb_notalm_tip').val()==2)
				{
					notalmacen_check();
				}
				else{
					$("#for_notalm").submit();
				}
			},
			Cancelar: function() {
				$('#for_notalm').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_notalmacen_check" ).dialog({
		title:'Verificando...',
		autoOpen: false,
		resizable: false,
		height: 275,
		width: 500,
		modal: false,
		buttons: {
			OK: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_notalmacen_impresion" ).dialog({
		title:'Desea Imprimir Documento?',
		autoOpen: false,
		resizable: false,
		height: 140,
		width: 370,
		modal: true
	});
	
	$(document).shortkeys({
	  //'a+g':       function () { notalmacen_form('insertar') }
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
                    <td class="caption_cont">NOTAS DE ALMACEN</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" title="Agregar (A+G)" href="#" onClick="notalmacen_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right">
                      <div id="msj_notalmacen" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_notalmacen_filtro" class="contenido_tabla">
      		</div>
            <div id="div_notalmacen_form">
			</div>
            <div id="div_notalmacen_check">
			</div>
            <div id="div_notalmacen_impresion">
			</div>
            <div id="div_notalmacen_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>