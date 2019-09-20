<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cLugar.php");
$oLugar = new cLugar();
?>
	<option value="">-</option>
<?php
	$dts1=$oLugar->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_lugar_nom']?>" <?php if($_SESSION['cmb_salida_nom']==$dt1['tb_lugar_nom'])echo 'selected'?>><?php echo $dt1['tb_lugar_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>