<?php
require_once ("../../config/Cado.php");
require_once ("../formatos/formato.php");
require_once("cPlanilla.php");
$oPlanilla = new cPlanilla();

$dts=$oPlanilla->mostrar_filtro(fecha_mysql($_POST['txt_fil_fec1']),fecha_mysql($_POST['txt_fil_fec2']));
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
	$("#tabla_planilla").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_planilla" class="tablesorter">
            <thead>
            <tr>
                <th>Código</th>
                <th>Empresa</th>
                <th>Fec. Declaración</th>
                <th>Fec. Vencimiento</th>
                <th>Fec. Envio</th>
                <th>Estado Fec. Envio</th>
                <th>Planilla No Declarados</th>
                <th>Realizo el Pago de Planilla</th>
                <th>Deudas Pendientes</th>
                <th>Persona Responsable de Declaración</th>
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
                    <td>COD.SCF-<?php echo $dt['tb_planilla_id']?></td>
                    <td><?php echo $dt['tb_cliente_nom']?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_declaracion'])?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_vencimiento']); ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_envio']); ?></td>
                    <td><?php if($dt['tb_estado_correo']==True)
                        {echo 'Enviado';}else{ echo 'Pendiente'; } ?></td>
                    <td><?php echo $dt['tb_planilla_nodeclarados']; ?></td>
                    <td><?php if($dt['tb_planilla_estadopago']==True)
                        {echo 'Efectuado';}else{ echo 'Pendiente'; } ?></td>
                    <td><?php echo $dt['tb_planilla_deudas']; ?></td>
                    <td><?php echo $dt['tb_persdecl_nom']; ?></td>
                    <td><?php echo $dt['tb_observaciones']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="planilla_form('editar','<?php echo $dt['tb_planilla_id']?>')">Editar</a>
                        <a class="btn_eliminar" href="#" onClick="eliminar_planilla('<?php echo $dt['tb_planilla_id']?>')">Eliminar</a></td>
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