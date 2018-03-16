<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../cajaobs/cajaobs_cierre.php");
require_once("../formatos/formato.php");

$dts1=$oIngreso->mostrar_filtro($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($_POST['txt_fil_ing_fec1']),fecha_mysql($_POST['txt_fil_ing_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_doc_id'],$_POST['txt_fil_ing_numdoc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ing_est']);

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
		sortList: [[0,0],[1,0]]
		<?php }?>
    });
}); 
</script>
<table cellspacing="1" id="tabla_ingreso" class="tablesorter">
            <thead>
        <tr>
          <th nowrap title="Fecha">FECHA</th>
          <th>DOCUMENTO</th>
          <th>CLIENTE</th>
          <th>DETALLE</th>
          <th>CUENTA</th>
          <th nowrap>SUB CUENTA</th>
          <th align="right">IMPORTE</th>
          <th align="center">ESTADO</th>
          <th align="center">CAJA</th>
          <th align="right">ID</th>
          <th title="Editar">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
<?php
while($dt1 = mysql_fetch_array($dts1)){
	$sum_imp+=$dt1['tb_ingreso_imp'];

  $caja_estado=caja_cierre($dt1['tb_caja_id'],$dt1['tb_ingreso_fec']);
?>
        <tr>
          <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_ingreso_fec'])?></td>
          <td nowrap="nowrap">
            <?php $documento=$dt1['tb_documento_abr'].' '.$dt1['tb_ingreso_numdoc']?>
            <a style="color: blue;" title="Imprimir" href="#imprimir" onClick="ingreso_impresion('<?php echo $dt1['tb_ingreso_id']?>')"><?php echo $documento?></a>
          </td>
          <td><?php echo $dt1['tb_cliente_doc'].' '.$dt1['tb_cliente_nom']?></td>  
          <td><?php echo $dt1['tb_ingreso_det']?></td>
          <td><?php echo $dt1['tb_cuenta_des']?></td>
          <td><?php echo $dt1['tb_subcuenta_des']?></td>
          <td align="right"><?php echo formato_money($dt1['tb_ingreso_imp'])?></td>
          <td align="center">
            <?php 
              if($dt1['tb_ingreso_est']==1)echo 'CANCELADO';
              if($dt1['tb_ingreso_est']==2)echo 'EMITIDO';
            ?>
          </td>
          <td align="center" nowrap="nowrap"><?php echo $dt1['tb_caja_nom']?></td>
          <td align="right"><?php echo $dt1['tb_ingreso_id']?></td>
          <td align="center" nowrap="nowrap">
          <?php 
          if($dt1['tb_ingreso_modide']==0){
            if($caja_estado==1){?>
          <a class="btn_editar" href="#update" onClick="ingreso_form('editar','<?php echo $dt1['tb_ingreso_id']?>')">Editar</a> 
		        <?php //if($_SESSION['usuariogrupo_id']==3){?>
          <a class="btn_eliminar" href="#eliminar" onClick="ingreso_eliminar('<?php echo $dt1['tb_ingreso_id']?>')">Eliminar</a> 
          <?php  //}

            }//cierre caja
          }//trans y venta
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