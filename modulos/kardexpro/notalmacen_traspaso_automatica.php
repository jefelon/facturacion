<?php
	/*session_start();
	require_once ("../../config/Cado.php");
	require_once ("../traspaso/cTraspaso.php");		
	$oTraspaso = new cTraspaso();
	
	require_once ("../formatos/formato.php");	
	require_once ("../notalmacen/cNotalmacen.php");
	$oNotalmacen = new cNotalmacen();
	require_once ("../talonario/cTalonariointerno.php");
	$oTalonariointerno= new cTalonariointerno();
	
	$alm_id = 4;	
	
	//Traspaso Entrada
	$dts = $oTraspaso->mostrar_todos_por_empresa_almacen_destino($_SESSION['empresa_id'], $alm_id);	
	
	while($dt = mysql_fetch_array($dts)){			
		echo $tra_id = $dt['tb_traspaso_id'];
		echo '</br>';
		$tra_fec = $dt['tb_traspaso_fec'];
		//$doc_id = $dt['tb_documento_id'];
		$doc_num = $dt['tb_traspaso_cod'];
		
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
					
		$oNotalmacen->insertar(1, $codigo, $tra_fec, 1, 6, $doc_num, 4, 'TRANSFERENCIA ENTRADA', $tra_id, $alm_id, 2, $_SESSION['empresa_id']);		
		
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
		$rs_2 = $oTraspaso->mostrar_traspaso_detalle($tra_id);
		while($dt_2 = mysql_fetch_array($rs_2)){
			echo $cat_id = $dt_2['tb_catalogo_id'];
			echo ' | ';
			echo $can = $dt_2['tb_traspasodetalle_can'];
			echo '</br>';					
			$oNotalmacen->insertar_detalle(
				$cat_id,
				$can,
				0,
				0,
				$notalm_id				
			);
		}				
		//Fin Registro del Stock Inicial en las Notas de Almacen
		echo '</br>';	
	}
	mysql_free_result($dts);
	
	echo 'SALIDA</br>';
	//Traspaso Salida
	$dts1 = $oTraspaso->mostrar_todos_por_empresa_almacen_origen($_SESSION['empresa_id'], $alm_id);	
	
	while($dt = mysql_fetch_array($dts1)){			
		echo $tra_id = $dt['tb_traspaso_id'];
		echo '</br>';
		$tra_fec = $dt['tb_traspaso_fec'];
		//$doc_id = $dt['tb_documento_id'];
		$doc_num = $dt['tb_traspaso_cod'];
		
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
				
		$oNotalmacen->insertar(1, $codigo, $tra_fec, 2, 6, $doc_num, 5, 'TRANSFERENCIA SALIDA', $tra_id, $alm_id, 2, $_SESSION['empresa_id']);		
		
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
		$rs_2 = $oTraspaso->mostrar_traspaso_detalle($tra_id);
		while($dt_2 = mysql_fetch_array($rs_2)){
			echo $cat_id = $dt_2['tb_catalogo_id'];
			echo ' | ';
			echo $can = $dt_2['tb_traspasodetalle_can'];
			echo '</br>';					
			$oNotalmacen->insertar_detalle(
				$cat_id,
				$can,
				0,
				0,
				$notalm_id				
			);
		}				
		//Fin Registro del Stock Inicial en las Notas de Almacen
		echo '</br>';	
	}
	mysql_free_result($dts1);
*/?>