<?php
require_once ("../../config/Cado.php");
require_once ("cNotalmacen.php");
$oNotalmacen = new cNotalmacen();

require_once ("../formatos/formato.php");

	$dts= $oNotalmacen->mostrarUno($_POST['notalm_id']);
	$dt = mysql_fetch_array($dts);
		$fec		=mostrarFecha($dt['tb_notalmacen_fec']);
		$cod	=str_pad($dt['tb_notalmacen_cod'],4, "0", STR_PAD_LEFT);
		$tip	=$dt['tb_notalmacen_tip'];
		$obs	=$dt['tb_notalmacen_obs'];
		$alm_id	=$dt['tb_almacen_id'];
	mysql_free_result($dts);

$almacen=3;

$dts1=$oNotalmacen->mostrar_notalmacen_detalle2($_POST['notalm_id'],$almacen);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn_agregar').button({
		icons: {primary: "ui-icon-plus"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_notalmacen_detalle").tablesorter({ 
		headers: {
			//4: {sorter: 'shortDate' },
			//8: { sorter: false}
			},
		//sortForce: [[0,0]],
		//sortList: [[2,0]]
    });

}); 
</script>
<?php 
	if($num_rows=="" or $num_rows==0)echo $num_rows.' Ningún registro.';
	if($num_rows==1)echo $num_rows.' registro.';
	if($num_rows>=2)echo $num_rows.' registros.';
?>
        <table cellspacing="1" id="tabla_notalmacen_detalle" class="tablesorter">
            <thead>
                <tr>
                  <th align="right">CANT</th>
                  <th>UND</th>
                  <th>CAT_ID</th>
                  <th>NOMBRE</th>
                  <th title="PRECIO COSTO">P. COSTO S/.</th>
                  <th title="PRECIO VENTA">P. VENTA S/.</th>
                  <th title="PRECIO VENTA">CAT_NAD</th>
                  <th title="PRECIO VENTA">COS</th>
                  <th title="PRECIO VENTA">PRE</th>
                  <th title="PRECIO VENTA">RES</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
				?>
                        <tr>
                          <td align="right"><?php 
							echo $dt1['tb_notalmacendetalle_can'];
							?></td>
                          <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                          <td><?php echo $dt1['tb_catalogo_id']?></td>
                            <td>
							<?php 
							echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
							//echo ' / '.$dt1['tb_presentacion_nom'];
							?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_notalmacendetalle_cos'])?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_notalmacendetalle_pre'])?></td>
                            <td><?php echo $dt1['tb_notalmacendetalle_id']?></td>
                            <?php 
							$costo=0;
							$precio=0;
							$rws= $oNotalmacen->mostrar_catalogo($dt1['tb_catalogo_id']);
							$rw = mysql_fetch_array($rws);
								$costo	=$rw['tb_catalogo_precos'];
								$precio	=$rw['tb_catalogo_preven'];
							mysql_free_result($rws);
							?>
                            <td align="right"><?php echo $costo?></td>
                            <td align="right"><?php echo $precio?></td>
                            <td align="right"><?php 
							//$consulta=$oNotalmacen->modificar_detalle_na($dt1['tb_notalmacendetalle_id'],$costo,$precio);
							/*if($consulta)
							{
								echo "OK";
							}
							else
							{
								echo "N";	
							}*/
							?></td>
                        </tr>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <?php
				}
				?>
        </table>