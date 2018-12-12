<?php
session_start();
require_once ("../../config/Cado.php");	
require_once ("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once ("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();
require_once ("../historial/cHistorial.php");
$oHistorial = new cHistorial();
require_once ("../formatos/formato.php");
require_once ("../catalogo/cst_producto.php");
/*
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();



require_once("../producto/cStock.php");
$oStock = new cStock();

*/

	
$fecini='01-01-2016';
//$fecfin='';
$fecfin=date('d-m-Y');

/*$rs = $oCatalogoproducto->presentacion_catalogo_stock_almacen($_POST['cat_id'], $_POST['alm_id']);
$dt = mysql_fetch_array($rs);
$sto_id = $dt['tb_stock_id'];
$pre_id = $dt['tb_presentacion_id'];
$stock_actual = $dt['tb_stock_num'];

$precos		=$dt['tb_catalogo_precos'];
$preven		=$dt['tb_catalogo_preven'];
$precosdol	=$dt['tb_catalogo_precosdol'];
$utilidad	=$dt['tb_catalogo_uti'];
	
	mysql_free_result($rs);*/
	
	//artificio para mostrar el tipo cambio eliminar luego de uso
	/*$rws= $oNotalmacen->mostrar_catalogo($_POST['cat_id']);
	$rw = mysql_fetch_array($rws);
		$cat_tipcam	=$rw['tb_catalogo_tipcam'];
		$cat_uti	=$rw['tb_catalogo_uti'];
		$cat_costo	=$rw['tb_catalogo_precos'];
		$cat_precio	=$rw['tb_catalogo_preven'];
	mysql_free_result($rws);
	*/
	//consulta de saldo inicial
	/*$dts1 = $oKardex->mostrar_kardex_por_producto($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));
	$num_rows_1 = mysql_num_rows($dts1);
	
	$dt1 = mysql_fetch_array($dts1);
	$notdet_id=$dt1['tb_notalmacendetalle_id'];;
	$ver_costo=$dt1['tb_notalmacendetalle_cos'];
	mysql_free_result($dts1);*/
	
	//actualizar costos
	/*if($num_rows_1>0)
	{
		if($ver_costo=='0.00')
		{
			echo 'Se actualizó. ok';
			$consulta=$oNotalmacen->modificar_detalle_na($notdet_id,$precos,$preven);
		}
		else
		{
			echo 'Existe dato de costos.';
		}
	}*/
?>
<script type="text/javascript">
/*function notalmacen_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "notalmacen_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			alm_id:	idf,
			vista:	'almacen_tabla'
		}),
		beforeSend: function() {
			$('#msj_notalmacen').hide();
			$('#div_notalmacen_form').dialog("open");
			$('#div_notalmacen_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_notalmacen_form').html(html);				
		}
	});
}*/
function notalmacen_detalle_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "../notalmacen/notalmacen_detalle_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			notalmdet_id: idf,
			vista:	'historial_tabla'
		}),
		beforeSend: function() {
			$('#msj_notalmacen').hide();
			$('#div_notalmacen_detalle_form').dialog("open");
			$('#div_notalmacen_detalle_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_notalmacen_detalle_form').html(html);				
		}
	});
}
$('.cantidad').autoNumeric({
	aSep: '',
	aDec: '.',
	vMin: '0',
	vMax: '99999'
});

function actualizar_salini(id)
{   
	$.ajax({
		type: "POST",
		url: "notalmacen_salini_reg.php",
		async:true,
		dataType: "json",
		data: ({
			action: "actualizar_saldo_inicial",
			notalmdet_id:	id,
			can: $('#txt_salini_can').val()
		}),
		beforeSend: function() {
			$('#msj_notalmacen').hide();
			$('#msj_notalmacen').html("Cargando...");
			$('#msj_notalmacen').show(100);
		},
		success: function(data){
			$('#msj_notalmacen').html(data.notalm_msj);
		},
		complete: function(){
			//alert('Se actualizó correctamente.');
			historial_tabla();
		}
	});
}

$(function() {
	$('.btn_editar_si').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	$('.btn_act_stock_si').button({
		//icons: {primary: "ui-icon-pencil"},
		text: true
	});
	
	/*$( "#div_notalmacen_form" ).dialog({
		title:'Información de Nota de Almacén',
		autoOpen: false,
		resizable: false,
		height: 180,
		width: 500,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_notalm").submit();
			},
			Cancelar: function() {
				$('#for_notalm').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});*/
	
	$( "#div_notalmacen_detalle_form" ).dialog({
		title:'Información de Detalle de Nota de Almacén',
		autoOpen: false,
		resizable: false,
		height: 180,
		width: 430,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_notalm_det").submit();
			},
			Cancelar: function() {
				$('#for_notalm_det').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
}); 
</script>
<div id="div_notalmacen_detalle_form">
</div>

<style>
div#div_tabla_historial_saldoi { margin: 0 0; }
div#div_tabla_historial_saldoi table { margin: 0 0; border-collapse: collapse; width: 100%; }
div#div_tabla_historial_saldoi table td, div#div_tabla_historial_saldoi table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; } 
div#div_tabla_historial_saldoi table th { height:18px } 
div#div_tabla_historial_saldoi table td { height:17px }
</style>


<div id="div_tabla_historial_saldoi" class="ui-widget">
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
			<td align="right"><?php echo $dt1['tb_notalmacendetalle_can']?></td>
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


</br></br>

<style>
	div#div_tabla_historial_compra { margin: 0 0; }
	div#div_tabla_historial_compra table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_historial_compra table td, div#div_tabla_historial_compra table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_historial_compra table th { height:18px }
	div#div_tabla_historial_compra table td { height:17px }
</style>



<div id="div_tabla_historial_compra" class="ui-widget">
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


</br></br>
<style>
	div#div_tabla_historial_calculo { margin: 0 0; }
	div#div_tabla_historial_calculo table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_historial_calculo table td, div#div_tabla_historial_calculo table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_historial_calculo table th { height:18px }
	div#div_tabla_historial_calculo table td { height:17px }
</style>
<?php /*?>
<div id="div_tabla_historial_calculo" class="ui-widget">
<strong>CÁLCULO COSTOS POR ALMACEN</strong>
<?php 
$stock_kardex=stock_kardex($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);
						
$costo_ponderado_array=costo_ponderado($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin),$stock_kardex,$precos,$precosdol,$_SESSION['empresa_id']);

$costo_ponderado_soles=$costo_ponderado_array['soles'];
$costo_ponderado_dolares=$costo_ponderado_array['dolares'];

$calculo_utilidad=$utilidad/100;

$precio_sugerido=moneda_mysql($costo_ponderado_soles)/(1-$calculo_utilidad);

$precio_sugerido=moneda_mysql(number_format($precio_sugerido,1));

//$datos=$costo_ponderado_array['datos'];
//$datos2=$costo_ponderado_array['datos2'];
//$datos3=$costo_ponderado_array['datos3'];
//$datos4=$costo_ponderado_array['datos4'];
?>
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
<thead>    	
  <tr class="ui-widget-header">
    <th title="Cálculo de stock en kardex. Stock Actual.">STOCK*</th>
    <!--<th>dat</th>-->
    <th>COSTO UNITARIO PROM. US$</th>
    <th>COSTO UNITARIO PROM. S/.</th>
    <th>UTILIDAD</th>
    <th>PRECIO SUGERIDO</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td align="right"><?php echo $stock_kardex?></td>
    <?php //?><td align="right"><?php echo $datos.'---'.$datos2.'---'.$datos3.'---'.$datos4;?></td><?php ?>
    <td align="right"><?php echo formato_money($costo_ponderado_dolares)?></td>
    <td align="right"><?php echo formato_money($costo_ponderado_soles)?></td>
    <td align="right"><?php echo formato_money($utilidad)?></td>
    <td align="right"><?php echo formato_money($precio_sugerido)?></td>
  </tr>
</tbody>
</table>
</div>
<?php */?>
</br>
<style>
	div#div_tabla_historial_calculo { margin: 0 0; }
	div#div_tabla_historial_calculo table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_historial_calculo table td, div#div_tabla_historial_calculo table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_historial_calculo table th { height:18px }
	div#div_tabla_historial_calculo table td { height:17px }
</style>
<?php /*?>
<div id="div_tabla_historial_calculo" class="ui-widget">
<strong>CÁLCULO COSTOS GENERAL</strong>
<?php 
//$stock_kardex=stock_kardex($_POST['cat_id'],0,fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);
						
//$costo_ponderado_array=costo_ponderado_empresa($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin),$stock_kardex,$precos,$precosdol,$_SESSION['empresa_id']);

//$costo_ponderado_soles=$costo_ponderado_array['soles'];
//$costo_ponderado_dolares=$costo_ponderado_array['dolares'];

//$calculo_utilidad=$utilidad/100;

//$precio_sugerido=moneda_mysql($costo_ponderado_soles)/(1-$calculo_utilidad);

//$precio_sugerido=moneda_mysql(number_format($precio_sugerido,1));

//$datos=$costo_ponderado_array['datos'];
//$datos2=$costo_ponderado_array['datos2'];
//$datos3=$costo_ponderado_array['datos3'];
//$datos4=$costo_ponderado_array['datos4'];
?><?php */?>
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
<thead>    	
  <tr class="ui-widget-header">
    <th title="Cálculo de stock en kardex. Stock Actual General.">STOCK GENERAL</th>
    <!--<th>dat</th>-->
    <th>COSTO UNITARIO PROM. US$</th>
    <th>COSTO UNITARIO PROM. S/.</th>
    <th>UTILIDAD</th>
    <th>PRECIO SUGERIDO</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td align="right"><?php echo $stock_kardex?></td>
    <?php ?><td align="right"><?php echo $datos.'---'.$datos2.'---'.$datos3.'---'.$datos4;?></td><?php ?>
    <td align="right"><?php echo formato_money($costo_ponderado_dolares)?></td>
    <td align="right"><?php echo formato_money($costo_ponderado_soles)?></td>
    <td align="right"><?php echo formato_money($utilidad)?></td>
    <td align="right"><?php echo formato_money($precio_sugerido)?></td>
  </tr>
</tbody>
</table>
</div>


<style>
	div#div_tabla_historial_venta { margin: 0 0; }
	div#div_tabla_historial_venta table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_historial_venta table td, div#div_tabla_historial_venta table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_historial_venta table th { height:18px }
	div#div_tabla_historial_venta table td { height:17px }
</style>
</br></br>
<?php /*?>
<div id="div_tabla_historial_venta" class="ui-widget">
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
<?php */?>

<style>
	div#div_tabla_historial_ventanota { margin: 0 0; }
	div#div_tabla_historial_ventanota table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_historial_ventanota table td, div#div_tabla_historial_ventanota table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_historial_ventanota table th { height:18px }
	div#div_tabla_historial_ventanota table td { height:17px }
</style>
</br></br>
<?php /*?>
<div id="div_tabla_historial_ventanota" class="ui-widget">
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
<?php */?>

<style>
	div#div_tabla_historial_traspaso_entrada { margin: 0 0; }
	div#div_tabla_historial_traspaso_entrada table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_historial_traspaso_entrada table td, div#div_tabla_historial_traspaso_entrada table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_historial_traspaso_entrada table th { height:18px }
	div#div_tabla_historial_traspaso_entrada table td { height:17px }
</style>
</br></br>
<?php /*?>
<div id="div_tabla_historial_traspaso_entrada" class="ui-widget">
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
					<td><?php echo $dt3['cantidad']?></td>					
				</tr>
			<?php				
			}	
			?>
            <tr>
                <td colspan="3" align="right"><strong>TOTAL</strong></td>                    
				<td><strong><?php echo $sum_can_tra_ent;?></strong></td>                
            </tr>
    	</tbody>
    </table>
<?php			
		}
		mysql_free_result($dts3);?>
</div>
<?php */?>

<style>
	div#div_tabla_historial_traspaso_salida { margin: 0 0; }
	div#div_tabla_historial_traspaso_salida table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_historial_traspaso_salida table td, div#div_tabla_historial_traspaso_salida table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_historial_traspaso_salida table th { height:18px }
	div#div_tabla_historial_traspaso_salida table td { height:17px }
</style>
</br></br>
<?php /*?>
<div id="div_tabla_historial_traspaso_salida" class="ui-widget">
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
					<td><?php echo $dt4['cantidad']?></td>					
				</tr>
			<?php				
			}	
			?>
            <tr>
                <td colspan="3" align="right"><strong>TOTAL</strong></td>                    
				<td><strong><?php echo $sum_can_tra_sal;?></strong></td>                
            </tr>
    	</tbody>
    </table>
<?php			
		}
		mysql_free_result($dts4);?>
</div>
<?php */?>

</br></br>
<style>
	div#div_tabla_historial_notalm_ent { margin: 0 0; }
	div#div_tabla_historial_notalm_ent table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_historial_notalm_ent table td, div#div_tabla_historial_notalm_ent table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_historial_notalm_ent table th { height:18px }
	div#div_tabla_historial_notalm_ent table td { height:17px }
</style>
<?php /*?>
<div id="div_tabla_historial_notalm_ent" class="ui-widget">
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
					<td><?php echo $dt1['tb_notalmacendetalle_can']?></td>
				</tr>
          <?php }?>
		  <tr>
				  <td colspan="3" align="right"><strong>TOTAL</strong></td>
				  <td><strong><?php echo $sum_can_notalm_ent?></strong></td>
		  </tr>
    	</tbody>
    </table>
<?php 
}
mysql_free_result($dts1);	
?>
</div>
<?php */?>
</br></br>
<style>
	div#div_tabla_historial_notalm_sal { margin: 0 0; }
	div#div_tabla_historial_notalm_sal table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_historial_notalm_sal table td, div#div_tabla_historial_notalm_sal table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_historial_notalm_sal table th { height:18px }
	div#div_tabla_historial_notalm_sal table td { height:17px }
</style>
<?php /*?>
<div id="div_tabla_historial_notalm_sal" class="ui-widget">
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
					<td><?php echo $dt1['tb_notalmacendetalle_can']?></td>
				</tr>
          <?php }?>
		  <tr>
				  <td colspan="3" align="right"><strong>TOTAL</strong></td>
				  <td><strong><?php echo $sum_can_notalm_sal?></strong></td>
		  </tr>
    	</tbody>
    </table>
<?php 
}
mysql_free_result($dts1);	
?>
</div>
<?php */?>
<?php /*?>
<div align="right">
<fieldset style="width:20%">
	<legend>Datos Stock</legend>
    <strong>Stock Actual en Registro: </strong><?php 	
	echo $stock_actual;
	
	$stock_inicial = $stock_actual - $sum_can_com + $sum_can_ven + $sum_can_vennot - $sum_can_tra_ent + $sum_can_tra_sal - $sum_can_notalm_ent + $sum_can_notalm_sal;
	
	$stock_final = $sum_can_salini + $sum_can_com - $sum_can_ven - $sum_can_vennot + $sum_can_tra_ent - $sum_can_tra_sal + $sum_can_notalm_ent - $sum_can_notalm_sal;
	?>
    </br>
    <strong>Stock Actual Calculado: </strong><?php echo $stock_final;?>
    <!--</br>
    <strong>Stock Inicial: </strong>--><?php //echo $stock_inicial;
	?>    
</fieldset>
</div>
<?php */?>

<?php
/*if($_SESSION['usuariogrupo_id']==2){
	//actualización automatica del stock resultante
	if($stock_actual!=$stock_final){echo 'Se actualizó stock automaticamente.';
			$oStock->modificar(
				$sto_id,
				$stock_final
			);
	}
}*/
?>