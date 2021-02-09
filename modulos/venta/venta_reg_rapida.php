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
if ($_SESSION['usuariogrupo_id']==2){
    $usu_ses = 0;
}

if ($_SESSION['usuariogrupo_id']==3){
    $usu_ses = $_POST['hdd_usu_id']!==$_SESSION['usuario_id'];
}

if($usu_ses || $_POST['hdd_punven_id']!==$_SESSION['puntoventa_id'] || $_POST['hdd_emp_id']!==$_SESSION['empresa_id'])
{
	echo json_encode(['redireccionar'=>true]);
	exit();
}

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

require_once ("../letras/cLetras.php");
$cLetras = new cLetras();

require_once("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();

require_once("../formatos/formato.php");
require_once ("../formatos/numletras.php");

require_once("../guia/cGuia.php");
$oGuia = new cGuia();

require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();

require_once ("../lote/cLote.php");
$oLote = new cLote();
require_once ("../lote/cVentaDetalleLote.php");
$oVentaDetalleLote = new cVentaDetalleLote();

require_once("../asientoestado/cAsientoestado.php");
$oAsientoestado = new cAsientoestado();

$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$emp_razsoc=$dt['tb_empresa_razsoc'];
$emp_dir=$dt['tb_empresa_dir'];
mysql_free_result($dts);

if($_POST['action']=="postergar")
{
    if(!empty($_POST['asiento_id']) && !empty($_POST['viaje_horario_id']) && !empty($_POST['viaje_horario_pos']))
    {

        $aes=$oAsientoestado->mostrar_asiento_estado($_POST['viaje_horario_pos'],$_POST['cmb_asiento_pos']);
        $ae_rows = mysql_numrows($aes);
        if($ae_rows<=0){
            $oVenta->modificar_venta_viaje($_POST['viaje_horario_id'],$_POST['asiento_id'],$_POST['viaje_horario_pos'],$_POST['cmb_asiento_pos']);
            $oAsientoestado->modificar_asiento_estado($_POST['viaje_horario_id'],$_POST['asiento_id'],$_POST['viaje_horario_pos'],$_POST['cmb_asiento_pos']);
            echo "Se postergo correctamente";
        }else{
            echo "No se puede postergar, el asiento esta ocupado";
        }
    }
    else
    {
        echo 'Intentelo nuevamente.';
    }
}

$unico_id=$_POST['unico_id'];

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
	if(!empty($_POST['txt_num_asi']))
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

        if ($_POST['hdd_usu_id']==''){
            $usu_id= $_SESSION['usuario_id'];
        }else{
            $usu_id= $_POST['hdd_usu_id'];
        }

        $descuento_numero_global = 0;


        if($_POST['hdd_tipo']=='encomienda'){
            $tipo_venta=2;
            $dtipo='encomienda';
        }else if($_POST['hdd_tipo']=='viaje'){
            $tipo_venta=1;
            $dtipo='viaje';
        }

        //insertamos venta
        $oVenta->insertar_tipo_venta(
            fecha_mysql($_POST['txt_ven_fec']),
            $_POST['cmb_ven_doc'],
            $numdoc,
            $tal_ser,
            $numero,
            $_POST['hdd_ven_cli_id'],
            moneda_mysql($_POST['txt_ven_valven']),
            moneda_mysql($_POST['txt_ven_igv']),
            moneda_mysql($_POST['txt_com_destotal']),
            moneda_mysql($_POST['txt_ven_tot']),
            $_POST['cmb_ven_est'],
            $_POST['txt_ven_lab1'],
            $_POST['txt_ven_lab2'],
            $_POST['txt_ven_lab3'],
            $_POST['chk_ven_may'],
            $_SESSION['usuario_id'],
            $_POST['hdd_punven_id'],
            $_SESSION['empresa_id'],

            $documento_tipdoc,//cs_tipodocumento_id
            $_POST['cmb_ven_moneda'],// cs_tipomoneda_id
            moneda_mysql($_POST['txt_ven_valven']),//tb_venta_gra
            0,//tb_venta_ina
            moneda_mysql($_POST['txt_ven_opeexo']),//tb_venta_exo
            moneda_mysql($_POST['txt_ven_opegra']),//tb_venta_grat
            0,//tb_venta_isc
            moneda_mysql($_POST['txt_ven_otrtri']),
            moneda_mysql($_POST['txt_ven_otrcar']),
            moneda_mysql($_POST['txt_ven_desglob']),//tb_venta_desglo
            1,//cs_tipooperacion_id
            0,//cs_documentosrelacionados_id
            $usu_id,
            $tipo_venta,
            $dtipo
        );

		//ultima venta
			$dts=$oVenta->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$ven_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

        if ($_POST['cmb_forpag_id'] == 4) {
            $pagado=0;
        }else{
            $pagado=1;
        }

        $pas_id=$_POST['hdd_ven_pas_id'];
        if($pas_id==""){
            $pas_id=$_POST['hdd_ven_cli_id'];
        }


        //REGISTRO VIAJE
        if($_POST['hdd_tipo']=='encomienda'){
            $oVenta->insertarEncomiendaVenta(
                $ven_id,
                $_POST['hdd_vi_ho'],
                $_POST['hdd_ven_rem_id'],
                $_POST['txt_ven_des_nom'],
                $_POST['cmb_salida_id'],
                $_POST['cmb_llegada_id'],
                $_POST['txt_clave'],
                $pagado
            );
        }else{
            $oVenta->insertarViajeVenta(
                $ven_id,
                $_POST['hdd_vi_ho_id'],
                $_POST['txt_num_asi'],
                fecha_mysql($_POST['txt_fech_sal']),
                $pas_id,
                $_POST['viaje_parada']
            );

            $oAsientoestado->eliminar($_POST['hdd_vi_ho_id'],$_POST['txt_num_asi']);


            if ($_POST['viaje_parada']>0){
                $oVenta->insertarAsientoEstado(
                    $_POST['txt_num_asi'],
                    $_POST['hdd_vi_ho_id'],
                    $_POST['viaje_parada']
                );
            }else{
                $oVenta->insertarAsientoEstado(
                    $_POST['txt_num_asi'],
                    $_POST['hdd_vi_ho_id'],
                    $_POST['viaje_llegada']
                );
            }
        }

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

            //FORMA DE PAGO POR PAGAR
            if($_POST['cmb_forpag_id']==4)
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
		//detalle de servicios
		if($_POST['detalle_array']==1)
		{			
			$autoin++;

            $cantidad=1;
			//precio de venta ingresado
            $precio_unitario_linea = $_POST['txt_ven_opeexo'];

            $afeigv_id=$_POST['servicio_tip'];
			//precio unitario de venta
            if ($afeigv_id == 1) {
                $valor_unitario_linea = $precio_unitario_linea/(1+$igv_dato);
            }elseif ($afeigv_id == 9){
                $valor_unitario_linea = $precio_unitario_linea;
            }

            $llegada= $_POST['viaje_llegada_text'];
            if($_POST['viaje_parada']>0){$llegada=$_POST['viaje_parada_text'];}
			$nom = "PASAJE " . $_POST['viaje_partida_text']. ' - '.  $llegada;

			//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
			$tipdes = 0;
            $descuento_numero_linea = 0;
            $descuento_porcentaje_linea = $descuento_numero_linea/100;
			//descuento en porcentaje

            $valor_venta_bruto_linea=$valor_unitario_linea*$cantidad;

            //igv
            $descuento_x_item_linea = $valor_venta_bruto_linea*$descuento_porcentaje_linea;
            $valor_venta_x_item_linea = $valor_venta_bruto_linea-$descuento_x_item_linea;

            $igv_linea=$valor_venta_x_item_linea*$igv_dato;
			
			$tipo_venta=2;
			$cat_id=0;
			$unimed_id=13;//ZZ

			//////////////////////
			//registro detalle de venta de servicio

			$oVenta->insertar_detalle( 
				$tipo_venta,
				$cat_id,  
				$indice,
				$nom,
                $precio_unitario_linea,
                $cantidad,
				$tipdes,
                $descuento_x_item_linea,
				$valor_unitario_linea,
                $valor_venta_x_item_linea,
                0,//igv
				$ven_id,
				$afeigv_id,
				$unimed_id,
				$calisc,
				$det_isc,
				$autoin,
                $pro_ser
			);
        }
		
	  }//fin diferente de aunalada

		$data['ven_id']=$ven_id;
		if($_POST['chk_imprimir']==1)$data['ven_act']='imprime';


		if($documento_ele==1)
		{
			if($documento_cod==1 or $documento_cod==3)$data['ven_sun']='enviar';
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

?>