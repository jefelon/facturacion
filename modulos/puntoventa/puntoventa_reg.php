<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

if($_POST['action_puntoventa']=="insertar")
{
	if(!empty($_POST['txt_punven_nom']))
	{
		$oPuntoventa->insertar(strip_tags($_POST['txt_punven_nom']),$_POST['cmb_alm_id'],$_SESSION['empresa_id']);
		echo 'Se registró punto de venta correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_puntoventa']=="editar")
{
	if(!empty($_POST['txt_punven_nom']))
	{
		$oPuntoventa->modificar($_POST['hdd_punven_id'],strip_tags($_POST['txt_punven_nom']),$_POST['cmb_alm_id']);
		echo 'Se registró punto de venta correctamente.';
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
		$cst1 = $oPuntoventa->verifica_puntoventa_tabla($_POST['id'],'tb_usuariodetalle');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Usuarios';
		
		$cst2 = $oPuntoventa->verifica_puntoventa_tabla($_POST['id'],'tb_venta');
		$rst2= mysql_num_rows($cst2);
		if($rst2>0)$msj2=' - Venta';
		
		if($rst1>0 or $rst2>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.".";
		}
		else
		{
			$oPuntoventa->eliminar($_POST['id']);
			echo 'Se eliminó punto de venta correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>