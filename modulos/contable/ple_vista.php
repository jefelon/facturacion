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

    function libro_filtro()
    {
        $.ajax({
            type: "POST",
            url: "ple_filtro.php",
            async:true,
            dataType: "html",
            beforeSend: function() {
                $('#div_venta_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_venta_filtro').html(html);
            },
            complete: function(){
                ple_tabla();
            }
        });
    }
    function ple_tabla(){
        $.ajax({
            type: "POST",
            url: "ple_tabla.php",
            async:true,
            dataType: "html",
            data: ({
                anio:   $('#cmb_fil_anio').val(),
                mes:   $('#cmb_fil_mes').val(),
                libro: $("#cmb_fil_librople").val()

                // mes:	$('#cmb_fil_mes').val()
            }),
            beforeSend: function() {
                $('#div_ple_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_ple_tabla').html(html);
            },
            complete: function(){
                $('#div_ple_tabla').removeClass("ui-state-disabled");
            }
        });
}

    function descargar_txt() {
        userDetails = '';
        $('#tabla_ple tbody:first tr').each(function () {
            var detail = '';
            $(this).find('td').each(function () {
                detail += $(this).html() + '|';
            });
            detail = detail.substring(0, detail.length - 1);
            detail += '';
            userDetails += detail + "\r\n";
        });
        var a = document.getElementById("btn_descargar_txt");
        var file = new Blob([userDetails], {type: 'text/plain'});
        a.href = URL.createObjectURL(file);
        a.download = "LE20601411076"+$('#cmb_fil_anio').val()+$('#cmb_fil_mes').val()+"00"+$("#cmb_fil_librople").val()+"00"+"1111.txt"
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
	})

    // $('#cmb_fil_librople').change(function(e) {
    //     ple_tabla();
    // });
    $('#btn_descargar_txt').click(function(e) {
        descargar_txt();
    });
	libro_filtro();
	ple_tabla();

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
                    <td class="caption_cont">INDICA EL PERIODO Y EL LIBRO QUE DESEAS DESCARGAR</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $razon ?></td>
                  </tr>
              </table>
			</div>
        	<div id="div_venta_filtro" class="contenido_tabla">
      		</div>
            <div id="div_ple_tabla" class="div_ple_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php /*echo $oContenido->print_footer()*/?>
</footer>
</body>
</html>