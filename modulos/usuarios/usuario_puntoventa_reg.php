<?php
require_once ("../../config/Cado.php");
require_once("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

if($_POST['action_punven']=="insertar")
{
	if(!empty($_POST['cmb_pv_punven_id']))
	{
		$cst1 = $oPuntoventa->mostrar_puntoventa_por_usuario($_POST['hdd_pv_usu_id'],$_POST['cmb_pv_punven_id']);
		$rst1= mysql_num_rows($cst1);
		
		if($rst1>0)
		{
			echo 'El Punto de Venta ya se encuentra registrado.';
		}
		else
		{
			$oPuntoventa->insertar_usuariopv($_POST['hdd_pv_usu_id'],$_POST['cmb_pv_punven_id']);
			echo 'Se agregó Punto de Venta correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_punven']=="editar")
{
	if(!empty($_POST['txt_tel_num']))
	{
		$oPuntoventa->modificar($_POST['hdd_tel_id'],$_POST['cmb_tel_tip'], $_POST['cmb_tel_ope'], $_POST['txt_tel_num']);
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
		$oPuntoventa->eliminar_usuariopv($_POST['id']);
		echo 'Se quitó Punto de Venta correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}
?>