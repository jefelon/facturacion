<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("../formatos/fechas.php");

require_once("../cuentas/cCuenta.php");
$oCuenta = new cCuenta();
require_once("../cuentas/cSubcuenta.php");
$oSubcuenta = new cSubcuenta();
require_once ("../entfinanciera/cEntfinanciera.php");
$oEntfinanciera = new cEntfinanciera();
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();

$est="'".$_GET['est']."'";

$dts=$oCuenta->mostrarUno($_GET['cue']);
$dt = mysql_fetch_array($dts);
$cue_des=$dt['tb_cuenta_des'];
mysql_free_result($dts);

if($_GET['cue']==0)$cue_des='INGRESOS';

$dts=$oSubcuenta->mostrarUno($_GET['subcue']);
$dt = mysql_fetch_array($dts);
$subcue_des=$dt['tb_subcuenta_des'];
mysql_free_result($dts);


if(isset($_GET['entfin']))
{
	$entfinanciera=$_GET['entfin'];
	$dts=$oEntfinanciera->mostrarUno($_GET['entfin']);
	$dt = mysql_fetch_array($dts);
	$entfin_des=$dt['tb_entfinanciera_nom'];
	mysql_free_result($dts);
}
else
{
	$entfinanciera=0;
}

//$entfinanciera=0;
$cliente=0;

//echo $_GET['emp'].'/'.$_GET['a'].'/'.$_GET['m'].'/'.$_GET['cue'].'/s'.$_GET['subcue'].'/'.$doc.'/'.$cliente.'/'.$entfinanciera.'/'.$_GET['est'];

$dts1=$oIngreso->mostrar_filtro($_GET['emp'],$_GET['a'],$_GET['m'],$_GET['cue'],$_GET['subcue'],$doc,$cliente,$entfinanciera,$_GET['est']);
$num_reg=mysql_num_rows($dts1);
?>

<!--<script type="text/javascript">
$(function() {	
	$('.btn_verdetalle').button({
		//icons: {primary: "ui-icon-pencil"},
		text: true
	});
});
</script>-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong><?php echo $cue_des?></strong></td>
    <td rowspan="3" align="right" valign="top"><?php echo $_GET['a']?><br><?php echo nombre_mes($_GET['m'])?></td>
  </tr>
  <tr>
    <td><strong><?php echo $subcue_des?></strong></td>
  </tr>
  <tr>
    <td><?php echo $entfin_des?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><?php 
if($num_reg==0)
{
	echo "Ningún registro";
}
if($num_reg==1)
{
	echo $num_reg." registro";
}
if($num_reg>1)
{
	echo $num_reg." registros";
}
?> | <a href="#detalle" class="btn_verdetalle" onClick="detalle_ingresos(<?php echo $_GET['cue'].','.$_GET['subcue'].','.$_GET['emp'].','.$_GET['a'].','.$_GET['m'].','.$est.','.$entfinanciera?>)"><span class="btn_verdetalle">Ver detalle</span></a></td>
  </tr>
</table>
