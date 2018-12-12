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


$_POST['ven_id'];
echo 'aqui';
header("location: ../modulos/venta/venta_vista_adm.php");

?>