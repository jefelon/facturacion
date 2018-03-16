<?php
require_once ("../../config/Cado.php");
require_once ("cAtributo.php");
$oAtributo = new cAtributo();

if($_POST['atr_id']!=0)
{
	if($_POST['atr_idp']==0)
	{
		$n=1;//nivel de atributo
		
		$dts1=$oAtributo->mostrar_por_idp($_POST['atr_id']);
		$num_rows1= mysql_num_rows($dts1);
		if($num_rows1>0){
			$nh=1;//nivel de hijos
			while($dt1 = mysql_fetch_array($dts1)){
				$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
				$num_rows2= mysql_num_rows($dts2);
				if($num_rows2>0){
					$nh=2;
				}
				mysql_free_result($dts2);
			}
			mysql_free_result($dts1);
		}
	}
	else
	{
		$n=2;
		$dts1=$oAtributo->mostrar_por_idp($_POST['atr_id']);
		$num_rows1= mysql_num_rows($dts1);
		if($num_rows1>0){
			$nh=1;
			while($dt1 = mysql_fetch_array($dts1)){
				$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
				$num_rows2= mysql_num_rows($dts2);
				if($num_rows2>0){
					$nh=2;
				}
				mysql_free_result($dts2);
			}
			mysql_free_result($dts1);
		}
	}
}
else
{
	$n=0;
	$nh=0;
}
?>
	<option value="0">                                </option>

<?php
if($n==0 and $nh==0)
{
	$dts1=$oAtributo->mostrar_atr_idp();
	while($dt1 = mysql_fetch_array($dts1))
	{
	if($dt1['tb_atributo_id']!=$_POST['atr_id'])
	{
?>
	<option value="<?php echo $dt1['tb_atributo_id']?>" <?php if($dt1['tb_atributo_id']==$_POST['atr_idp'])echo 'selected'?>><?php echo $dt1['tb_atributo_nom']?></option>
<?php
	$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
	while($dt2 = mysql_fetch_array($dts2))
	{
	if($dt2['tb_atributo_id']!=$_POST['atr_id'])
	{
?>
	<option value="<?php echo $dt2['tb_atributo_id']?>" <?php if($dt2['tb_atributo_id']==$_POST['atr_idp'])echo 'selected'?>><?php echo '  -  '.$dt2['tb_atributo_nom']?></option>
<?php
	}//if 2
	}//fin nivel 2
	mysql_free_result($dts2);

	}//if 1
	}//fin nivel 1
	mysql_free_result($dts1);
}
?>

<?php
if($n==1 and $nh<2)
{
	$dts1=$oAtributo->mostrar_atr_idp();
	while($dt1 = mysql_fetch_array($dts1))
	{
	if($dt1['tb_atributo_id']!=$_POST['atr_id'])
	{
?>
	<option value="<?php echo $dt1['tb_atributo_id']?>" <?php if($dt1['tb_atributo_id']==$_POST['atr_idp'])echo 'selected'?>><?php echo $dt1['tb_atributo_nom']?></option>
<?php
if($n==1 and $nh<1)
{
	$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
	while($dt2 = mysql_fetch_array($dts2))
	{
	if($dt2['tb_atributo_id']!=$_POST['atr_id'])
	{
?>
	<option value="<?php echo $dt2['tb_atributo_id']?>" <?php if($dt2['tb_atributo_id']==$_POST['atr_idp'])echo 'selected'?>><?php echo '  -  '.$dt2['tb_atributo_nom']?></option>
<?php
	}//if 2
	}//fin nivel 2
	mysql_free_result($dts2);
	
}
	}//if 1
	}//fin nivel 1
	mysql_free_result($dts1);
}
?>

<?php
if($n==2 and $nh<2)
{
	$dts1=$oAtributo->mostrar_atr_idp();
	while($dt1 = mysql_fetch_array($dts1))
	{
	if($dt1['tb_atributo_id']!=$_POST['atr_id'])
	{
?>
	<option value="<?php echo $dt1['tb_atributo_id']?>" <?php if($dt1['tb_atributo_id']==$_POST['atr_idp'])echo 'selected'?>><?php echo $dt1['tb_atributo_nom']?></option>
<?php
if($n==2 and $nh<1)
{
	$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
	while($dt2 = mysql_fetch_array($dts2))
	{
	if($dt2['tb_atributo_id']!=$_POST['atr_id'])
	{
?>
	<option value="<?php echo $dt2['tb_atributo_id']?>" <?php if($dt2['tb_atributo_id']==$_POST['atr_idp'])echo 'selected'?>><?php echo '  -  '.$dt2['tb_atributo_nom']?></option>
<?php
	}//if 2
	}//fin nivel 2
	mysql_free_result($dts2);
	
}
	}//if 1
	}//fin nivel 1
	mysql_free_result($dts1);
}
?>