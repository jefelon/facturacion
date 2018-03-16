<?php
require_once ("../../config/Cado.php");
require_once("cCategoria.php");
$oCategoria = new cCategoria();

if($_POST['action_categoria']=="insertar")
{
	if(!empty($_POST['txt_cat_nom']))
	{
		$oCategoria->insertar($_POST['txt_cat_nom'],$_POST['cmb_cat_idp']);
		
			$dts=$oCategoria->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$cat_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['cat_id']=$cat_id;
		$data['cat_msj']='Se registró categoria correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_categoria']=="editar")
{
	if(!empty($_POST['txt_cat_nom']))
	{
		$oCategoria->modificar($_POST['hdd_cat_id'],$_POST['txt_cat_nom'],$_POST['cmb_cat_idp']);
		
		$data['cat_msj']='Se registró categoria correctamente.';
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
		$cst1 = $oCategoria->verifica_categoria_tabla($_POST['id'],'tb_producto');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Producto';
		
		$cst2 = $oCategoria->verifica_categoria_padre($_POST['id']);
		$rst2= mysql_num_rows($cst2);
		if($rst2>0)$msj2=' - Sub categorías';
		
		if($rst1>0 or $rst2>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.".";
		}
		else
		{
			$oCategoria->eliminar($_POST['id']);
			echo 'Se eliminó categoría correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>