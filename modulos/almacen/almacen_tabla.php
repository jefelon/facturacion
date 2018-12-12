<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cAlmacen.php");
$oAlmacen = new cAlmacen();

require_once ("../formatos/formatos.php");

$dts=$oAlmacen->mostrarTodos($_SESSION['empresa_id']);
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
	$("#tabla_almacen").tablesorter({ 
		headers: {
			2: {sorter: false }, 
			3: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_almacen" class="tablesorter">
            <thead>
                <tr>
                <th>NOMBRE DE ALMACEN</th>
                <th>PARA VENTA</th>
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
                <td><?php echo $dt['tb_almacen_nom']?></td>
                <td><?php echo mostrar_siigual($dt['tb_almacen_ven'],1,'SI')?></td>
                <td align="center"><a class="btn_editar" href="#" onClick="almacen_form('editar','<?php echo $dt['tb_almacen_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar_almacen('<?php echo $dt['tb_almacen_id']?>')">Eliminar</a></td>
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
                  <td colspan="4"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>