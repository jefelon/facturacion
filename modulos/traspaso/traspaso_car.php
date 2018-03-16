<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../formatos/formato.php");

$almacen_traspaso=$_POST['alm_ori'];

//agregar a cesta
if($_POST['action']=='agregar')
{
	if($_POST['cat_can']>0)
	{
		//producto por catalogo y stock y almacen
		$dts= $oCatalogoproducto->presentacion_catalogo_stock_almacen($_POST['cat_id'],$almacen_traspaso);
		$dt = mysql_fetch_array($dts);
			$pro_nom=$dt['tb_producto_nom'];
			$pre_nom=$dt['tb_presentacion_nom'];
			$pre_id	=$dt['tb_presentacion_id'];
			$sto_num=$dt['tb_stock_num'];
			$cat_mul=$dt['tb_catalogo_mul'];
			$nombre_producto=$pro_nom.' '.$pre_nom;
		mysql_free_result($dts);
		
		$num=0;
		if(isset($_SESSION['traspaso_car']))
		{
			foreach($_SESSION['traspaso_car'] as $indice=>$cantidad){
				if(($_POST['cat_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$indice]))
				{
					$num++;
				}
			}
		}
		
		if($num==0)
		{
			$_SESSION['traspaso_car'][$_POST['cat_id']]=$_POST['cat_can'];//id cat - cantidad
			$_SESSION['presentacion_id'][$_POST['cat_id']]=$pre_id;//id cat-presentacion - pre_id
			$_SESSION['catalogo_mul'][$_POST['cat_id']]=$cat_mul;//id cat-presentacion - mul
		}
		
		if($num==1)
		{
			foreach($_SESSION['traspaso_car'] as $indice=>$cantidad){
				if(($_POST['cat_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$indice]))
				{
					$t1=$cat_mul*$_POST['cat_can'];
					$t2=$_SESSION['catalogo_mul'][$indice]*$_SESSION['traspaso_car'][$indice];
					//echo 'N='.$_POST['cat_id'].' nN='.$t1.'<br>';
					//echo 'S='.$indice.' nS='.$t2.'<br>';
					//echo 'stock='.$sto_num.'<br>';
					$ped=$t1+$t2;
					$dif=$ped-$sto_num;
					//echo 'pedido='.$ped.'<br>';
					
					if($cat_mul>$_SESSION['catalogo_mul'][$indice])
					{
						//echo 'El mayor mul es N'.$cat_mul;
						if($dif>0){
							$st_uni=floor($sto_num/$cat_mul);
							$st_res=$sto_num%$cat_mul;
						}
						
						if($ped<=$sto_num)
						{
							$st_uni=floor($ped/$cat_mul);
							$st_res=$ped%$cat_mul;
						}
						
						//unidad nueva
						$_SESSION['traspaso_car'][$_POST['cat_id']]=$st_uni;//id cat - cantidad
						$_SESSION['presentacion_id'][$_POST['cat_id']]=$pre_id;//id cat-presentacion - pre_id
						$_SESSION['catalogo_mul'][$_POST['cat_id']]=$cat_mul;//id cat-presentacion - mul
						
						//unidad en sesion
						if($st_res>0)
						{
							$_SESSION['traspaso_car'][$indice]=$st_res;
						}
						else
						{
							unset($_SESSION['traspaso_car'][$indice]);
							unset($_SESSION['presentacion_id'][$indice]);
							unset($_SESSION['catalogo_mul'][$indice]);
						}
						$msj='Se ajustó automaticamente cantidad de '.$nombre_producto;
						if($dif>0)$msj.=' desface en '.$dif.'.';
					}
					else
					{
						//echo 'El mayor mul es S'.$_SESSION['catalogo_mul'][$indice];
						if($dif>0){
							$st_uni=floor($sto_num/$_SESSION['catalogo_mul'][$indice]);
							$st_res=$sto_num%$_SESSION['catalogo_mul'][$indice];
						}
						
						if($ped<=$sto_num)
						{
							$st_uni=floor($ped/$_SESSION['catalogo_mul'][$indice]);
							$st_res=$ped%$_SESSION['catalogo_mul'][$indice];
						}

						//unidad en sesion
						if($st_res>0)
						{
							//unidad nueva
							$_SESSION['traspaso_car'][$_POST['cat_id']]=$st_res;//id cat - cantidad
							$_SESSION['presentacion_id'][$_POST['cat_id']]=$pre_id;//id cat-presentacion - pre_id
							$_SESSION['catalogo_mul'][$_POST['cat_id']]=$cat_mul;//id cat-presentacion - mul
						}
						
						$_SESSION['traspaso_car'][$indice]=$st_uni;
						
						$msj='Se ajustó automaticamente cantidad de '.$nombre_producto;
						if($dif>0)$msj.=' desface en '.$dif.'.';
					}
				}
			}			
		}
		
		if($num>1)
		{
			$msj='No se permite agregar mas de 2 unidades de una sola presentación de producto.';
		}
		
		
	}
}

//quitar valores del array
if($_POST['action']=='quitar')
{
	unset($_SESSION['traspaso_car'][$_POST['cat_id']]);
	unset($_SESSION['presentacion_id'][$_POST['cat_id']]);
	unset($_SESSION['catalogo_mul'][$_POST['cat_id']]);
}

//restablecer o eliminar array
if($_POST['action']=='restablecer')
{
	unset($_SESSION['traspaso_car']);
	unset($_SESSION['presentacion_id']);
	unset($_SESSION['catalogo_mul']);
}

if(isset($_SESSION['traspaso_car']))
{
	$num_rows=count($_SESSION['traspaso_car']);
	if($num_rows==0)$num_rows="";
}
else
{
	$num_rows="";
}
?>
<script type="text/javascript">
$('.btn_rest_car').button({
	icons: {
		//primary: "ui-icon-cart"//,
		secondary: "ui-icon-cart"
	},
	text: true
});

$('.btn_agregar_producto').button({
	icons: {
		primary:  "ui-icon-plus"
	},
	text: true
});

$('.btn_quitar').button({
	icons: {primary: "ui-icon-minus"},
	text: false
});
	
$('.btn_item').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});

$(function() {
	$("#tabla_traspaso_car").tablesorter({ 
		widgets : ['zebra'],
		headers: {
			3: {sorter: false }
			},
		//sortForce: [[0,0]],
		//sortList: [[1,0]]
    });

}); 
</script>
<input name="hdd_tra_numite" id="hdd_tra_numite" type="hidden" value="<?php echo $num_rows?>">
<fieldset><legend>Detalle</legend>
<a class="btn_agregar_producto" title="Agregar Producto (A+P)" href="#" onClick="catalogo_traspaso()">Agregar Producto</a>
<a class="btn_rest_car" href="#" onClick="traspaso_car('restablecer')">Vaciar</a>
<div id="msj_traspaso_car" class="ui-state-error ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php if($msj!=""){echo 'block';} else{ echo 'none';}?>"><?php echo $msj?></div>
<div id="msj_traspaso_check" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
<?php 
	if($num_rows=="" or $num_rows==0)echo 'Ningún ítem agregado.';
	if($num_rows==1)echo $num_rows.' ítem agregado.';
	if($num_rows>=2)echo $num_rows.' ítems agregados.';
?>
</fieldset>
        <table cellspacing="1" id="tabla_traspaso_car" class="tablesorter">
            <thead>
                <tr>
                  <th>PRODUCTO</th>
                  <!--<th>PRESENTACION</th>-->
                  <th align="left">UNIDAD</th>
                  <th align="right" title="CANTIDAD">CANT</th>
                  <th width="25">&nbsp;</th>
                </tr>
            </thead>
       <?php
if($num_rows>=1){
?>
            <tbody>
            <?php
			foreach($_SESSION['traspaso_car'] as $indice=>$cantidad){			
				$dts1=$oCatalogoproducto->presentacion_catalogo_stock_almacen($indice,$almacen_traspaso);
				$dt1 = mysql_fetch_array($dts1);
			?>
                        <tr>
                          <td><?php echo $dt1['tb_producto_nom']?></td>
                            <!--<td><?php //echo $dt1['tb_presentacion_nom']?></td>-->
                            <td align="left" title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                          <td align="right"><?php echo $cantidad?></td>
                            <td align="center" nowrap="nowrap">
                            <a class="btn_item" href="#" onClick="editar_datos_item('<?php echo $dt1['tb_catalogo_id']?>','<?php echo $dt1['tb_producto_nom']?>')">Actualizar Datos de Item</a>
                            <a class="btn_quitar" href="#" onClick="traspaso_car('quitar','<?php echo $dt1['tb_catalogo_id']?>')">Quitar</a></td>
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
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
<?php
}
?>
        </table>