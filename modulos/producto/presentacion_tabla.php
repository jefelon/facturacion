<?php
require_once ("../../config/Cado.php");
require_once ("cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();

require_once ("../formatos/formato.php");

$dts1=$oPresentacion->mostrar_por_producto($_POST['pro_id']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">
$(function() {	
	$('#btn_agregar_presentacion').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});
	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});

	$("#tabla_presentacion_fila").tablesorter({
		widgets: ['zebra'],
		headers: {
			4: { sorter: false}
			},
		//sortForce: [[0,0]],
		//sortList: [[0,0]]
    });
}); 
</script>
<?php /*?>
<a id="btn_agregar_presentacion" href="#" onClick="presentacion_form('insertar')">Agregar</a>
<?php */?>
<?php /*
if($num_rows==0)echo 'Ninguna Presentación.';
if($num_rows==1)echo $num_rows.' Presentación.';
if($num_rows>1)echo $num_rows.' Presentaciones.';*/
?>
	  <table cellspacing="1" id="tabla_presentacion_fila" class="tablesorter">
       	  <thead>
                <tr>
<!--                <th>NOMBRE</th>-->
                <th>CODIGO</th>
<!--                <th align="right">STOCK MIN.</th>-->
<!--                <th align="center">ESTADO</th>-->
                <th align="center">&nbsp;</th>
                </tr>
      </thead>
            <?php
			$dts1=$oPresentacion->mostrar_por_producto($_POST['pro_id']);
			$num_rows= mysql_num_rows($dts1);
			if($num_rows>=1)
			{
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
					//unidad base de presentacion
					$rws= $oCatalogoproducto->presentacion_unidad_base($dt1['tb_presentacion_id']);
					$rw = mysql_fetch_array($rws);
						$unidad_base_nombre	=$rw['tb_unidad_abr'];
					mysql_free_result($rws);
				?>
                        <tr>
<!--                          <td><strong>--><?php //echo $pre_nom=$dt1['tb_presentacion_nom']?><!--</strong></td>-->
                          <td><strong><?php echo $dt1['tb_presentacion_cod']?></strong></td>
<!--                            <td align="right">--><?php //echo $dt1['tb_presentacion_stomin'].' '.$unidad_base_nombre?><!--</td>-->
<!--                            <td align="center">--><?php //echo $dt1['tb_presentacion_est']?><!--</td>-->
                            <td align="center"><a class="btn_editar" onClick="presentacion_form('editar','<?php echo $dt1['tb_presentacion_id']?>')">Editar Presentación</a><a class="btn_eliminar" onClick="eliminar_presentacion('<?php echo $dt1['tb_presentacion_id']?>')"> Eliminar Presentación</a></td>
                        </tr>
                <?php
                }
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
            }
			else
			{
            ?>
            <tr>
                <!--<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>-->
            </tr>
            <?php }?>
        </table>