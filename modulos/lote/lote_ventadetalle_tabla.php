<?php
require_once ("../../config/Cado.php");
require_once ("cVentaDetalleLote.php");
$oVentaDetalleLote = new cVentaDetalleLote();

$dts=$oVentaDetalleLote->mostrar_filtro_venta_detalle($_POST['vendet_id']);
$num_rows= mysql_num_rows($dts);

?>
<script type="text/javascript">
$(function() {
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_lote").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });


}); 
</script>
        <table cellspacing="1" id="tabla_lote" class="tablesorter">
            <thead>
                <tr>
                    <th>LOTE</th>
                    <th>FECHA FABRICACION</th>
                    <th>FECHA VENCIMIENTO</th>
                    <th>STOCK ACTUAL</th>
                </tr>
            </thead>
        <?php
        if($num_rows>=1){
		?>  
            <tbody>
			<?php
           	while($dt = mysql_fetch_array($dts)){
            ?>
                <tr>
                    <td><?php echo $dt['tb_ventadetalle_lotenum']?></td>
                    <td><?php echo $dt['tb_fecha_fab']?></td>
                    <td><?php echo $dt['tb_fecha_ven']?></td>
                    <td><?php echo $dt['tb_ventadetalle_exisact']?></td>
                </tr>
			<?php
				}
				mysql_free_result($dts);
            ?>
            </tbody>
     	<?php
        }
		?>
                <tr class="even">
                  <td colspan="4"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>