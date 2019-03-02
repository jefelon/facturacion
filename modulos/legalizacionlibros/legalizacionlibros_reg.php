<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cLegalizacionlibros.php");
$oLegalizacionlibros = new cPlanilla();

if($_POST['action_legalizacionlibros']=="insertar")
{
	if(!empty($_POST['txt_recdoc_fech']) && !empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['hdd_perspentrega_id']) && !empty($_POST['hdd_recepdocumentos_id'])
        && !empty($_POST['hdd_docpersrecojo_id'] ) && !empty($_POST['cmb_pendiente'] ))
	{
		$oLegalizacionlibros->insertar(fecha_mysql($_POST['txt_recdoc_fech']),$_POST['hdd_recdoc_empresa_id'], $_POST['hdd_perspentrega_id'],
            $_POST['hdd_recepdocumentos_id'], $_POST['hdd_docpersrecojo_id'],
            $_POST['cmb_pendiente'], strip_tags($_POST['txt_observaciones']));
		
			$dts=$oLegalizacionlibros->ultimoInsert();
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

if($_POST['action_legalizacionlibros']=="editar")
{
    if(!empty($_POST['hdd_recepcion_id']) && !empty($_POST['txt_recdoc_fech']) && !empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['hdd_perspentrega_id']) && !empty($_POST['hdd_recepdocumentos_id'])
        && !empty($_POST['hdd_docpersrecojo_id'] ) && !empty($_POST['cmb_pendiente'] ))
    {
		$oLegalizacionlibros->modificar($_POST['hdd_recepcion_id'],fecha_mysql($_POST['txt_recdoc_fech']),$_POST['hdd_recdoc_empresa_id'], $_POST['hdd_perspentrega_id'],
            $_POST['hdd_recepdocumentos_id'], $_POST['hdd_docpersrecojo_id'],
            $_POST['cmb_pendiente'], strip_tags($_POST['txt_observaciones']));
		
		$data['recdoc_msj']='Se registró legalizacionlibros correctamente.';
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
		$cst1 = $oLegalizacionlibros->verifica_legalizacionlibros_tabla($_POST['id'],'tb_producto');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oLegalizacionlibros->eliminar($_POST['id']);
			echo 'Se eliminó recepcion correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>