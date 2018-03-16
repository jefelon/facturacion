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
require_once ("../catalogoimagen/cCatalogoimagen.php");
$oCatalogoimg = new cCatalogoimagen();

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

$dts1=$oCatalogo->catalogo_venta_filtro_barras($_SESSION['almacen_id'],$_POST['pro_nom'],$_POST['pro_cod'],$_POST['pro_codbar'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['limit']);
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
$('.cantidad_cat_ven').autoNumeric({
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
$('.btn_info').button({
	icons: {
		//primary: "ui-icon-info"
	},
	text: true
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
		sortList: [[1,0]]
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

<input id="hdd_catimg_id" name="hdd_catimg_id" type="hidden" value="<?php echo $_POST['catimg_id']; ?>">


<div id="div_consulta_stock">
</div>
        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <th align="right">CODIGO</th>
                  <th>NOMBRE</th>
                  <th align="right" nowrap title="PRECIO VENTA ACTUAL">PRECIO S/.</th>
                  <th align="right">STOCK</th>
                  <th width="110" align="center">CANTIDAD</th>
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
							
					?>
                        <tr>
                          <td align="right"><?php echo $dt1['tb_presentacion_cod']?></td>
                          <td>
                            <span class="tip-producto" id="../producto/producto_detalle.php?pro_id=<?php echo $dt1['tb_producto_id']?>">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                            <?php
														if($num_rows_encarte>=1)
														{
                            echo '<span class="alerta_r" title="PRODUCTO EN PROMOCIÓN">Des. '.$enc_despor.'% | S/. '.$enc_preven2.'</span>';
														}
														?>
                            
                            </td>
                            <td align="right" nowrap="nowrap">
                            
                            <input name="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" value="<?php echo $dt1['tb_catalogo_preven']?>" size="8" maxlength="8" style="text-align:right; font-size:10px; font-weight:bold" class="moneda">
                            
                    </td>
                            <td align="right">
                            <span style="font-weight: bold;">
							<?php echo $stock_unidad?>
                            </span>
                            <input name="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>" id="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>"  type="hidden" value="<?php echo $stock_unidad?>">
                            </td>
                            <td align="center">
                            <input name="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" class="cantidad_cat_ven" value="1" size="5" maxlength="6" style="text-align:right">
                            <a class="btn_mas" href="#mas" onClick="cantidad('mas','<?php echo $dt1['tb_catalogo_id']?>')">Aumentar</a>
                            <a class="btn_menos" href="#menos" onClick="cantidad('menos','<?php echo $dt1['tb_catalogo_id']?>')">Disminuir</a>
                            </td>
                            <td align="center" nowrap="nowrap">
                            <?php if($stock_unidad!=0){?>
                            
                            <a class="btn_agregar" href="#" onClick="nueva_busqueda(); catalogoimagendetalle_reg('insertar','<?php echo $dt1['tb_catalogo_id']?>')">Agregar</a>
                            <?php }?>
                           
                        </tr>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <tr class="even">
                  <td colspan="10"><?php echo $num_rows.' registros'?></td>
                  <!--<td>&nbsp;</td>-->
                </tr>
        </table>
