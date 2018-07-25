<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/datos.php");
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();

require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Soporte Técnico</title>
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

<script src="../../js/vistaButton.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$("#btn_chrome").button({
		icons: {primary: "ui-icon-carat-1-e",
                secondary: "ui-icon-arrowthickstop-1-s"
			}
		});
	$("#btn_firefox").button({
		icons: {primary: "ui-icon-carat-1-e",
                secondary: "ui-icon-arrowthickstop-1-s"
			}
		});
	$("#btn_comentario").button({
		icons: {primary: "ui-icon-mail-closed"
			}
		});
})
</script>
</head>

<body>
<div class="container">
	<header>
    	<?php echo $oContenido->print_header()?>
	</header>
    <article class="content">
    	<div class="contenido">
    	<section>
            <div class="contenido_des">
            <table  align="center" class="tabla_cont">
                  <tr>
                    <td class="caption_cont">SOPORTE TÉCNICO</td>
                  </tr>
                  <tr>
                    <td class="cont_emp"><span title="Está Visualizando la Información de:"><?php echo $_SESSION['empresa_nombre']?></span></td>
                  </tr>
                </table>
            </div>
        </section>
        <section>
        	<div>
            <table width="532" cellpadding="3" cellspacing="2" align="center">
          <tr>
            <td width="528"><div align="justify">Ud. Se encuentra en el Área de Soporte Técnico, si tiene alguna consulta, sugerencia, requerimiento o cualquier comentario porfavor  complete el siguiente <a id="btn_comentario" href="javascript:popUp('formMensaje',800,400,'form_mail.php')">formulario</a>. Gracias.</div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>La aplicación se integra mejor con los siguientes navegadores:</td>
          </tr>
          <tr>
            <td><a id="btn_chrome" target="_blank" href="http://www.google.com/chrome?hl=es">Google Chrome - Descargar</a></td>
          </tr>
          <tr>
            <td><a id="btn_firefox" target="_blank" href="http://www.mozilla.org/es-ES/firefox/new/">Mozilla Firefox - Descargar</a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>TUTORIAL: <a href="https://www.a-zetasoft.com/facturacion-electronica-sunat-arequipa/" target="_blank">Ingresar aquí</a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Información: <?php echo $d_email_soporte?><br>
            Para más información entra a: <a href="https://www.a-zetasoft.com" target="_blank">www.a-zetasoft.com</a></td>
          </tr>
            </table>
          </div>
        </section>
        </div>
	</article>
</div>
<footer>
   	<?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>