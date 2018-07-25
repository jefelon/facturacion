<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCajaobs.php");
$oCajaobs = new cCajaobs();
require_once("../formatos/formato.php");

$dts1=$oCajaobs->verificar_cierre_caja($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($_POST['txt_fil_cajobs_fec']));

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

	$("#tabla_cajaobs").tablesorter({
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
<table cellspacing="1" id="tabla_cajaobs" class="tablesorter">
            <thead>
        <tr>
          <th nowrap title="Fecha">FECHA</th>
          <th>CAJA</th>
          <th>OBSERVACION</th>
          <th align="center">ESTADO</th>
          <th align="right">ID</th>
          <th title="Editar">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
<?php
while($dt1 = mysql_fetch_array($dts1)){

?>
        <tr>
          <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_cajaobs_fec'])?></td>
          <td nowrap="nowrap"><?php echo $dt1['tb_caja_nom']?></td>
          <td><?php echo $dt1['tb_cajaobs_det']?></td>
          <td align="center">
            <?php 
              if($dt1['tb_cajaobs_est']==1)echo 'ABIERTA';
              if($dt1['tb_cajaobs_est']==2)echo 'CERRADA';
            ?>
          </td>
          <td align="right"><?php echo $dt1['tb_cajaobs_id']?></td>
          <td align="center" nowrap="nowrap">
          <a class="btn_editar" href="#update" onClick="cajaobs_form('editar','<?php echo $dt1['tb_cajaobs_id']?>')">Editar</a> 
		        <?php //if($_SESSION['usuarioprupo_id']==3){?>
          <a class="btn_eliminar" href="#eliminar" onClick="cajaobs_eliminar('<?php echo $dt1['tb_cajaobs_id']?>')">Eliminar</a> 
          <?php  //}?>
          </td>
          </tr>
<?php
}
mysql_free_result($dts1);
?>
		</tbody>
        <tr class="even">
          <td colspan="6"><?php echo $num_rows." registros";?></td>
        </tr>
      </table>