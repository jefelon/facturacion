<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
$oCompra = new cCompra();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../formatos/formato.php");

//actualizacion de utilidad y precio de venta

$dts1=$oCompra->mostrar_compra_detalle($_POST['hdd_com_id']);
$num_rows= mysql_num_rows($dts1);

while($dt1 = mysql_fetch_array($dts1)){
	$catalogo_id=$dt1['tb_catalogo_id'];
	
	$uti	=$_POST["txt_cat_uti_$catalogo_id"];
	$preven	=moneda_mysql($_POST["txt_cat_preven_$catalogo_id"]);
	$dts= $oCatalogoproducto->actualizar_precio_venta($catalogo_id,$uti,$preven);
}
mysql_free_result($dts1);
echo 'Se actualizó precios de venta correctamente.';