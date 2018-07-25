<?php
require_once ("../../config/Cado.php");
require_once ("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();

require_once ("../formatos/formato.php");

$dts1=$oCatalogoproducto->presentacion_catalogo_producto($_POST['pro_id']);
$num_rows= mysql_num_rows($dts1);

?>
<script type="text/javascript">

$(function() {
	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	$('.btn_info').button({
		icons: {primary: "ui-icon-info"},
		text: false
	});
	
	/*$("#tabla_producto_catalogo").tablesorter({
		widgets: ['zebra'],
		widthFixed: true,
		headers: {
			//4: {sorter: 'shortDate' }
			10: {sorter: false }
		},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });*/


}); 
</script>
        <table cellspacing="1" id="tabla_producto_catalogo" class="tablesorter">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>PRESENTACION</th>
                    <th title="UNIDAD">UND</th>
                    <th align="right" title="PRECIO UNITARIO DE COMPRA">PRECIO UNIT COMPRA</th>
                    <th align="right" title="PRECIO COSTO">PRECIO COSTO</th>
                    <th align="right">PRECIO VENTA</th>
                    <th align="right" title="MODIFICACION">MODIFICACION</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
						$stock=$dt1['tb_stock_num'];
							
							$mod_pro=mostrarFechaHora($dt1['tb_producto_mod']);
							
								$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
								$st_res=$stock%$dt1['tb_catalogo_mul'];
								
								if($st_res!=0){
									//$stock_unidad="$st_uni + r$st_res";
									$stock_unidad="$st_uni";
								} else{
									$stock_unidad="$st_uni";
								}

					?>
                        <tr class="even">
                          <td title="<?php echo 'PRO ID= '.$dt1['tb_producto_id'].', CAT ID= '.$dt1['tb_catalogo_id']?>">
                            <span style="">
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
                            <td align="right"><?php if($dt1['tb_catalogo_preunicom']!=0)echo $dt1['tb_catalogo_preunicom']?></td>
                            <td align="right"><?php if($dt1['tb_catalogo_precos']!=0)echo $dt1['tb_catalogo_precos']?></td>
                            <td align="right"><?php if($dt1['tb_catalogo_preven']!=0)echo $dt1['tb_catalogo_preven']?></td>
                            <td align="right"><?php echo mostrarFechaHora($dt1['tb_catalogo_mod'])?></td>
                        </tr>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <?php
				}
				?>
        </table>
</br>
<?php echo 'Producto Modificado el: '.$mod_pro.''?>