<?php
require_once ("../../config/Cado.php");
require_once ("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();

require_once ("../formatos/formato.php");

$dts= $oCotizacion->mostrarUno($_POST['ven_id']);
$dt = mysql_fetch_array($dts);
	$fec	=mostrarFecha($dt['tb_cotizacion_fec']);
	$doc_id	=$dt['tb_documento_id'];
  $doc_ele =$dt['tb_documento_ele'];
	$numdoc	=$dt['tb_cotizacion_numdoc'];

	$cli_id	=$dt['tb_cliente_id'];
  $subtotal=$dt["tb_cotizacion_gra"];
	$valven	=$dt['tb_cotizacion_valven'];
	$igv	=$dt['tb_cotizacion_igv'];
	$des	=$dt['tb_cotizacion_des'];
	$tot	=$dt['tb_cotizacion_tot'];
  $ope_gratuitas = $dt['tb_cotizacion_grat'];

  $estsun=$dt['tb_cotizacion_estsun'];
  $fecenvsun=mostrarFechaHora($dt['tb_cotizacion_fecenvsun']);
  $faucod=$dt['tb_cotizacion_faucod'];
  $digval=$dt['tb_cotizacion_digval'];
  $sigval=$dt['tb_cotizacion_sigval'];
  $val=$dt['tb_cotizacion_val'];
mysql_free_result($dts);

$dts1=$oCotizacion->mostrar_venta_detalle($_POST['ven_id']);
$num_rows= mysql_num_rows($dts1);

$dts2=$oCotizacion->mostrar_venta_detalle_servicio($_POST['ven_id']);
$num_rows_2= mysql_num_rows($dts2);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn_agregar').button({
		icons: {primary: "ui-icon-plus"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_venta_detalle").tablesorter({ 
		headers: {
			//4: {sorter: 'shortDate' },
			//8: { sorter: false}
			},
		//sortForce: [[0,0]],
		//sortList: [[2,0]]
    });
	
	$("#tabla_venta_detalle_servicio").tablesorter({ 
		headers: {
			//4: {sorter: 'shortDate' },
			//8: { sorter: false}
			},
		//sortForce: [[0,0]],
		//sortList: [[2,0]]
    });

}); 
</script>
<?php 
	$num_rows_total = ($num_rows + $num_rows_2);
	if($num_rows_total =="" or $num_rows_total==0)echo $num_rows_total.' Ningún registro.';
	if($num_rows_total==1)echo $num_rows_total.' registro.';
	if($num_rows_total>=2)echo ($num_rows_total).' registros.';
	
?>
        <table cellspacing="1" id="tabla_venta_detalle" class="tablesorter">
            <thead>
                <tr>
                  <th align="right">CANT</th>
                  <th>UND</th>
                  <th>TIPO</th>
                  <th>ARTICULO</th>
                  <th>CATEGORIA | MARCA</th>
                  <th align="right" nowrap="nowrap">PRECIO UNIT</th>
                  <th align="right" title="DESCUENTO">DSCTO</th>
                  <th align="right" nowrap="nowrap" title="VALOR VENTA">VALOR VEN</th>
                  <th align="right" nowrap="nowrap" title="PRECIO VENTA">PREC VENTA</th>
                </tr>
            </thead>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){

						//$precio_venta=($dt1["tb_ventadetalle_valven"]+$dt1["tb_ventadetalle_igv"])+formato_moneda($dt1["tb_ventadetalle_des"]*1.18);
				
				?>
                        <tr>
                          <td align="right"><?php 
							echo $dt1['tb_cotizaciondetalle_can'];
							?></td>
                          <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                          <td>Producto</td>
                            <td>
							<?php 
							if($dt1['tb_cotizaciondetalle_nom']!="")
              {
                echo '<strong>'.$dt1['tb_cotizaciondetalle_nom'].'</strong>';
              }
              else
              {
                echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
              }
							//echo ' | '.$dt1['tb_presentacion_nom'];
							?></td>
                            <td><?php 
							echo $dt1['tb_categoria_nom'];
							echo ' | '.$dt1['tb_marca_nom'];
							?></td>
                            <td align="right"><?php echo $dt1['tb_cotizaciondetalle_preuni']?></td>
                            <td align="right"><?php
							$tipdes			=$dt1['tb_cotizaciondetalle_tipdes'];
							$descuento_linea=$dt1['tb_cotizaciondetalle_des'];
									if($tipdes == 1 and $descuento_linea!=0){										
										echo $descuento_linea."%";	
									}
									if($tipdes == 2 and $descuento_linea!=0){
										echo "S/. ".$descuento_linea;
									}									
								?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_cotizaciondetalle_valven'])?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_cotizaciondetalle_preunilin']*$dt1['tb_cotizaciondetalle_can'])?></td>
                        </tr>
                        <?php						
                	}
                mysql_free_result($dts1);
                ?>
                <?php
					while($dt2 = mysql_fetch_array($dts2)){
						$precio_venta=$dt2['tb_cotizaciondetalle_valven']+$dt2['tb_cotizaciondetalle_igv'];
						?>
                        <tr>
                          <td align="right"><?php echo $dt2['tb_cotizaciondetalle_can'];?></td>
                          <td>UN</td>
                          <td>Servicio</td>
                        	<td><?php
                          if($dt2['tb_cotizaciondetalle_nom']!="")
                          {
                            echo '<strong>'.$dt2['tb_cotizaciondetalle_nom'].'</strong>';
                          }
                          else
                          {
                            echo '<strong>'.$dt2['tb_servicio_nom'].'</strong>';
                          }
                          ?>
                            
                          </td>
                          <td><?php echo $dt2['tb_categoria_nom'];?></td>
                            <td align="right"><?php echo $dt2['tb_cotizaciondetalle_preuni']?></td>
                          	<td align="right"><?php
							$tipdes			=$dt2['tb_cotizaciondetalle_tipdes'];
							$descuento_linea=$dt2['tb_cotizaciondetalle_des'];
									if($tipdes == 1 and $descuento_linea!=0){										
										echo $descuento_linea."%";	
									}
									if($tipdes == 2 and $descuento_linea!=0){
										echo "S/. ".$descuento_linea;
									}									
								?></td>                                                        
                            <td align="right"><?php echo $dt2['tb_cotizaciondetalle_valven']?></td>
                            <td align="right"><?php echo formato_money($precio_venta)?></td>
              </tr>
              <?php						
                	}
                mysql_free_result($dts2);
                ?>
                        
                </tbody>
        </table>
        <br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
<!--      <td>-->
<!--          <div id="div_calcular_vuelto">-->
<!--              <fieldset style="width:200px">-->
<!--                  <legend>Calcular Vuelto</legend>-->
<!--                  <table>-->
<!--                      <tr>-->
<!--                          <td align="right"><label style="font-size:12px">Paga con:</label></td>-->
<!--                          <td align="right"><input type="text" name="txt_importe_cliente" id="txt_importe_cliente" size="10" style="text-align:right; font-size:14px" class="moneda2" /></td>-->
<!--                      </tr>-->
<!---->
<!---->
<!--                      <tr>-->
<!--                          <td align="right"><label for="lbl_ven_vuelto" style="font-size:12px">Vuelto:</label></td>-->
<!--                          <td align="right"><input type="text" name="lbl_ven_vuelto" id="lbl_ven_vuelto" readonly size="10" style="text-align:right; font-size:14px" class="moneda2" /></td>-->
<!--                      </tr>-->
<!--                  </table>-->
<!--              </fieldset>-->
<!--          </div>-->
<!--      </td>-->
    <td valign="top">
      <div style="margin-left:20px; margin-top:10px; float:right">
        <table border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td nowrap="nowrap"><strong>OPERACIONES GRATUITAS:</strong></td>
          <td align="right"><input name="txt_ven_opegra" type="text" id="txt_ven_opegra" style="text-align:right; font-size:14px" value="<?php echo formato_money($ope_gratuitas)?>" size="15" readonly>
          </td>
          </tr>
        </table>
      </div>
    </td>
    <td valign="top">
      <div style="margin-top:10px;">
      <table border="0" align="right" cellpadding="0" cellspacing="0">
        <tr>
          <td nowrap="nowrap"><label for="txt_ven_subtot" style="font-size:12px;margin-right: 10px;"><strong>SUB TOTAL VENTAS:</strong></label></td>
          <td align="right"><input name="txt_ven_subtot" type="text" id="txt_ven_subtot" style="text-align:right; font-size:14px" value="<?php echo formato_money($subtotal)?>" size="15" readonly></td>
        </tr>
        <tr>
          <td><label for="txt_ven_des" style="font-size:12px"><strong>DESCUENTOS:</strong></label></td>
          <td align="right"><input name="txt_ven_des" type="text" id="txt_ven_des" style="text-align:right; font-size:14px" value="<?php echo formato_money($des)?>" size="15" readonly></td>
        </tr>
        <tr>
          <td width="120"><label for="txt_ven_valven" style="font-size:12px"><strong>VALOR VENTA:</strong></label></td>
          <td width="140" align="right">
            <input name="txt_ven_valven" type="text" id="txt_ven_valven" style="text-align:right; font-size:14px" value="<?php echo formato_money($valven)?>" size="15" readonly></td>
        </tr>
        <tr>
          <td><label for="txt_ven_igv" style="font-size:12px"><strong>IGV:</strong></label>
        </td>
          <td align="right"><input name="txt_ven_igv" type="text" id="txt_ven_igv" style="text-align:right; font-size:14px" value="<?php echo formato_money($igv)?>" size="15" readonly></td>
        </tr>
        <?php /*?>
        <tr>
          <td><label for="txt_ven_otrcar" style="font-size:12px"><strong>OTROS CARGOS:</strong></label></td>
          <td align="right"><input name="txt_ven_otrcar" type="text" id="txt_ven_otrcar" style="text-align:right; font-size:14px" value="<?php echo formato_money($otr_car)?>" size="15" readonly></td>
        </tr>
        <tr>
          <td><label for="txt_ven_otrtri" style="font-size:12px"><strong>OTROS TRIBUTOS:</strong></label></td>
          <td align="right"><input name="txt_ven_otrtri" type="text" id="txt_ven_otrtri" style="text-align:right; font-size:14px" value="<?php echo formato_money($otr_tri)?>" size="15" readonly></td>
        </tr><?php */?>
        <tr>
          <td><label for="txt_ven_tot" style="font-size:12px"><strong>IMPORTE TOTAL:</strong></label></td>
          <td align="right"><input name="txt_ven_tot" type="text" id="txt_ven_tot" style="text-align:right; font-size:14px; font-weight:bold;" value="<?php echo formato_money($tot)?>" size="13" readonly></td>   
          
        </tr>
      </table>
      </div>
    </td>
  </tr>
</table>