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
<title>Libros Electrónicos</title>
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

    function libroelectronico_filtro()
    {
        $.ajax({
            type: "POST",
            url: "../libroselectronicos/libroelectronico_filtro.php",
            async:true,
            dataType: "html",
            //data: ({
            //venta: $('#txt_fil_pro').val()
            //}),
            beforeSend: function() {
                $('#div_libroelectronico_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_libroelectronico_filtro').html(html);
            },
            complete: function(){
                libroelectronico_tabla();
            }
        });
    }
function libroelectronico_tabla()
{	
	$.ajax({
		type: "POST",
		url: "libroelectronico_tabla.php",
		async:true,
		dataType: "html",
        data: $("#for_fil").serialize(),
		beforeSend: function() {
			$('#div_libroelectronico_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_libroelectronico_tabla').html(html);
		},
		complete: function(){			
			$('#div_libroelectronico_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function libroelectronico_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "libroelectronico_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
            libroelectronico_id:	idf,
			vista:	'libroelectronico_tabla'
		}),
		beforeSend: function() {
			$('#msj_libroelectronico').hide();
			$('#div_libroelectronico_form').dialog("open");
			$('#div_libroelectronico_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_libroelectronico_form').html(html);
		}
	});
}

function eliminar_libroelectronico(id)
{   
	$('#msj_libroelectronico').hide();
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "libroelectronico_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			beforeSend: function() {
				$('#msj_libroelectronico').html("Cargando...");
				$('#msj_libroelectronico').show(100);
			},
			success: function(html){
				$('#msj_libroelectronico').html(html);
			},
			complete: function(){
                libroelectronico_tabla();
			}
		});
	}
}

function libele_reporte_xls(){
    $("#hdd_tabla").val( $("<div>").append( $("#tabla_libroelectronico").eq(0).clone()).html());
    $("#for_rep_xls").submit();
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

    $('#btn_imprimir_xls').button({
        icons: {primary: "ui-icon-print"},
        text: true
    });

    libroelectronico_filtro();
	
	$( "#div_libroelectronico_form" ).dialog({
		title:'Información de libros electronicos',
		autoOpen: false,
		resizable: false,
		height: 400,
		width: 450,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_recdoc").submit();
			},
			Cancelar: function() {
				$('#for_recdoc').each (function(){this.reset();});
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
                    <td class="caption_cont">L</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="libroelectronico_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                        <td align="left" valign="middle">
                            <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="libele_reporte_xls()" title="Imprimir en Excel">Excel</a>
                            <form action="libele_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
                                <input type="hidden" id="hdd_tabla" name="hdd_tabla" />
                            </form></td>
                      <td align="right"><div id="msj_libroelectronico" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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
            <div id="div_libroelectronico_filtro" class="contenido_tabla">
            </div>
        	<div id="div_libroelectronico_form">
			</div>
        	<div id="div_libroelectronico_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>