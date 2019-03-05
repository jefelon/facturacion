<?php
	session_start();
	if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
	require_once ("../../config/Cado.php");
	
	require_once ("../contenido/contenido.php");
	$oContenido = new cContenido();
	
	if($_SESSION['usuariogrupo_id']==2)$titulo='Registrar Ventas - Administrador';
	if($_SESSION['usuariogrupo_id']==3)$titulo='Registrar Ventas - Vendedor';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $titulo?></title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery-ui-1.8.16.custom.js?v=2"></script>
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

<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/i18n/jquery.ui.datepicker-es.js"></script>

<script src="../../js/jquery-ui/development-bundle/external/jquery.metadata.js"></script>
<script src="../../js/Moneda/autoNumeric.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<link rel="stylesheet" href="../../js/cluetip/jquery.cluetip.css" type="text/css" />
<script src="../../js/cluetip/lib/jquery.hoverIntent.js"></script>
<script src="../../js/cluetip/jquery.cluetip.min.js"></script>

<script src="../../js/ckeditor/ckeditor-standar/jquery.min.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/ckeditor.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/adapters/jquery.js"></script>
<script> var $j = jQuery.noConflict(true); </script>

<script type="text/javascript">
function venta_filtro()
{
	$.ajax({
		type: "POST",
		url: "../tributos/venta_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//venta: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_venta_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_filtro').html(html);
		},
		complete: function(){
			venta_tabla();
		}
	});
}

function venta_tabla()
{
	$.ajax({
		type: "POST",
		url: $('#hdd_modo').val(),
		async:true,
		dataType: "html",                      
		data: $("#for_fil_ven").serialize(),                      
		/*data: ({
			ven_fec1:	$('#txt_fil_ven_fec1').val(),
			ven_fec2:	$('#txt_fil_ven_fec2').val(),
			cli_id:		$('#txt_fil_cli_id').val(),
			ven_est:	$('#cmb_fil_ven_est').val(),
			ven_doc:	$('#cmb_fil_ven_doc').val()
		}),*/
		beforeSend: function(){
			$('#div_venta_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_venta_tabla').html(html);
		},
		complete: function(){			
			$('#div_venta_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	


function modo(url){
	$('#hdd_modo').val(url);
	venta_tabla();
};

function venta_reporte(url)
{	
	$("#for_fil_ven").attr("action", url);
	$("#for_fil_ven").submit();
}




$(function() {
	
	$('#btn_actualizar').button({
		icons: {primary: "ui-icon-arrowrefresh-1-e"},
		text: true
		}).click(function() {
		location.reload();
	});
	

	$('.btn_modo').button({
		icons: {primary: "ui-icon-document"},
		text: true
	});
	

	
	venta_filtro();		
	
	$('#chk_ven_anu').change( function(){
		venta_tabla();
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
                    <td class="caption_cont"><?php echo strtoupper($titulo)?></td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>

                      <td align="right">
                      	<div id="msj_venta" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                      	<div id="msj_venta_sunat" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_venta_filtro" class="contenido_tabla">
      		</div>

            <div id="div_venta_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>