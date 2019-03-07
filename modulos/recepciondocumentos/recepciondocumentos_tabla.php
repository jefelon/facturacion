<?php
require_once ("../../config/Cado.php");
require_once ("../formatos/formato.php");
require_once ("cRecepcionDocumentos.php");
$oRecepcionDocumentos = new cRecepcionDocumentos();
$dts=$oRecepcionDocumentos->mostrar_filtro(fecha_mysql($_POST['txt_fil_fec1']),fecha_mysql($_POST['txt_fil_fec2']));
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
	$("#tabla_recepciondocumentos").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_recepciondocumentos" class="tablesorter">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha de Recepción</th>
                    <th>Empresa</th>
                    <th>Pers. Entrega</th>
                    <th>Pers. Recepciona</th>
                    <th>Resp. Recojo</th>
                    <th>Pendientes</th>
                    <th>Dirección</th>
                    <th>Celular</th>
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
                    <td>COD.SCF-<?php echo $dt['tb_recepciondocumentos_id']?></td>
                    <td><?php echo mostrarFecha($dt['tb_recepciondocumentos_fecha'])?></td>
                    <td><?php echo $dt['tb_cliente_nom']; ?></td>
                    <td><?php echo $dt['tb_persentrega_nom']; ?></td>
                    <td><?php echo $dt['tb_persrecepcion_nom']; ?></td>
                    <td><?php echo $dt['tb_persrecoge_nom']; ?></td>
                    <td><?php if($dt['tb_recepciondocumentos_pendientes']==True)
                    {echo 'Trajo';}else{ echo 'No Trajo'; } ?></td>
                    <td><?php echo $dt['tb_cliente_dir']; ?></td>
                    <td><?php echo $dt['tb_cliente_tel']; ?></td>
                    <td><?php echo $dt['tb_recepciondocumentos_observacion']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="recepciondocumentos_form('editar','<?php echo $dt['tb_recepciondocumentos_id']?>')">Editar</a>
                    <a class="btn_eliminar" href="#" onClick="eliminar_recepciondocumentos('<?php echo $dt['tb_recepciondocumentos_id']?>')">Eliminar</a></td>
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