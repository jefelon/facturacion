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

require_once ("../../config/Cado.php");
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


require_once ("../cajadetalle/cCajadetalle.php");
$oCajadetalle = new cCajadetalle();


require_once ("../caja/cCaja.php");
$oCaja = new cCaja();

require_once("../formatos/formato.php");

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

if($_POST['action_caja']=="insertar") {
    if (!empty($_POST['txt_mon_inicial'])) {


        //insertamos venta
        $oCajadetalle->insertar(
            $caja_venta,
            fechahora_mysql($_POST['txt_fec_ape']),
            NULL,
            $_POST['txt_mon_inicial'],
            1
        );

        $oCaja->modificar_estado($caja_venta, 1);
        $data['caj_msj']='Se abrio la caja.';
        $_SESSION['caja_estado']=1;
        $data['respuesta']=1;
    }else{
        $data['caj_msj']='Intentelo nuevamente.';
        $data['respuesta']=0;
    }

    echo json_encode($data);
}

if($_POST['action_caja']=="actualizar") {
    if (!empty($_POST['hdd_cajadetalle_id'])) {


        //insertamos venta
        $oCajadetalle->modificar_fec_cierre(
            $_POST['hdd_cajadetalle_id'],
            fechahora_mysql($_POST['txt_fec_cie']),
            0,
            $_POST['txt_mon_cie']
        );

        $oCaja->modificar_estado($caja_venta, 0);
        $data['caj_msj']='Se cerro la caja.';
        $_SESSION['caja_estado']=0;
        $data['respuesta']=1;
    }else{
        $data['caj_msj']='Intentelo nuevamente.';
        $data['respuesta']=0;
    }

    echo json_encode($data);
}


