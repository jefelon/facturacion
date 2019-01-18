<?php
require_once ("../../config/Cado.php");
require_once ("cServicio.php");
$oServicio = new cServicio();

//defino una clase que voy a utilizar para generar los elementos sugeridos en autocompletar
class ElementoAutocompletar {
   var $value;
   var $label;
   
   function __construct($label, $value, $serid){
      $this->label = $label;
      $this->value = $value;
      $this->serid = $serid;
   }
}

//recibo el dato que deseo buscar sugerencias
$datoBuscar = $_GET["term"];

//busco un valor aproximado al dato escrito
$rs=$oServicio->complete_nom($datoBuscar);

//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
   array_push($arrayElementos, new ElementoAutocompletar($fila["tb_servicio_nom"], $fila["tb_servicio_nom"], $fila["tb_servicio_id"]));
}

print_r(json_encode($arrayElementos));

?>