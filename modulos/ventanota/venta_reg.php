<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once("cVentanota.php");
$oVentanota = new cVentanota();
require_once("cVentanotapago.php");
$oVentanotapago = new cVentanotapago();
require_once("../clientecuenta/cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();

require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();

require_once("../producto/cStock.php");
$oStock = new cStock();

require_once("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

require_once ("../cuentacorriente/cCuentacorriente.php");
$oCuentacorriente = new cCuentacorriente();
require_once ("../tarjeta/cTarjeta.php");
$oTarjeta = new cTarjeta();

require_once("../formatos/formato.php");

$igv_dato=0.18;
$almacen_venta=$_SESSION['almacen_id'];
if($_POST['hdd_punven_id']>0)
{
	$dts=$oPuntoventa->mostrarUno($_POST['hdd_punven_id']);
	$dt = mysql_fetch_array($dts);
		$caja_venta		=$dt['tb_caja_id'];
	mysql_free_result($dts);
}

if($_POST['action_venta']=="insertar")
{
	if(!empty($_POST['txt_ven_fec']))
	{
		$docc_id=1;
		//consultamos talonario
			$dts= $oTalonariointerno->correlativo_notven($_SESSION['puntoventa_id'],$docc_id);
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
		$oVentanota->insertar( 
			fecha_mysql($_POST['txt_ven_fec']),
			$_POST['cmb_ven_doc'],
			$numdoc,
			$_POST['hdd_ven_cli_id'],
			moneda_mysql($_POST['txt_ven_valven']),
			moneda_mysql($_POST['txt_ven_igv']),
			moneda_mysql($_POST['txt_ven_des']),
			moneda_mysql($_POST['txt_ven_tot']),
			$_POST['cmb_ven_est'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_punven_id'],
			$_SESSION['empresa_id']
		);
		//ultima venta
			$dts=$oVentanota->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$ven_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		//REGISTRO DE PAGOS
		//PAGO AUTOMATICO
		
		if($_POST['chk_venpag_aut']==1)
		{
			//Registro de pago
			$oVentanotapago->insertar(
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
			
			//datos para glosa cuenta cliente
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
			//documento
				$dts= $oDocumento->mostrarUno($_POST['cmb_ven_doc']);
				$dt = mysql_fetch_array($dts);
			$documento=$dt['tb_documento_abr'];
				mysql_free_result($dts);
			
			//FORMA DE PAGO CONTADO
			if($_POST['cmb_forpag_id']==1)
			{
				//registro entrada
				$xac=1;
				$cuecli_tipreg=1;
				$cuecli_tip=1;
				$cuecli_est=1;
				$verif=1;
				$ventip=2;//nota de venta
				$cuecli_glo="NOTA VENTA $forma_pago $modo_pago | $documento $numdoc";
				$oClientecuenta->insertar(
					$xac,
					$cuecli_tipreg,
					fecha_mysql($_POST['txt_ven_fec']),
					$cuecli_glo,
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
					
				//registro salida
				$xac=1;
				$cuecli_tipreg=1;
				$cuecli_tip=2;
				$cuecli_est=0;
				$verif=1;
				$ventip=2;//nota de venta
				$oClientecuenta->insertar(
					$xac,
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

				//INGRESO CAJA
				$xac=1;
				$ing_det="NOTA DE VENTA $documento $numdoc | $modo_pago";
				$ing_est='1';
				$ing_cue_id=23;
				if($_SESSION['empresa_id']==1)$ing_subcue_id=159;
				//$ing_subcue_id=0;
				//$caj_id=1;
				$mon_id=1;
				$mod_id=4;//modulo 4 nota venta

				//SELECCIONAR CAJA
				if($_POST['cmb_modpag_id']==1)
				{
					$caj_id=$caja_venta;//efectivo
				}
				if($_POST['cmb_modpag_id']==2)
				{
					$dts=$oCuentacorriente->mostrarUno($_POST['cmb_cuecor_id']);
					$dt = mysql_fetch_array($dts);
						$cuecor_nom	=$dt['tb_cuentacorriente_nom'];
						$caj_id	=$dt['tb_caja_id'];
					mysql_free_result($dts);
				}
				if($_POST['cmb_modpag_id']==3)
				{
					$dts=$oTarjeta->mostrarUno($_POST['cmb_tar_id']);
					$dt = mysql_fetch_array($dts);
						$tar_nom	=$dt['tb_tarjeta_nom'];
						$caj_id		=$dt['tb_caja_id'];
					mysql_free_result($dts);
				}

				$oIngreso->insertar(
					$_SESSION['usuario_id'],
					$_SESSION['usuario_id'],
					$xac,
					fecha_mysql($_POST['txt_ven_fec']),
					$_POST['cmb_ven_doc'],
					$numdoc,
					$ing_det,
					moneda_mysql($_POST['txt_venpag_mon']),
					$ing_est,
					$ing_cue_id,
					$ing_subcue_id,
					$_POST['hdd_ven_cli_id'],
					$caj_id,
					$mon_id,
					$mod_id,
					$ven_id,
					$_SESSION['empresa_id']
				);

			}
			
			//FORMA DE PAGO CREDITO
			if($_POST['cmb_forpag_id']==2)
			{
				//registro entrada
				$xac=1;
				$cuecli_tipreg=1;
				$cuecli_tip=1;
				$cuecli_est=2;
				$verif=2;
				$ventip=2;//nota de venta
				$oClientecuenta->insertar(
					$xac,
					$cuecli_tipreg,
					fecha_mysql($_POST['txt_ven_fec']),
					"NOTA VENTA $forma_pago $modo_pago | $documento $numdoc",
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
				//no existe salida, se espera registre pago
			}
		}
		else //PAGO DE FORMA MANUAL
		{
			if(isset($_SESSION['vennotpag_mon']))foreach($_SESSION['vennotpag_mon'] as $indice=>$valor){
				
				$oVentanotapago->insertar(
					$_SESSION['vennotpag_for'][$indice],
					$_SESSION['vennotpag_mod'][$indice],
					fecha_mysql(date('d-m-Y')),
					moneda_mysql($valor),
					$_SESSION['vennotpag_cuecor'][$indice],
					$_SESSION['vennotpag_tar'][$indice],
					$_SESSION['vennotpag_numope'][$indice],
					$_SESSION['vennotpag_numdia'][$indice],
					fecha_mysql($_SESSION['vennotpag_fecven'][$indice]),
					$ven_id,
					$_SESSION['empresa_id']
				);
				//para glosa cuantacliente
				switch ($_SESSION['vennotpag_for'][$indice]) {
					case 1:
						$forma_pago='CONTADO';
						break;
					case 2:
						$forma_pago='CREDITO';
						break;
				}
				
				switch ($_SESSION['vennotpag_mod'][$indice]) {
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
				
				//FORMA DE PAGO CONTADO
				if($_SESSION['vennotpag_for'][$indice]==1)
				{
					//registro de entrada
					$xac=1;
					$cuecli_tipreg=1;
					$cuecli_tip=1;
					$cuecli_est=1;
					$verif=1;
					$ventip=2;//nota de venta
					$oClientecuenta->insertar(
						$xac,
						$cuecli_tipreg,
						fecha_mysql($_POST['txt_ven_fec']),
						"NOTA VENTA $forma_pago $modo_pago | $documento $numdoc",
						$cuecli_tip,
						moneda_mysql($valor),
						$cuecli_est,
						$ventip,
						$ven_id,
						$_SESSION['vennotpag_for'][$indice],
						$_SESSION['vennotpag_mod'][$indice],
						$_SESSION['vennotpag_cuecor'][$indice],
						$_SESSION['vennotpag_tar'][$indice],
						$_SESSION['vennotpag_numope'][$indice],
						$_SESSION['vennotpag_numdia'][$indice],
						fecha_mysql($_SESSION['vennotpag_fecven'][$indice]),
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
					
					//registro de salida
					$xac=1;
					$cuecli_tipreg=1;
					$cuecli_tip=2;
					$cuecli_est=0;
					$verif=1;
					$ventip=2;//nota de venta
					$oClientecuenta->insertar(
						$xac,
						$cuecli_tipreg,
						fecha_mysql($_POST['txt_ven_fec']),
						"PAGO $forma_pago $modo_pago | $documento $numdoc",
						$cuecli_tip,
						moneda_mysql($valor),
						$cuecli_est,
						$ventip,
						$ven_id,
						$_SESSION['vennotpag_for'][$indice],
						$_SESSION['vennotpag_mod'][$indice],
						$_SESSION['vennotpag_cuecor'][$indice],
						$_SESSION['vennotpag_tar'][$indice],
						$_SESSION['vennotpag_numope'][$indice],
						$_SESSION['vennotpag_numdia'][$indice],
						fecha_mysql($_SESSION['vennotpag_fecven'][$indice]),
						$_POST['hdd_ven_cli_id'],
						$verif,
						$clicue_idp,
						$_SESSION['usuario_id'],
						$_SESSION['empresa_id']
					);

					//INGRESO CAJA
					$xac=1;
					$ing_det="NOTA DE VENTA $documento $numdoc | $modo_pago";
					$ing_est='1';
					$ing_cue_id=23;
					if($_SESSION['empresa_id']==1)$ing_subcue_id=159;
					//$ing_subcue_id=0;
					//$caj_id=1;
					$mon_id=1;
					$mod_id=4;//modulo 4 nota venta

					//SELECCIONAR CAJA
					if($_SESSION['vennotpag_mod'][$indice]==1)
					{
						$caj_id=$caja_venta;//efectivo
					}
					if($_SESSION['vennotpag_mod'][$indice]==2)
					{
						$dts=$oCuentacorriente->mostrarUno($_SESSION['vennotpag_cuecor'][$indice]);
						$dt = mysql_fetch_array($dts);
							$cuecor_nom	=$dt['tb_cuentacorriente_nom'];
							$caj_id	=$dt['tb_caja_id'];
						mysql_free_result($dts);
					}
					if($_SESSION['vennotpag_mod'][$indice]==3)
					{
						$dts=$oTarjeta->mostrarUno($_SESSION['vennotpag_tar'][$indice]);
						$dt = mysql_fetch_array($dts);
							$tar_nom	=$dt['tb_tarjeta_nom'];
							$caj_id		=$dt['tb_caja_id'];
						mysql_free_result($dts);
					}

					$oIngreso->insertar(
						$_SESSION['usuario_id'],
						$_SESSION['usuario_id'],
						$xac,
						fecha_mysql($_POST['txt_ven_fec']),
						$_POST['cmb_ven_doc'],
						$numdoc,
						$ing_det,
						moneda_mysql($valor),
						$ing_est,
						$ing_cue_id,
						$ing_subcue_id,
						$_POST['hdd_ven_cli_id'],
						$caj_id,
						$mon_id,
						$mod_id,
						$ven_id,
						$_SESSION['empresa_id']
					);

				}
				
				//FORMA DE PAGO CREDITO
				if($_SESSION['vennotpag_for'][$indice]==2)
				{
					$xac=1;
					$cuecli_tipreg=1;
					$cuecli_tip=1;
					$cuecli_est=2;
					$verif=2;
					$ventip=2;//nota de venta
					$oClientecuenta->insertar(
						$xac,
						$cuecli_tipreg,
						fecha_mysql($_POST['txt_ven_fec']),
						"NOTA VENTA $forma_pago $modo_pago | $documento $numdoc",
						$cuecli_tip,
						moneda_mysql($valor),
						$cuecli_est,
						$ventip,
						$ven_id,
						$_SESSION['vennotpag_for'][$indice],
						$_SESSION['vennotpag_mod'][$indice],
						$_SESSION['vennotpag_cuecor'][$indice],
						$_SESSION['vennotpag_tar'][$indice],
						$_SESSION['vennotpag_numope'][$indice],
						$_SESSION['vennotpag_numdia'][$indice],
						fecha_mysql($_SESSION['vennotpag_fecven'][$indice]),
						$_POST['hdd_ven_cli_id'],
						$verif,
						$clicue_idp,
						$_SESSION['usuario_id'],
						$_SESSION['empresa_id']
					);
					
					//no existe salida, se espera registro de pago			
				}
				
			}
		}
		
		if(isset($_SESSION['vennotpag_mon'])){
			unset($_SESSION['vennotpag_mon']);
			unset($_SESSION['vennotpag_for']);
			unset($_SESSION['vennotpag_mod']);
			unset($_SESSION['vennotpag_cuecor']);
			unset($_SESSION['vennotpag_tar']);
			unset($_SESSION['vennotpag_numope']);
			unset($_SESSION['vennotpag_numdia']);
			unset($_SESSION['vennotpag_fecven']);
		}
		
		//actualizamos talonario
		$estado='ACTIVO';
		if($numero==$tal_fin)$estado='INACTIVO';
		$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$numero,$estado);
		
		//registro de kardex
		$xac=1;
		$tipo_registro=1;//1 automatico 2 manual
		$kar_tip=2;//1 entrada 2 salida
		$tipope_id=5;//5 NOTA venta
		$kar_des='NOTA DE VENTA';
		$operacion_id=$ven_id;//id de la operacion(modulo compras, ventas, etc)
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
			$almacen_venta,
			$_POST['hdd_usu_id'],
			$_SESSION['empresa_id']
		);
		//ultimo kardex
			$dts=$oKardex->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$kar_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		$oKardex->modificar_codigo($kar_id,$kar_id);

		//___________________________________________________________________
		
	  if($_POST['cmb_ven_est']!='ANULADA')
	  {
		//detalle de productos
		if(isset($_SESSION['ventanota_car']))foreach($_SESSION['ventanota_car'] as $indice=>$catalogo_id){			
			
			$cantidad=$_SESSION['ventanota_can'][$indice];
			
			//precio de venta ingresado
			$precio_venta	=$_SESSION['ventanota_preven'][$indice];
							
			//precio unitario de venta
			$precio_unitario=$precio_venta/(1+$igv_dato);
			
			
			//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
			$tipdes = $_SESSION['ventanota_tipdes'][$indice];				
			$descuento_linea=$_SESSION['ventanota_des'][$indice];
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
			$oVentanota->insertar_detalle(
				$tipo_venta,
				$catalogo_id,
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
			
			//datos presentacion catalogo
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($catalogo_id,$almacen_venta);
			$dt = mysql_fetch_array($dts);
				$pre_id=	$dt['tb_presentacion_id'];
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

			//unidad base
			$dts=$oKardex->presentacion_buscar_unidad_base($pre_id);
			$dt = mysql_fetch_array($dts);
				$cat_id		=$dt['tb_catalogo_id'];
			mysql_free_result($dts);

			//registro detalle de kardex
			$costo=0;
			$precio=moneda_mysql(($valor_venta+$igv)/$cantidad);
			$oKardex->insertar_detalle(
				$cat_id,
				$cantidad_venta,
				$costo,
				$precio,
				$kar_id
			);
			
        }
		
		if(isset($_SESSION['ventanota_car']))
		{
			unset($_SESSION['ventanota_car']);
			unset($_SESSION['ventanota_can']);
			unset($_SESSION['ventanota_des']);
			unset($_SESSION['ventanota_tipdes']);
			//unset($_SESSION['ventanota_igv']);
			unset($_SESSION['ventanota_preven']);
			unset($_SESSION['vn_presentacion_id']);
			unset($_SESSION['vn_catalogo_mul']);
			unset($_SESSION['ventanota_descuento']);
	  	}
		
		//detalle de servicios
		if(isset($_SESSION['vn_servicio_car']))foreach($_SESSION['vn_servicio_car'] as $indice=>$servicio_id){			
			$cantidad=$_SESSION['vn_servicio_can'][$indice];
			
			//precio de venta ingresado
			$precio_venta = $_SESSION['vn_servicio_preven'][$indice];
			
			//precio unitario de venta
			$precio_unitario=$precio_venta/(1+$igv_dato);
			
			
			//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
			$tipdes = $_SESSION['vn_servicio_tipdes'][$indice];				
			$descuento_linea = $_SESSION['vn_servicio_des'][$indice];
			
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
			$oVentanota->insertar_detalle( 
				$tipo_venta,
				$cat_id,  
				$servicio_id,				
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
		
		if(isset($_SESSION['vn_servicio_car'])){
			unset($_SESSION['vn_servicio_car']);
			unset($_SESSION['vn_servicio_can']);
			unset($_SESSION['vn_servicio_preven']);
			unset($_SESSION['vn_servicio_tipdes']);
			unset($_SESSION['vn_servicio_des']);
		}
		
	  }//fin diferente de aunalada
		 
		
		
		$data['ven_id']=$ven_id;
		if($_POST['chk_imprimir']==1)$data['ven_act']='imprime';
		$data['ven_msj']='Se registró venta correctamente.';
		echo json_encode($data);
	}
	else
	{
		$data['ven_msj']='Intentelo nuevamente.';
		echo json_encode($data);
	}
}

if($_POST['action_venta']=="editar")
{
	if(!empty($_POST['txt_ven_fec']))
	{
		$oVentanota->modificar(
			$_POST['hdd_ven_id'],
			fecha_mysql($_POST['txt_ven_fec']),
			//$_POST['cmb_ven_doc'],
			//$_POST['txt_ven_numdoc'],
			$_POST['hdd_ven_cli_id'],
			$_POST['hdd_ven_est']
		);
		
		$data['ven_msj']='Se registró venta correctamente.';
		echo json_encode($data);
	}
	else
	{
		$data['ven_msj']='Intentelo nuevamente.';
		echo json_encode($data);
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['ven_id']))
	{
//		$result = $oVentanota->verifica_venta_producto($_POST['ven_id']);
//		$fila = mysql_fetch_array($result);
//		
//		if($fila[1] !="")
//		{
			echo "No se puede eliminar, afecta información de productos.";
//		}
//		else
//		{
//			$oVentanota->eliminar($_POST['ven_id']);
//		echo 'Se eliminó venta correctamente.';
//		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>