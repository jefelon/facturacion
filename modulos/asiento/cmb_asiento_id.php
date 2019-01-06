<?php
require_once ("../../config/Cado.php");
require_once ("cAsiento.php");
$oAsiento = new cAsiento();
?>
	<option value="">-</option>
<?php
	$dts1=$oAsiento->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_asiento_id']?>" <?php if($dt1['tb_asiento_id']==$_POST['mar_id'])echo 'selected'?>><?php echo $dt1['tb_asiento_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>