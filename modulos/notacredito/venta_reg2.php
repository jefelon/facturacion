<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once("cNotacredito.php");
$oNotacredito = new cNotacredito();
require_once ("../talonarionc/cTalonario.php");
$oTalonario= new cTalonario();
require_once("../venta/cVenta.php");
$oVenta = new cVenta();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../producto/cStock.php");
$oStock = new cStock();


require_once("../formatos/formato.php");

if($_POST['action_venta']=="insertar")
{
	if(!empty($_POST['txt_ven_fec']))
	{
		$tipo_documento=substr($_POST['txt_ven_ser'], 0, 1);
		if($tipo_documento=='F' OR $tipo_documento=='B')
		{

			$serie= $_POST['txt_ven_ser'];
			$correlativo= $_POST['txt_ven_num'];

			$dts= $oNotacredito->verificar_venta($serie,$correlativo);
			$dt = mysql_fetch_array($dts);
				$ven_id	=$dt['tb_venta_id'];
			mysql_free_result($dts);


			if($ven_id>0)
			{

				//venta
				$dts= $oVenta->mostrarUno($ven_id);
				$dt = mysql_fetch_array($dts);
					$reg	=mostrarFechaHora($dt['tb_venta_reg']);
					
					$fec	=mostrarFecha($dt['tb_venta_fec']);
					
					//$doc_id	=$dt['tb_documento_id'];
					$ven_tipdoc =$dt["cs_tipodocumento_cod"];
					$ven_numdoc	=$dt['tb_venta_numdoc'];
					$ven_ser	=$dt['tb_venta_ser'];
					$ven_num	=$dt['tb_venta_num'];
					$cli_id	=$dt['tb_cliente_id'];
					
					$valven	=$dt['tb_venta_valven'];
					$subtot	=$dt['tb_venta_subtot'];
					$des	=$dt['tb_venta_des'];
					$igv	=$dt['tb_venta_igv'];
					$tot	=$dt['tb_venta_tot'];
					$gra	=$dt['tb_venta_gra'];

					$grat	=$dt['tb_venta_grat'];
					$otrtri	=$dt['tb_venta_otrtri'];
					$otrcar	=$dt['tb_venta_otrcar'];

					$est	=$dt['tb_venta_est'];
					
					$punven_id	=$dt['tb_puntoventa_id'];
					$alm_id	=$dt['tb_almacen_id'];
					
				mysql_free_result($dts);


				if($tipo_documento=='F')$documento_id=11;//factura
				if($tipo_documento=='B')$documento_id=12;//boleta

				//consultamos talonario
				$dts= $oTalonario->correlativo($punven_id,$documento_id);
				$dt = mysql_fetch_array($dts);
					$tal_id=$dt['tb_talonario_id'];
					$tal_ser=$dt['tb_talonario_ser'];
					$tal_fin=$dt['tb_talonario_fin'];
					$tal_num=$dt['tb_talonario_num'];
				mysql_free_result($dts);
			
				$numero=$tal_num+1;
				$largo=strlen($tal_fin);
				$numero=str_pad($numero,$largo, "0", STR_PAD_LEFT);
				$numdoc=$tal_ser.'-'.$numero;
				
				//actualizamos talonario
				$estado='ACTIVO';
				if($numero==$tal_fin)$estado='INACTIVO';
				$rs= $oTalonario->actualizar_correlativo($tal_id,$numero,$estado);


				$est="CANCELADA";
				$mot="ANULACIÓN DE LA OPERACIÓN";
				$documento_tipdoc=3;//notacredito

				//insertamos venta
				$oNotacredito->insertar( 
					fecha_mysql($_POST['txt_ven_fec']),
					$_POST['cmb_ven_doc'],
					$numdoc,
					$tal_ser,
					$numero,
					$cli_id,
					$valven,
					$igv,
					$des,
					$tot,
					$est,
					$_POST['cmb_ven_tip'],
					$mot,
					$ven_tipdoc,
					$ven_numdoc,
					$_POST['hdd_usu_id'],
					$_POST['hdd_punven_id'],
					$_SESSION['empresa_id'],

					$documento_tipdoc,//cs_tipodocumento_id
					1,//cs_tipomoneda_id
					$gra,//tb_venta_gra
					0,//tb_venta_ina
					0,//tb_venta_exo
					$grat,//tb_venta_grat
					0,//tb_venta_isc
					$otrtri,
					$otrcar,
					0,//tb_venta_desglo
					1,//cs_tipooperacion_id
					0//cs_documentosrelacionados_id
				);
				
				//ultimo
					$dts=$oNotacredito->ultimoInsert();
					$dt = mysql_fetch_array($dts);
				$notcre_id=$dt['last_insert_id()'];
					mysql_free_result($dts);
				
				
				//registro de kardex
				$xac=1;
				$tipo_registro=1;//1 automatico 2 manual
				$kar_tip=1;//1 entrada 2 salida
				$tipope_id=11;//3 venta
				$kar_des='NOTA DE CREDITO';
				$operacion_id=$notcre_id;//id de la operacion(modulo compras, ventas, etc)
				//$emp_id=$_SESSION['empresa_id'];
				
				//insertamos kardex
				$oKardex->insertar(
					$xac,
					$tipo_registro,
					$codigo,
					fecha_mysql($_POST['txt_ven_fec']),
					$kar_tip,
					$_POST['cmb_ven_doc'],
					$numdoc,
					$tipope_id,
					$kar_des,
					$operacion_id,
					$alm_id,
					$_POST['hdd_usu_id'],
					$_SESSION['empresa_id']
				);
				//ultimo kardex
					$dts=$oKardex->ultimoInsert();
					$dt = mysql_fetch_array($dts);
				$kar_id=$dt['last_insert_id()'];
					mysql_free_result($dts);

				$oKardex->modificar_codigo($kar_id,$kar_id);
				

				//DETALLE DE NOTA CREDITO

				$dts1=$oVenta->mostrar_venta_detalle($ven_id);
				$num_rows= mysql_num_rows($dts1);
				while($dt1 = mysql_fetch_array($dts1))
				{
					$oNotacredito->insertar_detalle(
						$dt1['tb_ventadetalle_tipven'],
						$dt1['tb_catalogo_id'],
						$dt1['tb_servicio_id'],
						$dt1['tb_ventadetalle_nom'],
						$dt1['tb_ventadetalle_preuni'],
						$dt1['tb_ventadetalle_can'],
						$dt1['tb_ventadetalle_tipdes'],
						$dt1['tb_ventadetalle_des'],
						$dt1['tb_ventadetalle_preunilin'],
						$dt1['tb_ventadetalle_valven'],
						$dt1['tb_ventadetalle_igv'],
						$notcre_id,
						$dt1['cs_tipoafectacionigv_id'],
						$dt1['cs_tipounidadmedida_id'],
						$dt1['cs_tiposistemacalculoisc_id'],
						$dt1['tb_ventadetalle_isc'],
						$dt1['tb_ventadetalle_nro']
					);

					//datos presentacion catalogo
					$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($dt1['tb_catalogo_id'],$alm_id);
					$dt = mysql_fetch_array($dts);
						$pre_id=	$dt['tb_presentacion_id'];
						$sto_id=	$dt['tb_stock_id'];
						$sto_num	=$dt['tb_stock_num'];
						$mul		=$dt['tb_catalogo_mul'];
					mysql_free_result($dts);
					
					//conversion a la minima unidad
					$cantidad_venta=$dt1['tb_ventadetalle_can']*$mul;
					
					//actualizacion de stock
					$stock_nuevo=$sto_num+$cantidad_venta;
					$dts=$oStock->modificar($sto_id,$stock_nuevo);
					

					//unidad base
					$dts=$oKardex->presentacion_buscar_unidad_base($dt1['tb_presentacion_id']);
					$dt = mysql_fetch_array($dts);
						$cat_id		=$dt['tb_catalogo_id'];
					mysql_free_result($dts);

					//registro detalle de kardex
					$costo=0;
					$precio=moneda_mysql(($dt1['tb_ventadetalle_valven']+$dt1['tb_ventadetalle_igv'])/$dt1['tb_ventadetalle_can']);
					
					$oKardex->insertar_detalle(
						$cat_id,
						$cantidad_venta,
						$costo,
						$precio,
						$kar_id
					);
				}
                mysql_free_result($dts1);

				$dts2=$oVenta->mostrar_venta_detalle_servicio($ven_id);
				$num_rows_2= mysql_num_rows($dts2);
				while($dt2 = mysql_fetch_array($dts2))
				{
					$oNotacredito->insertar_detalle(
						$dt2['tb_ventadetalle_tipven'],
						$dt2['tb_catalogo_id'],
						$dt2['tb_servicio_id'],
						$dt2['tb_ventadetalle_nom'],
						$dt2['tb_ventadetalle_preuni'],
						$dt2['tb_ventadetalle_can'],
						$dt2['tb_ventadetalle_tipdes'],
						$dt2['tb_ventadetalle_des'],
						$dt2['tb_ventadetalle_preunilin'],
						$dt2['tb_ventadetalle_valven'],
						$dt2['tb_ventadetalle_igv'],
						$notcre_id,
						$dt2['cs_tipoafectacionigv_id'],
						$dt2['cs_tipounidadmedida_id'],
						$dt2['cs_tiposistemacalculoisc_id'],
						$dt2['tb_ventadetalle_isc'],
						$dt2['tb_ventadetalle_nro']
					);
				}
                mysql_free_result($dts2);

		
				 
				
				$data['ven_id']=$notcre_id;
				if($_POST['chk_imprimir']==1)$data['ven_act']='imprime';

				$data['ven_sun']='enviar';

				$data['ven_msj']='Se registró Nota de Crédito correctamente.'.$numdoc;
			}
			else
			{
				$data['ven_msj']='No existe venta con éste número de documento: '.$_POST['txt_ven_ser'].' - '.$_POST['txt_ven_num'].'.';
			}
		}
		else
		{
			$data['ven_msj']='Serie no válida.';
		}
	}
	else
	{
		$data['ven_msj']='Intentelo nuevamente.';
	}
	echo json_encode($data);
}

?>
