<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cBalancesanuales.php");
$oBalancesanuales = new cBalancesanuales();


if($_POST['action_balancesanuales']=="insertar")
{
	if(!empty($_POST['hdd_empresa_id']) && !empty($_POST['txt_doc_empresa']) && !empty($_POST['txt_nom_empresa'])
        && !empty($_POST['txt_fecha_comienza']) && !empty($_POST['txt_fecha_culminacion'] )
        && !empty($_POST['txt_fecha_declaracion']) && !empty($_POST['txt_fecha_vencimiento'] )
        && $_POST['cmb_balances_declarados']!='' && $_POST['cmb_balances_nodeclarados']!=''
        && !empty($_POST['txt_apagar']) && $_POST['cmb_pago_anual']!=''
        && !empty($_POST['hdd_persona_elaboracion_id']) && !empty($_POST['txt_doc_responsable_elaboracion'])
        && !empty($_POST['txt_nom_responsable_elaboracion']) && !empty($_POST['hdd_persona_declaracion_id'])
        && !empty($_POST['txt_doc_responsable_declaracion']) && !empty($_POST['txt_nom_responsable_declaracion']))
	{
		$oBalancesanuales->insertar($_POST['hdd_empresa_id'],fecha_mysql($_POST['txt_fecha_comienza']),
            fecha_mysql($_POST['txt_fecha_culminacion']), fecha_mysql($_POST['txt_fecha_declaracion']),
            fecha_mysql($_POST['txt_fecha_vencimiento']), $_POST['cmb_balances_declarados'],
            $_POST['cmb_balances_nodeclarados'],$_POST['txt_apagar'], $_POST['cmb_pago_anual'],
            $_POST['hdd_persona_elaboracion_id'],$_POST['hdd_persona_declaracion_id'],
            strip_tags($_POST['txt_observaciones']));
		
			$dts=$oBalancesanuales->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		    $recdoc_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['balanu_id']=$recdoc_id;
		$data['balanu_msj']='Se registró balancesanuales correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_balancesanuales']=="editar")
{
    if(!empty($_POST['hdd_empresa_id']) && !empty($_POST['txt_doc_empresa']) && !empty($_POST['txt_nom_empresa'])
        && !empty($_POST['txt_fecha_comienza']) && !empty($_POST['txt_fecha_culminacion'] )
        && !empty($_POST['txt_fecha_declaracion']) && !empty($_POST['txt_fecha_vencimiento'] )
        && $_POST['cmb_balances_declarados']!='' && $_POST['cmb_balances_nodeclarados']!=''
        && !empty($_POST['txt_apagar']) && $_POST['cmb_pago_anual']!=''
        && !empty($_POST['hdd_persona_elaboracion_id']) && !empty($_POST['txt_doc_responsable_elaboracion'])
        && !empty($_POST['txt_nom_responsable_elaboracion']) && !empty($_POST['hdd_persona_declaracion_id'])
        && !empty($_POST['txt_doc_responsable_declaracion']) && !empty($_POST['txt_nom_responsable_declaracion']))
    {
		$oBalancesanuales->modificar($_POST['hdd_balancesanuales_id'],$_POST['hdd_empresa_id'],
            fecha_mysql($_POST['txt_fecha_comienza']), fecha_mysql($_POST['txt_fecha_culminacion']),
            fecha_mysql($_POST['txt_fecha_declaracion']), fecha_mysql($_POST['txt_fecha_vencimiento']),
            $_POST['cmb_balances_declarados'], $_POST['cmb_balances_nodeclarados'],$_POST['txt_apagar'],
            $_POST['cmb_pago_anual'], $_POST['hdd_persona_elaboracion_id'],$_POST['hdd_persona_declaracion_id'],
            strip_tags($_POST['txt_observaciones']));
		
		$data['balanu_msj']='Se registró balancesanuales correctamente.';
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
//		$cst1 = $oBalancesanuales->verifica_balancesanuales_tabla($_POST['id'],'tb_producto');
//		$rst1= mysql_num_rows($cst1);
        $rst1=0;
        if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oBalancesanuales->eliminar($_POST['id']);
			echo 'Se eliminó balance anual correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>