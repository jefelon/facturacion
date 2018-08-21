<?php
require_once ("../../config/Cado.php");
require_once ("cMarca.php");
$oMarca = new cMarca();
?>
	<option value="">-</option>
<?php
	$dts1=$oMarca->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_marca_id']?>" <?php if($dt1['tb_marca_id']==$_POST['mar_id'])echo 'selected'?>><?php echo $dt1['tb_marca_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>