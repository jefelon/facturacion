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
<title>Catálogo de Productos</title>
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

<script type="text/javascript">
function catalogo_filtro()
{
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_filtro.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//catalogo: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_catalogo_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_filtro').html(html);
		},
		complete: function(){
			catalogo_tabla();
		}
	});
}

function catalogo_tabla(){
	/*var c = 1;	
	var atributos = "-1";	
    $('.casilla_verificacion').each( function(){		
		if($(this).is(':checked')){
			atributos += ", "+$(this).val();		
		}		
	});*/

	if($('#chk_fil_catven').is(':checked')) {  
		datven=1;
	} else {  
		datven=0;
	}
	if($('#chk_fil_catcom').is(':checked')) {  
		datcom=1;
	} else {  
		datcom=0;
	}
	if($('#chk_fil_unibas').is(':checked')) {  
		dunibas=1;
	} else {  
		dunibas=0;
	}	
	$.ajax({
		type: "POST",
		url: $('#hdd_modo').val(),
		async:true,
		dataType: "html",                      
		data: ({
			pro_nom:	$('#txt_fil_pro_nom').val(),
			pro_cod:	$('#txt_fil_pro_cod').val(),
			pro_cat:	$('#cmb_fil_pro_cat').val(),
			pro_mar:	$('#cmb_fil_pro_mar').val(),
			pro_est:	$('#cmb_fil_pro_est').val(),
			alm_id:		$('#cmb_fil_pro_alm').val(),
			atr_ids:	$('#cmb_fil_pro_atr').val(),
			verven:		datven,
			vercom:		datcom,
			unibas:		dunibas,
			inv_fec:	$('#txt_fil_inv_fec').val()
		}),
		beforeSend: function() {
			$('#msj_catalogo').html("Cargando...");
			$('#msj_catalogo').show(100);
			$('#div_catalogo_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_catalogo_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogo_tabla').removeClass("ui-state-disabled");
			$('#msj_catalogo').hide();
		}
	});     
}

function producto_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../producto/producto_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			pro_id:		idf,
			vista:	'catalogo_tabla'
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

function producto_info(idf){
	$.ajax({
		type: "POST",
		url: "../producto/producto_info.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id:		idf
		}),
		beforeSend: function() {
			$('#msj_producto').hide();
			$('#div_producto_info').dialog("open");
			$('#div_producto_info').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_producto_info').html(html);				
		}
	});
}

function modo(url){
	$('#hdd_modo').val(url);
	if(url=='catalogo_stock.php')
	{
		$('#chk_fil_unibas').attr("checked",true);
		$("#div_modo").html("Modo: Editar Stock");
		$("#div_fecha").hide(100);
	}
	
	if(url=='catalogo_stock_rep.php')
	{
		$('#chk_fil_unibas').attr("checked",true);
		$("#div_modo").html("Modo: Stock por Empresa");
		$("#div_fecha").hide(100);
	}
	
	if(url=='catalogo_tabla.php')
	{
		$('#chk_fil_unibas').attr("checked",false);
		$("#div_modo").html("Modo: Catálogo - Stock Valorizado");
		$("#div_fecha").hide(100);
	}
	
	if(url=='catalogo_tabla_si.php')
	{
		$('#chk_fil_unibas').attr("checked",false);
		$("#div_modo").html("Modo: Stock Valorizado Inicial");
		$("#div_fecha").hide(100);
	}
	
	if(url=='inventario_tabla.php')
	{
		$('#chk_fil_unibas').attr("checked",false);
		$("#div_modo").html("Modo: Inventario Valorizado");
		$("#div_fecha").show(100);
	}
	if(url=='inventario_valor_general.php')
	{
		$('#chk_fil_unibas').attr("checked",false);
		$("#div_modo").html("Modo: Inventario Valorizado Costo Prom Gen");
		$("#div_fecha").show(100);
	}
	catalogo_tabla();
};

function catalogo_reporte(url)
{	
	$("#for_fil_cat").attr("action", url);
	$("#for_fil_cat").submit();
}

function catalogo_reporte_xls(){
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_producto").eq(0).clone()).html()); 
	$("#for_rep_xls").submit();
}

$(function() {
	$('.tip_modo_vista').button({
		icons: {primary: "ui-icon-document"},
		text: true
	});
	
	$('.tip_modo_reporte').button({
		icons: {primary: "ui-icon-document"},
		text: true
	});
	
	$('.tip_modo_vista').cluetip({
		/*
		attribute: 'rel',
		cluezIndex:11000,
		/*/
		width: 'auto',
   		height:'auto',
		local:true,
		cluetipClass: 'jtip',
		cluetipClass: 'rounded',
		arrows: true,
		dropShadow: true,
		hoverIntent: false,
		sticky: true,
		showTitle: false,
		cursor: 'pointer',
		positionBy: 'bottomTop',
		mouseOutClose: true,
		closePosition: 'title',
		closeText: '<div align="right"><img src="../../js/cluetip/demo/cross.png" alt="close" /></div>'
	});
	
	$('.tip_modo_reporte').cluetip({
		/*
		attribute: 'rel',
		cluezIndex:11000,
		/*/
		width: 'auto',
   		height:'auto',
		local:true,
		cluetipClass: 'jtip',
		cluetipClass: 'rounded',
		arrows: true,
		dropShadow: true,
		hoverIntent: false,
		sticky: true,
		showTitle: false,
		cursor: 'pointer',
		positionBy: 'bottomTop',
		mouseOutClose: true,
		closePosition: 'title',
		closeText: '<div align="right"><img src="../../js/cluetip/demo/cross.png" alt="close" /></div>'
	});
	
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
	
	catalogo_filtro();	

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
				$("#for_pro").submit();
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
	
	$( "#div_producto_info" ).dialog({
		title:'Detalle de Información',
		autoOpen: false,
		resizable: false,
		height: 490,
		width: 970,
		modal: true,
		position: 'fixed',
		buttons: {
			OK: function() {
				$( this ).dialog("close");
			}
		}
	});

	$(document).shortkeys({
	  //'a+g':       function () { catalogo_form('insertar') }
	});
		
});
</script>
<style>
#menu ul
{
    margin: 0px;
    padding: 0px;
    list-style-type: none;
}

#menu a
{
    display: block;
    width: auto;
	height: 19px;
    color: #36C;
    background-color: #FCFCFC;
    text-decoration: none;
    text-align: left;
	vertical-align:middle;
	font-weight:bold;
}

#menu a:hover
{
    background-color: #EAEAEA;
}
</style>
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
                    <td class="caption_cont">CATALOGO DE PRODUCTOS</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="6%" align="left" valign="middle"><a id="btn_agregar" title="Agregar Producto" href="#" onClick="producto_form('insertar')">Agregar</a></td>
                      <td width="6%" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td width="6%" align="left" valign="middle" nowrap>
                      <a class="tip_modo_vista" href="#div_modo_vista" rel="#div_modo_vista">Modo de Vista</a>
                      </td>
                      <?php /*?> <td width="6%" align="left" valign="middle" nowrap>
                     <a class="tip_modo_reporte" href="#div_modo_reporte" rel="#div_modo_reporte">Reportes</a>
                      </td><?php */?>
                      <td width="6%" align="left" valign="middle">
                      <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="catalogo_reporte_xls()" title="Imprimir en Excel">Excel</a>
                      <form action="catalogo_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
						<input type="hidden" id="hdd_tabla" name="hdd_tabla" /> 
						</form> 
                      </td>
                      <td width="72%" align="right">
                      <div id="msj_catalogo" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div><div id="msj_producto" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
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
        	<div id="div_modo_vista">
            MODO VISTA
                <div id="menu">
                    <ul>
                    		<li><a href="#" onClick="modo('catalogo_impresion.php')">Catálogo Info</a></li>
                        <!--<li><a href="#" onClick="modo('catalogo_tabla_ven.php')">Catálogo - Info</a></li>-->
                        <li><a href="#" onClick="modo('catalogo_stock_rep.php')">Stock por Empresa</a></li>
                        <li>----------------------------</li>
                       <!-- <li><a href="#" onClick="modo('inventario_tabla.php')">Inventario Valorizado - Promedio</a></li>-->
                        <li><a href="#" onClick="modo('inventario_valor_general.php')">Invent. Valorizado - Costo Prom Gen</a></li>
                        <li><a href="#" onClick="modo('inventario_stock_emp.php')">Costo Prom. Stock Almacenes Fecha</a></li>
                       <!-- <li><a href="#" onClick="modo('catalogo_tabla_si_ven.php')">Stock Valorizado - Saldo Inicial</a>-->
                    </ul>
                </div>
            </div>
            <?php /*?><div id="div_modo_reporte">
            REPORTES
                <div id="menu">
                    <ul>
                        <li><a href="#" onClick="catalogo_reporte('catalogo_reporte2.php')">Catalogo de Precios</a></li>
                        <li><a href="#" onClick="catalogo_reporte('catalogo_reporte3.php')">Stock por Empresa</a></li>
                        <li>----------------------------</li>
                        <li><a href="#" onClick="catalogo_reporte('inventario_reporte.php')">Inventario Valorizado</a></li>
                        <li><a href="#" onClick="catalogo_reporte('catalogo_reporte4.php')">Stock Valorizado - Saldo Inicial</a></li>
                    </ul>
                </div>
            </div><?php */?>
            <div id="div_catalogo_filtro" class="contenido_tabla">
      		</div>
            <div id="div_producto_form">
			</div>
            <div id="div_producto_info">
			</div>
            <div id="div_catalogo_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>