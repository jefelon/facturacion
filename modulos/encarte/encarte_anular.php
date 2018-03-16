<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../formatos/formato.php");

require_once ("cEncarte.php");
$oEncarte = new cEncarte();
	

$dts= $oEncarte->mostrarUno($_POST['enc_id']);
	$dt = mysql_fetch_array($dts);
		$fecini	=mostrarFecha($dt['tb_encarte_fecini']);
		$fecfin	=mostrarFecha($dt['tb_encarte_fecfin']);

		$des	=$dt['tb_encarte_des'];
		$despor	=$dt['tb_encarte_despor'];

		$est	=$dt['tb_encarte_est'];
	mysql_free_result($dts);

if($est=='ACTIVO')
{

	$dts1=$oEncarte->mostrar_encarte_detalle($_POST['enc_id']);
	$num_rows= mysql_num_rows($dts1);
	
	if($num_rows>=1)
	{
		while($dt1 = mysql_fetch_array($dts1))
		{	
			$cat_id	=$dt1['tb_catalogo_id'];
			$cos		=$dt1['tb_encartedetalle_cos'];
			$uti1		=$dt1['tb_encartedetalle_uti1'];
			$preven1=$dt1['tb_encartedetalle_preven1'];
			
			//actualizacion de precios
			//$dts= $oCatalogoproducto->actualizar_precio_venta($cat_id,$uti1,$preven1);
			//$dts= $oCatalogoproducto->actualizar_precio_costo($cat_id,$cos);
					
		}//fin while
	}//fin if rows
	mysql_free_result($dts1);
	
	//estado de necarte INACTIVO
	$est='INACTIVO';
	$dts= $oEncarte->modificar_estado($_POST['enc_id'],$est);
			
	$data['msj'].='Encarte INACTIVO correctamente.';
	echo json_encode($data);

}//estado cancelada
else
{
	$data['msj'].='Encarte ya está INACTIVO.';
	echo json_encode($data);
}
?>