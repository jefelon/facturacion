<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../ingreso_r/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../gasto_r/cGasto.php");
$oGasto = new cGasto();
require_once("../formatos/formato.php");
require_once("../formatos/mysql.php");
$oMysql = new cMysql();
/*$ingreso=$_POST['ingreso'];
if($_POST['ingreso']=="")$ingreso=0;

$gasto=$_POST['gasto'];
if($_POST['gasto']=="")$gasto=0;*/

$emp_id=1;

//$ref_id=1;
$estado_ingreso='CANCELADO';
$estado_gasto='CANCELADO';

//SALDO ANTERIOR
$fec_ini='01-01-2013';
$fec_fin=$oMysql->DATE_ADD(fecha_mysql($_POST['txt_fil_caj_fec1']),'-1','DAY');

$dts=$oIngreso->mostrar_suma($emp_id,fecha_mysql($fec_ini),fecha_mysql($fec_fin),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_ing_doc'],$_POST['cmb_fil_cli_id'],$_POST['cmb_fil_entfin_id'],$estado_ingreso,$_POST['cmb_fil_caj_id'],$ref_id);
$dt = mysql_fetch_array($dts);
$sa_ingreso	=$dt['total'];
mysql_free_result($dts);

$dts=$oGasto->mostrar_suma($emp_id,fecha_mysql($fec_ini),fecha_mysql($fec_fin),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_pro_id'],$_POST['cmb_fil_entfin_id'],$estado_gasto,$_POST['cmb_fil_caj_id']);
$dt = mysql_fetch_array($dts);
$sa_gasto	=$dt['total'];
mysql_free_result($dts);

$saldo_anterior=$sa_ingreso-$sa_gasto;


//ENTRADA SALIDA

$dts=$oIngreso->mostrar_suma($emp_id,fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_ing_doc'],$_POST['cmb_fil_cli_id'],$_POST['cmb_fil_entfin_id'],$estado_ingreso,$_POST['cmb_fil_caj_id'],$ref_id);
$dt = mysql_fetch_array($dts);
$ingreso	=$dt['total'];
mysql_free_result($dts);

$dts=$oGasto->mostrar_suma($emp_id,fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_pro_id'],$_POST['cmb_fil_entfin_id'],$estado_gasto,$_POST['cmb_fil_caj_id']);
$dt = mysql_fetch_array($dts);
$gasto	=$dt['total'];
mysql_free_result($dts);

$saldo=$saldo_anterior+$ingreso-$gasto;
?>
<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left">SALDO ANTERIOR</td>
    <td align="right"><?php echo formato_money($saldo_anterior)?></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">INGRESOS</td>
    <td align="right"><?php echo formato_money($ingreso)?></td>
  </tr>
  <tr>
    <td align="left">GASTOS</td>
    <td align="right"><?php echo formato_money($gasto)?></td>
  </tr>
  <tr style="font-weight:bold" height="25">
    <td align="left">SALDO</td>
    <td align="right"><?php echo formato_money($saldo)?></td>
  </tr>
</table>
