<?php
require_once ("../../config/Cado.php");
require_once ("cProveedor.php");
$oProveedor = new cProveedor();

//defino una clase que voy a utilizar para generar los elementos sugeridos en autocompletar
class ElementoAutocompletar {
   var $id;
   var $value;//documento(dni,ruc)
   var $label;
   var $direccion;
   var $nombre;
   function __construct($id, $label, $value, $direccion, $nombre){
	  $this->id = $id;
      $this->label = $label;
      $this->value = $value;
	  $this->direccion = $direccion;	
	  $this->nombre = $nombre;  
   }
}

//recibo el dato que deseo buscar sugerencias
$datoBuscar = $_GET["term"];

//busco un valor aproximado al dato escrito
$rs=$oProveedor->complete_nom($datoBuscar);

//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
   array_push($arrayElementos, new ElementoAutocompletar($fila["tb_proveedor_id"], $fila["tb_proveedor_doc"].'-'.$fila["tb_proveedor_nom"],$fila["tb_proveedor_doc"], $fila['tb_proveedor_dir'], $fila['tb_proveedor_nom']));
}

print_r(json_encode($arrayElementos));

?>