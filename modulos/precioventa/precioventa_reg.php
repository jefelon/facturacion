<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();

foreach($_SESSION['precioventa'] as $indice=>$valor){	
	$oCatalogo->actualizar_precio_venta($valor,$_POST["txt_preven_$valor"]);
}
unset($_SESSION['precioventa']);
?>