<?php
require_once ("../../config/Cado.php");

require_once ("cTransferencia.php");
$oTransferencia = new cTransferencia();
require_once ("../gasto/cGasto.php");
$oGasto = new cGasto();
require_once ("../ingreso_r/cIngreso.php");
$oIngreso = new cIngreso();

require_once("../formatos/formato.php");

if($_POST['action_transferencia']=="insertar")
{
	if(!empty($_POST['txt_tra_fec']) and !empty($_POST['txt_tra_mon']))
	{
			$dts= $oTransferencia->codigo();
		$dt = mysql_fetch_array($dts);
			$cod	=$dt['maximo'];
		mysql_free_result($dts);
		$cod=$cod+1;
	
		$estado='CANCELADA';
		//registro de tranasferencia
		$oTransferencia->insertar(
			fecha_mysql($_POST['txt_tra_fec']),
			$cod,
            strip_tags($_POST['txt_tra_des']),
			$_POST['cmb_ref_id'],
			$_POST['cmb_entfin_id'],
			$_POST['cmb_tra_modpag'],
			moneda_mysql($_POST['txt_tra_mon']),
			$estado,
			$_POST['cmb_caj_id_ori'],
			$_POST['cmb_caj_id_des'],
			$_POST['cmb_mon_id'],
			$_POST['hdd_emp_id'],
			$_POST['hdd_usu_id_reg'],
			$_POST['hdd_usu_id_mod']
		);
		
		//ultima transferencia
			$dts=$oTransferencia->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$tra_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$glosa_salida	='TRANSFERENCIA A CAJA TERCEROS: '.strip_tags($_POST['txt_tra_des']);
		$doc_salida		='TCT '.$cod;
		$cue_salida		=33;//PAGO PROVEEDORES
		
		//registro de SALIDA caja general
		$oGasto->insertar(
			fecha_mysql($_POST['txt_tra_fec']),
			$doc_salida,
			$glosa_salida,
			moneda_mysql($_POST['txt_tra_mon']), 
			$_POST['cmb_tra_modpag'], 
			'',
			'CANCELADO',
			$cue_salida,
			'',
			'',
			$_POST['cmb_entfin_id'],
			$_POST['cmb_caj_id_ori'],
			$_POST['cmb_mon_id'],
			$_POST['cmb_ref_id'],
			$tra_id,
			$_POST['hdd_emp_id'],
			$_POST['hdd_usu_id_reg'],
			$_POST['hdd_usu_id_mod']
		);
		
		$glosa_entrada	='TRANSFERENCIA DESDE CAJA GENERAL: '.strip_tags($_POST['txt_tra_des']);
		$doc_entrada	='TCT '.$cod;
		$cue_entrada	=3;//INGRESO POR TRANSFERENCIA
	
		//registro de ENTRADA caja tercero
		$oIngreso->insertar(
			'',
			fecha_mysql($_POST['txt_tra_fec']),
			$doc_entrada,
			$glosa_entrada,
			moneda_mysql($_POST['txt_tra_mon']),
			'CANCELADO', 
			$cue_entrada,
			'',
			$_POST['cmb_entfin_id'],
			'',
			'',
			$_POST['cmb_caj_id_des'],
			$_POST['cmb_mon_id'],
			$_POST['cmb_ref_id'],
			$tra_id,
			$_POST['hdd_emp_id'],
			$_POST['hdd_usu_id_reg'],
			$_POST['hdd_usu_id_mod']
		);

		$data['tra_msj']='Se registró transferencia correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_transferencia']=="editar")
{
	if(!empty($_POST['txt_tra_fec']) and !empty($_POST['txt_tra_mon']))
	{
/*		$oTransferencia->modificar(
			$_POST['hdd_tra_id'],
			fecha_mysql($_POST['txt_tra_fecemi']),
			fecha_mysql($_POST['txt_tra_feccon']),
			$_POST['txt_tra_doc'],
			$_POST['txt_tra_des'],
			moneda_mysql($_POST['txt_tra_mon']),
			$_POST['cmb_tra_est'],
			$_POST['cmb_cue_id'],
			$_POST['cmb_subcue_id'],
			$_POST['cmb_entfin_id'],
			$_POST['txt_tra_numope'],
			$_POST['cmb_cli_id'],
			$_POST['cmb_caj_id'],
			$_POST['cmb_ref_id'],
			$_POST['hdd_usu_id_mod']
			);*/
		
		$data['tra_msj']='No es posible editar o guardar cambios.';
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
		//$cst1 = $oTransferencia->verifica_transferencia_tabla($_POST['tra_id'],'tb_transferencia');
		//$rst1= mysql_num_rows($cst1);
		//if($rst1>0)$msj1=' - Transferencias';
		
		/*if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{*/
			$oTransferencia->eliminar($_POST['tra_id']);
			echo 'Se eliminó transferencia correctamente.';
		//}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>