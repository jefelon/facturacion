<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once ("../stock/cStock.php");
$oStock = new cStock();
//defino una clase que voy a utilizar para generar los elementos sugeridos en autocompletar
class ElementoAutocompletar {
    var $value;
    var $label;
    var $catid;
    function __construct($label, $value,$catid){
        $this->label = $label;
        $this->value = $value;
        $this->catid = $catid;
    }
}
$datoBuscar = '%'.$_GET["term"].'%';
$est='Activo';
$lim=12;
$rs=$oCatalogo->filtrar_unidades($datoBuscar,$codbar,$est,$_SESSION['almacen_id'],$lim);
//creo el array de los elementos sugeridos
$arrayElementos = array();
//bucle para meter todas las sugerencias de autocompletar en el array
$num_rows = mysql_num_rows($rs);
if($num_rows>0){
    while ($fila = mysql_fetch_array($rs))
    {
        $largo=55;
        $producto=$fila["tb_producto_nom"];
        $marca=$fila["tb_marca_nom"];
        $n_producto=strlen($producto);
        $alm_id=$_SESSION['almacen_id'];
        $stock = mysql_fetch_array($oStock->stock_por_presentacion($fila["tb_presentacion_id"],$alm_id))['tb_stock_num'];
        $stock=($stock/$fila["tb_catalogo_mul"]);

        $stock=" ".$stock*1;
        $precio="S/. ".$fila["tb_catalogo_preven"];
        $n_precio=strlen($precio);
        $n_espacio=$largo-$n_producto-$n_precio-2;
        $espacio=" ".str_pad($ini,$n_espacio,"-")." ";
        $etiqueta= '<span style="display:inline-block; width:250px;">'.$producto.'</span><span style="display:inline-block; width:100px;">'.$marca.'</span><span style="display:inline-block; width:50px;text-align:right;">'.$stock." ".$fila["tb_unidad_abr"].'</span><span style="display:inline-block; width:100px;text-align:right;">'.$precio;
        array_push($arrayElementos, new ElementoAutocompletar($etiqueta, $fila["tb_producto_nom"],$fila["tb_catalogo_id"]));
    }
}else{
    $etiqueta= '<span style="display:inline-block; width:250px;">Agregar Producto</span>';
    array_push($arrayElementos, new ElementoAutocompletar($etiqueta, '',''));
}
print_r(json_encode($arrayElementos));