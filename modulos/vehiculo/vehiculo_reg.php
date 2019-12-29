<?php
require_once ("../../config/Cado.php");
require_once("cVehiculo.php");
$oVehiculo = new cVehiculo();

if($_POST['action_vehiculo']=="insertar")
{
	if(!empty($_POST['txt_veh_pla']))
	{
		$oVehiculo->insertar(
		    strip_tags($_POST['txt_veh_pla']),
            $_POST['cmb_conductor'],
            strip_tags($_POST['txt_veh_mar']),
            strip_tags($_POST['txt_veh_mod']),
            $_POST['txt_veh_numasi'],
            strip_tags($_POST['cmb_pisos'])
            );
		
			$dts=$oVehiculo->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$veh_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['veh_id']=$veh_id;
		$data['veh_msj']='Se registró vehiculo correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_vehiculo']=="editar")
{
	if(!empty($_POST['txt_veh_pla']))
	{
		$oVehiculo->modificar(
		    $_POST['hdd_veh_id'],
            strip_tags($_POST['txt_veh_pla']),
            $_POST['cmb_conductor'],
            strip_tags($_POST['txt_veh_mar']),
            strip_tags($_POST['txt_veh_mod']),
            $_POST['txt_veh_numasi'],
            strip_tags($_POST['cmb_pisos'])
        );
		
		$data['veh_msj']='Se registró marca correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
		$cst1 = $oVehiculo->verifica_vehiculo_tabla($_POST['id'],'tb_viajehorario');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Viaje Horario';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oVehiculo->eliminar($_POST['id']);
			echo 'Se eliminó vehiculo correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>