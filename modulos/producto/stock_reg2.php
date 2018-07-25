<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cStock.php");
$oStock = new cStock();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../notalmacen/cNotalmacen.php");
$oNotaAlmacen = new cNotalmacen();
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();

if($_POST['action_stock']=="insertar"){
	if(!empty($_POST['hdd_pre_id']))
	{
		$dts1=$oStock->stock_por_presentacion($_POST['hdd_pre_id'],$_POST["hdd_alm_id"]);
		$num=mysql_num_rows($dts1);
		
		if($num==0){		
			$oStock->insertar(
				$_POST["hdd_alm_id"],
				$_POST['hdd_pre_id'],
				$_POST["txt_sto_num"]
			);
			
			//Nota de Almacen
	
			$docc_id=3;//nota de almacen
			
			$rws= $oTalonariointerno->correlativo_tra($_POST["hdd_alm_id"],$docc_id);
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
			
			$cod_almacen=str_pad($_POST["hdd_alm_id"],2, "0", STR_PAD_LEFT);
		
			$codigo="$cod_almacen-$y-$correlativo";
			
			//Registro del Stock Inicial en las Notas de Almacen
		   //1. Registro de Nota de Almacen                
			$fec=date('Y-m-d');//Fecha
		   $oNotaAlmacen->insertar(1, $codigo, $fec,1,5,'', 1, 'SALDO INICIAL', '0', $_POST["hdd_alm_id"],'2', $_SESSION['empresa_id']);
		   
		   //2. ultimo nota de almacen
		   $rs_na =$oNotaAlmacen->ultimoInsert();
		   $dt_na = mysql_fetch_array($rs_na);
		   $notalm_id=$dt_na['last_insert_id()'];
		   mysql_free_result($rs_na);
		   //Fin Nota de Almacen
		   
		   //actualizamos talonario de nota de almacen
			$tal_estado='ACTIVO';
			if($tal_numero==$tal_fin)$tal_estado='INACTIVO';
			$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$tal_numero,$tal_estado);            
		   
		   //3. Consultar catalogo_Id
		   $rs = $oCatalogoproducto->presentacion_unidad_base($_POST['hdd_pre_id']);
		   $dt = mysql_fetch_array($rs);
		   $cat_id = $dt['tb_catalogo_id'];
		   mysql_free_result($rs);
		   
		   //4. registro detalle de notalmacen
		   $oNotaAlmacen->insertar_detalle(
						   $cat_id,
						   $_POST["txt_sto_num"],
						   0,
						   0,
						   $notalm_id                                
		   );
   		   //Fin Registro del Stock Inicial en las Notas de Almacen
			
		}
		echo 'Se actualizó stock correctamente.';
	}
	else{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_stock']=="editar")
{
	if(!empty($_POST['hdd_pre_id']))
	{
		$oStock->modificar(
			$_POST["hdd_sto_id"],
			$_POST["txt_sto_num"]
		);

		echo 'Se actualizó stock correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="actualizar_stock")
{
	if($_POST['tipo']=='insertar')
	{
		$dts1=$oStock->stock_por_presentacion($_POST['pre_id'],$_POST["alm_id"]);
		$num=mysql_num_rows($dts1);
		
		if($num==0){
			$oStock->insertar(
				$_POST["alm_id"],
				$_POST['pre_id'],
				$_POST["sto_num"]
			);
			
			//Nota de Almacen
	
			$docc_id=3;//nota de almacen
			
			$rws= $oTalonariointerno->correlativo_tra($_POST["alm_id"],$docc_id);
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
			
			$cod_almacen=str_pad($_POST["alm_id"],2, "0", STR_PAD_LEFT);
		
			$codigo="$cod_almacen-$y-$correlativo";
			
			//Registro del Stock Inicial en las Notas de Almacen
		   //1. Registro de Nota de Almacen                
			$fec=date('Y-m-d');//Fecha
		   $oNotaAlmacen->insertar(1, $codigo, $fec,1,5,'', 1, 'SALDO INICIAL', '0', $_POST["alm_id"],'2', $_SESSION['empresa_id']);
		   
		   //2. ultimo nota de almacen
		   $rs_na =$oNotaAlmacen->ultimoInsert();
		   $dt_na = mysql_fetch_array($rs_na);
		   $notalm_id=$dt_na['last_insert_id()'];
		   mysql_free_result($rs_na);
		   //Fin Nota de Almacen
		   
		   //actualizamos talonario de nota de almacen
			$tal_estado='ACTIVO';
			if($tal_numero==$tal_fin)$tal_estado='INACTIVO';
			$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$tal_numero,$tal_estado);            
		   
		   //3. Consultar catalogo_Id
		   $rs = $oCatalogoproducto->presentacion_unidad_base($_POST['pre_id']);
		   $dt = mysql_fetch_array($rs);
		   $cat_id = $dt['tb_catalogo_id'];
		   mysql_free_result($rs);
		   
		   //4. registro detalle de notalmacen
		   $oNotaAlmacen->insertar_detalle(
						   $cat_id,
						   $_POST["sto_num"],
						   0,
						   0,
						   $notalm_id                                
		   );
   		   //Fin Registro del Stock Inicial en las Notas de Almacen
		}
		echo 'Ok';
	}
	else
	{
		echo 'Error';
	}
}

?>