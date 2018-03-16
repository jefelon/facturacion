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
	<option value="<?php echo $dt1['tb_atributo_id']?>" <?php if($dt1['tb_atributo_id']==$_POST['atr_idp'])echo 'selected'?>><?php echo $dt1['tb_atributo_nom']?></option>
<?php }?>