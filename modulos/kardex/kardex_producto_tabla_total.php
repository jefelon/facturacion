<?php
session_start();
require_once ("../../config/Cado.php");	
require_once ("../formatos/formato.php");
require_once ("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once("../producto/cStock.php");
$oStock = new cStock();
?>
<script type="text/javascript">

$(function() {
	//$.tablesorter.defaults.widgets = ['zebra'];
	//$("#tabla_kardex").tablesorter({});
}); 
</script>
<style>
	div#div_tabla_kardex { margin: 0 0; }
	div#div_tabla_kardex table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_kardex table td, div#div_tabla_kardex table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_kardex table th { height:18px }
	div#div_tabla_kardex table td { height:17px }
</style>
<div id="div_tabla_kardex" class="ui-widget">
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
    <thead>
        <tr class="ui-widget-header">
            <th>CÓDIGO</th>
            <th>DESCRIPCIÓN</th>
            <th>TOTAL INGRESOS</th>
            <th>TOTAL SALIDAS</th>
            <th>TOTAL SALDO</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $dts1 = $oCatalogo->catalogo_compra_filtro('', '', '', '', '', '');
    while ($dt1 = mysql_fetch_array($dts1)) {
        ?>
        <tr>
        <td><?php echo $dt1['tb_presentacion_cod'] ?></td>
        <td><?php echo $dt1['tb_producto_nom'] ?></td>
        <?php
        $cat_precos = $dt1['tb_catalogo_precos'];
        $fecini = '01-01-2013';
        $fecfin = '';

        $dts2 = $oKardex->mostrar_kardex_por_producto($dt1['tb_catalogo_id'], $_SESSION['almacen_id'], fecha_mysql($fecini), fecha_mysql($fecfin));
        $cantidad_total = 0;
        $precio_promedio = 0;
        $costo_total = 0;
        $cantidad_total_entradas = 0;
        $cantidad_total_salidas = 0;
        $costo_total_entradas = 0;
        $costo_total_salidas = 0;
        while ($dt2 = mysql_fetch_array($dts2)) {
            $can = $dt2['tb_kardexdetalle_can'];
            $tip = $dt2['tb_kardex_tip'];//Verificando si es Entrada o Salida (1: ENTRADA | 2: SALIDA)

            if ($tip == 1) {
                $precos = $dt2['tb_kardexdetalle_cos'];

                if ($dt2['tb_tipoperacion_id'] == 1) $precos = $cat_precos;

                $subtotal = $can * $precos;
                $cantidad_total += $can;
                $cantidad_total_entradas += $can;
                $costo_total_entradas += $subtotal;
            }
            ?>
            <?php
            if ($tip == 2) {
                $precos = $dt2['tb_kardexdetalle_pre'];
                $subtotal = $can * $precos;
                $cantidad_total -= $can;
                $cantidad_total_salidas += $can;
                $costo_total_salidas += $subtotal;
            }
            if ($cantidad_total > 0) $precio_promedio = ($subtotal + $costo_total) / $cantidad_total;
            ?>

            <?php
        }
        mysql_free_result($dts2);
        ?>

        <td align="right"><strong><?php echo $cantidad_total_entradas ?></strong></td>
        <td align="right"><strong><?php echo $cantidad_total_salidas ?></strong></td>
        <td align="right">
            <strong><?php echo $stock_final = $cantidad_total_entradas - $cantidad_total_salidas ?></strong></td>
        </tr>
        <?php
    }
    mysql_free_result($dts1);
    ?>
    </tbody>
</table>
</div>
