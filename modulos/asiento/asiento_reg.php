<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cAsiento.php");
$oAsiento = new cAsiento();

if($_POST['action_asiento']=="insertar")
{
	if(!empty($_POST['txt_asiento_nom']))
	{
		$oAsiento->insertar(strip_tags($_POST['txt_asiento_nom']),$_SESSION['empresa_id']);
		
			$dts=$oAsiento->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$asiento_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['asiento_id']=$asiento_id;
		$data['asiento_msj']='Se registró asiento correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_asiento']=="editar")
{
	if(!empty($_POST['txt_asiento_nom']))
	{
		$oAsiento->modificar($_POST['hdd_asiento_id'],strip_tags($_POST['txt_asiento_nom']));
		
		$data['asiento_msj']='Se registró asiento correctamente.';
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
		$cst1 = $oAsiento->verifica_asiento_tabla($_POST['id'],'tb_producto');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oAsiento->eliminar($_POST['id']);
			echo 'Se eliminó asiento correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>