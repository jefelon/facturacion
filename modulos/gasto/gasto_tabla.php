<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cGasto.php");
$oGasto = new cGasto();
require_once("../formatos/formato.php");

$emp_id=1;

$dts1=$oGasto->mostrar_filtro_fec($emp_id,fecha_mysql($_POST['txt_fil_gas_fec1']),fecha_mysql($_POST['txt_fil_gas_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_pro_id'],$_POST['cmb_fil_entfin_id'],$_POST['cmb_fil_gas_est'],$_POST['cmb_fil_caj_id'],$_POST['cmb_fil_mon_id'],$_POST['cmb_fil_ref_id']);

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
          <th>REFERENCIA</th>
          <th>BANCO</th>
          <th title="Modo de Pago">M PAGO</th>
          <th>N° OPE</th>
          <th align="right" title="MONEDA">MON</th>
          <th align="right">IMPORTE</th>
          <th align="right">ESTADO</th>
          <th align="right">CAJA</th>
          <th title="Editar">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
<?php
while($dt1 = mysql_fetch_array($dts1)){
	$sum_importe+=$dt1['tb_gasto_imp'];
?>
        <tr>
          <td valign="top" nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_gasto_fec'])?></td>
          <td valign="top"><?php echo $dt1['tb_gasto_doc']?></td>
          <td valign="top"><?php echo $dt1['tb_gasto_des']?></td>
          <?php /*?><td valign="top"><?php echo $dt1['tb_proveedor_nom']?></td><?php */?>
          <td><?php echo $dt1['tb_cuenta_des']?></td>
          <td><?php echo $dt1['tb_subcuenta_des']?></td>
          <td><?php echo $dt1['tb_referencia_nom']?></td>
          <td valign="top"><?php echo $dt1['tb_entfinanciera_nom']?></td>
          <td valign="top"><?php echo $dt1['tb_gasto_modpag']?></td>
          <td valign="top"><?php echo $dt1['tb_gasto_numope']?></td>
          <td align="right" valign="top"><?php if($dt1['tb_moneda_id']==1)echo "S/."; if($dt1['tb_moneda_id']==2)echo "US$";?></td>
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
          <td colspan="14"><?php echo $num_rows." registros";?></td>
        </tr>
        <tr class="even">
          <td colspan="10"><strong>TOTAL</strong></td>
          <td align="right"><strong><?php echo formato_money($sum_importe)?></strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>