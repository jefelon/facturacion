<?php
require_once ("../../config/Cado.php");
require_once ("cLetras.php");
$oLetras = new cLetras();
?>
	<option value="">-</option>
<?php
	$dts1=$oLetras->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_letra_id']?>" <?php if($dt1['tb_letra_id']==$_POST['mar_id'])echo 'selected'?>><?php echo $dt1['tb_letra_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>