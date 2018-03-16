<?php
require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();

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
$usugru = $_GET["usugru"];

//busco un valor aproximado al dato escrito
$rs=$oUsuario->complete_nom($datoBuscar,$usugru);

//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
   array_push($arrayElementos, new ElementoAutocompletar($fila["nombre"], $fila["nombre"]));
}

print_r(json_encode($arrayElementos));

?>