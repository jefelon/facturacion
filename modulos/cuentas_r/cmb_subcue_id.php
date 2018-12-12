<?php
require_once ("../../config/Cado.php");
require_once ("cSubcuenta.php");
$oSubcuenta = new cSubcuenta();

?>
<option value="">-</option>
<?php
$dts=$oSubcuenta->mostrarTodos_cue($_POST['cue_id']);
while($dt = mysql_fetch_array($dts))
{
?>
<option value="<?php echo $dt['tb_subcuenta_id']?>" <?php if($dt['tb_subcuenta_id']==$_POST['subcue_id'])echo 'selected'?>><?php echo $dt['tb_subcuenta_des']?></option>
<?php 
}
mysql_free_result($dts);
?>