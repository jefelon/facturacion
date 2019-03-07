<?php
require_once ("../../config/Cado.php");
require_once ("../formatos/formato.php");
require_once("cLegalizacionlibros.php");
$oLegalizacionlibros = new cLegalizacionlibros();

$dts=$oLegalizacionlibros->mostrar_filtro(fecha_mysql($_POST['txt_fil_fec1']),fecha_mysql($_POST['txt_fil_fec2']));
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
	$("#tabla_legalizacionlibros").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_legalizacionlibros" class="tablesorter">
            <thead>
                <tr>
                    <th>CÓDIGO</th>
                    <th>EMPRESA</th>
                    <th>LUGAR DE DOMICILIO FISCAL</th>
                    <th>FECHA DE RECEPCIÓN DE DINERO</th>
                    <th>NOTARÍA</th>
                    <th>FECHA DE LEGALIZACIÓN</th>
                    <th>FECHA DE RECOJO</th>
                    <th>Nro DE DOCUMENTO</th>
                    <th>REGIMEN TRIBUTARIO</th>
                    <th>CANTIDAD DE LIBROS</th>
                    <th>PERSONA RESPONSABLE DE LEGALIZACIÓN</th>
                    <th>LIBROS LEGALIZADOS</th>
                    <th>LIBROS NO LEGALIZADOS</th>
                    <th>PENDIENTE DE COBRO DE LIBROS CONTABLES</th>
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
                    <td>COD.SCF-<?php echo $dt['tb_legalizacionlibros_id']?></td>
                    <td><?php echo $dt['tb_cliente_nom']; ?></td>
                    <td><?php echo $dt['tb_domicilio_fiscal']?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_recepcion']); ?></td>
                    <td><?php echo $dt['tb_notaria']; ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_legalizacion']); ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_recojo']); ?></td>
                    <td><?php echo $dt['tb_numdoc']; ?></td>
                    <td><?php
                        if($dt['tb_regimen_tributario']==1) {echo 'Regimen Especial';}
                        if($dt['tb_regimen_tributario']==2){ echo 'Regimen MYPE Tributario'; }
                        if($dt['tb_regimen_tributario']==3){ echo 'Regimen General'; }
                        ?></td>
                    <td><?php echo $dt['tb_cantidad_libros']; ?></td>
                    <td><?php echo $dt['tb_responsable_nom']; ?></td>
                    <td><?php echo $dt['tb_libros_legalizados']; ?></td>
                    <td><?php echo $dt['tb_libros_nolegalizados']; ?></td>
                    <td><?php echo $dt['tb_pendiente_cobro']; ?></td>
                    <td><?php echo $dt['tb_observaciones']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="legalizacionlibros_form('editar','<?php echo $dt['tb_legalizacionlibros_id']?>')">Editar</a>
                    <a class="btn_eliminar" href="#" onClick="eliminar_legalizacionlibros('<?php echo $dt['tb_legalizacionlibros_id']?>')">Eliminar</a></td>
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
                  <td colspan="15"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>