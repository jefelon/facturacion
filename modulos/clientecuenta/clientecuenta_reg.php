<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
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
		$cuecli_tipreg=2;//manual
		$est=0;
		$xac=1;
		
		$oClientecuenta->insertar( 
			$xac,
			$cuecli_tipreg,
			fecha_mysql($_POST['txt_clicue_fec']),
			$_POST['txt_clicue_glo'],
			$_POST['hdd_clicue_tip'], 
			moneda_mysql($_POST['txt_clicue_mon']),
			$est,
			$_POST['hdd_clicue_ventip'],
			$_POST['hdd_clicue_ven_id'],
			$_POST['cmb_forpag_id'], 
			$_POST['cmb_modpag_id'],
      		$_POST['cmb_cuecor_id'],
			$_POST['cmb_tar_id'],
      		$_POST['txt_venpag_numope'],
      		$_POST['hdd_clicue_numdia'],
     		$fecven,
			$_POST['hdd_cli_id'],
			$_POST['hdd_clicue_ver'],
			$_POST['hdd_clicue_idp'],
			$_SESSION['usuario_id'],
			$_SESSION['empresa_id']
		);

			$dts=$oClientecuenta->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$clicue_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		//consulta venta
		$dts= $oVenta->mostrarUno($_POST['hdd_clicue_ven_id']);
		$dt = mysql_fetch_array($dts);
			$reg	=mostrarFechaHora($dt['tb_venta_reg']);
			
			$fec	=mostrarFecha($dt['tb_venta_fec']);
			
			$doc_id	=$dt['tb_documento_id'];
			$numdoc	=$dt['tb_venta_numdoc'];
			$cli_id	=$dt['tb_cliente_id'];
			$cli_nom = $dt['tb_cliente_nom'];
			$cli_doc = $dt['tb_cliente_doc'];
			$cli_dir = $dt['tb_cliente_dir'];
			$cli_tip = $dt['tb_cliente_tip'];
			
			$subtot	=$dt['tb_venta_subtot'];
			$igv	=$dt['tb_venta_igv'];
			$tot	=$dt['tb_venta_tot'];
			$est	=$dt['tb_venta_est'];
			
			$punven_id	=$dt['tb_puntoventa_id'];
			$punven_nom	=$dt['tb_puntoventa_nom'];
			$alm_nom	=$dt['tb_almacen_nom'];
			
			$lab1	=$dt['tb_venta_lab1'];
			
			$may	=$dt['tb_venta_may'];
		mysql_free_result($dts);

		//documento
			$dts= $oDocumento->mostrarUno($doc_id);
			$dt = mysql_fetch_array($dts);
		$documento=$dt['tb_documento_abr'];
			mysql_free_result($dts);

		$modo_pago="EFECTIVO";

		if($punven_id>0)
		{
			$dts=$oPuntoventa->mostrarUno($punven_id);
			$dt = mysql_fetch_array($dts);
				$caj_id		=$dt['tb_caja_id'];
			mysql_free_result($dts);
		}

		//INGRESO CAJA
		$xac=1;
		$ing_det="VENTA $documento $numdoc | PAGO: $modo_pago";
		$ing_est='1';
		$ing_cue_id=22;
		if($_SESSION['empresa_id']==1)$ing_subcue_id=157;
		//$ing_subcue_id=0;
		//$caj_id=1;
		$mon_id=1;
		$tra_id=0;

		$oIngreso->insertar(
			$_SESSION['usuario_id'],
			$_SESSION['usuario_id'],
			$xac,
			fecha_mysql($_POST['txt_clicue_fec']),
			$doc_id,
			$numdoc,
			$ing_det,
			moneda_mysql($_POST['txt_clicue_mon']),
			$ing_est,
			$ing_cue_id,
			$ing_subcue_id,
			$_POST['hdd_cli_id'],
			$caj_id,
			$mon_id,
			$_POST['hdd_clicue_ven_id'],
			$tra_id,
			$_SESSION['empresa_id']
		);	
		
		$data['clicue_id']=$clicue_id;
		if($_POST['chk_imprimir']==1)$data['clicue_act']='imprime';
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
		//$oClientecuenta->modificar($_POST['hdd_clicue_id'], $_POST['txt_clicue_glo'], $_POST['cbo_clicue_tip'], moneda_mysql($_POST['txt_clicue_mon']), $_POST['cbo_clicue_est'], $_POST['hdd_ven_id'], $_POST['hdd_cli_id']);
		
		//$data['clicue_msj']='Se registró Cuenta Cliente correctamente.';
		$data['clicue_msj']='Error.';
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
		/*$oClientecuenta->modificar(
			$_POST['hdd_clicue_id'],
			$_POST['txt_clicue_glo'],
			$_POST['hdd_clicue_tip'],
			moneda_mysql($_POST['txt_clicue_mon']),
			$_POST['hdd_clicue_est']
		);
		
		$data['clicue_msj']='Se registró Pago correctamente.';*/
		$data['clicue_msj']='No es posible, consultar.';
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