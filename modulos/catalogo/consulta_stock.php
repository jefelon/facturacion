<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../producto/cStock.php");
$oStock = new cStock();

$conf_stock=1;

require_once ("../formatos/formato.php");


$dts= $oCatalogoproducto->presentacion_catalogo($_POST['cat_id']);
$dt = mysql_fetch_array($dts);
	$pro_nom=$dt['tb_producto_nom'];
	$pre_nom=$dt['tb_presentacion_nom'];
	$pre_id	=$dt['tb_presentacion_id'];
	$sto_num=$dt['tb_stock_num'];
	$cat_mul=$dt['tb_catalogo_mul'];
	$nombre_articulo=$pro_nom.' '.$pre_nom;
mysql_free_result($dts);
?>

<script type="text/javascript">
$(function() {	
	$('.btn_act_stock').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
});
</script>
<style>
	div#tabla_pre_stock { margin: 0 0; }
	div#tabla_pre_stock table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#tabla_pre_stock table td, div#tabla_pre_stock table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#tabla_pre_stock table th { height:16px; text-align:left }
</style> 
<div>
<?php echo $nombre_articulo?>
</div>
<hr> 
		<table cellspacing="0" width="100%">
            <?php
			$dts1=$oEmpresa->mostrarTodos();
			?>
            <tbody>
            	<?php
				while($dt1 = mysql_fetch_array($dts1))
				{
					if($dt1['tb_empresa_id']==1 or $dt1['tb_empresa_id']==2)
					{
				?>		<tr class="ui-widget-header">
                          <td colspan="6" height="18px"><?php echo $dt1['tb_empresa_razsoc']?></td>
                        </tr>
                	
                        <tr>
                          <td colspan="6" valign="top">
                            <div id="tabla_pre_stock" class="ui-widget">
                              <table class="ui-widget ui-widget-content">
                                <!--<tr class="ui-widget-header">
                                  <th>ALMACEN</th>
                                  <th align="center">STOCK</th>
                                </tr>-->
						<?php
                        $dts=$oAlmacen->mostrar_por_empresa($dt1['tb_empresa_id']);
                        $num_rows= mysql_num_rows($dts);
                        while($dt = mysql_fetch_array($dts))
						{
							//stock
							$rws= $oStock->stock_por_presentacion($pre_id,$dt['tb_almacen_id']);
							$rw = mysql_fetch_array($rws);
								$stock_num=$rw['tb_stock_num'];
								
								if($stock_num==""){
									$stock_texto='<span title="Sin Dato">S/D</span>';
									$action_stock='insertar';
								}
								else
								{
									$stock_texto=$stock_num.' '.$unidad_base_nombre;
									$action_stock='editar';
									$stock_id=$rw['tb_stock_id'];
								}
							mysql_free_result($rws);
							//fin
                        ?>
                                <tr>
                                  <th><?php echo $dt['tb_almacen_nom']?></th>
                                  <td align="right" width="70px"><?php echo $stock_texto?></td>
                                </tr>
                                <?php
					  }
					  mysql_free_result($dts);
          ?>       
                              </table>
  </div>                          </td>
                        </tr>
                        <tr>
                          <td colspan="6">&nbsp;</td>
                        </tr>
                <?php
					}
                }
                mysql_free_result($dts1);
                ?>
            </tbody>
        </table>