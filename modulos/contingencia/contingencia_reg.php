<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/formato.php");


$dts1=$oVenta->mostrar_filtro_adm(fecha_mysql($_POST['hdd_con_fec']),fecha_mysql($_POST['hdd_con_fec']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id'],$_POST['chk_fil_ven_may']);
$num_rows = mysql_num_rows($dts1);

if($num_rows>0)
{
	$fecref = $_POST['hdd_con_fec'];
	$fec=date('Y-m-d');//fecha generacion

	$dts = $oVenta->ultimo_numero($fec);
	$dt = mysql_fetch_array($dts);
	$numero = $dt['ultimo_numero'] + 1;
	mysql_free_result($dts);

	$ruc="20479676861";
	$cod = $ruc.'-RF-'.str_replace('-','',$fecref).'-'.str_pad($numero, 2, "0", STR_PAD_LEFT);

	$mot= $_POST['cmb_con_mot'];

	while($dt1 = mysql_fetch_array($dts1))
    {
    	$lin++;

    	$idcomprobante=$dt1["cs_tipodocumento_cod"];
    	$fechadoc=$dt1["tb_venta_fec"];

    	$ser=$dt1['tb_venta_ser'];
    	$num=$dt1['tb_venta_num'];

    	$fin="";//correlativo final

    	$identidad=$dt1["tb_cliente_doc"];
		if($dt1["tb_cliente_tip"]==1)$idtipodni=1;
		if($dt1["tb_cliente_tip"]==2)$idtipodni=6;
		$razon=$dt1["tb_cliente_nom"];

		$valven=$dt1["tb_venta_valven"];
		$des=$dt1["tb_venta_des"];
		$igv=$dt1["tb_venta_igv"];
		$tot=$dt1["tb_venta_tot"];

		$gra=$dt1["tb_venta_gra"];
		$ina=$dt1["tb_venta_ina"];
		$exo=$dt1["tb_venta_exo"];
		$grat=$dt1["tb_venta_grat"];
		$isc=$dt1["tb_venta_isc"];
		$otrtri=$dt1["tb_venta_otrtri"];
		$otrcar=$dt1["tb_venta_otrcar"];
		$desglo=$dt1["tb_venta_desglo"];

    	$linea=$mot."|".$fechadoc."|".$idcomprobante."|".$ser."|".$num."|".$fin."|".$idtipodni."|".$identidad."|".$razon."|".$gra."|".$exo."|".$ina."|".$isc."|".$igv."|".$otrcar."|".$tot."|".$tipcommod."|".$sercommod."|".$numcommod."|";

    	$txt.=$linea."\n";
    }
    mysql_free_result($dts1);

	
	$oVenta->guardar_contingencia($_SESSION['usuario_id'],$fec,fecha_mysql($fecref),$cod,$numero,$mot,$lin,$txt);

	$dts=$oVenta->ultimoInsert();
	$dt = mysql_fetch_array($dts);
	$con_id=$dt['last_insert_id()'];
	mysql_free_result($dts);


	$data['msj']="Registrado $cod Correctamente. N° Filas $lin/$num_rows.";
	
}
else
{
	$data['msj']='No existe Comprobantes para declarar.';
}

echo json_encode($data);
?>