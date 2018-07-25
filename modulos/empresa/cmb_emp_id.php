<?php
require_once ("../../config/Cado.php");
require_once ("cEmpresa.php");
$oEmpresa = new cEmpresa();
?>
	<option value="">-</option>

<?php
	$dts1=$oEmpresa->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_empresa_id']?>" <?php if($dt1['tb_empresa_id']==$_POST['emp_id'])echo 'selected'?>><?php echo $dt1['tb_empresa_razsoc']?></option>
<?php
	}
	mysql_free_result($dts1);
?>