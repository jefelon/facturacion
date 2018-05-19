<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
$oCompra = new cCompra();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../catalogo/cst_producto.php");
require_once("../producto/cPrecio.php");
$oPrecio = new cPrecio();
require_once ("../formatos/formato.php");

	$dts= $oCompra->mostrarUno($_POST['com_id']);
	$dt = mysql_fetch_array($dts);
		$fec	=mostrarFecha($dt['tb_compra_fec']);
		$doc_id	=$dt['tb_documento_id'];
		$numdoc	=$dt['tb_compra_numdoc'];
		$pro_id	=$dt['tb_proveedor_id'];
		$subtot	=$dt['tb_compra_subtot'];
		$des	=$dt['tb_compra_des'];
		$descal	=$dt['tb_compra_descal'];
		$fle	=$dt['tb_compra_fle'];
		$tipfle	=$dt['tb_compra_tipfle'];
		$ajupos	=$dt['tb_compra_ajupos'];
		$ajuneg	=$dt['tb_compra_ajuneg'];
		$valven	=$dt['tb_compra_valven'];
		$igv	=$dt['tb_compra_igv'];
		$tot	=$dt['tb_compra_tot'];
		$alm_id	=$dt['tb_almacen_id'];
		$est	=$dt['tb_compra_est'];
	mysql_free_result($dts);

$dts1=$oCompra->mostrar_compra_detalle($_POST['com_id']);
$num_rows= mysql_num_rows($dts1);

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

$('.btn_guardar').button({
	icons: {primary: "ui-icon-disk"},
	text: false
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

///precio min
function calculo_precioventa_uti2(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var uti		=parseFloat($("#txt_cat_uti2_"+idf ).val());
	
	if(uti>=0)
	{
		var utilidad=uti/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_predet_val1_"+idf).autoNumericSet(calculo.toFixed(1));
	}
	else
	{
		$( "#txt_cat_uti2_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_predet_val1_"+idf).autoNumericSet(calculo.toFixed(1));
	}
	
}

function calculo_precioventa_preven2(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var preven	=parseFloat($("#txt_predet_val1_"+idf).autoNumericGet());
	
	if(preven>0 && preven>=precos)
	{
		var calculo=(1-precos/preven)*100;
		$( "#txt_cat_uti2_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	else
	{
		alert('Precio de Venta debe ser mayor que Precio Costo.');
		
		$( "#txt_cat_uti2_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$("#txt_predet_val1_"+idf).autoNumericSet(calculo.toFixed(1));
	}
	
}

function actualizar_precio(idf)
{
	$('#lbl_sto_'+idf).hide();
		$.ajax({
			type: "POST",
			url: "../producto/precio_reg.php",
			async:true,
			dataType: "html",                      
			data: ({
				action:	'actualizar_precio_panel',
				cat_id: idf,
				cat_uti: $("#txt_cat_uti_"+idf).autoNumericGet(),
				cat_preven: $("#txt_cat_preven_"+idf).autoNumericGet(),
				predet_val1: $("#txt_predet_val1_"+idf).autoNumericGet()
			}),
			beforeSend: function() {
				$('#lbl_sto_'+idf).addClass("ui-state-highlight ui-corner-all");
				$('#lbl_sto_'+idf).html('G...');
				$('#lbl_sto_'+idf).show(100);
				//$('#div_catalogo_filtro').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
			},
			success: function(html){
				$('#lbl_sto_'+idf).html(html);
				//$('#div_catalogo_filtro').html(html);
			},
			complete: function(){
				//$('#lbl_sto_'+idf).hide();
				//catalogo_tabla();
			}
		});
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
				url: "../compra/compra_precio_reg.php",
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
<input name="hdd_com_id" id="hdd_com_id" type="hidden" value="<?php echo $_POST['com_id']?>">
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
                    <th title="UNIDAD">UNI</th>
                    <th align="right">STOCK</th>
                    <th align="right" title="PRECIO COSTO UNITARIO COMPRA">PRECIO COSTO</th>
                  	<th align="right" title="COSTO PROMEDIO">COSTO PROM</th>
                    <th align="right" title="PRECIO DE VENTA ACTUAL">P.V. ACTUAL</th>
                    <th align="right" title="PRECIO DE VENTA NUEVO">UTI% | P.V. NUEVO</th>
                    <th align="right" title="PRECIO DE VENTA MINIMO">UTI% | P.V. MINIMO</th>
                    <th align="center"></th>
                </tr>
            </thead>
<?php
if($num_rows>0){
?>
            <tbody>
            <?php
			while($dt1 = mysql_fetch_array($dts1)){
				//consulta de datos			
				$dts2=$oCatalogoproducto->presentacion_catalogo_stock_almacen($dt1['tb_catalogo_id'],$alm_id);
				$dt2 = mysql_fetch_array($dts2);
				
				$utilidad=$dt2['tb_catalogo_uti']/100;
				
				
				//stock general para calculo de costo promedio-- almacen=0
						$stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
						
						$costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$dt1['tb_catalogo_precos'],$dt1['tb_catalogo_precosdol'],$_SESSION['empresa_id']);
						
						$costo_promedio=$costo_ponderado_array['soles'];

			//$precio_venta=formato_money($dt1['tb_compradetalle_cosuni']/(1-$utilidad));
			$precio_venta=formato_money($costo_promedio/(1-$utilidad));

				//PRECIOS

				$precio=1;
				$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt1['tb_catalogo_id']);
				$rw = mysql_fetch_array($rws);
				$predet_id1=$rw['tb_preciodetalle_id'];
				$predet_val1=$rw['tb_preciodetalle_val'];
				mysql_free_result($rws);

				$uti1="";
				if($predet_val1>0)$uti1=(1-$dt1['tb_catalogo_precos']/$predet_val1)*100;
				?>
                        <tr>
                         	<td><?php echo $dt2['tb_producto_nom']?></td>
                            <td title="<?php echo $dt2['tb_unidad_nom']?>"><?php echo $dt2['tb_unidad_abr']?></td>
                            <td align="right"><?php echo $dt2['tb_stock_num']?></td>
                            <td align="right"><?php echo $dt1['tb_compradetalle_cosuni']?></td>
                          	<td align="right"><input name="txt_cat_precos_<?php echo $dt2['tb_catalogo_id']?>" type="text" id="txt_cat_precos_<?php echo $dt2['tb_catalogo_id']?>" value="<?php echo formato_money($costo_promedio)?>" size="10" maxlength="8" style="text-align:right" readonly></td>
                            <td align="right"><?php echo formato_money($dt2['tb_catalogo_preven'])?>
                            </td>
                            <td align="right" nowrap="nowrap">
							<input name="txt_cat_uti_<?php echo $dt2['tb_catalogo_id']?>" type="text" id="txt_cat_uti_<?php echo $dt2['tb_catalogo_id']?>" class="porcentaje" value="<?php echo $dt2['tb_catalogo_uti']?>" size="7" maxlength="6" style="text-align:right" onChange="calculo_precioventa_uti('<?php echo $dt2['tb_catalogo_id']?>')">
                            <input name="txt_cat_preven_<?php echo $dt2['tb_catalogo_id']?>" type="text" id="txt_cat_preven_<?php echo $dt2['tb_catalogo_id']?>" class="moneda_cp" value="<?php echo number_format(moneda_mysql($precio_venta),1).'0'?>" size="10" maxlength="8" style="text-align:right" onChange="calculo_precioventa_preven('<?php echo $dt2['tb_catalogo_id']?>')">
                            </td>
                            <td align ="right" nowrap>
							<input name="txt_cat_uti2_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_uti2_<?php echo $dt1['tb_catalogo_id']?>" class="porcentaje" value="<?php if($uti1!=0) echo formato_money($uti1)?>" size="4" maxlength="6" style="text-align:right" onChange="calculo_precioventa_uti2('<?php echo $dt1['tb_catalogo_id']?>')">
							<input name="txt_predet_val1_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_predet_val1_<?php echo $dt1['tb_catalogo_id']?>" class="moneda_cp" value="<?php if($predet_val1!=0)echo formato_money($predet_val1)?>" size="10" maxlength="8" style="text-align:right" onChange="calculo_precioventa_preven2('<?php echo $dt1['tb_catalogo_id']?>')">
							</td>
							<td align="right" nowrap>
	                        <label id="lbl_sto_<?php echo $dt1['tb_catalogo_id']?>" style="display:none"></label>
	                        <a class="btn_guardar" href="#editar" onClick="actualizar_precio('<?php echo $dt1['tb_catalogo_id']?>')">Guardar</a>
	                        </td>
                        </tr>
            <?php
                mysql_free_result($dts2);
			}
			mysql_free_result($dts1);
            ?>
            </tbody>
<?php
}
else
{
?>
            <tr>
              <td colspan="9">&nbsp;</td>
              <!--<td>&nbsp;</td>-->
            </tr>
<?php
}
?>
        </table>
</form>