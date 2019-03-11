<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once("../producto/cPrecio.php");
$oPrecio = new cPrecio();
require_once("../encarte/cEncarte_catalogo.php");
$oEncarte = new cEncarte();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../catalogoimagen/cCatalogoimagen.php");
$oCatimagen = new cCatalogoimagen();
require_once("../producto/cStock.php");
$oStock = new cStock();

require_once ("../catalogo/cst_producto.php");

require_once ("../formatos/formato.php");

$igv_dato=0.18;

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
$nom = $_POST['pro_nom'];

if($_POST['cbox1']=='true'){
    $pactivo = 1;
}else{
    $pactivo = 0;
}

if($_POST['cbox2']=='true'){
    $indicacion = 1;
}else{
    $indicacion = 0;
}

$dts1=$oCatalogo->catalogo_ventafarmacia_filtro($_SESSION['almacen_id'],$nom,$pactivo,$indicacion,$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['limit']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">

$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.999999'
});
$('.cantidad_cat_ven').autoNumeric({
	aSep: ',',
	aDec: '.',
    vMin: '0.00',
    vMax: '99999.999999'
});

function cantidad(act,idf)
{
	var can=($('#txt_cat_can_'+idf).val())*1;
	var sto=($('#hdd_cat_stouni_'+idf).val())*1;
	var valor=0;
	var sum=1;
	
	if(act=='mas')
	{
		valor=can+sum;
		if(valor<=sto)$('#txt_cat_can_'+idf).val(valor);
	}
	
	if(act=='menos')
	{
		valor=can-sum;
		if(valor>=1)$('#txt_cat_can_'+idf).val(valor);
	}
}
$('.btn_agregar').button({
	icons: {
		//primary: "ui-icon-plusthick",
		secondary:"ui-icon-cart"
	},
	text: true
});
$('.btn_stock').button({
	icons: {
		primary: "ui-icon-star",
		//secondary:"ui-icon-cart"
	},
	text: false
});

$('.btn_mas').button({
	icons: {
		primary: "ui-icon-plus"
	},
	text: false
});
$('.btn_menos').button({
	icons: {
		primary: "ui-icon-minus"
	},
	text: false
});
$('.btn_info').button({
	icons: {
		//primary: "ui-icon-info"
	},
	text: true
});

$('.btn_info_img').button({
	icons: {
		primary: "ui-icon-image",
		//secondary:"ui-icon-cart"
	},
	text: false
});

$(".btn_mas").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });
$(".btn_menos").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });
$(".btn_info").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

function consulta_stock(catid)
{	
	$.ajax({
		type: "POST",
		url: "../catalogo/consulta_stock.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id:	catid
		}),
		beforeSend: function() {
			$('#div_consulta_stock').dialog("open");
			$('#div_consulta_stock').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_consulta_stock').html(html);
		},
		complete: function(){			
			
		}
	});     
}

// funcion para catalogo imagen

function catalogo_info(idf)
{
	$.ajax({
		type: "POST",
		url: "../catalogoimagen/catalogo_info.php",
		async:true,
		dataType: "html",
		data:({			
			cat_id: idf
		}),
		beforeSend: function(){
			// $('#msj_catimg').hide();
			$('#div_catalogo_info').dialog("open");
			$('#div_catalogo_info').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
		},
		success: function(html){
			$('#div_catalogo_info').html(html);
		}				
	});
}

$(function() {
	
	$('.tip-producto').cluetip({
		attribute: 'id',
		cluezIndex:11000,
		//cluetipClass: 'jtip',
		cluetipClass: 'rounded',
		arrows: true,
		dropShadow: false,
		sticky: true,
		mouseOutClose: true,
		hoverClass: 'ui-state-highlight',
		showTitle: false,
		closePosition: 'title',
		closeText: '<div align="right"><img src="../../js/cluetip/demo/cross.png" alt="close" /></div>'
	});
	
	$('.tip-producto-precio').cluetip({
		attribute: 'id',
		cluezIndex:11001,
		//cluetipClass: 'jtip',
		cluetipClass: 'rounded',
		width:320,
		arrows: true,
		dropShadow: false,
		sticky: true,
		mouseOutClose: true,
		hoverClass: 'ui-state-highlight',
		showTitle: false,
		ajaxCache: false,
		closePosition: 'title',
		closeText: '<div align="right"><img src="../../js/cluetip/demo/cross.png" alt="close" /></div>'
	});
	
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			//4: {sorter: 'shortDate' },
			7: {sorter: false }
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0]]
		<?php }?>
    });
	
	$( ".rad_tip_des" ).buttonset();

	$( "#div_consulta_stock" ).dialog({
		title:'Información de Stock General',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 'auto',
		modal: true,
		position: 'right',
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});

	$( "#div_catalogo_info" ).dialog({
		title:'Información de producto',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 800,
		modal: true,
		position: 'top',
		buttons:{
			Cerrar: function() {				
				$( this ).dialog( "close" );
			}
		},
		close: function(event, ui) {			
			$('#div_catalogo_info').html('venta_info');
		}
	});

}); 
</script>
<div id="div_consulta_stock"></div>
<div id="div_catalogo_info"></div>

<table cellspacing="1" id="tabla_producto" class="tablesorter">
    <thead>
        <tr>
          <th>NOMBRE</th>
            <th align="right">UND.</th>
            <th align="right">STOCK</th>
          <th align="right" nowrap="nowrap" title="PRECIO DE VENTA MAYORISTA">PV. MAY</th>
          <th align="right" nowrap="nowrap" title="PRECIO DE VENTA MINIMO">PV. MIN</th>
          <th align="right" nowrap title="PRECIO VENTA ACTUAL">PRECIO S/.</th>
          <th width="110" align="center">CANTIDAD</th>
          <?php /*?><th align="center">DESCUENTO</th><?php */?>
          <th width="50">&nbsp;</th>
          <th>L</th>
          <th>D</th>
          <th>G</th>
        </tr>
    </thead>
    <tbody>
        <?php
			while($dt1 = mysql_fetch_array($dts1)){

				$stock="";
				//catalogo
				$rs = $oCatalogoproducto->presentacion_catalogo_stock_almacen($dt1['tb_catalogo_id'],$_SESSION['almacen_id']);
				$dt = mysql_fetch_array($rs);
				//$sto_id = $dt['tb_stock_id'];
				//$pre_id = $dt['tb_presentacion_id'];
				$stock = $dt['tb_stock_num'];

				$precos		=$dt['tb_catalogo_precos'];
				//$preven		=$dt['tb_catalogo_preven'];
				//$precosdol	=$dt['tb_catalogo_precosdol'];
				//$utilidad	=$dt['tb_catalogo_uti'];	
				mysql_free_result($rs);

				//$stock=$dt1['tb_stock_num'];
				
						$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
						$st_res=$stock%$dt1['tb_catalogo_mul'];
						
						if($st_res!=0){
							//$stock_unidad="$st_uni + r$st_res";
							$stock_unidad="$st_uni";
						} else{
							$stock_unidad="$st_uni";
						}
						
			//PRECIOS

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

			//ENCARTE
			$enc_est='ACTIVO';
					$rws = $oEncarte->verificar_catalogo_encarte($dt1['tb_catalogo_id'],$enc_est);
					$rw = mysql_fetch_array($rws);
					$enc_despor	=round($rw['tb_encartedetalle_despor'],1);
					$enc_preven2	=$rw['tb_encartedetalle_preven2'];
					$num_rows_encarte=mysql_num_rows($rws);
					
					mysql_free_result($rws);

			//STOCK
			$alm_id=1;
			$rws= $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$alm_id);
			$rw = mysql_fetch_array($rws);
				$stock1=$rw['tb_stock_num'];
			mysql_free_result($rws);
			$alm_id=2;
			$rws= $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$alm_id);
			$rw = mysql_fetch_array($rws);
				$stock2=$rw['tb_stock_num'];
			mysql_free_result($rws);
			$alm_id=3;
			$rws= $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$alm_id);
			$rw = mysql_fetch_array($rws);
				$stock3=$rw['tb_stock_num'];
			mysql_free_result($rws);

			//costo promedio

			if($dt1['tb_catalogo_id']>0)
	        {
	        	$costo_ponderado="";
	            $stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
	        
	            $costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$precos,$precosdol,$_SESSION['empresa_id']);
	            
	            $costo_ponderado=$costo_ponderado_array['soles'];
	        }

			?>
                <tr>
                  <td>
                  	<input name="txt_cat_nom_<?php echo $dt1['tb_catalogo_id']?>" type="hidden" id="txt_cat_nom_<?php echo $dt1['tb_catalogo_id']?>" value="<?php echo $dt1['tb_producto_nom']?>">
                  	
                    <span class="tip-producto" id="../producto/producto_detalle.php?pro_id=<?php echo $dt1['tb_producto_id']?>">
					<?php echo $dt1['tb_producto_nom']?>
                    </span>
                    <?php
												if($num_rows_encarte>=1)
												{
                    echo '<span class="alerta_r" title="PRODUCTO EN PROMOCIÓN">Des. '.$enc_despor.'% | S/. '.$enc_preven2.'</span>';
												}
												?>
                    <?php //echo $dt1['tb_presentacion_nom']?>
                    <!--<span style="">
					<?php //echo $dt1['tb_unidad_abr']?>
                    </span>-->
                    </td>
                    <td align="right">
                        <?php echo $dt1['tb_unidad_abr'];?>
                    </td>
                    <td align="right">
                    <span style="font-weight: bold;">
					<?php echo $stock_unidad?>
                    </span>
                        <input name="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>" id="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>"  type="hidden" value="<?php echo $stock_unidad?>">

                        <input name="hdd_cat_cospro_<?php echo $dt1['tb_catalogo_id']?>" id="hdd_cat_cospro_<?php echo $dt1['tb_catalogo_id']?>"  type="hidden" value="<?php echo $costo_ponderado?>">
                        <input name="hdd_detven_tip_<?php echo $dt1['tb_catalogo_id']?>" id="hdd_detven_tip_<?php echo $dt1['tb_catalogo_id']?>"  type="hidden" value="<?php echo $dt1['tb_afectacion_id']?>">
                    </td>
                  <td align="right"><span style="font-size: 9pt;">
                    <?php if($predet_val2!=0)echo formato_money($predet_val2)?>
                  </span></td>
                  <td align="right"><span style="font-size: 9pt;">
                    <?php if($predet_val1!=0)echo formato_money($predet_val1)?>
                  </span></td>
                    <td align="right" nowrap="nowrap">
                    <!--<span style="font-weight: bold;">
					<?php //echo $dt1['tb_catalogo_preven']?>
                    </span>-->
                    <input name="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" value="<?php echo $dt1['tb_catalogo_preven']?>" size="8" maxlength="8" style="text-align:right; font-size:10px; font-weight:bold" class="moneda">
                    <!--<input name="txt_cat_preven_<?php //echo $dt1['tb_catalogo_id']?>" type="hidden" id="txt_cat_preven_<?php //echo $dt1['tb_catalogo_id']?>" value="<?php //echo $dt1['tb_catalogo_preven']?>">-->
                    <span class="tip-producto-precio" id="../producto/producto_cluetip_precio.php?cat_id=<?php echo $dt1['tb_catalogo_id']?>" style="cursor: help;">
                    <a class="btn_info" href="#info">*</a>
                    </span>
            </td>


                    <td align="center">
                    <input name="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" class="cantidad_cat_ven" value="1" size="5" maxlength="6" style="text-align:right">
                    <a class="btn_mas" href="#mas" onClick="cantidad('mas','<?php echo $dt1['tb_catalogo_id']?>')">Aumentar</a>
                    <a class="btn_menos" href="#menos" onClick="cantidad('menos','<?php echo $dt1['tb_catalogo_id']?>')">Disminuir</a>
                    </td>
<?php /*?>
                    <td align="left" style="width:100px">x
                            <!--Descuento del producto (este valor va en el Detalle Venta)-->
                            
                        <div id="rad_cat_tip_des_<?php echo $dt1['tb_catalogo_id']?>" class="rad_tip_des" style="float:left">
                          <?php <label for="rad_cat_tip_des_1_<?php echo $dt1['tb_catalogo_id']?>">%</label>
                          <input name="rad_cat_tip_des_<?php echo $dt1['tb_catalogo_id']?>" type="radio" id="rad_cat_tip_des_1_<?php echo $dt1['tb_catalogo_id']?>" value="1" checked />  ?>
                          <label for="rad_cat_tip_des_2_<?php echo $dt1['tb_catalogo_id']?>">S/.</label>
                          <input name="rad_cat_tip_des_<?php echo $dt1['tb_catalogo_id']?>" type="radio" id="rad_cat_tip_des_2_<?php echo $dt1['tb_catalogo_id']?>" value="2" checked readonly/>
                        </div>
                        
                        <div style="width:30px; float:left;"><input type="text" name="txt_detven_des_<?php echo $dt1['tb_catalogo_id']?>" id="txt_detven_des_<?php echo $dt1['tb_catalogo_id']?>" class="moneda" size="6" maxlength="8" style="text-align:right">
                        </div>
                    </td><?php */?>


                    <td align="center" nowrap="nowrap">
                    <?php if($stock_unidad!=0){?>
                    
                    <a class="btn_agregar" href="#" onClick="venta_car_form('agregar','<?php echo $dt1['tb_catalogo_id']?>')">Agregar</a>
                    <?php }?>
                    <?php /*?>
                    <a class="btn_stock" href="#" onClick="consulta_stock('<?php echo $dt1['tb_catalogo_id']?>')">Consultar Stock</a><?php */?>
					<?php 
					$dts4=$oCatimagen->mostrar_slaider($dt1['tb_catalogo_id']);							
					$dt4 = mysql_fetch_array($dts4);
					
					if ($dt4['tb_catalogo_id']==$dt1['tb_catalogo_id'])
					{															
					?>
                     	<a class="btn_info_img" href="#" onClick="catalogo_info('<?php echo $dt1['tb_catalogo_id']?>')">Info</a>
                    <?php }?>

                    </td>
                    <td align="center"><?php echo $stock1;?></td>
                    <td align="center"><?php echo $stock2;?></td>
                    <td align="center"><?php echo $stock3;?></td>
                </tr>
        <?php
        	}
        mysql_free_result($dts1);
        ?>
        </tbody>
        <tr class="even">
          <td colspan="13"><?php echo $num_rows.' registros'?></td>
          <!--<td>&nbsp;</td>-->
        </tr>
</table>