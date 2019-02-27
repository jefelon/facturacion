<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cRecursoshumanos.php");
$oRecursoshumanos = new cRecursoshumanos();

if($_POST['action_recursoshumanos']=="insertar")
{
	if(!empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['txt_fecha_ingreso']) && !empty($_POST['txt_fecha_salida'])
        && !empty($_POST['txt_tardanza']) && !empty($_POST['txt_falta']) && !empty($_POST['txt_permisos']))
	{
		$oRecursoshumanos->insertar($_POST['hdd_recdoc_empresa_id'], fecha_mysql($_POST['txt_fecha_ingreso']),
            fecha_mysql($_POST['txt_fecha_salida']), $_POST['txt_tardanza'],
            $_POST['txt_falta'], $_POST['txt_permisos']);
		
			$dts=$oRecursoshumanos->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		    $marper_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['marper_id']=$marper_id;
		$data['marper_msj']='Se registró recurso humano correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_recursoshumanos']=="editar")
{
    if(!empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['txt_cargo']) && !empty($_POST['txt_fecha_ingreso']) && !empty($_POST['txt_fecha_salida'])
        && !empty($_POST['txt_tardanza']) && !empty($_POST['txt_falta']) && !empty($_POST['txt_permisos']))
    {
		$oRecursoshumanos->modificar($_POST['hdd_recursoshumanos_id'],$_POST['hdd_recdoc_empresa_id'],
            fecha_mysql($_POST['txt_fecha_ingreso']),
            fecha_mysql($_POST['txt_fecha_salida']), $_POST['txt_tardanza'],
            $_POST['txt_falta'], $_POST['txt_permisos']);
		
		$data['marper_msj']='Se registró recurso humano correctamente.';
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
//		$cst1 = $oRecursoshumanos->verifica_recursoshumanos_tabla($_POST['id'],'tb_producto');
//		$rst1= mysql_num_rows($cst1);
        $rst1=0;
        if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oRecursoshumanos->eliminar($_POST['id']);
			echo 'Se eliminó recurso humano correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>