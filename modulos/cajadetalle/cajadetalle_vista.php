<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../gasto/cGasto.php");
$oGasto = new cGasto();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

require_once ("../caja/cCaja.php");
$oCaja = new cCaja();


$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);

$cjs = $oCaja->mostrarUno($pv['tb_caja_id']);
$cj = mysql_fetch_array($cjs);
$est_caja = $cj['tb_caja_estado'];

//empresa 
//$emp_id=$_SESSION['empresa_id'];
$emp_id='1';

//año
$anio=date('Y');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Lista de Cajas</title>
    <link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../js/cluetip/jquery.cluetip.css" type="text/css" />

<link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.position.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.dialog.js"></script>
    <script src="../../js/Moneda/autoNumeric.js"></script>
    <link rel="stylesheet" href="../../js/flatpickr/flatpickr.min.css">
    <script src="../../js/flatpickr/flatpickr.js"></script>
    <script src="../../js/flatpickr/es.js"></script>

    <script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
    <script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
    <script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>


<script src="../../js/cluetip/lib/jquery.hoverIntent.js"></script>
<script src="../../js/cluetip/jquery.cluetip.min.js"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>


<script type="text/javascript">



    function caja_detalle_consulta(act,fec_apertura, fec_cierre, caja_id, mon_inicial){
        $.ajax({
            type: "POST",
            url: "../cajadetalle/cajadetalle_consulta.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                txt_fil_caj_fec1:	fec_apertura,
                txt_fil_caj_fec2:   fec_cierre,
                cmb_fil_caj_id: caja_id,
                txt_mon_inicial: mon_inicial
            }),
            beforeSend: function() {
                $('#msj_cajadetalle').hide();
                $('#div_cajadetalle_consulta').dialog("open");
                $('#div_cajadetalle_consulta').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_cajadetalle_consulta').html(html);
            },
            complete: function(){

            }
        });
    }

    function caja_abrir_form(act,idf){
        $.ajax({
            type: "POST",
            url: "../cajadetalle/caja_abrir_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                ven_id:	idf
            }),
            beforeSend: function() {
                $('#msj_cajadetalle').hide();
                $('#div_cajadetalle_form').dialog("open");
                $('#div_cajadetalle_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_cajadetalle_form').html(html);
            },
            complete: function(){

            }
        });
    }

    function caja_cerrar_form(act,idf){
        $.ajax({
            type: "POST",
            url: "../cajadetalle/caja_cerrar_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                ven_id:	idf
            }),
            beforeSend: function() {
                $('#msj_cajadetalle').hide();
                $('#div_cajadetalle_form').dialog("open");
                $('#div_cajadetalle_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_cajadetalle_form').html(html);
            },
            complete: function(){
            }
        });
    }

function cajadetalle_filtro()
{
    $.ajax({
        type: "POST",
        url: "../cajadetalle/cajadetalle_filtro.php",
        async:true,
        dataType: "html",
        //data: ({
        //venta: $('#txt_fil_pro').val()
        //}),
        beforeSend: function() {
            $('#div_cajadetalle_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_cajadetalle_filtro').html(html);
        },
        complete: function(){
            cajadetalle_tabla();
        }
    });
}

function cajadetalle_tabla()
{
    $.ajax({
        type: "POST",
        url: "../cajadetalle/cajadetalle_tabla.php",
        async:true,
        dataType: "html",
        /*data: ({
            ven_fec1:	$('#txt_fil_ven_fec1').val(),
            ven_fec2:	$('#txt_fil_ven_fec2').val(),
            cli_id:		$('#txt_fil_cli_id').val(),
            ven_est:	$('#cmb_fil_ven_est').val(),
            ven_doc:	$('#cmb_fil_ven_doc').val()
        }),*/
        beforeSend: function(){
            $('#div_cajadetalle_tabla').addClass("ui-state-disabled");
        },
        success: function(html){
            $('#div_cajadetalle_tabla').html(html);
        },
        complete: function(){
            $('#div_cajadetalle_tabla').removeClass("ui-state-disabled");
        }
    });
}

//
$(function() {
    $( "#div_cajadetalle_form" ).dialog({
        title:'Información de Caja Detalle | <?php echo $_SESSION['empresa_nombre']?>',
        autoOpen: false,
        resizable: false,
        height: 600,
        width: 980,
        zIndex: 1,
        modal: true,
        position: "top",
        closeOnEscape: false,
        buttons: {
            Guardar: function(){
                $("#for_cdet").submit();
            },
            Cancelar: function() {
                $('#for_cdet').each (function(){this.reset();});
                $( this ).dialog( "close" );
            }
        },
        close: function(event, ui) {
            $('#div_catalogo_venta').dialog( "close" );
            $('#div_cajadetalle_form').html('cajadetalle_form');
        }
    });

    $( "#div_cajadetalle_consulta" ).dialog({
        title:'Información de Caja Detalle | <?php echo $_SESSION['empresa_nombre']?>',
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
            $('#div_cajadetalle_consulta').html('cajadetalle_consulta');
        }
    });




    $('#btn_abrir').button({
        icons: {primary: "ui-icon-plus"},
        text: true

    });
    $('#btn_cerrar').button({
        icons: {primary: "ui-icon-close"},
        text: true
    });

    <?php
    if ($est_caja == 1) {
    ?>
        $("#btn_abrir").button("option", "disabled", true);
        $("#btn_cerrar").button("option", "disabled", false);
    <?php
    } elseif($est_caja == 0) {
    ?>
        $("#btn_cerrar").button("option", "disabled", true);
        $("#btn_abrir").button("option", "disabled", false);
    <?php }?>


    cajadetalle_tabla();


 });

 </script>
 </head>

 <body>
 <div class="container">
    <header>
        <?php echo $oContenido->print_header()?>
	</header>
    <div class="content">
    	<div class="contenido">
            <div>
                <div class="contenido_des">
                    <table align="center" class="tabla_cont">
                        <tr>
                            <td class="caption_cont">Apertura y Cierre de Caja</td>
                        </tr>
                        <tr>
                            <td align="right" class="cont_emp"><span
                                        title="Está Visualizando la Información de:"><?php echo $_SESSION['empresa_nombre'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td width="8%"><button id="btn_abrir" title="Abrir" onClick="caja_abrir_form('insertar')">Abrir Caja</button></td>
                                        <td width="8%"><button id="btn_cerrar" title="Cerrar" onClick="caja_cerrar_form('actualizar')">Cerrar Caja</button></td>
                                        <td width="84%" align="right"><div id="msj_cajadetalle" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="div_cajadetalle_filtro" class="contenido_tabla">
            <div id="div_cajadetalle_filtro" class="contenido_tabla">
            </div>
            <div id="div_cajadetalle_form">
            </div>
            <div id="div_cajadetalle_tabla" class="contenido_tabla">
            </div>
                <div id="div_cajadetalle_consulta" class="contenido_tabla">

                </div>
        </div>
  	</div>
	<footer>
    	<?php echo $oContenido->print_footer()?>
  	</footer>
</div>

</body>
</html>