<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}

function responder($estado=false, $mensaje='', $datos=[])
{
	header('Content-Type: application/json');
	echo json_encode([
		'est' => $estado,
		'msj' => $mensaje,
		'dat' => $datos,
	]);
	exit;
}
// Valida sesion
if( $_POST['hdd_usu_id']!==$_SESSION['usuario_id'] ||
	$_POST['hdd_punven_id']!==$_SESSION['puntoventa_id'] ||
	$_POST['hdd_emp_id']!==$_SESSION['empresa_id'])
{
	echo json_encode(['redireccionar'=>true]);
	exit();
}

require_once ("../../config/Cado.php");
require_once("cCotizacion.php");
$oCotizacion = new cCotizacion();

require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();

require_once ("../talonario/cTalonario.php");
$oTalonario= new cTalonario();

require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

require_once("../formatos/formato.php");

$unico_id=$_POST['unico_id'];

$igv_dato=0.18;
$almacen_venta=$_SESSION['almacen_id'];
if($_POST['hdd_punven_id']>0)
{
	$dts=$oPuntoventa->mostrarUno($_POST['hdd_punven_id']);
	$dt = mysql_fetch_array($dts);
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
		$oCotizacion->insertar(
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
			$dts=$oCotizacion->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$ven_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		

		
		if(isset($_SESSION['venpag_mon'][$unico_id])){
			unset($_SESSION['venpag_mon'][$unico_id]);
			unset($_SESSION['venpag_for'][$unico_id]);
			unset($_SESSION['venpag_mod'][$unico_id]);
			unset($_SESSION['venpag_cuecor'][$unico_id]);
			unset($_SESSION['venpag_tar'][$unico_id]);
			unset($_SESSION['venpag_numope'][$unico_id]);
			unset($_SESSION['venpag_numdia'][$unico_id]);
			unset($_SESSION['venpag_fecven'][$unico_id]);
		}

		//actualizamos talonario
		$estado='ACTIVO';
		if($numero==$tal_fin)$estado='INACTIVO';
		$rs= $oTalonario->actualizar_correlativo($tal_id,$numero,$estado);
		
		

		
		//___________________________________________________________________
		//VENDA DIFERENTE DE ANULADA
	$descuento_global = 0;
	  if($_POST['cmb_ven_est']!='ANULADA')
	  {

	  	$autoin = 0;
		
		//detalle de productos
		if(isset($_SESSION['venta_car'][$unico_id]))foreach($_SESSION['venta_car'][$unico_id] as $indice=>$cantidad)
		{			
			$autoin++;

			//precio de venta ingresado
			$precio_venta	=$_SESSION['venta_preven'][$unico_id][$indice];
							
			//precio unitario de venta
			$precio_unitario=$precio_venta/(1+$igv_dato);
			
			$nom = $_SESSION['venta_nom'][$unico_id][$indice];
			//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
			$tipdes = $_SESSION['venta_tipdes'][$unico_id][$indice];				
			$descuento_linea=formato_money($_SESSION['venta_des'][$unico_id][$indice]/1.18);
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
			$precio_unitario_linea=$_SESSION['venta_preven'][$unico_id][$indice];
			
			//valor venta
			$valor_venta=moneda_mysql(($precio_unitario*$cantidad)-$descuento_calculo);
			
			//igv
			$igv=$valor_venta*$igv_dato;
			
			$tipo_venta=1;
			$ser_id=0;
			$afeigv_id=1;
			$unimed_id=12;//NIU

			//////////////////////
			$oCotizacion->insertar_detalle(
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

			//------------------------------------
			
        }
        
        //$oVenta->modificar_campo($ven_id,'des',$descuento_global);
		
		if(isset($_SESSION['venta_car'][$unico_id]))
		{
			unset($_SESSION['venta_car'][$unico_id]);
			unset($_SESSION['venta_des'][$unico_id]);
			unset($_SESSION['venta_tipdes'][$unico_id]);
			//unset($_SESSION['venta_igv'][$unico_id]);
			unset($_SESSION['venta_preven'][$unico_id]);
			unset($_SESSION['presentacion_id'][$unico_id]);
			unset($_SESSION['catalogo_mul'][$unico_id]);
			unset($_SESSION['venta_descuento'][$unico_id]);
	  	}
		
		//detalle de servicios
		if(isset($_SESSION['servicio_car'][$unico_id]))foreach($_SESSION['servicio_car'][$unico_id] as $indice=>$cantidad)
		{			
			$autoin++;

			//precio de venta ingresado
			$precio_venta = $_SESSION['servicio_preven'][$unico_id][$indice];
			
			//precio unitario de venta
			$precio_unitario=$precio_venta/(1+$igv_dato);
			
			$nom = $_SESSION['servicio_nom'][$unico_id][$indice];

			//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
			$tipdes = $_SESSION['servicio_tipdes'][$unico_id][$indice];				
			$descuento_linea = $_SESSION['servicio_des'][$unico_id][$indice];
			
			//descuento en porcentaje
			// if($tipdes == 1){
			// 	$descuento_calculo = ($descuento_linea/100)*$precio_unitario;
			// }
			//descuento en soles
			if($tipdes == 2){
				$descuento_calculo = $descuento_linea;	
			}
			
			
			//precio unitario linea al que se vende
			$precio_unitario_linea=$_SESSION['servicio_preven'][$unico_id][$indice];
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
			$oCotizacion->insertar_detalle(
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
		
		if(isset($_SESSION['servicio_car'][$unico_id])){
			unset($_SESSION['servicio_car'][$unico_id]);
			unset($_SESSION['servicio_preven'][$unico_id]);
			unset($_SESSION['servicio_tipdes'][$unico_id]);
			unset($_SESSION['servicio_des'][$unico_id]);
			unset($_SESSION['servicio_nom'][$unico_id]);
		}
		
	  }//fin diferente de aunalada
		 
		
		$data['ven_id']=$ven_id;
		if($_POST['chk_imprimir']==1)$data['ven_act']='imprime';

//editado
	//	if($documento_ele==1)
		//{
		//	if($documento_cod==1)$data['ven_sun']='enviar';
		//	if($documento_cod==3)$oVenta->modificar_campo($ven_id,'estsun','10'//);
		//}
		
		if($documento_ele==1)
		{
			if($documento_cod==1 or $documento_cod==3)$data['ven_sun']='enviar';
			if($documento_cod==3)$oCotizacion->modificar_campo($ven_id,'estsun','10');
		}

		$data['ven_msj']='Se registró cotización correctamente.';
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

        $oCotizacion->modificar_adm(
			$_POST['hdd_ven_id'],
			$_POST['chk_ven_may'],
			$_POST['txt_ven_lab1']
		);

		$data['ven_msj']='Se registró cotización correctamente.';
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