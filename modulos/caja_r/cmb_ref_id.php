<?php
require_once ("../../config/Cado.php");
require_once ("cReferencia.php");
$oReferencia = new cReferencia();
?>
	<option value="">-</option>

<?php
	$dts1=$oReferencia->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_referencia_id']?>" <?php if($dt1['tb_referencia_id']==$_POST['ref_id'])echo 'selected'?>><?php echo $dt1['tb_referencia_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>