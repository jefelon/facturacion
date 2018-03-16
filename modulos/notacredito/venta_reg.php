<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once("cVenta.php");
$oVenta = new cVenta();
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
		

		//documento
			$dts= $oDocumento->mostrarUno($_POST['cmb_ven_doc']);
			$dt = mysql_fetch_array($dts);
		$documento=$dt['tb_documento_abr'];
		$documento_ele=$dt['tb_documento_ele'];
		$documento_tipdoc=$dt['cs_tipodocumento_id'];
		$documento_cod=$dt['cs_tipodocumento_cod'];
			mysql_free_result($dts);


		//insertamos venta
		$oVenta->insertar( 
			fecha_mysql($_POST['txt_ven_fec']),
			$_POST['cmb_ven_doc'],
			$numdoc,
			$tal_ser,
			$numero,
			$_POST['hdd_ven_cli_id'],
			moneda_mysql($_POST['txt_ven_valven']),
			moneda_mysql($_POST['txt_ven_igv']),
			moneda_mysql($_POST['txt_ven_des']),
			moneda_mysql($_POST['txt_ven_tot']),
			$_POST['cmb_ven_est'],
			$_POST['txt_ven_lab1'],
			$_POST['txt_ven_lab2'],
			$_POST['txt_ven_lab3'],
			$_POST['chk_ven_may'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_punven_id'],
			$_SESSION['empresa_id'],

			$documento_tipdoc,//cs_tipodocumento_id
			1,//cs_tipomoneda_id
			moneda_mysql($_POST['txt_ven_subtot']),//tb_venta_gra
			0,//tb_venta_ina
			0,//tb_venta_exo
			moneda_mysql($_POST['txt_ven_opegra']),//tb_venta_grat
			0,//tb_venta_isc
			moneda_mysql($_POST['txt_ven_otrtri']),
			moneda_mysql($_POST['txt_ven_otrcar']),
			0,//tb_venta_desglo
			1,//cs_tipooperacion_id
			0//cs_documentosrelacionados_id
		);
		//ultima venta
			$dts=$oVenta->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$ven_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		//REGISTRO DE PAGOS
		//PAGO AUTOMATICO
		
		if($_POST['chk_venpag_aut']==1)
		{
			//Registro de pago
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
			
			
			//FORMA DE PAGO CONTADO
			if($_POST['cmb_forpag_id']==1)
			{
				//registro entrada
				$xac=1;
				$cuecli_tipreg=1;
				$cuecli_tip=1;
				$cuecli_est=1;
				$verif=1;
				$ventip=1;//venta
				$cuecli_glo="VENTA $forma_pago $modo_pago | $documento $numdoc";
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
				$ventip=1;//venta
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
				$ing_det="VENTA $documento $numdoc | $modo_pago";
				$ing_est='1';
				$ing_cue_id=22;
				if($_SESSION['empresa_id']==1)$ing_subcue_id=157;
				//$ing_subcue_id=0;
				//$caj_id=1;
				$mon_id=1;
				$mod_id=1;//modulo 1 venta
				
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
				$ventip=1;//venta
				$oClientecuenta->insertar(
					$xac,
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
				//no existe salida, se espera registre pago
			}
		}
		else //PAGO DE FORMA MANUAL
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
				//para glosa cuantacliente
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
				
				//FORMA DE PAGO CONTADO
				if($_SESSION['venpag_for'][$indice]==1)
				{
					//registro de entrada
					$xac=1;
					$cuecli_tipreg=1;
					$cuecli_tip=1;
					$cuecli_est=1;
					$verif=1;
					$ventip=1;//venta
					$oClientecuenta->insertar(
						$xac,
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
					
					//registro de salida
					$xac=1;
					$cuecli_tipreg=1;
					$cuecli_tip=2;
					$cuecli_est=0;
					$verif=1;
					$ventip=1;//venta
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

					//INGRESO CAJA
					$xac=1;
					$ing_det="VENTA $documento $numdoc | $modo_pago";
					$ing_est='1';
					$ing_cue_id=22;
					if($_SESSION['empresa_id']==1)$ing_subcue_id=157;
					//$ing_subcue_id=0;
					//$caj_id=1;
					$mon_id=1;
					$mod_id=1;//modulo 1 venta

					//SELECCIONAR CAJA
					if($_SESSION['venpag_mod'][$indice]==1)
					{
						$caj_id=$caja_venta;//efectivo
					}
					if($_SESSION['venpag_mod'][$indice]==2)
					{
						$dts=$oCuentacorriente->mostrarUno($_SESSION['venpag_cuecor'][$indice]);
						$dt = mysql_fetch_array($dts);
							$cuecor_nom	=$dt['tb_cuentacorriente_nom'];
							$caj_id	=$dt['tb_caja_id'];
						mysql_free_result($dts);
					}
					if($_SESSION['venpag_mod'][$indice]==3)
					{
						$dts=$oTarjeta->mostrarUno($_SESSION['venpag_tar'][$indice]);
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
				if($_SESSION['venpag_for'][$indice]==2)
				{
					$xac=1;
					$cuecli_tipreg=1;
					$cuecli_tip=1;
					$cuecli_est=2;
					$verif=2;
					$ventip=1;//venta
					$oClientecuenta->insertar(
						$xac,
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
					
					//no existe salida, se espera registro de pago			
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
		
		
		//registro de kardex
		$xac=1;
		$tipo_registro=1;//1 automatico 2 manual
		$kar_tip=2;//1 entrada 2 salida
		$tipope_id=3;//3 venta
		$kar_des='VENTA';
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
		//VENDA DIFERENTE DE ANULADA
	$descuento_global = 0;
	  if($_POST['cmb_ven_est']!='ANULADA')
	  {

	  	$autoin = 0;
		
		//detalle de productos
		if(isset($_SESSION['venta_car']))foreach($_SESSION['venta_car'] as $indice=>$cantidad)
		{			
			$autoin++;

			//precio de venta ingresado
			$precio_venta	=$_SESSION['venta_preven'][$indice];
							
			//precio unitario de venta
			$precio_unitario=$precio_venta/(1+$igv_dato);
			
			$nom = $_SESSION['venta_nom'][$indice];
			//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
			$tipdes = $_SESSION['venta_tipdes'][$indice];				
			$descuento_linea=formato_money($_SESSION['venta_des'][$indice]/1.18);
			$descuento_global += $descuento_linea*$cantidad;
			//descuento en porcentaje
			//if($tipdes == 1){
			//	$descuento_calculo = ($descuento_linea/100)*$precio_unitario;
			//}
			//descuento en soles
			if($tipdes == 2){
				$descuento_calculo = $descuento_linea;	
			}
			
			//precio unitario linea al que se vende
			$precio_unitario_linea=$_SESSION['venta_preven'][$indice];
			
			//valor venta
			$valor_venta=moneda_mysql(($precio_unitario*$cantidad)-$descuento_calculo);
			
			//igv
			$igv=$valor_venta*$igv_dato;
			
			$tipo_venta=1;
			$ser_id=0;
			$afeigv_id=1;
			$unimed_id=12;//NIU

			//////////////////////
			$oVenta->insertar_detalle(
				$tipo_venta,
				$indice,
				$ser_id,
				$nom,
				$precio_unitario,
				$cantidad,
				$tipdes,
				$descuento_linea,
				$precio_unitario_linea,
				$valor_venta,
				$igv,
				$ven_id,
				$afeigv_id,
				$unimed_id,
				$calisc,
				$det_isc,
				$autoin
			);
			
			///-----------------------------------
			
			//datos presentacion catalogo
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($indice,$almacen_venta);
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
			
			//------------------------------------
			
        }
        
        //$oVenta->modificar_campo($ven_id,'des',$descuento_global);
		
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
		if(isset($_SESSION['servicio_car']))foreach($_SESSION['servicio_car'] as $indice=>$cantidad)
		{			
			$autoin++;

			//precio de venta ingresado
			$precio_venta = $_SESSION['servicio_preven'][$indice];
			
			//precio unitario de venta
			$precio_unitario=$precio_venta/(1+$igv_dato);
			
			$nom = $_SESSION['servicio_nom'][$indice];

			//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
			$tipdes = $_SESSION['servicio_tipdes'][$indice];				
			$descuento_linea = $_SESSION['servicio_des'][$indice];
			
			//descuento en porcentaje
			// if($tipdes == 1){
			// 	$descuento_calculo = ($descuento_linea/100)*$precio_unitario;
			// }
			//descuento en soles
			if($tipdes == 2){
				$descuento_calculo = $descuento_linea;	
			}
			
			
			//precio unitario linea al que se vende
			$precio_unitario_linea=$_SESSION['servicio_preven'][$indice];
			//$precio_unitario_linea=$precio_unitario-$descuento_calculo;//correccion
			
			//valor venta
			$valor_venta=moneda_mysql(($precio_unitario*$cantidad)-$descuento_calculo);
			//$valor_venta=$cantidad*(moneda_mysql($precio_unitario_linea));//correccion
			
			//igv
			$igv=$valor_venta*$igv_dato;
			
			$tipo_venta=2;
			$cat_id=0;
			$afeigv_id=1;
			$unimed_id=13;//ZZ

			//////////////////////
			//registro detalle de venta de servicio
			$oVenta->insertar_detalle( 
				$tipo_venta,
				$cat_id,  
				$indice,
				$nom,				
				$precio_unitario,
				$cantidad,
				$tipdes,
				$descuento_linea,
				$precio_unitario_linea,
				$valor_venta,
				$igv,			
				$ven_id,
				$afeigv_id,
				$unimed_id,
				$calisc,
				$det_isc,
				$autoin
			);		
        }
		
		if(isset($_SESSION['servicio_car'])){
			unset($_SESSION['servicio_car']);
			unset($_SESSION['servicio_preven']);
			unset($_SESSION['servicio_tipdes']);
			unset($_SESSION['servicio_des']);
			unset($_SESSION['servicio_nom']);
		}
		
	  }//fin diferente de aunalada
		 
		
		$data['ven_id']=$ven_id;
		if($_POST['chk_imprimir']==1)$data['ven_act']='imprime';

		if($documento_ele==1)
		{
			if($documento_cod==1)$data['ven_sun']='enviar';
			if($documento_cod==3)$oVenta->modificar_campo($ven_id,'estsun','10');
		}

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
		/*$oVenta->modificar(
			$_POST['hdd_ven_id'],
			fecha_mysql($_POST['txt_ven_fec']),
			$_POST['hdd_ven_cli_id'],
			$_POST['hdd_ven_est'],
			$_POST['txt_ven_lab1']
		);*/
		
		$oVenta->modificar_adm(
			$_POST['hdd_ven_id'],
			$_POST['chk_ven_may'],
			$_POST['txt_ven_lab1']
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
//		$result = $oVenta->verifica_venta_producto($_POST['ven_id']);
//		$fila = mysql_fetch_array($result);
//		
//		if($fila[1] !="")
//		{
			echo "No se puede eliminar, afecta información de productos.";
//		}
//		else
//		{
//			$oVenta->eliminar($_POST['ven_id']);
//		echo 'Se eliminó venta correctamente.';
//		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>