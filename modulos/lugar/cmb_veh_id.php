<?php
require_once ("../../config/Cado.php");
require_once ("cLugar.php");
$oLugar = new cLugar();
?>
<?php
	$dts1=$oLugar->mostrarLugarHorario($_POST['salida_id'],$_POST['llegada_id'],$_POST['horario']);
	$dt1 = mysql_fetch_array($dts1);
    $data['viajehorario_id']=$dt1['tb_viajehorario_id'];
    $data['vehiculo_id']=$dt1['tb_vehiculo_id'];
    $data['vehiculo_placa']=$dt1['tb_vehiculo_placa'];
    echo json_encode($data);
	mysql_free_result($dts1);
?>