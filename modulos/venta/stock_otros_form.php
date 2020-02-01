<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once ("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../producto/cStock.php");
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
        $('.btn_stock_solicitar').button({
            // icons: {primary: "ui-icon-pencil"},
            // text: true
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
<table cellspacing="0" width="100%">
    <?php
    $dts0=$oPresentacion->mostrar_por_catalogo($_POST['cat_id']);
    $dat= mysql_fetch_array($dts0);
    $pro_id = $dat['tb_producto_id'];

    $dts1=$oPresentacion->mostrar_por_producto($pro_id);
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
                                <th>ALMACEN</th>
                                <th align="center">STOCK</th>
<!--                                <th align="center">Acción</th>-->
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
                                    $idstock=$rw['tb_stock_id'];
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
                                        <td><?php echo $dt['tb_almacen_nom']?></td>
                                        <td align="right"><?php echo $stock_texto?></td>
<!--                                        <td align="right">-->
<!--                                            <a class="btn_stock_solicitar" href="#" onClick="solicitar_stock()">Pedir</a>-->
<!--                                        </td>-->
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