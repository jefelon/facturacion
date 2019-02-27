<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cAfp.php");
$oRecepcionDocumentos = new cPlanilla();

if($_POST['action_recepciondocumentos']=="insertar")
{
	if(!empty($_POST['txt_recdoc_fech']) && !empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['hdd_perspentrega_id']) && !empty($_POST['hdd_recepdocumentos_id'])
        && !empty($_POST['hdd_docpersrecojo_id'] ) && !empty($_POST['cmb_pendiente'] ))
	{
		$oRecepcionDocumentos->insertar(fecha_mysql($_POST['txt_recdoc_fech']),$_POST['hdd_recdoc_empresa_id'], $_POST['hdd_perspentrega_id'],
            $_POST['hdd_recepdocumentos_id'], $_POST['hdd_docpersrecojo_id'],
            $_POST['cmb_pendiente'], strip_tags($_POST['txt_observaciones']));
		
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
    if(!empty($_POST['hdd_recepcion_id']) && !empty($_POST['txt_recdoc_fech']) && !empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['hdd_perspentrega_id']) && !empty($_POST['hdd_recepdocumentos_id'])
        && !empty($_POST['hdd_docpersrecojo_id'] ) && !empty($_POST['cmb_pendiente'] ))
    {
		$oRecepcionDocumentos->modificar($_POST['hdd_recepcion_id'],fecha_mysql($_POST['txt_recdoc_fech']),$_POST['hdd_recdoc_empresa_id'], $_POST['hdd_perspentrega_id'],
            $_POST['hdd_recepdocumentos_id'], $_POST['hdd_docpersrecojo_id'],
            $_POST['cmb_pendiente'], strip_tags($_POST['txt_observaciones']));
		
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