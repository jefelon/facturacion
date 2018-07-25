<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();

require_once("../formatos/formato.php");

require_once ("cTraspaso.php");
$oTraspaso = new cTraspaso();

require_once("../producto/cStock.php");
$oStock = new cStock();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();

$dts= $oTraspaso->mostrarUno($_POST['tra_id']);
$dt = mysql_fetch_array($dts);
	$fec		=mostrarFecha($dt['tb_traspaso_fec']);
	$doc_id		=$dt['tb_documento_id'];
	$cod		=$dt['tb_traspaso_cod'];
	$alm_id_ori	=$dt['tb_almacen_id_ori'];
	$alm_id_des	=$dt['tb_almacen_id_des'];
	$ref=$dt['tb_traspaso_ref'];
	$act	=$dt['tb_traspaso_act'];

mysql_free_result($dts);


if($act!='0')
{
	$error_anular=0;
	//verificar stock de almacén destino para reponer a alm origen
	$dts1=$oTraspaso->mostrar_traspaso_detalle($_POST['tra_id']);
	$num_rows= mysql_num_rows($dts1);
	//detalle de productos
	while($dt1 = mysql_fetch_array($dts1))
	{
		//STOCK ALMACEN DESTINO
		$cat_id					=$dt1['tb_catalogo_id'];
		$tradet_can_des	=$dt1['tb_traspasodetalle_can'];
	
		//datos presentacion catalogo almacen
		$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id,$alm_id_des);
		$dt = mysql_fetch_array($dts);
			$sto_id_des		=$dt['tb_stock_id'];
			$sto_num_des	=$dt['tb_stock_num'];
			$mul_des			=$dt['tb_catalogo_mul'];
		mysql_free_result($dts);
		
		//conversion a la minima unidad
		$cantidad_des=$tradet_can_des*$mul_des;
		$stock_nuevo_des=$sto_num_des-$cantidad_des;
		
		if($stock_nuevo_des<0){
			$error_anular=1;
			break;
		}
	}	
	mysql_free_result($dts1);


	if($error_anular==0)
	{	
		$activo='0';
		$oTraspaso->modificar_act(
			$_POST['tra_id'],
			$activo
		);
		
		$dts1=$oTraspaso->mostrar_traspaso_detalle($_POST['tra_id']);
		$num_rows= mysql_num_rows($dts1);

		//detalle de productos
		while($dt1 = mysql_fetch_array($dts1))
		{
			//STOCK ALMACEN ORIGEN
			$cat_id					=$dt1['tb_catalogo_id'];
			$tradet_can_ori	=$dt1['tb_traspasodetalle_can'];
		
			//datos presentacion catalogo almacen
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id,$alm_id_ori);
			$dt = mysql_fetch_array($dts);
				$sto_id_ori		=$dt['tb_stock_id'];
				$sto_num_ori	=$dt['tb_stock_num'];
				$mul_ori		=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);
			
			//conversion a la minima unidad
			$cantidad_ori=$tradet_can_ori*$mul_ori;
					
			//actualizacion de stock
			$stock_nuevo_ori=$sto_num_ori+$cantidad_ori;
			$dts=$oStock->modificar($sto_id_ori,$stock_nuevo_ori);
			
			//----------------------------------------------------------------------
			//STOCK ALMACEN DESTINO
			$cat_id					=$dt1['tb_catalogo_id'];
			$tradet_can_des	=$dt1['tb_traspasodetalle_can'];
		
			//datos presentacion catalogo almacen
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id,$alm_id_des);
			$dt = mysql_fetch_array($dts);
				$sto_id_des		=$dt['tb_stock_id'];
				$sto_num_des	=$dt['tb_stock_num'];
				$mul_des			=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);
			
			//conversion a la minima unidad
			$cantidad_des=$tradet_can_des*$mul_des;
					
			//actualizacion de stock
			$stock_nuevo_des=$sto_num_des-$cantidad_des;
			$dts=$oStock->modificar($sto_id_des,$stock_nuevo_des);
				
		}
		mysql_free_result($dts1);
		

		//anularkardex ingreso
		//($tiporeg,$tipo,$documento_id,$tipoperacion_id,$operacion_id)
		$dts= $oKardex->consulta_eliminar(1,1,6,4,$_POST['tra_id']);
		$dt = mysql_fetch_array($dts);
			$kar_id	=$dt['tb_kardex_id'];
		mysql_free_result($dts);
		if($kar_id>0)
		{
			$oKardex->modificar_campo($kar_id,'xac','0');
			$msj_n='';
		}
		else
		{
			$msj_n='No se pudo eliminar Kardex ingreso.';
		}
		
		//----------------------------------------

		//anularkardex salida
		//($tiporeg,$tipo,$documento_id,$tipoperacion_id,$operacion_id)
		$dts= $oKardex->consulta_eliminar(1,2,6,4,$_POST['tra_id']);
		$dt = mysql_fetch_array($dts);
			$kar_id	=$dt['tb_kardex_id'];
		mysql_free_result($dts);
		if($kar_id>0)
		{
			$oKardex->modificar_campo($kar_id,'xac','0');
			$msj_n='';
		}
		else
		{
			$msj_n='No se pudo eliminar Kardex salida.';
		}
		//----------------------------------------
		//_________________________________________
		$error1=0;
		$data['act']='correcto';
		$data['msj'].='Se anuló transferencia correctamente.'.$msj_n;
		echo json_encode($data);
	
	}
	else
	{
		$data['msj'].='Estock insuficiente de algun(os) producto(os) de Alm. Destino, no se puede anular.';
		echo json_encode($data);
	}

}//estado cancelada
else
{
	$data['msj'].='Transferencia ya ha sido anulada.';
	echo json_encode($data);
}
?>