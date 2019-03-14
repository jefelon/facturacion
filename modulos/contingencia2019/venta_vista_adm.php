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
<title>Ventas</title>
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

<script src="../../js/ckeditor/ckeditor-standar/jquery.min.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/ckeditor.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/adapters/jquery.js"></script>
<script> var $j = jQuery.noConflict(true); </script>

<script type="text/javascript">
function venta_filtro()
{
	$.ajax({
		type: "POST",
		url: "../venta/venta_filtro_adm.php",
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
		beforeSend: function() {
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
	
function venta_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../venta/venta_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ven_id:	idf,
			vista:	'administrador'
		}),
		beforeSend: function() {
			$('#msj_venta').hide();
			$('#div_venta_form').dialog("open");
			$('#div_venta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_form').html(html);				
		}
	});
}

function venta_check(){	
	$.ajax({
		type: "POST",
		url: "../venta/venta_check.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act
		}),
		beforeSend: function() {
			txt_ven_numdoc();			
			$('#msj_venta_car').hide();
			$('#msj_venta_check').html("Verificando...");
			$('#msj_venta_check').show(100);
        },
		success: function(html){			
			if(html!='correcto')
			{
				$('#div_venta_check').dialog("open");
				$('#div_venta_check').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
				$('#div_venta_check').html(html);
			}
			else
			{
				$("#for_ven").submit();
			}
		},
		complete: function(){
			$('#msj_venta_check').hide();
		}
		
	});
}

function venta_impresion(idf){
    $.ajax({
        type: "POST",
        url: "../venta/venta_preimpresion.php",
        async:true,
        dataType: "html",
        data: ({
            ven_id:	idf
        }),
        beforeSend: function() {
            $('#div_venta_impresion').dialog("open");
            $('#div_venta_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_venta_impresion').html(html);
        }
    });
}

function venta_impresion_pas(idf){
	$.ajax({
		type: "POST",
		url: "../venta/venta_preimpresion_pas.php",
		async:true,
		dataType: "html",                      
		data: ({
			ven_id:	idf
		}),
		beforeSend: function() {
			$('#div_venta_impresion').dialog("open");
			$('#div_venta_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_impresion').html(html);				
		}
	});
}

function venta_impresion_enc(idf){
    $.ajax({
        type: "POST",
        url: "../venta/venta_preimpresion.php",
        async:true,
        dataType: "html",
        data: ({
            ven_id:	idf

        }),
        beforeSend: function() {
            $('#div_venta_impresion').dialog("open");
            $('#div_venta_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_venta_impresion').html(html);
        }
    });
}
	
function eliminar_venta(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../venta/venta_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				ven_id:		id
			}),
			beforeSend: function() {
				$('#msj_venta').html("Cargando...");
				$('#msj_venta').show(100);
			},
			success: function(html){
				$('#msj_venta').html(html);
				$('#msj_venta').show();
			},
			complete: function(){
				venta_tabla();
			}
		});
	}
}

function enviar_sunat(id)
{      
	if(confirm("Realmente desea Enviar a la Sunat?")){
		$.ajax({
			type: "POST",
			url: "../venta/enviar_sunat.php",
			async:true,
			dataType: "json",
			data: ({
				ven_id:		id
			}),
			beforeSend: function() {
				$('#msj_venta').html("Enviando a SUNAT...");
				$('#msj_venta').show(100);
			},
			success: function(data){
				$('#msj_venta').html(data.msj);
				//$('#msj_venta').html(data.msj2);
				$('#msj_venta').show();
			},
			complete: function(){
				venta_tabla();
			}
		});
	}
}

function venta_anular(id,texto)
{      
	if(confirm("Realmente desea anular venta "+texto+", se actualizará el stock. ASEGURESE QUE LAS CANTIDADES DE PRODUCTO SE PUEDAN REPONER CORRECTAMENTE.  Continuar?")){
		$.ajax({
			type: "POST",
			url: "../venta/venta_anular.php",
			async:true,
			dataType: "json",
			data: ({
				action: "anular",
				ven_id:		id
			}),
			beforeSend: function() {
				$('#msj_venta').html("Cargando...");
				$('#msj_venta').show(100);
			},
			success: function(data){
				if(data.act!='correcto')
				{
					venta_anular(id);
				}
				$('#msj_venta').html(data.msj);
			},
			complete: function(){
				$("#chk_ven_anu").removeAttr("checked");
				venta_tabla();
			}
		});
	}
	else
	{
		$("#chk_ven_anu").removeAttr("checked");
		venta_tabla();	
	}
}
function venta_reporte(url)
{	
	$("#for_fil_ven").attr("action", url);
	$("#for_fil_ven").submit();
}

function venta_reporte_xls(){
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_venta").eq(0).clone()).html()); 
	$("#for_rep_xls").submit();
}
function modo(url){
	$('#hdd_modo').val(url);
	venta_tabla();
};

function venta_correo_form(act,venid){
	//if($("#hdd_fil_cli_id").val()>0)
	//{
		$.ajax({
			type: "POST",
			url: "../venta/venta_correo_form.php",
			async:true,
			dataType: "html",
			data: ({
				action: act,
				ven_id: venid
			}),
			beforeSend: function() {
				$('#msj_venta').hide();
				$('#div_venta_correo_form').dialog("open");
				$('#div_venta_correo_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
	        },
			success: function(html){
				$('#div_venta_correo_form').html(html);				
			}
		});
	/*}
	else
	{
		alert('Seleccione un Cliente para poder envíar reporte por correo.');
	}*/
}
function venta_correo_email(ven_id){
	$.ajax({
		type: "POST",
		url: "../venta/venta_correo_email.php",
		async:true,
		dataType: "html",
		data: ({
			ven_id:	ven_id
		}),
		beforeSend: function() {
			$('#msj_venta').hide();
			$('#div_venta_email').dialog("open");
			$('#div_venta_email').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_email').html(html);				
		}
	});
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
	$('.btn_modo').button({
		icons: {primary: "ui-icon-document"},
		text: true
	});
	$('.imprimir_pdf').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
	
	$('#btn_imprimir_xls').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
		
	venta_filtro();		
	
	$( "#div_venta_form" ).dialog({
		title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 550,
		width: 980,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			/*Guardar: function() {
				if($('#hdd_ven_numite').val()>0)
				{
					venta_check();
				}
				else{
				$("#for_ven").submit();
				}
			},
			Cancelar: function() {
				$('#for_ven').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}*/
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_venta_check" ).dialog({
		title:'Verificando Venta...',
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
	
	$( "#div_venta_impresion" ).dialog({
		title:'Desea Imprimir Documento?',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 370,
		modal: true,
		position: 'top'
	});

	$( "#div_venta_correo_form" ).dialog({
		title:'Enviar por Correo',
		autoOpen: false,
		resizable: false,
		//height: 600,
		width: 990,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Enviar: function() {
				//if(confirm("Confirmar envío de correo?"))
				//{
					$("#for_ven_cor").submit();
				//}
			},
			Cancelar: function() {
				$('#for_ven_cor').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});


	$( "#div_venta_email" ).dialog({
		title:'Detalle de Correos',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 990,
		modal: true,
		position: "top",
		closeOnEscape: true,
		buttons: {
			Cerrar: function() {
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
                    <td class="caption_cont">VENTAS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="6%" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td width="6%" align="left" valign="middle" nowrap>
                      <a href="#" onClick="modo('venta_tabla_adm.php')" class="btn_modo" title="Modo Vista Ventas">Ventas</a>
                      </td>
                      <td width="8%" align="left" valign="middle" nowrap>
                      <a href="#" onClick="modo('venta_tabla_detalle_adm.php')" class="btn_modo" title="Modo Vista Detalle de Ventas">Detalle Ventas</a>
                      </td>
                      <td width="8%" align="left" valign="middle" nowrap>
                      <a href="#" onClick="modo('venta_tabla_resumen_adm.php')" class="btn_modo" title="Resumen">Resumen</a>
                      </td>
                      <?php /*?>
                      <td width="8%" align="left" valign="middle" nowrap>
                      <a href="#" onClick="modo('venta_tabla_caja_adm.php')" class="btn_modo" title="Caja">Caja</a>
                      </td><?php */?>
                      <td width="6%" align="left" valign="middle"><a class="imprimir_pdf" id="btn_imprimir_pdf" href="#" onClick="venta_reporte('venta_reporte_adm.php')" title="Imprimir en Pdf">Pdf</a></td>
                      <td width="6%" align="left" valign="middle">
                      <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="venta_reporte_xls()" title="Imprimir en Excel">Excel</a>
                      <form action="venta_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
						<input type="hidden" id="hdd_tabla" name="hdd_tabla" /> 
						</form> 
                      </td>
                      <td width="6%" align="left" valign="middle"><a class="imprimir_pdf" id="btn_imprimir_pdf" href="#" onClick="venta_reporte('venta_reporte_detalle_adm.php')" title="Imprimir en Pdf">Reporte</a></td>
                      <td align="right" width="72%">
                      <div id="msj_venta" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
            <div id="div_venta_form">
			</div>
            <div id="div_venta_check">
			</div>
            <div id="div_venta_impresion"></div>
            <div id="div_venta_correo_form"></div>
			<div id="div_venta_email"></div>
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