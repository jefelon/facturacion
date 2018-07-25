<?php
require_once ("../../config/Cado.php");
require_once ("cConductor.php");
$oConductor = new cConductor();

$dts1=$oConductor->mostrarTodos();
$num_rows= mysql_num_rows($dts1);
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
	$("#tabla_conductor").tablesorter({ 
		headers: {
			6: {sorter: false }, 
			7: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_conductor" class="tablesorter">
            <thead>
                <tr>
                  <th>CLIENTE</th>               
                    <th>RUC/DNI</th>
                    <th>DIRECCION</th>                    
                    <th>TELEFONO</th>
                    <th>EMAIL</th>
                    <th>N° LICENCIA</th>
                    <th>CATEGORIA</th>
                    <th>EMPRESA TRANSPORTE</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>
                          <td><?php echo $dt1['tb_conductor_nom']?></td>                            
                            <td><?php echo $dt1['tb_conductor_doc']?></td>
                            <td><?php echo $dt1['tb_conductor_dir']?></td>                                                 
                            <td><?php echo $dt1['tb_conductor_tel']?></td>
                            <td><?php echo $dt1['tb_conductor_ema']?></td>
                            <td><?php echo $dt1['tb_conductor_lic']?></td>
                            <td><?php echo $dt1['tb_conductor_cat']?></td>
                            <td><?php echo $dt1['tb_transporte_razsoc']?></td>
                            <td align="center"><a class="btn_editar" href="#" onClick="conductor_form('editar','<?php echo $dt1['tb_conductor_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_conductor('<?php echo $dt1['tb_conductor_id']?>')">Eliminar</a></td>
                        </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
                </tbody>
            <?php }?>
                <tr class="even">
                  <td colspan="9"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>