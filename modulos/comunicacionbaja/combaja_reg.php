<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/formato.php");


$estado='ANULADA';
$dts=$oVenta->mostrar_filtro($_SESSION['empresa_id'],fecha_mysql($_POST['hdd_combaj_fec']),$estado);
$num = 0;
while($dt = mysql_fetch_array($dts))
{
	$dts2=$oVenta->comparar_combaja_detalle($dt['tb_venta_id']);
    if(mysql_num_rows($dts2)>0)
    {

    }
    else
    {
    	$num++;
    }
    mysql_free_result($dts2);
}
mysql_free_result($dts);


if($num>0)
{
	$fecref = fecha_mysql($_POST['hdd_combaj_fec']);
	$fec=date('Y-m-d');//fecha generacion

	$dts = $oVenta->ultimo_numero($fec);
	$dt = mysql_fetch_array($dts);
	$num = $dt['ultimo_numero'] + 1;
	mysql_free_result($dts);
	
	$cod = 'RA-'.str_replace('-','',$fec).'-'.str_pad($num, 3, "0", STR_PAD_LEFT);
	
	$oVenta->guardar_combaja($_SESSION['usuario_id'],$fec,$fecref,$cod,$num);

	$dts=$oVenta->ultimoInsert();
	$dt = mysql_fetch_array($dts);
	$baja_id=$dt['last_insert_id()'];
	mysql_free_result($dts);


	$estado='ANULADA';
	$dts=$oVenta->mostrar_filtro($_SESSION['empresa_id'],fecha_mysql($_POST['hdd_combaj_fec']),$estado);
	$num_rows= mysql_num_rows($dts);
	
	$item=0;
	while($dt = mysql_fetch_array($dts))
	{
		$dts2=$oVenta->comparar_combaja_detalle($dt['tb_venta_id']);
	    if(mysql_num_rows($dts2)>0)
	    {

	    }
	    else
	    {
	    	$item++;
	    	$idcom	=$dt['cs_tipodocumento_id'];
			$ser 	=$dt['tb_venta_ser'];
			$numdoc =$dt['tb_venta_num'];
			$mot 	=$_POST['txt_combaj_mot'];
			$ven_id =$dt['tb_venta_id'];

			$oVenta->guardar_combaja_detalle($baja_id,$item,$idcom,$ser,$numdoc,$mot,$ven_id);
	    }
	    mysql_free_result($dts2);
	}
	mysql_free_result($dts);

	$data['msj']="Registrado $cod Correctamente. N° Comprobantes $num.";
	
}
else
{
	$data['msj']='Comprobantes ya declarados o no existe ninguno para declarar.';
}

echo json_encode($data);

?>