<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 17/12/2019
 * Time: 18:41
 */
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../asiento/cAsiento.php");
$oAsiento = new cAsiento();

require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();

require_once ("../formatos/formato.php");

$fecha_salida=fecha_mysql($_POST['cmb_fech_sal']);
$hora_salida=$_POST['cmb_horario'];
$num_asi=$_POST['num_asi'];
$cli_doc= $_POST['txt_cli_doc'];

$dtsCli = $oCliente->mostrarUnoDoc($cli_doc);
$dtcli = mysql_fetch_array($dtsCli);
$cli_id=$dtcli['tb_cliente_id'];

$asts = $oAsiento->estadoReserva($num_asi,$_POST['veh_id'],$fecha_salida,$hora_salida);
$ast = mysql_fetch_array($asts);
$estado="";
if ($ast['tb_asientoestado_id'] && $ast['tb_clientereserva_id']!=$cli_id){
    if($ast['tb_asientoestado_reserva']==1){
       $estado='reserva';
       $msj='El asiento está reservado.';
    }else{
        $estado='ocupado';
        $msj='El asiento está ocupado.';
    }
}
else{
    $estado='libre';
    $msj='El asiento libre.';
}
$data['estado']=$estado;
$data['as_msj']=$msj;
echo json_encode($data);