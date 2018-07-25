<?php
require_once ("../../config/Cado.php");
require_once ("cAtributo.php");
$oAtributo = new cAtributo();
?>
	<option value="">                                </option>

<?php
	$dts1=$oAtributo->mostrar_por_categoria($_POST['cat_id']);
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php //echo $dt1['tb_atributo_id']?>" <?php if($dt1['tb_atributo_id']==$_POST['atr_idp'])echo 'selected'?>><?php echo $dt1['tb_atributo_nom']?></option>

<?php
	$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
	while($dt2 = mysql_fetch_array($dts2))
	{
?>
	<option value="<?php echo $dt2['tb_atributo_id']?>" <?php if($dt2['tb_atributo_id']==$_POST['atr_id'])echo 'selected'?>><?php echo '  -  '.$dt2['tb_atributo_nom']?></option>
<?php

	}//fin nivel 2
	mysql_free_result($dts2);
	?>
    <option value="">                                </option>
    <?php
}
mysql_free_result($dts1);
?>