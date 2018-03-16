<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cIngreso.php");
$oIngreso = new cIngreso();
require_once("../formatos/formato.php");

$emp_id=1;

$dts1=$oIngreso->mostrar_filtro_fec($emp_id,fecha_mysql($_POST['txt_fil_ing_fec1']),fecha_mysql($_POST['txt_fil_ing_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_ing_doc'],$_POST['cmb_fil_cli_id'],$_POST['cmb_fil_entfin_id'],$_POST['cmb_fil_ing_est'],$_POST['cmb_fil_caj_id'],$_POST['cmb_fil_mon_id'],$_POST['cmb_fil_ref_id']);

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

	$("#tabla_ingreso").tablesorter({
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
<table cellspacing="1" id="tabla_ingreso" class="tablesorter">
            <thead>
        <tr>
          <th nowrap title="Fecha Contable">FECHA</th>
          <?php /*?><th nowrap title="Fecha de Emisión">F EMISION</th><?php */?>
          <th>DOCUMENTO</th>
          <th>DESCRIPCION</th>
          <?php /*?><th>CLIENTE</th><?php */?>
          <th>CUENTA</th>
          <th nowrap>SUB CUENTA</th>
          <th>REFERENCIA</th>
          <th nowrap title="Entidad Financiera">E FINANC</th>
          <th nowrap title="Número de Operación">N° OPER</th>
          <th align="right" title="MONEDA">MON</th>
          <th align="right">MONTO</th>
          <th align="center">ESTADO</th>
          <th align="center">CAJA</th>
          <th title="Editar">&nbsp;</th>
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
          <td><?php echo $dt1['tb_ingreso_doc']?></td>
          <td><?php echo $dt1['tb_ingreso_des']?></td>
          <?php /*?><td><?php echo $dt1['tb_cliente_nom']?></td><?php */?>
          <td><?php echo $dt1['tb_cuenta_des']?></td>
          <td><?php echo $dt1['tb_subcuenta_des']?></td>
          <td><?php echo $dt1['tb_referencia_nom']?></td>
          <td><?php echo $dt1['tb_entfinanciera_nom']?></td>
          <td><?php echo $dt1['tb_ingreso_numope']?></td>
          <td align="right"><?php if($dt1['tb_moneda_id']==1)echo "S/."; if($dt1['tb_moneda_id']==2)echo "US$";?></td>
          <td align="right"><?php echo formato_money($dt1['tb_ingreso_mon'])?></td>
          <td align="center"><?php echo $dt1['tb_ingreso_est']?></td>
          <td align="center"><?php echo $dt1['tb_caja_nom']?></td>
          <td align="center" nowrap="nowrap">
          <a class="btn_editar" href="#update" onClick="ingreso_form('editar','<?php echo $dt1['tb_ingreso_id']?>')">Editar</a> 
		  <?php //if($dt1['tb_ingreso_est']!='ANULADA'){?>
          <a class="btn_eliminar" href="#eliminar" onClick="ingreso_eliminar('<?php echo $dt1['tb_ingreso_id']?>')">Eliminar</a> 
          <?php // }?>
          </td>
          </tr>
<?php
}
mysql_free_result($dts1);
?>
		</tbody>
        <tr class="even">
          <td colspan="13"><?php echo $num_rows." registros";?></td>
        </tr>
        <tr class="even">
          <td colspan="9"><strong>TOTAL</strong></td>
          <td align="right"><strong><?php echo formato_money($sum_mon)?></strong></td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table>