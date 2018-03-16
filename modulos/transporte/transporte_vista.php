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
<title>Clientes</title>
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

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
function transporte_tabla(){			
	$.ajax({						
		url: "transporte_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
		}),
		beforeSend: function() {
			$('#div_transporte_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_transporte_tabla').html(html);
		},
		complete: function(){			
			$('#div_transporte_tabla').removeClass("ui-state-disabled");
		}
	});        
}
	
function transporte_form(act,idf){
	$.ajax({
		type: "POST",
		url: "transporte_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			tra_id:	idf,
			vista:	'transporte_tabla'
		}),
		beforeSend: function() {
			$('#msj_transporte').hide();
			$('#div_transporte_form').dialog("open");
			$('#div_transporte_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_transporte_form').html(html);				
		}
	});
}

function eliminar_transporte(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "transporte_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				tra_id:		id
			}),
			beforeSend: function() {
				$('#msj_transporte').html("Cargando...");
				$('#msj_transporte').show(100);
			},
			success: function(html){
				$('#msj_transporte').html(html);
				$('#msj_transporte').show();
			},
			complete: function(){
				transporte_tabla();
			}
		});
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
	
	transporte_tabla();
		
	$( "#div_transporte_form" ).dialog({
		title:'Información de Transporte',
		autoOpen: false,
		resizable: false,
		height: 300,
		width: 530,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_tra").submit();
			},
			Cancelar: function() {
				$('#for_tra').each (function(){this.reset();});
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
                    <td class="caption_cont">TRANSPORTE</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="transporte_form('insertar')">Agregar</a></td>
                      <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right"><div id="msj_transporte" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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
            <div id="div_transporte_form">
            </div>
        	<div id="div_transporte_tabla" class="contenido_tabla">
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>