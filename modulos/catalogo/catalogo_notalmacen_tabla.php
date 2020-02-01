<?php
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

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

if($_POST['tipo']==2)
{
	if($_POST['alm_id']>0)
	{
		$dts1=$oCatalogo->catalogo_notalmacen_filtro_salida($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['alm_id'],$_POST['verven'],$_POST['vercom'],$_POST['unibas'],$_POST['limit']);
		$num_rows= mysql_num_rows($dts1);
	}
	else
	{
		$num_rows=0;
	}
}


if($_POST['tipo']==1)
{
	$dts1=$oCatalogo->catalogo_notalmacen_filtro_entrada($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['verven'],$_POST['vercom'],$_POST['unibas'],$_POST['limit']);
	$num_rows= mysql_num_rows($dts1);
}
?>
<script type="text/javascript">

$('.moneda').autoNumeric({
    mDec: '2',
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999.99'
});
$('.cantidad--').autoNumeric({
    mDec: '2',
	aSep: ',',
	aDec: '.',
	vMin: '1',
	vMax: '99999'
});

function cantidad(act,idf)
{
<?php
if($_POST['tipo']==2)
{
?>
	//salida
	
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
	
<?php
}

if($_POST['tipo']==1)
{
?>
	//entrada
	var can=($('#txt_cat_can_'+idf).val())*1;
	//var sto=($('#hdd_cat_stouni_'+idf).val())*1;
	var valor=0;
	var sum=1;
	
	if(act=='mas')
	{
		valor=can+sum;
		if(valor<=9999)$('#txt_cat_can_'+idf).val(valor);
	}
	
	if(act=='menos')
	{
		valor=can-sum;
		if(valor>=1)$('#txt_cat_can_'+idf).val(valor);
	}
<?php
}
?>
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

$(".btn_mas").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });
$(".btn_menos").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$(document).ready(function() {
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			3: {sorter: false }, 
			4: { sorter: false}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0]]
		<?php }?>
    });


}); 
</script>
<?php
if($_POST['alm_id']=="")
{
	echo 'Por favor seleccione Almacén para mostrar Productos.';
}

//vista de tablas

if($_POST['tipo']==2)
{
?>
<table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <!--<th>CODIGO</th>-->
                  <th>NOMBRE</th>
                  <!--<th>PRESENTACION</th>-->
                  <th>UNIDAD</th>
                  <th align="right">STOCK</th>
                  <th width="110" align="center">CANTIDAD</th>
                  <th width="50">&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
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

					?>
                        <tr>
                          <!--<td><?php //echo $dt1['tb_presentacion_cod']?></td>-->
                          <td>
                            <span style="">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                            </td>
                            <!--<td>
							<span style="">
							<?php //echo $dt1['tb_presentacion_nom']?>
                            </span>
                            </td>-->
                            <td title="<?php echo $dt1['tb_unidad_nom']?>">
							<span style="">
							<?php echo $dt1['tb_unidad_abr']?>
                            </span>
                            </td>
                            <td align="right">
                            <span style="">
							<?php echo $stock_unidad?>
                            </span>
                            <input name="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>" id="hdd_cat_stouni_<?php echo $dt1['tb_catalogo_id']?>"  type="hidden" value="<?php echo $stock_unidad?>">
                            </td>
                            <td align="center">
                            <input name="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" class="cantidad" value="1" size="5" maxlength="6" style="text-align:right">
                            <a class="btn_mas" href="#mas" onClick="cantidad('mas','<?php echo $dt1['tb_catalogo_id']?>')">Aumentar</a>
                            <a class="btn_menos" href="#menos" onClick="cantidad('menos','<?php echo $dt1['tb_catalogo_id']?>')">Disminuir</a>
                            </td>
                            <td align="center">
                            <?php if($stock_unidad!=0){?>
                            
                            <a class="btn_agregar" href="#" onClick="notalmacen_car('agregar','<?php echo $dt1['tb_catalogo_id']?>')">Agregar</a>
                            <?php }?>
                            </td>
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
                  <td colspan="6"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
<?php
}

if($_POST['tipo']==1)
{
?>
<table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <!--<th>CODIGO</th>-->
                  <th>NOMBRE</th>
                  <!--<th>PRESENTACION</th>-->
                  <th>UNIDAD</th>
                  <th width="110" align="center">CANTIDAD</th>
                  <th width="50">&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
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

					?>
                        <tr>
                          <!--<td><?php //echo $dt1['tb_presentacion_cod']?></td>-->
                          <td>
                            <span style="">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                            </td>
                            <!--<td>
							<span style="">
							<?php //echo $dt1['tb_presentacion_nom']?>
                            </span>
                            </td>-->
                            <td title="<?php echo $dt1['tb_unidad_nom']?>">
							<span style="">
							<?php echo $dt1['tb_unidad_abr']?>
                            </span>
                            </td>
                            <td align="center">
                            <input name="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" class="cantidad" value="1" size="5" maxlength="6" style="text-align:right">
                            <a class="btn_mas" href="#mas" onClick="cantidad('mas','<?php echo $dt1['tb_catalogo_id']?>')">Aumentar</a>
                            <a class="btn_menos" href="#menos" onClick="cantidad('menos','<?php echo $dt1['tb_catalogo_id']?>')">Disminuir</a>
                            </td>
                            <td align="center">                            
                            <a class="btn_agregar" href="#" onClick="notalmacen_car('agregar','<?php echo $dt1['tb_catalogo_id']?>')">Agregar</a>
                            </td>
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
                  <td colspan="5"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
<?php }?>