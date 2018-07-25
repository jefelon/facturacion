<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTransferencia.php");
$oTransferencia = new cTransferencia();
require_once ("../cajaobs/cajaobs_cierre.php");
require_once("../formatos/formato.php");

$dts1=$oTransferencia->mostrar_filtro($_SESSION['empresa_id'],fecha_mysql($_POST['txt_fil_tra_fec1']),fecha_mysql($_POST['txt_fil_tra_fec2']),$_POST['cmb_fil_caj_id_ori'],$_POST['cmb_fil_caj_id_des']);

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
		sortList: [[0,0],[1,0]]
		<?php }?>
    });
}); 
</script>
<table cellspacing="1" id="tabla_transferencia" class="tablesorter">
            <thead>
        <tr>
          <th nowrap title="Fecha Contable">FECHA</th>
          <th>ID</th>
          <th>DETALLE</th>
          <th>CAJA ORIGEN</th>
          <th>CAJA DESTINO</th>
          <th align="right">IMPORTE</th>
          <th align="center">ESTADO</th>
          <th title="Editar">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
<?php
while($dt1 = mysql_fetch_array($dts1)){
	$sum_imp+=$dt1['tb_transferencia_imp'];
  $caja_estado=caja_cierre($dt1['tb_caja_id_ori'],$dt1['tb_transferencia_fec']);
?>
        <tr>
          <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_transferencia_fec'])?></td>
          <td><?php echo $dt1['tb_transferencia_id']?></td>
          <td><?php echo $dt1['tb_transferencia_det']?></td>
          <td><?php echo $dt1['caja_ori']?></td>
          <td><?php echo $dt1['caja_des']?></td>
          <td align="right"><?php echo formato_money($dt1['tb_transferencia_imp'])?></td>
          <td align="center"><?php 
            if($dt1['tb_transferencia_est']==1)echo 'CANCELADO';
            if($dt1['tb_transferencia_est']==2)echo 'EMITIDO';
          ?></td>
          <td align="center" nowrap="nowrap">
          <?php if($caja_estado==1){?>
          <a class="btn_editar" href="#update" onClick="transferencia_form('editar','<?php echo $dt1['tb_transferencia_id']?>')">Editar</a>
		  <?php if($dt1['tb_transferencia_est']!='ANULADA'){?>
      <?php ?>
          <a class="btn_eliminar" href="#eliminar" onClick="transferencia_eliminar('<?php echo $dt1['tb_transferencia_id']?>')">Eliminar</a>
          <?php 
           }

          }//cierre de caja
           ?>
          </td>
          </tr>
<?php
}
mysql_free_result($dts1);
?>
		</tbody>
        <tr class="even">
          <td colspan="8"><?php echo $num_rows." registros";?></td>
        </tr>
        <tr class="even">
          <td colspan="5"><strong>TOTAL</strong></td>
          <td align="right"><strong><?php echo formato_money($sum_imp)?></strong></td>
          <td colspan="2">&nbsp;</td>
        </tr>
      </table>