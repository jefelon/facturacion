<?php
require_once ("../../config/Cado.php");
require_once ("cAtributo.php");
$oAtributo = new cAtributo();
?>
	<option value="">-</option>
<?php
	$dts1=$oAtributo->mostrar_atr_idp();
	//Nivel 1
	while($dt1 = mysql_fetch_array($dts1)){?>
		<option value="<?php echo $dt1['tb_atributo_id']?>" <?php if($dt1['tb_atributo_id']==$_POST['atr_id'])echo 'selected'?>><?php echo $dt1['tb_atributo_nom']?>
        </option><?php
		$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
		//Nivel 2
		while($dt2 = mysql_fetch_array($dts2)){?><option value="<?php echo $dt2['tb_atributo_id']?>" <?php if($dt2['tb_atributo_id']==$_POST['atr_id'])echo 'selected'?>><?php echo '&nbsp;&nbsp;&nbsp;'.$dt2['tb_atributo_nom']?></option><?php		
		$dts3=$oAtributo->mostrar_por_idp($dt2['tb_atributo_id']);
		//Nivel 3
			while($dt3 = mysql_fetch_array($dts3)){?>        
				<option value="<?php echo $dt3['tb_atributo_id']?>" <?php if($dt3['tb_atributo_id']==$_POST['atr_id'])echo 'selected'?>><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$dt3['tb_atributo_nom']?></option><br><?php
			}//fin nivel 3
			mysql_free_result($dts3);
		}//fin nivel 2
		mysql_free_result($dts2);
	}//fin nivel 1
	mysql_free_result($dts1);
?>