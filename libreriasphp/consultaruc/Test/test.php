<?php
    require ("curl.php");
    require ("clase.php");
    $cliente = new Sunat();
    $Page = $cliente->BuscaDatosSunat('20487816672');
    $Page = str_replace("	", "", $Page);
    $Page = utf8_encode($Page);
    $Page = preg_replace('/Ñ/','&Ntilde;', $Page);
    //$Page = str_replace("  ", "", $Page);
    echo $Page;

?>
