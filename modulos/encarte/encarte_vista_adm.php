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
<title>Encarte</title>
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
function encarte_filtro()
{
	$.ajax({
		type: "POST",
		url: "encarte_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//encarte: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_encarte_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_encarte_filtro').html(html);
		},
		complete: function(){
			encarte_tabla();
		}
	});
}

function encarte_tabla()
{
	$.ajax({
		type: "POST",
		url: $('#hdd_modo').val(),
		async:true,
		dataType: "html",                      
		data: ({
			enc_fec1:	$('#txt_fil_enc_fec1').val(),
			enc_fec2:	$('#txt_fil_enc_fec2').val(),
			enc_mon:	$('#cmb_fil_enc_mon').val(),
			pro_id:		$('#hdd_fil_pro_id').val(),
			enc_est:	$('#cmb_fil_enc_est').val()
			
		}),
		beforeSend: function() {
			$('#div_encarte_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_encarte_tabla').html(html);
		},
		complete: function(){			
			$('#div_encarte_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function encarte_form(act,idf){
	$.ajax({
		type: "POST",
		url: "encarte_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			enc_id:	idf
		}),
		beforeSend: function() {
			$('#msj_encarte').hide();
			$('#div_encarte_form').dialog("open");
			$('#div_encarte_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_encarte_form').html(html);				
		}
	});
}

function encarte_anular(id)
{
	$('#msj_encarte').hide();     
	if(confirm("Realmente desea dejar INACTIVO encarte, se actualizará precio de venta (al precio de venta anterior). Desea continuar?")){
		$.ajax({
			type: "POST",
			url: "encarte_anular.php",
			async:true,
			dataType: "json",
			data: ({
				action: "anular",
				enc_id:		id
			}),
			beforeSend: function() {
				$('#msj_encarte').html("Cargando...");
				$('#msj_encarte').show(100);
			},
			success: function(data){
				$('#msj_encarte').html(data.msj);
			},
			complete: function(){
				encarte_tabla();
			}
		});
	}
}
	
function eliminar_encarte(id)
{    
	$('#msj_encarte').hide();  
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "encarte_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				enc_id:		id
			}),
			beforeSend: function() {
				$('#msj_encarte').html("Cargando...");
				$('#msj_encarte').show(100);
			},
			success: function(html){
				$('#msj_encarte').html(html);
				$('#msj_encarte').show();
			},
			complete: function(){
				encarte_tabla();
			}
		});
	}
}

function encarte_reporte()
{	
	$("#for_fil_enc").submit();
}

function encarte_reporte_xls(){
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_encarte").eq(0).clone()).html()); 
	$("#for_rep_xls").submit();
}

function modo(url){
	$('#hdd_modo').val(url);
	encarte_tabla();
};

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
	
	$('.btn_modo').button({
		icons: {primary: "ui-icon-document"},
		text: true
	});
	
	$('#btn_imprimir_pdf').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
	
	$('#btn_imprimir_xls').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
		
	encarte_filtro();		
	
	$( "#div_encarte_form" ).dialog({
		title:"Información de Encarte | <?php echo $_SESSION['empresa_nombre']?>",
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 980,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_enc").submit();
			},
			Cancelar: function() {
				$('#for_enc').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$('#div_catalogo_encarte').dialog( "close" );
			$('#div_encarte_form').html('encarte_form');
		}
	});
	
	$(document).shortkeys({
	  'a+g':       function () { encarte_form('insertar') }
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
                    <td class="caption_cont">ENCARTE</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="6%" align="left" valign="middle"><a id="btn_agregar" title="Agregar (A+G)" href="#" onClick="encarte_form('insertar')">Agregar</a></td>
                      <td width="6%" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <?php /*?><td width="6%" align="left" valign="middle" nowrap>
                      <a href="#" onClick="modo('encarte_tabla.php')" class="btn_modo" title="Modo Vista Encartes">Encartes</a>
                      </td>
                      <td width="8%" align="left" valign="middle" nowrap>
                      <a href="#" onClick="modo('encarte_tabla_detalle.php')" class="btn_modo" title="Modo Vista Detalle de Encartes">Detalle encartes</a>
                      </td>
                      <td align="left" valign="middle"><a class="btn_imprimir_pdf" id="btn_imprimir_pdf" href="#" onClick="encarte_reporte()" title="Imprimir en Pdf">Pdf</a></td>
                      <td width="6%" align="left" valign="middle">
                      <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="encarte_reporte_xls()" title="Imprimir en Excel">Excel</a>
                      <form action="../encarte - Copia/encarte_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
						<input type="hidden" id="hdd_tabla" name="hdd_tabla" /> 
						</form> 
                      </td><?php */?>
                      <td align="right" width="72%">
                      <div id="msj_encarte" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_encarte_filtro" class="contenido_tabla">
      		</div>
            <div id="div_encarte_form">
			</div>
            <div id="div_encarte_precios">
			</div>
            <div id="div_encarte_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>