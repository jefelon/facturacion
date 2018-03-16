<?php
require_once ("../../config/Cado.php");

require_once ("cIngreso.php");
$oIngreso = new cIngreso();
require_once("../formatos/formato.php");

if($_POST['action_ingreso']=="insertar")
{
	if(!empty($_POST['hdd_emp_id']) and !empty($_POST['txt_ing_feccon']) and !empty($_POST['cmb_cue_id']))
	{
		$oIngreso->insertar(
			fecha_mysql($_POST['txt_ing_fecemi']),
			fecha_mysql($_POST['txt_ing_feccon']),
			$_POST['txt_ing_doc'],
			$_POST['txt_ing_des'],
			moneda_mysql($_POST['txt_ing_mon']),
			$_POST['cmb_ing_est'],
			$_POST['cmb_cue_id'],
			$_POST['cmb_subcue_id'],
			$_POST['cmb_entfin_id'],
			$_POST['txt_ing_numope'],
			$_POST['cmb_cli_id'],
			$_POST['cmb_caj_id'],
			$_POST['cmb_mon_id'],
			$_POST['cmb_ref_id'],
			'',
			$_POST['hdd_emp_id'],
			$_POST['hdd_usu_id_reg'],
			$_POST['hdd_usu_id_mod']
			);

		$data['ing_msj']='Se registró ingreso correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_ingreso']=="editar")
{
	if(!empty($_POST['hdd_emp_id']) and !empty($_POST['txt_ing_feccon']) and !empty($_POST['cmb_cue_id']))
	{
		$oIngreso->modificar(
			$_POST['hdd_ing_id'],
			fecha_mysql($_POST['txt_ing_fecemi']),
			fecha_mysql($_POST['txt_ing_feccon']),
			$_POST['txt_ing_doc'],
			$_POST['txt_ing_des'],
			moneda_mysql($_POST['txt_ing_mon']),
			$_POST['cmb_ing_est'],
			$_POST['cmb_cue_id'],
			$_POST['cmb_subcue_id'],
			$_POST['cmb_entfin_id'],
			$_POST['txt_ing_numope'],
			$_POST['cmb_cli_id'],
			$_POST['cmb_caj_id'],
			$_POST['cmb_mon_id'],
			$_POST['cmb_ref_id'],
			$_POST['hdd_usu_id_mod']
			);
		
		$data['ing_msj']='Se registró ingreso correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['ing_id']))
	{
		//$cst1 = $oIngreso->verifica_ingreso_tabla($_POST['ing_id'],'tb_ingreso');
		//$rst1= mysql_num_rows($cst1);
		//if($rst1>0)$msj1=' - Ingresos';
		
		/*if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{*/
			//$oIngreso->eliminar($_POST['ing_id']);
			//echo 'Se eliminó ingreso correctamente.';
			echo 'No es posible eliminar.';
		//}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>