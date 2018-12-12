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


	$fecini='01-01-2013';
	$fecfin='';
	
	$dts1 = $oKardex->mostrar_kardex_por_producto($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));	
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
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
    <thead>
    	<tr class="ui-widget-header">
        	<th colspan="4">DOCUMENTO</th>            
            <th rowspan="2">TIPO DE OPERACI&Oacute;N</th>
            <th colspan="1">ENTRADAS</th>
            <th colspan="1">SALIDAS</th>
            <th colspan="1">SALDO FINAL</th>
        </tr>
        <tr class="ui-widget-header">
            <th>FECHA</th>
            <th>CÓDIGO</th>
            <th>TIPO DE DOCUMENTO</th>
            <th>NUMERO DE DOCUMENTO</th>
            <!--TIPO OPERACIÓN-->
            <th>CANTIDAD</th>
            <th>CANTIDAD</th>
            <th>CANTIDAD</th>
                    
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
			
            while($dt1 = mysql_fetch_array($dts1)){
            	if($dt1['tb_tipoperacion_id']=='1')$operacion='STOCK INICIAL';
            	if($dt1['tb_tipoperacion_id']=='2')$operacion='COMPRA';
            	if($dt1['tb_tipoperacion_id']=='3')$operacion='VENTA';
            	//if($dt1['tb_tipoperacion_id']=='9')$operacion='NOTA DE ALMACEN';
            	if($dt1['tb_tipoperacion_id']=='4')$operacion='TRASPASO';
            	if($dt1['tb_tipoperacion_id']=='5')$operacion='NOTA DE VENTA';
            	if($dt1['tb_tipoperacion_id']=='11')$operacion='NOTA DE CREDITO';
			?>
                <tr>
                    <td nowrap="nowrap" title="<?php echo 'Registrado: '.mostrarFechaHoraH($dt1['tb_kardex_reg'])?>"><?php echo mostrarFecha($dt1['tb_kardex_fec'])?></td>
                    <td nowrap="nowrap"><?php echo $dt1['tb_kardex_cod']?></td>
					<td><?php echo $dt1['tb_documento_nom']?></td>
    				<td nowrap="nowrap"><?php echo $dt1['tb_kardex_numdoc']?></td>                	
                    <td><?php echo $dt1['tb_kardex_des'] ?></td>
                    <?php 					
						$can = $dt1['tb_kardexdetalle_can'];						
						$tip = $dt1['tb_kardex_tip'];//Verificando si es Entrada o Salida (1: ENTRADA | 2: SALIDA)
						
						if($tip == 1){							
							$precos = $dt1['tb_kardexdetalle_cos'];
							
							if($dt1['tb_tipoperacion_id']==1)$precos=$cat_precos;
							
							$subtotal = $can*$precos;
							$cantidad_total += $can;
							$cantidad_total_entradas += $can;
							$costo_total_entradas += $subtotal;
							}?>
                        	<td align="right" nowrap="nowrap"><?php
							 if($tip == 1)echo $can;
							 if($dt1['tb_tipoperacion_id']==1){/*
							 ?>
                             <a class="btn_act_stock" onClick="kardex_form('actualizar_saldo_inicial','<?php echo $dt1['tb_kardexdetalle_id']?>','<?php echo $dt['tb_almacen_id']?>','<?php echo $stock_id?>')">Actualizar</a>
                             <?php */}?>
                             </td>
<?php														
						
						if($tip == 2){							
							$precos = $dt1['tb_kardexdetalle_pre'];
							$subtotal = $can*$precos;
							$cantidad_total -= $can;
							$cantidad_total_salidas += $can;
							$costo_total_salidas += $subtotal;}?>

                  <td align="right"><?php if($tip == 2)echo $can?></td>
							<?php								
									
						if($cantidad_total>0)$precio_promedio = ($subtotal+$costo_total)/$cantidad_total;			
					?>
                  <td align="right"><?php echo $cantidad_total?></td>
                   
      </tr>                                                            
                <?php
            }
			mysql_free_result($dts1);
			?>
            <tr>
                <td colspan="5"><strong>TOTAL</strong></td>                    
<td align="right"><strong><?php echo $cantidad_total_entradas?></strong></td>
             
                <td align="right"><strong><?php echo $cantidad_total_salidas?></strong></td>
                <td align="right"><strong><?php echo $stock_final=$cantidad_total_entradas-$cantidad_total_salidas?></strong></td>
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