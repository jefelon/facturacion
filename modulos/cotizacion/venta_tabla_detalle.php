<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();
require_once ("../formatos/formato.php");

$dts1=$oCotizacion->mostrar_filtro_detalle(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],'',$cat_ids,$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_SESSION['usuario_id'],$_SESSION['puntoventa_id'],$_POST['chk_fil_ven_may']);
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
	
	$('.btn_anular').button({
		icons: {primary: "ui-icon-cancel"},
		text: false
	});

	$("#tabla_venta").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		headers: {
			0: {sorter: 'shortDate' },
		11: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0],[2,1]]
    });
	
}); 
</script>
        <table cellspacing="1" id="tabla_venta" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th>HORA</th>
                  <th>DOCUMENTO</th>
                  <th>ARTICULO</th>
                    <th>UNI</th>
                    <th align="right">CAN</th>
                    <th align="right">PREC UNIT</th>
                    <!--<th align="right" title="Descuento">DESC</th>-->
                    <th align="right">VALOR VENTA</th>
                    <th align="right">IGV</th>
                    <th align="right">SUB TOTAL</th>
                    <th align="right">ESTADO</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
					$sub_total=$dt1['tb_ventadetalle_valven']+$dt1['tb_ventadetalle_igv'];
					
					if($dt1['tb_venta_est']=='CANCELADA'){
						$total_valven	+=$dt1['tb_ventadetalle_valven'];
						$total_igv		+=$dt1['tb_ventadetalle_igv'];
						
						//$total_des		+=$dt1['tb_venta_des'];
						$total_ventas	+=$sub_total;
					}
				?>
                    <tr>
                      <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                      <td nowrap="nowrap"><?php echo mostrarHora_fh($dt1['tb_venta_reg'])?></td>
                      <td nowrap="nowrap" title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_numdoc']?></td>
                      <td><?php 
					  	if($dt1['tb_ventadetalle_tipven']==1)echo $dt1['tb_producto_nom'];
						if($dt1['tb_ventadetalle_tipven']==2)echo $dt1['tb_servicio_nom'];
					  ?></td>
                      <td><?php 
					  	if($dt1['tb_ventadetalle_tipven']==1)echo $dt1['tb_unidad_abr'];
						if($dt1['tb_ventadetalle_tipven']==2)echo 'UN';
					  ?></td>
                      <td align="right"><?php echo $dt1['tb_ventadetalle_can']?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_ventadetalle_preuni'])?></td>
                      <!--<td align="right"><?php //echo $dt1['tb_venta_des']?></td>-->
                      <td align="right"><?php echo formato_money($dt1['tb_ventadetalle_valven'])?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_ventadetalle_igv'])?></td>
                      <td align="right"><?php echo formato_money($sub_total)?></td>
                      <td align="right"><?php echo $dt1['tb_venta_est']?></td>
                      <td align="left" nowrap="nowrap">
                      <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">Editar</a> 
                      <?php /*if($dt1['tb_venta_est']!='ANULADA'){?>
                      <a class="btn_anular" href="#anular" onClick="venta_anular('<?php echo $dt1['tb_venta_id']?>')">Anular</a> 
                      <?php }*/?>
                      <!--<a class="btn_eliminar" href="#delete" onClick="eliminar_venta('<?php //echo $dt1['tb_venta_id']?>')">Eliminarr</a>-->
                      </td>
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
                  <td colspan="7">TOTAL</td>
                  <td align="right"><strong><?php echo formato_money($total_valven)?></strong></td>
                  <td align="right"><strong><?php echo formato_money($total_igv)?></strong></td>
                  <!--<td align="right"><strong><?php //echo formato_money($total_des)?></strong></td>-->
                  <td align="right"><strong><?php echo formato_money($total_ventas)?></strong></td>
                  <td colspan="2" align="right">&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="13"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>