<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cTramitependiente.php");
$oTramitependiente = new cTramitependiente();

if($_POST['action_tramitependiente']=="insertar")
{
	if( !empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['txt_fecha_acuerdo']) &&
        !empty($_POST['txt_fecha_finalizado']) && !empty($_POST['txt_tramite_ejecutar']) && !empty($_POST['txt_fecha_conteo'])
        && !empty($_POST['txt_fecha_plazo'] ) && !empty($_POST['hdd_persdecl_id']))
	{
        $oTramitependiente->insertar($_POST['hdd_recdoc_empresa_id'],fecha_mysql($_POST['txt_fecha_acuerdo']),
            fecha_mysql($_POST['txt_fecha_finalizado']),$_POST['txt_tramite_ejecutar'],
            fecha_mysql($_POST['txt_fecha_conteo']),fecha_mysql($_POST['txt_fecha_plazo']),
            $_POST['hdd_persdecl_id'], strip_tags($_POST['txt_observaciones']));
		
			$dts=$oTramitependiente->ultimoInsert();
			$dt = mysql_fetch_array($dts);
            $trapen_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['trapen_id']=$trapen_id;
		$data['trapen_msj']='Se registró tramite pendiente correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_tramitependiente']=="editar")
{
    if(!empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['txt_fecha_acuerdo']) &&
        !empty($_POST['txt_fecha_finalizado']) && !empty($_POST['txt_tramite_ejecutar']) && !empty($_POST['txt_fecha_conteo'])
        && !empty($_POST['txt_fecha_plazo'] ) && !empty($_POST['hdd_persdecl_id']))
    {
		$oTramitependiente->modificar($_POST['hdd_tramitependiente_id'],$_POST['hdd_recdoc_empresa_id'],fecha_mysql($_POST['txt_fecha_acuerdo']),
            fecha_mysql($_POST['txt_fecha_finalizado']),$_POST['txt_tramite_ejecutar'],
            fecha_mysql($_POST['txt_fecha_conteo']),fecha_mysql($_POST['txt_fecha_plazo']),
            $_POST['hdd_persdecl_id'], strip_tags($_POST['txt_observaciones']));
		
		$data['trapen_msj']='Se registró tramite pendiente correctamente.';
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
//		$cst1 = $oTramitependiente->verifica_tramitependiente_tabla($_POST['id'],'tb_producto');
//		$rst1= mysql_num_rows($cst1);
        $rst1=0;
        if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
            $oTramitependiente->eliminar($_POST['id']);
			echo 'Se eliminó tramite pendiente correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>