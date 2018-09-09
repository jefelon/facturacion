<?php
	/*session_start();
	if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
	require_once ("../../config/Cado.php");
	
	require_once ("../../modulos/contenido/contenido.php");
	$oContenido = new cContenido();*/

	require_once ("../../config/datos.php");
?>

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
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>LIBROS ELECTRÓNICOS - PLE</title>
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

<link rel="stylesheet" href="../../js/cluetip/jquery.cluetip.css" type="text/css" />
<script src="../../js/cluetip/lib/jquery.hoverIntent.js"></script>
<script src="../../js/cluetip/jquery.cluetip.min.js"></script>

<script src="../../js/ckeditor/ckeditor-standar/jquery.min.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/ckeditor.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/adapters/jquery.js"></script>
<script> var $j = jQuery.noConflict(true); </script>

<script type="text/javascript">

    function cmb_ven_doc(ids) {
        $.ajax({
            type: "POST",
            url: "../../modulos/documento/cmb_doc_id.php",
            async: true,
            dataType: "html",
            data: ({
                doc_tip: '2',
                doc_id: ids,
                vista: '<?php echo $_POST['action']?>'
            }),
            beforeSend: function () {
                $('#cmb_fil_ven_doc').html('<option value="">Cargando...</option>');
            },
            success: function (html) {
                $('#cmb_fil_ven_doc').html(html);
            }
        });
    }

    function venta_filtro() {
        $.ajax({
            type: "POST",
            url: "contable_registro_filtro.php",
            async: true,
            dataType: "html",
            beforeSend: function () {
                $('#div_venta_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function (html) {
                $('#div_venta_filtro').html(html);
            },
            complete: function () {
            }
        });
    }

    function venta_form(act, idf) {
        $.ajax({
            type: "POST",
            url: "venta_form.php",
            async: true,
            dataType: "html",
            data: ({
                action: act,
                ven_id: idf
            }),
            beforeSend: function () {
                $('#msj_venta').hide();
                $('#div_venta_form').dialog("open");
                $('#div_venta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function (html) {
                $('#div_venta_form').html(html);
            },
            complete: function () {
                if (act == 'editar') {
                    $("#div_venta_form").dialog({
                        title: 'Información de Venta | <?php echo $razon ?> | Editar',
                        buttons: {
                            Cancelar: function () {
                                $('#for_ven').each(function () {
                                    this.reset();
                                });
                                $(this).dialog("close");
                            }
                        }
                    });
                }
            }
        });
    }

    function registro_filtro()
    {
        var url;
        if (document.getElementById("cmb_fil_tipo_doc").value==='1'){
            url = "contable_registro_compra_tabla.php";
        }else if(document.getElementById("cmb_fil_tipo_doc").value==='3'){
            url = "contable_registro_venta_tabla.php";
        }else {
            url = "contable_registro_venta_tabla.php";
        }

        $.ajax({
            type: "POST",
            url: url,
            async:true,
            dataType: "html",
            data: $("#for_fil_contable").serialize(),
            beforeSend: function() {
                $('#div_registro_venta_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_registro_venta_tabla').html(html);
            },
            complete: function(){
                $('#div_registro_venta_tabla').removeClass("ui-state-disabled");
            }
        });
    }


    function registro_reporte_xls() {
        $("#hdd_tabla").val($("<div>").append($("#tabla_producto").eq(0).clone()).html());
        document.for_fil_contable.action = 'contable_registro_xls.php';
        $("#for_fil_contable").submit();
    }

    function registro_reporte_pdf() {
        console.log(document.getElementById("cmb_fil_tipo_doc").value);
        if (document.getElementById("cmb_fil_tipo_doc").value==='1'){
            document.for_fil_contable.action = "contable_registro_reporte_compra.php";
        }else if(document.getElementById("cmb_fil_tipo_doc").value==='3'){
            document.for_fil_contable.action = "contable_registro_reporte_venta.php";
        }

        $("#for_fil_contable").submit();
    }
    function registro_reporte_txt() {
        $("#hdd_tabla").val($("<div>").append($("#tabla_producto").eq(0).clone()).html());
        document.for_fil_contable.action = 'contable_registro_txt.php';
        $("#for_fil_contable").submit();
    }


function modo(url){
	$('#hdd_modo').val(url);
	venta_tabla();
};

$(function() {
	
	$('#btn_actualizar').button({
		icons: {primary: "ui-icon-arrowrefresh-1-e"},
		text: true
		}).click(function() {
		location.reload();
	});
	
	$('#btn_imprimir_pdf').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
	
	$('.btn_modo').button({
		icons: {primary: "ui-icon-document"},
		text: true
	});
		
	venta_filtro();		
	
	$( "#div_venta_form" ).dialog({
		title:'Información de Venta | <?php echo $razon ?>',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 980,
		zIndex: 1,
		modal: true,
		position: "top",
		closeOnEscape: false,
		close: function(event, ui) {
			$('#div_catalogo_venta').dialog( "close" );
			$('#div_venta_form').html('venta_form');
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
                    <td class="caption_cont">INDICA EL PERIODO Y EL REGISTRO QUE DESEAS DESCARGAR</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $razon ?></td>
                  </tr>
              </table>
			</div>
        	<div id="div_venta_filtro" class="contenido_tabla">
      		</div>
            <div id="div_venta_form">
			</div>
            <div id="div_venta_impresion">
			</div>
            <div id="div_venta_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php /*echo $oContenido->print_footer()*/?>
</footer>
</body>
</html>