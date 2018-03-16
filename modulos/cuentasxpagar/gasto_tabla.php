<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../gasto_r/cGasto.php");
$oGasto = new cGasto();
require_once("../formatos/formato.php");

$emp_id=1;

$dts1=$oGasto->mostrar_por_compra($_POST['com_id']);

$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(function() {	
	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	
	$('.btn_anular').button({
		icons: {primary: "ui-icon-cancel"},
		text: false
	});
	
	compra_obs();

	$("#tabla_gasto").tablesorter({
		widgets: ['zebra'],
		headers: {
			0: {sorter: 'shortDate' },
			11: { sorter: false}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0]]
		<?php }?>
    });
}); 
</script>
<table cellspacing="1" id="tabla_gasto" class="tablesorter">
            <thead>
        <tr>
          <th>FECHA</th>
          <th>DOCUMENTO</th>
          <th>DESCRIPCION</th>
          <?php /*?><th>PROVEEDOR</th><?php */?>
          <th>CUENTA</th>
          <th>SUB CUENTA</th>
          <th>BANCO</th>
          <th title="Modo de Pago">M PAGO</th>
          <th>N° OPE</th>
          <th align="right">IMPORTE S/.</th>
          <th align="right">ESTADO</th>
          <th align="right">CAJA</th>
          <th title="Editar">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
  <?php
while($dt1 = mysql_fetch_array($dts1)){
	if($dt1['tb_gasto_est']=='CANCELADO')
	{
		$sum_importe+=$dt1['tb_gasto_imp'];
	}
?>
          <tr>
            <td valign="top" nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_gasto_fec'])?></td>
            <td valign="top"><?php echo $dt1['tb_gasto_doc']?></td>
            <td valign="top"><?php echo $dt1['tb_gasto_des']?></td>
            <?php /*?><td valign="top"><?php echo $dt1['tb_proveedor_nom']?></td><?php */?>
            <td><?php echo $dt1['tb_cuenta_des']?></td>
            <td><?php echo $dt1['tb_subcuenta_des']?></td>
            <td valign="top"><?php echo $dt1['tb_entfinanciera_nom']?></td>
            <td valign="top"><?php echo $dt1['tb_gasto_modpag']?></td>
            <td valign="top"><?php echo $dt1['tb_gasto_numope']?></td>
            <td align="right" valign="top"><?php echo formato_money($dt1['tb_gasto_imp'])?></td>
            <td align="right" valign="top"><?php echo $dt1['tb_gasto_est']?></td>
            <td align="right" valign="top"><?php echo $dt1['tb_caja_nom']?></td>
            <td align="center" nowrap="nowrap">
              <a class="btn_editar" href="#update" onClick="gasto_form('editar','<?php echo $dt1['tb_gasto_id']?>')">Editar</a> 
              <?php //if($dt1['tb_gasto_est']!='ANULADA'){?>
              <a class="btn_eliminar" href="#eliminar" onClick="gasto_eliminar('<?php echo $dt1['tb_gasto_id']?>')">Eliminar</a> 
              <?php // }?>
            </td>
          </tr>
  <?php
}
mysql_free_result($dts1);
?>
        </tbody>
        <tr class="even">
          <td colspan="8"><strong>TOTAL</strong></td>
          <td align="right"><strong><?php echo formato_money($sum_importe)?></strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
<input type="hidden" name="gasto_total" id="gasto_total" value="<?php if($sum_importe>0 and $sum_importe!=""){ echo $sum_importe;} else{ echo 'n';}?>">
<br>
<?php
echo 'DETALLE: ';
$compra_total=(moneda_mysql($_POST['com_tot']))*1;
$gasto_total=(moneda_mysql(formato_money($sum_importe)))*1;
$res=$compra_total-$gasto_total;

if($compra_total>$gasto_total) { 
	echo '<span class="alerta_a">Por pagar '.formato_money($compra_total-$gasto_total).'</span>';
}
elseif($compra_total==$gasto_total){
   if($_POST['com_est']=='CANCELADA')echo '<span class="alerta_v">Factura de Compra Cancelada.</span>';
   if($_POST['com_est']=='ANULADA')echo '<span class="alerta_v">Factura de Compra Anulada.</span>';
}
elseif($compra_total<$gasto_total){
   echo '<span class="alerta_r">Monto Total registrado es mayor que monto de Factura, en '.formato_money($gasto_total-$compra_total).'</span>';
}
?>
<input type="hidden" name="gasto_res" id="gasto_res" value="<?php echo $res?>">