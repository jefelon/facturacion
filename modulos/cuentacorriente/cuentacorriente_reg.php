<?php
require_once ("../../config/Cado.php");
require_once("cCuentacorriente.php");
$oCuentacorriente = new cCuentacorriente();

if($_POST['action_cuentacorriente']=="insertar")
{
	if(!empty($_POST['txt_cuecor_nom']))
	{
		$oCuentacorriente->insertar(strip_tags($_POST['txt_cuecor_nom']),$_POST['cmb_caj_id']);
		
			$dts=$oCuentacorriente->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$cuecor_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['cuecor_id']=$cuecor_id;
		$data['cuecor_msj']='Se registró cuenta corriente correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_cuentacorriente']=="editar")
{
	if(!empty($_POST['txt_cuecor_nom']))
	{
		$oCuentacorriente->modificar($_POST['hdd_cuecor_id'],strip_tags($_POST['txt_cuecor_nom']),$_POST['cmb_caj_id']);
		
		$data['cuecor_msj']='Se registró cuenta corriente correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['cuecor_id']))
	{
		/*$cst1 = $oCuentacorriente->verifica_cuentacorriente_tabla($_POST['cuecor_id'],'tb_ventapago');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Pagos en Ventas';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{*/
			$oCuentacorriente->eliminar($_POST['cuecor_id']);
			echo 'Se eliminó cuenta corriente correctamente.';
		//}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>