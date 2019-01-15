<?php
require_once ("../../config/Cado.php");
require_once ("cLugar.php");
$oLugar = new cLugar();
?>
	<option value="">-</option>
<?php
	$dts1=$oLugar->mostrarFechas($_POST['salida_id'],$_POST['llegada_id']);
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
        <option value="<?php echo $dt1['tb_viajehorario_fecha']?>"><?php echo $dt1['tb_viajehorario_fecha']?></option>
<?php
	}
	mysql_free_result($dts1);
?>