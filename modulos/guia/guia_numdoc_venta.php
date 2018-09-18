<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 17/09/2018
 * Time: 21:05
 */
require_once ("../../config/Cado.php");
require_once("../venta/cVenta.php");
$oVenta = new cVenta();
require_once("../venta/cVentapago.php");
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

require_once("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();

require_once("../formatos/formato.php");


        $dts = $oVenta->mostrarUno(24);
        while ($dt = mysql_fetch_array($dts)) {

            $idcomprobante = $dt["cs_tipodocumento_cod"];

            $ser = $dt["tb_venta_ser"];
            $num = $dt["tb_venta_num"];
//            if($dt["cs_tipomoneda_id"]==1)
//            {
//                $mon="PEN";
//                $monval=1;
//            }
//            if($dt["cs_tipomoneda_id"]==2)
//            {
//                $mon="USD";
//                $monval=2;
//            }
//
//            $fechadoc=$dt["tb_venta_fec"];
//
//            $identidad=$dt["tb_cliente_doc"];
//            if($dt["tb_cliente_tip"]==1)$idtipodni=1;
//            if($dt["tb_cliente_tip"]==2)$idtipodni=6;
//            $razon=$dt["tb_cliente_nom"];
//
//
//            $valven=$dt["tb_venta_valven"];
//            $des=$dt["tb_venta_des"];
//            $igv=$dt["tb_venta_igv"];
//            $tot=$dt["tb_venta_tot"];
//
//            $gra=$dt["tb_venta_gra"];
//            $ina=$dt["tb_venta_ina"];
//            $exo=$dt["tb_venta_exo"];
//            $grat=$dt["tb_venta_grat"];
//            $isc=$dt["tb_venta_isc"];
//            $otrtri=$dt["tb_venta_otrtri"];
//            $otrcar=$dt["tb_venta_otrcar"];
//            $desglo=$dt["tb_venta_desglo"];
//
//
//            $idtoperacion=$dt["cs_tipooperacion_id"];
//
//            $numpla=$dt["tb_venta_lab1"];

            $data['ven_numdoc'] = $ser . '-' . $num;
            $data['ven_id'] = 24;

            $data['msj'] = 'Encontrado';
            echo json_encode($data);
            mysql_free_result($dts);
        }