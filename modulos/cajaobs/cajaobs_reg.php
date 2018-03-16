<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../cajaobs/cCajaobs.php");
$oCajaobs = new cCajaobs();
require_once("../formatos/formato.php");

if($_POST['action_cajaobs']=="insertar")
{
	if(!empty($_POST['hdd_emp_id']))
	{

		$dts= $oCajaobs->verificar_cierre_caja($_SESSION['empresa_id'],$_POST['cmb_caj_id'],fecha_mysql($_POST['txt_cajobs_fec']));
		$dt = mysql_fetch_array($dts);
			$fecreg		=mostrarFechaHora($dt['tb_cajaobs_fecreg']);
			$fecmod		=mostrarFechaHora($dt['tb_cajaobs_fecmod']);
			$fec		=mostrarFecha($dt['tb_cajaobs_fec']);
		mysql_free_result($dts);

		if($fecreg!="")
		{
			$data['cajobs_msj']="Ya existe cierre de caja en la fecha $fec.";
		}
		else
		{

			$xac=1;

			$oCajaobs->insertar(
				$_POST['hdd_cajobs_usureg'],
				$_POST['hdd_cajobs_usumod'],
				$xac,
				fecha_mysql($_POST['txt_cajobs_fec']),
				$_POST['txt_cajobs_det'],
				$_POST['cmb_cajobs_est'],
				$_POST['cmb_caj_id'],
				$_POST['hdd_emp_id']
			);

			$data['cajobs_msj']='Se registró observación correctamente.';
		}
	}
	else
	{
		$data['cajobs_msj']='Intentelo nuevamente.';
	}
	echo json_encode($data);
}

if($_POST['action_cajaobs']=="editar")
{
	if(!empty($_POST['hdd_cajobs_id']))
	{

		$oCajaobs->modificar(
			$_POST['hdd_cajobs_id'],
			$_POST['hdd_cajobs_usumod'],
			fecha_mysql($_POST['txt_cajobs_fec']),
			$_POST['txt_cajobs_det'],
			$_POST['cmb_cajobs_est'],
			$_POST['cmb_caj_id']
		);
		
		$data['cajobs_msj']='Se registró observación correctamente.';

	}
	else
	{
		$data['cajobs_msj']='Intentelo nuevamente.';
	}
	echo json_encode($data);
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['cajobs_id']))
	{
		//$cst1 = $oCajaobs->verifica_cajaobs_tabla($_POST['cajobs_id'],'tb_cajaobs');
		//$rst1= mysql_num_rows($cst1);
		//if($rst1>0)$msj1=' - Cajaobss';
		
		/*if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{*/
			$oCajaobs->modificar_campo($_POST['cajobs_id'],$_SESSION['usuario_id'],'xac','0');
			echo 'Se envió a la papelera correctamente.';
		//}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>