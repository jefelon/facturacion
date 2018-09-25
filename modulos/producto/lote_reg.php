<?php
session_start();
require_once("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once ("../lote/cLote.php");
$oLote = new cLote();



if($_POST['action']=="insertar")
{
    $lts=$oLote->mostrarUnoLoteNumero($_POST['txt_lote_num'], $_POST['hdd_alm_id']);
    $nro_rows = mysql_num_rows($lts);
    if ($nro_rows==0) {
        $oLote->insertar($_POST['txt_lote_num'], $_POST['hdd_pre_id'], fecha_mysql($_POST['txt_lote_fecfab']), fecha_mysql($_POST['txt_lote_fecven']), moneda_mysql($_POST['txt_lote_sto_num']), moneda_mysql($_POST['txt_lote_sto_num']), 1, $_POST['hdd_alm_id'], $_POST['sto_id']);
        $data['lote_msj'] = 'Se registro correctamente lote.';
    }else{
        $data['lote_msj']='No se puede insertar ya existe este Lote.';
    }
    echo json_encode($data);
}

if($_POST['action']=="editar"){
    $lts=$oLote->mostrarUnoLoteNumero($_POST['txt_lote_num'], $_POST['hdd_alm_id']);
    $nro_rows = mysql_num_rows($lts);
    if ($nro_rows==0) {
        $oLote->modificar($_POST['lote_id'], $_POST['txt_lote_num'], fecha_mysql($_POST['txt_lote_fecfab']), fecha_mysql($_POST['txt_lote_fecven']), moneda_mysql($_POST['txt_lote_sto_num']));
        $data['lote_msj'] = 'Se modifico lote correctamente.';
    }else{
        $data['lote_msj']='No se puede modificar ya existe este Lote.';
    }
    echo json_encode($data);
}

if($_POST['action']=="eliminar"){
    $oLote->eliminar($_POST['lote_id']);
    $data['lote_msj']='Se elimino lote.';
    echo json_encode($data);
}