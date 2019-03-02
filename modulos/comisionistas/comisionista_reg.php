<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cComisionista.php");
$oComisionista = new cComisionista();

if($_POST['action_comisionista']=="insertar")
{
	if(!empty($_POST['hdd_empresa_id']) && !empty($_POST['txt_doc_empresa']) && !empty($_POST['txt_nom_empresa'])
        && !empty($_POST['hdd_intermediario_id']) && !empty($_POST['txt_doc_intermediario']) &&
        !empty($_POST['txt_nom_intermediario']) && !empty($_POST['txt_fecha_consiguio'] )
        && !empty($_POST['cmb_opcion_com']) && !empty($_POST['txt_cobro']) && !empty($_POST['txt_comision'])
        && !empty($_POST['txt_mes1']) && !empty($_POST['txt_mes2']) && !empty($_POST['txt_mes3'])
        && !empty($_POST['txt_monto_total']))
	{
        $oComisionista->insertar($_POST['hdd_empresa_id'],$_POST['hdd_intermediario_id'],
            fecha_mysql($_POST['txt_fecha_consiguio']), $_POST['cmb_opcion_com'],
            $_POST['txt_cobro'], $_POST['txt_comision'],$_POST['txt_mes1'], $_POST['txt_mes2'], $_POST['txt_mes3'],
            $_POST['txt_monto_total']);

			$dts=$oComisionista->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		    $recdoc_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['com_id']=$recdoc_id;
		$data['com_msj']='Se registró comisionista correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_comisionista']=="editar")
{
    if(!empty($_POST['hdd_comisionista_id']) && !empty($_POST['hdd_empresa_id']) && !empty($_POST['txt_doc_empresa']) && !empty($_POST['txt_nom_empresa'])
        && !empty($_POST['hdd_intermediario_id']) && !empty($_POST['txt_doc_intermediario']) &&
        !empty($_POST['txt_nom_intermediario']) && !empty($_POST['txt_fecha_consiguio'] )
        && !empty($_POST['cmb_opcion_com']) && !empty($_POST['txt_cobro']) && !empty($_POST['txt_comision'])
        && !empty($_POST['txt_mes1']) && !empty($_POST['txt_mes2']) && !empty($_POST['txt_mes3'])
        && !empty($_POST['txt_monto_total']))
    {
        $oComisionista->modificar($_POST['hdd_comisionista_id'], $_POST['hdd_empresa_id'],
            $_POST['hdd_intermediario_id'], fecha_mysql($_POST['txt_fecha_consiguio']), $_POST['cmb_opcion_com'],
            $_POST['txt_cobro'], $_POST['txt_comision'],$_POST['txt_mes1'], $_POST['txt_mes2'], $_POST['txt_mes3'],
            $_POST['txt_monto_total']);
		
		$data['com_msj']='Se registró comisionista correctamente.';
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
//		$cst1 = $oComisionista->verifica_comisionista_tabla($_POST['id'],'tb_producto');
		$rst1= mysql_num_rows($cst1);
        $cst1=0;
		if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
            $oComisionista->eliminar($_POST['id']);
			echo 'Se eliminó comisionista correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>