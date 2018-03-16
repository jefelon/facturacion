<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cEgreso.php");
$oEgreso = new cEgreso();
require_once ("../cajaobs/cajaobs_cierre.php");
require_once("../formatos/formato.php");

$dts1=$oEgreso->mostrar_filtro($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($_POST['txt_fil_egr_fec1']),fecha_mysql($_POST['txt_fil_egr_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_doc_id'],$_POST['txt_fil_egr_numdoc'],$_POST['hdd_fil_pro_id'],$_POST['cmb_fil_egr_est']);

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

	$("#tabla_egreso").tablesorter({
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
<table cellspacing="1" id="tabla_egreso" class="tablesorter">
            <thead>
        <tr>
          <th nowrap title="Fecha">FECHA</th>
          <th>ID</th>
          <th>DOCUMENTO</th>
          <th>ANEXO</th>
          <th>DETALLE</th>
          <th>CUENTA</th>
          <th nowrap>SUB CUENTA</th>
          <th align="right">IMPORTE</th>
          <th align="center">ESTADO</th>
          <th align="center">CAJA</th>
          <th title="Editar">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
<?php
while($dt1 = mysql_fetch_array($dts1)){
	$sum_imp+=$dt1['tb_egreso_imp'];
  $caja_estado=caja_cierre($dt1['tb_caja_id'],$dt1['tb_egreso_fec']);
?>
        <tr>
          <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_egreso_fec'])?></td>
          <td><?php echo $dt1['tb_egreso_id']?></td>
          <td nowrap="nowrap">
            <?php $documento=$dt1['tb_documento_abr'].' '.$dt1['tb_egreso_numdoc']?>
            <a style="color: blue;" title="Imprimir" href="#imprimir" onClick="egreso_impresion('<?php echo $dt1['tb_egreso_id']?>')"><?php echo $documento?></a>
          </td>
          <td><?php echo $dt1['tb_proveedor_doc'].' '.$dt1['tb_proveedor_nom']?></td>  
          <td><?php echo $dt1['tb_egreso_det']?></td>
          <td><?php echo $dt1['tb_cuenta_des']?></td>
          <td><?php echo $dt1['tb_subcuenta_des']?></td>
          <td align="right"><?php echo formato_money($dt1['tb_egreso_imp'])?></td>
          <td align="center"><?php 
            if($dt1['tb_egreso_est']==1)echo 'CANCELADO';
            if($dt1['tb_egreso_est']==2)echo 'EMITIDO';
          ?></td>
          <td align="center" nowrap><?php echo $dt1['tb_caja_nom']?></td>
          <td align="center" nowrap="nowrap">
          <?php 
          if($dt1['tb_egreso_modide']==0){
            if($caja_estado==1){?>
          <a class="btn_editar" href="#update" onClick="egreso_form('editar','<?php echo $dt1['tb_egreso_id']?>')">Editar</a> 
		        <?php //if($_SESSION['usuariogrupo_id']==3){?>
          <a class="btn_eliminar" href="#eliminar" onClick="egreso_eliminar('<?php echo $dt1['tb_egreso_id']?>')">Eliminar</a> 
          <?php //}

            }//cierre caja
          }//transferencia
          ?>
          </td>
          </tr>
<?php
}
mysql_free_result($dts1);
?>
		</tbody>
        <tr class="even">
          <td colspan="11"><?php echo $num_rows." registros";?></td>
        </tr>
        <tr class="even">
          <td colspan="7"><strong>TOTAL</strong></td>
          <td align="right"><strong><?php echo formato_money($sum_imp)?></strong></td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table>