<?php
require '../consultadni/simple_html_dom.php';
    $ruc = $_POST['vruc'];
    $link="https://www.facturacionelectronica.us/facturacion/controller/ws_consulta_rucdni_v2.php?documento=RUC&usuario=10447915125&password=985511933&nro_documento=";
    $consulta = file_get_contents($link.$ruc);
    //Make sure we received utf-8:
    $encoding = @mb_detect_encoding($consulta);
    if ($encoding && strtoupper($encoding) != "utf-8") {
        $consulta = @iconv($encoding, "utf-8//TRANSLIT//IGNORE", $consulta);
    }

    $datos = json_decode($consulta, true);

    $data['Ruc'] = $datos{'result'}['Ruc'];
    $data['RazonSocial'] = $datos{'result'}['RazonSocial'];
    $data['Estado'] = $datos{'result'}['Estado'];
    $data['Condicion']=$datos{'result'}['Condicion'];
    $data['DireccionCompleta'] = $datos{'result'}['Direccion'];

    echo json_encode($data);

?>
