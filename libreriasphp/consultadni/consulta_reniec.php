<?php
header('Content-Type: text/html; charset=UTF-8');
require 'simple_html_dom.php';
require_once( __DIR__ . "/src/autoload.php" );

//error_reporting(E_ALL ^ E_NOTICE);

//$essalud = new \EsSalud\EsSalud();
//$reniec = new \Reniec\Reniec();


$dni = $_POST['dni'];

$persona="Datos no encontrados, completa el nombre manualmente.";
//$search0 = $reniec->search( $dni );
//if( $search0->success == true){
//    $persona=$search0->result->apellidos." ".$search0->result->Nombres;
//}
//else{


    $link="https://www.facturacionelectronica.us/facturacion/controller/ws_consulta_rucdni_v2.php?documento=DNI&usuario=10447915125&password=985511933&nro_documento=";
    $consulta = file_get_contents($link.$dni);
    //Make sure we received utf-8:
    $encoding = @mb_detect_encoding($consulta);
    if ($encoding && strtoupper($encoding) != "utf-8")
        $consulta = @iconv($encoding, "utf-8//TRANSLIT//IGNORE", $consulta);

    $datos344=json_decode($consulta,true);
    $dni=$datos344['result']['Dni'];
    $nom=$datos344['result']['Nombre'];
    $pat=$datos344['result']['Paterno'];
    $mat=$datos344['result']['Materno'];

//    $search1 = $essalud->search( $dni );
//    if($search1->success == true){
//        $persona=$search1->result->paterno." ".$search1->result->materno." ".$search1->result->nombre;
//    }
//    else if($consulta){
        $persona=$pat.' '.$mat.' '.$nom;
//    }
//}

$data['persona']=$persona;

echo json_encode($data);
