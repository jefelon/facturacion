<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cLibroelectronico.php");
$oLibroelectronico = new cLibroelectronico();

if($_POST['action_libroelectronico']=="insertar")
{
	if(!empty($_POST['hdd_recdoc_empresa_id']) && !empty($_POST['txt_fech_decl']) && !empty($_POST['txt_fech_ven'])
        && !empty($_POST['txt_libroelectronicos_nodecl']) && $_POST['cmb_libros_vencidos']!=''
        && !empty($_POST['hdd_persdecl_id'] ))
	{
        $oLibroelectronico->insertar($_POST['hdd_recdoc_empresa_id'], fecha_mysql($_POST['txt_fech_decl']),
            fecha_mysql($_POST['txt_fech_ven']), $_POST['txt_libroelectronicos_nodecl'], $_POST['cmb_libros_vencidos'],
            $_POST['hdd_persdecl_id'],$_POST['txt_observaciones']);
		
			$dts=$oLibroelectronico->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		    $libelec_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['libelec_id']=$libelec_id;
		$data['libelec_msj']='Se registró libro electrónico correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_libroelectronico']=="editar")
{
    if(!empty($_POST['hdd_libroelectronico_id']) && !empty($_POST['hdd_recdoc_empresa_id']) &&
        !empty($_POST['txt_fech_decl']) && !empty($_POST['txt_fech_ven'])
        && !empty($_POST['txt_libroelectronicos_nodecl']) && $_POST['cmb_libros_vencidos']!=''
        && !empty($_POST['hdd_persdecl_id'] ))
    {
        $oLibroelectronico->modificar($_POST['hdd_libroelectronico_id'],$_POST['hdd_recdoc_empresa_id'], fecha_mysql($_POST['txt_fech_decl']),
            fecha_mysql($_POST['txt_fech_ven']), $_POST['txt_libroelectronicos_nodecl'], $_POST['cmb_libros_vencidos'],
            $_POST['hdd_persdecl_id'],$_POST['txt_observaciones']);
		
		$data['libelec_msj']='Se registró libro electrónico correctamente.';
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
		$cst1 = $oLibroelectronico->verifica_libroelectronico_tabla($_POST['id'],'tb_producto');
//		$rst1= mysql_num_rows($cst1);
        $rst1= 0;
		if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
            $oLibroelectronico->eliminar($_POST['id']);
			echo 'Se eliminó libro electrónico correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>