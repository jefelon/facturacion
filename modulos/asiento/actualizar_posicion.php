<?php
/**
 * Created by PhpStorm.
 * User: donal
 * Date: 06/01/2019
 * Time: 01:13 PM
 */
session_start();
require_once ("../../config/Cado.php");
require_once("../asiento/cAsiento.php");
$oAsiento = new cAsiento();





$fila1 = $_POST['sort1'];
$fila2 = $_POST['sort2'];
$fila3 = $_POST['sort3'];
$fila4 = $_POST['sort4'];
$fila5 = $_POST['sort5'];


$oAsiento->actualizar_distribucionasiento(1,$fila1);
$oAsiento->actualizar_distribucionasiento(2,$fila2);
$oAsiento->actualizar_distribucionasiento(3,$fila3);
$oAsiento->actualizar_distribucionasiento(4,$fila4);
$oAsiento->actualizar_distribucionasiento(5,$fila5);

echo $data;
$data['asiento_msj']='Se actualizó la distribución de los asientos correctamente.';

echo json_encode($data);