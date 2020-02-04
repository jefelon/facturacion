<?php
require 'simple_html_dom.php';
require_once( __DIR__ . "/src/autoload.php" );

//error_reporting(E_ALL ^ E_NOTICE);

$essalud = new \EsSalud\EsSalud();
$reniec = new \Reniec\Reniec();


$dni = $_POST['dni'];

$persona="Datos no encontrados, completa el nombre manualmente.";
$result="no";
$search0 = $reniec->search( $dni );
if( $search0->success == true){
    $persona=$search0->result->apellidos." ".$search0->result->Nombres;
    $result="si";
}
else{
    $consulta = file_get_html('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni)->plaintext;
	//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES

    $search1 = $essalud->search( $dni );
    if($search1->success == true){
        $persona=$search1->result->paterno." ".$search1->result->materno." ".$search1->result->nombre;
        $result="si";
    }
    else if($consulta){
    	$persona=$consulta;
        $result="si";
    }
}
$data['resultado']=$result;
$data['persona']=$persona;

echo json_encode($data);
