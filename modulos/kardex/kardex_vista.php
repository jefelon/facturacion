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
<title>Kardex</title>
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
function catalogo_kardex(){	
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_kardex.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//ven_id:	idf
		}),
		beforeSend: function() {
			//$('#msj_venta').hide();
			$('#div_catalogo_kardex').dialog("open");
			$('#div_catalogo_kardex').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
		},
		success: function(html){
			$('#div_catalogo_kardex').html(html);				
		}
	});
}

function kardex_car(idf){		
	$.ajax({
		type: "POST",
		url: "../kardex/kardex_producto.php",
		async:true,
		dataType: "html",                      
		data: ({			
			cat_id:	 idf
		}),
		beforeSend: function() {
			$('#div_kardex').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_kardex').html(html);
		},
		complete: function(){			
			$('#div_kardex').removeClass("ui-state-disabled");
			$( "#div_catalogo_kardex" ).dialog("close");
		}
	});	
}

function kardex_valorado_car(idf){
    $.ajax({
        type: "POST",
        url: "../kardex/kardex_valorado_producto.php",
        async:true,
        dataType: "html",
        data: ({
            cat_id:	 idf
        }),
        beforeSend: function() {
            $('#div_kardex').addClass("ui-state-disabled");
        },
        success: function(html){
            $('#div_kardex').html(html);
        },
        complete: function(){
            $('#div_kardex').removeClass("ui-state-disabled");
            $( "#div_catalogo_kardex" ).dialog("close");
        }
    });
}

function kardex_tabla(cat_id,alm_id){
	$.ajax({
		type: "POST",
		url: "../kardex/kardex_producto_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id: cat_id,
			alm_id: alm_id
		}),
		beforeSend: function() {
			$('#div_producto_kardex_tabla').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
			//$('#div_catalogo_venta_tabla').addClass("ui-state-disabled");
        },
		success: function(html){			
			$('#div_producto_kardex_tabla').html(html);
		},
		complete: function(){			
			//$('#div_catalogo_venta_tabla').removeClass("ui-state-disabled");
		}
	});     
}


function kardex_valorado_tabla(cat_id,alm_id, fec_ini, fec_fin){
    $.ajax({
        type: "POST",
        url: "../kardex/kardex_valorado_producto_tabla.php",
        async:true,
        dataType: "html",
        data: ({
            cat_id: cat_id,
            alm_id: alm_id,
            fec_ini: fec_ini,
            fec_fin: fec_fin
        }),
        beforeSend: function() {
            $('#div_producto_kardex_tabla').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            //$('#div_catalogo_venta_tabla').addClass("ui-state-disabled");
        },
        success: function(html){
            $('#div_producto_kardex_tabla').html(html);
        },
        complete: function(){
            //$('#div_catalogo_venta_tabla').removeClass("ui-state-disabled");
        }
    });
}



function catalogo_kardex_tabla_total(){
    $.ajax({
        type: "POST",
        url: "../kardex/kardex_producto_tabla_total.php",
        async:true,
        dataType: "html",
        data: ({
            alm_id: $('#cmb_fil_pro_alm').val()
        }),
        beforeSend: function() {
            $('#div_catalogo_kardex_tabla').addClass("ui-state-disabled");
        },
        success: function(html){
            $('#div_catalogo_kardex_tabla').html(html);
        },
        complete: function(){
            $('#div_catalogo_kardex_tabla').removeClass("ui-state-disabled");
        }
    });
}
function karde_total_reporte_xls(){
    $("#hdd_tabla").val( $("<div>").append( $("#tabla_kardex_total").eq(0).clone()).html());
    $("#for_rep_xls").submit();
}



function karde_valorado_reporte_xls(){
    $("#hdd_tabla_valorada").val( $("<div>").append( $("#kardex_producto_datos").eq(0).clone()).append($("#tabla_kardex_valorado").eq(0).clone()).html());
    $("#for_rep_valorado_xls").submit();
}

$(function() {
	catalogo_kardex();
    catalogo_kardex_tabla_total();
	
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

    $('#btn_imprimir_xls' ).button({
        icons: {primary: "ui-icon-print"},
        text: true
    });



	/*$( "#div_catalogo_kardex" ).dialog({
		title:'Lista de Productos',
		autoOpen: false,
		resizable: false,
		height: 400,
		width: 880,
		modal: true,
		position: 'top',
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function(){
			
		}
	});*/
	
	//kardex_car('agregar', 0);
		
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
                    <td class="caption_cont">KARDEX</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_seleccionar" href="#" onClick="catalogo_kardex()">Seleccionar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td width="6%" align="left" valign="middle">
                            <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="karde_total_reporte_xls()" title="Imprimir en Excel">Excel</a>
                            <form action="kardex_reporte_total_xls.php" method="post" target="_blank" id="for_rep_xls">
                                <input type="hidden" id="hdd_tabla" name="hdd_tabla" />
                            </form>
                      </td>
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
            <div id="div_catalogo_kardex" style="OVERFLOW: auto; WIDTH: 980px; text-align:center">
      		</div> 
            
            <div id="div_kardex">
      		</div>        	
            <div id="div_producto_kardex_tabla"></div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer></body>
</html>