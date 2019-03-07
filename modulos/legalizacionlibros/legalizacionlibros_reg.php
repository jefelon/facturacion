<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cLegalizacionlibros.php");
$oLegalizacionlibros = new cLegalizacionlibros();


if($_POST['action_legalizacionlibros']=="insertar")
{
	if(!empty($_POST['hdd_empresa_id']) && !empty($_POST['txt_doc_empresa']) && !empty($_POST['txt_nom_empresa'])
        && !empty($_POST['txt_domicilio_fiscal']) && !empty($_POST['txt_fecha_recepcion'])
        && !empty($_POST['txt_notaria']) && !empty($_POST['txt_fecha_legalizacion']) && !empty($_POST['txt_fecha_recojo'])
        && !empty($_POST['txt_numdoc'] ) && !empty($_POST['cmb_regimen_tributario'] )
        && !empty($_POST['txt_cantidad_libros']) && !empty($_POST['hdd_responsable_id']) && !empty($_POST['txt_doc_responsable'])
        && !empty($_POST['txt_nom_responsable']) && !empty($_POST['txt_libros_legalizados'])
        && !empty($_POST['txt_libros_nolegalizados']) && !empty($_POST['txt_pendiente_cobro']))
	{
		$oLegalizacionlibros->insertar($_POST['hdd_empresa_id'],$_POST['txt_domicilio_fiscal'],
            fecha_mysql($_POST['txt_fecha_recepcion']),$_POST['txt_notaria'],fecha_mysql($_POST['txt_fecha_legalizacion']),
            fecha_mysql($_POST['txt_fecha_recojo']),$_POST['txt_numdoc'], $_POST['cmb_regimen_tributario'],
            $_POST['txt_cantidad_libros'], $_POST['hdd_responsable_id'],
            $_POST['txt_libros_legalizados'], $_POST['txt_libros_nolegalizados'], $_POST['txt_pendiente_cobro'],
            strip_tags($_POST['txt_observaciones']));
		
			$dts=$oLegalizacionlibros->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		    $recdoc_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['leglib_id']=$recdoc_id;
		$data['leglib_msj']='Se registró legalizacion libros correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_legalizacionlibros']=="editar")
{
    if(!empty($_POST['hdd_empresa_id']) && !empty($_POST['txt_doc_empresa']) && !empty($_POST['txt_nom_empresa'])
        && !empty($_POST['txt_domicilio_fiscal']) && !empty($_POST['txt_fecha_recepcion'])
        && !empty($_POST['txt_notaria']) && !empty($_POST['txt_fecha_legalizacion']) && !empty($_POST['txt_fecha_recojo'])
        && !empty($_POST['txt_numdoc'] ) && !empty($_POST['cmb_regimen_tributario'] )
        && !empty($_POST['txt_cantidad_libros']) && !empty($_POST['hdd_responsable_id']) && !empty($_POST['txt_doc_responsable'])
        && !empty($_POST['txt_nom_responsable']) && !empty($_POST['txt_libros_legalizados'])
        && !empty($_POST['txt_libros_nolegalizados']) && !empty($_POST['txt_pendiente_cobro']))
    {
		$oLegalizacionlibros->modificar($_POST['hdd_legalizacionlibros_id'],$_POST['hdd_empresa_id'],$_POST['txt_domicilio_fiscal'],
            fecha_mysql($_POST['txt_fecha_recepcion']),$_POST['txt_notaria'],fecha_mysql($_POST['txt_fecha_legalizacion']),
            fecha_mysql($_POST['txt_fecha_recojo']),$_POST['txt_numdoc'], $_POST['cmb_regimen_tributario'],
            $_POST['txt_cantidad_libros'], $_POST['hdd_responsable_id'],
            $_POST['txt_libros_legalizados'], $_POST['txt_libros_nolegalizados'], $_POST['txt_pendiente_cobro'],
            strip_tags($_POST['txt_observaciones']));
		
		$data['leglib_msj']='Se registró legalizacion libros correctamente.';
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
//		$cst1 = $oLegalizacionlibros->verifica_legalizacionlibros_tabla($_POST['id'],'tb_producto');
//		$rst1= mysql_num_rows($cst1);
        $rst1=0;
        if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oLegalizacionlibros->eliminar($_POST['id']);
			echo 'Se eliminó legalizacion libros correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>