<?php
require_once ("../../config/Cado.php");
require_once("cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once("../formatos/formato.php");

if($_POST['action']=="insertar")
{
	if(!empty($_POST['txt_tipcam']))
	{
		$oCatalogo->actualizar_cambio(
			$_POST['txt_tipcam']
		);

		$data['msj']='Se actualizó correctamente';
		
	}
	else
	{
		$data['msj']='Error.';
	}
	echo json_encode($data);
}

?>