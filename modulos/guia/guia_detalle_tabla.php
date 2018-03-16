<?php
require_once ("../../config/Cado.php");
require_once ("cGuia.php");
$oGuia = new cGuia();

require_once ("../formatos/formato.php");

	$dts= $oGuia->mostrarUno($_POST['gui_id']);
	$dt = mysql_fetch_array($dts);
		$fec	=mostrarFecha($dt['tb_guia_fec']);
		$num	=$dt['tb_guia_num'];
		$com	=$dt['tb_guia_com'];
		$obs	=$dt['tb_guia_obs'];
		$pla	=$dt['tb_guia_pla'];
		$est	=$dt['tb_guia_est'];		
		$con_id	=$dt['tb_conductor_id'];		
		$tra_id	=$dt['tb_tranporte_id'];
	mysql_free_result($dts);

$dts1=$oGuia->mostrar_guia_detalle($_POST['gui_id']);
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
	$("#tabla_guia_detalle").tablesorter({ 
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
        <table cellspacing="1" id="tabla_guia_detalle" class="tablesorter">
            <thead>
                <tr>
                  <th align="right">CANT</th>
                  <th>UND</th>
                  <th>NOMBRE / PRESENTACION</th>
                  <th>CATEGORIA / MARCA</th>                   
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
							echo $dt1['tb_guiadetalle_can'];
							?></td>
                          <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                            <td>
							<?php 
							echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
							echo ' / '.$dt1['tb_presentacion_nom'];
							?></td>
                            <td><?php 
							echo $dt1['tb_categoria_nom'];
							echo ' / '.$dt1['tb_marca_nom'];
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
