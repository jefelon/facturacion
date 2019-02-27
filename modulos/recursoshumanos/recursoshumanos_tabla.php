<?php
require_once ("../../config/Cado.php");
require_once("cRecursoshumanos.php");
$oRecursoshumanos = new cRecursoshumanos();

$dts=$oRecursoshumanos->mostrarTodos();
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
	$("#tabla_recursoshumanos").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_recursoshumanos" class="tablesorter">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Personal</th>
                    <th>Cargo</th>
                    <th>Fec. Ingreso</th>
                    <th>Fec. Salida</th>
                    <th>Tardanza</th>
                    <th>Falta</th>
                    <th>Permisos</th>
                    <th>Fec. Cumpleaños</th>
                    <th></th>
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
                    <td><?php echo $dt['tb_recursoshumanos_id']?></td>
                    <td><?php echo $dt['tb_cargo']?></td>
                    <td><?php echo $dt['tb_fecha_ingreso']?></td>
                    <td><?php echo $dt['tb_fecha_salida']; ?></td>
                    <td><?php echo $dt['tb_tardanza']; ?></td>
                    <td><?php echo $dt['tb_falta']; ?></td>
                    <td><?php echo $dt['tb_permisos']; ?></td>
                    <td><?php echo $dt['tb_permisos']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="recursoshumanos_form('editar','<?php echo $dt['tb_recursoshumanos_id']?>')">Editar</a>
                    <a class="btn_eliminar" href="#" onClick="eliminar_recursoshumanos('<?php echo $dt['tb_recursoshumanos_id']?>')">Eliminar</a></td>
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
                  <td colspan="11"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>