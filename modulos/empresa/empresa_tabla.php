<?php
require_once ("../../config/Cado.php");
require_once ("cEmpresa.php");
$oEmpresa = new cEmpresa();

$dts1=$oEmpresa->mostrarTodos();
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
	$("#tabla_empresa").tablesorter({ 
		headers: {
			6: {sorter: false }
		},
		//sortForce: [[0,0]],
		//sortList: [[1,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_empresa" class="tablesorter">
            <thead>
                <tr>               
                    <th>RUC</th>
                    <th>NOMBRE COMERCIAL</th>                                
                    <th>RAZON SOCIAL</th>
                    <th>DIRECCION</th>
                    <th>TELEFONO</th>
                    <th>EMAIL</th>
                    <th>REPRESENTANTE</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
					if($num_rows>0){
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>                            
                            <td><?php echo $dt1['tb_empresa_ruc']?></td>
                            <td><?php echo $dt1['tb_empresa_nomcom']?></td>
                            <td><?php echo $dt1['tb_empresa_razsoc']?></td>
                            <td><?php echo $dt1['tb_empresa_dir']." ".$dt1['tb_empresa_dir2']?></td>                     
                            <td><?php echo $dt1['tb_empresa_tel']?></td>
                            <td><?php echo $dt1['tb_empresa_ema']?></td>
                            <td><?php echo $dt1['tb_empresa_rep']?></td>
                            <td align="center" nowrap="nowrap"><a class="btn_editar" href="#" onClick="empresa_form('editar','<?php echo $dt1['tb_empresa_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_empresa('<?php echo $dt1['tb_empresa_id']?>')">Eliminar</a></td>
                        </tr>
                <?php
                }
				}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <tr class="even">
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>