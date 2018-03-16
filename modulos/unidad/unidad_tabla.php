<?php
require_once ("../../config/Cado.php");
require_once ("cUnidad.php");
$oUnidad = new cUnidad();

$dts=$oUnidad->mostrarTodos();
$num_rows= mysql_num_rows($dts);
mysql_free_result($dts);
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
	/*$("#tabla_unidad").tablesorter({ 
		headers: {
			2: {sorter: false }, 
			3: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });*/
}); 
</script>
        <table cellspacing="1" id="tabla_unidad" class="tablesorter">
            <thead>
                <tr>
                  <th>Abreviatura</th>
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
		$dts1=$oUnidad->mostrar_tipo();
		while($dt1 = mysql_fetch_array($dts1)){
		?>
        		<tr class="hover">
        		  <th colspan="4" valign="bottom"><strong>
				  <?php 
					switch ($dt1['tb_unidad_tip']) {
						case 0:
							echo "Sin clasificar";
						break;
						case 1:
							echo "UNIDAD BASE";
						break;
						case 2:
							echo "UNIDAD ALTERNATIVA";
						break;
					}
				  ?></strong></th>
      		  </tr>
       		  <?php	
			$dts=$oUnidad->mostrar_por_tipo($dt1['tb_unidad_tip']);
           	while($dt = mysql_fetch_array($dts)){
            ?>
                <tr class="even">
                  <td><?php echo $dt['tb_unidad_abr']?></td>
                <td><?php echo $dt['tb_unidad_nom']?></td>
                <td align="center"><a class="btn_editar" href="#" onClick="unidad_form('editar','<?php echo $dt['tb_unidad_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar_unidad('<?php echo $dt['tb_unidad_id']?>')">Eliminar</a></td>
                </tr>
			<?php
				}
				mysql_free_result($dts);
			?>
            <tr class="even">
                  <td colspan="4">&nbsp;</td>
                </tr>
        <?php
		}
        mysql_free_result($dts1);
		?>
            </tbody>
     	<?php
        }
		?>
                <tr class="even">
                  <td colspan="4"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>