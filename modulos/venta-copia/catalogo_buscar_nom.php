<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVentacatalogo.php");
$oVentacatalogo = new cVentacatalogo();

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
$rs=$oVentacatalogo->mostrar_catalogo($datoBuscar,$_SESSION['almacen_id'],10);

//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
	$largo=55;
	
	$producto=$fila["tb_producto_nom"];
	$n_producto=strlen($producto);

	$precio="S/. ".$fila["tb_catalogo_preven"];
	$n_precio=strlen($precio);
	
	$n_espacio=$largo-$n_producto-$n_precio-2;
	$espacio=" ".str_pad($ini,$n_espacio,"-")." ";

	$etiqueta=$producto." - - - ".$precio;
   	array_push($arrayElementos, new ElementoAutocompletar($etiqueta, $fila["tb_producto_nom"]));
}

print_r(json_encode($arrayElementos));

?>