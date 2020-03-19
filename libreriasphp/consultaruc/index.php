<?php
require '../consultadni/simple_html_dom.php';
    $ruc = $_POST['vruc'];
    $consulta = file_get_html('http://ruc.aqpfact.pe/sunat/'.$ruc)->plaintext;

    $datos = json_decode($consulta, true);

    $data['Ruc'] = $datos{'result'}['Ruc'];
    $data['RazonSocial'] = $datos{'result'}['RazonSocial'];
    $data['Estado'] = $datos{'result'}['Estado'];
    $data['Condicion']=$datos{'result'}['Condicion'];
    $data['DireccionCompleta'] = $datos{'result'}['DireccionCompleta'];

    echo json_encode($data);
?>
