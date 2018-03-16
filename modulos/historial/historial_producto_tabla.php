<?php
session_start();
require_once ("../../config/Cado.php");	
require_once ("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once ("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();
require_once ("../historial/cHistorial.php");
$oHistorial = new cHistorial();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../catalogo/cst_producto.php");
require_once ("../formatos/formato.php");

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

	
$fecini='01-01-2016';
$fecfin=date('d-m-Y');

?>
<script type="text/javascript">

$(function() {

}); 
</script>

<style>
	div.div_tabla { margin: 0 0; }
	div.div_tabla table { margin: 0 0; border-collapse: collapse; width: 90%; }
	div.div_tabla table td, div.div_tabla table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div.div_tabla table th { height:18px }
	div.div_tabla table td { height:17px }
</style>

<div id="div_notalmacen_detalle_form">
</div>

<div class="div_tabla" class="ui-widget">
<strong>SALDO INICIAL</strong>
<?php 
	$dts1=$oNotalmacen->consultar_existencia_saldo_inicial($_POST['cat_id'],$_POST['alm_id']);
?>
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
	<thead>    	
		<tr class="ui-widget-header">
			<th>FECHA</th>
			<th>N° DOCUMENTO</th>
			<th title="PRECIO COSTO">P. COSTO S/.</th>
			<th>CANTIDAD</th>
			<th>ACTUALIZAR</th>
			<th>EDITAR</th>
		</tr>
	</thead>			
    <tbody>					
    <?php
		while($dt1 = mysql_fetch_array($dts1)){
	?>
		<tr>
			<td><?php echo mostrarFecha($dt1['tb_notalmacen_fec'])?></td>
            <td><?php echo $dt1['tb_notalmacen_numdoc']?></td>
            <td align="right"><?php echo formato_money($dt1['tb_notalmacendetalle_cos'])?></td>
			<td align="right"><?php echo $sum_can_salini=$dt1['tb_notalmacendetalle_can']?></td>
			<td align="center">
            <?php /*if($_SESSION['usuariogrupo_id']==2){?>
            <label for="txt_salini_can_">Cantidad:</label>
			  <input name="txt_salini_can" class="cantidad" type="text" id="txt_salini_can" size="10" maxlength="10" value="<?php echo $dt1['tb_notalmacendetalle_can']?>">
            <a class="btn_act_stock_si" onClick="actualizar_salini('<?php echo $dt1['tb_notalmacendetalle_id']?>')">Actualizar</a>
            <?php }*/?>
            </td>
			<td align="center">
				<?php /*?><a class="btn_editar_si" href="#update" onClick="notalmacen_detalle_form('editar','<?php echo $dt1['tb_notalmacendetalle_id']?>')">Editar</a><?php */?>
			</td>
		</tr>
		<?php
		}	
		mysql_free_result($dts1);?>
	</tbody>
</table>
</div>
<br>
<br>

<div class="div_tabla" class="ui-widget">
<strong>COMPRAS</strong>
<?php 
$dts1 = $oHistorial->consultar_historial_compras_por_producto($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin),'ASC',$_SESSION['empresa_id']);	
		$num_rows_1 = mysql_num_rows($dts1);		
			
		if($num_rows_1>=1){
?>
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
	<thead>    	
			<tr class="ui-widget-header">
				<th>FECHA</th>
				<th>TIPO DE DOCUMENTO</th>
				<th>N° DOCUMENTO</th>
				<th title="MONEDA">MON</th>
				<th title="TIPO DE CAMBIO"> CAMB</th>
				<th title="CANTIDAD">CANT</th>
				<th title="PRECIO UNITARIO COMPRA">PRECIO UNIT</th>
				<th title="DESCUENTO POR LINEA">DSCTO %</th>
				<th title="SUB TOTAL">SUB TOTAL</th>
				<th>FLETE S/.</th>
				<th title="DESCUENTO GENERAL COMPRA">DTO COMP %</th>
				<th title="COSTO UNITARIO DOLARES">COSTO UNIT US$</th>
				<th title="COSTO UNITARIO SOLES">COSTO UNIT S/.</th>
			</tr>
	</thead>			
        <tbody>					
        <?php
			$sum_can_com = 0;//Suma Cantidades de Compras por Producto
			$sum_tot_com = 0;//Suma Total de Los SubTotales por Producto
			while($dt1 = mysql_fetch_array($dts1)){
				$sum_can_com += $dt1['tb_compradetalle_can'];
				$subtotal = $dt1['tb_compradetalle_can']*$dt1['tb_compradetalle_preuni'];
				$sum_tot_com += $subtotal;
			
				$sum_tot_imp += $dt1['tb_compradetalle_imp'];
				
				//costo unitario en dolares
				if($dt1['tb_compra_mon']==2)
				{
					$costo_unitario_dol=formato_money($dt1['tb_compradetalle_cosuni']/$dt1['tb_compra_tipcam']);
				}
				else
				{
					$costo_unitario_dol='-';
				}
					
		?>
				<tr>
					<td nowrap="nowrap" title="<?php echo 'Registrado: '.mostrarFechaHoraH($dt1['tb_compra_reg'])?>"><?php echo mostrarFecha($dt1['tb_compra_fec'])?></td>
					<td><?php echo $dt1['tb_documento_nom']?></td>
                    <td><?php echo $dt1['tb_compra_numdoc']?></td>
                    <td><?php if($dt1['tb_compra_mon']==1)echo "S/."; if($dt1['tb_compra_mon']==2)echo "US$";?></td>
                    <td align="right"><?php echo formato_money($dt1['tb_compra_tipcam'])?></td>
					<td align="right"><?php echo $dt1['tb_compradetalle_can']?></td>
					<td align="right"><?php echo formato_money($dt1['tb_compradetalle_preuni'])?></td>
					<td align="right"><?php echo formato_money($dt1['tb_compradetalle_des'])?></td>
					<td align="right"><?php echo formato_money($dt1['tb_compradetalle_imp'])?></td>
					<td align="right"><?php echo formato_money($dt1['tb_compradetalle_fle'])?></td>
					<td align="right"><?php echo formato_money($dt1['tb_compra_des'])?></td>
					<td align="right"><?php echo $costo_unitario_dol?></td>
					<td align="right"><?php echo formato_money($dt1['tb_compradetalle_cosuni'])?></td>
				</tr>
			<?php				
			}	
			?>
            <tr>
                <td colspan="5"><strong>TOTAL</strong></td>
                <td align="right"><strong><?php echo $sum_can_com;?></strong></td>
				<td align="right">&nbsp;</td>
				<td align="right">&nbsp;</td>                
                <td align="right"><strong><?php echo formato_money($sum_tot_imp);?></strong></td>
                <td align="right">&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td align="right">&nbsp;</td>
            </tr>
    	</tbody>
  </table>
<?php			
}
mysql_free_result($dts1);?>
</div>

<br>
<br>
<div class="div_tabla" class="ui-widget">
<strong> VENTAS</strong>
<?php 
		$dts2 = $oHistorial->consultar_historial_ventas_por_producto($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));	
		$num_rows_2 = mysql_num_rows($dts2);		
			
		if($num_rows_2>=1){
?>
    <table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
		<thead>    	
			<tr class="ui-widget-header">
				<th>FECHA</th>
				<th>TIPO DE DOCUMENTO</th>
				<th>N° DOCUMENTO</th>
				<th>CANTIDAD</th>
				<th>PRECIO UNIT</th>
				<th>SUB TOTAL</th>
				<th>TOTAL VENTA</th>
				<th>PRECIO VENTA UNIT</th>                                   
			</tr>
		</thead>			
        <tbody>					
        <?php
			$sum_can_ven = 0;//Suma Cantidades de Ventas por Producto
			$sum_tot_ven = 0;//Suma Total de Los SubTotales por Producto
			while($dt2 = mysql_fetch_array($dts2)){
				
				$precio_venta = $dt2['tb_ventadetalle_valven']+$dt2['tb_ventadetalle_igv'];
				$total_venta+=$precio_venta;
				
				$precio_venta_unitario=$precio_venta/$dt2['tb_ventadetalle_can'];
				
				$sum_can_ven += $dt2['tb_ventadetalle_can'];
				$subtotal = $dt2['tb_ventadetalle_can']*$dt2['tb_ventadetalle_preuni'];
				$sum_tot_ven += $subtotal;
				
				$promedio_precio_venta_unitario=$total_venta/$sum_can_ven;

		?>
				<tr>
					<td><?php echo mostrarFecha($dt2['tb_venta_fec'])?></td>
					<td><?php echo $dt2['tb_documento_nom']?></td>
                    <td><?php echo $dt2['tb_venta_numdoc']?></td>
					<td align="right"><?php echo $dt2['tb_ventadetalle_can']?></td>
					<td align="right"><?php echo formato_money($dt2['tb_ventadetalle_preuni'])?></td>
					<td align="right"><?php echo formato_money($subtotal)?></td>
				  <td align="right"><?php echo formato_money($precio_venta)?></td>
				  <td align="right"><?php echo formato_money($precio_venta_unitario)?></td>
				</tr>
			<?php				
			}	
			?>
            <tr>
                <td colspan="3"><strong>TOTAL</strong></td>                    
				<td align="right"><strong><?php echo $sum_can_ven;?></strong></td>
                <td align="right">&nbsp;</td>                
                <td align="right"><strong><?php echo formato_money($sum_tot_ven);?></strong></td>
                <td align="right"><strong><?php echo formato_money($total_venta);?></strong></td>
                <td align="right"><strong><?php echo 'Promedio= '.formato_money($promedio_precio_venta_unitario);?></strong></td>                
            </tr>
   	  </tbody>
    </table>
<?php	}
mysql_free_result($dts2);?>
</div>

<br>
<br>
<div class="div_tabla" class="ui-widget">
<strong> NOTAS DE VENTA</strong>
<?php 
		$dts5 = $oHistorial->consultar_historial_ventanotas_por_producto($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));	
		$num_rows_5 = mysql_num_rows($dts5);		
			
		if($num_rows_5>=1){
?>
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
		<thead>    	
			<tr class="ui-widget-header">
				<th>FECHA</th>
				<th>TIPO DE DOCUMENTO</th>
				<th>N° DOCUMENTO</th>
				<th>CANTIDAD</th>
				<th>COSTO UNIT</th>
				<th>SUB TOTAL</th>
				<th>TOTAL VENTA</th>                                   
			</tr>
		</thead>			
        <tbody>					
        <?php
			$sum_can_vennot = 0;//Suma Cantidades de Ventas por Producto
			$sum_tot_vennot = 0;//Suma Total de Los SubTotales por Producto
			while($dt5 = mysql_fetch_array($dts5)){
				$precio_ventanota = $dt5['tb_ventadetalle_valven']+$dt5['tb_ventadetalle_igv'];
				$total_ventanota+=$precio_ventanota;
				
				$sum_can_vennot += $dt5['tb_ventadetalle_can'];
				$subtotal = $dt5['tb_ventadetalle_can']*$dt5['tb_ventadetalle_preuni'];
				$sum_tot_vennot += $subtotal;?>
				<tr>
					<td><?php echo mostrarFecha($dt5['tb_venta_fec'])?></td>
					<td><?php echo $dt5['tb_documento_nom']?></td>
                    <td><?php echo $dt5['tb_venta_numdoc']?></td>
					<td align="right"><?php echo $dt5['tb_ventadetalle_can']?></td>
					<td align="right"><?php echo formato_moneda($dt5['tb_ventadetalle_preuni'])?></td>
					<td align="right"><?php echo formato_moneda($subtotal);?></td>
					<td align="right"><?php echo formato_money($precio_ventanota)?></td>
				</tr>
			<?php				
			}	
			?>
            <tr>
                <td colspan="3" align="right"><strong>TOTAL</strong></td>                    
				<td align="right"><strong><?php echo $sum_can_vennot;?></strong></td>
                <td align="right">&nbsp;</td>                
                <td align="right"><strong><?php echo formato_money($sum_tot_vennot);?></strong></td>
                <td align="right"><strong><?php echo formato_money($total_ventanota);?></strong></td>                
            </tr>
    	</tbody>
    </table>
            <?php			
		}
		mysql_free_result($dts5);?>
</div>

<br>
<br>
<div class="div_tabla" class="ui-widget">
<strong> TRANSFERENCIAS DE ENTRADA</strong>
<?php 
		$dts3 = $oHistorial->consultar_historial_traspasos_entrada_por_producto($_POST['cat_id'], $_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));	
		$num_rows_3 = mysql_num_rows($dts3);		
			
		if($num_rows_3>=1){
?>
	<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
		<thead>    	
			<tr class="ui-widget-header">
				<th>FECHA</th>
				<th>ALMACEN ORIGEN</th>
				<th>ALMACEN DESTINO</th>
				<th>CANTIDAD</th>				                                  
			</tr>
		</thead>			
        <tbody>					
        <?php
			$sum_can_tra_ent = 0;//Suma Cantidades de Trasnferencias de Entrada por Producto
			while($dt3 = mysql_fetch_array($dts3)){
				$sum_can_tra_ent += $dt3['cantidad'];?>
				<tr>
					<td><?php echo mostrarFecha($dt3['fecha'])?></td>
					<td><?php echo $dt3['origen']?></td>
                    <td><?php echo $dt3['destino']?></td>
					<td align="right"><?php echo $dt3['cantidad']?></td>					
				</tr>
			<?php				
			}	
			?>
            <tr>
                <td colspan="3" align="right"><strong>TOTAL</strong></td>                    
				<td align="right"><strong><?php echo $sum_can_tra_ent;?></strong></td>                
            </tr>
    	</tbody>
    </table>
<?php			
		}
		mysql_free_result($dts3);?>
</div>

<br>
<br>
<div class="div_tabla" class="ui-widget">
<strong> TRANSFERENCIAS DE SALIDA</strong>
<?php
		$dts4 = $oHistorial->consultar_historial_traspasos_salida_por_producto($_POST['cat_id'], $_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));	
		$num_rows_4 = mysql_num_rows($dts4);		
			
		if($num_rows_4>=1){
?>
	<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
		<thead>    	
			<tr class="ui-widget-header">
				<th>FECHA</th>
				<th>ALMACEN ORIGEN</th>
				<th>ALMACEN DESTINO</th>
				<th>CANTIDAD</th>				                                  
			</tr>
		</thead>			
        <tbody>					
        <?php
			$sum_can_tra_sal = 0;//Suma Cantidades de Trasnferencias de Salida por Producto
			while($dt4 = mysql_fetch_array($dts4)){
				$sum_can_tra_sal += $dt4['cantidad'];?>
				<tr>
					<td><?php echo mostrarFecha($dt4['fecha'])?></td>
					<td><?php echo $dt4['origen']?></td>
                    <td><?php echo $dt4['destino']?></td>
					<td align="right"><?php echo $dt4['cantidad']?></td>					
				</tr>
			<?php				
			}	
			?>
            <tr>
                <td colspan="3" align="right"><strong>TOTAL</strong></td>                    
				<td align="right"><strong><?php echo $sum_can_tra_sal;?></strong></td>                
            </tr>
    	</tbody>
    </table>
<?php			
		}
		mysql_free_result($dts4);?>
</div>

<br>
<br>

<div class="div_tabla" class="ui-widget">
<strong>NOTAS DE ALMACEN ENTRADA</strong>
<?php 
$dts1=$oHistorial->consultar_historial_notalmacen_entrada_por_producto($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));
$num_rows_1 = mysql_num_rows($dts1);		

$sum_can_notalm_ent=0;

if($num_rows_1>=1){
?>
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
		<thead>    	
			<tr class="ui-widget-header">
				<th>FECHA</th>
				<th>TIPO DE DOCUMENTO</th>
				<th>N° DOCUMENTO</th>
				<th>CANTIDAD</th>
			</tr>
		</thead>			
        <tbody>					
        <?php
			while($dt1 = mysql_fetch_array($dts1)){
					$sum_can_notalm_ent += $dt1['tb_notalmacendetalle_can'];
				?>
				<tr>
					<td><?php echo mostrarFecha($dt1['tb_notalmacen_fec'])?></td>
					<td><?php echo $dt1['tb_documento_nom']?></td>
                    <td><?php echo $dt1['tb_notalmacen_numdoc']?></td>
					<td align="right"><?php echo $dt1['tb_notalmacendetalle_can']?></td>
				</tr>
          <?php }?>
		  <tr>
				  <td colspan="3" align="right"><strong>TOTAL</strong></td>
				  <td align="right"><strong><?php echo $sum_can_notalm_ent?></strong></td>
		  </tr>
    	</tbody>
    </table>
<?php 
}
mysql_free_result($dts1);	
?>
</div>

<br>
<br>
<div class="div_tabla" class="ui-widget">
<strong>NOTAS DE ALMACEN SALIDA</strong>
<?php 
$dts1=$oHistorial->consultar_historial_notalmacen_salida_por_producto($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));
$num_rows_1 = mysql_num_rows($dts1);		

$sum_can_notalm_sal=0;

if($num_rows_1>=1){
?>
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
		<thead>    	
			<tr class="ui-widget-header">
				<th>FECHA</th>
				<th>TIPO DE DOCUMENTO</th>
				<th>N° DOCUMENTO</th>
				<th>CANTIDAD</th>
			</tr>
		</thead>			
        <tbody>					
        <?php
			while($dt1 = mysql_fetch_array($dts1)){
					$sum_can_notalm_sal += $dt1['tb_notalmacendetalle_can'];
				?>
				<tr>
					<td><?php echo mostrarFecha($dt1['tb_notalmacen_fec'])?></td>
					<td><?php echo $dt1['tb_documento_nom']?></td>
                    <td><?php echo $dt1['tb_notalmacen_numdoc']?></td>
					<td align="right"><?php echo $dt1['tb_notalmacendetalle_can']?></td>
				</tr>
          <?php }?>
		  <tr>
				  <td colspan="3" align="right"><strong>TOTAL</strong></td>
				  <td align="right"><strong><?php echo $sum_can_notalm_sal?></strong></td>
		  </tr>
    	</tbody>
    </table>
<?php 
}
mysql_free_result($dts1);	
?>
</div>

<div align="right">
<fieldset style="width:20%">
	<legend>Datos Stock</legend>
    <strong>Stock Actual Registrado: </strong><?php 	
	echo $stock_actual;
	
	$stock_inicial = $stock_actual - $sum_can_com + $sum_can_ven + $sum_can_vennot - $sum_can_tra_ent + $sum_can_tra_sal - $sum_can_notalm_ent + $sum_can_notalm_sal;
	
	$stock_final = $sum_can_salini + $sum_can_com - $sum_can_ven - $sum_can_vennot + $sum_can_tra_ent - $sum_can_tra_sal + $sum_can_notalm_ent - $sum_can_notalm_sal;

	$total_ingresos=$sum_can_salini + $sum_can_com + $sum_can_tra_ent + $sum_can_notalm_ent;
	$total_salidas=$sum_can_ven + $sum_can_vennot + $sum_can_tra_sal + $sum_can_notalm_sal;
	?>
    </br>
    <strong>Stock Actual Calculado: </strong><?php echo $stock_final;?>
    <br>
    <br>
    Ingresos: <?php echo $total_ingresos;?>
    <br>
    Salidas: <?php echo $total_salidas;?>
    <!--</br>
    <strong>Stock Inicial: </strong>--><?php //echo $stock_inicial;
	?>    
</fieldset>
</div>