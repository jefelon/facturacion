<?php
require_once ("../../config/Cado.php");
require_once ("cEncarte.php");
$oEncarte = new cEncarte();

require_once ("../formatos/formato.php");

	$dts= $oEncarte->mostrarUno($_POST['enc_id']);
	$dt = mysql_fetch_array($dts);
		$fecini	=mostrarFecha($dt['tb_encarte_fecini']);
		$fecfin	=mostrarFecha($dt['tb_encarte_fecfin']);

		$des	=$dt['tb_encarte_des'];
		$despor	=$dt['tb_encarte_despor'];

		$est	=$dt['tb_encarte_est'];
	mysql_free_result($dts);

$dts1=$oEncarte->mostrar_encarte_detalle($_POST['enc_id']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">
$(function() {
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_encarte_detalle").tablesorter({ 
		headers: {
			//4: {sorter: 'shortDate' },
			//8: { sorter: false}
			},
		//sortForce: [[0,0]],
		//sortList: [[2,0]]
    });

}); 
</script>
        <table cellspacing="1" id="tabla_encarte_detalle" class="tablesorter">
            <thead>
                <tr>
                  <th>PRODUCTO</th>
                  <th title="UNIDAD">UNID</th>
                  <th align="right" title="COSTO PROMEDIO SOLES">COSTO PROM</th>
                  <th align="right" title="PRECIO UNITARIO">UTI %</th>
                  <th align="right" nowrap title="PRECIO DE VENTA"> P.  VENTA S/.</th>
                  <th align="right" nowrap="nowrap" title="DESCUENTO %">DSCTO %</th>
                  <th align="right" nowrap="nowrap" title="DESCUENTO %">UTI%</th>
                  <th align="right" nowrap title="PRECIO MINIMO"> P.  VENTA. S/.</th>
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
                          <td><?php echo $dt1['tb_producto_nom'];?></td>
                          <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                          <td align="right"><?php echo formato_money($dt1['tb_encartedetalle_cos']);?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_encartedetalle_uti1']);?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_encartedetalle_preven1']);?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_encartedetalle_despor']);?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_encartedetalle_uti2']);?></td>
                            <td align="right"><strong><?php echo formato_money($dt1['tb_encartedetalle_preven2']);?></strong></td>
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
        
        <?php 
	if($num_rows=="" or $num_rows==0)echo $num_rows.' Ningún registro.';
	if($num_rows==1)echo $num_rows.' registro.';
	if($num_rows>=2)echo $num_rows.' registros.';
?>