<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("./cCatalogo.php");
$oCatalogo = new cCatalogo();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once("../producto/cStock.php");
$oStock = new cStock();
require_once("../producto/cPrecio.php");
$oPrecio = new cPrecio();
require_once ("../catalogo/cst_producto.php");

require_once ("../formatos/formato.php");


if(isset($_POST['pro_cat']) and $_POST['pro_cat']>0)
{
	$dc=$_POST['pro_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['pro_cat']);
	$num_rows2= mysql_num_rows($dts2);
	if($num_rows2>0){
		while($dt2 = mysql_fetch_array($dts2)){
			
			$dc.=', '.$dt2['tb_categoria_id'];
			
			$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
			$num_rows3= mysql_num_rows($dts3);
			if($num_rows3>0){
				while($dt3 = mysql_fetch_array($dts3)){
					$dc.=', '.$dt3['tb_categoria_id'];			
				}
			mysql_free_result($dts3);
			}//fin nivel 3
					
		}
	mysql_free_result($dts2);
	}//fin nivel 2

//echo $dc;			
}

//seleccion de los atributos
$atr_array=$_POST['atr_ids'];
if(is_array($atr_array)){
	$cadena_atr = implode(',',$atr_array);
}

if($_POST['alm_id']>0)
{
	$dts1=$oCatalogo->catalogo_filtro_stock($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$cadena_atr,$_POST['verven'],$_POST['vercom'],$_POST['unibas']);
$num_rows= mysql_num_rows($dts1);
}
else
{
	$num_rows=0;
}
?>
<script type="text/javascript">
$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
$('.cantidad').autoNumeric({
	aSep: '',
	aDec: '.',
	vMin: '0',
	vMax: '99999'
});

$('.moneda_cp').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.9999'
});
$('.moneda_tc').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.000',
	vMax: '9.999'
});
$('.porcentaje').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '999.99'
});

function calculo_precioventa_tipcam(idf)
{
	var tipcam	=parseFloat($("#txt_cat_tipcam_"+idf).autoNumericGet());

	var precosdol	=parseFloat($("#txt_cat_precosdol_"+idf).autoNumericGet());
	var uti		=parseFloat($("#txt_cat_uti_"+idf ).val());
	var precos=parseFloat(precosdol*tipcam);
	
	if(uti>=0)
	{
		var utilidad=uti/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(2));
		$( "#txt_cat_precos_"+idf).autoNumericSet(precos.toFixed(2));
	}
	else
	{
		$( "#txt_cat_uti_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(2));
		$( "#txt_cat_precos_"+idf).autoNumericSet(precos.toFixed(2));
	}
	
}

function calculo_precioventa_precosdol(idf)
{
	var tipcam	=parseFloat($("#txt_cat_tipcam_"+idf).autoNumericGet());

	var precosdol	=parseFloat($("#txt_cat_precosdol_"+idf).autoNumericGet());
	var uti		=parseFloat($("#txt_cat_uti_"+idf ).val());
	var precos=parseFloat(precosdol*tipcam);
	
	if(uti>=0)
	{
		var utilidad=uti/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(2));
		$( "#txt_cat_precos_"+idf).autoNumericSet(precos.toFixed(2));
	}
	else
	{
		$( "#txt_cat_uti_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(2));
		$( "#txt_cat_precos_"+idf).autoNumericSet(precos.toFixed(2));
	}
	
}

function calculo_precioventa_precos(idf)
{
	var tipcam	=parseFloat($("#txt_cat_tipcam_"+idf).autoNumericGet());

	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var uti		=parseFloat($("#txt_cat_uti_"+idf ).val());
	//var precos=parseFloat(precosdol*tipcam);
	
	if(uti>=0)
	{
		var utilidad=uti/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	else
	{
		$( "#txt_cat_uti_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	
}

function calculo_precioventa_uti(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var uti		=parseFloat($("#txt_cat_uti_"+idf ).val());
	
	if(uti>=0)
	{
		var utilidad=uti/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	else
	{
		$( "#txt_cat_uti_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(2));
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
		$("#txt_cat_preven_"+idf).autoNumericSet(calculo.toFixed(2));
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
		$( "#txt_predet_val1_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	else
	{
		$( "#txt_cat_uti2_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_predet_val1_"+idf).autoNumericSet(calculo.toFixed(2));
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
		$("#txt_predet_val1_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	
}

/// precio mayorista
function calculo_precioventa_uti3(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var uti		=parseFloat($("#txt_cat_uti3_"+idf ).val());
	
	if(uti>=0)
	{
		var utilidad=uti/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_predet_val2_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	else
	{
		$( "#txt_cat_uti3_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_predet_val2_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	
}

function calculo_precioventa_preven3(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var preven	=parseFloat($("#txt_predet_val2_"+idf).autoNumericGet());
	
	if(preven>0 && preven>=precos)
	{
		var calculo=(1-precos/preven)*100;
		$( "#txt_cat_uti3_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	else
	{
		alert('Precio de Venta debe ser mayor que Precio Costo.');
		
		$( "#txt_cat_uti3_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$("#txt_predet_val2_"+idf).autoNumericSet(calculo.toFixed(2));
	}
	
}



function actualizar_precio(idf)
{
	$('#lbl_sto_'+idf).hide();
	//alert($("#txt_cat_uti_"+idf).autoNumericGet());
	//alert($("#txt_cat_preven_"+idf).autoNumericGet());
	//if($('#txt_sto_'+idf).val()!="")
	//{
		$.ajax({
			type: "POST",
			url: "../producto/precio_reg.php",
			async:true,
			dataType: "html",                      
			data: ({
				action:	'actualizar_precio_panel',
				cat_id: idf,
				cat_tipcam: $("#txt_cat_tipcam_"+idf).autoNumericGet(),
				cat_precosdol: $("#txt_cat_precosdol_"+idf).autoNumericGet(),
				cat_precos: $("#txt_cat_precos_"+idf).autoNumericGet(),
				cat_uti: $("#txt_cat_uti_"+idf).autoNumericGet(),
				cat_preven: $("#txt_cat_preven_"+idf).autoNumericGet(),
				predet_val1: $("#txt_predet_val1_"+idf).autoNumericGet(),
				predet_val2: $("#txt_predet_val2_"+idf).autoNumericGet()
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
	/*}
	else
	{
		$('#lbl_sto_'+idf).addClass("ui-state-highlight ui-corner-all");
		$('#lbl_sto_'+idf).html('Número?');
		$('#lbl_sto_'+idf).show(100);
	}*/
}
function catalogo_precio_cambio_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "catalogo_precio_cambio_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			cat_id:	idf,
			vista:	'categoria_tabla'
		}),
		beforeSend: function() {
			$('#msj_catalogo').hide();
			$('#div_catalogo_precio_cambio_form').dialog("open");
			$('#div_catalogo_precio_cambio_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_precio_cambio_form').html(html);				
		}
	});
}

$(document).ready(function() {
	
	$('.btn_guardar').button({
		icons: {primary: "ui-icon-disk"},
		text: false
	});

	$('#btn_accion').button({
		//icons: {primary: "ui-icon-document"},
		text: true
	});
	
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			//4: {sorter: 'shortDate' }
		},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0],[1,0],[2,0]]
		<?php }?>
    });

    $( "#div_catalogo_precio_cambio_form" ).dialog({
		title:'Información de Tipo de Cambio',
		autoOpen: false,
		resizable: false,
		height: 200,
		width: 500,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_cam").submit();
			},
			Cancelar: function() {
				$('#for_cam').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});


}); 
</script>
<a id="btn_accion" title="Actualizar Tipo de Cambio" href="#" onClick="catalogo_precio_cambio_form('insertar')">Actualizar Tipo Cambio</a>
<div id="div_catalogo_precio_cambio_form"></div>

        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                    <th>CODIGO</th>
                  <th>NOMBRE</th>
                    <th>MARCA</th>
                    <th>CATEGORIA</th>
                    <th title="UNIDAD">UN</th>
                    <th align="right" title="STOCK">ST</th>
                    <th align="right" nowrap title="CAMBIO">CAMBIO</th>
                    <th align="right" nowrap title="COSTO EN DOLARES">COSTO USD</th>
                    <th align="right" nowrap title="COSTO EN SOLES">COSTO S/.</th>
                    <th align="right" nowrap title="UTILIDAD">UTI %</th>
                    <th align="right" nowrap title="PRECIO DE VENTA">P.  VENTA S/.</th>
                    <th align="right" nowrap title="PRECIO MINIMO">UTI% | P.  MIN. S/.</th>
                    <th align="right" nowrap title="PRECIO MAYORISTA">UTI% | P.  MAY. S/.</th>
                    <th align="right">&nbsp;</th>
                    <th align="right">&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
						//stock
							$rws = $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$_POST['alm_id']);
							$num_filas=mysql_num_rows($rws);
							$rw = mysql_fetch_array($rws);
							$stock_num=$rw['tb_stock_num'];
							mysql_free_result($rws);
								
								$stock_unidad=0;
								
								if($num_filas>0){
									$st_uni=floor($stock_num/$dt1['tb_catalogo_mul']);
									$st_res=$stock_num%$dt1['tb_catalogo_mul'];

									if($st_res!=0){
										//$stock_unidad="$st_uni + r$st_res";
										$stock_unidad=$st_uni;
									} else{
										$stock_unidad=$st_uni;
									}
									
									$action_stock='editar';
									$stock_id=$rw['tb_stock_id'];
								}
								else
								{
									$action_stock='insertar';
									$stock_unidad='-';
								}
							
							//fin
							
						//stock general para calculo de costo promedio-- almacen=0
						$stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
						
						$costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$dt1['tb_catalogo_precos'],$dt1['tb_catalogo_precosdol'],$_SESSION['empresa_id']);
						
											
						//$utilidad=$dt1['tb_catalogo_uti']/100;
						//$precio_sugerido=number_format(moneda_mysql($costo_ponderado)/(1-$utilidad),1);
						
						//$precio_venta=$dt1['tb_catalogo_preven'];
						//if($precio_venta>0)$utilidad=(1-($costo_ponderado/$precio_venta))*100;
						//$utilidad=$dt1['tb_catalogo_uti'];


						//PRECIOS
						$predet_val1="";
						$predet_val2="";
						$m_predet_val1="";
						$m_predet_val2="";

						$precio=1;
								$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt1['tb_catalogo_id']);
								$rw = mysql_fetch_array($rws);
								$predet_id1=$rw['tb_preciodetalle_id'];
								$predet_val1=$rw['tb_preciodetalle_val'];
								mysql_free_result($rws);
								
						$precio=2;
								$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt1['tb_catalogo_id']);
								$rw = mysql_fetch_array($rws);
								$predet_id2=$rw['tb_preciodetalle_id'];
								$predet_val2=$rw['tb_preciodetalle_val'];
								mysql_free_result($rws);

						
						//calculo utilidad

						$uti1="";
						$uti2="";
						if($predet_val1>0)$uti1=(1-$dt1['tb_catalogo_precos']/$predet_val1)*100;
						if($predet_val2>0)$uti2=(1-$dt1['tb_catalogo_precos']/$predet_val2)*100;


						//SI HAY TIPO DE CAMBIO
						$tipo_cambio="";
						$utilidad="";
						$c_utilidad="";
						$costo_ponderado_dolares="";
						$costo_ponderado="";
						$precio_venta="";

						if($dt1['tb_catalogo_tipcam']>0)
						{
							$tipo_cambio=$dt1['tb_catalogo_tipcam'];
							//
							$costo_ponderado_dolares=$costo_ponderado_array['dolares'];
							$utilidad=$dt1['tb_catalogo_uti'];

							$costo_ponderado=$dt1['tb_catalogo_tipcam']*$costo_ponderado_dolares;
							
							$c_utilidad=$dt1['tb_catalogo_uti']/100;
							$precio_venta=$costo_ponderado/(1-$c_utilidad);
							$precio_venta=round($precio_venta,1);

							if($predet_val1>0)
							{
								$m_predet_val1=$predet_val1;

								$c_uti1=$uti1/100;
								$predet_val1=$costo_ponderado/(1-$c_uti1);
								$predet_val1=round($predet_val1,1);
							}

							if($predet_val2>0)
							{
								$m_predet_val2=$predet_val2;

								$c_uti2=$uti2/100;
								$predet_val2=$costo_ponderado/(1-$c_uti2);
								$predet_val2=round($predet_val2,1);
							}
						}
						else
						{
							$utilidad=$dt1['tb_catalogo_uti'];
							$tipo_cambio="";
							$costo_ponderado_dolares="";

							$costo_ponderado=$costo_ponderado_array['soles'];
							$c_utilidad=$dt1['tb_catalogo_uti']/100;
							
							$precio_venta=$costo_ponderado/(1-$c_utilidad);
							$precio_venta=round($precio_venta,1);

							if($predet_val1>0)
							{
								$m_predet_val1=$predet_val1;

								$c_uti1=$uti1/100;
								$predet_val1=$costo_ponderado/(1-$c_uti1);
								$predet_val1=round($predet_val1,1);
							}

							if($predet_val2>0)
							{
								$m_predet_val2=$predet_val2;

								$c_uti2=$uti2/100;
								$predet_val2=$costo_ponderado/(1-$c_uti2);
								$predet_val2=round($predet_val2,1);
							}
						}

				//consulta de datos
				/*$rws = $oCatalogo->consulta_costo($dt1['tb_catalogo_id']);
				$rw = mysql_fetch_array($rws);
				$cospro=$rw['tb_catalogo_cospro'];
				$cosprodol=$rw['tb_catalogo_cosprodol'];
				mysql_free_result($rws);

				///copia de datos copia_dato_cospro($cat_id,$precos,$precosdol)

				$oCatalogo->copia_dato_cospro($dt1['tb_catalogo_id'],moneda_mysql($cospro),moneda_mysql($cosprodol));

				*/

					?>
                        <tr>
                            <td><?php echo $dt1['tb_presentacion_cod']?></td>
                          <td>
                            <span style="">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                          </td>
                          <td><?php echo $dt1['tb_marca_nom']?></td>
                        <td><?php echo $dt1['tb_categoria_nom']?></td>
                        <td title="<?php echo $dt1['tb_unidad_nom']?>">
						<span style="">
						<?php echo $dt1['tb_unidad_abr']?>
                        </span>
                        </td>
                        <td align="right" nowrap><?php if($dt1['tb_catalogo_unibas']==1)
						{
							//echo $stock_num.'/'.$st_uni.'/'.$st_res.'/'.$stock_unidad;
							echo $stock_unidad;
						}
						?></td>
						<td align="right">
							<input name="txt_cat_tipcam_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_tipcam_<?php echo $dt1['tb_catalogo_id']?>" class="moneda_tc" value="<?php echo $tipo_cambio?>" onChange="calculo_precioventa_tipcam('<?php echo $dt1['tb_catalogo_id']?>')" size="6" maxlength="8" style="text-align:right">
							<br>
							<?php if($dt1['tb_catalogo_tipcam']>0)echo $dt1['tb_catalogo_tipcam'].'&nbsp'?>
						</td>
						<td align="right">
							<input name="txt_cat_precosdol_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_precosdol_<?php echo $dt1['tb_catalogo_id']?>" class="moneda_c" value="<?php echo formato_money($costo_ponderado_dolares)?>" onChange="calculo_precioventa_precosdol('<?php echo $dt1['tb_catalogo_id']?>')" size="6" maxlength="8" style="text-align:right">
							<br>
							<?php if($dt1['tb_catalogo_precosdol']>0)echo formato_money($dt1['tb_catalogo_precosdol']).'&nbsp'?>
						</td>
						<td align ="right">
							<input name="txt_cat_precos_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_precos_<?php echo $dt1['tb_catalogo_id']?>" class="moneda_c" value="<?php echo formato_money($costo_ponderado)?>" onChange="calculo_precioventa_precos('<?php echo $dt1['tb_catalogo_id']?>')" size="6" maxlength="8" style="text-align:right">
							<br>
							<?php 
								echo formato_money($dt1['tb_catalogo_precos']).'&nbsp';
								//echo formato_money($costo_ponderado).'&nbsp';
							?>
						</td>
						<td align ="right">
							<input name="txt_cat_uti_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_uti_<?php echo $dt1['tb_catalogo_id']?>" class="porcentaje" value="<?php if($utilidad!=0) echo formato_money($utilidad)?>" size="4" maxlength="6" style="text-align:right" onChange="calculo_precioventa_uti('<?php echo $dt1['tb_catalogo_id']?>')">
							<!--<input name="hdd_cat_uti_<?php //echo $dt1['tb_catalogo_id']?>" type="hidden" id="hdd_cat_uti_<?php //echo $dt1['tb_catalogo_id']?>" value="<?php //if($utilidad!=0) echo formato_money($utilidad)?>">-->
							<br>
							<?php if($dt1['tb_catalogo_uti']!=0) echo formato_money($dt1['tb_catalogo_uti']).'&nbsp'?>
						</td>
						<td align ="right" nowrap="nowrap">
							<input name="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" class="moneda_cp" value="<?php if($precio_venta!=0) echo formato_money($precio_venta)?>" size="7" maxlength="8" style="text-align:right" onChange="calculo_precioventa_preven('<?php echo $dt1['tb_catalogo_id']?>')">
							<br>
							<?php if($dt1['tb_catalogo_preven']!=0) echo formato_money($dt1['tb_catalogo_preven']).'&nbsp'?>
						</td>
						<td align ="right" nowrap>
							<input name="txt_cat_uti2_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_uti2_<?php echo $dt1['tb_catalogo_id']?>" class="porcentaje" value="<?php if($uti1!=0) echo formato_money($uti1)?>" size="4" maxlength="6" style="text-align:right" onChange="calculo_precioventa_uti2('<?php echo $dt1['tb_catalogo_id']?>')">
							<input name="txt_predet_val1_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_predet_val1_<?php echo $dt1['tb_catalogo_id']?>" class="moneda_cp" value="<?php if($predet_val1!=0)echo formato_money($predet_val1)?>" size="7" maxlength="8" style="text-align:right" onChange="calculo_precioventa_preven2('<?php echo $dt1['tb_catalogo_id']?>')">
							<br>
							<?php if($uti1!=0) echo formato_money($uti1)?>
							&nbsp&nbsp&nbsp&nbsp&nbsp
							<?php if($m_predet_val1!=0)echo formato_money($m_predet_val1).'&nbsp'?>
						</td>
						<td align ="right" nowrap>
							<input name="txt_cat_uti3_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_uti3_<?php echo $dt1['tb_catalogo_id']?>" class="porcentaje" value="<?php if($uti2!=0) echo formato_money($uti2)?>" size="4" maxlength="6" style="text-align:right" onChange="calculo_precioventa_uti3('<?php echo $dt1['tb_catalogo_id']?>')">
							<input name="txt_predet_val2_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_predet_val2_<?php echo $dt1['tb_catalogo_id']?>" class="moneda_cp" value="<?php if($predet_val2!=0)echo formato_money($predet_val2)?>" size="7" maxlength="8" style="text-align:right" onChange="calculo_precioventa_preven3('<?php echo $dt1['tb_catalogo_id']?>')">
							<br>
							<?php if($uti2!=0) echo formato_money($uti2)?>
							&nbsp&nbsp&nbsp&nbsp&nbsp
							<?php if($m_predet_val2!=0)echo formato_money($m_predet_val2).'&nbsp'?>
						</td>
                        <td align="right" nowrap>
                        <label id="lbl_sto_<?php echo $dt1['tb_catalogo_id']?>" style="display:none"></label>
                        <a class="btn_guardar" href="#editar" onClick="actualizar_precio('<?php echo $dt1['tb_catalogo_id']?>')">Guardar</a>
                        </td>
                        <td align="right" nowrap><a class="btn_editar" href="#editar" onClick="producto_form('editar','<?php echo $dt1['tb_producto_id']?>')">Editar Producto</a></td>
                        </tr>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <?php
				}
				?>
                <tr class="even">
                  <td colspan="14"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
