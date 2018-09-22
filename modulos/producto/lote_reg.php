<?php
session_start();
require_once("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once ("../lote/cLote.php");
$oLote = new cLote();



if($_POST['action_lote']=="insertar")
{
    $oLote->insertar($_POST['txt_lote_num'], $_POST['hdd_pre_id'], fecha_mysql($_POST['txt_lote_fecfab']), fecha_mysql($_POST['txt_lote_fecven']), moneda_mysql($_POST['txt_lote_sto_num']), moneda_mysql($_POST['txt_lote_sto_num']), 1, $_POST['hdd_alm_id'], $_POST['sto_id']);
    $data['lote_msj']='Se registro correctamente lote.';
    echo json_encode($data);
}