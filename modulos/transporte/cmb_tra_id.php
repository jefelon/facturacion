<?php
require_once ("../../config/Cado.php");
require_once ("cTransporte.php");
$oTransporte = new cTransporte();

?>
<option value="">-</option>
<?php
$dts=$oTransporte->mostrarTodos();
while($dt = mysql_fetch_array($dts))
{
	?>
	<option value="<?php echo $dt['tb_transporte_id']?>" <?php if($dt['tb_transporte_id']==$_POST['tra_id'])echo 'selected'?>><?php echo $dt['tb_transporte_razsoc']?></option>
    <?php
}
mysql_free_result($dts);
?>