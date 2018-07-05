<?php
session_start();
require_once("../../config/Cado.php");
require_once("cProducto.php");
$oProducto = new cProducto();
require_once("../formatos/formato.php");


	if(!empty($_POST['pro_nom']) and !empty($_POST['cat_id']) and !empty($_POST['mar_id']) and !empty($_POST['afec_id']))
	{
		if($_POST['action']=='insertar')
		{
			$cst1 = $oProducto->consultar_coincidencia($_POST['pro_id'],limpia_espacios($_POST['pro_nom']),$_POST['cat_id'],$_POST['mar_id']);
		}
		if($_POST['action']=='editar')
		{
			$cst1 = $oProducto->consultar_coincidencia($_POST['pro_id'],limpia_espacios($_POST['pro_nom']),$_POST['cat_id'],$_POST['mar_id']);
		}
		
		$rst1= mysql_num_rows($cst1);	
		if($rst1>=1)
		{
			$data['msj']='Ya existe producto con el mismo nombre, categoría y marca.';
			$data['act']=0;
		}
		else
		{
			$data['msj']='Correcto...';
			$data['act']=1;
		}
		//$data['msj']=limpia_espacios($_POST['pro_nom']).$_POST['cat_id'].' '.$_POST['mar_id'].$_POST['action'];
	}
	else
	{
		$data['msj']='Faltan datos...';
		$data['act']=1;
	}

echo json_encode($data);
?>