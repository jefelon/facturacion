<?php
require_once ("../../config/Cado.php");
require_once ("cLugar.php");
$oLugar = new cLugar();
?>
	<option value="">-</option>
<?php
	$dts1=$oLugar->mostrarFechaHorario($_POST['salida_id'],$_POST['llegada_id'],$_POST['fecha']);
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
        <option value="<?php echo $dt1['tb_viajehorario_horario']?>"><?php echo $dt1['tb_conductor_nom'] . ' - '.$dt1['tb_vehiculo_placa'] .' - '. $dt1['tb_viajehorario_horario'] ?></option>
<?php
	}
	mysql_free_result($dts1);
?>