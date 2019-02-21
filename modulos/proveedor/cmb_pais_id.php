<?php
require_once ("../../config/Cado.php");
require_once ("cProveedor.php");
$oProveedor = new cProveedor();
?>
	<option value="">-</option>
<?php
	$dts1=$oProveedor->mostrarTodosPaises();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['cs_codigopais_id']?>" <?php if($dt1['cs_codigopais_id']==$_POST['pais_id'])echo 'selected'?>><?php echo $dt1['cs_codigopais_des']?></option>
<?php
	}
	mysql_free_result($dts1);
?>