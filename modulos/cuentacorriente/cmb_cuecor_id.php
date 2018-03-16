<?php
require_once ("../../config/Cado.php");
require_once ("cCuentacorriente.php");
$oCuentacorriente = new cCuentacorriente();
?>
	<option value="">-</option>

<?php
	$dts1=$oCuentacorriente->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_cuentacorriente_id']?>" <?php if($dt1['tb_cuentacorriente_id']==$_POST['cuecor_id'])echo 'selected'?>><?php echo $dt1['tb_cuentacorriente_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>