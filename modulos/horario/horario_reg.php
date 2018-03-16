<?php
require_once ("../../config/Cado.php");
require_once("cHorario.php");
$oHorario = new cHorario();
require_once("../formatos/formato.php");

if($_POST['action_horario']=="insertar")
{
	if(!empty($_POST['txt_hor_nom']))
	{
		$oHorario->insertar(
			$_POST['txt_hor_nom'],
			fecha_mysql($_POST['txt_hor_fecini']),
			fecha_mysql($_POST['txt_hor_fecfin']),
			$_POST['chk_hor_lun'],
			$_POST['chk_hor_mar'],
			$_POST['chk_hor_mie'],
			$_POST['chk_hor_jue'],
			$_POST['chk_hor_vie'],
			$_POST['chk_hor_sab'],
			$_POST['chk_hor_dom'],
			hora_mysql($_POST['txt_hor_horini1']),
			hora_mysql($_POST['txt_hor_horfin1']),
			hora_mysql($_POST['txt_hor_horini2']),
			hora_mysql($_POST['txt_hor_horfin2']),
			$_POST['cmb_hor_est']
		);
		echo 'Se registró horario correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_horario']=="editar")
{
	if(!empty($_POST['txt_hor_nom']))
	{
		$oHorario->modificar(
			$_POST['hdd_hor_id'],
			$_POST['txt_hor_nom'],
			fecha_mysql($_POST['txt_hor_fecini']),
			fecha_mysql($_POST['txt_hor_fecfin']),
			$_POST['chk_hor_lun'],
			$_POST['chk_hor_mar'],
			$_POST['chk_hor_mie'],
			$_POST['chk_hor_jue'],
			$_POST['chk_hor_vie'],
			$_POST['chk_hor_sab'],
			$_POST['chk_hor_dom'],
			hora_mysql($_POST['txt_hor_horini1']),
			hora_mysql($_POST['txt_hor_horfin1']),
			hora_mysql($_POST['txt_hor_horini2']),
			hora_mysql($_POST['txt_hor_horfin2']),
			$_POST['cmb_hor_est']
		);
		echo 'Se registró horario correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['hor_id']))
	{
		$cst1 = $oHorario->verifica_horario_tabla($_POST['hor_id'],'tb_usuariodetalle');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' Usuarios';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oHorario->eliminar($_POST['hor_id']);
			echo 'Se eliminó horario correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>