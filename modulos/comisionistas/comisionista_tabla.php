<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cComisionista.php");
$oComisionista = new cComisionista();

$dts=$oComisionista->mostrar_filtro(fecha_mysql($_POST['txt_fil_fec1']),fecha_mysql($_POST['txt_fil_fec2']));
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
	$("#tabla_comisionista").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_comisionista" class="tablesorter">
            <thead>
                <tr>
                    <th>CÓDIGO</th>
                    <th>COMISIONISTA</th>
                    <th>EMPRESA</th>
                    <th>FECHA QUE CONSIGUIO CLIENTE</th>
                    <th>OPCIÓN COMISIONISTA</th>
                    <th>SE COBRO</th>
                    <th>COMISIÓN LIBROS</th>
                    <th>MES 1</th>
                    <th>MES 2</th>
                    <th>MES 3</th>
                    <th>CONTABILIDAD POR PAGAR</th>
                    <th>CONTABILIDADES YA PAGADAS</th>
                    <th>MONTO TOTAL</th>
                    <th></th>
                </tr>
            </thead>
        <?php
        if($num_rows>=1){
		?>  
            <tbody>
			<?php
           	while($dt = mysql_fetch_array($dts)){
           	    $pagado = $dt['tb_mes1']+$dt['tb_mes2']+$dt['tb_mes3'];
           	    $por_pagar=$dt['tb_monto_total']-$pagado;
            ?>
                <tr>
                    <td>COD.SCF - <?php echo $dt['tb_comisionista_id']?></td>
                    <td><?php echo $dt['tb_intermediario_nom']?></td>
                    <td><?php echo $dt['tb_cliente_nom']; ?></td>
                    <td><?php echo mostrarFecha($dt['tb_fecha_consiguio']); ?></td>
                    <td><?php
                        if($dt['tb_opcion_com']==1) {echo 'Concepto que se realizo';}
                        if($dt['tb_opcion_com']==2){ echo 'Llevado de contabilidad'; }
                        if($dt['tb_opcion_com']==3){ echo 'Constitución de Empresa'; }
                        ?></td>
                    <td><?php echo $dt['tb_cobro']; ?></td>
                    <td><?php echo $dt['tb_comision']; ?></td>
                    <td><?php echo $dt['tb_mes1']; ?></td>
                    <td><?php echo $dt['tb_mes2']; ?></td>
                    <td><?php echo $dt['tb_mes3']; ?></td>
                    <td><?php echo $por_pagar; ?></td>
                    <td><?php echo $pagado; ?></td>
                    <td><?php echo $dt['tb_monto_total']; ?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="comisionista_form('editar','<?php echo $dt['tb_comisionista_id']?>')">Editar</a>
                    <a class="btn_eliminar" href="#" onClick="eliminar_comisionista('<?php echo $dt['tb_comisionista_id']?>')">Eliminar</a></td>
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