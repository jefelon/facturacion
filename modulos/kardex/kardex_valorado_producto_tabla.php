<?php
session_start();
require_once ("../../config/Cado.php");	
require_once ("../formatos/formato.php");
require_once ("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../producto/cStock.php");
$oStock = new cStock();
require_once ("../catalogo/cst_producto.php");

	$rs = $oKardex->mostrar_datos_producto($_POST['cat_id']);
	$dt = mysql_fetch_array($rs);			
			$alm = $dt['tb_almacen_nom'];//establecimiento			
			$cod = $dt['tb_presentacion_cod'];//codigo de la existencia			
			$cat = $dt['tb_categoria_nom'];//tipo
			$nom = $dt['tb_producto_nom'];//descripcion
			$cat_precos = $dt['tb_catalogo_precos'];//descripcion
		mysql_free_result($rs);
	
	//catalogo
		$rs = $oCatalogoproducto->presentacion_catalogo_stock_almacen($_POST['cat_id'], $_POST['alm_id']);
		$dt = mysql_fetch_array($rs);
		$sto_id = $dt['tb_stock_id'];
		$pre_id = $dt['tb_presentacion_id'];
		$stock_actual = $dt['tb_stock_num'];

		$precos		=$dt['tb_catalogo_precos'];
		$preven		=$dt['tb_catalogo_preven'];
		$precosdol	=$dt['tb_catalogo_precosdol'];
		$utilidad	=$dt['tb_catalogo_uti'];
			
		mysql_free_result($rs);


	$fecini='01-01-2013';;
	$fecfin=$_POST['fec_fin'];
	
	$dts1 = $oKardex->mostrar_kardex_por_producto($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));

    $firstrow = mysql_fetch_assoc($dts1);
    mysql_data_seek($dts1, 0);

	$num_rows_1 = mysql_num_rows($dts1);

	if($num_rows_1 > 0){
	}
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
<table id="tabla_kardex_valorado" border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
    <thead>
    	<tr class="ui-widget-header">
        	<th colspan="4">DOCUMENTO</th>
            <th rowspan="2">TIPO DE OPERACI&Oacute;N</th>
            <th colspan="3">ENTRADAS</th>
            <th colspan="3">SALIDAS</th>
            <th colspan="3">SALDO FINAL</th>
        </tr>
        <tr class="ui-widget-header">
            <th>FECHA</th>
            <th>CÓDIGO</th>
            <th>TIPO DE DOCUMENTO</th>
            <th>NUMERO DE DOCUMENTO</th>
            <!--TIPO OPERACIÓN-->
            <th>CANTIDAD</th>
            <th>COSTO UNITARIO</th>
            <th>COSTO TOTAL</th>

            <th>CANTIDAD</th>
            <th>COSTO UNITARIO</th>
            <th>COSTO TOTAL</th>

            <th>CANTIDAD</th>
            <th>COSTO UNITARIO</th>
            <th>COSTO TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <?php
			$cantidad_total = 0;
			$precio_promedio = 0;
			$costo_total = 0;
			$cantidad_total_entradas = 0;
			$cantidad_total_salidas = 0;
			$costo_total_entradas = 0;
			$costo_total_salidas = 0;
			$mes_empezar=00;

            $d_ini = strtotime($_POST['fec_ini']);
            while($dt1 = mysql_fetch_array($dts1)) {

                $d_kar_fec = strtotime($dt1['tb_kardex_fec']);

                if ($d_kar_fec >= $d_ini) {
                    if ($dt1['tb_tipoperacion_id'] == '1') $operacion = 'STOCK INICIAL';
                    if ($dt1['tb_tipoperacion_id'] == '2') $operacion = 'COMPRA';
                    if ($dt1['tb_tipoperacion_id'] == '3') $operacion = 'VENTA';
                    //if($dt1['tb_tipoperacion_id']=='9')$operacion='NOTA DE ALMACEN';
                    if ($dt1['tb_tipoperacion_id'] == '4') $operacion = 'TRASPASO';
                    if ($dt1['tb_tipoperacion_id'] == '5') $operacion = 'NOTA DE VENTA';
                    if ($dt1['tb_tipoperacion_id'] == '11') $operacion = 'NOTA DE CREDITO';
                    ?>


                    <tr>
                        <td nowrap="nowrap"
                            title="<?php echo 'Registrado: ' . mostrarFechaHoraH($dt1['tb_kardex_reg']) ?>"><?php echo mostrarFecha($dt1['tb_kardex_fec']) ?></td>
                        <td nowrap="nowrap"><?php if (9 != $dt1['tb_tipoperacion_id']) {
                                echo $dt1['tb_kardex_cod'];
                            } ?></td>
                        <td><?php if (9 != $dt1['tb_tipoperacion_id']) {
                                echo $dt1['tb_documento_nom'];
                            } ?></td>
                        <td nowrap="nowrap"><?php if (9 != $dt1['tb_tipoperacion_id']) {
                                echo $dt1['tb_kardex_numdoc'];
                            } ?></td>
                        <td><?php
                                echo $dt1['tb_kardex_des']; ?>
                        </td>
                        <?php
                        $can = $dt1['tb_kardexdetalle_can'];
                        $tip = $dt1['tb_kardex_tip'];//Verificando si es Entrada o Salida (1: ENTRADA | 2: SALIDA)

                        if ($tip == 1){
                            $precos = $dt1['tb_kardexdetalle_cos'];
                            $subtotal = $can * $precos;
                            $cantidad_total += $can;
                            $cantidad_total_entradas += $can;
                            $costo_total_entradas += $subtotal;
                        } ?>
                        <td align="right" nowrap="nowrap"><?php
                            if ($tip == 1) {
                                if (9 != $dt1['tb_tipoperacion_id']) {
                                    echo formato_decimal($can, 0);
                                }
                            }
                             ?>
                        </td>
                        <td align="right" nowrap="nowrap"><?php
                            if ($tip == 1) {
                                    echo formato_decimal($dt1['tb_kardexdetalle_cos'], 2);
                            } ?>
                        </td>
                        <td align="right" nowrap="nowrap"><?php
                            if ($tip == 1) {
                                echo formato_decimal($dt1['tb_kardexdetalle_cos'] * $can, 2);
                            } ?>
                        </td>
                        <?php

                        if ($tip == 2) {
                            $precos = $dt1['tb_kardexdetalle_pre'];
                            $subtotal = $can * $precos;
                            $cantidad_total -= $can;
                            $cantidad_total_salidas += $can;
                            $costo_total_salidas += $subtotal;
                        } ?>

                        <td align="right"><?php if ($tip == 2) echo $can ?></td>

                        <td align="right" nowrap="nowrap"><?php
                            if ($tip == 2) {
                                    echo formato_decimal($precos, 2);
                            } ?>
                        </td>
                        <td align="right" nowrap="nowrap"><?php
                            if ($tip == 2) {
                                    echo formato_decimal($precos * $can, 2);
                            } ?>
                        </td>
                        <?php

                        $precio_promedio = ($costo_total_entradas-$costo_total_salidas) / $cantidad_total;
                        ?>
                        <td align="right"><?php echo $cantidad_total ?></td>
                        <td align="right">
                            <?php if ($cantidad_total == 0) {
                                echo formato_decimal(0.000, 2);
                            } else {
                                echo formato_decimal($precio_promedio, 2);
                            } ?>
                        </td>
                        <td align="right"><?php echo formato_decimal($costo_total_entradas-$costo_total_salidas, 2); ?></td>

                    </tr>
                     <?php if (date("m",strtotime($dt1['tb_kardex_reg'])) != $mes_empezar) {
                        $mes_empezar=date("m",strtotime($dt1['tb_kardex_reg']));
                         ?>
                    <tr>
                        <td nowrap="nowrap"></td>
                        <td nowrap="nowrap"></td>
                        <td></td>
                        <td nowrap="nowrap"></td>
                        <td>
                            Stock Inicial - Mes - <?php echo mostrarDiaMesAnio(2, $dt1['tb_kardex_fec']); ?>
                        </td>

                        <td align="right" nowrap="nowrap">
                        </td>
                        <td align="right" nowrap="nowrap">
                        </td>
                        <td align="right" nowrap="nowrap">
                        </td>


                        <td align="right"></td>

                        <td align="right" nowrap="nowrap">
                        </td>
                        <td align="right" nowrap="nowrap">
                        </td>
                        <td align="right"><?php echo $cantidad_total ?></td>
                        <td align="right">
                            <?php echo formato_decimal($precio_promedio, 2); ?>
                        </td>
                        <td align="right"><?php echo formato_decimal($costo_total_entradas-$costo_total_salidas, 2); ?></td>

                    </tr>
                    <?php
                    }

            }


            }
			mysql_free_result($dts1);
			?>
            <tr>
                <td colspan="5"><strong>TOTAL</strong></td>                    
                <td align="right"><strong><?php echo $cantidad_total_entradas?></strong></td>
                <td align="right"><strong></strong></td>
                <td align="right"><strong></strong></td>
                <td align="right"><strong><?php echo $cantidad_total_salidas?></strong></td>
                <td align="right"><strong></strong></td>
                <td align="right"><strong></strong></td>
                <td align="right"><strong><?php echo $stock_final=$cantidad_total_entradas-$cantidad_total_salidas?></strong></td>
                <td align="right"><strong></strong></td>
                <td align="right"><strong></strong></td>
                <td align="right">&nbsp;</td>
            </tr>
    </tbody>
</table>
</div>
<?php
if($_SESSION['usuariogrupo_id']==2){
	//actualización automatica del stock resultante
	if($stock_actual!=$stock_final and $sto_id>0 and $stock_final>=0){
		echo 'Se actualizó stock.';
			$oStock->modificar(
				$sto_id,
				$stock_final
			);
	}
}
?>