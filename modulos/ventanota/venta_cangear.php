<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../formatos/formato.php");

require_once ("cVentanota.php");
$oVentanota = new cVentanota();
require_once("../producto/cStock.php");
$oStock = new cStock();
require_once ("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();

if($_POST['action']=='cangear')
{
	
	$dts= $oVentanota->mostrarUno($_POST['ven_id']);
$dt = mysql_fetch_array($dts);
	$fec	=mostrarFecha($dt['tb_venta_fec']);
	$doc_id	=$dt['tb_documento_id'];
	$numdoc	=$dt['tb_venta_numdoc'];
	$cli_id	=$dt['tb_cliente_id'];
	$valven	=$dt['tb_venta_valven'];
	$igv	=$dt['tb_venta_igv'];
	$tot	=$dt['tb_venta_tot'];
	$est	=$dt['tb_venta_est'];
	
	$punven_id	=$dt['tb_puntoventa_id'];
	$punven_nom	=$dt['tb_puntoventa_nom'];
mysql_free_result($dts);

	if($_SESSION['puntoventa_id']==$punven_id)
	{
		if($est=='CANCELADA')
		{
			//sesion de la nota de venta
			$_SESSION['vennot_id']=$_POST['ven_id'];
			
		//$almacen=$_SESSION['almacen_id'];
			
			$dts1=$oVentanota->mostrar_venta_detalle_ps($_POST['ven_id']);
			$num_rows= mysql_num_rows($dts1);
			//detalle de productos
				while($dt1 = mysql_fetch_array($dts1))
				{
					$vennot_tipven	=$dt1['tb_ventadetalle_tipven'];
					$cat_id			=$dt1['tb_catalogo_id'];
					$ser_id			=$dt1['tb_servicio_id'];
					$vennot_can		=$dt1['tb_ventadetalle_can'];
					$vennot_preuni	=$dt1['tb_ventadetalle_preuni'];
					$vennot_valven	=$dt1['tb_ventadetalle_valven'];
					$vennot_igv	=$dt1['tb_ventadetalle_igv'];
					
					$vennot_preven=$vennot_valven+$vennot_igv;
					
					//sesion en carrito de venta
					if($vennot_tipven==1)
					{//producto
							
						//IDENTIFICADOR CATALOGO Y CANTIDAD
						$_SESSION['venta_car'][$cat_id]=$vennot_can;
						//PRECIO DE VENTA unitario
						$_SESSION['venta_preven'][$cat_id]=moneda_mysql($vennot_preven)/$vennot_can;
					}
					
					
					if($vennot_tipven==2)
					{//servicio
						//id servicio - cantidad	
						$_SESSION['servicio_car'][$ser_id]=$vennot_can;		
						//id servicio - precio unitario
						$_SESSION['servicio_preven'][$ser_id]=moneda_mysql($vennot_preven)/$vennot_can;
					}
					
					//datos presentacion catalogo almacen
					/*$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id,$almacen);
					$dt = mysql_fetch_array($dts);
						$sto_id_ori		=$dt['tb_stock_id'];
						$sto_num_ori	=$dt['tb_stock_num'];
						$mul_ori		=$dt['tb_catalogo_mul'];
					mysql_free_result($dts);
					
					//conversion a la minima unidad
					$cantidad_ori=$vennot_can*$mul_ori;
					
					//actualizacion de stock
					$stock_nuevo_ori=$sto_num_ori+$cantidad_ori;
					$dts=$oStock->modificar($sto_id_ori,$stock_nuevo_ori);*/
				}
			
			mysql_free_result($dts1);
			
			//elimiar nota de almacen --------------
			/*$dts= $oNotalmacen->consulta_eliminar(1,2,$doc_id,3,$_POST['ven_id']);
			$dt = mysql_fetch_array($dts);
				$notalm_id	=$dt['tb_notalmacen_id'];
			mysql_free_result($dts);
			if($notalm_id>0)
			{
				$oNotalmacen->eliminar_notalmacendetalle($notalm_id);
				$oNotalmacen->eliminar_notalmacen($notalm_id);
				$msj_n='';
			}
			else
			{
				$msj_n=' No se pudo eliminar Nota de Almacen.';
			}*/
			//----------------------------------------
			
			$error1=0;
			$data['act']='correcto';
			//$data['msj'].='Se anuló venta correctamente.'.$msj_n;
			echo json_encode($data);
		
		
		}//estado cancelada
		else
		{
			$data['msj'].='Venta con estado diferente a CANCELADA.';
			echo json_encode($data);
		}
	}
	else
	{
		$data['act2']=0;
		$data['msj']='Por favor seleccione el punto de venta: '.$punven_nom.', desde el menu Opciones.';
		echo json_encode($data);
	}
}

if($_POST['action']=='restablecer')
{
	unset($_SESSION['venta_car']);
	unset($_SESSION['venta_des']);
	unset($_SESSION['venta_tipdes']);
	//unset($_SESSION['venta_igv']);
	unset($_SESSION['venta_preven']);
	unset($_SESSION['presentacion_id']);
	unset($_SESSION['catalogo_mul']);
	unset($_SESSION['venta_descuento']);
	
	unset($_SESSION['servicio_car']);
	unset($_SESSION['servicio_preven']);
	unset($_SESSION['servicio_tipdes']);
	unset($_SESSION['servicio_des']);
	
	unset($_SESSION['vennot_id']);
	
	$data['msj'].='ok';
	echo json_encode($data);
}
?>