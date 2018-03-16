<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../guia/cGuia.php");
$oGuia = new cGuia();
require_once("../presentacion/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once("../stock/cStock.php");
$oStock = new cStock();
require_once("../formatos/formato.php");

$igv_dato=0.18;

if($_POST['action_guia']=="insertar")
{
	if(!empty($_POST['txt_gui_fec'])){
		$num_doc = $_POST['txt_gui_tipope_num'];		
		$estado='CONCLUIDA';
		//insertamos guia
		$oGuia->insertar(
			fecha_mysql($_POST['txt_gui_fec']),
			$_POST['txt_gui_rem'],
			$_POST['txt_gui_des'],
			$_POST['txt_gui_punpar'],
			$_POST['txt_gui_punlle'],
			$_POST['txt_gui_num'],			
			$_POST['txt_gui_obs'],
			$_POST['txt_gui_pla'],
			$_POST['txt_gui_mar'],
			$estado,
			$_POST['cbo_gui_tip_ope'],
			$_POST['hdd_gui_ven_id'],
			$_POST['hdd_gui_tra_id'],			
			$_POST['txt_gui_tipope_num'],
			$_POST['txt_fil_gui_con_id'],
			$_POST['txt_fil_gui_tra_id'],
			$_POST['hdd_usu_id'],
			$_SESSION['empresa_id']
		);
		//ultima guia
			$dts=$oGuia->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$gui_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		//detalle productos
		foreach($_SESSION['guia_car'] as $indice=>$cantidad){			
			//registro detalle de guia
			$oGuia->insertar_detalle(
				$indice,				
				$cantidad,				
				$gui_id
			);		
        }
		
		unset($_SESSION['guia_car']);		
		echo 'Se registró guia correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_guia']=="editar")
{
	if(!empty($_POST['txt_gui_fec']))
	{
		$oGuia->modificar(
			$_POST['hdd_gui_id'],
			fecha_mysql($_POST['txt_gui_fec']),
			$_POST['txt_gui_rem'],
			$_POST['txt_gui_des'],
			$_POST['txt_gui_punpar'],
			$_POST['txt_gui_punlle'],
			$_POST['txt_gui_num'],			
			$_POST['txt_gui_obs'],
			$_POST['txt_gui_pla'],
			$_POST['txt_gui_mar'],
			$_POST['hdd_gui_est'],
			$_POST['txt_fil_gui_con_id'],
			$_POST['txt_fil_gui_tra_id']
		);
		
		echo 'Se registró guia correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['gui_id']))
	{
//		$result = $oGuia->verifica_guia_producto($_POST['gui_id']);
//		$fila = mysql_fetch_array($result);
//		
//		if($fila[1] !="")
//		{
			echo "No se puede eliminar, afecta información de productos.";
//		}
//		else
//		{
//			$oGuia->eliminar($_POST['gui_id']);
//		echo 'Se eliminó guia correctamente.';
//		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>