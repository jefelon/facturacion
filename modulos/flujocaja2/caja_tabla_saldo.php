<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../gasto/cGasto.php");
$oGasto = new cGasto();
require_once("../formatos/formato.php");
require_once("../formatos/mysql.php");
$oMysql = new cMysql();
/*$ingreso=$_POST['ingreso'];
if($_POST['ingreso']=="")$ingreso=0;

$gasto=$_POST['gasto'];
if($_POST['gasto']=="")$gasto=0;*/

$emp_id=1;

$ref_id=1;
$estado_ingreso='CANCELADO';
$estado_gasto='CANCELADO';

//fechas
$fec_ini='01-01-2013';
$fec_fin=$oMysql->DATE_ADD(fecha_mysql($_POST['txt_fil_caj_fec1']),'-1','DAY');

//CAJA SOLES______________
$mon_id=1;

//SALDO ANTERIOR
$dts=$oIngreso->mostrar_suma($emp_id,fecha_mysql($fec_ini),fecha_mysql($fec_fin),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_ing_doc'],$_POST['cmb_fil_cli_id'],$_POST['cmb_fil_entfin_id'],$estado_ingreso,$_POST['cmb_fil_caj_id'],$mon_id,$ref_id);
$dt = mysql_fetch_array($dts);
$sa_ingreso_sol	=$dt['total'];
mysql_free_result($dts);

$dts=$oGasto->mostrar_suma($emp_id,fecha_mysql($fec_ini),fecha_mysql($fec_fin),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_pro_id'],$_POST['cmb_fil_entfin_id'],$estado_gasto,$_POST['cmb_fil_caj_id'],$mon_id,$ref_id);
$dt = mysql_fetch_array($dts);
$sa_gasto_sol	=$dt['total'];
mysql_free_result($dts);

$saldo_anterior_sol=$sa_ingreso_sol-$sa_gasto_sol;


//ENTRADA

$dts=$oIngreso->mostrar_suma($emp_id,fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_ing_doc'],$_POST['cmb_fil_cli_id'],$_POST['cmb_fil_entfin_id'],$estado_ingreso,$_POST['cmb_fil_caj_id'],$mon_id,$ref_id);
$dt = mysql_fetch_array($dts);
$ingreso_sol	=$dt['total'];
mysql_free_result($dts);

//SALIDA
$dts=$oGasto->mostrar_suma($emp_id,fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_pro_id'],$_POST['cmb_fil_entfin_id'],$estado_gasto,$_POST['cmb_fil_caj_id'],$mon_id,$ref_id);
$dt = mysql_fetch_array($dts);
$gasto_sol	=$dt['total'];
mysql_free_result($dts);

$saldo_sol=$saldo_anterior_sol+$ingreso_sol-$gasto_sol;


//CAJA DOLARES______________
$mon_id=2;

//SALDO ANTERIOR
$dts=$oIngreso->mostrar_suma($emp_id,fecha_mysql($fec_ini),fecha_mysql($fec_fin),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_ing_doc'],$_POST['cmb_fil_cli_id'],$_POST['cmb_fil_entfin_id'],$estado_ingreso,$_POST['cmb_fil_caj_id'],$mon_id,$ref_id);
$dt = mysql_fetch_array($dts);
$sa_ingreso_dol	=$dt['total'];
mysql_free_result($dts);

$dts=$oGasto->mostrar_suma($emp_id,fecha_mysql($fec_ini),fecha_mysql($fec_fin),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_pro_id'],$_POST['cmb_fil_entfin_id'],$estado_gasto,$_POST['cmb_fil_caj_id'],$mon_id,$ref_id);
$dt = mysql_fetch_array($dts);
$sa_gasto_dol	=$dt['total'];
mysql_free_result($dts);

$saldo_anterior_dol=$sa_ingreso_dol-$sa_gasto_dol;


//ENTRADA

$dts=$oIngreso->mostrar_suma($emp_id,fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_ing_doc'],$_POST['cmb_fil_cli_id'],$_POST['cmb_fil_entfin_id'],$estado_ingreso,$_POST['cmb_fil_caj_id'],$mon_id,$ref_id);
$dt = mysql_fetch_array($dts);
$ingreso_dol	=$dt['total'];
mysql_free_result($dts);

//SALIDA
$dts=$oGasto->mostrar_suma($emp_id,fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_pro_id'],$_POST['cmb_fil_entfin_id'],$estado_gasto,$_POST['cmb_fil_caj_id'],$mon_id,$ref_id);
$dt = mysql_fetch_array($dts);
$gasto_dol	=$dt['total'];
mysql_free_result($dts);

$saldo_dol=$saldo_anterior_dol+$ingreso_dol-$gasto_dol;
?>
<table width="350" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="24" align="left">CAJA </th>
    <th height="24" align="right">SOLES S/.</th>
    <th height="24" align="right">&nbsp;</th>
    <th height="24" align="right">&nbsp;</th>
    <th height="24" align="right">DOLARES US$.</th>
  <tr>
    <td align="left">SALDO ANTERIOR</td>
    <td align="right"><?php echo formato_money($saldo_anterior_sol)?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo formato_money($saldo_anterior_dol)?></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">INGRESOS</td>
    <td align="right"><?php echo formato_money($ingreso_sol)?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo formato_money($ingreso_dol)?></td>
  </tr>
  <tr>
    <td align="left">GASTOS</td>
    <td align="right"><?php echo formato_money($gasto_sol)?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo formato_money($gasto_dol)?></td>
  </tr>
  <tr style="font-weight:bold" height="25">
    <td align="left">SALDO</td>
    <td align="right"><?php echo formato_money($saldo_sol)?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo formato_money($saldo_dol)?></td>
  </tr>
</table>