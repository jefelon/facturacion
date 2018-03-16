<?php
require_once ("../../config/Cado.php");
require_once ("../atributo/cAtributo.php");
require_once ("../categoria/cCategoria.php");
$oAtributo = new cAtributo();
$oCategoria = new cCategoria();
?>	
<?php
if($_POST['cat_id']>0)
{
	$dts1=$oCategoria->mostrarUno($_POST['cat_id']);
	$dt1 = mysql_fetch_array($dts1);
	$idp1=$dt1['tb_categoria_idp'];
	mysql_free_result($dts1);
	
	if($idp1==0)
	{
		$cat_id=$_POST['cat_id'];
	}
	else
	{
		$dts1=$oCategoria->mostrarUno($idp1);
		$dt1 = mysql_fetch_array($dts1);
		$idp2=$dt1['tb_categoria_idp'];
		mysql_free_result($dts1);
		
		if($idp2==0)
		{
			$cat_id=$idp1;
		}
		else
		{
			$cat_id=$idp2;		
		}	
	}
}
?>
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-multiselect/jquery.multiselect.css" />
<script type="text/javascript" src="../../js/jquery-ui-multiselect/src/jquery.multiselect.js"></script>
<script type="text/javascript">
$(function(){
	$("#cmb_fil_pro_atr").multiselect({
   		header: false,
		height: 250,
      	minWidth: 150,
		selectedList: 3
	});
});
</script>
<label for="cmb_fil_atributo">Atributos:</label>
<?php
	$dts1=$oAtributo->mostrar_por_categoria($cat_id);
	$num_filas = mysql_num_rows($dts1);
?>
<input type="hidden" id="hdd_atr_numfil" value="<?php echo $num_filas?>" />
<select name="cmb_fil_pro_atr" id="cmb_fil_pro_atr" multiple="multiple" size="10">
    <?php
	while($dt1 = mysql_fetch_array($dts1))
	{
	?>    
    <optgroup label="<?php echo $dt1['tb_atributo_nom']?>">
    	<?php
		$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
		while($dt2 = mysql_fetch_array($dts2))
		{
		?>
		<option value="<?php echo $dt2['tb_atributo_id']?>"><?php echo $dt2['tb_atributo_nom']?></option>
    	<?php
		}
		mysql_free_result($dts2);
	?>
    </optgroup>
    <?php
	}
	mysql_free_result($dts1);
	?>
</select>