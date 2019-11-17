<?php
require '../consultadni/simple_html_dom.php';
    $ruc = $_POST['vruc'];
    $consulta = file_get_html('http://ruc.aqpfact.pe/sunat/'.$ruc)->plaintext;
    echo $consulta;
?>
