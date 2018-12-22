<?php
require_once ("../../config/Cado.php");
require_once ("cGasto.php");
$oGasto = new cGasto();
require_once("../formatos/formato.php");

if($_POST['action_gasto']=="insertar")
{
	if(!empty($_POST['hdd_emp_id']) and !empty($_POST['txt_gas_fec']) and !empty($_POST['cmb_cue_id']))
	{
		$oGasto->insertar(
			fecha_mysql($_POST['txt_gas_fec']),
            strip_tags($_POST['txt_gas_doc']),
            strip_tags($_POST['txt_gas_des']),
			moneda_mysql($_POST['txt_gas_imp']),
			$_POST['cmb_gas_modpag'],
            strip_tags($_POST['txt_gas_numope']),
			$_POST['cmb_gas_est'], 
			$_POST['cmb_cue_id'],
			$_POST['cmb_subcue_id'],
			$_POST['hdd_prov_id'],
			$_POST['cmb_entfin_id'],
			$_POST['cmb_caj_id'],
			$_POST['cmb_mon_id'],
			'',
			$_POST['hdd_com_id'],
			$_POST['hdd_emp_id'],
			$_POST['hdd_usu_id_reg'],
			$_POST['hdd_usu_id_mod']
			);

		$data['gas_msj']='Se registró gasto correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_gasto']=="editar")
{
	if(!empty($_POST['hdd_emp_id']) and !empty($_POST['txt_gas_fec']) and !empty($_POST['cmb_cue_id']))
	{
		$oGasto->modificar(
			$_POST['hdd_gas_id'],
			fecha_mysql($_POST['txt_gas_fec']),
            strip_tags($_POST['txt_gas_doc']),
            strip_tags($_POST['txt_gas_des']),
			moneda_mysql($_POST['txt_gas_imp']),
			$_POST['cmb_gas_modpag'],
            strip_tags($_POST['txt_gas_numope']),
			$_POST['cmb_gas_est'], 
			$_POST['cmb_cue_id'],
			$_POST['cmb_subcue_id'],
            $_POST['hdd_prov_id'],
			$_POST['cmb_entfin_id'],
			$_POST['cmb_caj_id'],
			$_POST['cmb_mon_id'],
			$_POST['hdd_usu_id_mod']
			);
		
		$data['gas_msj']='Se registró gasto correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['gas_id']))
	{
		//$cst1 = $oGasto->verifica_gasto_tabla($_POST['gas_id'],'tb_gasto');
		//$rst1= mysql_num_rows($cst1);
		//if($rst1>0)$msj1=' - Gastos';
		
		/*if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{*/
			$oGasto->eliminar($_POST['gas_id']);
			echo 'Se eliminó gasto correctamente.';
			//echo 'No es posible eliminar.';
		//}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>