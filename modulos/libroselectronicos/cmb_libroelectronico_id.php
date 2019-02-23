<?php
require_once ("../../config/Cado.php");
require_once("cLibroelectronico.php");
$oLibroelectronico = new cLibroelectronico();
?>
	<option value="">-</option>
<?php
	$dts1=$oLibroelectronico->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_libroelectronico_id']?>" <?php if($dt1['tb_libroelectronico_id']==$_POST['libele_id'])echo 'selected'?>><?php echo $dt1['tb_libroelectronico_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>