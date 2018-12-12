<?php
require_once ("../../config/Cado.php");
require_once ("cCliente.php");
$oCliente = new cCliente();

?>
<option value="">-</option>
<?php
$dts=$oCliente->mostrarTodos();
while($dt = mysql_fetch_array($dts))
{
	?>
	<option value="<?php echo $dt['tb_cliente_id']?>" <?php if($dt['tb_cliente_id']==$_POST['cli_id'])echo 'selected'?>><?php echo $dt['tb_cliente_nom']?></option>
    <?php
}
mysql_free_result($dts);
?>