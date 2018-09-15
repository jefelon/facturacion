<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once ("cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("cStock.php");
$oStock = new cStock();
require_once ("../notalmacen/cNotalmacen.php");
$oNotaAlmacen = new cNotalmacen();

$conf_stock=1;

require_once ("../formatos/formato.php");

?>

<script type="text/javascript">
$(function() {	
	$('.btn_act_stock').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
    $('.btn_ir').button({
        icons: {primary: "ui-icon-newwin"},
        text: false
    });
    $(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });
});
</script>
<style>
	div#tabla_pre_stock { margin: 0 0; }
	div#tabla_pre_stock table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#tabla_pre_stock table td, div#tabla_pre_stock table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#tabla_pre_stock table th { height:16px }
</style>   
		<table cellspacing="0">
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
					//fin
				?>
                        <tr>
                          <td colspan="6" valign="top">
                            <div id="tabla_pre_stock" class="ui-widget">
                              <table class="ui-widget ui-widget-content">
                                <tr class="ui-widget-header">
                                  <th>PRESENTACION</th>
                                  <th>STOCK MIN.</th>
                                  <th>ALMACEN</th>
                                  <th align="center">STOCK</th>
                                  <th align="center">LOTES</th>
                                  <th align="center">&nbsp;</th>
                                </tr>
						<?php
                        $dts=$oAlmacen->mostrar_por_empresa($_SESSION['empresa_id']);
                        $num_rows= mysql_num_rows($dts);
                        if($num_rows>=1){
                        while($dt = mysql_fetch_array($dts))
						{
							//stock
							$rws= $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$dt['tb_almacen_id']);
							$rw = mysql_fetch_array($rws);
								$stock_num=$rw['tb_stock_num'];
								$lote_num=$rw['tb_lote_exisact'];
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
                                  <td><?php echo $pre_nom=$dt1['tb_presentacion_nom']?></td>
                                  <td><?php echo $dt1['tb_presentacion_stomin'].' '.$unidad_base_nombre?></td>
                                  <td><?php echo $dt['tb_almacen_nom']?></td>
                                  <td align="right"><?php echo $stock_texto?></td>
                                  <td><?php echo $lote_num ?>
                                      <?php if($lote_num !=""){?>
                                      <a id="btn_cmb_lot_id" class="btn_ir" href="#" onClick="lote_form('',<?php echo $dt1['tb_presentacion_id'] ?>,<?php echo $dt['tb_almacen_id']?>)">Ver Lotes</a>
                                     <?php }?>
                                  </td>
                                  <td align="right">
                                  <?php if($conf_stock==1){
									   $pre_id = $dt1['tb_presentacion_id'];
                                       $alm_id = $dt['tb_almacen_id'];
                                       //Consultar catalogo_Id
                                       $rs2 = $oCatalogoproducto->presentacion_unidad_base($pre_id);
                                       $dt2 = mysql_fetch_array($rs2);
                                       $cat_id = $dt2['tb_catalogo_id'];
                                       mysql_free_result($rs2);

                                       $rs1 = $oNotaAlmacen->consultar_existencia_saldo_inicial($cat_id,$alm_id);
                                       $num_rows1 = mysql_num_rows($rs1);
                                       mysql_free_result($rs1);
                                       if($num_rows1>0){
																		   
								   }else{
								   	/*
									?>
                                  <a class="btn_act_stock" onClick="stock_form('<?php echo $action_stock?>','<?php echo $dt1['tb_presentacion_id']?>','<?php echo $dt['tb_almacen_id']?>','<?php echo $stock_id?>')">Actualizar Stock</a>
                                  <?php  
                                  */
								   }
								  }?>
                                  </td>
                                </tr>
                                <?php
			  }
			  mysql_free_result($dts);
		  }
		  else
		  {
			  $action_stock='insertar';
		  }
          ?>       
                              </table>
  </div>                          </td>
                        </tr>
                        <tr>
                          <td colspan="6">&nbsp;</td>
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