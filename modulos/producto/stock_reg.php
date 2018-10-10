<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../producto/cStock.php");
$oStock = new cStock();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();

require_once ("../formatos/formato.php");
require_once ("../catalogo/cst_producto.php");

if($_POST['action_stock']=="insertar"){
	if(!empty($_POST['hdd_pre_id']))
	{
		$dts1=$oStock->stock_por_presentacion($_POST['hdd_pre_id'],$_POST["hdd_alm_id"]);
		$num=mysql_num_rows($dts1);
		
		if($num==0)
		{		
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
		
			$codigo="$cod_almacen-$correlativo";
			
			//Registro del Stock Inicial en las Notas de Almacen
		    //1. Registro de Nota de Almacen                
			$fec=date('Y-m-d');
			$tipo=1;
			$doc_id=5;
			$tipope_id=1;//saldo inicial
			$des="STOCK INICIAL";
			//insertamos nota almacen
			$oNotalmacen->insertar(
				$fec,
				$tipo,
				$doc_id,
				$numdoc,
				$tipope_id,
				$des,
				$_POST['alm_id'],
				$_SESSION['usuario_id'],
				$_SESSION['empresa_id']
			);
		   
		   //2. ultimo nota de almacen
		   $rs_na =$oNotalmacen->ultimoInsert();
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
		   $oNotalmacen->insertar_detalle(
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
		//$dts1=$oStock->stock_por_presentacion($_POST['pre_id'],$_POST["alm_id"]);
		//$num=mysql_num_rows($dts1);
		
		$rs = $oCatalogoproducto->presentacion_unidad_base($_POST['pre_id']);
	    $dt = mysql_fetch_array($rs);
	    $cat_id = $dt['tb_catalogo_id'];
	    mysql_free_result($rs);

		$dts= $oNotalmacen->consultar_existencia_saldo_inicial($cat_id, $_POST['alm_id']);
		$dt = mysql_fetch_array($dts);
		$notalm_id=$dt['tb_notalmacen_id'];
		$notalmdet_id=$dt['tb_notalmacendetalle_id'];
		mysql_free_result($dts);
		
		if($notalm_id>0)
		{	
			echo "Ya existe Dato.";
		}
		else
		{
			$oStock->insertar(
				$_POST["alm_id"],
				$_POST['pre_id'],
				$_POST["sto_num"]
			);
			
			//Nota de Almacen
			$doc_id=3;//nota de almacen
			
			$dts= $oTalonariointerno->correlativo_tra($_POST['alm_id'],$doc_id);
			$dt = mysql_fetch_array($dts);
			
			$tal_id=$dt['tb_talonario_id'];
			$tal_ser=$dt['tb_talonario_ser'];
			$tal_num=$dt['tb_talonario_num'];
			$tal_fin=$dt['tb_talonario_fin'];
				mysql_free_result($dts);
			$numero=$tal_num+1;
			$largo=strlen($tal_fin);
			$correlativo=str_pad($numero,$largo, "0", STR_PAD_LEFT);
			$serie=$tal_ser;
			
			if($tal_ser!="")$numdoc=$serie.'-'.$correlativo;
			
			//Registro del Stock Inicial en las Notas de Almacen
		    //1. Registro de Nota de Almacen                
			$fec=date('Y-m-d');
			$tipo=1;
			$doc_id=5;
			$tipope_id=1;//saldo inicial
			$des="STOCK INICIAL";
			//insertamos nota almacen
			$oNotalmacen->insertar(
				$fec,
				$tipo,
				$doc_id,
				$numdoc,
				$tipope_id,
				$des,
				$_POST['alm_id'],
				$_SESSION['usuario_id'],
				$_SESSION['empresa_id']
			);
		   
		    //2. ultimo nota de almacen
		    $rs_na =$oNotalmacen->ultimoInsert();
		    $dt_na = mysql_fetch_array($rs_na);
		    $notalm_id=$dt_na['last_insert_id()'];
		    mysql_free_result($rs_na);
		    //Fin Nota de Almacen
		   
		    //actualizamos talonario de nota de almacen
			$estado='ACTIVO';
			if($tal_numero==$tal_fin)$tal_estado='INACTIVO';
			$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$numero,$estado);            
		   
		    //3. Consultar catalogo_Id
		    $rs = $oCatalogoproducto->presentacion_unidad_base($_POST['pre_id']);
		    $dt = mysql_fetch_array($rs);
		    $cat_id = $dt['tb_catalogo_id'];
		    $precos = $dt['tb_catalogo_precos'];
            $preuni = $dt['tb_catalogo_preunicom'];
		    mysql_free_result($rs);
		   
		    //4. registro detalle de notalmacen
		    $oNotalmacen->insertar_detalle(
						   $cat_id,
						   $_POST["sto_num"],
                           $precos,
                            $preuni,
						   $notalm_id                                
		   );
   		   //Fin Registro del Stock Inicial en las Notas de Almacen

   		   //KARDEX
			//registro de kardex
			$xac=1;
			$tipo_registro=1;//1 automatico 2 manual
			$kar_tip=$tipo;//1 entrada 2 salida
			$tipope_id=9;//9 nota de almacen
			$kar_des='NOTA DE ALMACEN - STOCK INICIAL';
			$operacion_id=$notalm_id;//id de la operacion(modulo compras, ventas, etc)
			$emp_id=$_SESSION['empresa_id'];



			//insertamos kardex
			$oKardex->insertar(
				$xac,
				$tipo_registro,
				$cod,
                $fec,
				$kar_tip,
				$doc_id,
				$numdoc,
				$tipope_id,
				$kar_des,
				$operacion_id,
				$_POST['alm_id'],
				$_SESSION['usuario_id'],
				$_SESSION['empresa_id']
			);
			//ultimo kardex
				$dts=$oKardex->ultimoInsert();
				$dt = mysql_fetch_array($dts);
			$kar_id=$dt['last_insert_id()'];
				mysql_free_result($dts);

			$oKardex->modificar_codigo($kar_id,$kar_id);

			//registro detalle de kardex
			$oKardex->insertar_detalle(
				$cat_id,
				$_POST["sto_num"],
                $precos,
                $preuni,
				$kar_id
			);

			//actualizar stock si es necesario con el kardex
			$fecini='01-01-2015';
			$fecfin=date('d-m-Y');
			$stock=stock_kardex($cat_id,$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);

			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id,$_POST['alm_id']);
			$dt = mysql_fetch_array($dts);
				$pre_id		=$dt['tb_presentacion_id'];
				$sto_id		=$dt['tb_stock_id'];
				$sto_num	=$dt['tb_stock_num'];
				$mul		=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);

			$oStock->modificar(
				$sto_id,
				$stock
			);

			echo 'Ok';
		}

		
	}

	if($_POST['tipo']=='editar')
	{

		$rs = $oCatalogoproducto->presentacion_unidad_base($_POST['pre_id']);
	    $dt = mysql_fetch_array($rs);
	    $cat_id = $dt['tb_catalogo_id'];
	    mysql_free_result($rs);
		   

		$dts= $oNotalmacen->consultar_existencia_saldo_inicial($cat_id, $_POST['alm_id']);
		$dt = mysql_fetch_array($dts);
		$notalm_id=$dt['tb_notalmacen_id'];
		$notalmdet_id=$dt['tb_notalmacendetalle_id'];
		mysql_free_result($dts);
		
		if($notalm_id>0)
		{
		
			$oNotalmacen->actualizar_salini($notalmdet_id, $_POST["sto_num"]);
		
			$tipoperacion_id=9;
			$dts= $oKardex->consulta_por_operacion_si($tipoperacion_id,$notalm_id);
			$dt = mysql_fetch_array($dts);
			$kardet_id=$dt['tb_kardexdetalle_id'];
			mysql_free_result($dts);

			$oKardex->actualizar_salini($kardet_id, $_POST["sto_num"]);

			$fecini='01-01-2015';
			$fecfin=date('d-m-Y');
			$stock=stock_kardex($cat_id,$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);

			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id,$_POST['alm_id']);
			$dt = mysql_fetch_array($dts);
				$pre_id		=$dt['tb_presentacion_id'];
				$sto_id		=$dt['tb_stock_id'];
				$sto_num	=$dt['tb_stock_num'];
				$mul		=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);

			$oStock->modificar(
				$sto_id,
				$stock
			);

			echo 'Registro OK! Stock Actual Nuevo: '.$stock;
		}
		else
		{
			echo "No hay Stock Inicial";
		}

	}
}

?>