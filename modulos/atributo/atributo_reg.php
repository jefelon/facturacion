<?php
require_once ("../../config/Cado.php");
require_once("cAtributo.php");
$oAtributo = new cAtributo();

if($_POST['action_atributo']=="insertar")
{
	if(!empty($_POST['txt_atr_nom']))
	{
		//verificar si hay una atributo igual
		$cst=$oAtributo->verifica_atributo_dupli($_POST['txt_atr_nom'],$_POST['cmb_atr_idp'],$_POST['cmb_cat_id']);
		$res=mysql_num_rows($cst);
		if($res>=1)
		{
			$data['atr_msj']='Ya existe una atributo con el mismo nombre o dato.';
		}
		else
		{
			$oAtributo->insertar(strip_tags($_POST['txt_atr_nom']),$_POST['cmb_atr_idp'], $_POST['cmb_cat_id']);
			
				$dts=$oAtributo->ultimoInsert();
				$dt = mysql_fetch_array($dts);
			$atr_id=$dt['last_insert_id()'];
				mysql_free_result($dts);
			
			$data['atr_id']=$atr_id;
			$data['atr_msj']='Se registró atributo correctamente.';
		}
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_atributo']=="editar")
{
	if(!empty($_POST['txt_atr_nom']))
	{
		//verificar si hay una atributo igual
		$cst=$oAtributo->verifica_atributo_dupli($_POST['txt_atr_nom'],$_POST['cmb_atr_idp'],$_POST['cmb_cat_id']);
		$res=mysql_num_rows($cst);
		if($res>=1)
		{
			$data['atr_msj']='No se puede modificar, ya existe una atributo con el mismo nombre o dato.';
		}
		else
		{
			$oAtributo->modificar($_POST['hdd_atr_id'],strip_tags($_POST['txt_atr_nom']),$_POST['cmb_atr_idp'], $_POST['cmb_cat_id']);
			
			$data['atr_msj']='Se registró atributo correctamente.';
		}
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
		$cst1 = $oAtributo->verifica_atributo_tabla($_POST['id'],'tb_tag');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Producto';
		
		$cst2 = $oAtributo->verifica_atributo_padre($_POST['id']);
		$rst2= mysql_num_rows($cst2);
		if($rst2>0)$msj2=' - Valor de atributos';
		
		if($rst1>0 or $rst2>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.".";
		}
		else
		{
			$oAtributo->eliminar($_POST['id']);
			echo 'Se eliminó atributo correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>