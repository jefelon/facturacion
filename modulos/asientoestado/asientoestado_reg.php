<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../asientoestado/cAsientoestado.php");
$oAsientoestado = new cAsientoestado();

if($_POST['action_asientoestado']=="insertar")
{
    if(!empty($_POST['txt_asiento_id']) && !empty($_POST['hdd_vh_id']) && !empty($_POST['txt_destpar']) && !empty($_POST['cli_id']))
    {
        $oAsientoestado->insertar($_POST['txt_asiento_id'],$_POST['hdd_vh_id'],$_POST['cli_id'],$_POST['txt_destpar']);

        $dts=$oAsientoestado->ultimoInsert();
        $dt = mysql_fetch_array($dts);
        $asientoestado_id=$dt['last_insert_id()'];
        mysql_free_result($dts);

        $data['asientoestado_id']=$asientoestado_id;
        $data['asientoestado_msj']='Se registró asiento correctamente.';
        echo json_encode($data);
    }
    else
    {
        echo 'Intentelo nuevamente';
    }
}


if($_POST['action_asientoestado']=="eliminar")
{
    if(!empty($_POST['txt_asiento_id']) && !empty($_POST['hdd_vh_id']))
    {
        $oAsientoestado->eliminar($_POST['hdd_vh_id'],$_POST['txt_asiento_id']);

        $data['asientoestado_msj']='Se elimino asiento correctamente.';
        echo json_encode($data);
    }
    else
    {
        echo 'Intentelo nuevamente';
    }
}

