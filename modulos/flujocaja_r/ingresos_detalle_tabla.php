<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("../formatos/fechas.php");

require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
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

if($_POST['cue']==0)$cue_des='INGRESOS';

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

$cliente=0;

$dts1=$oIngreso->mostrar_filtro($_POST['emp'],$_POST['a'],$_POST['m'],$_POST['cue'],$_POST['subcue'],$doc,$cliente,$entfinanciera,$_POST['est'],'','');

$num_rows=mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(document).ready(function() {
	$("#tabla_ingreso").tablesorter({
		 widgets:['zebra'],
		 headers: {
			0: {sorter: 'shortDate' },
			1: {sorter: 'shortDate' },
			15: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong><?php echo $cue_des?></strong></td>
    <td rowspan="3" align="right" valign="top"><strong><?php echo $_POST['a']?></strong><br><strong><?php echo nombre_mes($_POST['m'])?></strong></td>
  </tr>
  <tr>
    <td><strong><?php echo $subcue_des?></strong></td>
  </tr>
  <tr>
    <td><?php echo $entfin_des?></td>
  </tr>
</table>
<br>
<div>
<table cellspacing="1" id="tabla_ingreso" class="tablesorter">
            <thead>
        <tr>
          <th nowrap title="Fecha Contable">FECHA</th>
          <?php /*?><th nowrap title="Fecha de Emisión">F EMISION</th><?php */?>
          <th>DESCRIPCION</th>
          <?php /*?><th>CLIENTE</th><?php */?>
          <th>CUENTA</th>
          <th nowrap>SUB CUENTA</th>
          <th title="Referencia">REF</th>
          <th nowrap title="Entidad Financiera">E FINANC</th>
          <th nowrap title="Número de Operación">N° OPER</th>
          <th align="right">MONTO</th>
          <th align="center">ESTADO</th>
          <th align="center">CAJA</th>
          </tr>
        </thead>
        <tbody>
<?php
while($dt1 = mysql_fetch_array($dts1)){
	$sum_mon+=$dt1['tb_ingreso_mon'];
?>
        <tr>
          <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_ingreso_feccon'])?></td>
          <?php /*?><td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_ingreso_fecemi'])?></td><?php */?>
          <td><?php echo $dt1['tb_ingreso_des']?></td>
          <?php /*?><td><?php echo $dt1['tb_cliente_nom']?></td><?php */?>
          <td><?php echo $dt1['tb_cuenta_des']?></td>
          <td><?php echo $dt1['tb_subcuenta_des']?></td>
          <td><?php echo $dt1['tb_referencia_nom']?></td>
          <td><?php echo $dt1['tb_entfinanciera_nom']?></td>
          <td><?php echo $dt1['tb_ingreso_numope']?></td>
          <td align="right"><?php echo formato_money($dt1['tb_ingreso_mon'])?></td>
          <td align="center"><?php echo $dt1['tb_ingreso_est']?></td>
          <td align="center"><?php echo $dt1['tb_caja_nom']?></td>
          </tr>
<?php
}
mysql_free_result($dts1);
?>
		</tbody>
        <tr class="even">
          <td colspan="10"><?php echo $num_rows." registros";?></td>
        </tr>
        <tr class="even">
          <td colspan="7"><strong>TOTAL</strong></td>
          <td align="right"><strong><?php echo formato_money($sum_mon)?></strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
</div>