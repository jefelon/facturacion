<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../talonario/cTalonario.php");
$oTalonario= new cTalonario();
require_once("../venta/cVenta.php");
$oVenta = new cVenta();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../producto/cStock.php");
$oStock = new cStock();
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();


require_once("../formatos/formato.php");

$ven_id = $_POST['ven_id'];
$documento_id = $_POST['cmb_ven_doc'];

if ($_POST['action_venta'] == "insertar") {
    if ($ven_id > 0) {
        $dts=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
        $dt = mysql_fetch_array($dts);
        $caja_venta		=$dt['tb_caja_id'];


        //venta
        $dts = $oVenta->mostrarUno($ven_id);
        $dt = mysql_fetch_array($dts);
        $reg = mostrarFechaHora($dt['tb_venta_reg']);

        $fec = date('Y-m-d');
        $doc_id = $dt['tb_documento_id'];
        
        $documento_tipdoc=2; // 2 boleta, 1 factura
        if($_POST['cmb_ven_doc']==11)
        {
            $documento_tipdoc=1; //factura
        }
        $ven_numdoc = $dt['tb_venta_numdoc'];
        $ven_ser = $dt['tb_venta_ser'];
        $ven_num = $dt['tb_venta_num'];
        $cli_id = $_POST['cli_id'];

        $valven = $dt['tb_venta_valven'];
        $subtot = $dt['tb_venta_subtot'];
        $desglo = $dt['tb_venta_desglo'];
        $igv = $dt['tb_venta_igv'];
        $tot = $dt['tb_venta_tot'];
        $est = $dt['tb_venta_est'];
        $lab1 = $dt['tb_venta_lab1'];
        $lab2 = $dt['tb_venta_lab2'];
        $lab3 = $dt['tb_venta_lab3'];
        $may = $dt['tb_venta_may'];
        $tipomoneda = $dt['cs_tipomoneda_id'];
        $gra = $dt['tb_venta_gra'];
        $exo = $dt['tb_venta_exo'];
        $ina = $dt['tb_venta_ina'];
        $grat = $dt['tb_venta_grat'];
        $isc = $dt['tb_venta_isc'];
        $otrtri = $dt['tb_venta_otrtri'];
        $otrcar = $dt['tb_venta_otrcar'];
        $usu_id = $dt['tb_usuario_id'];


        $est = $dt['tb_venta_est'];

        $punven_id = $dt['tb_puntoventa_id'];
        $alm_id = $dt['tb_almacen_id'];
        $monval = $dt['cs_tipomoneda_id'];

        mysql_free_result($dts);



        //consultamos talonario
        $dts= $oTalonario->correlativo($_SESSION['puntoventa_id'],$documento_id);
        $dt = mysql_fetch_array($dts);
        $tal_id = $dt['tb_talonario_id'];
        $tal_ser = $dt['tb_talonario_ser'];
        $tal_fin = $dt['tb_talonario_fin'];
        $tal_num = $dt['tb_talonario_num'];
        mysql_free_result($dts);

        $numero = $tal_num + 1;
        $largo = strlen($tal_fin);
        $numero = str_pad($numero, $largo, "0", STR_PAD_LEFT);
        $numdoc = $tal_ser . '-' . $numero;


        //actualizamos talonario
        $estado = 'ACTIVO';
        if ($numero == $tal_fin) $estado = 'INACTIVO';
        $rs = $oTalonario->actualizar_correlativo($tal_id, $numero, $estado);


        $oVenta->insertar_tipo_venta(
            $fec,
            $documento_id,
            $numdoc,
            $tal_ser,
            $numero,
            $cli_id,
            moneda_mysql($valven),
            moneda_mysql($igv),
            moneda_mysql($_POST['txt_com_destotal']),
            moneda_mysql($tot),
            $est,
            $lab1,
            $lab2,
            $lab3,
            $may,
            $_SESSION['usuario_id'],
            $punven_id,
            $_SESSION['empresa_id'],

            $documento_tipdoc,//cs_tipodocumento_id
            $tipomoneda,// cs_tipomoneda_id
            moneda_mysql($gra),//tb_venta_gra
            $ina,//tb_venta_ina
            moneda_mysql($exo),//tb_venta_exo
            moneda_mysql($grat),//tb_venta_grat
            $isc,//tb_venta_isc
            moneda_mysql($otrtri),
            moneda_mysql($otrcar),
            moneda_mysql($desglo),//tb_venta_desglo
            1,//cs_tipooperacion_id
            0,//cs_documentosrelacionados_id
            $usu_id,
            3,
            'encomiendapagada'
        );



        //ultimo
        $dts = $oVenta->ultimoInsert();
        $dt = mysql_fetch_array($dts);
        $ven_id = $dt['last_insert_id()'];
        mysql_free_result($dts);


        //registro de kardex
        $xac = 1;
        $tipo_registro = 1;//1 automatico 2 manual
        $kar_tip = 1;//1 entrada 2 salida
        $tipope_id = 11;//3 venta
        $kar_des = 'VENTA';
        $operacion_id = $ven_id;//id de la operacion(modulo compras, ventas, etc)
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
        $dts = $oKardex->ultimoInsert();
        $dt = mysql_fetch_array($dts);
        $kar_id = $dt['last_insert_id()'];
        mysql_free_result($dts);

        $oKardex->modificar_codigo($kar_id, $kar_id);


        //DETALLE DE VENTA

        $dts1 = $oVenta->mostrar_venta_detalle($_POST['ven_id']);
        $num_rows = mysql_num_rows($dts1);
        while ($dt1 = mysql_fetch_array($dts1)) {
            $oVenta->insertar_detalle(
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
                $ven_id,
                $dt1['cs_tipoafectacionigv_id'],
                $dt1['cs_tipounidadmedida_id'],
                $dt1['cs_tiposistemacalculoisc_id'],
                $dt1['tb_ventadetalle_isc'],
                $dt1['tb_ventadetalle_nro']
            );

            //datos presentacion catalogo
            $dts = $oCatalogoproducto->presentacion_catalogo_stock_almacen($dt1['tb_catalogo_id'], $alm_id);
            $dt = mysql_fetch_array($dts);
            $pre_id = $dt['tb_presentacion_id'];
            $sto_id = $dt['tb_stock_id'];
            $sto_num = $dt['tb_stock_num'];
            $mul = $dt['tb_catalogo_mul'];
            mysql_free_result($dts);

            //conversion a la minima unidad
            $cantidad_venta = $dt1['tb_ventadetalle_can'] * $mul;

            //actualizacion de stock
            $stock_nuevo = $sto_num + $cantidad_venta;
            $dts = $oStock->modificar($sto_id, $stock_nuevo);


            //unidad base
            $dts = $oKardex->presentacion_buscar_unidad_base($dt1['tb_presentacion_id']);
            $dt = mysql_fetch_array($dts);
            $cat_id = $dt['tb_catalogo_id'];
            mysql_free_result($dts);

            //registro detalle de kardex
            $costo = 0;
            $precio = moneda_mysql(($dt1['tb_ventadetalle_valven'] + $dt1['tb_ventadetalle_igv']) / $dt1['tb_ventadetalle_can']);

            $oKardex->insertar_detalle(
                $cat_id,
                $cantidad_venta,
                $costo,
                $precio,
                $kar_id
            );
        }
        mysql_free_result($dts1);

        $dts2 = $oVenta->mostrar_venta_detalle_servicio($_POST['ven_id']);
        $num_rows_2 = mysql_num_rows($dts2);
        while ($dt2 = mysql_fetch_array($dts2)) {
            $oVenta->insertar_detalle(
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
                $ven_id,
                $dt2['cs_tipoafectacionigv_id'],
                $dt2['cs_tipounidadmedida_id'],
                $dt2['cs_tiposistemacalculoisc_id'],
                $dt2['tb_ventadetalle_isc'],
                $dt2['tb_ventadetalle_nro']
            );
        }
        mysql_free_result($dts2);


        $oVenta->modificar_encomiendaviaje_pagado($_POST['ven_id']);
        $oVenta->modificar_puntoventa($_POST['ven_id'],$_SESSION['puntoventa_id']);



        //INGRESO CAJA
        $modo_pago='EFECTIVO';
        $xac=1;
        $ing_det="VENTA $documento $numdoc | $modo_pago";
        $ing_est='1';
        $ing_cue_id=22;
        if($_SESSION['empresa_id']==1)$ing_subcue_id=157;
        //$ing_subcue_id=0;
        //$caj_id=1;
        $mon_id=1;
        $mod_id=1;
        $caj_id=$caja_venta;

        $oIngreso->insertar(
            $_SESSION['usuario_id'],
            $_SESSION['usuario_id'],
            $xac,
            $fec,
            $documento_id,
            $numdoc,
            $ing_det,
            moneda_mysql($tot),
            $ing_est,
            $ing_cue_id,
            $ing_subcue_id,
            $_POST['cli_id'],
            $caj_id,
            $mon_id,
            $mod_id,
            $ven_id,
            $_SESSION['empresa_id']
        );


        $data['ven_id'] = $ven_id;
        if ($_POST['chk_imprimir'] == 1) $data['ven_act'] = 'imprime';

        $data['ven_sun'] = 'enviar';

        $data['ven_msj'] = 'Se registró Venta  correctamente.' . $numdoc;
    } else {
        $data['ven_msj'] = 'Intentelo nuevamente.';
    }
    echo json_encode($data);
}

?>
