<?php
require_once ("../../config/datos.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<link href="../../images/favicon.ico" type="image/x-icon" rel="shortcut icon">
<title>Iniciar sesión</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/Estilo/miestilo_blank.css" rel="stylesheet" type="text/css">

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
    <td height="25" align="center" bgcolor="#025A8D"><!--<strong class="titulo">Ir a la Página Principal del Sitio</strong>--></td>
  </tr>
  <tr>
    <td height="35" align="center" bgcolor="#025A8D"><a href="#" class="link"><strong>SISTEMA DE GESTION EMPRESARIAL</strong></a></td>
  </tr>
  <tr>
    <td height="41" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>
    <fieldset>
  <table width="650" border="0" align="center">
  <tr>
    <td align="center">Si usted se encuentra en ésta página probablemente no pueda tener acceso, posibles incidencias:</td>
  </tr>
  <tr>
    <td height="148" align="center" valign="top"><?php echo '</br>'.$_GET['mm']?></td>
  </tr>
  <tr>
    <td width="251" align="center">Comuníquese con el Administrador o vuelva a intentarlo. <a href="./login.php">Iniciar sesión</a></td>
    <!--<td colspan="3" align="right"><a href="restablecerpas.php">¿No puedes acceder a tu cuenta?</a></td>-->
  </tr>
  <tr>
    <td height="41" align="center">&nbsp;</td>
  </tr>
  </table>
</fieldset>
</td>
  </tr>
</table>
<div align="center">
<a href="http://<?php echo $d_dominio?>"><?php echo $d_dominio?></a>
<!--<a href="http://www.inticap.com" target="_blank">Sistema de Ventas. INTICAP www.inticap.com</a>-->
</div>
</body>
</html>