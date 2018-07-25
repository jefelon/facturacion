<?php
/*	session_start();
	require_once ("../../config/Cado.php");	
	require_once ("../venta/cVenta.php");		
	require_once ("../formatos/formato.php");	
	require_once ("../notalmacen/cNotalmacen.php");
	$oNotalmacen = new cNotalmacen();
	require_once ("../talonario/cTalonariointerno.php");
	$oTalonariointerno= new cTalonariointerno();
	
	$alm_id = 3;
	$oVenta = new cVenta();
	//$emp_id = $_SESSION['empresa_id'];
	
	$dts = $oVenta->mostrar_todos_por_empresa($_SESSION['empresa_id'], $alm_id);
	
	while($dt = mysql_fetch_array($dts)){		
		echo $ven_id = $dt['tb_venta_id'];
		echo '-</br>';
		$ven_fec = $dt['tb_venta_fec'];
		$doc_id = $dt['tb_documento_id'];
		$doc_num = $dt['tb_venta_numdoc'];
		
		//Nota de Almacen
	
		$docc_id=3;//nota de almacen
		
		$rws= $oTalonariointerno->correlativo_tra($alm_id,$docc_id);
		$rw = mysql_fetch_array($rws);
		
		$tal_id=$rw['tb_talonario_id'];
		$tal_ser=$rw['tb_talonario_ser'];
		$tal_num=$rw['tb_talonario_num'];
		$tal_fin=$rw['tb_talonario_fin'];
			mysql_free_result($rws);
		$tal_numero=$tal_num+1;
		$largo=strlen($tal_fin);
		
		$correlativo=str_pad($tal_numero,$largo, "0", STR_PAD_LEFT);
		
		$y=date('Y');
		
		$cod_almacen=str_pad($alm_id,2, "0", STR_PAD_LEFT);
	
		$codigo="$cod_almacen-$y-$correlativo";
						
		$oNotalmacen->insertar(1, $codigo, $ven_fec, 2, $doc_id, $doc_num, 3, 'VENTA', $ven_id, $alm_id, 2, $_SESSION['empresa_id']);		
		
		//ultimo nota de almacen
		$rs_na =$oNotalmacen->ultimoInsert();
		$dt_na = mysql_fetch_array($rs_na);
		$notalm_id=$dt_na['last_insert_id()'];
		mysql_free_result($rs_na);
		//Fin Nota de Almacen
		
		//actualizamos talonario de nota de almacen
		$tal_estado='ACTIVO';
		if($tal_numero==$tal_fin)$tal_estado='INACTIVO';
		$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$tal_numero,$tal_estado); 
		
		//registro detalle de notalmacen		
		$rs_2 = $oVenta->mostrar_venta_detalle($ven_id);
		while($dt_2 = mysql_fetch_array($rs_2)){
			echo $cat_id = $dt_2['tb_catalogo_id'];
			echo ' | ';
			echo $can = $dt_2['tb_ventadetalle_can'];
			$valven = $dt_2['tb_ventadetalle_valven'];//Valor Venta
			$igv = $dt_2['tb_ventadetalle_igv'];//IGV
			$pre = ($valven + $igv)/$can;
			echo '</br>';
			$oNotalmacen->insertar_detalle(
				$cat_id,
				$can,
				0,
				$pre,
				$notalm_id				
			);
		}				
		//Fin Registro del Stock Inicial en las Notas de Almacen
		echo '</br>';
	}
	mysql_free_result($dts);
*/?>