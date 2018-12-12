<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();
require_once("cHorario.php");
$oHorario = new cHorario();
require_once ("../formatos/formato.php");

	$dts= $oHorario->mostrarUno($_SESSION['horario_id']);
	$dt = mysql_fetch_array($dts);
	
		$nom	=$dt['tb_horario_nom'];
		$fecini	=mostrarFecha($dt['tb_horario_fecini']);
		$fecfin	=mostrarFecha($dt['tb_horario_fecfin']);
		$est	=$dt['tb_horario_est'];
		
		$lun	=$dt['tb_horario_lun'];
		$mar	=$dt['tb_horario_mar'];
		$mie	=$dt['tb_horario_mie'];
		$jue	=$dt['tb_horario_jue'];
		$vie	=$dt['tb_horario_vie'];
		$sab	=$dt['tb_horario_sab'];
		$dom	=$dt['tb_horario_dom'];
		
		$horini1	=mostrarHora($dt['tb_horario_horini1']);
		$horfin1	=mostrarHora($dt['tb_horario_horfin1']);
		$horini2	=mostrarHora($dt['tb_horario_horini2']);
		$horfin2	=mostrarHora($dt['tb_horario_horfin2']);
	
	mysql_free_result($dts);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Horario</title>
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

$(function() {
	$(":input").attr("disabled", "disabled");
	//$( "#format_checks" ).buttonset();
	
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
                    <td class="caption_cont">HORARIO</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right"><div id="msj_almacen" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
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
        	<div id="div_almacen_tabla" class="contenido_tabla">
            <form id="for_hor">
<input name="action_horario" id="action_horario" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_hor_id" id="hdd_hor_id" type="hidden" value="<?php echo $_POST['hor_id']?>">
<fieldset><legend>General</legend>
<label for="txt_hor_nom">Nombre de Horario:</label>
<input name="txt_hor_nom" type="text" id="txt_hor_nom" size="55" maxlength="50" value="<?php echo $nom?>">
<br>
<label for="txt_hor_fecini">Horario válido desde:</label>
<input name="txt_hor_fecini" type="text" id="txt_hor_fecini" value="<?php echo $fecini?>" size="8" readonly>
<label for="txt_hor_fecfin"> hasta</label>
<input name="txt_hor_fecfin" type="text" id="txt_hor_fecfin" value="<?php echo $fecfin?>" size="8" readonly>

<label for="cmb_hor_est">Estado</label>
<select name="cmb_hor_est" id="cmb_hor_est" disabled>
<option value="">-</option>
<option value="ACTIVO" <?php if($est=='ACTIVO')echo 'selected'?>>ACTIVO</option>
<option value="INACTIVO" <?php if($est=='INACTIVO')echo 'selected'?>>INACTIVO</option>
</select>
</fieldset>
<fieldset><legend>Detalle Horario</legend>
    <table>                
        <tr>
          <td>Día(s):</td>
        </tr>
        <tr>
          <td>
          <div id="format_checks">
          <input name="chk_hor_lun" type="checkbox" id="chk_hor_lun" value="1" <?php if($lun==1)echo 'checked'?>>
          <label for="chk_hor_lun">Lunes</label>
          <input name="chk_hor_mar" type="checkbox" id="chk_hor_mar" value="1" <?php if($mar==1)echo 'checked'?>>
          <label for="chk_hor_mar">Martes</label>
          <input name="chk_hor_mie" type="checkbox" id="chk_hor_mie" value="1" <?php if($mie==1)echo 'checked'?>>
          <label for="chk_hor_mie">Miércoles</label>
          <input name="chk_hor_jue" type="checkbox" id="chk_hor_jue" value="1" <?php if($jue==1)echo 'checked'?>>
          <label for="chk_hor_jue">Jueves</label>
          <input name="chk_hor_vie" type="checkbox" id="chk_hor_vie" value="1" <?php if($vie==1)echo 'checked'?>>
          <label for="chk_hor_vie">Viernes</label>
          <input name="chk_hor_sab" type="checkbox" id="chk_hor_sab" value="1" <?php if($sab==1)echo 'checked'?>>
          <label for="chk_hor_sab">Sábado</label>
          <input name="chk_hor_dom" type="checkbox" id="chk_hor_dom" value="1" <?php if($dom==1)echo 'checked'?>>
          <label for="chk_hor_dom">Domingo</label>
          </div>        
          </td>
        </tr>
        <tr>
          <td>
          TURNO 1: 
            <label for="txt_hor_horini1">Hora Inicio</label>
          	<input name="txt_hor_horini1" type="text" id="txt_hor_horini1" value="<?php echo $horini1?>" size="10" maxlength="5" />
            <label for="txt_hor_horfin1">Hora Fin</label>
          <input name="txt_hor_horfin1" type="text" id="txt_hor_horfin1" value="<?php echo $horfin1?>" size="10" maxlength="5" /></td>
        </tr>
        <tr>
          <td>TURNO 2:
            <label for="txt_hor_horini2">Hora Inicio</label>
            <input name="txt_hor_horini2" type="text" id="txt_hor_horini2" value="<?php echo $horini2?>" size="10" maxlength="5" />
            <label for="txt_hor_horfin2">Hora Fin</label>
          <input name="txt_hor_horfin2" type="text" id="txt_hor_horfin2" value="<?php echo $horfin2?>" size="10" maxlength="5"/></td>
        </tr>        
    </table>
</fieldset>
</form>
      		</div>
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>