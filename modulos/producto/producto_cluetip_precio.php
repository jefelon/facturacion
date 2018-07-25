<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../producto/cPrecio.php");
$oPrecio = new cPrecio();
//require_once ("cProducto.php");
//$oProducto = new cProducto();
//
require_once ("../formatos/formato.php");
require_once ("../catalogo/cst_producto.php");
require_once("../encarte/cEncarte_catalogo.php");
$oEncarte = new cEncarte();
//
//$dts= $oProducto->mostrarUno($_GET['pro_id']);
//$dt = mysql_fetch_array($dts);
//		$pro_nom	=$dt['tb_producto_nom'];
//		$pro_des	=$dt['tb_producto_des'];
//		$cat_nom	=$dt['tb_categoria_nom'];
//		$mar_nom	=$dt['tb_marca_nom'];
//		$pro_est	=$dt['tb_producto_est'];
//mysql_free_result($dts);

$catalogo_id=$_GET['cat_id'];
$dts= $oCatalogoproducto->mostrarUno($catalogo_id);
	$dt = mysql_fetch_array($dts);
	
		$fecmod		=mostrarFechaHora($dt['tb_catalogo_mod']);
		$cat_id_bas	=$dt['tb_unidad_id_bas'];
		$cat_id_equ	=$dt['tb_unidad_id_equ'];
		
		$mul		=$dt['tb_catalogo_mul'];
		
		$tipcam		=$dt['tb_catalogo_tipcam'];
		//if($tipcam=='0.000')$tipcam="";
		
		$precosdol	=$dt['tb_catalogo_precosdol'];
		//if($precosdol=='0.00')$precosdol="";
		
		$preunicom	=$dt['tb_catalogo_preunicom'];
		//if($preunicom=='0.00')$preunicom="";
		
		$precos	=$dt['tb_catalogo_precos'];
		//if($precos=='0.00')$precos="";
		
		$uti		=$dt['tb_catalogo_uti'];
		
		$preven		=$dt['tb_catalogo_preven'];
		//if($preven=='0.00')$preven="";
		
		$vercom		=$dt['tb_catalogo_vercom'];
		$verven		=$dt['tb_catalogo_verven'];
		
		$igvcom		=$dt['tb_catalogo_igvcom'];
		$igvven		=$dt['tb_catalogo_igvven'];
		
		$unibas		=$dt['tb_catalogo_unibas'];
		
		$est		=$dt['tb_catalogo_est'];

	mysql_free_result($dts);
	
	//$stock=$dt1['tb_stock_num'];
//						
//			$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
//			$st_res=$stock%$dt1['tb_catalogo_mul'];
//			
//			if($st_res!=0){
//				//$stock_unidad="$st_uni + r$st_res";
//				$stock_unidad="$st_uni";
//			} else{
//				$stock_unidad="$st_uni";
//			}

	//stock general para calculo de costo promedio-- almacen=0
	$stock_kardex=stock_kardex($catalogo_id,0,'',date('Y-m-d'),$_SESSION['empresa_id']);
	
	$costo_ponderado_array=costo_ponderado_empresa($catalogo_id,$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$precos,$precosdol,$_SESSION['empresa_id']);
	
	$costo_ponderado=$costo_ponderado_array['soles'];
	
	$utilidad=$uti/100;
	$precio_sugerido=number_format(moneda_mysql($costo_ponderado)/(1-$utilidad),1);
	
	
	//PRECIOS

	$precio=1;
			$rws = $oPrecio->consultar_precio_por_catalogo($precio,$catalogo_id);
			$rw = mysql_fetch_array($rws);
			$predet_id1=$rw['tb_preciodetalle_id'];
			$predet_val1=$rw['tb_preciodetalle_val'];
			mysql_free_result($rws);
			
	$precio=2;
			$rws = $oPrecio->consultar_precio_por_catalogo($precio,$catalogo_id);
			$rw = mysql_fetch_array($rws);
			$predet_id2=$rw['tb_preciodetalle_id'];
			$predet_val2=$rw['tb_preciodetalle_val'];
			mysql_free_result($rws);
			
	//ENCARTE
	$enc_est='ACTIVO';
			$rws = $oEncarte->verificar_catalogo_encarte($catalogo_id,$enc_est);
			$rw = mysql_fetch_array($rws);
			$enc_despor		=$rw['tb_encartedetalle_despor'];
			$enc_preven1	=$rw['tb_encartedetalle_preven1'];
			$enc_preven2	=$rw['tb_encartedetalle_preven2'];
			$num_rows_encarte=mysql_num_rows($rws);
			
			mysql_free_result($rws);
?>
<script type="text/javascript">
		
$(function() {	

});
</script>
<style>
	div#tabla_pre { margin: 0 0; }
	div#tabla_pre table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#tabla_pre table td, div#tabla_pre table th { border: 1px solid #eee; padding: 2px 3px; font-size:9pt; }
	/*div#tabla_pre table th { height:18px }
	div#tabla_pre table td { height:17px }*/
</style>
<div id="tabla_pre" class="ui-widget">
<?php if($_SESSION['usuariogrupo_id']==2){?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ui-widget">
<!--<thead>
    <tr class="ui-widget-header">
      <th>PRODUCTO</th>
    </tr>
</thead>-->
<tbody>
  <tr>
    <td class="ui-widget-header">P. Costo</td>
    <td align="right"><span style="font-size: 8pt;"><?php echo formato_money($precos)?></span></td>
    <td>&nbsp;</td>
    <td class="ui-widget-header">Costo Prom.</td>
    <td align="right"><span style="font-size: 8pt;"><?php echo formato_money($costo_ponderado)?></span></td>
    </tr>
  <tr>
    <td class="ui-widget-header">Utilidad%</td>
    <td align="right"><span style="font-size: 8pt;"><?php echo formato_money($uti)?></span></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    </tr>
  <tr>
    <td class="ui-widget-header">P. Venta</td>
    <td align="right"><span style="font-size: 9pt;"><?php echo formato_money($preven)?></span></td>
    <td align="right">&nbsp;</td>
    <td class="-ui-widget-header"><!--PV Promedio--></td>
    <td align="right"><span style="font-size: 9pt;"><?php //echo formato_money(moneda_mysql($precio_sugerido))?></span></td>
    </tr>
  <tr>
    <td class="ui-widget-header">PV Mínimo</td>
    <td align="right"><span style="font-size: 9pt;"><?php if($predet_val1!=0)echo formato_money($predet_val1)?></span></td>
    <td align="right">&nbsp;</td>
    <td class="ui-widget-header">PV Mayorista</td>
    <td align="right"><span style="font-size: 9pt;"><?php if($predet_val2!=0)echo formato_money($predet_val2)?></span></td>
    </tr>
    <?php if($num_rows_encarte>0){?>
  <tr>
    <td class="ui-widget-header">PV Promo</td>
    <td align="right"><span style="font-size: 9pt;">
      <?php if($predet_val1!=0)echo formato_money($enc_preven2)?>
    </span></td>
    <td align="right">&nbsp;</td>
    <td class="ui-widget-header">PV Normal</td>
    <td align="right"><span style="font-size: 9pt;">
      <?php if($predet_val1!=0)echo formato_money($enc_preven1)?>
    </span></td>
  </tr>
	<?php }?>
</tbody>
</table>
<?php }
if($_SESSION['usuariogrupo_id']==3){?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ui-widget">
<!--<thead>
    <tr class="ui-widget-header">
      <th>PRODUCTO</th>
    </tr>
</thead>-->
<tbody>
  <tr>
    <td class="ui-widget-header">P. Venta</td>
    <td align="right"><span style="font-size: 9pt;"><?php echo formato_money($preven)?></span></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td class="ui-widget-header">PV Mínimo</td>
    <td align="right"><span style="font-size: 9pt;"><?php if($predet_val1!=0)echo formato_money($predet_val1)?></span></td>
    <td align="right">&nbsp;</td>
    </tr>
  <tr>
    <td class="ui-widget-header">PV Mayorista</td>
    <td align="right"><span style="font-size: 9pt;">
      <?php if($predet_val2!=0)echo formato_money($predet_val2)?>
    </span></td>
    <td align="right">&nbsp;</td>
    </tr>
        <?php if($num_rows_encarte>0){?>
  <tr>
    <td class="ui-widget-header">PV Promo</td>
    <td align="right"><span style="font-size: 9pt;">
      <?php if($predet_val1!=0)echo formato_money($enc_preven2)?>
    </span></td>
    <td align="right">&nbsp;</td>
    <td class="ui-widget-header">PV Normal</td>
    <td align="right"><span style="font-size: 9pt;">
      <?php if($predet_val1!=0)echo formato_money($enc_preven1)?>
    </span></td>
  </tr>
	<?php }?>
</tbody>
</table>
<?php }?>
<?php /*?><table width="100%" border="0" cellspacing="1" cellpadding="0" class="ui-widget ui-widget-content">
<thead>
  <tr class="ui-widget-header">
    <th><span style="font-size: 7pt;">Descripción</span></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td><span style="font-size: 7pt;"><?php echo $pro_des?></span></td>
  </tr>
</tbody>
</table><?php */?>