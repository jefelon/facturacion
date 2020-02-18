<?php
require_once("../../config/Cado.php");
require_once("cServicio.php");
$oServicio = new cServicio();
require_once("../formatos/formato.php");


if(!empty($_POST['txt_ser_nom']))
{

    $svs = $oServicio->mostrar_filtro_3($_POST['txt_ser_nom']);
    $num_rows = mysql_num_rows($svs);
    if($num_rows>0){
        $sv = mysql_fetch_array($svs);
        $data['ser_existe'] = 1;
        $data['servicio_id']=$sv['tb_servicio_id'];
        $data['servicio_nom']=$sv['tb_servicio_nom'];
        $data['servicio_pre']=$sv['tb_servicio_pre'];
    }else{
        $data['ser_existe'] = 0;
    }
} else {
    $data['ser_existe'] = 0;
}

echo json_encode($data);



?>