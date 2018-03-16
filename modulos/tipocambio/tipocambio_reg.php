<?php
require_once ("../../config/Cado.php");
require_once("../tipocambio/cTipoCambio.php");
$oTipoCambio = new cTipoCambio();
require_once("../formatos/formato.php");

if($_POST['action_tipocambio']=="insertar")
{
	if(!empty($_POST['txt_tipcam_fec']))
	{
		//verificar si existe registro
		$fecha = $_POST['txt_tipcam_fec'];
		$fecha = fecha_mysql($fecha);	
		$rs = $oTipoCambio->consultar($fecha);
		
		if(mysql_num_rows($rs)==0)
		{
			$oTipoCambio->insertar(
				fecha_mysql($_POST['txt_tipcam_fec']), 
				$_POST['txt_tipcam_dolsun']
			);
			$data['tipcam_msj']='Se registró tipo de cambio correctamente.';
			
				$dts=$oTipoCambio->ultimoInsert();
				$dt = mysql_fetch_array($dts);
			$tipcam_id=$dt['last_insert_id()'];
				mysql_free_result($dts);
			
			$data['tipcam_id']=$tipcam_id;
		}
		else
		{			
			$data['tipcam_msj']='Existe registro de fecha: '.$_POST['txt_tipcam_fec'].'.';
		}
		
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_tipocambio']=="editar")
{
	if(!empty($_POST['hdd_tipcam_id']))
	{
		$oTipoCambio->modificar(
			$_POST['hdd_tipcam_id'], 
			fecha_mysql($_POST['txt_tipcam_fec']), 
			$_POST['txt_tipcam_dolsun']);
		
		$data['tipcam_msj']='Se registró tipo de cambio correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['tipcam_id']))
	{
		
		$oTipoCambio->eliminar($_POST['tipcam_id']);
		echo 'Se eliminó tipocambio correctamente.';
		
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

//Consultar si existen al menos un tipo de cambio registrado el día de hoy
if($_POST['action']=="consultar"){	
	$fechahoy = date('d-m-Y');
	$fechahoy = fecha_mysql($fechahoy);	
		$rs = $oTipoCambio->consultar($fechahoy);
		$dt = mysql_fetch_array($rs);
	$num_tipocambio = $dt['tb_tipocambio_dolsun'];
		mysql_free_result($rs);
	echo $num_tipocambio;	
}

if($_POST['action']=="obtener_dato"){
	//soles
	if($_POST['moneda']=='1')
	{
		$tipocambio=formato_money(1.00);
	}
	//dolares
	if($_POST['moneda']=='2')
	{
		$fecha_buscar=fecha_mysql($_POST['fecha']);
		//$fechahoy = date('d-m-Y');
		//$fechahoy = fecha_mysql($fechahoy);	
		$rs = $oTipoCambio->consultar($fecha_buscar);
		$dt = mysql_fetch_array($rs);
		$tipocambio = number_format($dt['tb_tipocambio_dolsun'], 3);
		if($tipocambio=='0.000')$tipocambio = "";
		mysql_free_result($rs);
		//$tipocambio=formato_money(3.00);
	}
	$data['tipcam']=$tipocambio;
	echo json_encode($data);
}	
?>