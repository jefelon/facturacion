<?php
/*session_start();
	require_once ("../../config/Cado.php");	
	require_once ("../compra/cCompra.php");	
	$oCompra = new cCompra();
	require_once ("../formatos/formato.php");	
	require_once ("../notalmacen/cNotalmacen.php");
	$oNotalmacen = new cNotalmacen();
	require_once ("../talonario/cTalonariointerno.php");
	$oTalonariointerno= new cTalonariointerno();
	
	
	$dts = $oCompra->mostrar_todos();
	$i=1;
	while($dt = mysql_fetch_array($dts)){
		echo $i++.' | ';
		echo $com_id = $dt['tb_compra_id'];
		$com_fec = $dt['tb_compra_fec'];
		//$com_tipcam = $dt['tb_compra_tipcam'];
		$doc_id = $dt['tb_documento_id'];
		$doc_num = $dt['tb_compra_numdoc'];
		$alm_id = $dt['tb_almacen_id'];
		echo '-</br>';
		
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
		
				
		$oNotalmacen->insertar(1,$codigo, $com_fec, 1, $doc_id, $doc_num, 2, 'COMPRA', $com_id, $alm_id, 2, $_SESSION['empresa_id']);
			
		//ultimo nota de almacen
		$rs_c =$oNotalmacen->ultimoInsert();
		$dt_c = mysql_fetch_array($rs_c);
		$notalm_id=$dt_c['last_insert_id()'];
		mysql_free_result($rs_c);
		//Fin Nota de Almacen
		
		//actualizamos talonario de nota de almacen
		$tal_estado='ACTIVO';
		if($tal_numero==$tal_fin)$tal_estado='INACTIVO';
		$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$tal_numero,$tal_estado); 
		
		//registro detalle de notalmacen
		
		$rs_2 = $oCompra->mostrar_compra_detalle($com_id);
		while($dt_2 = mysql_fetch_array($rs_2)){
			echo $cat_id = $dt_2['tb_catalogo_id'];
			echo ' | ';
			echo $can = $dt_2['tb_compradetalle_can'];
			$cos = $dt_2['tb_compradetalle_cosuni'];
			
			echo "</br>";
			$oNotalmacen->insertar_detalle(
				$cat_id,
				$can,
				$cos,
				0,
				$notalm_id				
			);
		}		
		//Fin Registro del Stock Inicial en las Notas de Almacen		
		echo "</br>";
	}
	mysql_free_result($dts);
*/?>