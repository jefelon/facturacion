<?php
require_once ("../../config/Cado.php");
require_once("cTramitependiente.php");
require_once("../formatos/formato.php");
$oTramitependiente = new cTramitependiente();

$dts=$oTramitependiente->mostrarTodos();
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
	$("#tabla_tramitependiente").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_tramitependiente" class="tablesorter">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Empresa</th>
                    <th>Fecha Acuerdo</th>
                    <th>Tramite Finalizado</th>
                    <th>Tramite por ejecutar</th>
                    <th>Fec. empieza conteo</th>
                    <th>Fec. cumple plazo</th>
                    <th>Pers. Resp</th>
                    <th>Observaciones</th>
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
                    <td>COD.SCF-<?php echo $dt['tb_tramitependiente_id']?></td>
                    <td><?php echo $dt['tb_cliente_nom']?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_acuerdo']); ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_finalizado']); ?></td>
                    <td><?php echo $dt['tb_tramite_ejecutar']; ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_conteo']); ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_plazo']); ?></td>
                    <td><?php echo $dt['tb_persdecl_nom']; ?></td>
                    <td><?php echo $dt['tb_observaciones']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="tramitependiente_form('editar','<?php echo $dt['tb_tramitependiente_id']?>')">Editar</a>
                    <a class="btn_eliminar" href="#" onClick="eliminar_tramitependiente('<?php echo $dt['tb_tramitependiente_id']?>')">Eliminar</a></td>
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