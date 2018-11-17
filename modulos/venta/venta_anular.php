<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../formatos/formato.php");

require_once ("cVenta.php");
$oVenta = new cVenta();
require_once("../producto/cStock.php");
$oStock = new cStock();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once("../clientecuenta/cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../lote/cLote.php");
$oLote = new cLote();
require_once ("../lote/cVentaDetalleLote.php");
$oVentaDetalleLote = new cVentaDetalleLote();


$dts= $oVenta->mostrarUno($_POST['ven_id']);
$dt = mysql_fetch_array($dts);
	$fec	=mostrarFecha($dt['tb_venta_fec']);
	$doc_id	=$dt['tb_documento_id'];
	$numdoc	=$dt['tb_venta_numdoc'];
	$cli_id	=$dt['tb_cliente_id'];
	$valven	=$dt['tb_venta_valven'];
	$igv	=$dt['tb_venta_igv'];
	$tot	=$dt['tb_venta_tot'];
	$est	=$dt['tb_venta_est'];

	$lab1	=$dt['tb_venta_lab1'];
	
	$punven_id	=$dt['tb_puntoventa_id'];
	$punven_nom	=$dt['tb_puntoventa_nom'];
	
	$alm_id=$dt['tb_almacen_id'];
mysql_free_result($dts);


if($est!='ANULADA')
{
	$estado='ANULADA';
	$oVenta->modificar(
		$_POST['ven_id'],
		fecha_mysql($fec),
		$cli_id,
		$estado,
		$lab1
	);
	
	$dts1=$oVenta->mostrar_venta_detalle($_POST['ven_id']);
	$num_rows= mysql_num_rows($dts1);


	//detalle de productos
		while($dt1 = mysql_fetch_array($dts1))
		{
			$cat_id=$dt1['tb_catalogo_id'];
			$cantidad=$dt1['tb_ventadetalle_can'];
            $ven_det_id=$dt1['tb_ventadetalle_id'];

            //datos presentacion catalogo almacen
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id,$alm_id);
			$dt = mysql_fetch_array($dts);
				$sto_id_ori		=$dt['tb_stock_id'];
				$sto_num_ori	=$dt['tb_stock_num'];
				$mul_ori		=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);
			
			//conversion a la minima unidad
			$cantidad_ori=$cantidad*$mul_ori;
			
			//actualizacion de stock producto
			$stock_nuevo_ori=$sto_num_ori+$cantidad_ori;
			$dts=$oStock->modificar($sto_id_ori,$stock_nuevo_ori);

			//actualizacion stock lote
            $dts22=$oVentaDetalleLote->mostrar_filtro_venta_detalle($ven_det_id);
            $num_rows22= mysql_num_rows($dts22);

            while($dt22 = mysql_fetch_array($dts22)) {
                $lote_num=$dt22['tb_ventadetalle_lotenum'];
                $lote_cant=$dt22['tb_ventadetalle_exisact'];
                //actualizamos lotes
                $lts = $oLote->mostrarUnoLoteNumero($cat_id, $lote_num, $alm_id);
                $lt = mysql_fetch_array($lts);
                $nro_rows = mysql_num_rows($lts);
                if ($nro_rows > 0) {
                    $nuevo_stock = $lt['tb_lote_exisact'] + $lote_cant;
                    $oLote->modificar_stock($cat_id, $lote_num, $alm_id, $nuevo_stock);
                }
            }
        }
	
	mysql_free_result($dts1);
	
	//anular kardex
	//($tiporeg,$tipo,$documento_id,$tipoperacion_id,$operacion_id)
	$dts= $oKardex->consulta_eliminar(1,2,$doc_id,3,$_POST['ven_id']);
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
		$msj_n='No se pudo anular kardex.';
	}
	//----------------------------------------
	
	//anular cuenta cliente --------------
	$tipven=1;//1 venta, 2 notaventa
	$dts= $oClientecuenta->mostrar_por_tipo_venta($tipven,$_POST['ven_id'],0,0);
	while($dt = mysql_fetch_array($dts))
	{
		$clicue_id	=$dt['tb_clientecuenta_id'];
		$oClientecuenta->modificar_campo($clicue_id,'xac','0');
	}
	mysql_free_result($dts);

	//ANULAR INGRESO DE CAJA
    $estado="'1','2'";
    $mod_id=1;
    $rws1=$oIngreso->mostrar_por_modulo($mod_id,$_POST['ven_id'],$estado);
    $filas= mysql_num_rows($rws1);
    while($rw1 = mysql_fetch_array($rws1))
    {
      $oIngreso->modificar_campo($rw1['tb_ingreso_id'],$_SESSION['usuario_id'],'xac','0');
    }
    mysql_free_result($rws1);

	//_________________________________________
	$error1=0;
	$data['act']='correcto';
	$data['msj'].='Se anuló venta correctamente.'.$msj_n;
	echo json_encode($data);


}//estado cancelada
else
{
	$data['msj'].='Venta ya ha sido anulada.';
	echo json_encode($data);
}
?>