<?php
require_once ("../../config/Cado.php");
require_once ("cUbigeo.php");
$oUbigeo = new cUbigeo();

$dts1=$oUbigeo->mostrarTodos();
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_ubigeo").tablesorter({ 
		headers: {
			0: {sorter: 'text' },
			3: {sorter: false }, 
			4: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_ubigeo" class="tablesorter" >
            <thead>
                <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Tipo</th>
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
                <td><?php echo $dt1['tb_ubigeo_coddep'].$dt1['tb_ubigeo_codpro'].$dt1['tb_ubigeo_coddis']?></td>
                <td><?php echo $dt1['tb_ubigeo_nom']?></td>
                <td><?php echo $dt1['tb_ubigeo_tip']?></td>
                <td align="center"><a class="btn_editar" href="#update" onClick="ubigeo_form('editar','<?php echo $dt1['tb_ubigeo_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#delete" onClick="eliminar('<?php echo $dt1['tb_ubigeo_id']?>')">Eliminar</a></td>
                </tr>
                                <?php
                }
				}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <tr class="even">
                  <td colspan="5"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>