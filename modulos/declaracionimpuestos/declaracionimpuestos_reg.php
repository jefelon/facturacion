<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cDeclaracionimpuestos.php");
$oDeclaracionimpuestos = new cDeclaracionimpuestos();

if($_POST['action_declaracionimpuestos']=="insertar")
{
	if(!empty($_POST['hdd_empresa_id']) && !empty($_POST['txt_doc_empresa']) && !empty($_POST['txt_nom_empresa'])
        && !empty($_POST['txt_fecha_declaracion']) && !empty($_POST['txt_fecha_vencimiento'])
        && !empty($_POST['txt_fecha_envio']) && $_POST['cmb_estado_envio']!=''
        && !empty($_POST['txt_pdt_nodeclarados'] ) && $_POST['cmb_pago_realizado']!=''
        && !empty($_POST['txt_deudas']) && !empty($_POST['hdd_persdecl_id']))
	{
		$oDeclaracionimpuestos->insertar($_POST['hdd_empresa_id'],fecha_mysql($_POST['txt_fecha_declaracion']),
            fecha_mysql($_POST['txt_fecha_vencimiento']), fecha_mysql($_POST['txt_fecha_envio']),
            $_POST['cmb_estado_envio'], $_POST['txt_pdt_nodeclarados'],
            $_POST['cmb_pago_realizado'], $_POST['txt_deudas'], $_POST['hdd_persdecl_id'],
            strip_tags($_POST['txt_observaciones']));
		
			$dts=$oDeclaracionimpuestos->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		    $recdoc_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['decimp_id']=$recdoc_id;
		$data['decimp_msj']='Se registró declaracionimpuestos correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}





if($_POST['action_declaracionimpuestos']=="editar")
{
    if(!empty($_POST['hdd_declaracionimpuestos_id']) && !empty($_POST['hdd_empresa_id'])
        && !empty($_POST['txt_doc_empresa']) && !empty($_POST['txt_nom_empresa'])
    && !empty($_POST['txt_fecha_declaracion']) && !empty($_POST['txt_fecha_vencimiento'])
    && !empty($_POST['txt_fecha_envio']) && $_POST['cmb_estado_envio']!=''
    && !empty($_POST['txt_pdt_nodeclarados'] ) && $_POST['cmb_pago_realizado']!=''
    && !empty($_POST['txt_deudas']) && !empty($_POST['hdd_persdecl_id']))
    {
        $oDeclaracionimpuestos->modificar($_POST['hdd_declaracionimpuestos_id'],$_POST['hdd_empresa_id'],
            fecha_mysql($_POST['txt_fecha_declaracion']), fecha_mysql($_POST['txt_fecha_vencimiento']),
            fecha_mysql($_POST['txt_fecha_envio']), $_POST['cmb_estado_envio'], $_POST['txt_pdt_nodeclarados'],
            $_POST['cmb_pago_realizado'], $_POST['txt_deudas'], $_POST['hdd_persdecl_id'],
            strip_tags($_POST['txt_observaciones']));
		
		$data['decimp_msj']='Se registró declaracion impuestos correctamente.';
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
//		$cst1 = $oDeclaracionimpuestos->verifica_declaracionimpuestos_tabla($_POST['id'],'tb_producto');
//		$rst1= mysql_num_rows($cst1);
        $rst1= 0;
        if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oDeclaracionimpuestos->eliminar($_POST['id']);
			echo 'Se eliminó declaración impuestos correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>