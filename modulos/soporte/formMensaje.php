<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}

require_once("../formatos/formatos.php");

require_once ("../../Clases/cAdelanto.php");
$oAdelanto = new cAdelanto();

require_once ("../form/cForm.php");
$oForm = new cForm();

if($_GET['action']=="editar")
{
	$dts=$oAdelanto->mostrarUno($_GET['id']);
	$dt = mysql_fetch_array($dts);

	$fec=mostrarFecha($dt['tb_adelanto_fec']);
	
	$des=$dt['tb_adelanto_des'];
	$tip=$dt['tb_adelanto_tip'];
	$mon=$dt['tb_adelanto_mon'];

	$est=$dt['tb_adelanto_est'];
	
	$emp=$dt['tb_empresa_id'];
	mysql_free_result($dts);
}
$mon=formato_moneda($mon);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<title>Mensaje</title>
<script language='javascript' src="../../calendario/popcalendar.js" type="text/jscript"></script>
<script language="javascript" src="../../js/recursos.js" type="text/javascript"></script>
</head>

<body>
<form action="../../rAdelanto.php?action=<?php echo $_GET['action']?>" method="post" name="form1">
<input name="hdd_id" type="hidden" value="<?php echo $_GET['id']?>">
<input name="hdd_per" type="hidden" value="<?php echo $_GET['personal']?>">
<input name="hdd_use" type="hidden" value="<?php echo $_SESSION['user_id']?>">
<input name="hdd_emp" type="hidden" value="<?php echo $_SESSION['empresa']?>">
<table class="tabla_form" align="center">
      <tr>
          <td colspan="2" class="caption_form">Form Mensaje</td>
        </tr>
        <tr>
          <td colspan="2" align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">Para:</td>
          <td><label for="txt_des"></label>
          <input name="txt_des2" type="text" id="txt_des" readonly></td>
        </tr>
        <tr>
          <td align="right">Asunto:</td>
          <td><label>
            <input name="txt_des" type="text" id="txt_des" value="<?php echo $asu?>" size="60">
            </label></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><label for="txt_con"></label>
          <textarea name="txt_con" id="txt_con" cols="50" rows="5"></textarea></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="right">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="center"><label>
            <input name="btn_enviar" type="submit" class="ButtonT" id="btn_enviar" value="Guardar">
            </label>
            <label><input class="ButtonT" type="button" value="Cancelar" onClick="self.close();" onKeyPress="self.close();"></label></td>
        </tr>
      </table>
      </form>
</body>
</html>
