<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTransferencia.php");
$oTransferencia = new cTransferencia();
require_once("../formatos/formato.php");

$emp_id=1;

$dts1=$oTransferencia->mostrar_filtro_fec($emp_id,fecha_mysql($_POST['txt_fil_tra_fec1']),fecha_mysql($_POST['txt_fil_tra_fec2']), $_POST['txt_fil_tra_cod'],$_POST['cmb_fil_caj_id_ori'],$_POST['cmb_fil_caj_id_des'],$_POST['cmb_fil_mon_id']);

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

	$("#tabla_transferencia").tablesorter({
		widgets: ['zebra'],
		headers: {
			0: {sorter: 'shortDate' },
			12: { sorter: false}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0]]
		<?php }?>
    });
}); 
</script>
<table cellspacing="1" id="tabla_transferencia" class="tablesorter">
            <thead>
        <tr>
          <th nowrap title="Fecha Contable">FECHA</th>
          <th>CODIGO</th>
          <th>DESCRIPCION</th>
          <th>CAJA ORIGEN</th>
          <th>CAJA DESTINO</th>
          <th align="right" title="MONEDA">MON</th>
          <th align="right">MONTO</th>
          <th align="center">ESTADO</th>
          <th title="Editar">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
<?php
while($dt1 = mysql_fetch_array($dts1)){
	$sum_mon+=$dt1['tb_transferencia_mon'];
?>
        <tr>
          <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_transferencia_fec'])?></td>
          <td><?php echo $dt1['tb_transferencia_cod']?></td>
          <td><?php echo $dt1['tb_transferencia_des']?></td>
          <td><?php echo $dt1['caja_ori']?></td>
          <td><?php echo $dt1['caja_des']?></td>
          <td align="right"><?php if($dt1['tb_moneda_id']==1)echo "S/."; if($dt1['tb_moneda_id']==2)echo "US$";?></td>
          <td align="right"><?php echo formato_money($dt1['tb_transferencia_mon'])?></td>
          <td align="center"><?php echo $dt1['tb_transferencia_est']?></td>
          <td align="center" nowrap="nowrap">
          <a class="btn_editar" href="#update" onClick="transferencia_form('editar','<?php echo $dt1['tb_transferencia_id']?>')">Editar</a>
		  <?php /*if($dt1['tb_transferencia_est']!='ANULADA'){?>
          <a class="btn_eliminar" href="#eliminar" onClick="transferencia_eliminar('<?php echo $dt1['tb_transferencia_id']?>')">Eliminar</a> 
          <?php  }*/?>
          </td>
          </tr>
<?php
}
mysql_free_result($dts1);
?>
		</tbody>
        <tr class="even">
          <td colspan="9"><?php echo $num_rows." registros";?></td>
        </tr>
        <tr class="even">
          <td colspan="6"><strong>TOTAL</strong></td>
          <td align="right"><strong><?php echo formato_money($sum_mon)?></strong></td>
          <td colspan="2">&nbsp;</td>
        </tr>
      </table>