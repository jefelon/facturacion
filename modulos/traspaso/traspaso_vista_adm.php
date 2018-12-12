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
<title>Transferencias</title>
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
function traspaso_filtro()
{
	$.ajax({
		type: "POST",
		url: "traspaso_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//traspaso: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_traspaso_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_traspaso_filtro').html(html);
		},
		complete: function(){
			traspaso_tabla();
		}
	});
}

function traspaso_tabla()
{
	$.ajax({
		type: "POST",
		url: "traspaso_tabla.php",
		async:true,
		dataType: "html",                      
		data: $("#for_fil_tra").serialize(),                    
		/*data: ({
			tra_fec1:	$('#txt_fil_tra_fec1').val(),
			tra_fec2:	$('#txt_fil_tra_fec2').val(),
			alm_ori:	$('#cmb_fil_tra_alm_ori').val(),
			alm_des:	$('#cmb_fil_tra_alm_des').val()
			
		}),*/
		beforeSend: function() {
			$('#div_traspaso_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_traspaso_tabla').html(html);
		},
		complete: function(){			
			$('#div_traspaso_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function traspaso_form(act,idf){
	$.ajax({
		type: "POST",
		url: "traspaso_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			tra_id:	idf
		}),
		beforeSend: function() {
			$('#msj_traspaso').hide();
			$('#div_traspaso_form').dialog("open");
			$('#div_traspaso_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_traspaso_form').html(html);				
		}
	});
}

function traspaso_check(){
	$.ajax({
		type: "POST",
		url: "traspaso_check.php",
		async:true,
		dataType: "html",                      
		data: ({
			alm_ori: $('#cmb_tra_alm_ori').val()
		}),
		beforeSend: function(){
			txt_tra_cod();
			$('#msj_traspaso_car').hide();
			$('#msj_traspaso_check').html("Verificando...");
			$('#msj_traspaso_check').show(100);
        },
		success: function(html){
			if(html!='correcto')
			{
				$('#div_traspaso_check').dialog("open");
				$('#div_traspaso_check').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
				$('#div_traspaso_check').html(html);
			}
			else
			{
				$("#for_tra").submit();
			}
		},
		complete: function(){
			$('#msj_traspaso_check').hide();
		}
		
	});
}

function traspaso_impresion(idf){
	$.ajax({
		type: "POST",
		url: "traspaso_preimpresion.php",
		async:true,
		dataType: "html",                      
		data: ({
			tra_id:	idf
		}),
		beforeSend: function() {
			$('#div_traspaso_impresion').dialog("open");
			$('#div_traspaso_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_traspaso_impresion').html(html);				
		}
	});
}
	
function eliminar_traspaso(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "traspaso_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				tra_id:		id
			}),
			beforeSend: function() {
				$('#msj_traspaso').html("Cargando...");
				$('#msj_traspaso').show(100);
			},
			success: function(html){
				$('#msj_traspaso').html(html);
				$('#msj_traspaso').show();
			},
			complete: function(){
				traspaso_tabla();
			}
		});
	}
}
function traspaso_anular(id,texto)
{      
	if(confirm("Realmente desea anular transferencia de COD: "+texto+", se actualizará el stock. ASEGURESE QUE LAS CANTIDADES DE PRODUCTO DE ALMACÉN DESTINO SE PUEDAN REPONER CORRECTAMENTE EN ALMACÉN DE ORIGNE. Desea continuar?")){
		$.ajax({
			type: "POST",
			url: "../traspaso/traspaso_anular.php",
			async:true,
			dataType: "json",
			data: ({
				action: "anular",
				tra_id:		id
			}),
			beforeSend: function() {
				$('#msj_traspaso').html("Cargando...");
				$('#msj_traspaso').show(100);
			},
			success: function(data){
				if(data.act!='correcto')
				{
					traspaso_anular(id);
				}
				$('#msj_traspaso').html(data.msj);
			},
			complete: function(){
				$("#chk_tra_anu").removeAttr("checked");
				traspaso_tabla();
			}
		});
	}
	else
	{
		$("#chk_tra_anu").removeAttr("checked");
		traspaso_tabla();	
	}
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
		
	traspaso_filtro();		
	
	$( "#div_traspaso_form" ).dialog({
		title:'Información de Transferencia | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 980,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				if($('#hdd_tra_numite').val()>0)
				{
					traspaso_check();
				}
				else{
					$("#for_tra").submit();
				}
			},
			Cancelar: function() {
				$('#for_tra').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$('#div_catalogo_traspaso').dialog( "close" );
			$('#div_traspaso_form').html('traspaso_form');
		}
	});
	
	$( "#div_traspaso_check" ).dialog({
		title:'Verificando Transferencia...',
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
	
	$( "#div_traspaso_impresion" ).dialog({
		title:'Desea Imprimir Documento?',
		autoOpen: false,
		resizable: false,
		height: 140,
		width: 370,
		modal: true
	});
	
	//$(document).shortkeys({
	  //'a+g':       function () { traspaso_form('insertar') }
	//});
		
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
                    <td class="caption_cont">TRANSFERENCIAS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle">
                      <div id="div_btn_agregar">
                      <a id="btn_agregar" title="Agregar (A+G)" href="#" onClick="traspaso_form('insertar')">Agregar</a>
                      </div>
                      </td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right">
                      <div id="msj_traspaso" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_traspaso_filtro" class="contenido_tabla">
      		</div>
            <div id="div_traspaso_form">
			</div>
            <div id="div_traspaso_check">
			</div>
            <div id="div_traspaso_impresion">
			</div>
            <div id="div_traspaso_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>