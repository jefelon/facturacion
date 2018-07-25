<?php
require_once ("../../config/Cado.php");
require_once ("cCategoria.php");
$oCategoria = new cCategoria();

$nivel=3;
if($_POST['nivel']>0)$nivel=$_POST['nivel'];

?>
	<option value="">-</option>

<?php
	$dts1=$oCategoria->mostrar_cat_idp();
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_categoria_id']?>" <?php if($dt1['tb_categoria_id']==$_POST['cat_id'])echo 'selected'?>><?php echo $dt1['tb_categoria_nom']?></option>
<?php
if($nivel>=2)
{
	$dts2=$oCategoria->mostrar_por_idp($dt1['tb_categoria_id']);
	while($dt2 = mysql_fetch_array($dts2))
	{

?>
	<option value="<?php echo $dt2['tb_categoria_id']?>" <?php if($dt2['tb_categoria_id']==$_POST['cat_id'])echo 'selected'?>><?php echo '&nbsp;&nbsp;&nbsp;'.$dt2['tb_categoria_nom']?></option>
<?php
if($nivel>=3)
{
	$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
	while($dt3 = mysql_fetch_array($dts3))
	{

?>
	<option value="<?php echo $dt3['tb_categoria_id']?>" <?php if($dt3['tb_categoria_id']==$_POST['cat_id'])echo 'selected'?>><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$dt3['tb_categoria_nom']?></option>
    <br>
<?php
	}//fin nivel 3
	mysql_free_result($dts3);
}//if nivel 3
	}//fin nivel 2
	mysql_free_result($dts2);
}//ifnivel 2
	}//fin nivel 1
	mysql_free_result($dts1);
?>