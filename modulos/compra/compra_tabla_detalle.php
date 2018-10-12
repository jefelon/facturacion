<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
$oCompra = new cCompra();
require_once ("../formatos/formato.php");
require_once ("../formatos/operaciones.php");

$dts1=$oCompra->mostrar_filtro_detalle(fecha_mysql($_POST['com_fec1']),fecha_mysql($_POST['com_fec2']),$_POST['com_mon'],$_POST['pro_id'],$_POST['com_est'],$_SESSION['empresa_id']);
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

	$.tablesorter.defaults.widgets = ['zebra'];
	//$.tablesorter.defaults.sortList = [[0,0]];
	$("#tabla_compra").tablesorter({ 
		headers: {
			0: {sorter: 'shortDate' },
			10: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_compra" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th>DOC</th>
                  <th>NUM DOC</th>
                  <th>PRODUCTO</th>
                  <th>PRESENTACION</th>
                  <th>MARCA</th>
                  <th>CATEGORIA</th>
                  <th>UNI</th>
                  <th>CAN</th>
                  <th nowrap="nowrap">PREC UNIT</th>
                  <th align="right">SUB TOT</th>
                  <th align="right">ESTADO</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
					
					if($dt1['tb_compra_est']=='CONTADO' or $dt1['tb_compra_est']=='CREDITO'){
					//$total_subtot+=$dt1['tb_compra_subtot'];
					//$total_igv+=$dt1['tb_compra_igv'];
					$total_compras+=$dt1['tb_compradetalle_imp'];
					}
				?>
                    <tr>
                      <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_compra_fec'])?></td>
                      <td title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr']?></td>
                      <td><?php echo $dt1['tb_compra_numdoc']?></td>
                      <td><?php echo $dt1['tb_producto_nom']?></td>
                      <td><?php echo $dt1['tb_presentacion_nom']?></td>
                      <td><?php echo $dt1['tb_marca_nom']?></td>
                      <td><?php echo $dt1['tb_categoria_nom']?></td>
                      <td><?php echo $dt1['tb_unidad_abr']?></td>
                      <td align="right"><?php echo $dt1['tb_compradetalle_can']?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compradetalle_preuni'])?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compradetalle_imp'])?></td>
                      <td align="right"><?php echo $dt1['tb_compra_est']?></td>
                      <td align="left">
                      <a class="btn_editar" href="#update" onClick="compra_form('editar','<?php echo $dt1['tb_compra_id']?>')">Editar</a> 
					  <?php if($dt1['tb_compra_est']!='ANULADA'){?>
                      <!--<a class="btn_anular" href="#anular" onClick="compra_anular('<?php //echo $dt1['tb_compra_id']?>')">Anular</a> -->
                      <?php }?>
                      <!--<a class="btn_eliminar" href="#delate" onClick="eliminar_compra('<?php //echo $dt1['tb_compra_id']?>')">Eliminarr</a>-->
                      </td>
                    </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
			}
			//ocultar cuando no se selecciona moneda
			if($_POST['com_mon']>0){
		    ?>
                <tr class="even">
                  <td colspan="10">TOTAL</td>
                  <td align="right"><strong><?php echo formato_money($total_compras)?></strong></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
           <?php }?>
                <tr class="even">
                  <td colspan="13"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>