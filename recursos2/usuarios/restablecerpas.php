<!DOCTYPE HTML>
<html>
<head>
<link href="../../images/favicon.ico" type="image/x-icon" rel="shortcut icon">
<title>Recuperación de Cuenta</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/Estilo/miestilo_blank.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>
<script type="text/javascript">

function enviar_email(){
	$("#form").submit();    
}

$(function() {
	$('#btn_enviar').button({
		icons: {
			//primary: "ui-icon-check",
			text: true		
		}
	});
	
	//$('#btn_enviar').click(function(){
    	//$("#for_usugru").submit();
  	//});
	
	$("#form").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "restablecerpas_reg.php",
				async:true,
				dataType: "html",
				data: ({
					email	: $('#txt_res_ema').val()			
				}),
				beforeSend: function() {
					$('#div_mensaje').html("Cargando <img src='images/loadingf11.gif' align='absmiddle'/>");
					$('#div_mensaje').show();
				},
				success: function(html){
					$('#div_mensaje').html(html);
					$('#div_contenido').html('<a href="login.php">Iniciar sesión</a><br><br><a href="restablecerpas.php">Restablecer Contraseña</a>');
				}
			});
		},
		rules: {
			txt_res_ema: {
            	required: true,
				email: true
            }
		},
		messages: {
			txt_res_ema: {
				//required: ""
			}
		}
	});             
});
</script>
<style type="text/css">
.link {
	font-size: 14px;
}
.link strong {
	color: #CCC;
	font-size: 16px;
}
a:hover {
	text-decoration: none;
	color: #36F;
}
.titulo {
	color: #CCC;
}
</style>
</head>

<body>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="25" align="center" bgcolor="#025A8D"><strong class="titulo">Ir a la Página Principal del Sitio</strong></td>
  </tr>
  <tr>
    <td height="35" align="center" bgcolor="#025A8D"><a href="../../../portal" class="link"><strong>m-trainingperu.com</strong></a></td>
  </tr>
  <tr>
    <td height="41" align="center"><div id="div_mensaje" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
  </tr>
  <tr>
    <td>
    <div id="div_contenido">
    <fieldset>
  <table width="650" border="0" align="center">
  <tr>
    <th height="36" colspan="4" align="center"><strong>¿Has olvidado tu contraseña?</strong></th>
  </tr>
  <tr>
    <td width="251" valign="top"><p align="justify">Para restablecer tu contraseña, introduce tu dirección de correo electrónico que hayas asociado a la cuenta.</p></td>
    <td width="60%" colspan="3" rowspan="2" valign="top">
    <form method="post" name="form" id="form">
    
        <fieldset class="fset" style="background-color:#FBFBFB">
  <legend class="leg">Dirección de correo electrónico
</legend>
          <table width="99%" border="0">
        <tr>
          <td width="303" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><label>
            <input name="txt_res_ema" type="text" id="txt_res_ema" autofocus placeholder="" size="55" />
          </label></td>
          </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td><a id="btn_enviar" href="#" onClick="enviar_email()">Enviar</a></td>
        </tr>
      </table>
      </fieldset>
    </form></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="right"><a href="../../login.php">Iniciar sesión</a></td>
  </tr>
</table>
</fieldset>
	</div>
</td>
  </tr>
</table>
</body>
</html>