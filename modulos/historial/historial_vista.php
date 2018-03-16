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
<title>Historial de Productos</title>
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
function catalogo_historial(){	
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_historial.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//destino:	'historial'
		}),
		beforeSend: function() {
			//$('#msj_venta').hide();
			$('#div_seleccionar_producto').dialog("open");
			$('#div_seleccionar_producto').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
		},
		success: function(html){
			$('#div_seleccionar_producto').html(html);				
		}
	});
}

function historial_producto(idc){
	$.ajax({
		type: "POST",
		url: "../historial/historial_producto.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			cat_id:	idc
		}),
		beforeSend: function() {
			$('#div_historial_producto').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
		},
		success: function(html){
			$('#div_historial_producto').html(html);				
		},
		complete: function(html){
			$('#div_seleccionar_producto').dialog("close");
			$('#div_historial_producto_tabla').html("");
		}
	});
}
function historial_producto_tabla(){
	$.ajax({
		type: "POST",
		url: "../historial/historial_producto_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id: $('#hdd_cat_sel_id').val(),
			alm_id: $('#cmb_almacen').val()
		}),
		beforeSend: function() {
			$('#div_historial_producto_tabla').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
			//$('#div_catalogo_venta_tabla').addClass("ui-state-disabled");
    },
		success: function(html){			
			$('#div_historial_producto_tabla').html(html);
		},
		complete: function(){			
			//$('#div_catalogo_venta_tabla').removeClass("ui-state-disabled");
		}
	});     
}

$(function() {
	
	catalogo_historial()
	
	$('#btn_actualizar').button({
		icons: {primary: "ui-icon-arrowrefresh-1-e"},
		text: true
		}).click(function() {
		location.reload();
	});
	
	$('#btn_seleccionar').button({
		icons: {primary: "ui-icon-plus"},
		text: true
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
                    <td class="caption_cont">HISTORIAL DE PRODUCTOS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right">
                      <div id="msj_kardex" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
            <div id="div_seleccionar_producto" style="OVERFLOW: auto; WIDTH: 980px; HEIGHT: 188px; text-align:center">
      		</div>             
            <div id="div_historial_producto">
      		</div>            
            <div id="div_historial_producto_tabla">
			</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer></body>
</html>