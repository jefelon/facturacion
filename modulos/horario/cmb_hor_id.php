<?php
require_once ("../../config/Cado.php");
require_once ("cHorario.php");
$oHorario = new cHorario();
?>
	<option value="">-</option>

<?php
	$dts1=$oHorario->mostrar_todos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_horario_id']?>" <?php if($dt1['tb_horario_id']==$_POST['hor_id'])echo 'selected'?>><?php echo $dt1['tb_horario_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>