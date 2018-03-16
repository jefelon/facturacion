<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("cCatalogo_encarte.php");
$oCatalogo = new cCatalogo();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once ("../catalogo/cst_producto.php");
require_once ("../formatos/formato.php");

$encdet_despor=$_POST['enc_despor'];
if($encdet_despor=="")$encdet_despor=0;

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

$dts1=$oCatalogo->catalogo_encarte_filtro($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'], $_POST['limit']);

$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">

$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999.99'
});
$('.porcentaje_c').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99.99'
});
$('.cantidad').autoNumeric({
	aSep: ',',
	aDec: '.',
	vMin: '1',
	vMax: '99999'
});

$('.btn_agregar').button({
	icons: {
		//primary: "ui-icon-plusthick",
		secondary:"ui-icon-cart"
	},
	text: true
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

function calculo_precioventa_uti2(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var uti2		=parseFloat($("#txt_cat_uti2_"+idf ).autoNumericGet());
	var preven1	=parseFloat($("#txt_cat_preven1_"+idf).autoNumericGet());
	
	if(uti2>=0)
	{
		var utilidad=uti2/100;
		var preven2=precos/(1-utilidad);
		$( "#txt_cat_preven2_"+idf).autoNumericSet(preven2.toFixed(1));
		
		//porcentaje
		var descuento=(1-preven2/preven1)*100;
		$( "#txt_encdet_despor_"+idf).autoNumericSet(descuento.toFixed(2));
	}
	else
	{
		alert('Utilidad negativa.');
		$( "#txt_cat_uti2_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_cat_preven2_"+idf).autoNumericSet(calculo.toFixed(1));
	}
	
}

function calculo_precioventa_preven2(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var preven2	=parseFloat($("#txt_cat_preven2_"+idf).autoNumericGet());
	var preven1	=parseFloat($("#txt_cat_preven1_"+idf).autoNumericGet());
	
	if(preven2>0 && preven2>=precos)
	{
		//utilidad
		var calculo=(1-precos/preven2)*100;
		$( "#txt_cat_uti2_"+idf).autoNumericSet(calculo.toFixed(2));
		
		//porcentaje
		var descuento=(1-preven2/preven1)*100;
		$( "#txt_encdet_despor_"+idf).autoNumericSet(descuento.toFixed(2));
	}
	else
	{
		alert('Precio de Venta Calculado debe ser mayor que Precio Costo.');
		
		$( "#txt_cat_uti2_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		
		var preven2=precos/(1-utilidad);
		$("#txt_cat_preven2_"+idf).autoNumericSet(preven2.toFixed(1));
		
		//porcentaje
		var descuento=(1-preven2/preven1)*100;
		$( "#txt_encdet_despor_"+idf).autoNumericSet(descuento.toFixed(2));
	}
	
}

function calculo_precioventa_despor(idf)
{
	var precos	=parseFloat($("#txt_cat_precos_"+idf).autoNumericGet());
	var preven1	=parseFloat($("#txt_cat_preven1_"+idf).autoNumericGet());
	var uti1		=parseFloat($("#txt_cat_uti1_"+idf ).autoNumericGet());
	var despor	=parseFloat($("#txt_encdet_despor_"+idf ).autoNumericGet());
	
	if(despor>=0 && despor<=uti1)
	{
		//precioventa
		var preven2=(1-despor/100)*preven1;
		$( "#txt_cat_preven2_"+idf).autoNumericSet(preven2.toFixed(2));
		
		//utilidad
		var calculo=(1-precos/preven2)*100;
		$( "#txt_cat_uti2_"+idf).autoNumericSet(calculo.toFixed(2));

	}
	else
	{
		alert('Precio de Venta Calculado debe ser mayor que Precio Costo.');
		
		$( "#txt_cat_uti2_"+idf).autoNumericSet(0);
		var utilidad=0/100;
		
		var preven2=precos/(1-utilidad);
		$("#txt_cat_preven2_"+idf).autoNumericSet(preven2.toFixed(1));
		
		//porcentaje
		var descuento=(1-preven2/preven1)*100;
		$( "#txt_encdet_despor_"+idf).autoNumericSet(descuento.toFixed(2));
	}
	
}

$(function() {	
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			2: {sorter: false },
			3: {sorter: false },
			4: {sorter: false },
			5: {sorter: false }, 
			6: { sorter: false}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0]]
		<?php }?>
    });

}); 
</script>

        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <th>NOMBRE</th>
                    <th>UNIDAD</th>
                    <th align="center" nowrap title="COSTO EN SOLES">COSTO PROM</th>
                    <th align="right" nowrap title="PRECIO DE VENTA">UTI% | P.  VENTA S/.</th>
                  <th align="right" nowrap="nowrap" title="DESCUENTO %">DSCTO %</th>
                 	<th align="right" nowrap title="PRECIO MINIMO">UTI% | P.  VENTA. S/.</th>
               	  <th >&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
						
						//stock general para calculo de costo promedio-- almacen=0
						$stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
						
						$costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$dt1['tb_catalogo_precos'],$dt1['tb_catalogo_precosdol'],$_SESSION['empresa_id']);
						
						$costo_ponderado=$costo_ponderado_array['soles'];
											
						//$utilidad=$dt1['tb_catalogo_uti']/100;
						//$precio_sugerido=number_format(moneda_mysql($costo_ponderado)/(1-$utilidad),1);
						
						$precio_venta1=$dt1['tb_catalogo_preven'];
						if($precio_venta1>0)$utilidad1=(1-($costo_ponderado/$precio_venta1))*100;
						
						//calculo de precio venta - descuento en porcentaje
						$precio_venta2=$precio_venta1*(1-($encdet_despor/100));
						if($precio_venta2>0)$utilidad2=(1-$costo_ponderado/$precio_venta2)*100;
						$precio_venta2=round($precio_venta2,1);
						
						?>
                        <tr>
                            <td>
							<?php 
							echo $dt1['tb_producto_nom'];
							?></td>
                            <td><?php echo $dt1['tb_unidad_abr']?></td>
                            <td align="center"><input name="txt_cat_precos_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_precos_<?php echo $dt1['tb_catalogo_id']?>" value="<?php if($costo_ponderado!=0)echo formato_money($costo_ponderado)?>" size="7" maxlength="8" style="text-align:right" readonly></td>
                            <td align="right" nowrap="nowrap"><input name="txt_cat_uti1_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_uti1_<?php echo $dt1['tb_catalogo_id']?>" style="text-align:right" onChange="calculo_precioventa_uti('<?php echo $utilidad1?>')" value="<?php if($utilidad1!=0) echo formato_money($utilidad1)?>" size="6" maxlength="5" readonly>
                          <input name="txt_cat_preven1_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_preven1_<?php echo $dt1['tb_catalogo_id']?>" style="text-align:right" onChange="calculo_precioventa_preven('<?php echo $dt1['tb_catalogo_id']?>')" value="<?php if($precio_venta1!=0) echo formato_money($precio_venta1)?>" size="7" maxlength="8" readonly></td>
                            <td align="right">
                            <input type="text" name="txt_encdet_despor_<?php echo $dt1['tb_catalogo_id']?>" id="txt_encdet_despor_<?php echo $dt1['tb_catalogo_id']?>" class="porcentaje_c" value="<?php echo $encdet_despor?>" size="6" maxlength="5" style="text-align:right" onChange="calculo_precioventa_despor('<?php echo $dt1['tb_catalogo_id']?>')"></td>
                            <td align="right" nowrap><input name="txt_cat_uti2_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_uti2_<?php echo $dt1['tb_catalogo_id']?>" class="porcentaje_c" value="<?php echo formato_money($utilidad2)?>" size="6" maxlength="5" style="text-align:right" onChange="calculo_precioventa_uti2('<?php echo $dt1['tb_catalogo_id']?>')">
                              <input name="txt_cat_preven2_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_preven2_<?php echo $dt1['tb_catalogo_id']?>" class="moneda" value="<?php echo formato_money($precio_venta2)?>" size="7" maxlength="8" style="text-align:right" onChange="calculo_precioventa_preven2('<?php echo $dt1['tb_catalogo_id']?>')"></td>
                            <td align="center"><a class="btn_agregar" href="#" onClick="encarte_car('agregar','<?php echo $dt1['tb_catalogo_id']?>')">Agregar</a></td>
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
                  <td colspan="7"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
