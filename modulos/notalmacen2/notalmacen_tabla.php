<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cNotalmacen.php");
$oNotalmacen = new cNotalmacen();
require_once ("../formatos/formato.php");

$dts1=$oNotalmacen->mostrar_filtro(fecha_mysql($_POST['notalm_fec1']),fecha_mysql($_POST['notalm_fec2']),$_POST['alm_id'],$_POST['notalm_tip'],$_SESSION['empresa_id']);
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

	$("#tabla_notalmacen").tablesorter({
		widgets: ['zebra', 'zebra'] ,
		headers: {
			0: {sorter: 'shortDate' },
			5: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
	
}); 
</script>
        <table cellspacing="1" id="tabla_notalmacen" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th>CODIGO</th>
                  <th>ALMACEN</th>
                  <th>TIPO</th>
                  <th>TIPO OPERACION</th>
                  <th>DOCUMENTO</th>
                  <th>DESCRIPCION</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
				?>
                    <tr>
                      <td><?php echo mostrarFecha($dt1['tb_notalmacen_fec'])?></td>
                      <td><?php echo str_pad($dt1['tb_notalmacen_cod'],4, "0", STR_PAD_LEFT)?></td>
                      <td><?php echo $dt1['tb_almacen_nom']?></td>
                      <td><?php if($dt1['tb_notalmacen_tip']==1)echo 'ENTRADA';
					  if($dt1['tb_notalmacen_tip']==2)echo 'SALIDA';?></td>
                      <td><?php echo $dt1['tb_tipoperacion_nom']?></td>
                      <td><?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_notalmacen_numdoc']?></td>
                      <td><?php echo $dt1['tb_notalmacen_des']?></td>
                      <td align="center"><a class="btn_editar" href="#update" onClick="notalmacen_form('editar','<?php echo $dt1['tb_notalmacen_id']?>')">Editar</a> <a class="btn_eliminar" href="#delete" onClick="eliminar_notalmacen('<?php echo $dt1['tb_notalmacen_id']?>')">Eliminarr</a></td>
                    </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
			}
		    ?>
                <tr class="even">
                  <td colspan="7">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>