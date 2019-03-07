<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cAfp.php");
$oAfp = new cAfp();

if($_POST['action_afp']=="insertar")
{
	if(!empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['txt_fech_decl']) && !empty($_POST['txt_fech_ven']) && !empty($_POST['txt_fech_envio'])
        && $_POST['cmb_estado_envio']!='' && !empty($_POST['txt_afp_decl']) && $_POST['cmb_pago_realizado']!=''
        && !empty($_POST['txt_deudas'] ) && !empty($_POST['hdd_persdecl_id'] ))
	{
        $oAfp->insertar($_POST['hdd_recdoc_empresa_id'],fecha_mysql($_POST['txt_fech_decl']),
            fecha_mysql($_POST['txt_fech_ven']), fecha_mysql($_POST['txt_fech_envio']),
            $_POST['cmb_estado_envio'], $_POST['txt_afp_decl'],
            $_POST['cmb_pago_realizado'], $_POST['txt_deudas'],
            $_POST['hdd_persdecl_id'], strip_tags($_POST['txt_observaciones']));
		
			$dts=$oAfp->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		    $recdoc_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['decldoc_id']=$recdoc_id;
		$data['decldoc_msj']='Se registró AFP correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_afp']=="editar")
{
    if(!empty($_POST['hdd_afp_id']) && !empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['txt_fech_decl']) &&
        !empty($_POST['txt_fech_ven']) && !empty($_POST['txt_fech_envio'])
        && $_POST['cmb_estado_envio']!='' && !empty($_POST['txt_afp_decl']) && $_POST['cmb_pago_realizado']!=''
        && !empty($_POST['txt_deudas'] ) && !empty($_POST['hdd_persdecl_id'] ))
    {
        $oAfp->modificar($_POST['hdd_afp_id'],$_POST['hdd_recdoc_empresa_id'], fecha_mysql($_POST['txt_fech_decl']),
            fecha_mysql($_POST['txt_fech_ven']),fecha_mysql($_POST['txt_fech_envio']),
            $_POST['cmb_estado_envio'], $_POST['txt_afp_decl'],
            $_POST['cmb_pago_realizado'], $_POST['txt_deudas'],
            $_POST['hdd_persdecl_id'], strip_tags($_POST['txt_observaciones']));
		
		$data['decldoc_msj']='Se registró AFP correctamente.';
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
//		$cst1 = $oAfp->verifica_afp_tabla($_POST['id'],'tb_producto');
//		$rst1= mysql_num_rows($cst1);
        $rst1 = 0;
        if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
            $oAfp->eliminar($_POST['id']);
			echo 'Se eliminó AFP correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>