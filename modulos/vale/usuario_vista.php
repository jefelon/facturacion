<?php
session_start();
require_once ("../../config/Cado.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Registro de vale</title>
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
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.tabs.js"></script>

<script src="../../js/vistaButton.js"></script>

<script src="../../js/formButton.js"></script>
<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
function insertar_usuario()
{
	$.ajax({
		type: "POST",
		url: "../vale/usuario_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "insertar"
		}),
		beforeSend: function() {
			$('#msj_usuario').hide();
			$('#div_usuario_form').dialog( "open" );
			$('#div_usuario_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_usuario_form').html(html);
		},
		complete: function(){			

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

	insertar_usuario();
});

</script>
<style>
#txt_nom2{
	font-size: 16px;
	border: 1px solid silver;
	background: #fff;
	padding: 8px 10px;
	border-color: #bdc7d8;
	-webkit-border-radius: 5px;
}
._input{
	font-size: 16px;
	border: 1px solid silver;
	background: #fff;
	padding: 8px 10px;
	border-color: #bdc7d8;
	-webkit-border-radius: 5px;
}
._title1{
	color: #fff;
	font-size: 16px;
	font-weight: bold;
}
._title{
	color: #333;
	font-size: 16px;
	font-weight: normal;
}
._title2{
	color: #333;
	font-size: 16px;
	font-weight: bold;
}
._texto{
	font-size: 10pt;
	font-weight: normal;
}
</style>
</head>
<body>
<div class="container">
	<header></header>
    <article class="content">
    	<div class="contenido">
		<section>
            <div class="contenido_des">
			<table align="center" class="tabla_cont">
      <tr>
        <td>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="insertar_usuario()">Registrarme</a></td>
              <td width="25" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="right"><div id="msj_usuario" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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
		</section>
    <table width="100%">
    <tr>
      <td width="220" height="25px" align="center" bgcolor="#336699"><div class="_title1">REGISTRATE PARA OBTENER TU VALE DE DESCUENTO</div></td>
      </tr>
    <tr>
      <td><div id="div_usuario_form">
					</div></td>
      </tr>
    </table>
    			
       	<div id="div_usuario_tabla">
      		</div>
          <table width="100%" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td align="left">&nbsp;</td>
  </tr>
    <tr>
      <td align="left" class="_texto">Visita cualquiera de nuestras tiendas con el vale impreso o muestranos en tu smartphone.<br></td>
  </tr>
    <tr>
      <td align="left" class="_texto"><strong>Nuestras tiendas:</strong><br>
        <ul>
          <li>Av. Augusto. B. Leguía N° 1160 José Leonardo Ortiz.</li>
          <li>Calle Virgilio Dallorso N° 175 - 179 Centro.</li>
        </ul></td>
  </tr>
    <tr>
      <td align="left" class="_texto">
      Si no te llega el mensaje revisa tu bandeja "correo no deseado", agrega a tu lista segura el correo ventas@granadosllantas.com<br>
      Si tienes algún otro inconveniente comunícate con nosotros a ventas@granadosllantas.com<br>
        <a href="http://granadosllantas.com/portal/index.php/contactenos" title="Envía tu consulta" target="_blank">ó Envía tu consulta desde acá.</a></p></td>
  </tr>
</table>
      	</div>
    </article>
</div>
<footer>
</footer>
</body>
</html>