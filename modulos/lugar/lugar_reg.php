<?php
require_once ("../../config/Cado.php");
require_once("cLugar.php");
$oLugar = new cLugar();

if($_POST['action_lugar']=="insertar")
{
	if(!empty($_POST['txt_lugar_nom']))
	{
        $oLugar->insertar(strip_tags($_POST['txt_lugar_nom']));
		
			$dts=$oLugar->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		    $lugar_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['lugar_id']=$lugar_id;
		$data['lugar_msj']='Se registró el lugar correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_lugar']=="editar")
{
	if(!empty($_POST['txt_lugar_nom']))
	{
		$oLugar->modificar($_POST['hdd_lugar_id'],strip_tags($_POST['txt_lugar_nom']));
		
		$data['lugar_msj']='Se registró el lugar correctamente.';
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
		$cst1 = $oLugar->verifica_lugar_tabla($_POST['id'],'tb_viajehorario');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Viaje Horario';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oLugar->eliminar($_POST['id']);
			echo 'Se eliminó lugar correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>