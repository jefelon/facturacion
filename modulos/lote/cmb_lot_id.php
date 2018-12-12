<?php
require_once ("../../config/Cado.php");
require_once ("cLote.php");
$oMarca = new cLote();
?>
	<option value="">-</option>
<?php
	$dts1=$oLote->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_lote_id']?>" <?php if($dt1['tb_lote_id']==$_POST['mar_id'])echo 'selected'?>><?php echo $dt1['tb_lote_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>