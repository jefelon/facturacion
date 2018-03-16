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
<title>Notas de Venta</title>
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
function ventanota_filtro()
{
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_filtro_adm.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//venta: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_ventanota_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_ventanota_filtro').html(html);
		},
		complete: function(){
			ventanota_tabla();
		}
	});
}

function ventanota_tabla()
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
			ven_doc:	$('#cmb_fil_ven_doc').val(),
			cli_id:		$('#txt_fil_cli_id').val(),
			usu_id:		$('#cmb_fil_ven_ven').val(),
			punven_id:	$('#cmb_fil_ven_punven').val(),
			ven_est:	$('#cmb_fil_ven_est').val()
			
		}),*/
		beforeSend: function() {
			$('#div_ventanota_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_ventanota_tabla').html(html);
		},
		complete: function(){			
			$('#div_ventanota_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function ventanota_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ven_id:	idf,
			vista:	'administrador'
		}),
		beforeSend: function() {
			$('#msj_ventanota').hide();
			$('#div_ventanota_form').dialog("open");
			$('#div_ventanota_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_ventanota_form').html(html);				
		}
	});
}

function ventanota_check(){	
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_check.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act
		}),
		beforeSend: function() {
			txt_ven_numdoc();			
			$('#msj_ventanota_car').hide();
			$('#msj_ventanota_check').html("Verificando...");
			$('#msj_ventanota_check').show(100);
        },
		success: function(html){			
			if(html!='correcto')
			{
				$('#div_ventanota_check').dialog("open");
				$('#div_ventanota_check').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
				$('#div_ventanota_check').html(html);
			}
			else
			{
				$("#for_ven").submit();
			}
		},
		complete: function(){
			$('#msj_ventanota_check').hide();
		}
		
	});
}

function ventanota_impresion(idf){
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_preimpresion.php",
		async:true,
		dataType: "html",                      
		data: ({
			ven_id:	idf
		}),
		beforeSend: function() {
			$('#div_ventanota_impresion').dialog("open");
			$('#div_ventanota_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_ventanota_impresion').html(html);				
		}
	});
}
	
function eliminar_ventanota(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../ventanota/venta_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				ven_id:		id
			}),
			beforeSend: function() {
				$('#msj_ventanota').html("Cargando...");
				$('#msj_ventanota').show(100);
			},
			success: function(html){
				$('#msj_ventanota').html(html);
				$('#msj_ventanota').show();
			},
			complete: function(){
				ventanota_tabla();
			}
		});
	}
}
function ventanota_anular(id,texto)
{      
	if(confirm("Realmente desea anular venta "+texto+", se actualizará el stock. ASEGURESE QUE LAS CANTIDADES DE PRODUCTO SE PUEDAN REPONER CORRECTAMENTE.  Continuar?")){
		$.ajax({
			type: "POST",
			url: "../ventanota/venta_anular.php",
			async:true,
			dataType: "json",
			data: ({
				action: "anular",
				ven_id:		id
			}),
			beforeSend: function() {
				$('#msj_ventanota').html("Cargando...");
				$('#msj_ventanota').show(100);
			},
			success: function(data){
				if(data.act!='correcto')
				{
					ventanota_anular(id);
				}
				$('#msj_ventanota').html(data.msj);
			},
			complete: function(){
				$("#chk_ven_anu").removeAttr("checked");
				ventanota_tabla();
			}
		});
	}
	else
	{
		$("#chk_ven_anu").removeAttr("checked");
		ventanota_tabla();	
	}
}
function ventanota_reporte(url)
{	
	$("#for_fil_ven").attr("action", url);
	$("#for_fil_ven").submit();
}

function ventanota_reporte_xls(){
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_venta").eq(0).clone()).html()); 
	$("#for_rep_xls").submit();
}

function modo(url){
	$('#hdd_modo').val(url);
	ventanota_tabla();
};

function ventanota_cange(id,texto)
{      
	if(confirm("Realmente desea cangear Nota de Venta "+texto+".  Continuar?")){
		$.ajax({
			type: "POST",
			url: "../ventanota/venta_cangear.php",
			async:true,
			dataType: "json",
			data: ({
				action: 'cangear',
				ven_id:	id
			}),
			beforeSend: function() {
				//$('#msj_ventanota').html("Cargando...");
				//$('#msj_ventanota').show(100);
			},
			success: function(data){
				//alert(data.act);
				if(data.act2!='0')
				{
					if(data.act=='correcto')
					{
						//alert('ok');
						$('#div_ventanota_form').dialog("close");
						venta_form('insertar','');
					}
				}
				else
				{
					alert(data.msj);	
				}
				$('#msj_ventanota').html(data.msj);
			},
			complete: function(){
				//$("#chk_ven_anu").removeAttr("checked");
				//ventanota_tabla();
			}
		});
	}
}
function ventanota_cange_rest()
{      
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_cangear.php",
		async:true,
		dataType: "json",
		data: ({
			action: 'restablecer'
		}),
		beforeSend: function() {
			//alert('rest');
		},
		success: function(data){
			//alert(data.msj);
		},
		complete: function(){

		}
	});
}

//para cange de nota de venta
function venta_check(){
	$.ajax({
		type: "POST",
		url: "../venta/venta_check.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act
		}),
		beforeSend: function(){
			//txt_ven_numdoc();
			$('#msj_venta_car').hide();
			$('#msj_venta_check').html("Verificando...");
			$('#msj_venta_check').show(100);
        },
		success: function(html){
			$("#for_ven").submit();
			/*if(html!='correcto')
			{
				$('#div_venta_check').dialog("open");
				$('#div_venta_check').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
				$('#div_venta_check').html(html);
			}
			else
			{
				$("#for_ven").submit();
			}*/
		},
		complete: function(){
			$('#msj_venta_check').hide();
		}
	});
}
function venta_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../venta/venta_form_cange.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ven_id:	idf
		}),
		beforeSend: function() {
			//alert('venta');
			$('#msj_venta').hide();
			$('#div_venta_form').dialog("open");
			$('#div_venta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_form').html(html);				
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
	$('#btn_imprimir_pdf').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
	
	$('#btn_imprimir_xls').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
		
	ventanota_filtro();		
	
	$( "#div_ventanota_form" ).dialog({
		title:'Información de Nota de Venta | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 550,
		width: 940,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			/*Guardar: function() {
				if($('#hdd_ven_numite').val()>0)
				{
					ventanota_check();
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
		},
		close: function() {
			$('#div_catalogo_venta').dialog( "close" );
			$('#div_ventanota_form').html('ventanota_form');
		}
	});
	
	$( "#div_ventanota_check" ).dialog({
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
	
	$( "#div_ventanota_impresion" ).dialog({
		title:'Desea Imprimir Documento?',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 370,
		modal: true,
		close: function() {
			$('#div_ventanota_impresion').html('venta_imp');
		}
	});
	
	
	//para cange
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
	$( "#div_venta_form" ).dialog({
		title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?>',
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
				txt_ven_numdoc();
				if($('#hdd_ven_doc').val()==1){
					if($('#hdd_ven_numite').val()>0)
					{
						venta_check();
					}
					else{
						$("#for_ven").submit();
					}
				}
				else
				{
					$("#for_ven").submit();
				}
			},
			Cancelar: function() {
				ventanota_cange_rest();
				$('#for_ven').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
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
		modal: true,
		close: function() {
			$('#div_venta_impresion').html('venta_imp');
		}
	});
	
	
	
	$(document).shortkeys({
	  //'a+g':       function () { ventanota_form('insertar') }
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
                    <td class="caption_cont">NOTAS DE VENTA</td>
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
                      <a href="#" onClick="modo('venta_tabla_adm.php')" class="btn_modo" title="Modo Vista Ventas">Nota Venta</a>
                      </td>
                      <td width="8%" align="left" valign="middle" nowrap>
                      <a href="#" onClick="modo('venta_tabla_detalle_adm.php')" class="btn_modo" title="Modo Vista Detalle de Ventas">Detalle Nota Venta</a>
                      </td>
                      <td width="8%" align="left" valign="middle" nowrap>
                      <a href="#" onClick="modo('venta_tabla_resumen_adm.php')" class="btn_modo" title="Resumen">Resumen</a>
                      </td>
                      <?php /*?>
                      <td width="8%" align="left" valign="middle" nowrap>
                      <a href="#" onClick="modo('venta_tabla_caja_adm.php')" class="btn_modo" title="Caja">Caja</a>
                      </td><?php */?>
                      <td width="6%" align="left" valign="middle"><a class="btn_imprimir_pdf" id="btn_imprimir_pdf" href="#" onClick="ventanota_reporte('venta_reporte_adm.php')" title="Imprimir en Pdf">Pdf</a></td>
                      <td width="6%" align="left" valign="middle">
                      <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="ventanota_reporte_xls()" title="Imprimir en Excel">Excel</a>
                      <form action="../ventanota/venta_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
						<input type="hidden" id="hdd_tabla" name="hdd_tabla" /> 
						</form> 
                      </td>
                      <td width="6%" align="left" valign="middle"><a class="imprimir_pdf" id="btn_imprimir_pdf" href="#" onClick="ventanota_reporte('venta_reporte_detalle_adm.php')" title="Imprimir en Pdf">Reporte</a></td>
                      <td align="right" width="72%">
                      <div id="msj_ventanota" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_ventanota_filtro" class="contenido_tabla">
      		</div>
            <div id="div_ventanota_form">
			</div>
            <div id="div_ventanota_check">
			</div>
            <div id="div_ventanota_impresion">
			</div>
            <div id="div_venta_form">
			</div>
            <div id="div_venta_check">
			</div>
            <div id="div_venta_impresion">
			</div>
            <div id="div_ventanota_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>