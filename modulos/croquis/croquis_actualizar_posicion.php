<?php
/**
 * Created by PhpStorm.
 * User: donal
 * Date: 06/01/2019
 * Time: 01:13 PM
 */
session_start();
require_once("../../config/Cado.php");
require_once("../croquis/cCroquis.php");
$oCroquis = new cCroquis();





$fila1 = $_POST['sort1'];
$fila2 = $_POST['sort2'];
$fila3 = $_POST['sort3'];
$fila4 = $_POST['sort4'];
$fila5 = $_POST['sort5'];

$veh_id=$_POST['veh_id'];
$piso=$_POST['veh_pis'];


$oCroquis->actualizar_distribucionasiento($veh_id,$piso,1,$fila1);
$oCroquis->actualizar_distribucionasiento($veh_id,$piso,2,$fila2);
$oCroquis->actualizar_distribucionasiento($veh_id,$piso,3,$fila3);
$oCroquis->actualizar_distribucionasiento($veh_id,$piso,4,$fila4);
$oCroquis->actualizar_distribucionasiento($veh_id,$piso,5,$fila5);

echo $data;
$data['asiento_msj']='Se actualizó la distribución de los asientos correctamente.';

echo json_encode($data);