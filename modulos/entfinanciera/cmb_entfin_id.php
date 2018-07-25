<?php
require_once ("../../config/Cado.php");
require_once ("cEntfinanciera.php");
$oEntfinanciera = new cEntfinanciera();

?>
<option value="">-</option>
<?php
$dts=$oEntfinanciera->mostrarTodos();
while($dt = mysql_fetch_array($dts))
{
	?>
	<option value="<?php echo $dt['tb_entfinanciera_id']?>" <?php if($dt['tb_entfinanciera_id']==$_POST['entfin_id'])echo 'selected'?>><?php echo $dt['tb_entfinanciera_nom']?></option>
    <?php
}
mysql_free_result($dts);
?>