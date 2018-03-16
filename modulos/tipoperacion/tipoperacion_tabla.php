<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTipoperacion.php");
$oTipoperacion = new cTipoperacion();

require_once ("../formatos/formatos.php");

$dts=$oTipoperacion->mostrarTodos();
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
	$("#tabla_tipoperacion").tablesorter({ 
		headers: {
			3: {sorter: false }, 
			4: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[1,0],[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_tipoperacion" class="tablesorter">
            <thead>
                <tr>
                <th>NOMBRE</th>
                <th>TIPO</th>
                <th>MANUAL</th>
                <th align="right">ID</th>
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
                <td><?php echo $dt['tb_tipoperacion_nom']?></td>
                <td><?php if($dt['tb_tipoperacion_tip']==1)echo 'ENTRADA';
				if($dt['tb_tipoperacion_tip']==2)echo 'SALIDA';
				?></td>
                <td><?php if($dt['tb_tipoperacion_man']==1)echo 'SI';?></td>
                <td align="right"><?php echo $dt['tb_tipoperacion_id']?></td>
                <td align="center"><a class="btn_editar" href="#" onClick="tipoperacion_form('editar','<?php echo $dt['tb_tipoperacion_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_tipoperacion('<?php echo $dt['tb_tipoperacion_id']?>')">Eliminar</a></td>
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
                  <td colspan="5"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>