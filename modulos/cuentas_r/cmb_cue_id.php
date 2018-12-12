<?php
require_once ("../../config/Cado.php");
require_once ("cCuenta.php");
$oCuenta = new cCuenta();

?>
<option value="">-</option>
<?php
$dts=$oCuenta->mostrarTodos_oby($_POST['elemento'],$_POST['orden']);
while($dt = mysql_fetch_array($dts))
{
?>
<option value="<?php echo $dt['tb_cuenta_id']?>" <?php if($dt['tb_cuenta_id']==$_POST['cue_id'])echo 'selected'?>><?php echo $dt['tb_cuenta_des']?>		</option>
<?php 
}
mysql_free_result($dts);
?>