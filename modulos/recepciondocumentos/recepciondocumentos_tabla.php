<?php
require_once ("../../config/Cado.php");
require_once ("cRecepcionDocumentos.php");
$oRecepcionDocumentos = new cRecepcionDocumentos();

$dts=$oRecepcionDocumentos->mostrarTodos();
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
	$("#tabla_recepciondocumentos").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_recepciondocumentos" class="tablesorter">
            <thead>
                <tr>
                <th>Nombre</th>
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
                <td><?php echo $dt['tb_recepciondocumentos_fecha']?></td>
                <td align="center"><a class="btn_editar" href="#" onClick="recepciondocumentos_form('editar','<?php echo $dt['tb_recepciondocumentos_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar_recepciondocumentos('<?php echo $dt['tb_recepciondocumentos_id']?>')">Eliminar</a></td>
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
                  <td colspan="3"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>