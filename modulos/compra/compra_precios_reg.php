<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../formatos/formato.php");

//actualizacion de utilidad y precio de venta
foreach($_SESSION['precio_car'] as $indice=>$catalogo_id){

	$uti	=$_POST["txt_cat_uti_$catalogo_id"];
	$preven	=moneda_mysql($_POST["txt_cat_preven_$catalogo_id"]);
	$dts= $oCatalogoproducto->actualizar_precio_venta($catalogo_id,$uti,$preven);
}

unset($_SESSION['precio_car']);
echo 'Se actualizó precios de venta correctamente.';