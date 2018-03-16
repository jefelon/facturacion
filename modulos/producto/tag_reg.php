<?php
require_once ("../../config/Cado.php");
require_once("../producto/cTag.php");
$oTag = new cTag();
require_once ("../atributo/cAtributo.php");
$oAtributo = new cAtributo();

if($_POST['action']=="insertar"){
	if(!empty($_POST['hdd_pre_id']))
	{
		$dts1=$oAtributo->mostrar_atributo_valor($_POST['cmb_atr_id']);
			$dt1 = mysql_fetch_array($dts1);
		$atr_id	=$dt1['tb_atributo_id'];
		$atr_idp=$dt1['tb_atributo_idp'];
			mysql_free_result($dts1);
		
		//consulta de atributos agregadas anteriormente
		$dts2=$oTag->mostrar_atributo_valor_por_presentacion($_POST['hdd_pre_id']);
		
		$ban=0;
		while($dt2 = mysql_fetch_array($dts2)){
			if($atr_idp==$dt2['tb_atributo_idp'])
			{
				$ban=1;
				$atributo=$dt2['atributo'];
			}			
		}
		mysql_free_result($dts2);
		
		if($ban==0)
		{
			$oTag->insertar(
				$_POST['hdd_pre_id'],
				$_POST["cmb_atr_id"]
			);
			$msj='Se agregó atributo correctamente.';
		}
		
		if($ban==1)
		{
			$msj="Ya existe una atributo de tipo: $atributo.";
		}
		
	}
	else{
		$msj='Intentelo nuevamente.';
	}
	$data['tag_msj']=$msj;
	echo json_encode($data);
}

if($_POST['action_stock']=="editar")
{
	if(!empty($_POST['hdd_pre_id']))
	{
		$oTag->modificar(
			$_POST["hdd_sto_id"],
			$_POST["txt_sto_num"]
		);

		echo 'Se actualizó stock correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['tag_id']))
	{
		$oTag->eliminar($_POST['tag_id']);
		echo 'Se eliminó atributo correctamente.';

	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

?>