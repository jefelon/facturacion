<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

$emp_id=$_SESSION['empresa_id'];
if($_POST['emp_id']>0)$emp_id=$_POST['emp_id'];

?>
	<option value="">-</option>

<?php
	$dts1=$oPuntoventa->mostrar_filtro($emp_id);
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_puntoventa_id']?>" <?php if($dt1['tb_puntoventa_id']==$_POST['punven_id'])echo 'selected'?>><?php echo $dt1['tb_puntoventa_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>