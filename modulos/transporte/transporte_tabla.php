<?php
require_once ("../../config/Cado.php");
require_once ("cTransporte.php");
$oTransporte = new cTransporte();

$dts1=$oTransporte->mostrarTodos();
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
	$("#tabla_transporte").tablesorter({ 
		headers: {
			6: {sorter: false }, 
			7: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_transporte" class="tablesorter">
            <thead>
                <tr>
                  <th>RAZON SOCIAL</th>               
                    <th>RUC</th>
                    <th>DIRECCION</th>                    
                    <th>TELEFONO</th>
                    <th>EMAIL</th>
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
                          <td><?php echo $dt1['tb_transporte_razsoc']?></td>                            
                            <td><?php echo $dt1['tb_transporte_ruc']?></td>
                            <td><?php echo $dt1['tb_transporte_dir']?></td>                            
                            <td><?php echo $dt1['tb_transporte_tel']?></td>
                            <td><?php echo $dt1['tb_transporte_ema']?></td>
                            <td align="center"><a class="btn_editar" href="#" onClick="transporte_form('editar','<?php echo $dt1['tb_transporte_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_transporte('<?php echo $dt1['tb_transporte_id']?>')">Eliminar</a></td>
                        </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
                </tbody>
            <?php }?>
                <tr class="even">
                  <td colspan="7"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>