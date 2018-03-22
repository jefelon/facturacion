<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../egreso/cEgreso.php");
$oEgreso = new cEgreso();
require_once ("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../catalogo/cst_producto.php");
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

//Ganancias
$dts1=$oVenta->mostrar_filtro_adm(fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),0,0,'',0,0,$_SESSION['empresa_id'],0);
$ventas = 0;
$compras = 0;
while($dt1 = mysql_fetch_array($dts1)){
    $ventas =$ventas + $dt1['tb_venta_valven'];
    $dts2=$oVenta->mostrar_venta_detalle($dt1['tb_venta_id']);
    while($dt2 = mysql_fetch_array($dts2)) {
        $cantidad = $dt2['tb_ventadetalle_can'];
        $dts3=$oPresentacion->mostrar_por_producto($dt2['tb_producto_id']);
        while($dt3 = mysql_fetch_array($dts3)){
            $dts4=$oCatalogoproducto->mostrar_unidad_de_presentacion($dt3['tb_presentacion_id']);
            $array_dt4 = array();
            while($dt4 = mysql_fetch_array($dts4)) {
                $array_dt4[] = $dt4;
            }
            // Costo Ponderado
            $costo_ponderado="";
            $stock_kardex=stock_kardex($array_dt4[0]['cat_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
            $costo_ponderado_array=costo_ponderado_empresa($array_dt4[0]['cat_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$array_dt4[0]['precos'],$precosdol,$_SESSION['empresa_id']);
            $costo_ponderado=$costo_ponderado_array['soles'];
            $compras = $compras + $costo_ponderado;
        }
    }
}
$compras = $compras-$compras*0.18;

//End Ganancias

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

<table border="0" cellspacing="0" cellpadding="0" style="width:30%;float:right">
    <tr>
        <th height="24" align="left">GANANCIA</th>
        <th height="24" align="right">SOLES S/.</th>
    <tr>
    <tr>
        <td align="left">Ventas</td>
        <td align="right">S/.<?php echo formato_money($ventas)?></td>
    </tr>
    <tr>
        <td align="left">Compras</td>
        <td align="right">S/.<?php echo formato_money($compras)?></td>
    </tr>
    <tr style="font-weight:bold" height="25">
        <td align="left">Total</td><td align="right">S/.<?php echo formato_money($ventas - $compras)?></td>
    </tr>
</table>