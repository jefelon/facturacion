<?php
require_once ("../../config/Cado.php");
require_once ("cUnidad.php");
$oUnidad = new cUnidad();
?>
	<option value="">-</option>

<?php
$dts=$oUnidad->mostrar_tipo();
while($dt = mysql_fetch_array($dts)){

?>					
<optgroup label="
<?php
switch ($dt['tb_unidad_tip']) {
	case 0:
		echo "Sin clasificar";
	break;
	case 1:
		echo "UNIDAD BASE";
	break;
	case 2:
		echo "UNIDAD ALTERNATIVA";
	break;
}
?>">
<?php
	$dts1=$oUnidad->mostrar_por_tipo($dt['tb_unidad_tip']);
	while($dt1 = mysql_fetch_array($dts1))
	{
		if($dt1['tb_unidad_id']!=$_POST['uni_id_bas'])
		{
?>
	<option value="<?php echo $dt1['tb_unidad_id']?>" <?php if($dt1['tb_unidad_id']==$_POST['uni_id'])echo 'selected'?>><?php echo $dt1['tb_unidad_abr'].' - '.$dt1['tb_unidad_nom']?></option>
<?php
		}
	}
	mysql_free_result($dts1);
?>
</optgroup>
<?php
}
mysql_free_result($dts);
?>