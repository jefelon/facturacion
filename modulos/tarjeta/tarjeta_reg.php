<?php
require_once ("../../config/Cado.php");
require_once("cTarjeta.php");
$oTarjeta = new cTarjeta();

if($_POST['action_tarjeta']=="insertar")
{
	if(!empty($_POST['txt_tar_nom']))
	{
		$oTarjeta->insertar(strip_tags($_POST['txt_tar_nom']),$_POST['cmb_caj_id']);
		
			$dts=$oTarjeta->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$tar_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['tar_id']=$tar_id;
		$data['tar_msj']='Se registró tarjeta correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_tarjeta']=="editar")
{
	if(!empty($_POST['txt_tar_nom']))
	{
		$oTarjeta->modificar($_POST['hdd_tar_id'],strip_tags($_POST['txt_tar_nom']),$_POST['cmb_caj_id']);
		
		$data['tar_msj']='Se registró tarjeta correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['tar_id']))
	{
		$cst1 = $oTarjeta->verifica_tarjeta_tabla($_POST['tar_id'],'tb_ventapago');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Pagos en Ventas';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oTarjeta->eliminar($_POST['tar_id']);
			echo 'Se eliminó tarjeta correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>