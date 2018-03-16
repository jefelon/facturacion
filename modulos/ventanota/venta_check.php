<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoProducto = new cCatalogoProducto();
require_once("../formatos/formato.php");

$almacen_venta=$_SESSION['almacen_id'];

if(isset($_SESSION['ventanota_car']))
{
	foreach($_SESSION['ventanota_car'] as $indice=>$catalogo_id)
	{			
		//presentacion catalogo
		$dts=$oCatalogoProducto->presentacion_catalogo_stock_almacen($catalogo_id,$almacen_venta);
		$dt = mysql_fetch_array($dts);
			$pro_nom=$dt['tb_producto_nom'];
			$pre_nom=$dt['tb_presentacion_nom'];
			$pre_id	=$dt['tb_presentacion_id'];
			$sto_num=$dt['tb_stock_num'];
			$cat_mul=$dt['tb_catalogo_mul'];
			$nombre_producto=$pro_nom.' '.$pre_nom;
		mysql_free_result($dts);
		
		$cantidad=$_SESSION['ventanota_can'][$indice];
		//conversion a la minima unidad
		$stock_venta=$cantidad*$cat_mul;

		//SUMA ACUMULATIVA POR CATALOGO
		//verifico si se encuentra en el carrito
		foreach($_SESSION['ventanota_car'] as $i=>$c){
			if(($catalogo_id==$c))
			{
				$ban++;
			}
		}
		
		//encontar mas de una coincidencia para saber que se encuentra en el carrito
		if($ban>2){
			$cantidad_carro=$_SESSION['catalogo_suma'][$catalogo_id];
			$_SESSION['catalogo_suma'][$catalogo_id]=$cantidad_carro+$stock_venta;
		}
		else
		{
			$_SESSION['catalogo_suma'][$catalogo_id]=$stock_venta;
		}
		
		
		/*$num=0;
		foreach($_SESSION['ventanota_car'] as $i=>$c){
			if(($catalogo_id==$c))
			{
				$num++;
			}
		}
		
		if($num==0)
		{
			if($stock_venta>$sto_num)
			{
				$dif=$stock_venta-$sto_num;
				$array_pre[$nombre_producto]=$dif;
				$error1=1;
			}
		}*/
		//NO DISPONIBLE YA QUE NO ENTRA OTRAS UNIDADES DE LA MISMA PRESENTACION
		/*if($num==1)
		{
			foreach($_SESSION['ventanota_car'] as $i=>$c){
				if(($indice!=$i) and ($pre_id==$_SESSION['vn_presentacion_id'][$i]))
				{
					$t1=$cat_mul*$cantidad;
					$t2=$_SESSION['vn_catalogo_mul'][$i]*$_SESSION['ventanota_car'][$i];
					//echo 'N='.$_POST['cat_id'].' nN='.$t1.'<br>';
					//echo 'S='.$indice.' nS='.$t2.'<br>';
					//echo 'stock='.$sto_num.'<br>';
					$ped=$t1+$t2;
					$dif=$ped-$sto_num;
					//echo 'pedido='.$ped.'<br>';
					
					if($ped>$sto_num)
					{
						$array_pre[$nombre_producto]=$dif;
						$error1=1;
					}
				}
			}			
		}*/
		
		
		
	}
}

if(isset($_SESSION['catalogo_suma']))
foreach($_SESSION['catalogo_suma'] as $cat_id=>$can){
	//presentacion catalogo
	$dts=$oCatalogoProducto->presentacion_catalogo_stock_almacen($cat_id,$almacen_venta);
	$dt = mysql_fetch_array($dts);
		$pro_nom=$dt['tb_producto_nom'];
		$pre_nom=$dt['tb_presentacion_nom'];
		$pre_id	=$dt['tb_presentacion_id'];
		$sto_num=$dt['tb_stock_num'];
		$cat_mul=$dt['tb_catalogo_mul'];
		$nombre_producto=$pro_nom;
	mysql_free_result($dts);
	
	if($can>$sto_num)
	{
		$dif=$can-$sto_num;
		$array_pre[$nombre_producto]=$dif;
		$error1=1;
	}
			
	//echo $cat_id.'-'.$can.' | ';
}
unset($_SESSION['catalogo_suma']);
?>
<?php
if($error1==1){
?>
<script type="text/javascript">
$('.btn_arre_car').button({
	icons: {
		//primary: "ui-icon-cart"//,
		secondary: "ui-icon-cart"
	},
	text: true
});
</script>
<div style="width:380px; height:180px; float:left;" class="ui-widget-content">
<?php
	echo 'Stock insuficiente para:<br>';
	foreach($array_pre as $p=>$d){
		echo "<li>$p - Disminuir cantidad en $d.</li>";
	}
?>
</div>
<?php }
else
{
	echo 'correcto';
}?>