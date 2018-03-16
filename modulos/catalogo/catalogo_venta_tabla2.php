<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();

$igv_dato=0.18;

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");



$dts1=$oCatalogo->catalogo_venta_filtro(1,'','','','');
$num_rows= mysql_num_rows($dts1);
?>

        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <th>CODIGO</th>
                  <th>NOMBRE</th>
                    <th>PRESENTACION</th>
                    <th>UNIDAD</th>
                    <th align="right" nowrap>PRECIO S/.</th>
                  <th align="right">STOCK</th>
                    <th align="center">IGV</th>
                  <th width="110" align="center">CANTIDAD</th>
                  <th width="50">&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
						$stock=$dt1['tb_stock_num'];
						
								$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
								$st_res=$stock%$dt1['tb_catalogo_mul'];
								
								if($st_res!=0){
									//$stock_unidad="$st_uni + r$st_res";
									$stock_unidad="$st_uni";
								} else{
									$stock_unidad="$st_uni";
								}

					?>
                        <tr>
                          <td><?php echo $dt1['tb_presentacion_cod']?></td>
                          <td>
                            <span class="tip-producto" id="../producto/producto_detalle.php?pro_id=<?php echo $dt1['tb_producto_id']?>">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                            </td>
                            <td>
							<span style="">
							<?php echo $dt1['tb_presentacion_nom']?>
                            </span>
                            </td>
                            <td title="<?php echo $dt1['tb_unidad_nom']?>">
							<span style="">
							<?php echo $dt1['tb_unidad_abr']?>
                            </span>
                            </td>
                            <td align="right">
                            <span style="font-weight: bold;">
							<?php echo $dt1['tb_catalogo_preven']?>
                            </span>
                            <!--<input name="txt_cat_preven_<?php //echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_preven_<?php //echo $dt1['tb_catalogo_id']?>" value="<?php //echo $dt1['tb_catalogo_preven']?>" size="10" maxlength="8" style="text-align:right" readonly>-->
                            <input name="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" type="hidden" id="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" value="<?php echo $dt1['tb_catalogo_preven']?>">
                    </td>
                            <td align="right">
                            <span style="">
							<?php echo $stock_unidad?>
                            </span>
                            <input name="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>" id="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>"  type="hidden" value="<?php echo $stock_unidad?>">
                            </td>
                            <td align="center"><input name="chk_cat_igv_<?php echo $dt1['tb_catalogo_id']?>" type="checkbox" id="chk_cat_igv_<?php echo $dt1['tb_catalogo_id']?>" value="1" <?php if($dt1['tb_catalogo_igvven']==1) echo 'checked'?> disabled>
                            <input name="hdd_cat_igvven_<?php echo $dt1['tb_catalogo_id']?>" type="hidden" id="hdd_cat_igvven_<?php echo $dt1['tb_catalogo_id']?>" value="<?php echo $dt1['tb_catalogo_igvven']?>">
                            </td>
                            <td align="center">
                            <input name="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" class="cantidad" value="1" size="5" maxlength="6" style="text-align:right">
                            <a class="btn_mas" href="#mas" onClick="cantidad('mas','<?php echo $dt1['tb_catalogo_id']?>')">Aumentar</a>
                            <a class="btn_menos" href="#menos" onClick="cantidad('menos','<?php echo $dt1['tb_catalogo_id']?>')">Disminuir</a>
                            </td>
                            <td align="center">
                            <?php if($stock_unidad!=0){?>
                            
                            <a class="btn_agregar" href="#" onClick="venta_car('agregar','<?php echo $dt1['tb_catalogo_id']?>')">Agregar</a>
                            <?php }?>
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
                  <td><?php echo $num_rows.' registros'?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
        </table>
