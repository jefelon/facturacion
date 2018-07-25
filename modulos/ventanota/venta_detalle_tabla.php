<?php
require_once ("../../config/Cado.php");
require_once ("cVentanota.php");
$oVentanota = new cVentanota();

require_once ("../formatos/formato.php");

$dts= $oVentanota->mostrarUno($_POST['ven_id']);
$dt = mysql_fetch_array($dts);
	$fec	=mostrarFecha($dt['tb_venta_fec']);
	$doc_id	=$dt['tb_documento_id'];
	$numdoc	=$dt['tb_venta_numdoc'];
	$cli_id	=$dt['tb_cliente_id'];
	$valven	=$dt['tb_venta_valven'];
	$igv	=$dt['tb_venta_igv'];
	$des	=$dt['tb_venta_des'];
	$tot	=$dt['tb_venta_tot'];
mysql_free_result($dts);

$dts1=$oVentanota->mostrar_venta_detalle($_POST['ven_id']);
$num_rows= mysql_num_rows($dts1);

$dts2=$oVentanota->mostrar_venta_detalle_servicio($_POST['ven_id']);
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
						$precio_venta=$dt1['tb_ventadetalle_valven']+$dt1['tb_ventadetalle_igv'];
						?>
                        <tr>
                          <td align="right"><?php 
							echo $dt1['tb_ventadetalle_can'];
							?></td>
                          <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                          <td>Producto</td>
                            <td>
							<?php 
							echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
							//echo ' | '.$dt1['tb_presentacion_nom'];
							?></td>
                            <td><?php 
							echo $dt1['tb_categoria_nom'];
							echo ' | '.$dt1['tb_marca_nom'];
							?></td>
                            <td align="right"><?php echo $dt1['tb_ventadetalle_preuni']?></td>
                            <td align="right"><?php
							$tipdes			=$dt1['tb_ventadetalle_tipdes'];
							$descuento_linea=$dt1['tb_ventadetalle_des']; 
									if($tipdes == 1 and $descuento_linea!=0){										
										echo $descuento_linea."%";	
									}
									if($tipdes == 2 and $descuento_linea!=0){
										echo "S/. ".$descuento_linea;
									}									
								?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_ventadetalle_valven'])?></td>
                            <td align="right"><?php echo formato_money($precio_venta)?></td>
                        </tr>
                        <?php						
                	}
                mysql_free_result($dts1);
                ?>
                <?php
					while($dt2 = mysql_fetch_array($dts2)){
						$precio_venta=$dt2['tb_ventadetalle_valven']+$dt2['tb_ventadetalle_igv'];
						?>
                        <tr>
                          <td align="right"><?php echo $dt2['tb_ventadetalle_can'];?></td>
                          <td>UN</td>
                          <td>Servicio</td>
                        	<td><?php echo '<strong>'.$dt2['tb_servicio_nom'].'</strong>'?></td>
                            <td><?php echo $dt2['tb_categoria_nom'];?></td>
                            <td align="right"><?php echo $dt2['tb_ventadetalle_preuni']?></td>
                          	<td align="right"><?php
							$tipdes			=$dt2['tb_ventadetalle_tipdes'];
							$descuento_linea=$dt2['tb_ventadetalle_des']; 
									if($tipdes == 1 and $descuento_linea!=0){										
										echo $descuento_linea."%";	
									}
									if($tipdes == 2 and $descuento_linea!=0){
										echo "S/. ".$descuento_linea;
									}									
								?></td>                                                        
                            <td align="right"><?php echo $dt2['tb_ventadetalle_valven']?></td>
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
    <td>&nbsp;</td>
    <td valign="top"><div style="margin-left:20px; margin-top:10px; float:right">
    <?php /*?><table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td><label for="txt_ven_subtot" style="font-size:14px"><strong>SUB TOTAL</strong></label></td>
        <td align="right"><input name="txt_ven_subtot" type="text" id="txt_ven_subtot" value="<?php echo formato_money($sub_total)?>" readonly style="text-align:right; font-size:14px"></td>
      </tr>
      <tr>
        <td width="110"><label style="font-size:14px"><strong>DESCUENTO</strong></label></td>
        <td width="190" align="right"><input type="text" name="txt_ven_des" id="txt_ven_des" value="<?php echo formato_money($des_total)?>" style="text-align:right; font-size:14px" readonly></td>
      </tr>
    </table><?php */?>
    </div></td>
    <td valign="top"><div style="margin-right:53px; margin-top:10px;">
<table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td width="120"><label for="txt_ven_valven" style="font-size:12px"><strong>VALOR VENTA</strong></label></td>
    <td width="140" align="right">
      <input name="txt_ven_valven" type="text" id="txt_ven_valven" style="text-align:right; font-size:14px" value="<?php echo formato_money($valven)?>" size="15" readonly></td>
  </tr>
  <tr>
    <td><label for="txt_ven_igv" style="font-size:12px"><strong>IGV</strong></label></td>
    <td align="right"><input name="txt_ven_igv" type="text" id="txt_ven_igv" style="text-align:right; font-size:14px" value="<?php echo formato_money($igv)?>" size="15" readonly></td>
  </tr>
  <tr>
    <td><label for="txt_ven_tot" style="font-size:12px"><strong>TOTAL</strong></label></td>
    <td align="right"><input name="txt_ven_tot" type="text" id="txt_ven_tot" style="text-align:right; font-size:14px; font-weight:bold;" value="<?php echo formato_money($tot)?>" size="13" readonly></td>   
    
  </tr>
</table>
</div></td>
  </tr>
</table>