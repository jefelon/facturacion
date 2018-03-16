<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTalonariointerno.php");
$oTalonariointerno = new cTalonariointerno();

$dts=$oTalonariointerno->mostrar_filtro($_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts);

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

	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_talonario").tablesorter({ 
		headers: {
			8: { sorter: false}
		},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0]]
		<?php }?>
    });
}); 
</script>
        <table cellspacing="1" id="tabla_talonario" class="tablesorter">
            <thead>
                <tr>
                  <th>DOCUMENTO</th>
                  <th>PUNTO VENTA</th>
                  <th>ALMACEN</th>
                  <th>SERIE</th>
                  <th>INICIO-FIN</th>
                  <th>NUMERO</th>
                <th>ESTADO</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
       		<?php	
			//$dts=$oTalonariointerno->mostrar_por_tipo($dt1['tb_talonario_tip']);
           	while($dt = mysql_fetch_array($dts)){
            ?>
                <tr>
                  <td><?php 
				  if($dt['tb_documento_id']==1)echo 'NOTA DE VENTA'; 
				  if($dt['tb_documento_id']==2)echo 'TRANSFERENCIA';
				  if($dt['tb_documento_id']==3)echo 'NOTA DE ALMACEN'; 
				  ?></td>
                  <td><?php echo $dt['tb_puntoventa_nom']?></td>
                  <td><?php echo $dt['tb_almacen_nom']?></td>
                  <td><?php echo $dt['tb_talonario_ser']?></td>
                  <td><?php echo $dt['tb_talonario_ini'].' - '.$dt['tb_talonario_fin']?></td>
                  <td><?php echo $dt['tb_talonario_num']?></td>
                <td><?php echo $dt['tb_talonario_est']?></td>
                <td align="left">
                <?php //if($dt['tb_talonario_est']=='ACTIVO' or $dt['tb_talonario_est']=='ESPERA'){?>
                <a class="btn_editar" href="#" onClick="talonario_form('editar','<?php echo $dt['tb_talonario_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_talonario('<?php echo $dt['tb_talonario_id']?>')">Eliminar</a></td>
                <?php //}?>
              </tr>
			<?php
				}
				mysql_free_result($dts);
			?>
            </tbody>
                <tr class="even">
                  <td colspan="8">&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>