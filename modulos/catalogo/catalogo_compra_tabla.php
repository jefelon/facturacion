<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once ("../formatos/formato.php");


$igv_dato=0.18;
//TIPO DE PRECIO
if($_POST['tippre']==1)
{
	$mul1=1;
	$texto_precio='VALOR COMPRA';
}

if($_POST['tippre']==2)
{
	$mul1=1+$igv_dato;
	$texto_precio='PRECIO COMPRA';
}
//TIPO DE MONEDA
if($_POST['mon']==1)
{
	$mul2=$_POST['tipcam'];
	$texto_moneda='S/.';	
}

if($_POST['mon']==2)
{
	$mul2=1/$_POST['tipcam'];
	$texto_moneda='US$';
}

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

$dts1=$oCatalogo->catalogo_compra_filtro($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'], $_POST['limit'],$_POST['prov_id']);

$num_rows= mysql_num_rows($dts1);

?>
<script type="text/javascript">

$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.000',
	vMax: '9999.99'
});
$('.porcentaje').autoNumeric({
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
    vMin: '0.00',
    vMax: '99999.99'
});

function cantidad(act,idf)
{
	var can=($('#txt_cat_can_'+idf).val())*1;
	//var sto=($('#hdd_cat_stouni_'+idf).val())*1;
	var valor=0;
	var sum=1;
	
	if(act=='mas')
	{
		valor=can+sum;
		if(valor<=999)$('#txt_cat_can_'+idf).val(valor);
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

$(".focus_precom, .cantidad, .porcentaje ").one("keypress", function (e) {
    e.target.value = e.target.value[0];
});

$(".btn_mas").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });
$(".btn_menos").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$(function() {	
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			7: {sorter: false }, 
			8: { sorter: false}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[1,0]]
		<?php }?>
    });

}); 
</script>

        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <!--<th>PRESENTACION</th>-->
                    <th>UNIDAD</th>
                    <th align="right" nowrap="nowrap"><?php echo $texto_precio?></th>
                  	<th align="center">CANTIDAD</th>
               	  <th align="right" nowrap="nowrap" title="DESCUENTO %">DSCTO %</th>
               	  <th align="right">FLETE S/.</th>
                    <th>TIPO</th>
               	  <th >&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
						//precio_unitario_compra
						$precio_unitario_compra=formato_money($dt1['tb_catalogo_preunicom']*$mul1*$mul2);
						
						?>
                        <tr>
                            <td><?php echo $dt1['tb_presentacion_cod']?></td>
                            <td>
							<?php 
							echo $dt1['tb_producto_nom'];
							?></td>
                            <!--<td>
							<?php 
							//echo ''.$dt1['tb_presentacion_nom'].'';
							?></td>-->
                            <td><?php echo $dt1['tb_unidad_abr']?></td>                           
                            <td align="right">
                            <?php echo $texto_moneda?>

                                <!--Descuento del producto (este valor va en el Detalle compra)-->
                                <?php
                                if($_POST['prov_id']){
                                    $dts22=$oCatalogo->catalogo_compra_filtro_descuento($dt1['tb_producto_id'],$_POST['prov_id']);
                                    $dt33 = mysql_fetch_array($dts22);

                                    $costoPactado=$precio_unitario_compra;
                                    if($dt33['tb_productoproveedor_cantmin']>0){
                                        $costoPactado=  $dt33['tb_productoproveedor_cantmin'];
                                    }
                                    $descuento=  $dt33['tb_productoproveedor_desc'];
                                    mysql_free_result($dts22);
                                }
                                ?>

                            <input class="focus_precom moneda" name="txt_cat_precom_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_precom_<?php echo $dt1['tb_catalogo_id']?>" value="<?php echo formato_decimal($costoPactado, 3)?>" size="10" maxlength="8" style="text-align:right">
							</td>                            
                            <td align="center">
                            <input name="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" class="cantidad" value="1" size="5" maxlength="6" style="text-align:right">
                            <a class="btn_mas" href="#mas" onClick="cantidad('mas','<?php echo $dt1['tb_catalogo_id']?>')">Aumentar</a>
                            <a class="btn_menos" href="#menos" onClick="cantidad('menos','<?php echo $dt1['tb_catalogo_id']?>')">Disminuir</a>
                            </td>
                            <td align="right">
                            <input type="text" name="txt_detcom_des_<?php echo $dt1['tb_catalogo_id']?>" id="txt_detcom_des_<?php echo $dt1['tb_catalogo_id']?>" class="porcentaje" value="<?php echo formato_decimal($descuento,3) ?>" size="6" maxlength="5" style="text-align:right"></td>
                            <td align="right">
							<input type="text" name="txt_detcom_fle_<?php echo $dt1['tb_catalogo_id']?>" id="txt_detcom_fle_<?php echo $dt1['tb_catalogo_id']?>" class="moneda" value="<?php //echo $dt1['tb_compradetalle_fle']?>" size="8" maxlength="8" style="text-align:right">
                            </td>
                            <td>
                                <select name="cmb_afec_id" id="cmb_afec_id_<?php echo $dt1['tb_catalogo_id']?>">
                                    <option value="1">GRAVADO</option>
                                    <option value="9">EXONERADO</option>
                                    <option value="6">BONIFICACION</option>
                                </select>
                            </td>
                         
                            <td align="center"><a class="btn_agregar" href="#" onClick="compra_car('agregar', '<?php echo $dt1['tb_catalogo_id']?>','<?php echo $_POST['tippre']?>')">Agregar</a></td>
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
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
<script>
    $('#txt_cat_precom_6').focus()
</script>
