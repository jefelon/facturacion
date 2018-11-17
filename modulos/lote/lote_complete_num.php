<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../lote/cLote.php");
require_once ("../formatos/formato.php");
$oLote = new cLote();

require_once ("cCompraDetalleLote.php");
$oCompraDetalleLote = new cCompraDetalleLote();

//defino una clase que voy a utilizar para generar los elementos sugeridos en autocompletar
class ElementoAutocompletar {
    var $id;
    var $value;
    var $label;
    var $fecfab;
    var $fecven;
    var $stock;

    function __construct($id, $label,$value, $fecfab, $fecven,$stock ){
        $this->id = $id;
        $this->label = $label;
        $this->value = $value;
        $this->fecfab = $fecfab;
        $this->fecven = $fecven;
        $this->stock = $stock;
    }
}

//recibo el dato que deseo buscar sugerencias
$datoBuscar = $_GET["term"];

$alm_id = $_SESSION['almacen_id'];

$cat_id = $_GET["cat_id"];

//busco un valor aproximado al dato escrito
$rs=$oLote->complete_nom($datoBuscar,$alm_id, $cat_id);


//creo el array de los elementos sugeridos
$arrayElementos = array();

//bucle para meter todas las sugerencias de autocompletar en el array
while ($fila = mysql_fetch_array($rs)){
    $lts=$oCompraDetalleLote->mostrarFiltroCompraDetalleLote($fila["tb_lote_numero"]);
    $lt= mysql_fetch_array($lts);
    array_push($arrayElementos, new ElementoAutocompletar($fila["tb_lote_id"], $fila["tb_lote_numero"].' - FV: '.$fila["tb_lote_fechavence"] .' - Stock: '.$fila['tb_lote_exisact']  .' - FCompra:'. mostrarFecha($lt["tb_compra_fec"]),$fila["tb_lote_numero"], $fila["tb_lote_fechafab"],$fila["tb_lote_fechavence"], $fila['tb_lote_exisact']));
}

print_r(json_encode($arrayElementos));

?>