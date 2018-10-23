<?php
require_once ("../../config/Cado.php");
require_once ("cCliente.php");
$oCliente = new cCliente();

//defino una clase que voy a utilizar para generar los elementos sugeridos en autocompletar
class ElementoAutocompletar {
   var $id;
   var $value;
   var $label;
   var $direccion;
   var $documento;
   var $tipo;
    var $precio_id;
   function __construct($id, $label, $value, $direccion, $documento,$tipo,$retiene, $precio_id){
	  $this->id = $id;
    $this->label = $label;
    $this->value = $value;
	  $this->direccion = $direccion;	
	  $this->documento = $documento;
	  $this->tipo = $tipo;
       $this->retiene = $retiene;
       $this->precio_id = $precio_id;
   }
}

//recibo el dato que deseo buscar sugerencias
$datoBuscar = $_GET["term"];

//busco un valor aproximado al dato escrito
$rs=$oCliente->complete_nom($datoBuscar);

//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
   array_push($arrayElementos, new ElementoAutocompletar($fila["tb_cliente_id"], $fila["tb_cliente_doc"].'-'.$fila["tb_cliente_nom"],$fila["tb_cliente_nom"], $fila['tb_cliente_dir'], $fila['tb_cliente_doc'],$fila['tb_cliente_tip'], $fila['tb_cliente_retiene'], $fila['tb_precio_id']));
}

print_r(json_encode($arrayElementos));

?>