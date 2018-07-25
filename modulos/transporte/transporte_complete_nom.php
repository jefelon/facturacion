<?php
require_once ("../../config/Cado.php");
require_once ("cTransporte.php");
$oTransporte = new cTransporte();

//defino una clase que voy a utilizar para generar los elementos sugeridos en autocompletar
class ElementoAutocompletar {
   var $id;
   var $value;
   var $label;
   var $direccion;
   var $ruc;
   function __construct($id, $label, $value, $direccion, $ruc){
	  $this->id = $id;
      $this->label = $label;
      $this->value = $value;
	  $this->direccion = $direccion;	
	  $this->ruc = $ruc;  
   }
}

//recibo el dato que deseo buscar sugerencias
$datoBuscar = $_GET["term"];

//busco un valor aproximado al dato escrito
$rs=$oTransporte->complete_razsoc($datoBuscar);

//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
   array_push($arrayElementos, new ElementoAutocompletar($fila["tb_transporte_id"], $fila["tb_transporte_ruc"].'-'.$fila["tb_transporte_razsoc"],$fila["tb_transporte_razsoc"], $fila['tb_transporte_dir'], $fila['tb_transporte_ruc']));
}

print_r(json_encode($arrayElementos));

?>