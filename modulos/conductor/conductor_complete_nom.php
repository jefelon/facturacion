<?php
require_once ("../../config/Cado.php");
require_once ("cConductor.php");
$oConductor = new cConductor();

//defino una clase que voy a utilizar para generar los elementos sugeridos en autocompletar
class ElementoAutocompletar {
   var $id;
   var $value;
   var $label;
   var $direccion;
   var $documento;
   function __construct($id, $label, $value, $direccion, $documento){
	  $this->id = $id;
      $this->label = $label;
      $this->value = $value;
	  $this->direccion = $direccion;	
	  $this->documento = $documento;  
   }
}

//recibo el dato que deseo buscar sugerencias
$datoBuscar = $_GET["term"];
$tra_id = $_GET['tra_id'];

//busco un valor aproximado al dato escrito
$rs=$oConductor->complete_nom_por_transporte($datoBuscar, $tra_id);

//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
   array_push($arrayElementos, new ElementoAutocompletar($fila["tb_conductor_id"], $fila["tb_conductor_doc"].'-'.$fila["tb_conductor_nom"],$fila["tb_conductor_nom"], $fila['tb_conductor_dir'], $fila['tb_conductor_doc']));
}

print_r(json_encode($arrayElementos));

?>