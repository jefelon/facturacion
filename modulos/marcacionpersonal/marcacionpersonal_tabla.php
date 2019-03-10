<?php
require_once ("../../config/Cado.php");
require_once ("../formatos/formato.php");
require_once("cMarcacionpersonal.php");
$oMarcacionpersonal = new cMarcacionpersonal();

$dts=$oMarcacionpersonal->mostrarTodos();
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
	$("#tabla_marcacionpersonal").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_marcacionpersonal" class="tablesorter">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Personal</th>
                    <th>Fecha y Hora Ingreso</th>
                    <th>Fecha y Hora Salidas</th>
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
                    <td>COD.SCF-<?php echo $dt['tb_marcacionpersonal_id']?></td>
                    <td><?php echo $dt['tb_cliente_nom']?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_ingreso']).' - '.formato_hora($dt['tb_hora_ingreso']); ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_salida']).' - '.formato_hora($dt['tb_hora_salida']); ?></td>
                    <td><?php echo $dt['tb_tardanza']; ?></td>
                    <td><?php echo $dt['tb_falta']; ?></td>
                    <td><?php echo $dt['tb_permisos']; ?></td>
                    <td><?php echo $dt['tb_fecha_cumpleanos']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="marcacionpersonal_form('editar','<?php echo $dt['tb_marcacionpersonal_id']?>')">Editar</a>
                    <a class="btn_eliminar" href="#" onClick="eliminar_marcacionpersonal('<?php echo $dt['tb_marcacionpersonal_id']?>')">Eliminar</a></td>
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
                  <td colspan="12"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>