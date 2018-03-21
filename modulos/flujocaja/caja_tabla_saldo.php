<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../egreso/cEgreso.php");
$oEgreso = new cEgreso();
require_once("../formatos/formato.php");
require_once("../formatos/mysql.php");
$oMysql = new cMysql();

$estado_ingreso='1';
$estado_egreso='1';

//fechas
$fec_ini='01-01-2014';
$fec_fin=$oMysql->DATE_ADD(fecha_mysql($_POST['txt_fil_caj_fec1']),'-1','DAY');

//CAJA SOLES______________
$mon_id=1;

//SALDO ANTERIOR
$dts=$oIngreso->mostrar_suma($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($fec_ini),$fec_fin,$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_ing_numdoc'],$_POST['cmb_fil_cli_id'],$estado_ingreso);
$dt = mysql_fetch_array($dts);
$sa_ingreso_sol	=$dt['total'];
mysql_free_result($dts);

$dts=$oEgreso->mostrar_suma($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($fec_ini),$fec_fin,$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_egr_numdoc'],$_POST['cmb_fil_pro_id'],$estado_egreso);
$dt = mysql_fetch_array($dts);
$sa_egreso_sol	=$dt['total'];
mysql_free_result($dts);

$saldo_anterior_sol=$sa_ingreso_sol-$sa_egreso_sol;


//ENTRADA

$dts=$oIngreso->mostrar_suma($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_egr_numdoc'],$_POST['cmb_fil_pro_id'],$estado_ingreso);
$dt = mysql_fetch_array($dts);
$ingreso_sol	=$dt['total'];
mysql_free_result($dts);

//SALIDA
$dts=$oEgreso->mostrar_suma($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_egr_numdoc'],$_POST['cmb_fil_pro_id'],$estado_egreso);
$dt = mysql_fetch_array($dts);
$egreso_sol	=$dt['total'];
mysql_free_result($dts);

$saldo_sol=$saldo_anterior_sol+$ingreso_sol-$egreso_sol;

require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
$dts1=$oVenta->mostrar_filtro_adm(fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),0,0,'',0,0,$_SESSION['empresa_id'],0);
$ventas = 0;
while($dt = mysql_fetch_array($dts1)){
    echo $dt['tb_venta_valven'];
    $ventas =$ventas + $dt['tb_venta_valven'];
}

require_once ("../compra/cCompra.php");
$oCompra = new cCompra();
$dts1=$oCompra->mostrar_filtro(fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),0,0,'',$_SESSION['empresa_id']);
$compras = 0;
while($dt = mysql_fetch_array($dts1)){
    $compras =$compras + $dt['tb_compra_valven'];
}

//Costo promedio

?>
<table border="0" cellspacing="0" cellpadding="0" style="width:30%;float:left">
  <tr>
    <th height="24" align="left">CAJA</th>
    <th height="24" align="right">SOLES S/.</th>
    <th height="24" align="right">&nbsp;</th>
  <tr>
    <td align="left">SALDO ANTERIOR</td>
    <td align="right"><?php echo formato_money($saldo_anterior_sol)?></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">INGRESOS</td>
    <td align="right"><?php echo formato_money($ingreso_sol)?></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">EGRESOS</td>
    <td align="right"><?php echo formato_money($egreso_sol)?></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr style="font-weight:bold" height="25">
    <td align="left">SALDO</td>
    <td align="right"><?php echo formato_money($saldo_sol)?></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" style="width:30%;float:left">
    <tr>
        <th height="24" align="left">GANANCIA</th>
        <th height="24" align="right">SOLES S/.</th>
    <tr>
    <tr>
        <td align="left">Ventas</td>
        <td align="right">S/.<?php echo $ventas?></td>
    </tr>
    <tr>
        <td align="left">Compras</td>
        <td align="right">S/.<?php echo $compras?></td>
    </tr>
    <tr style="font-weight:bold" height="25">
        <td align="left">Total</td><td align="right">S/.<?php echo $ventas - $compras?></td>
    </tr>
</table>