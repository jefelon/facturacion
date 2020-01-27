<?php
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
session_start();
$oVenta = new cVenta();

//defino una clase que voy a utilizar para generar los elementos sugeridos en autocompletar
class ElementoAutocompletar {
    var $id;
    var $value;
    function __construct($id, $label, $value){
        $this->id = $id;
        $this->label = $label;
        $this->value = $value;
    }
}

//recibo el dato que deseo buscar sugerencias
$datoBuscar = $_GET["term"];

//busco un valor aproximado al dato escrito
$rs=$oVenta->mostrar_cli_nom($datoBuscar,$_SESSION['puntoventa_id']);

//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
    array_push($arrayElementos, new ElementoAutocompletar($fila["tb_destinatario_nom"], $fila["tb_destinatario_nom"],$fila["tb_destinatario_nom"]));
}

print_r(json_encode($arrayElementos));

?>