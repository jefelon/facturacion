<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/formato.php");

$dts1=$oVenta->mostrar_filtro($_SESSION['empresa_id'],fecha_mysql($_POST['hdd_resbol_fec']));
$num = mysql_num_rows($dts1);

$num = 0;
while($dt1 = mysql_fetch_array($dts1))
{
	$dts2=$oVenta->comparar_resumenboleta_detalle($dt1['tb_venta_id']);
	$d=mysql_num_rows($dts2);

	if($d==0)
    {
    	$num++;
    }

    if($d==1)
    {
      if($dt1['tb_venta_est']=='CANCELADA')$dec++;
      if($dt1['tb_venta_est']=='ANULADA')$num++;
    }
    if($d==2)
    {

    }

    mysql_free_result($dts2);
}
mysql_free_result($dts1);

if($num>0)
{
	$fecref = fecha_mysql($_POST['hdd_resbol_fec']);
	$fec=date('Y-m-d');//fecha generacion

	$dts = $oVenta->ultimo_numero($fec);
	$dt = mysql_fetch_array($dts);
	$num = $dt['ultimo_numero'] + 1;
	mysql_free_result($dts);
	
	$cod = 'RC-'.str_replace('-','',$fec).'-'.str_pad($num, 3, "0", STR_PAD_LEFT);
	
	$oVenta->guardar_resumenboleta($_SESSION['usuario_id'],$fec,$fecref,$cod,$num);

	$dts=$oVenta->ultimoInsert();
	$dt = mysql_fetch_array($dts);
		$resbol_id=$dt['last_insert_id()'];
	mysql_free_result($dts);


	$dts1=$oVenta->mostrar_filtro($_SESSION['empresa_id'],fecha_mysql($_POST['hdd_resbol_fec']));
	$num_rows= mysql_num_rows($dts1);

	$item=0;
	while ($dt1 = mysql_fetch_array($dts1))
	{
		$estado="";
		$insertar=0;

		$dts2=$oVenta->comparar_resumenboleta_detalle($dt1['tb_venta_id']);
		$d=mysql_num_rows($dts2);
		if($d==0)
        {
          $item++;
	      $estado=1;
	      $insertar=1;
        }
		if($d==1)
	    {
	      	if($dt1['tb_venta_est']=='CANCELADA')$declarados++;
	      	if($dt1['tb_venta_est']=='ANULADA')
	      	{
	      		$item++;
	      		$estado=3;
	      		$insertar=1;
	    	}
	    }
	    if($d==2)
        {
        
        }

	    mysql_free_result($dts2);
     

	    if($insertar==1)
	    {
	    	//sumatorias
			$opegra=($dt1['tb_venta_gra']*$dt1['tb_venta_tipcam']);
	        $igv=($dt1['tb_venta_igv']*$dt1['tb_venta_tipcam']);
	        $imptot=($dt1['tb_venta_tot']*$dt1['tb_venta_tipcam']);


	        $tipdoc_id=$dt1['cs_tipodocumento_id'];
	        $ser=$dt1['tb_venta_ser'];
	        $cor=$dt1['tb_venta_num'];

	        $cli_id=$dt1['tb_cliente_id'];

	        $tipmon_id=$dt1['cs_tipomoneda_id'];

	        $ven_id =$dt1['tb_venta_id'];

	        $oVenta->guardar_resumenboleta_detalle($resbol_id,$item,$tipdoc_id,$ser,$cor,$cli_id,$tipdocrel,$docrelser,$docrelcor,$tipmon_id,$opegra,$opeexo,$opeina,$otrcar,$isc,$igv,$imptot,$ven_id,$estado);
	    }
	
	    //solo envia 500 por lote
	    if($item==500)break;

	}
	mysql_free_result($dts1);


	$data['msj']="Registrado $cod Correctamente. N° Filas $item.";
	
}
else
{
	$data['msj']='No existe Comprobantes para declarar.';
}

echo json_encode($data);
?>