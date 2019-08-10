<?php
require_once ("../../config/Cado.php");
require_once ("cUsuariogrupo.php");
$oUsuariogrupo = new cUsuariogrupo();

$dts1=$oUsuariogrupo->mostrarTodos();
$num_rows= mysql_num_rows($dts1);
?>

<script src="../../js/tablaButton.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	$.tablesorter.defaults.widgets = ['zebra'];
	//$.tablesorter.defaults.sortList = [[0,0]];
	$("#tabla_usuarioGrupo").tablesorter({ 
		headers: {
			3: {sorter: false }, 
			4: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_usuarioGrupo" class="tablesorter" align="center">
            <thead>
                <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
				if($num_rows>0){
                while($dt1 = mysql_fetch_array($dts1)){
                ?>
                <tr>
                <td><?php echo $dt1['tb_usuariogrupo_id']?></td>
                <td><?php echo $dt1['tb_usuariogrupo_nom']?></td>
                <td><?php echo $dt1['tb_usuariogrupo_des']?></td>
                <td align="center"><a class="btn_editar" href="#" onClick="editar('<?php echo $dt1['tb_usuariogrupo_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar('<?php echo $dt1['tb_usuariogrupo_id']?>')">Eliminar</a></td>
                </tr>
                                <?php
                }
				}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <tr>
                  <td colspan="5"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>