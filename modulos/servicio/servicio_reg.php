<?php
require_once("../../config/Cado.php");
require_once("cServicio.php");
$oServicio = new cServicio();
require_once("../formatos/formato.php");

if($_POST['action_servicio']=="insertar")
{
	if(!empty($_POST['txt_ser_nom']))
	{
		
		$dts=$oServicio->mostrar_filtro_2($_POST['txt_ser_nom'],"Activo");
		$num_rows = mysql_num_rows($dts);
		if($num_rows==0){
			//insertamos servicio
			$oServicio->insertar(
                strip_tags($_POST['txt_ser_nom']),
                strip_tags($_POST['txt_ser_des']),
				moneda_mysql($_POST['txt_ser_pre']),
				$_POST['cmb_ser_est'],
				$_POST['cmb_cat_id'],
				$_POST['hdd_ser_aut']
			);
			
			//id servicio
			$dts=$oServicio->ultimoInsert();
			$dt = mysql_fetch_array($dts);
			$ser_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

			$data['ser_id']=$ser_id;		
			$data['ser_msj']='Se registró servicio correctamente.';	
		}
	
		$data['ser_nom']=$_POST['txt_ser_nom'];
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_servicio']=="editar")
{
	if(!empty($_POST['txt_ser_nom']))
	{
		$oServicio->modificar(
			$_POST['hdd_ser_id'],
			strip_tags($_POST['txt_ser_nom']),
            strip_tags($_POST['txt_ser_des']),
			moneda_mysql($_POST['txt_ser_pre']),
			$_POST['cmb_ser_est'],
			$_POST['cmb_cat_id']			
		);
		
		$data['ser_msj']='Se registró servicio correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['ser_id']))
	{
		
			$oServicio->eliminar($_POST['ser_id']);
			echo 'Se eliminó servicio correctamente.';
		
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>