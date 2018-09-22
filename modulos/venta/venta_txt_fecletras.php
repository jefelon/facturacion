<?php
require_once ("../../config/Cado.php");
require_once ("../formatos/mysql.php");
$oMysql= new cMysql();
require_once ("../formatos/formato.php");

if($_POST['ven_fec']>=0 && $_POST['ven_mes']>=0)
{
	$fecha=$oMysql->DATE_ADD(fecha_mysql($_POST['ven_fec']),$_POST['ven_mes'],"MONTH");
	$data['fecha']=mostrarFecha($fecha);
}
else
{
	$data['fecha']='-';
}
//$data['fecha']="n";
echo json_encode($data);
?>