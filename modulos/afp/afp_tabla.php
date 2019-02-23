<?php
require_once ("../../config/Cado.php");
require_once("cAfp.php");
$oAfp = new cAfp();

$dts=$oAfp->mostrarTodos();
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
	$("#tabla_afp").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_afp" class="tablesorter">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Empresa</th>
                    <th>Fec. Declaración</th>
                    <th>Fec. Vencimiento</th>
                    <th>Fec. Envio</th>
                    <th>Estado Fec. Envio</th>
                    <th>AFP No Declarados</th>
                    <th>Realizo Pago</th>
                    <th>Deudas Pendientes</th>
                    <th>Persona Responsable</th>
                    <th>Observaciones</th>
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
                    <td><?php echo $dt['tb_declaraciondocumentos_id']?></td>
                    <td><?php echo $dt['tb_cliente_nom']?></td>
                    <td><?php echo $dt['tb_fecha_declaracion']?></td>
                    <td><?php echo $dt['tb_fecha_vencimiento']; ?></td>
                    <td><?php echo $dt['tb_fecha_envio']; ?></td>
                    <td><?php if($dt['tb_estado_correo']==True)
                        {echo 'Enviado';}else{ echo 'Pendiente'; } ?></td>
                    <td><?php echo $dt['tb_afp_nodeclarados']; ?></td>
                    <td><?php if($dt['tb_afp_estadopago']==True)
                    {echo 'Efectuado';}else{ echo 'Pendiente'; } ?></td>
                    <td><?php echo $dt['tb_afp_deudas']; ?></td>
                    <td><?php echo $dt['tb_persdecl_nom']; ?></td>
                    <td><?php echo $dt['tb_observaciones']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="declaraciondocumentos_form('editar','<?php echo $dt['tb_declaraciondocumentos_id']?>')">Editar</a>
                    <a class="btn_eliminar" href="#" onClick="eliminar_declaraciondocumentos('<?php echo $dt['tb_declaraciondocumentos_id']?>')">Eliminar</a></td>
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
                  <td colspan="11"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>