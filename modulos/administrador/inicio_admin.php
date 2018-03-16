<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Principal | Administrador</title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">
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
<script src="../../js/jquery-ui/development-bundle/ui/jquery.effects.core.js"></script>

<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/i18n/jquery.ui.datepicker-es.js"></script>

<script src="../../js/jquery-ui/development-bundle/external/jquery.metadata.js"></script>
<script src="../../js/Moneda/autoNumeric.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
function cuadromi(){
	$.ajax({
		type: "POST",
		url: "../cuadromi/cuadromi_adm.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//mar_id:	idf
		}),
		beforeSend: function() {
			$('#div_cuadromi').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_cuadromi').html(html);				
		}
	});
}

function tipoCambiodelDia(){
	$.ajax({
		type: "POST",
		url: "../tipocambio/tipocambio_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: 'insertar',
			vista:	'tipocambio_principal'
		}),
		beforeSend: function() {			
			$('#div_tipocambio_form').dialog("open");
			$('#div_tipocambio_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){			
			$('#div_tipocambio_form').html(html);				
		}
	});
}

function verificarMostrarModal(){
	$.ajax({
		type: "POST",
		url: "../tipocambio/tipocambio_reg.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: 'consultar'
		}),
		beforeSend: function() {			
			//$('#div_tipocambio_form').dialog("open");
			//$('#div_tipocambio_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(numero){					
			if(numero > 0){
				//tipoCambiodelDia();	
			}else{
				tipoCambiodelDia();
			}
		}
	});
}

function verificarDatoFormula(){
	$.ajax({
		type: "POST",
		url: "../formula/formula_reg.php",
		async:true,
		dataType: "json",                      
		data: ({
			action: 'consultar_dato_formula',
			ide: 'MOS_TIPO_CAMBIO'
		}),
		beforeSend: function() {			
			//$('#div_tipocambio_form').dialog("open");
			//$('#div_tipocambio_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(data){					
			if(data.dato == 1){
				verificarMostrarModal();
			}		
		}
	});
}

$(function() {

	tipoCambiodelDia();
	
	$('#btn_actualizar').button({
		icons: {primary: "ui-icon-arrowrefresh-1-e"},
		text: false
		}).click(function() {
			cuadromi();
	});
	
	cuadromi();
	
	
	$( "#div_tipocambio_form" ).dialog({
		title:'Información de Tipo de Cambio',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 250,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_tipcam").submit();
			},
			Cancelar: function() {
				$('#for_tipcam').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	//verificarMostrarModal();
	verificarDatoFormula()
	
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
            <div class="contenido_des">
            <table  align="center" class="tabla_cont">
                  <tr>
                    <td class="caption_cont">PRINCIPAL</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><span title="Está Visualizando la Información de:"><?php echo $_SESSION['empresa_nombre']?></span></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                        <td width="25" align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                      </tr>
                    </table>
                    </td>
                  </tr>
                </table>
            </div>
        </div>
		<div id="div_cuadromi" class="contenido_tabla">
      	</div>
        <div id="div_tipocambio_form"></div>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>