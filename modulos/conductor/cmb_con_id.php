<?php
require_once ("../../config/Cado.php");
require_once ("cConductor.php");
$oConductor = new cConductor();

?>
<option value="">-</option>
<?php
$dts=$oConductor->mostrarTodos();
while($dt = mysql_fetch_array($dts))
{
	?>
	<option value="<?php echo $dt['tb_conductor_id']?>" <?php if($dt['tb_conductor_id']==$_POST['con_id'])echo 'selected'?>><?php echo $dt['tb_conductor_nom']?></option>
    <?php
}
mysql_free_result($dts);
?>