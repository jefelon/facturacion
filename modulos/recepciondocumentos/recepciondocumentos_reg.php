<?php
require_once ("../../config/Cado.php");
require_once("cRecepcionDocumentos.php");
$oRecepcionDocumentos = new cRecepcionDocumentos();

if($_POST['action_recepciondocumentos']=="insertar")
{
	if(!empty($_POST['txt_recdoc_nom']))
	{
		$oRecepcionDocumentos->insertar(strip_tags($_POST['txt_recdoc_nom']));
		
			$dts=$oRecepcionDocumentos->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$recdoc_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['recdoc_id']=$recdoc_id;
		$data['recdoc_msj']='Se registró recepción correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_recepciondocumentos']=="editar")
{
	if(!empty($_POST['txt_recdoc_nom']))
	{
		$oRecepcionDocumentos->modificar($_POST['hdd_recdoc_id'],strip_tags($_POST['txt_recdoc_nom']));
		
		$data['recdoc_msj']='Se registró recepciondocumentos correctamente.';
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
		$cst1 = $oRecepcionDocumentos->verifica_recepciondocumentos_tabla($_POST['id'],'tb_producto');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oRecepcionDocumentos->eliminar($_POST['id']);
			echo 'Se eliminó recepcion correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>