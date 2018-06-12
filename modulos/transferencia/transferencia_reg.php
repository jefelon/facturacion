<?php
session_start();
require_once ("../../config/Cado.php");

require_once ("cTransferencia.php");
$oTransferencia = new cTransferencia();
require_once ("../egreso/cEgreso.php");
$oEgreso = new cEgreso();
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();

require_once("../formatos/formato.php");

if($_POST['action_transferencia']=="insertar")
{
	if(!empty($_POST['txt_tra_fec']) and !empty($_POST['txt_tra_imp']))
	{
		$xac=1;
		$mon_id=1;
		$estado='1';

		$oTransferencia->insertar(
			$_POST['hdd_tra_usureg'],
			$_POST['hdd_tra_usumod'],
			$xac,
			fecha_mysql($_POST['txt_tra_fec']),
			strip_tags($_POST['txt_tra_det']),
			moneda_mysql($_POST['txt_tra_imp']),
			$estado,
			$_POST['cmb_caj_id_ori'],
			$_POST['cmb_caj_id_des'],
			$mon_id,
			$_POST['hdd_emp_id']
		);
		
		//ultima transferencia
			$dts=$oTransferencia->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$tra_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$egr_det	='TRANSFERENCIA SALIDA: '.strip_tags($_POST['txt_tra_det']);
		$cue_salida		=8;
		$doc_id=10;
		$numdoc=$tra_id;
		$egr_est='1';
		$pro_id='1';
		$mod_id=3;

		//registro de SALIDA
		$oEgreso->insertar(
			$_POST['hdd_tra_usureg'],
			$_POST['hdd_tra_usumod'],
			$xac,
			fecha_mysql($_POST['txt_tra_fec']),
			$doc_id,
			$numdoc,
			$egr_det,
			moneda_mysql($_POST['txt_tra_imp']),
			$egr_est,
			$cue_salida,
			$_POST['cmb_subcue_id'],
			$pro_id,
			$_POST['cmb_caj_id_ori'],
			$mon_id,
			$mod_id,
			$tra_id,
			$_POST['hdd_emp_id']
		);
		
		$ing_det	='TRANSFERENCIA ENTRADA: '.strip_tags($_POST['txt_tra_det']);
		$doc_id= 10;
		$numdoc	=$tra_id;
		$cue_entrada	=30;
		$ing_est='1';
		$cli_id='1';
		$mod_id=3;	

		//registro de ENTRADA
		$oIngreso->insertar(
			$_POST['hdd_tra_usureg'],
			$_POST['hdd_tra_usumod'],
			$xac,
			fecha_mysql($_POST['txt_tra_fec']),
			$doc_id,
			$numdoc,
			$ing_det,
			moneda_mysql($_POST['txt_tra_imp']),
			$ing_est,
			$cue_entrada,
			$_POST['cmb_subcue_id'],
			$cli_id,
			$_POST['cmb_caj_id_des'],
			$mon_id,
			$mod_id,
			$tra_id,
			$_POST['hdd_emp_id']
		);

		$data['tra_id']=$tra_id;
		//if($_POST['chk_imprimir']==1)$data['tra_act']='imprime';
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
	if(!empty($_POST['txt_tra_fec']))
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
		$data['tra_msj']='Intentelo nuevamente.';
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
			$oTransferencia->modificar_campo($_POST['tra_id'],$_SESSION['usuario_id'],'xac','0');
			
			$mod_id=3;
			$dts= $oIngreso->mostrar_por_modulo($mod_id,$_POST['tra_id'],$est);
			$dt = mysql_fetch_array($dts);
				$ing_id 	=$dt['tb_ingreso_id'];
			mysql_free_result($dts);
			$oIngreso->modificar_campo($ing_id,$_SESSION['usuario_id'],'xac','0');

			$mod_id=3;
			$dts= $oEgreso->mostrar_por_modulo($mod_id,$_POST['tra_id'],$est);
			$dt = mysql_fetch_array($dts);
				$egr_id 	=$dt['tb_egreso_id'];
			mysql_free_result($dts);
			$oEgreso->modificar_campo($egr_id,$_SESSION['usuario_id'],'xac','0');

			echo 'Se envió a la papelera correctamente.';
		//}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>