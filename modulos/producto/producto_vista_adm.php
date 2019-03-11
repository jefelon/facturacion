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
<title>Productos</title>
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
function producto_filtro()
{
	$.ajax({
		type: "POST",
		url: "producto_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_producto_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_producto_filtro').html(html);
		},
		complete: function(){
			producto_tabla();
		}
	});
}

function producto_tabla()
{
	$.ajax({
		type: "POST",
		url: "producto_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_nom:	$('#txt_fil_pro_nom').val(),
			pro_cat:	$('#cmb_fil_pro_cat').val(),
			pro_mar:	$('#cmb_fil_pro_mar').val(),
			pro_est:	$('#cmb_fil_pro_est').val(),
			limit:		$('#cmb_fil_lim').val(),
			ordby:		$('#cmb_fil_ordby').val()
			
		}),
		beforeSend: function() {
			$('#msj_producto').html("Cargando...");
			$('#msj_producto').show(100);
			$('#div_producto_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_producto_tabla').html(html);
		},
		complete: function(){			
			$('#div_producto_tabla').removeClass("ui-state-disabled");
			$('#msj_producto').hide(100);
		}
	});     
}
function producto_check(){
	$.ajax({
		type: "POST",
		url: "producto_check.php",
		async:true,
		dataType: "json",                      
		data: ({
			action:		$('#action_producto').val(),
			pro_id:		$('#hdd_pro_id').val(),
			pro_nom:	$('#txt_pro_nom').val(),
			cat_id:		$('#cmb_cat_id').val(),
			mar_id:		$('#cmb_mar_id').val(),
            afec_id:	$('#cmb_afec_id').val()
		}),
		beforeSend: function(){
			$('#msj_producto_check').html("Verificando...");
			$('#msj_producto_check').show(100);
        },
		success: function(data){
			if(data.act==0)
			{
				$('#msj_producto_check').dialog("open");
				$('#msj_producto_check').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
				$('#msj_producto_check').html(data.msj);
			}
			
			if(data.act==1)
			{
				$('#msj_producto_check').html(data.msj);
				$('#msj_producto_check').hide(100);
				$("#for_pro").submit();
			}
		},
		complete: function(){
			//$('#msj_producto_check').hide();
		},
      	error: function (xhr, ajaxOptions, thrownError) {
       		//alert(xhr.status);
			//alert(ajaxOptions);
        	alert(thrownError);
      	}
	});
}
function producto_form(act,idf){
	$.ajax({
		type: "POST",
		url: "producto_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			pro_id:		idf,
			vista:	'producto_tabla'
		}),
		beforeSend: function() {
			$('#msj_producto').hide();
			$('#div_producto_form').dialog("open");
			$('#div_producto_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_producto_form').html(html);				
		}
	});
}
	
function eliminar_producto(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "producto_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				pro_id:		id
			}),
			beforeSend: function() {
				$('#msj_producto').html("Cargando...");
				$('#msj_producto').show(100);
			},
			success: function(html){
				$('#msj_producto').html(html);
				$('#msj_producto').show();
			},
			complete: function(){
				producto_tabla();
			}
		});
	}
}

function presentacion_vista(proid){
	$.ajax({
		type: "POST",
		url: "presentacion_vista.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id:	proid,
			vista:	'Presentacion'
		}),
		beforeSend: function() {
			$('#div_presentacion_vista').dialog("open");
			$('#div_presentacion_vista').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_presentacion_vista').html(html);				
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

    $('#btn_reporte').button({
        icons: {primary: "ui-icon-plus"},
        text: true
    });


    producto_filtro();
	
	$( "#div_producto_form" ).dialog({
		title:'Información de Producto',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 990,
		modal: true,
		position: 'top',
		buttons: {
			Guardar: function() {
				producto_check();
				//$("#for_pro").submit();
			},
			Cancelar: function() {
				$('#for_pro').each (function(){this.reset();});
				$( this ).dialog("close");
			}
		},
		close: function() 
		{
			$("#div_producto_form").html('Cargando...');
		}
	});
	$( "#div_presentacion_vista" ).dialog({
		title:'',
		autoOpen: false,
		//resizable: true,
		height: 550,
		width: 680,
		modal: true,
		position: 'top',
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() 
		{
			$("#div_presentacion_vista").html('Cargando...');
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
                    <td class="caption_cont">PRODUCTOS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="producto_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;<a id="btn_reporte" href="#">Reporte Productos</a></td>
                      <td align="right">
                      <div id="msj_producto" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_producto_filtro" class="contenido_tabla">
      		</div>
            <div id="div_producto_form">
			</div>
            <div id="div_producto_tabla" class="contenido_tabla">
      		</div>
			<div id="div_presentacion_vista">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer></body>
</html>