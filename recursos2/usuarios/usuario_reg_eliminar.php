<?php
require_once("../../config/Cado.php");
require_once("cUsuario.php");
$oUsuario = new cUsuario();
require_once("cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();

if($_POST['action'] == 'eliminar'){
	if(!empty($_POST['id']))
	{
		$cst1 = $oUsuario->verifica_usuario_tabla($_POST['id'],'tb_venta');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Ventas';
		
		$cst2 = $oUsuario->verifica_usuario_tabla($_POST['id'],'tb_compra');
		$rst2= mysql_num_rows($cst2);
		if($rst2>0)$msj2=' - Compras';
		
		$cst3 = $oUsuario->verifica_usuario_tabla($_POST['id'],'tb_traspaso');
		$rst3= mysql_num_rows($cst3);
		if($rst3>0)$msj3=' - Transferencia de producto';
		
		if($rst1>0 or $rst2>0 or $rst3>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.$msj3.".";
		}
		else
		{
			$oUsuario->eliminar($_POST['id']);
			$oUsuariodetalle->eliminar($_POST['id']);
			echo 'Se eliminó usuario correctamente.';
		}
	}
	else
	{
		echo 'No se pudo eliminar, intentelo nuevamente.';
	}
}
?>