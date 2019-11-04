<?php
session_start();
require_once("../../config/Cado.php");
require_once("../formatos/formatos.php");
require_once ("../listaprecio/cListaprecio.php");
$oListaprecio = new cListaprecio();


if ($_POST['precio_id']) {
    $lprec = $oListaprecio->mostrarListaprecio($_POST['prod_id'], $_POST['precio_id']);
    $lprecs = mysql_fetch_array($lprec);
    $lprecs["tb_detallelistaprecio_precos"];
    $data['precos'] = $lprecs["tb_detallelistaprecio_precos"];
    $data['preven'] = $lprecs["tb_detallelistaprecio_preven"];
    $data['uti'] = $lprecs["tb_detallelistaprecio_uti"];
    echo json_encode($data);
}else{
    $data['precos'] = '';
    $data['preven'] = '';
    $data['uti'] = '';
    echo json_encode($data);
}


