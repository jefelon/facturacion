<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../probalancecontrol/cProbalancecontrol.php");
$oProbalancecontrol = new cProbalancecontrol();

if($_POST['action']=="insertar")
{
	if(!empty($_POST['cli_id']) and !empty($_POST['probalite_id']) and !empty($_POST['per_id']) and !empty($_POST['eje_id']))
	{
		$xac=1;

		$oProbalancecontrol->insertar_control(
			$xac,
			$_SESSION['usuario_id'],
			$_SESSION['usuario_id'],
			$_POST['cli_id'], 
			$_POST['probalite_id'],
			$_POST['per_id'],
			$_POST['eje_id']
		);
		
			$dts=$oProbalancecontrol->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$probalcon_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		
		$data['probalcon_id']=$probalcon_id;
		$data['probalcon_msj']='Se registró correctamente.';
		
	}
	else
	{
		$data['probalcon_msj']='Intentelo nuevamente.';
	}

	echo json_encode($data);
}

if($_POST['action']=="editar")
{
	if(!empty($_POST['probalcon_id']))
	{

		$oProbalancecontrol->editar_control(
			$_POST['probalcon_id'], 
			$_POST['xac'],
			$_SESSION['usuario_id']
		);
		
		$data['probalcon_id']=$_POST['probalcon_id'];
		$data['probalcon_msj']='Se registró correctamente.';
		
	}
	else
	{
		$data['probalcon_msj']='Intentelo nuevamente.';
	}

	echo json_encode($data);
}

?>