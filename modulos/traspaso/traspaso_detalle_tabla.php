<?php
require_once ("../../config/Cado.php");
require_once ("cTraspaso.php");
$oTraspaso = new cTraspaso();

require_once ("../formatos/formato.php");

	$dts= $oTraspaso->mostrarUno($_POST['tra_id']);
	$dt = mysql_fetch_array($dts);
		$fec		=mostrarFecha($dt['tb_traspaso_fec']);
		$alm_id_ori	=$dt['tb_almacen_id_ori'];
		$alm_id_des	=$dt['tb_almacen_id_des'];
	mysql_free_result($dts);

$dts1=$oTraspaso->mostrar_traspaso_detalle($_POST['tra_id']);
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
	$("#tabla_traspaso_detalle").tablesorter({ 
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
        <table cellspacing="1" id="tabla_traspaso_detalle" class="tablesorter">
            <thead>
                <tr>
                  <th align="right">CANT</th>
                  <th>UND</th>
                  <th>CODIGO</th>
                  <th>NOMBRE / PRESENTACION</th>
                  <th>MARCA</th>
                  <th> CATEGORIA</th>
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
							echo $dt1['tb_traspasodetalle_can'];
							?></td>
                          <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                          <td><?php echo $dt1['tb_presentacion_cod']?></td>
                          <td>
							<?php 
							echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
							echo ' / '.$dt1['tb_presentacion_nom'];
							?></td>
                          <td><?php 
							echo $dt1['tb_marca_nom'];
							?></td>
                          <td><?php 
							echo $dt1['tb_categoria_nom'];
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