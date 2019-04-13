<?php
require_once ("../../config/Cado.php");
require_once ("../formatos/mysql.php");
$oMysql= new cMysql();
require_once ("../formatos/formato.php");

if($_POST['venpag_numdia']>=0)
{
	$fecha=$oMysql->DATE_ADD(fecha_mysql($_POST['ven_fec']),$_POST['venpag_numdia'],"DAY");
	$data['fecha']=mostrarFecha($fecha);
}
else
{
	$data['fecha']='-';
}
//$data['fecha']="n";
echo json_encode($data);
?>