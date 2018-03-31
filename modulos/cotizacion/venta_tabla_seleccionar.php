<?php
require_once ("../../config/Cado.php");
require_once ("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();
require_once ("../formatos/formato.php");

$dts1=$oCotizacion->mostrar_filtro_adm(fecha_mysql($_POST['ven_fec1']),fecha_mysql($_POST['ven_fec2']),$_POST['cli_id'],$_POST['ven_est'],$_POST['usu_id'],$_POST['punven_id']);

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

	$("#tabla_venta").tablesorter({
		widgets: ['zebra', 'zebra'] ,
		headers: {
			0: {sorter: 'shortDate' },
			13: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0],[2,0]]
    });
	
	$('.btn_agregar_ven').button({		
		text: true
	});
}); 
</script>
        <table cellspacing="1" id="tabla_venta" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th>DOC</th>
                  <th>NUM DOC</th>                    
                    <th>CLIENTE</th>
                    <th>RUC/DNI</th>
                    <th align="right">SUB TOTAL</th>
                    <th align="right">IGV</th>
                    <th align="right" title="Descuento">DESC</th>
                    <th align="right">TOTAL</th>
                    <th align="right">ESTADO</th>
                    <th align="right">VENDEDOR</th>
                    <th align="right">PUNTO VENTA</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
					$total_subtot+=$dt1['tb_venta_subtot'];
					$total_igv+=$dt1['tb_venta_igv'];
					$total_des+=$dt1['tb_venta_des'];
					$total_ventas+=$dt1['tb_venta_tot'];
				?>
                    <tr>
                      <td><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                      <td title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr']?></td>
                      <td><?php echo $dt1['tb_venta_numdoc']?></td>
                      <td><?php echo $dt1['tb_cliente_nom']?></td>
                      <td><?php echo $dt1['tb_cliente_doc']?></td>
                      <td align="right"><?php echo $dt1['tb_venta_subtot']?></td>
                      <td align="right"><?php echo $dt1['tb_venta_igv']?></td>
                      <td align="right"><?php echo $dt1['tb_venta_des']?></td>
                      <td align="right"><?php echo $dt1['tb_venta_tot']?></td>
                      <td align="right"><?php echo $dt1['tb_venta_est']?></td>
                      <td align="right"><?php echo $dt1['tb_usuario_nom'].' '.$dt1['tb_usuario_apepat']?></td>
                      <td align="right"><?php echo $dt1['tb_puntoventa_nom']?></td>
                      <td align="center" nowrap="nowrap">
                      <a class="btn_agregar_ven" href="#" onClick="restablecer_session('<?php echo $dt1['tb_venta_id']?>')">Seleccionar</a>
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
              <!--  <tr class="even">
                  <td colspan="5">TOTAL</td>
                  <td align="right"><strong><?php //echo formato_money($total_subtot)?></strong></td>
                  <td align="right"><strong><?php //echo formato_money($total_igv)?></strong></td>
                  <td align="right"><strong><?php //echo formato_money($total_des)?></strong></td>
                  <td align="right"><strong><?php //echo formato_money($total_ventas)?></strong></td>
                  <td colspan="3" align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>-->
                <tr class="even">
                  <td colspan="13"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>