<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../producto/cPrecio.php");
$oPrecio = new cPrecio();
require_once ("../catalogo/cst_producto.php");
require_once ("../formatos/formato.php");

if(isset($_SESSION['precio_car']))
{
	$num_rows=count($_SESSION['precio_car']);
	if($num_rows==0)$num_rows="";
}
else
{
	$num_rows="";
}
?>
<script type="text/javascript">
$('.moneda_cp').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.99'
});
$('.porcentaje').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99.99'
});

function calculo_precioventa_uti(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var uti		=parseFloat($("#txt_cat_uti_"+idf ).val());
	
	if(uti>=0)
	{
		var utilidad=uti/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(1));
	}
	else
	{
		$( "#txt_cat_uti_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(1));
	}
	
}

function calculo_precioventa_preven(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var preven	=parseFloat($("#txt_cat_preven_"+idf).autoNumericGet());
	
	if(preven>0 && preven>=precos)
	{
		var calculo=(1-precos/preven)*100;
		$( "#txt_cat_uti_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	else
	{
		alert('Precio de Venta debe ser mayor que Precio Costo.');
		
		$( "#txt_cat_uti_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(1));
	}
	
}

$(function() {
	$("#tabla_compra_precio").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		//headers: {
			//0: {sorter: false },
			//8: {sorter: false }
			//},
		//sortForce: [[0,0]],	
		//sortList: [[2,0]]
    });
	
	$("#for_com_pre").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../compra/compra_precios_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_com_pre").serialize(),
				beforeSend: function(){
					$('#div_compra_precios').dialog("close");
					$('#msj_compra').html("Guardando...");
					$('#msj_compra').show(100);
				},
				success: function(html){
					$('#msj_compra').html(html);
				},
				complete: function(){
					//compra_tabla();
				}
			});			
		},
		rules: {
		},
		messages: {
		}
	});
}); 
</script>
<form id="for_com_pre">
<input name="hdd_com_numite" id="hdd_com_numite" type="hidden" value="<?php echo $num_rows?>">
<fieldset><legend>Detalle</legend>
Por favor ingrese el porcentaje de utilidad o el precio de venta a cada ítem, luego pulse guardar.
<div id="msj_compra_precio" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>

<div style="width:auto; float:right;">
<?php 
	if($num_rows=="" or $num_rows==0)echo 'Ningún ítem agregado.';
	if($num_rows==1)echo $num_rows.' ítem agregado.';
	if($num_rows>=2)echo $num_rows.' ítems agregados.';
?>
</div>
</fieldset>
        <table cellspacing="1" id="tabla_compra_precio" class="tablesorter">
            <thead>
                <tr>
                  	<th>PRODUCTO</th>
                    <th title="UNIDAD">UNID</th>
                    <th align="right" title="PRECIO COSTO UNITARIO COMPRA">PRECIO COSTO</th>
                    <th align="right" title="COSTO PROMEDIO">COSTO PROMEDIO</th>
                    <th align="right">UTILIDAD %</th>
                    <th align="right" title="PRECIO DE VENTA ACTUAL">PRECIO VENTA ACTUAL</th>
                    <th align="right" title="PRECIO DE VENTA MINIMO">PV. MIN.</th>
                    <th align="right">PRECIO VENTA NUEVO</th>
                </tr>
            </thead>
<?php
if($num_rows>0){
?>
            <tbody>
            <?php
			foreach($_SESSION['precio_car'] as $indice=>$catalogo_id){
				//consulta de datos			
				$dts1=$oCatalogoproducto->presentacion_catalogo($catalogo_id);
				$dt1 = mysql_fetch_array($dts1);
				
				$utilidad=$dt1['tb_catalogo_uti']/100;

				//stock general para calculo de costo promedio-- almacen=0
				$stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
				
				$costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$dt1['tb_catalogo_precos'],$dt1['tb_catalogo_precosdol'],$_SESSION['empresa_id']);
				
				$costo_promedio=$costo_ponderado_array['soles'];
				
				//$precio_venta=formato_money($dt1['tb_compradetalle_cosuni']/(1-$utilidad));
			$precio_venta=formato_money($costo_promedio/(1-$utilidad));
				?>
                        <tr>
                         	<td><?php echo $dt1['tb_producto_nom']?></td>
                            <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                            <td align="right"><?php echo $dt1['tb_compradetalle_cosuni']?></td>
                            <td align="right"><input name="txt_cat_precos_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_precos_<?php echo $dt1['tb_catalogo_id']?>" value="<?php echo formato_money($costo_promedio)?>" size="10" maxlength="8" style="text-align:right" readonly></td>
                            <td align="right"><input name="txt_cat_uti_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_uti_<?php echo $dt1['tb_catalogo_id']?>" class="porcentaje" value="<?php echo $dt1['tb_catalogo_uti']?>" size="7" maxlength="5" style="text-align:right" onChange="calculo_precioventa_uti('<?php echo $dt1['tb_catalogo_id']?>')"></td>
                            <td align="right"><?php echo formato_money($dt1['tb_catalogo_preven'])?></td>
                            <td align ="right" nowrap>
							<input name="txt_cat_uti2_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_uti2_<?php echo $dt1['tb_catalogo_id']?>" class="porcentaje" value="<?php if($uti1!=0) echo formato_money($uti1)?>" size="4" maxlength="5" style="text-align:right" onChange="calculo_precioventa_uti2('<?php echo $dt1['tb_catalogo_id']?>')">
							<input name="txt_predet_val1_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_predet_val1_<?php echo $dt1['tb_catalogo_id']?>" class="moneda_cp" value="<?php if($predet_val1!=0)echo formato_money($predet_val1)?>" size="10" maxlength="8" style="text-align:right" onChange="calculo_precioventa_preven2('<?php echo $dt1['tb_catalogo_id']?>')">
							</td>
                            <td align="right"><input name="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" class="moneda_cp" value="<?php echo number_format(moneda_mysql($precio_venta),1).'0'?>" size="10" maxlength="8" style="text-align:right" onChange="calculo_precioventa_preven('<?php echo $dt1['tb_catalogo_id']?>')"></td>
                        </tr>
            <?php
                mysql_free_result($dts1);
			}	
            ?>
            </tbody>
<?php
}
else
{
?>
            <tr>
              <td colspan="8">&nbsp;</td>
              <!--<td>&nbsp;</td>-->
            </tr>
<?php
}
?>
        </table>
</form>