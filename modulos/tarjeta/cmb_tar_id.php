<?php
require_once ("../../config/Cado.php");
require_once ("cTarjeta.php");
$oTarjeta = new cTarjeta();
?>
	<option value="">-</option>

<?php
	$dts1=$oTarjeta->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_tarjeta_id']?>" <?php if($dt1['tb_tarjeta_id']==$_POST['tar_id'])echo 'selected'?>><?php echo $dt1['tb_tarjeta_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>