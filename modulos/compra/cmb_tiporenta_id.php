<?php
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
$oCompra = new cCompra();

?>
	<option value="">-</option>
<?php
	$dts1=$oCompra->mostrarTipoRentaND();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_tiporenta_id']?>" <?php if($dt1['tb_tiporenta_id']==$_POST['tiporenta_id'])echo 'selected'?>><?php echo $dt1['tb_tiporenta_des']?></option>
<?php
	}
	mysql_free_result($dts1);
?>