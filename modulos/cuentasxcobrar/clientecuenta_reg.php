<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once("../formatos/formato.php");

if($_POST['action_clientecuenta']=="insertar")
{
	if(!empty($_POST['cbo_clicue_tip']))
	{
		$oClientecuenta->insertar($_POST['txt_clicue_glo'], $_POST['cbo_clicue_tip'], moneda_mysql($_POST['txt_clicue_mon']), $_POST['cbo_clicue_est'], $_POST['hdd_ven_id'], $_POST['hdd_cli_id']);
		
			$dts=$oClientecuenta->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$clicue_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['clicue_id']=$clicue_id;
		$data['clicue_msj']='Se registró cuenta cliente correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}
if($_POST['action_clientecuenta']=="insertar_pago")
{
	if(!empty($_POST['hdd_clicue_tip']))
	{
		$fec=date('Y-m-d');
		$cuecli_tipreg=2;
		
		$oClientecuenta->insertar( 
			$cuecli_tipreg,
			$fec,
			$_POST['txt_clicue_glo'],
			$_POST['hdd_clicue_tip'], 
			moneda_mysql($_POST['txt_clicue_mon']),
			'0',
			$_POST['hdd_ven_id'],
			$_POST['hdd_forpag_id'], 
			$_POST['hdd_modpag_id'],
            $_POST['hdd_cuecor_id'],
			$_POST['hdd_tar_id'],
            $_POST['hdd_clicue_numope'],
            $_POST['hdd_clicue_numdia'],
            $fecven,
			$_POST['hdd_cli_id'],
			$_POST['hdd_clicue_ver'],
			$_SESSION['empresa_id']
		);

			$dts=$oClientecuenta->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$clicue_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['clicue_id']=$clicue_id;
		$data['clicue_msj']="Se registró pago correctamente.";
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}
if($_POST['action_clientecuenta']=="editar")
{
	if(!empty($_POST['cbo_clicue_tip'])){
		$oClientecuenta->modificar($_POST['hdd_clicue_id'], $_POST['txt_clicue_glo'], $_POST['cbo_clicue_tip'], moneda_mysql($_POST['txt_clicue_mon']), $_POST['cbo_clicue_est'], $_POST['hdd_ven_id'], $_POST['hdd_cli_id']);
		
		$data['clicue_msj']='Se registró Cuenta Cliente correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_clientecuenta']=="editar_pago")
{
	if(!empty($_POST['hdd_clicue_tip'])){
		$oClientecuenta->modificar(
			$_POST['hdd_clicue_id'],
			$_POST['txt_clicue_glo'],
			$_POST['hdd_clicue_tip'],
			moneda_mysql($_POST['txt_clicue_mon']),
			$_POST['hdd_clicue_est']
		);
		
		$data['clicue_msj']='Se registró Pago correctamente.';
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
		/*$cst1 = $oClientecuenta->verifica_clientecuenta_tabla($_POST['id'],'tb_producto');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{*/
			$oClientecuenta->eliminar($_POST['id']);
			echo 'Se eliminó correctamente.';
		/*}
		echo 'No se puede eliminar, afecta información de ventas.';*/
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>