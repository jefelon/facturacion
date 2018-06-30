<?php
require_once ("../../config/Cado.php");
require_once ("cProducto.php");
$oProducto = new cProducto();

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

//busco un valor aproximado al dato escrito
$rs=$oProducto->complete_nom($datoBuscar,20);

$num_rows = mysql_num_rows($rs);

//creo el array de los elementos sugeridos
$arrayElementos = array();
if($num_rows<=0){
    array_push($arrayElementos, new ElementoAutocompletar('Agregar Producto', ''));
}
//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
   array_push($arrayElementos, new ElementoAutocompletar($fila["tb_producto_nom"], $fila["tb_producto_nom"]));
}

print_r(json_encode($arrayElementos));

?>