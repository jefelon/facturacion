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
$num_asi=$_POST['num_asi']; //número total de asientos

$asi_ocu=array();
while ($dt= mysql_fetch_array($vvs)){
    $asi_ocu[]=$dt['tb_asiento_nom'];
}

$asi_libre=array();
for ($i=1;$i<=$num_asi;$i++){
    if($asi_ocu)
    {
        foreach ($asi_ocu as $ocu){
            if($i==$ocu){
                $i++;
            }
            $asi_libre[]=$i;
        }
    }
    else{
        $asi_libre[]=$i;
    }
}

foreach ($asi_libre as $lib){
    echo "<option value='".$lib."'>".$lib."</option>";
}
