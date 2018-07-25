<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Principal</title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">

</head>

<body>
<div></div>
<div>
<table  align="center" class="tabla_cont" bgcolor="#F9F9F9">
      <tr>
        <td class="caption_cont">MENSAJE</td>
      </tr>
      <tr>
        <td class="cont_emp"><span title="Está Visualizando la Información de:"><?php echo $_SESSION['empresa_nombre']?></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="340" cellspacing="0">
          <tr>
            <td width="193" align="center">SU MENSAJE FUE ENVIADO CORRECTAMENTE!</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
      <tr>
        <td align="center"><input name="btn_cerrar" type="submit" class="ButtonT" id="btn_cerrar" onClick="self.close();" onKeyPress="self.close();" value="Cerrar" /></td>
      </tr>
    </table>
</div>
</body>
</html>