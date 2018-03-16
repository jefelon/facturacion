<?php
require_once ("../../config/Cado.php");
require_once ("cCaja.php");
$oCaja = new cCaja();
?>
	<option value="">-</option>

<?php
	$dts1=$oCaja->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_caja_id']?>" <?php if($dt1['tb_caja_id']==$_POST['caj_id'])echo 'selected'?>><?php echo $dt1['tb_caja_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>