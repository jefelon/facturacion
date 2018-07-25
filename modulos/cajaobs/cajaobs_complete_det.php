<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../cajaobs/cCajaobs.php");
$oCajaobs = new cCajaobs();

//defino una clase que voy a utilizar para generar los elementos sugeridos en autocompletar
class ElementoAutocompletar {
   var $value;
   var $label;
   
   function __construct($label, $value){
      $this->label = $label;
      $this->value = $value;
   }
}

//recibo el dato que deseo buscar sugerencias
$datoBuscar = $_GET["term"];

//$emp=$_SESSION['empresa_id'];
$emp=1;
//busco un valor aproximado al dato escrito
$rs=$oCajaobs->complete_det($emp,$datoBuscar);

//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
   array_push($arrayElementos, new ElementoAutocompletar($fila["tb_cajaobs_det"], $fila["tb_cajaobs_det"]));
}

print_r(json_encode($arrayElementos));

?>