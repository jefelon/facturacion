<?php
require_once ("../../config/Cado.php");
require_once ("cVehiculo.php");
$oVehiculo = new cVehiculo();

$dts=$oVehiculo->mostrarTodos();
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
	$("#tabla_vehiculo").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_vehiculo" class="tablesorter">
            <thead>
                <tr>
                <th>Codigo</th>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Num. Asi.</th>
                <th>Pisos</th>
                <th>Conductor</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
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
                <td><?php echo $dt['tb_vehiculo_id']?></td>
                <td><?php echo $dt['tb_vehiculo_placa']?></td>
                <td><?php echo $dt['tb_vehiculo_marca']?></td>
                <td><?php echo $dt['tb_vehiculo_modelo']?></td>
                <td><?php echo $dt['tb_vehiculo_numasi']?></td>
                <td><?php echo $dt['tb_vehiculo_pisos']?></td>
                <td><?php echo $dt['tb_conductor_nom']?></td>
                <td align="center"><a class="btn_editar" href="#" onClick="vehiculo_form('editar','<?php echo $dt['tb_vehiculo_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar_vehiculo('<?php echo $dt['tb_vehiculo_id']?>')">Eliminar</a></td>
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
                  <td colspan="10"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>