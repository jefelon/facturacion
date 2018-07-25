<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../../config/Cado.php");

require("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();

//datos de usuario
$dts=$oUsuario->mostrarUno($_SESSION['usuario_id']);
$dt = mysql_fetch_array($dts);
$nom=$dt['tb_usuario_nom']." ".$dt['tb_usuario_apepat']." ".$dt['tb_usuario_apemat'];
$ema=$dt['tb_usuario_ema'];
mysql_free_result($dts);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Form Mail</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">

</head>

<body>
<form method="post" action="form2mail.php">
<input name="Usuario" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="Empresa" type="hidden" value="<?php echo $_SESSION['empresa_id']?>">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td><table width="700" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr bgcolor="#FFFFFF">
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Nombres y Apellidos: </font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="Nombre" type="text" id="Nombre" value="<?php echo $nom?>" size="50" <?php if ($nom!="")echo 'readonly="readonly"'?>>
          </font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email: </font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="Email" type="text" id="Email" value="<?php echo $ema?>" size="50" <?php if ($ema!="")echo 'readonly="readonly"'?>>
          </font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Asunto: </font></td>
          <td align="left"><label for="Asunto"></label>
            <input name="Asunto" type="text" id="Asunto" size="50"></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Seleccione Tema:</font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <select name="Tema" id="Tema">
              <option value="Consulta">Consulta</option>
              <option value="Requerimiento">Requerimiento</option>
              <option value="Otro">Otro</option>
            </select>
          </font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Referencia o Ubicaci&oacute;n dentro de la Aplicación:<font size="1"><br>
            *P. Ej. Lista de eventos, Formulario Participante, etc</font>          </font></td>
          <td align="left"><label for="Ubicacion"></label>
            <input name="Ubicacion" type="text" id="Ubicacion" size="50"></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Mensaje:</font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <textarea name="Mensaje" cols="60" rows="8" id="Mensaje"></textarea>
            </font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td colspan="2" align="center"><input name="btn_enviar" type="submit" class="ButtonT" value="Enviar" id="btn_enviar"></td>
        </tr>
      </table>
    </td></tr></table></form>
</body>
</html>
