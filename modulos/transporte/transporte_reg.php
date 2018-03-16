<?php
require_once ("../../config/Cado.php");
require_once("../transporte/cTransporte.php");
$oTransporte = new cTransporte();

if($_POST['action_transporte']=="insertar")
{
	if(!empty($_POST['txt_tra_ruc']))
	{
		$oTransporte->insertar($_POST['txt_tra_razsoc'], $_POST['txt_tra_ruc'], $_POST['txt_tra_dir'], $_POST['txt_tra_tel'], $_POST['txt_tra_ema']);
		
			$dts=$oTransporte->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$tra_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['tra_id']=$tra_id;
		$data['tra_msj']='Se registró transporte correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_transporte']=="editar")
{
	if(!empty($_POST['txt_tra_ruc']))
	{
		$oTransporte->modificar($_POST['hdd_tra_id'], $_POST['txt_tra_razsoc'], $_POST['txt_tra_ruc'], $_POST['txt_tra_dir'], $_POST['txt_tra_tel'], $_POST['txt_tra_ema']);
		
		$data['tra_msj']='Se registró transporte correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['tra_id']))
	{
		$cst1 = $oTransporte->verifica_transporte_tabla($_POST['tra_id'],'tb_guia');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' Venta';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oTransporte->eliminar($_POST['tra_id']);
			echo 'Se eliminó transporte correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action'] == "obtener_datos"){
	if(!empty($_POST['tra_id'])){
		$rs = $oTransporte->mostrarUno($_POST['tra_id']);		
		$fila = mysql_fetch_array($rs);
			$data['direccion'] = $fila['tb_transporte_dir'];
			$data['ruc'] = $fila['tb_transporte_ruc'];			
			$data['razonsocial'] = $fila['tb_transporte_razsoc'];
		
		echo json_encode($data);
	}else{
		echo "Error en la obtención de datos del Proveedor!";	
	}
}
?>