<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../cajaobs/cCajaobs.php");

function caja_cierre($caja,$fecha){
	$oCajaobs = new cCajaobs();

	$rws= $oCajaobs->verificar_cierre_caja($_SESSION['empresa_id'],$caja,$fecha);
    $rw = mysql_fetch_array($rws);
      $estado    =$rw['tb_cajaobs_est'];
    mysql_free_result($rws);

    //1 abierta, 2 cerrada
    if($estado=="")$estado=1;

    return $estado;
}
?>