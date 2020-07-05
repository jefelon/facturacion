<?php
session_start();
require_once("../../config/Cado.php");
require_once("cProducto.php");
$oProducto = new cProducto();
require_once("cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("cTag.php");
$oTag = new cTag();
require_once("cProductoproveedor.php");
$oProductoproveedor = new cProductoproveedor();
require_once("../formatos/formato.php");

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
		$oProductoproveedor->eliminar($_POST['id']);
		echo 'Se eliminó el registro correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>