<?php
require_once ("../../config/Cado.php");
require_once("cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
	
//$emp_id=$_SESSION['empresa_id'];
//$cli_id = $_POST['cli_id'];
if($_POST['action']=='insertar_pago'){
	$dts=$oClientecuenta->mostrarUno($_POST['clicue_id']);
	$dt = mysql_fetch_array($dts);
		$clicue_fec	=$dt['tb_clientecuenta_fec'];
		$clicue_glo	=$dt['tb_clientecuenta_glo'];
		$clicue_tip	=$dt['tb_clientecuenta_tip'];//Tipo
		$clicue_mon	=$dt['tb_clientecuenta_mon'];//Monto
		$clicue_est	=$dt['tb_clientecuenta_est'];//Estado
		$ven_id		=$dt['tb_venta_id'];
		
		$forpag_id	=$dt['tb_formapago_id'];
		$modpag_id	=$dt['tb_modopago_id'];
		
		$cuecor_id	=$dt['tb_cuentacorriente_id'];
		$tar_id		=$dt['tb_tarjeta_id'];
		
		$numope		=$dt['tb_clientecuenta_numope'];
		$numdia		=$dt['clientecuenta_numdia'];
		//$fecven		=mostrarFecha($dt['tb_clientecuenta_fecven']);		
		
		$cli_id		=$dt['tb_cliente_id'];
		$cli_nom		=$dt['tb_cliente_nom'];
		$cli_doc		=$dt['tb_cliente_doc'];
		
		$clicue_ver	=$dt['tb_clientecuenta_ver'];
		
	mysql_free_result($dts);

//id padre
	$clicue_idp=$_POST['clicue_id'];

	//datos de venta
/*	$dts= $oVenta->mostrarUno($ven_id);
	$dt = mysql_fetch_array($dts);
		$ven_fec	=mostrarFecha($dt['tb_venta_fec']);
		
		$doc_id	=$dt['tb_documento_id'];
		$numdoc	=$dt['tb_venta_numdoc'];
		//$cli_id	=$dt['tb_cliente_id'];
		//$cli_nom = $dt['tb_cliente_nom'];
		//$cli_doc = $dt['tb_cliente_doc'];
		//$cli_dir = $dt['tb_cliente_dir'];
		//$subtot	=$dt['tb_venta_subtot'];
		//$igv	=$dt['tb_venta_igv'];
		$ven_tot	=$dt['tb_venta_tot'];
		//$est	=$dt['tb_venta_est'];
		
		//$lab1	=$dt['tb_venta_lab1'];
	mysql_free_result($dts);*/

	
	//pagos realizados
	$tipo=2;
	$tipo_registro=2;
	$dts=$oClientecuenta->mostrar_por_cuenta($clicue_idp,$tipo,$tipo_registro);
	while($dt = mysql_fetch_array($dts)){
		$total_pagado+=$dt['tb_clientecuenta_mon'];
	}
	mysql_free_result($dts);
	
	//saldo a pagar
	$saldo_pagar=$clicue_mon-$total_pagado;

	if($saldo_pagar>0)
	{	
		//pago parcial
		$oClientecuenta->actualizar_estado_entradas($_POST['clicue_id'], 3);
	}
	
	if($saldo_pagar==0)
	{
		//cancelado
		$oClientecuenta->actualizar_estado_entradas($_POST['clicue_id'], 1);
	}
}

if($_POST['action']=='editar_pago'){
	//INFORMACION DE PAGO
	$dts=$oClientecuenta->mostrarUno($_POST['clicue_id']);
	$dt = mysql_fetch_array($dts);
		//$clicue_fec	=mostrarFecha($dt['tb_clientecuenta_fec']);
		//$clicue_glo	=$dt['tb_clientecuenta_glo'];
		//$clicue_tip	=$dt['tb_clientecuenta_tip'];//Tipo
		$clicue_mon	=$dt['tb_clientecuenta_mon'];//Monto
		$clicue_est	=$dt['tb_clientecuenta_est'];//Estado
		$ven_id		=$dt['tb_venta_id'];
		
		//$forpag_id	=$dt['tb_formapago_id'];
//		$modpag_id	=$dt['tb_modopago_id'];
//		
//		$cuecor_id	=$dt['tb_cuentacorriente_id'];
//		$cuecor_nom	=$dt['tb_cuentacorriente_nom'];
//		
//		$tar_id		=$dt['tb_tarjeta_id'];
//		$tar_nom		=$dt['tb_tarjeta_nom'];
//		
//		$numope		=$dt['tb_clientecuenta_numope'];
//		$numdia		=$dt['clientecuenta_numdia'];
//		$fecven		=$dt['tb_clientecuenta_fecven'];		
//		
//		$cli_id		=$dt['tb_cliente_id'];
//		$cli_nom		=$dt['tb_cliente_nom'];
//		$cli_doc		=$dt['tb_cliente_doc'];
//		
//		$clicue_ver	=$dt['tb_clientecuenta_ver'];
//		$clicue_idp	=$dt['tb_clientecuenta_idp'];		
	mysql_free_result($dts);
	
	//INFORMACION DE CUENTA
	$dts=$oClientecuenta->mostrarUno($clicue_idp);
	$dt = mysql_fetch_array($dts);
		//$clicue_fec	=mostrarFecha($dt['tb_clientecuenta_fec']);
		$cuenta_clicue_glo	=$dt['tb_clientecuenta_glo'];
//		$clicue_tip	=$dt['tb_clientecuenta_tip'];//Tipo
		$cuenta_clicue_mon	=$dt['tb_clientecuenta_mon'];//Monto
//		$clicue_est	=$dt['tb_clientecuenta_est'];//Estado
//		$ven_id		=$dt['tb_venta_id'];
//		
//		$forpag_id	=$dt['tb_formapago_id'];
//		$modpag_id	=$dt['tb_modopago_id'];
//		
//		$cuecor_id	=$dt['tb_cuentacorriente_id'];
//		$cuecor_nom	=$dt['tb_cuentacorriente_nom'];
//		
//		$tar_id		=$dt['tb_tarjeta_id'];
//		$tar_nom		=$dt['tb_tarjeta_nom'];
//		
//		$numope		=$dt['tb_clientecuenta_numope'];
//		$numdia		=$dt['clientecuenta_numdia'];
//		$fecven		=$dt['tb_clientecuenta_fecven'];		
//		
//		$cli_id		=$dt['tb_cliente_id'];
//		$cli_nom		=$dt['tb_cliente_nom'];
//		$cli_doc		=$dt['tb_cliente_doc'];
//		
//		$clicue_ver	=$dt['tb_clientecuenta_ver'];
		//$v_clicue_idp	=$dt['tb_clientecuenta_idp'];		
	mysql_free_result($dts);
	
		//$monto=$clicue_mon;
		
		//forma pago
		/*$forma='';
		//modo
		if($modpag_id==1)
		{
			$modo='EFECTIVO';
		}
		if($modpag_id==2)
		{
			$modo='DEPOSITO '.$cuecor_nom.' OP: '.$numope;
		}
		if($modpag_id==3)
		{
			$modo='TARJETA '.$tar_nom.' OP: '.$numope;
		}
		
		$texto_pago=$forma.''.$modo;*/
		
		//pagos realizados
	$tipo=2;
	$tipo_registro=2;
	$dts=$oClientecuenta->mostrar_por_cuenta($clicue_idp,$tipo,$tipo_registro);
	while($dt = mysql_fetch_array($dts)){
		$total_pagado+=$dt['tb_clientecuenta_mon'];
	}
	mysql_free_result($dts);
	
	//saldo a pagar
	$saldo_pagar=$cuenta_clicue_mon-$total_pagado;
		
	if($saldo_pagar>0)
	{	
		//pago parcial
		$oClientecuenta->actualizar_estado_entradas($clicue_idp, 3);
	}
	
	if($saldo_pagar==0)
	{
		//cancelado
		$oClientecuenta->actualizar_estado_entradas($clicue_idp, 1);
	}
}
?>