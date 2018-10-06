<?php
require_once ("../../config/Cado.php");
require_once ("cCliente.php");
$oCliente = new cCliente();

if($_POST['cli_id']!="")
{
$dts1=$oCliente->mostrar_filtro($_POST['cli_id']);
$num_rows= mysql_num_rows($dts1);
}
else{
    $dts1=$oCliente->mostrarTodos($_POST['limit']);
    $num_rows= mysql_num_rows($dts1);
}
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
	
	$('.btn_info').button({
		icons: {primary: "ui-icon-info"},
		text: false
	});
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_cliente").tablesorter({ 
		headers: {
			6: {sorter: false }, 
			7: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_cliente" class="tablesorter">
            <thead>
                <tr>
                  <th>CLIENTE</th>               
                    <th>RUC/DNI</th>
                    <th>DIRECCION</th>
                    <th>CONTACTO</th>
                    <th>TELEFONO</th>
                    <th>EMAIL</th>
                    <th align="center">INFO</th>
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
                          <td><?php echo $dt1['tb_cliente_nom']?></td>                            
                            <td><?php echo $dt1['tb_cliente_doc']?></td>
                            <td><?php echo $dt1['tb_cliente_dir']?></td>
                            <td><?php echo $dt1['tb_cliente_con']?></td>                     
                            <td><?php echo $dt1['tb_cliente_tel']?></td>
                            <td><?php echo $dt1['tb_cliente_ema']?></td>
                            <td align="center" nowrap="nowrap"><a class="btn_info" href="#" onClick="ventas_por_cliente('<?php echo $dt1['tb_cliente_id']?>')">Información</a></td>
                            <td align="center" nowrap="nowrap"><a class="btn_editar" href="#editar" onClick="cliente_form('editar','<?php echo $dt1['tb_cliente_id']?>')">Editar</a> <a class="btn_eliminar" href="#eliminar" onClick="eliminar_cliente('<?php echo $dt1['tb_cliente_id']?>')">Eliminar</a></td>
                        </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
                </tbody>
            <?php }?>
                <tr class="even">
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>