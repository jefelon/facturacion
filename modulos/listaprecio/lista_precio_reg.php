<?php
session_start();
require_once("../../config/Cado.php");
require_once("../formatos/formatos.php");
require_once ("../listaprecio/cListaprecio.php");
$oListaprecio = new cListaprecio();

if($_POST['action']=="insertar"){
    if ($_POST['precio_id']){
        $lprec = $oListaprecio->mostrarListaprecio($_POST['prod_id'], $_POST['precio_id']);
        $nro_rows = mysql_num_rows($lprec);
        if ($nro_rows == 0) {
            $oListaprecio->insertar($_POST['prod_id'], $_POST['precio_id'], moneda_mysql($_POST["precos_alt"]), moneda_mysql($_POST["preven_alt"]), moneda_mysql($_POST["cat_uti_alt"]));
        } else {
            $lprecs = mysql_fetch_array($lprec);
            $oListaprecio->modificar($lprecs["tb_detallelistaprecio_id"], moneda_mysql($_POST["precos_alt"]), moneda_mysql($_POST["preven_alt"]), moneda_mysql($_POST["cat_uti_alt"]));
        }
        echo 'Se registro correctamente la lista';
    }else{
        echo 'Seleccione una lista';
    }
}