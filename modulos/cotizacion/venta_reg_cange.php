<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once("../ventacanje/cVentacanje.php");
$oVentacanje = new cVentacanje();
require_once("cCotizacion.php");
$oCotizacion = new cCotizacion();
require_once("cVentapago.php");
$oVentapago = new cVentapago();
require_once("../clientecuenta/cClientecuenta.php");
$oClientecuenta = new cClientecuenta();

require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();

require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();

require_once ("../talonario/cTalonario.php");
$oTalonario= new cTalonario();
require_once("../producto/cStock.php");
$oStock = new cStock();

require_once("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();

require_once ("../ventanota/cVentanota.php");
$oVentanota = new cVentanota();

require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once ("../gasto/cGasto.php");
$oGasto = new cGasto();

require_once("../formatos/formato.php");

$igv_dato=0.18;
$almacen_venta=$_SESSION['almacen_id'];

if($_POST['action_venta']=="insertar")
{
	if(!empty($_POST['txt_ven_fec']))
	{
		
		//ANULAMOS NOTA DE VENTA
		
			$dts= $oVentanota->mostrarUno($_SESSION['vennot_id']);
		$dt = mysql_fetch_array($dts);
			$fec	=mostrarFecha($dt['tb_venta_fec']);
			$doc_id	=$dt['tb_documento_id'];
			$numdoc	=$dt['tb_venta_numdoc'];
			$cli_id	=$dt['tb_cliente_id'];
			$valven	=$dt['tb_venta_valven'];
			$igv	=$dt['tb_venta_igv'];
			$tot	=$dt['tb_venta_tot'];
			$est	=$dt['tb_venta_est'];
			
			$punven_id	=$dt['tb_puntoventa_id'];
			$punven_nom	=$dt['tb_puntoventa_nom'];
			
			$alm_id=$dt['tb_almacen_id'];
		mysql_free_result($dts);
		
	//______validacion de almacenes
	
		if($almacen_venta==$alm_id)
		{
		//________
			if($est!='ANULADA')
			{
				$estado='ANULADA';
				$oVentanota->modificar(
						$_SESSION['vennot_id'],
						fecha_mysql($fec),
						$cli_id,
						$estado
					);
				
				$dts1=$oVentanota->mostrar_venta_detalle($_SESSION['vennot_id']);
				$num_rows= mysql_num_rows($dts1);
				//detalle de productos
					while($dt1 = mysql_fetch_array($dts1))
					{
						$cat_id=$dt1['tb_catalogo_id'];
						$cantidad=$dt1['tb_ventadetalle_can'];			
					
						//datos presentacion catalogo almacen
						$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id,$alm_id);
						$dt = mysql_fetch_array($dts);
							$sto_id_ori		=$dt['tb_stock_id'];
							$sto_num_ori	=$dt['tb_stock_num'];
							$mul_ori		=$dt['tb_catalogo_mul'];
						mysql_free_result($dts);
						
						//conversion a la minima unidad
						$cantidad_ori=$cantidad*$mul_ori;
						
						//actualizacion de stock
						$stock_nuevo_ori=$sto_num_ori+$cantidad_ori;
						$dts=$oStock->modificar($sto_id_ori,$stock_nuevo_ori);
					}
				
				mysql_free_result($dts1);
				
				//elimiar nota de almacen --------------
				$dts= $oNotalmacen->consulta_eliminar(1,2,$doc_id,3,$_SESSION['vennot_id']);
				$dt = mysql_fetch_array($dts);
					$notalm_id	=$dt['tb_notalmacen_id'];
				mysql_free_result($dts);
				
				if($notalm_id>0)
				{
					$oNotalmacen->eliminar_notalmacendetalle($notalm_id);
					$oNotalmacen->eliminar_notalmacen($notalm_id);
					$msj_n='';
				}
				else
				{
					$msj_n=' No se pudo eliminar Nota de Almacen.';
				}
				//----------------------------------------
				//eliminar cuenta cliente --------------
				$ventip=2;//nota venta
				$oClientecuenta->eliminar_por_venta($ventip,$_SESSION['vennot_id']);
				//_________________________________________

				//$error1=0;
				//$data['act']='correcto';
				//$data['msj'].='Se anuló venta correctamente.'.$msj_n;
				//echo json_encode($data);
			
			
			}//estado cancelada
			else
			{
				//$data['msj'].='Venta ya ha sido anulada.';
				//echo json_encode($data);
			}
			
			
			//REGISTRO DE VENTA
			
			//consultamos talonario
				$dts= $oTalonario->correlativo($_SESSION['puntoventa_id'],$_POST['cmb_ven_doc']);
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
			
			//$estado='CANCELADA';
			//insertamos venta
            $oCotizacion->insertar(
				fecha_mysql($_POST['txt_ven_fec']),
				$_POST['cmb_ven_doc'],
				$numdoc,
				$_POST['hdd_ven_cli_id'],
				moneda_mysql($_POST['txt_ven_valven']),
				moneda_mysql($_POST['txt_ven_igv']),
				moneda_mysql($_POST['txt_ven_des']),
				moneda_mysql($_POST['txt_ven_tot']),
				$_POST['cmb_ven_est'],
				$_POST['txt_ven_lab1'],
				$_POST['chk_ven_may'],
				$_POST['hdd_usu_id'],
				$_POST['hdd_punven_id'],
				$_SESSION['empresa_id']
			);
			//ultima venta
				$dts=$oCotizacion->ultimoInsert();
				$dt = mysql_fetch_array($dts);
			$ven_id=$dt['last_insert_id()'];
				mysql_free_result($dts);
			
			//registro de pago
			
			if($_POST['chk_venpag_aut']==1)
			{
				$oVentapago->insertar( 
					$_POST['cmb_forpag_id'],
					$_POST['cmb_modpag_id'],
					fecha_mysql($_POST['txt_ven_fec']),
					moneda_mysql($_POST['txt_venpag_mon']),
					$_POST['cmb_cuecor_id'],
					$_POST['cmb_tar_id'],
					$_POST['txt_venpag_numope'],
					$_POST['txt_venpag_numdia'],
					fecha_mysql($_POST['txt_venpag_fecven']),
					$ven_id,
					$_SESSION['empresa_id']
				);
				
				switch ($_POST['cmb_forpag_id']) {
					case 1:
						$forma_pago='CONTADO';
						break;
					case 2:
						$forma_pago='CREDITO';
						break;
				}
				
				switch ($_POST['cmb_modpag_id']) {
					case 1:
						$modo_pago='EFECTIVO';
						break;
					case 2:
						$modo_pago='DEPOSITO';
						break;
					case 3:
						$modo_pago='TARJETA';
						break;
				}
				
					$dts= $oDocumento->mostrarUno($_POST['cmb_ven_doc']);
					$dt = mysql_fetch_array($dts);
				$documento=$dt['tb_documento_abr'];
					mysql_free_result($dts);
				
				if($_POST['cmb_forpag_id']==1)
				{
					$cuecli_tipreg=1;
					$cuecli_tip=1;
					$cuecli_est=1;
					$verif=1;
					$ventip=1;//venta
					$oClientecuenta->insertar(
						$cuecli_tipreg,
						fecha_mysql($_POST['txt_ven_fec']),
						"VENTA $forma_pago $modo_pago | $documento $numdoc",
						$cuecli_tip,
						moneda_mysql($_POST['txt_venpag_mon']),
						$cuecli_est,
						$ventip,
						$ven_id,
						$_POST['cmb_forpag_id'], 
						$_POST['cmb_modpag_id'],
						$_POST['cmb_cuecor_id'],
						$_POST['cmb_tar_id'],
						$_POST['txt_venpag_numope'],
						$_POST['txt_venpag_numdia'],
						fecha_mysql($_POST['txt_venpag_fecven']),
						$_POST['hdd_ven_cli_id'],
						$verif,
						$clicue_idp,
						$_SESSION['usuario_id'],
						$_SESSION['empresa_id']
					);
					
					//ultimo registro cuantacliente
					$dts=$oClientecuenta->ultimoInsert();
					$dt = mysql_fetch_array($dts);
				$clicue_idp=$dt['last_insert_id()'];
					mysql_free_result($dts);
					
					$cuecli_tipreg=1;
					$cuecli_tip=2;
					$cuecli_est=0;
					$verif=1;
					$ventip=1;//venta
					$oClientecuenta->insertar(
						$cuecli_tipreg,
						fecha_mysql($_POST['txt_ven_fec']),
						"PAGO $forma_pago $modo_pago | $documento $numdoc",
						$cuecli_tip,
						moneda_mysql($_POST['txt_venpag_mon']),
						$cuecli_est,
						$ventip,
						$ven_id,
						$_POST['cmb_forpag_id'], 
						$_POST['cmb_modpag_id'],
						$_POST['cmb_cuecor_id'],
						$_POST['cmb_tar_id'],
						$_POST['txt_venpag_numope'],
						$_POST['txt_venpag_numdia'],
						fecha_mysql($_POST['txt_venpag_fecven']),
						$_POST['hdd_ven_cli_id'],
						$verif,
						$clicue_idp,
						$_SESSION['usuario_id'],
						$_SESSION['empresa_id']
					);			
				}
				
				//CREDITO
				if($_POST['cmb_forpag_id']==2)
				{
					$cuecli_tipreg=1;
					$cuecli_tip=1;
					$cuecli_est=2;
					$verif=2;
					$ventip=1;//venta
					$oClientecuenta->insertar(
						$cuecli_tipreg,
						fecha_mysql($_POST['txt_ven_fec']),
						"VENTA $forma_pago $modo_pago | $documento $numdoc",
						$cuecli_tip,
						moneda_mysql($_POST['txt_venpag_mon']),
						$cuecli_est,
						$ventip,
						$ven_id,
						$_POST['cmb_forpag_id'], 
						$_POST['cmb_modpag_id'],
						$_POST['cmb_cuecor_id'],
						$_POST['cmb_tar_id'],
						$_POST['txt_venpag_numope'],
						$_POST['txt_venpag_numdia'],
						fecha_mysql($_POST['txt_venpag_fecven']),
						$_POST['hdd_ven_cli_id'],
						$verif,
						$clicue_idp,
						$_SESSION['usuario_id'],
						$_SESSION['empresa_id']
					);
		
				}
			}
			else
			{
				if(isset($_SESSION['venpag_mon']))foreach($_SESSION['venpag_mon'] as $indice=>$valor){
					
					$oVentapago->insertar(
						$_SESSION['venpag_for'][$indice],
						$_SESSION['venpag_mod'][$indice],
						fecha_mysql(date('d-m-Y')),
						moneda_mysql($valor),
						$_SESSION['venpag_cuecor'][$indice],
						$_SESSION['venpag_tar'][$indice],
						$_SESSION['venpag_numope'][$indice],
						$_SESSION['venpag_numdia'][$indice],
						fecha_mysql($_SESSION['venpag_fecven'][$indice]),
						$ven_id,
						$_SESSION['empresa_id']
					);
					
					switch ($_SESSION['venpag_for'][$indice]) {
						case 1:
							$forma_pago='CONTADO';
							break;
						case 2:
							$forma_pago='CREDITO';
							break;
					}
					
					switch ($_SESSION['venpag_mod'][$indice]) {
						case 1:
							$modo_pago='EFECTIVO';
							break;
						case 2:
							$modo_pago='DEPOSITO';
							break;
						case 3:
							$modo_pago='TARJETA';
							break;
					}
					
						$dts= $oDocumento->mostrarUno($_POST['cmb_ven_doc']);
						$dt = mysql_fetch_array($dts);
					$documento=$dt['tb_documento_abr'];
						mysql_free_result($dts);
					
					if($_SESSION['venpag_for'][$indice]==1)
					{
						$cuecli_tipreg=1;
						$cuecli_tip=1;
						$cuecli_est=1;
						$verif=1;
						$ventip=1;//venta
						$oClientecuenta->insertar(
							$cuecli_tipreg,
							fecha_mysql($_POST['txt_ven_fec']),
							"VENTA $forma_pago $modo_pago | $documento $numdoc",
							$cuecli_tip,
							moneda_mysql($valor),
							$cuecli_est,
							$ventip,
							$ven_id,
							$_SESSION['venpag_for'][$indice],
							$_SESSION['venpag_mod'][$indice],
							$_SESSION['venpag_cuecor'][$indice],
							$_SESSION['venpag_tar'][$indice],
							$_SESSION['venpag_numope'][$indice],
							$_SESSION['venpag_numdia'][$indice],
							fecha_mysql($_SESSION['venpag_fecven'][$indice]),
							$_POST['hdd_ven_cli_id'],
							$verif,
							$clicue_idp,
							$_SESSION['usuario_id'],
							$_SESSION['empresa_id']
						);
						
						//ultimo registro cuantacliente
							$dts=$oClientecuenta->ultimoInsert();
							$dt = mysql_fetch_array($dts);
						$clicue_idp=$dt['last_insert_id()'];
							mysql_free_result($dts);
						
						$cuecli_tipreg=1;
						$cuecli_tip=2;
						$cuecli_est=0;
						$verif=1;
						$ventip=1;
						$oClientecuenta->insertar(
							$cuecli_tipreg,
							fecha_mysql($_POST['txt_ven_fec']),
							"PAGO $forma_pago $modo_pago | $documento $numdoc",
							$cuecli_tip,
							moneda_mysql($valor),
							$cuecli_est,
							$ventip,
							$ven_id,
							$_SESSION['venpag_for'][$indice],
							$_SESSION['venpag_mod'][$indice],
							$_SESSION['venpag_cuecor'][$indice],
							$_SESSION['venpag_tar'][$indice],
							$_SESSION['venpag_numope'][$indice],
							$_SESSION['venpag_numdia'][$indice],
							fecha_mysql($_SESSION['venpag_fecven'][$indice]),
							$_POST['hdd_ven_cli_id'],
							$verif,
							$clicue_idp,
							$_SESSION['usuario_id'],
							$_SESSION['empresa_id']
						);			
					}
					
					//CREDITO
					if($_SESSION['venpag_for'][$indice]==2)
					{
						$cuecli_tipreg=1;
						$cuecli_tip=1;
						$cuecli_est=2;
						$verif=2;
						$ventip=1;//venta
						$oClientecuenta->insertar(
							$cuecli_tipreg,
							fecha_mysql($_POST['txt_ven_fec']),
							"VENTA $forma_pago $modo_pago | $documento $numdoc",
							$cuecli_tip,
							moneda_mysql($valor),
							$cuecli_est,
							$ventip,
							$ven_id,
							$_SESSION['venpag_for'][$indice],
							$_SESSION['venpag_mod'][$indice],
							$_SESSION['venpag_cuecor'][$indice],
							$_SESSION['venpag_tar'][$indice],
							$_SESSION['venpag_numope'][$indice],
							$_SESSION['venpag_numdia'][$indice],
							fecha_mysql($_SESSION['venpag_fecven'][$indice]),
							$_POST['hdd_ven_cli_id'],
							$verif,
							$clicue_idp,
							$_SESSION['usuario_id'],
							$_SESSION['empresa_id']
						);
			
					}
					
				}
			}
			
			if(isset($_SESSION['venpag_mon'])){
				unset($_SESSION['venpag_mon']);
				unset($_SESSION['venpag_for']);
				unset($_SESSION['venpag_mod']);
				unset($_SESSION['venpag_cuecor']);
				unset($_SESSION['venpag_tar']);
				unset($_SESSION['venpag_numope']);
				unset($_SESSION['venpag_numdia']);
				unset($_SESSION['venpag_fecven']);
			}
			//actualizamos talonario
			$estado='ACTIVO';
			if($numero==$tal_fin)$estado='INACTIVO';
			$rs= $oTalonario->actualizar_correlativo($tal_id,$numero,$estado);
			
			
			//nota de almacen/_____________________________________________________
			$doc_id=3;//nota de almacen
			
			$dts= $oTalonariointerno->correlativo_tra($almacen_venta,$doc_id);
			$dt = mysql_fetch_array($dts);
			
			$tali_id=$dt['tb_talonario_id'];
			$tali_ser=$dt['tb_talonario_ser'];
			$tali_num=$dt['tb_talonario_num'];
			$tali_fin=$dt['tb_talonario_fin'];
				mysql_free_result($dts);
			$tali_numero=$tali_num+1;
			$tali_largo=strlen($tali_fin);
			
			$tali_correlativo=str_pad($tali_numero,$tali_largo, "0", STR_PAD_LEFT);
			
			$y=date('Y');
			
			$cod_almacen=str_pad($almacen_venta,2, "0", STR_PAD_LEFT);
		
			$codigo="$cod_almacen-$y-$tali_correlativo";
			
			//registro de nota
			$tipo_registro=1;//1 automatico 2 manual
			$notalm_tip=2;//1 entrada 2 salida
			$tipope_id=3;//2 compra 3 venta
			$notalm_des='VENTA';
			$operacion_id=$ven_id;//id de la operacion(modulo compras, ventas, etc)
			
			//insertamos nota almacen
			$oNotalmacen->insertar(
				$tipo_registro,
				$codigo,
				fecha_mysql($_POST['txt_ven_fec']),
				$notalm_tip,
				$_POST['cmb_ven_doc'],
				$numdoc,
				$tipope_id,
				$notalm_des,
				$operacion_id,
				$almacen_venta,
				$_POST['hdd_usu_id'],
				$_SESSION['empresa_id']
			);
			//ultima nota de almacen
				$dts=$oNotalmacen->ultimoInsert();
				$dt = mysql_fetch_array($dts);
			$notalm_id=$dt['last_insert_id()'];
				mysql_free_result($dts);
			
			//actualizamos talonario de nota de almacen
			$tali_estado='ACTIVO';
			if($tali_numero==$tali_fin)$tali_estado='INACTIVO';
			$rs= $oTalonariointerno->actualizar_correlativo($tali_id,$tali_numero,$tali_estado);
			
			//___________________________________________________________________
			
			if($_POST['cmb_ven_est']!='ANULADA')
			{
			//detalle de productos
			if(isset($_SESSION['venta_car']))foreach($_SESSION['venta_car'] as $indice=>$cantidad){			
				
				//precio de venta ingresado
				$precio_venta	=$_SESSION['venta_preven'][$indice];
								
				//precio unitario de venta
				$precio_unitario=$precio_venta/(1+$igv_dato);
				
				
				//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
				$tipdes = $_SESSION['venta_tipdes'][$indice];				
				$descuento_linea=$_SESSION['venta_des'][$indice];
				//descuento en porcentaje
				if($tipdes == 1){
					$descuento_calculo = ($descuento_linea/100)*$precio_unitario;
				}
				//descuento en soles
				if($tipdes == 2){
					$descuento_calculo = $descuento_linea;	
				}
				
				//precio unitario linea al que se vende
				$precio_unitario_linea=$precio_unitario-$descuento_calculo;
				
				//valor venta
				$valor_venta=$cantidad*(moneda_mysql($precio_unitario_linea));
				
				//igv
				$igv=$valor_venta*$igv_dato;
				
				$tipo_venta=1;
				$ser_id=0;
				//////////////////////
				//registro detalle de venta
                $oCotizacion->insertar_detalle(
					$tipo_venta,
					$indice,
					$ser_id,
					$precio_unitario,
					$cantidad,
					$tipdes,
					$descuento_linea,
					$precio_unitario_linea,
					$valor_venta,
					$igv,
					$ven_id
				);
				
				///-----------------------------------
				//registro detalle de notalmacen
				$costo=0;
				$precio=moneda_mysql(($valor_venta+$igv)/$cantidad);
				$oNotalmacen->insertar_detalle(
					$indice,
					$cantidad,
					$costo,
					$precio,
					$notalm_id
				);
				//------------------------------------
				
				//datos presentacion catalogo
				$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($indice,$almacen_venta);
				$dt = mysql_fetch_array($dts);
					$sto_id=	$dt['tb_stock_id'];
					$sto_num	=$dt['tb_stock_num'];
					$mul		=$dt['tb_catalogo_mul'];
				mysql_free_result($dts);
				
				//conversion a la minima unidad
				$cantidad_venta=$cantidad*$mul;
				
				//actualizacion de stock
				$stock_nuevo=$sto_num-$cantidad_venta;
				
				$dts=$oStock->modificar($sto_id,$stock_nuevo);
				
				//actualizacion de precio de venta
				//$dts= $oCatalogo->actualizar_precio_venta($indice,$preven);
				
			}
			
			if(isset($_SESSION['venta_car']))
			{
				unset($_SESSION['venta_car']);
				unset($_SESSION['venta_des']);
				unset($_SESSION['venta_tipdes']);
				//unset($_SESSION['venta_igv']);
				unset($_SESSION['venta_preven']);
				unset($_SESSION['presentacion_id']);
				unset($_SESSION['catalogo_mul']);
				unset($_SESSION['venta_descuento']);
			}
			
			//detalle de servicios
			if(isset($_SESSION['servicio_car']))foreach($_SESSION['servicio_car'] as $indice=>$cantidad){			
				
				//precio de venta ingresado
				$precio_venta = $_SESSION['servicio_preven'][$indice];
				
				//precio unitario de venta
				$precio_unitario=$precio_venta/(1+$igv_dato);
				
				
				//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
				$tipdes = $_SESSION['servicio_tipdes'][$indice];				
				$descuento_linea = $_SESSION['servicio_des'][$indice];
				
				//descuento en porcentaje
				if($tipdes == 1){
					$descuento_calculo = ($descuento_linea/100)*$precio_unitario;
				}
				//descuento en soles
				if($tipdes == 2){
					$descuento_calculo = $descuento_linea;	
				}
				
				
				//precio unitario linea al que se vende
				$precio_unitario_linea=$precio_unitario-$descuento_calculo;
				
				//valor venta
				$valor_venta=$cantidad*(moneda_mysql($precio_unitario_linea));
				
				//igv
				$igv=$valor_venta*$igv_dato;
				
				$tipo_venta=2;
				$cat_id=0;
				//////////////////////
				//registro detalle de venta de servicio
                $oCotizacion->insertar_detalle(
					$tipo_venta,
					$cat_id,  
					$indice,				
					$precio_unitario,
					$cantidad,
					$tipdes,
					$descuento_linea,
					$precio_unitario_linea,
					$valor_venta,
					$igv,			
					$ven_id
				);		
			}
			
			if(isset($_SESSION['servicio_car'])){
				unset($_SESSION['servicio_car']);
				unset($_SESSION['servicio_preven']);
				unset($_SESSION['servicio_tipdes']);
				unset($_SESSION['servicio_des']);
			}
			
			}//fin diferente de aunalada
			 
			
			//agregamos registro de canje de nota de venta y venta
			$oVentacanje->insertar( 
				$_SESSION['vennot_id'],
				$ven_id,
				$_POST['hdd_usu_id'],
				$_POST['hdd_punven_id'],
				$_SESSION['empresa_id']
			);
			
			unset($_SESSION['vennot_id']);
			
			//registrar EGRESO EN CAJA
			if($_POST['chk_egreso']==1){
			
				//punto venta y caja
				$dts=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
				$dt = mysql_fetch_array($dts);
					$caj_id		=$dt['tb_caja_id'];
				mysql_free_result($dts);
			
				//registro de egreso
				$descripcion="Egreso en caja por venta canjeada: $documento $numdoc.";
				$gasto_doc=$documento.' '.$numdoc;
				$modo_pago='EFECTIVO';
				$cuenta=34;
				$subcuenta='';
				$referencia=1;
				$gasto_emp=1;
				$mon_id=1;
				
				$oGasto->insertar(
					fecha_mysql($_POST['txt_ven_fec']),
					$gasto_doc,
					$descripcion,
					moneda_mysql($_POST['txt_ven_tot']),
					$modo_pago,
					'',
					'CANCELADO', 
					$cuenta,
					$subcuenta,
					'',
					'',
					$caj_id,
					$mon_id,
					$referencia,
					'',
					$gasto_emp,
					$_POST['hdd_usu_id'],
					$_POST['hdd_usu_id']
				);
			
			}
			
						
			$data['ven_id']=$ven_id;
			if($_POST['chk_imprimir']==1)$data['ven_act']='imprime';
			$data['ven_msj']='Se registró venta correctamente. Cange de Nota de Venta Correcto.';
			echo json_encode($data);
		}
		else
		{
			$data['ven_msj']='Cambie de Punto de Venta a: '.$punven_nom.', en menú Opciones.';
			echo json_encode($data);
		}
	}
	else
	{
		$data['ven_msj']='Intentelo nuevamente.';
		echo json_encode($data);
	
	}
}

?>