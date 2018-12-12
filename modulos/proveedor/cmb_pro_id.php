<?php
require_once ("../../config/Cado.php");
require_once ("cProveedor.php");
$oProveedor = new cProveedor();

?>
<option value="">-</option>
<?php
$dts=$oProveedor->mostrarTodos();
while($dt = mysql_fetch_array($dts))
{
	?>
	<option value="<?php echo $dt['tb_proveedor_id']?>" <?php if($dt['tb_proveedor_id']==$_POST['pro_id'])echo 'selected'?>><?php echo $dt['tb_proveedor_nom']?></option>
    <?php
}
mysql_free_result($dts);
?>