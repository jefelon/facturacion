<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../catalogo/cst_producto.php");

require_once ("../formatos/formato.php");

$dts1=$oVenta->mostrar_filtro_detalle_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],'',$cat_ids,$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id'],$_POST['chk_fil_ven_may']);
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
		10: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0],[1,1]]
    });
	
}); 
</script>
        <table cellspacing="1" id="tabla_venta" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th>DOCUMENTO</th>
                    <th>CUI</th>
                    <th>NOMBRE</th>
                    <th>ARTICULO</th>
                    <th>UNI</th>
                    <th align="right">CAN</th>
                    <th align="right">PREC UNIT</th>
                    <!--<th align="right" title="Descuento">DESC</th>-->
                    <th align="right">VALOR VENTA</th>
                    <th align="right">IGV</th>
                    <th align="right">SUB TOTAL</th>
                    <th align="right">P.VENTA | COSTO</th>
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

          //costo promedio
          if($dt1['tb_ventadetalle_tipven']==1)
          {
            $stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
        
            $costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$dt1['tb_almacen_id'],'',date('Y-m-d'),$stock_kardex,$dt1['tb_catalogo_precos'],$precosdol,$_SESSION['empresa_id']);
            
            $costo_ponderado=$costo_ponderado_array['soles'];
          }
          
				?>
                    <tr>
                      <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                      <td nowrap="nowrap" title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_numdoc']?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_cliente_cui']?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']?></td>
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
                      <td align="right"><?php 
                        echo '<strong>'.formato_money($dt1['tb_ventadetalle_preunilin']).'</strong>';
                        if($dt1['tb_ventadetalle_tipven']==1)
                        {
                          echo ' | '. formato_money($costo_ponderado);
                          $diferencia=$dt1['tb_ventadetalle_preunilin']-$costo_ponderado;
                          $suma_diferencias+=($diferencia*$dt1['tb_ventadetalle_can']);
                          if($diferencia>0)echo ' | <strong><span style="color:green;"> + '.formato_money($diferencia).'</span></strong>';
                          if($diferencia<0)echo ' | <strong><span style="color:red;"> - '.formato_money(-1*$diferencia).'</span></strong>';
                        }
                        if($dt1['tb_ventadetalle_tipven']==2)
                        {
                          $suma_diferencias+=($dt1['tb_ventadetalle_preunilin']*$dt1['tb_ventadetalle_can']);
                        }
                        ?></td>
                      <td align="right"><?php echo $dt1['tb_venta_est']?></td>
                      <td align="left" nowrap="nowrap">
                      <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">Editar</a> 
                      <?php if($dt1['tb_venta_est']!='ANULADA'){/*?>
                      <a class="btn_anular" href="#anular" onClick="venta_anular('<?php echo $dt1['tb_venta_id']?>')">Anular</a> 
                      <?php */}?>
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
                  <td colspan="6">TOTAL</td>
                  <td align="right"><strong><?php echo formato_money($total_valven)?></strong></td>
                  <td align="right"><strong><?php echo formato_money($total_igv)?></strong></td>
                  <!--<td align="right"><strong><?php //echo formato_money($total_des)?></strong></td>-->
                  <td align="right"><strong><?php echo formato_money($total_ventas)?></strong></td>
                  <td align="right"><strong><?php echo formato_money($suma_diferencias)?></strong></td>
                  <td colspan="2" align="right">&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="12"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>