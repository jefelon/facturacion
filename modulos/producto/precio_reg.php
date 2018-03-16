<?php
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../producto/cPrecio.php");
$oPrecio = new cPrecio();
require_once("../formatos/formato.php");

//actualizacion de utilidad y precio de venta
if($_POST['action']=="actualizar_precio_panel")
{
	$catalogo_id=$_POST['cat_id'];
	
	if ($_POST["cat_preven"]!="") {

		$dts= $oCatalogoproducto->actualizar_precio_venta($_POST['cat_id'],$_POST["cat_uti"],moneda_mysql($_POST["cat_preven"]));

		$dts= $oCatalogoproducto->actualizar_precio_compra_dolar($_POST['cat_id'],$_POST["cat_tipcam"],moneda_mysql($_POST["cat_precosdol"]));

		$dts= $oCatalogoproducto->actualizar_precio_costo($_POST['cat_id'],moneda_mysql($_POST["cat_precos"]));
	}
	
	//-------------PRECIO 1
	if ($_POST["predet_val1"]!="") {
		$precio_id=1;
		$rws = $oPrecio->consultar_precio_por_catalogo($precio_id,$_POST['cat_id']);
		$rw = mysql_fetch_array($rws);
		$predet_id1=$rw['tb_preciodetalle_id'];
		$predet_val1=$rw['tb_preciodetalle_val'];
		mysql_free_result($rws);

		if($predet_id1>0)
		{
			$dts= $oPrecio->modificar_preciodetalle($predet_id1,moneda_mysql($_POST["predet_val1"]));
		}
		else
		{
			$dts= $oPrecio->insertar_preciodetalle($precio_id,$_POST['cat_id'],moneda_mysql($_POST["predet_val1"]));
		}
	}
	
	//-------------PRECIO 2
	if ($_POST["predet_val2"]!="") {
		$precio_id=2;
		$rws = $oPrecio->consultar_precio_por_catalogo($precio_id,$_POST['cat_id']);
		$rw = mysql_fetch_array($rws);
		$predet_id2=$rw['tb_preciodetalle_id'];
		$predet_val2=$rw['tb_preciodetalle_val'];
		mysql_free_result($rws);

		if($predet_id2>0)
		{
			$dts= $oPrecio->modificar_preciodetalle($predet_id2,moneda_mysql($_POST["predet_val2"]));
		}
		else
		{
			$dts= $oPrecio->insertar_preciodetalle($precio_id,$_POST['cat_id'],moneda_mysql($_POST["predet_val2"]));
		}
	}
	//echo "$_POST['cat_id'] - $uti - $preven";
	echo "Ok";
}