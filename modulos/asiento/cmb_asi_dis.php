<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 3/02/2020
 * Time: 20:33
 */
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once("../vehiculo/cVehiculo.php");
$oVehiculo = new cVehiculo();
require_once("../venta/cVenta.php");
$oVenta = new cVenta();

$vvs=$oVenta->mostrar_asientos_ocupados($_POST['hdd_vi_ho_pos']);
$dset_ocu=$oVenta->mostrar_asientos_reservados($_POST['hdd_vi_ho_pos']);

$num_asi=$_POST['num_asi']; //número total de asientos

$i=1;
$asi_libre=array();
while ($i<=$num_asi){
    $asi_libre[]=$i;
    $i++;
}

$asi_ocu=array();
while ($dt= mysql_fetch_array($vvs)){
    $asi_ocu[]=$dt['tb_asiento_nom'];
}

$asi_res=array();
while ($dt2= mysql_fetch_array($dset_ocu)){
    $asi_res[]=$dt2['tb_asiento_id'];
}

$resultado = array_diff($asi_libre, $asi_ocu);
$asi_libre_res=array_diff($resultado, $asi_res);

foreach ($asi_libre_res as $lib){
    echo "<option value='".$lib."'>".$lib."</option>";
}
