<?php
require_once ("../../config/Cado.php");
require_once ("../lugar/cLugar.php");
$oLugar = new cLugar();
require_once("../formatos/formato.php");


if($_POST['action']=="insertar")
{
    if(!empty($_POST['cmb_salida']) && !empty($_POST['cmb_llegada']) && !empty($_POST['txt_fech_salida']) && !empty($_POST['txt_fech_salida']) && !empty($_POST['cmb_vehiculo'])) {
        $oLugar->insertarViajeHorario($_POST['cmb_salida'], $_POST['cmb_llegada'], fecha_mysql($_POST['txt_fech_salida']), $_POST['txt_hora'], $_POST['cmb_vehiculo']);
        $dts=$oLugar->ultimoInsert();
        $dt = mysql_fetch_array($dts);
        $hor_id=$dt['last_insert_id()'];
        mysql_free_result($dts);

        $lgs=$oLugar->mostrarViajeHorario($hor_id);
        $lg = mysql_fetch_array($lgs);

        $data['vh_sal']=$lg['tb_viajehorario_salida'];
        $data['vh_lleg']=$lg['tb_viajehorario_llegada'];
        $data['vh_fecha']=$lg['tb_viajehorario_fecha'];
        $data['vh_horario']=$lg['tb_viajehorario_horario'];
        $data['vh_vehiculo']=$lg['tb_vehiculo_id'];
        $data['vh_placa']=$lg['tb_vehiculo_placa'];
        $data['ven_ho_msj']='Se registró horario correctamente. Seleccione horario.';
        echo json_encode($data);
    }else{
        echo 'Intentelo nuevamente';
    }
}
if($_POST['action']=="actualizar-vehiculo")
{
    if(!empty($_POST['hdd_vi_ho']) && !empty($_POST['cmb_vehiculo'])) {
        $lgs=$oLugar->modificar_vh_vehiculo($_POST['hdd_vi_ho'],$_POST['cmb_vehiculo']);
        $data['ven_ho_msj']='Se actualizo vehiculo correctamente.';
        echo json_encode($data);
    }else{
        echo 'Intentelo nuevamente';
    }
}
?>
