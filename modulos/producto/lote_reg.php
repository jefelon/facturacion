<?php
session_start();
require_once("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once ("../lote/cLote.php");
$oLote = new cLote();
require_once("../stock/cStock.php");
$oStock = new cStock();


if($_POST['action']=="insertar")
{
    $lts=$oLote->mostrarUnoLoteNumero($_POST['txt_lote_num'], $_POST['hdd_alm_id']);
    $nro_rows = mysql_num_rows($lts);

    $rws= $oStock->stock_por_presentacion($_POST['hdd_pre_id'],$_POST['hdd_alm_id']);
    $rw = mysql_fetch_array($rws);
    $stock_num=$rw['tb_stock_num'];

    $sumlt =$oLote->sumaLoteProducto($_POST['hdd_pre_id'],$_POST['hdd_alm_id'],$_POST['sto_id']);
    $sumlt = mysql_fetch_array($sumlt);
    $sum_lotes = $sumlt['sum_lotes'];
    $sum_lotes+=$_POST['txt_lote_sto_num'];

    $msj_error = '';
    if ($sum_lotes<=$stock_num){
        $lote_cant = True;
    }else{
        $lote_cant = False;
        $msj_error .= ', supera stock';
    }

    if ($nro_rows==0){
        $rows_cant = True;
    }else{
        $rows_cant = False;
        $msj_error .= ', ya existe este Lote';
    }

    if ($rows_cant and $lote_cant) {
        $oLote->insertar($_POST['txt_lote_num'], $_POST['hdd_pre_id'], fecha_mysql($_POST['txt_lote_fecfab']), fecha_mysql($_POST['txt_lote_fecven']), moneda_mysql($_POST['txt_lote_sto_num']), moneda_mysql($_POST['txt_lote_sto_num']), 1, $_POST['hdd_alm_id'], $_POST['sto_id']);
        $data['lote_msj'] = 'Se registro correctamente lote.';
    }else{
        $data['lote_msj']='No se puede insertar'.$msj_error ;
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


