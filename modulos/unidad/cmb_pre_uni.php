<?php
require_once ("../../config/Cado.php");
require_once ("cUnidad.php");
$oUnidad = new cUnidad();
?>
	<option value="">-</option>

<?php
	$dts1=$oUnidad->mostrar_por_tipo($_POST['uni_id_bas']);
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_unidad_id']?>" <?php if($dt1['tb_unidad_id']==$_POST['uni_id'])echo 'selected'?>><?php echo $dt1['tb_unidad_abr'].' - '.$dt1['tb_unidad_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>