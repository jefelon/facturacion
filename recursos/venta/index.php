<?php
session_start();
$_SESSION["autentificado2"] = "SI";
$_SESSION['empresa_id']=1;
/*
if($_SESSION['usuariogrupo_id']==2)require('venta_vista_adm.php');
if($_SESSION['usuariogrupo_id']==3)require('venta_vista.php');
*/
require('venta_vista.php')

?>