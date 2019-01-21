<?php
require_once ("../../config/Cado.php");
require_once ("cVehiculo.php");
$oVehiculo = new cVehiculo();
?>
	<option value="">-</option>
<?php
	$dts1=$oVehiculo->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
        <option value="<?php echo $dt1['tb_vehiculo_id']?>" <?php if($dt1['tb_vehiculo_id']==$_POST['veh_id'])echo 'selected'?>><?php echo $dt1['tb_vehiculo_id']. ' '.$dt1['tb_vehiculo_marca']. ' - '.$dt1['tb_vehiculo_placa'].' de '.$dt1['tb_vehiculo_numasi'].' Asientos.'?></option>
<?php
	}
	mysql_free_result($dts1);
?>