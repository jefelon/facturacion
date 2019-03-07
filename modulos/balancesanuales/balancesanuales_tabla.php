<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cBalancesanuales.php");
$oBalancesanuales = new cBalancesanuales();

$dts=$oBalancesanuales->mostrarTodos();
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
	$("#tabla_balancesanuales").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_balancesanuales" class="tablesorter">
            <thead>
                <tr>
                    <th>CÓDIGO</th>
                    <th>EMPRESA</th>
                    <th>FECHA QUE COMIENZA A ELABORAR BALANCES ANUALES</th>
                    <th>FECHA DE CULMINACION DE BALANCES ANUALES</th>
                    <th>FECHA DE DECLARACION</th>
                    <th>FECHA DE VENCIMIENTO</th>
                    <th>BALANCES DECLARADOS</th>
                    <th>BALANCES NO DECLARADOS</th>
                    <th>SALE A PAGAR DEL BALANCE ANUAL</th>
                    <th>REALIZO EL PAGO ANUAL</th>
                    <th>PERSONA RESPONSABLE DE ELABORACION</th>
                    <th>PERSONA RESPONSABLE DE DECLARACION</th>
                    <th>OBSERVACIONES</th>
                    <th></th>
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
                    <td>COD.SCF-<?php echo $dt['tb_balancesanuales_id']?></td>
                    <td><?php echo $dt['tb_cliente_nom']?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_comienza']); ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_culminacion']); ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_declaracion']); ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_vencimiento']); ?></td>
                    <td><?php if($dt['tb_balances_declarados']==True)
                        {echo 'Declarados';}else{ echo 'Pendiente'; } ?></td>
                    <td><?php if($dt['tb_balances_nodeclarados']==True)
                        {echo 'Declarados';}else{ echo 'Pendiente'; } ?></td>
                    <td><?php echo $dt['tb_apagar'] ?></td>
                    <td><?php if($dt['tb_pago_anual']==True)
                        {echo 'Efectuado';}else{ echo 'Pendiente'; } ?></td>
                    <td><?php echo $dt['tb_responsable_elaboracion_nom']; ?></td>
                    <td><?php echo $dt['tb_responsable_declaracion_nom']; ?></td>
                    <td><?php echo $dt['tb_observaciones']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="balancesanuales_form('editar','<?php echo $dt['tb_balancesanuales_id']?>')">Editar</a>
                    <a class="btn_eliminar" href="#" onClick="eliminar_balancesanuales('<?php echo $dt['tb_balancesanuales_id']?>')">Eliminar</a></td>
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
                  <td colspan="14"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>