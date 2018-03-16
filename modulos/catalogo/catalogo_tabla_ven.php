<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");

require_once ("../catalogo/cst_producto.php");

//fecha inventario

$fecini='01-01-2013';
$fecfin=$_POST['inv_fec'];

//seleccion de las categorias
if(isset($_POST['pro_cat']) and $_POST['pro_cat']>0)
{
	$dc=$_POST['pro_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['pro_cat']);
	$num_rows2= mysql_num_rows($dts2);
	if($num_rows2>0){
		while($dt2 = mysql_fetch_array($dts2)){
			
			$dc.=', '.$dt2['tb_categoria_id'];
			
			$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
			$num_rows3= mysql_num_rows($dts3);
			if($num_rows3>0){
				while($dt3 = mysql_fetch_array($dts3)){
					$dc.=', '.$dt3['tb_categoria_id'];			
				}
			mysql_free_result($dts3);
			}//fin nivel 3
					
		}
	mysql_free_result($dts2);
	}//fin nivel 2

//echo $dc;			
}

//seleccion de los atributos
$atr_array=$_POST['atr_ids'];
if(is_array($atr_array)){
	$cadena_atr = implode(',',$atr_array);
}


if($_POST['alm_id']>0)
{
	$dts1=$oCatalogo->catalogo_filtro($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['alm_id'],$cadena_atr,$_POST['verven'],$_POST['vercom'],$_POST['unibas']);
$num_rows= mysql_num_rows($dts1);
}
else
{
	$num_rows=0;
}

?>
<script type="text/javascript">

$(document).ready(function() {
	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	$('.btn_info').button({
		icons: {primary: "ui-icon-info"},
		text: false
	});
	
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			//4: {sorter: 'shortDate' }
			10: {sorter: false }
		},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[2,0],[1,0],[0,0]]
		<?php }?>
    });


}); 
</script>
        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <!--<th>CODIGO</th>-->
                    <th>NOMBRE</th>
                    <th>MARCA</th>
                    <th>CATEGORIA</th>
                    <th>UNID</th>
                    <th align="right" nowrap>P. COSTO PROM S/.</th>
                    <th align="right" nowrap>UTI %</th>
                    <th align="right" nowrap>P.  VENTA S/.</th>
                  <th align="right">STOCK</th>
                  <!--<th align="right">DETALLE</th>-->
                    <th align="right">&nbsp;</th>
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
						
						//STOCK
						$stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);
//						
//						//COSTOS
//						
						$costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin),$stock_kardex,$dt1['tb_catalogo_precos'],$dt1['tb_catalogo_precosdol'],$_SESSION['empresa_id']);
//						
						$costo_ponderado_soles=$costo_ponderado_array['soles'];
						//$costo_ponderado_dolares=$costo_ponderado_array['dolares'];
						
						$precio_venta1=$dt1['tb_catalogo_preven'];
						if($precio_venta1>0)$utilidad1=(1-($costo_ponderado_soles/$precio_venta1))*100;
					?>
                        <tr>
                          <!--<td><?php //echo $dt1['tb_presentacion_cod']?></td>-->
                            <td>
                            <span style="">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                            </td>
                            <td><?php echo $dt1['tb_marca_nom']?></td>
                            <td><?php echo $dt1['tb_categoria_nom']?></td>
                            <td title="<?php echo $dt1['tb_unidad_nom']?>">
							<span style="">
							<?php echo $dt1['tb_unidad_abr']?>
                            </span>
                            </td>
                            <td align="right"><?php if($costo_ponderado_soles!=0)echo formato_money($costo_ponderado_soles)?></td>
                            <td align="right"><?php echo formato_money($utilidad1)?></td>
                            <td align="right"><?php if($dt1['tb_catalogo_preven']!=0)echo $dt1['tb_catalogo_preven']?></td>
                            <td align="right">
                            <span <?php if($dt1['tb_catalogo_unibas']==1 and $stock_unidad<=$dt1['tb_presentacion_stomin']){?> style="color:#F00; font-weight: bold;"<?php }?>>
							<?php echo $stock_unidad?>
                            </span>
                            <input name="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>" id="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>"  type="hidden" value="<?php echo $stock_unidad?>">
                            </td>
                            <!--<td align="right">
							<?php /*if($dt1['tb_catalogo_unibas']==1 and $stock_unidad<=$dt1['tb_presentacion_stomin'])
							{
								echo "Por debajo de stock mínimo.";
							}*/
							?></td>-->
                            <td align="right" nowrap>
                            <?php /*?><a class="btn_editar" href="#editar" onClick="producto_form('editar','<?php echo $dt1['tb_producto_id']?>')">Editar Producto</a><?php */?>
                            <a class="btn_info" href="#info" onClick="producto_info('<?php echo $dt1['tb_producto_id']?>')">Información</a>
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
                  <td colspan="8">TOTAL</td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="9"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
