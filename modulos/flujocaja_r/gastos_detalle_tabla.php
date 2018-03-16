<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("../formatos/fechas.php");

require_once ("../gasto/cGasto.php");
$oGasto = new cGasto();
require_once ("../cuentas/cCuenta.php");
$oCuenta = new cCuenta();
require_once ("../cuentas/cSubcuenta.php");
$oSubcuenta = new cSubcuenta();
require_once ("../entfinanciera/cEntfinanciera.php");
$oEntfinanciera = new cEntfinanciera();

$dts=$oCuenta->mostrarUno($_POST['cue']);
$dt = mysql_fetch_array($dts);
$cue_des=$dt['tb_cuenta_des'];
mysql_free_result($dts);

if($_POST['cue']==0)$cue_des='GASTOS';

$dts=$oSubcuenta->mostrarUno($_POST['subcue']);
$dt = mysql_fetch_array($dts);
$subcue_des=$dt['tb_subcuenta_des'];
mysql_free_result($dts);

if($_POST['entfin']!=0)
{
	$entfinanciera=$_POST['entfin'];
	
	$dts=$oEntfinanciera->mostrarUno($_POST['entfin']);
	$dt = mysql_fetch_array($dts);
	$entfin_des=$dt['tb_entfinanciera_des'];
	mysql_free_result($dts);
}
else
{
	$entfinanciera=0;
}

$dts1=$oGasto->mostrar_filtro($_POST['emp'],$_POST['a'],$_POST['m'],$_POST['cue'],$_POST['subcue'],'',$entfinanciera,$_POST['est']);
$num_reg=mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(document).ready(function() {
	$.tablesorter.defaults.widgets = ['zebra'];
	//$.tablesorter.defaults.sortList = [[0,0]];
	$("#tabla_sorter_gastos").tablesorter({ 
		headers: {
			0: {sorter: 'shortDate' },
			9: {sorter: 'numerico' },
			11: {sorter: false }, 12: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong><?php echo $cue_des?></strong></td>
    <td rowspan="2" align="right" valign="top"><strong><?php echo $_POST['a']?></strong><br><strong><?php echo nombre_mes($_POST['m'])?></strong></td>
  </tr>
  <tr>
    <td><strong><?php echo $subcue_des?></strong></td>
  </tr>
  <tr>
    <td><?php echo $entfin_des?></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
</table>
<br>
<div>
			<table cellspacing="1" id="tabla_sorter_gastos" class="tablesorter">
            <thead>
        <tr>
          <th>FECHA</th>
          <th>DOCUMENTO</th>
          <?php /*?><th>PROVEEDOR</th><?php */?>
          <th>DESCRIPCION</th>
          <th>CUENTA</th>
          <th>SUB CUENTA</th>
          <th>BANCO</th>
          <th>M PAGO</th>
          <th>N° OPE</th>
          <th>IMPORTE</th>
          <th>ESTADO</th>
          <th>CAJA</th>
          </tr>
        </thead>
        <tbody>
<?php
while($dt1 = mysql_fetch_array($dts1)){
	$sum_importe=$dt1['tb_gasto_imp']+$sum_importe;
?>
        <tr>
          <td valign="top" nowrap="nowrap"><?php echo date('d-m-Y', strtotime($dt1['tb_gasto_fec']))?></td>
          <td valign="top"><?php echo $dt1['tb_gasto_doc']?></td>
          <?php /*?><td valign="top"><?php echo $dt1['tb_proveedor_nom']?></td><?php */?>
          <td valign="top"><?php echo $dt1['tb_gasto_des']?></td>
          <td><?php echo $dt1['tb_cuenta_des']?></td>
          <td><?php echo $dt1['tb_subcuenta_des']?></td>
          <td valign="top"><?php echo $dt1['tb_entfinanciera_nom']?></td>
          <td valign="top"><?php echo $dt1['tb_gasto_modpag']?></td>
          <td valign="top"><?php echo $dt1['tb_gasto_numope']?></td>
          <td align="right" valign="top"><?php echo formato_money($dt1['tb_gasto_imp'])?></td>
          <td align="right" valign="top"><?php echo $dt1['tb_gasto_est']?></td>
          <td align="right" valign="top"><?php echo $dt1['tb_caja_nom']?></td>
          </tr>
<?php
}
mysql_free_result($dts1);
?>
		</tbody>
        <tr class="even">
          <td colspan="12"><?php echo $num_reg." registros";?></td>
        </tr>
        <tr class="even">
          <td colspan="8"><strong>TOTAL</strong></td>
          <td align="right"><strong><?php echo formato_money($sum_importe)?></strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
      </table>
			</div>