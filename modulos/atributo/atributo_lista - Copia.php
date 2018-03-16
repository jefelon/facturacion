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

	$dts1=$oAtributo->mostrar_por_categoria($cat_id);
	$num_filas = mysql_num_rows($dts1);
	if($num_filas>0){
		//Este etiqueta oculta me sirve para verificar si la categoria tiene atributos
		echo '<input type="hidden" id="hdd_verificar" value="1" />';
	}else{
		echo '<input type="hidden" id="hdd_verificar" value="2" />';
	}
	//Nivel 1
	$i=0;
	while($dt1 = mysql_fetch_array($dts1)){
		
		?>    		
		<label><?php echo $dt1['tb_atributo_nom']?></label>
        <?php
		$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
		//Nivel 2
		while($dt2 = mysql_fetch_array($dts2)){?><label><input type="checkbox" id="chk_atributos[<?php echo $i?>]" name="chk_atributos[<?php echo $i?>]"  value="<?php echo $dt2['tb_atributo_id']?>" class='casilla_verificacion' /><?php echo '&nbsp;&nbsp;&nbsp;'.$dt2['tb_atributo_nom']?></label><?php				
			$i++;
		}//fin nivel 2
		
		mysql_free_result($dts2);
	}//fin nivel 1
	mysql_free_result($dts1);
?>