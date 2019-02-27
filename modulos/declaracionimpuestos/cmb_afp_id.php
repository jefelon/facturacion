<?php
require_once ("../../config/Cado.php");
require_once("cDeclaracionimpuestos.php");
$oRecepcionDocumentos = new cPlanilla();
?>
	<option value="">-</option>
<?php
	$dts1=$oRecepcionDocumentos->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_recepciondocumentos_id']?>" <?php if($dt1['tb_recepciondocumentos_id']==$_POST['recdoc_id'])echo 'selected'?>><?php echo $dt1['tb_recepciondocumentos_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>