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
<title>Legalización de los Libros Contables</title>
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
    function legalizacionlibros_filtro()
    {
        $.ajax({
            type: "POST",
            url: "../legalizacionlibros/legalizacionlibros_filtro.php",
            async:true,
            dataType: "html",
            //data: ({
            //venta: $('#txt_fil_pro').val()
            //}),
            beforeSend: function() {
                $('#div_legalizacionlibros_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_legalizacionlibros_filtro').html(html);
            },
            complete: function(){
                legalizacionlibros_tabla();
            }
        });
    }
function legalizacionlibros_tabla()
{	
	$.ajax({
		type: "POST",
		url: "legalizacionlibros_tabla.php",
		async:true,
		dataType: "html",
        data: $("#for_fil").serialize(),
		beforeSend: function() {
			$('#div_legalizacionlibros_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_legalizacionlibros_tabla').html(html);
		},
		complete: function(){			
			$('#div_legalizacionlibros_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function legalizacionlibros_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "legalizacionlibros_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
            legalizacionlibros_id:	idf,
			vista:	'legalizacionlibros_tabla'
		}),
		beforeSend: function() {
			$('#msj_legalizacionlibros').hide();
			$('#div_legalizacionlibros_form').dialog("open");
			$('#div_legalizacionlibros_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_legalizacionlibros_form').html(html);				
		}
	});
}

function leglib_reporte_xls(){
    $("#hdd_tabla").val( $("<div>").append( $("#tabla_legalizacionlibros").eq(0).clone()).html());
    $("#for_rep_xls").submit();
}


function eliminar_legalizacionlibros(id)
{   
	$('#msj_legalizacionlibros').hide();   
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "legalizacionlibros_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			beforeSend: function() {
				$('#msj_legalizacionlibros').html("Cargando...");
				$('#msj_legalizacionlibros').show(100);
			},
			success: function(html){
				$('#msj_legalizacionlibros').html(html);
			},
			complete: function(){
				legalizacionlibros_tabla();
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

    $('#btn_imprimir_xls').button({
        icons: {primary: "ui-icon-print"},
        text: true
    });

    legalizacionlibros_filtro();
	
	$( "#div_legalizacionlibros_form" ).dialog({
		title:'Información de legalizacionlibros',
		autoOpen: false,
		resizable: false,
		height: 400,
		width: 500,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_leglib").submit();
			},
			Cancelar: function() {
				$('#for_leglib').each (function(){this.reset();});
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
                    <td class="caption_cont">LEGALIZACIÓN DE LOS LIBROS CONTABLES</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="legalizacionlibros_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                        <td align="left" valign="middle">
                            <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="leglib_reporte_xls()" title="Imprimir en Excel">Excel</a>
                            <form action="leglib_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
                                <input type="hidden" id="hdd_tabla" name="hdd_tabla" />
                            </form></td>
                      <td align="right"><div id="msj_legalizacionlibros" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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
            <div id="div_legalizacionlibros_filtro" class="contenido_tabla">
            </div>
        	<div id="div_legalizacionlibros_form">
			</div>
        	<div id="div_legalizacionlibros_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>