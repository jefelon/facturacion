<?php
require_once ("../../config/Cado.php");
require_once("cUbigeo.php");
$oUbigeo = new cUbigeo();

if($_POST['action']=="insertar")
{
	if(!empty($_POST['txt_ubigeo_nom']))
	{
		$cst1 =$oUbigeo->verifica_codigo($_POST['txt_ubigeo_coddep'],$_POST['txt_ubigeo_codpro'],$_POST['txt_ubigeo_coddis']);
		$rst1= mysql_num_rows($cst1);
		
		if($rst1>0)
		{
			echo "No se puede agregar, ya existe registro con codigo:".$_POST['txt_ubigeo_coddep'].$_POST['txt_ubigeo_codpro'].$_POST['txt_ubigeo_coddis'];
		}
		else
		{
			$oUbigeo->insertar($_POST['txt_ubigeo_coddep'],$_POST['txt_ubigeo_codpro'],$_POST['txt_ubigeo_coddis'],$_POST['txt_ubigeo_nom'],$_POST['cmb_ubigeo_tip']);
		echo 'Se registró correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="editar")
{
	if(!empty($_POST['txt_ubigeo_nom']))
	{
		$oUbigeo->modificar($_POST['hdd_ubigeo_id'],$_POST['txt_ubigeo_coddep'],$_POST['txt_ubigeo_codpro'],$_POST['txt_ubigeo_coddis'],$_POST['txt_ubigeo_nom'],$_POST['cmb_ubigeo_tip']);
		echo 'Se registró correctamente.';
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
		$oUbigeo->eliminar($_POST['id']);
		echo 'Se eliminó correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}
?>