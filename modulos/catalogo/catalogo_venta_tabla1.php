<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");
require_once ("../catalogo/cst_producto.php");

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

$dts1=$oCatalogo->catalogo_venta_filtro($_SESSION['almacen_id'],$_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['limit']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">

$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.99'
});
$('.cantidad').autoNumeric({
	aSep: ',',
	aDec: '.',
	vMin: '1',
	vMax: '999'
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

$(".btn_mas").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });
$(".btn_menos").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

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
		//closePosition: 'title',
		closeText: '<div align="right"><img src="../../js/cluetip/demo/cross.png" alt="close" /></div>'
	});
	
	$('.tip-producto-precio').cluetip({
		attribute: 'id',
		cluezIndex:11001,
		//cluetipClass: 'jtip',
		cluetipClass: 'rounded',
		arrows: true,
		dropShadow: false,
		sticky: true,
		mouseOutClose: true,
		hoverClass: 'ui-state-highlight',
		showTitle: false,
		//closePosition: 'title',
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
}); 
</script>
<div id="div_consulta_stock">
</div>
        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <th>NOMBRE</th>
                  <th align="right" title="COSTO PROMEDIO EXISTENCIAS">COSTO PROM</th>
                  <th align="right" title="UTILIDAD %">UTIL</th>
                  <th align="right" title="PRECIO SUGERIDO">PRECIO SUG</th>
                  <th align="right" title="PRECIO COSTO ACTUAL">P. COSTO</th>
                  <th align="right" nowrap title="PRECIO VENTA ACTUAL">PRECIO S/.</th>
                  <th align="right">STOCK</th>
                  <th width="110" align="center">CANTIDAD</th>
                  <th align="center">DESCUENTO</th>
                  <th width="50">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
						$stock=$dt1['tb_stock_num'];
						
								$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
								$st_res=$stock%$dt1['tb_catalogo_mul'];
								
								if($st_res!=0){
									//$stock_unidad="$st_uni + r$st_res";
									$stock_unidad="$st_uni";
								} else{
									$stock_unidad="$st_uni";
								}
						//stock general para calculo de costo promedio-- almacen=0
						$stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
						
						$costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$dt1['tb_catalogo_precos'],$dt1['tb_catalogo_precosdol'],$_SESSION['empresa_id']);
						
						$costo_ponderado=$costo_ponderado_array['soles'];
						
						$utilidad=$dt1['tb_catalogo_uti']/100;
						$precio_sugerido=number_format(moneda_mysql($costo_ponderado)/(1-$utilidad),1);
					?>
                        <tr>
                          <td>
                            <span class="tip-producto" id="../producto/producto_detalle.php?pro_id=<?php echo $dt1['tb_producto_id']?>">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                            <?php //echo $dt1['tb_presentacion_nom']?>
                            <!--<span style="">
							<?php //echo $dt1['tb_unidad_abr']?>
                            </span>-->
                            </td>
                          <td align="right"><?php echo formato_money($costo_ponderado)?></td>
                          <td align="right"><span style="font-weight:normal;"><?php echo $dt1['tb_catalogo_uti']?></span></td>
                          <td align="right"><?php echo formato_money(moneda_mysql($precio_sugerido))?></td>
                          <td align="right"><span style="font-weight:normal;"> <?php echo $dt1['tb_catalogo_precos']?> </span></td>
                            <td align="right">
                            <!--<span style="font-weight: bold;">
							<?php echo $dt1['tb_catalogo_preven']?>
                            </span>-->
                            <input name="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" value="<?php echo $dt1['tb_catalogo_preven']?>" size="8" maxlength="8" style="text-align:right; font-size:10px; font-weight:bold" class="moneda">
                            <!--<input name="txt_cat_preven_<?php //echo $dt1['tb_catalogo_id']?>" type="hidden" id="txt_cat_preven_<?php //echo $dt1['tb_catalogo_id']?>" value="<?php //echo $dt1['tb_catalogo_preven']?>">-->
                    </td>
                            <td align="right">
                            <span style="font-weight: bold;">
							<?php echo $stock_unidad?>
                            </span>
                            <input name="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>" id="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>"  type="hidden" value="<?php echo $stock_unidad?>">
                            </td>
                            <td align="center">
                            <input name="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" class="cantidad" value="1" size="5" maxlength="6" style="text-align:right">
                            <a class="btn_mas" href="#mas" onClick="cantidad('mas','<?php echo $dt1['tb_catalogo_id']?>')">Aumentar</a>
                            <a class="btn_menos" href="#menos" onClick="cantidad('menos','<?php echo $dt1['tb_catalogo_id']?>')">Disminuir</a>
                            </td>
                            <td align="left" style="width:130px">
                            <!--Descuento del producto (este valor va en el Detalle Venta)-->
                            
                            <div id="rad_cat_tip_des_<?php echo $dt1['tb_catalogo_id']?>" class="rad_tip_des" style="width:75px; float:left">
                              <label for="rad_cat_tip_des_1_<?php echo $dt1['tb_catalogo_id']?>">%</label>
                              <input name="rad_cat_tip_des_<?php echo $dt1['tb_catalogo_id']?>" type="radio" id="rad_cat_tip_des_1_<?php echo $dt1['tb_catalogo_id']?>" value="1" checked />
                              <label for="rad_cat_tip_des_2_<?php echo $dt1['tb_catalogo_id']?>">S/.</label>
                              <input name="rad_cat_tip_des_<?php echo $dt1['tb_catalogo_id']?>" type="radio" id="rad_cat_tip_des_2_<?php echo $dt1['tb_catalogo_id']?>" value="2" />
                            </div>
                            
                            <div style="width:30px; float:left;"><input type="text" name="txt_detven_des_<?php echo $dt1['tb_catalogo_id']?>" id="txt_detven_des_<?php echo $dt1['tb_catalogo_id']?>" class="moneda" size="6" maxlength="8" style="text-align:right"></div>
                            </td>
                            <td align="center" nowrap="nowrap">
                            <?php if($stock_unidad!=0){?>
                            
                            <a class="btn_agregar" href="#" onClick="venta_car('agregar','<?php echo $dt1['tb_catalogo_id']?>')">Agregar</a>
                            <?php }?>
                            <a class="btn_stock" href="#" onClick="consulta_stock('<?php echo $dt1['tb_catalogo_id']?>')">Consultar Stock</a>
                            </td>
                        </tr>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <tr class="even">
                  <td colspan="12"><?php echo $num_rows.' registros'?></td>
                  <!--<td>&nbsp;</td>-->
                </tr>
        </table>
