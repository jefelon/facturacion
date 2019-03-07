<?php
require_once ("../../config/Cado.php");
require_once ("../formatos/formato.php");
require_once("cDeclaracionimpuestos.php");
$oDeclaracionimpuestos = new cDeclaracionimpuestos();

$dts=$oDeclaracionimpuestos->mostrar_filtro(fecha_mysql($_POST['txt_fil_fec1']),fecha_mysql($_POST['txt_fil_fec2']));
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
	$("#tabla_declaracionimpuestos").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_declaracionimpuestos" class="tablesorter">
            <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>EMPRESA</th>
                    <th>FECHA DE DECLARACION</th>
                    <th>FECHA DE VENCIMIENTO</th>
                    <th>FECHA DE ENVIO CORREO</th>
                    <th>SE ENVIO AL CORREO DEL CLIENTE</th>
                    <th>PDT NO DECLARADOS</th>
                    <th>REALIZO EL PAGO DE SUS IMPUESTOS</th>
                    <th>DEUDAS PENDIENTES POR PAGAR IGV-RENTA</th>
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
                    <td>COD.SCF-<?php echo $dt['tb_declaracionimpuestos_id']?></td>
                    <td><?php echo $dt['tb_cliente_nom']; ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_declaracion'])?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_vencimiento'])?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_envio'])?></td>
                    <td><?php if($dt['tb_estado_correo']==True)
                        {echo 'Enviado';}else{ echo 'Pendiente'; } ?></td>
                    <td><?php echo $dt['tb_pdt_nodeclarados']; ?></td>
                    <td><?php if($dt['tb_estadopago']==True)
                        {echo 'Efectuado';}else{ echo 'Pendiente'; } ?></td>
                    <td><?php echo $dt['tb_deudas']; ?></td>
                    <td><?php echo $dt['tb_persdecl_nom']; ?></td>
                    <td><?php echo $dt['tb_observaciones']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="declaracionimpuestos_form('editar','<?php echo $dt['tb_declaracionimpuestos_id']?>')">Editar</a>
                    <a class="btn_eliminar" href="#" onClick="eliminar_declaracionimpuestos('<?php echo $dt['tb_declaracionimpuestos_id']?>')">Eliminar</a></td>
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
                  <td colspan="12"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>