<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once("../formatos/formato.php");



if($_POST['action_clientecuenta']=="insertar_pago")
{

    $cli_id = $_POST['hdd_cli_id'];
    $emp_id=$_SESSION['empresa_id'];

    $clicus = $oClientecuenta->mostrar_cuenta_por_cliente($cli_id, $emp_id);

    $cuecli_tipreg=2;//manual
    $r_clicue_tip=2;
    $est=0;
    $xac=1;

    while ($cliclu = mysql_fetch_array($clicus)) {
        if ($cliclu['tb_clientecuenta_est']==2 or $cliclu['tb_clientecuenta_est']==3){
        $forpag_id = $cliclu['tb_formapago_id'];
        $modpag_id = $cliclu['tb_modopago_id'];
        $ventip = $cliclu['tb_clientecuenta_ventip'];
        $ven_id = $cliclu['tb_clientecuenta_ven_id'];
        $cuenta_clicue_mon = $cliclu['tb_clientecuenta_mon'];
        $clicue_idp = $cliclu['tb_clientecuenta_id'];
        $oClientecuenta->modificar_estado($cliclu['tb_clientecuenta_id'],1);
        if (!empty($ventip)) {
            //TIPO DE VENTA
            if ($ventip == 1)//venta
            {
                //datos de venta
                $dts = $oVenta->mostrarUno($ven_id);
                $dt = mysql_fetch_array($dts);
                $ven_fec = mostrarFecha($dt['tb_venta_fec']);

                $doc_id = $dt['tb_documento_id'];
                $ven_numdoc = $dt['tb_venta_numdoc'];
                //$cli_id	=$dt['tb_cliente_id'];
                //$cli_nom = $dt['tb_cliente_nom'];
                //$cli_doc = $dt['tb_cliente_doc'];
                //$cli_dir = $dt['tb_cliente_dir'];
                //$subtot	=$dt['tb_venta_subtot'];
                //$igv	=$dt['tb_venta_igv'];
                $ven_tot = $dt['tb_venta_tot'];
                //$est	=$dt['tb_venta_est'];

                //$lab1	=$dt['tb_venta_lab1'];
                mysql_free_result($dts);

                $texto_titulo = 'VENTA';
            }

            if ($ventip == 2)//nota venta
            {
                //datos de nota venta
                $dts = $oVentanota->mostrarUno($ven_id);
                $dt = mysql_fetch_array($dts);
                $ven_fec = mostrarFecha($dt['tb_venta_fec']);

                $doc_id = $dt['tb_documento_id'];
                $ven_numdoc = $dt['tb_venta_numdoc'];
                //$cli_id	=$dt['tb_cliente_id'];
                //$cli_nom = $dt['tb_cliente_nom'];
                //$cli_doc = $dt['tb_cliente_doc'];
                //$cli_dir = $dt['tb_cliente_dir'];
                //$subtot	=$dt['tb_venta_subtot'];
                //$igv	=$dt['tb_venta_igv'];
                $ven_tot = $dt['tb_venta_tot'];
                //$est	=$dt['tb_venta_est'];

                //$lab1	=$dt['tb_venta_lab1'];
                mysql_free_result($dts);

                $texto_titulo = 'NOTA VENTA';

            }

            switch ($forpag_id) {
                case 1:
                    $forma_pago = 'CONTADO';
                    break;
                case 2:
                    $forma_pago = 'CREDITO';
                    break;
            }

            switch ($modpag_id) {
                case 1:
                    $modo_pago = 'EFECTIVO';
                    break;
                case 2:
                    $modo_pago = 'DEPOSITO';
                    break;
                case 3:
                    $modo_pago = 'TARJETA';
                    break;
            }

            $dts = $oDocumento->mostrarUno($doc_id);
            $dt = mysql_fetch_array($dts);
            $doc_abr = $dt['tb_documento_abr'];
            mysql_free_result($dts);
            $r_clicue_glo = "PAGO $texto_titulo $doc_abr $ven_numdoc | $forma_pago $modo_pago.";


            //pagos realizados
            $tipo = 2;
            $tipo_registro = 2;
            $total_pagado = 0;
            $dts = $oClientecuenta->mostrar_por_cuenta($clicue_idp, $tipo, $tipo_registro);
            while ($dt = mysql_fetch_array($dts)) {
                $total_pagado += $dt['tb_clientecuenta_mon'];
            }
            mysql_free_result($dts);

            //saldo a pagar
            $saldo_pagar = $cuenta_clicue_mon - $total_pagado;

            $oClientecuenta->insertar(
                $xac,
                $cuecli_tipreg,
                fecha_mysql($_POST['txt_clicue_fec']),
                $r_clicue_glo,//fatla
                $r_clicue_tip,
                moneda_mysql($saldo_pagar),//falta
                $est,
                $cliclu['tb_clientecuenta_tip'],
                $cliclu['tb_clientecuenta_ven_id'],
                $_POST['cmb_forpag_id'],
                $_POST['cmb_modpag_id'],
                $_POST['cmb_cuecor_id'],
                $_POST['cmb_tar_id'],
                $_POST['txt_venpag_numope'],
                $_POST['hdd_clicue_numdia'],
                $fecven,
                $cli_id,
                $_POST['hdd_clicue_ver'],
                $clicue_idp,
                $_SESSION['usuario_id'],
                $emp_id
            );

            $dts = $oClientecuenta->ultimoInsert();
            $dt = mysql_fetch_array($dts);
            $clicue_id = $dt['last_insert_id()'];
            mysql_free_result($dts);

            //consulta venta
            $dts = $oVenta->mostrarUno($cliclu['tb_clientecuenta_ven_id']);
            $dt = mysql_fetch_array($dts);
            $reg = mostrarFechaHora($dt['tb_venta_reg']);

            $fec = mostrarFecha($dt['tb_venta_fec']);

            $doc_id = $dt['tb_documento_id'];
            $numdoc = $dt['tb_venta_numdoc'];
            $cli_id = $dt['tb_cliente_id'];
            $cli_nom = $dt['tb_cliente_nom'];
            $cli_doc = $dt['tb_cliente_doc'];
            $cli_dir = $dt['tb_cliente_dir'];
            $cli_tip = $dt['tb_cliente_tip'];

            $subtot = $dt['tb_venta_subtot'];
            $igv = $dt['tb_venta_igv'];
            $tot = $dt['tb_venta_tot'];
            $est = $dt['tb_venta_est'];

            $punven_id = $dt['tb_puntoventa_id'];
            $punven_nom = $dt['tb_puntoventa_nom'];
            $alm_nom = $dt['tb_almacen_nom'];

            $lab1 = $dt['tb_venta_lab1'];

            $may = $dt['tb_venta_may'];
            mysql_free_result($dts);

            //documento
            $dts = $oDocumento->mostrarUno($doc_id);
            $dt = mysql_fetch_array($dts);
            $documento = $dt['tb_documento_abr'];
            mysql_free_result($dts);

            $modo_pago = "EFECTIVO";

            if ($punven_id > 0) {
                $dts = $oPuntoventa->mostrarUno($punven_id);
                $dt = mysql_fetch_array($dts);
                $caj_id = $dt['tb_caja_id'];
                mysql_free_result($dts);
            }

            //INGRESO CAJA
            $xac = 1;
            $ing_det = "VENTA $documento $numdoc | PAGO: $modo_pago";
            $ing_est = '1';
            $ing_cue_id = 22;
            if ($emp_id == 1) $ing_subcue_id = 157;
            //$ing_subcue_id=0;
            //$caj_id=1;
            $mon_id = 1;
            $tra_id = 0;

            $oIngreso->insertar(
                $_SESSION['usuario_id'],
                $_SESSION['usuario_id'],
                $xac,
                fecha_mysql($_POST['txt_clicue_fec']),
                $doc_id,
                $numdoc,
                $ing_det,
                moneda_mysql($saldo_pagar),
                $ing_est,
                $ing_cue_id,
                $ing_subcue_id,
                $cli_id,
                $caj_id,
                $mon_id,
                $cliclu['tb_clientecuenta_ven_id'],
                $tra_id,
                $emp_id
            );

        } else {
            echo 'Intentelo nuevamente';
        }
    }
    }
    $data['clicue_msj'] = "Se registró los pagos correctamente.";
    echo json_encode($data);

}

?>