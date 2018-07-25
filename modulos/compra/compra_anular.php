<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../formatos/formato.php");

require_once ("cCompra.php");
$oCompra = new cCompra();
require_once("../producto/cStock.php");
$oStock = new cStock();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();
	

$dts= $oCompra->mostrarUno($_POST['com_id']);
$dt = mysql_fetch_array($dts);
	$fec	=mostrarFecha($dt['tb_compra_fec']);
	$fecven	=mostrarFecha($dt['tb_compra_fecven']);
	$doc_id	=$dt['tb_documento_id'];
	$numdoc	=$dt['tb_compra_numdoc'];
	$pro_id	=$dt['tb_proveedor_id'];
	$subtot	=$dt['tb_compra_subtot'];
	$des	=$dt['tb_compra_des'];
	$descal	=$dt['tb_compra_descal'];
	$fle	=$dt['tb_compra_fle'];
	$tipfle	=$dt['tb_compra_tipfle'];
	$ajupos	=$dt['tb_compra_ajupos'];
	$ajuneg	=$dt['tb_compra_ajuneg'];
	$valven	=$dt['tb_compra_valven'];
	$igv	=$dt['tb_compra_igv'];
	$tot	=$dt['tb_compra_tot'];
	$alm_id	=$dt['tb_almacen_id'];
	$est	=$dt['tb_compra_est'];
mysql_free_result($dts);

if($est!='ANULADA')
{

$almacen=$alm_id;

$dts1=$oCompra->mostrar_compra_detalle($_POST['com_id']);
$num_rows= mysql_num_rows($dts1);

if($num_rows>=1)
{
	while($dt1 = mysql_fetch_array($dts1))
	{	
		$cat_id1	=$dt1['tb_catalogo_id'];
		$cantidad	=$dt1['tb_compradetalle_can'];
		$dt1['tb_unidad_nom'];
		$dt1['tb_unidad_abr'];	
			
		//presentacion catalogo
		$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id1,$almacen);
		$dt = mysql_fetch_array($dts);
			$pro_nom=$dt['tb_producto_nom'];
			$pre_nom=$dt['tb_presentacion_nom'];
			$pre_id	=$dt['tb_presentacion_id'];
			$sto_num=$dt['tb_stock_num'];
			$cat_mul=$dt['tb_catalogo_mul'];
			$nombre_producto=$pro_nom.' '.$pre_nom;
		mysql_free_result($dts);
		
		//conversion a la minima unidad
		$stock_operacion=$cantidad*$cat_mul;
		
				
		$num=0;
		
		$dts2=$oCompra->mostrar_compra_detalle($_POST['com_id']);
		$num_rows2= mysql_num_rows($dts2);
		
		if($num_rows2>=1)
		{
			while($dt2 = mysql_fetch_array($dts2))
			{
				$cat_id2=$dt2['tb_catalogo_id'];
				$pre_id2=$dt2['tb_presentacion_id'];
				if(($cat_id1!=$cat_id2) and ($pre_id==$pre_id2))
				{
					$num++;
				}
			}
		}
		mysql_free_result($dts2);
	
		if($num==0)
		{
			if($stock_operacion>$sto_num)
			{
				$diferencia_stock=$stock_operacion-$sto_num;
				$array_pre[$nombre_producto]=$diferencia_stock;
				$error1=1;
			}
		}
		
		if($num==1)
		{
			$dts3=$oCompra->mostrar_compra_detalle($_POST['com_id']);
			$num_rows3= mysql_num_rows($dts3);
			if($num_rows2>=1)
			{
				while($dt3 = mysql_fetch_array($dts3))
				{
					$cat_id2=$dt3['tb_catalogo_id'];
					$pre_id2=$dt3['tb_presentacion_id'];
					
					if(($cat_id1!=$cat_id2) and ($pre_id==$pre_id2))
					{
						$can1=$cat_mul*$cantidad;
						$can2=$dt3['tb_catalogo_mul']*$dt3['tb_compradetalle_can'];
						$ped=$can1+$can2;
						$diferencia_stock=$ped-$sto_num;
						
						if($ped>$sto_num)
						{
							$array_pre[$nombre_producto]=$diferencia_stock;
							$error1=1;
						}
					}
				}
			}
			mysql_free_result($dts3);
		}
				
	}//fin while
}//fin if rows
mysql_free_result($dts1);


if($error1==1){
	$html='No se puede anular compra, stock insuficiente para:<br><br>';
	foreach($array_pre as $p=>$d){
		$html.= "<li>$p - Diferencia en $d.</li>";
	}
	$data['htm']=$html;
	$data['msj']='No se puede anular compra.';
	echo json_encode($data);
}
else
{
	$estado='ANULADA';
	$oCompra->modificar(
		$_POST['com_id'],
		fecha_mysql($fec),
		fecha_mysql($fecven),
		$doc_id,
		$numdoc,
		$pro_id,
		$estado
	);
	
	$dts1=$oCompra->mostrar_compra_detalle($_POST['com_id']);
	$num_rows= mysql_num_rows($dts1);
	//detalle de productos
		while($dt1 = mysql_fetch_array($dts1))
		{
			$cat_id1=$dt1['tb_catalogo_id'];
			$cantidad=$dt1['tb_compradetalle_can'];			
		
			//datos presentacion catalogo almacen
			$dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id1,$almacen);
			$dt = mysql_fetch_array($dts);
				$sto_id_ori=	$dt['tb_stock_id'];
				$sto_num_ori	=$dt['tb_stock_num'];
				$mul_ori		=$dt['tb_catalogo_mul'];
			mysql_free_result($dts);
			//conversion a la minima unidad
			$cantidad_traspaso_ori=$cantidad*$mul_ori;
			//actualizacion de stock
			$stock_nuevo_ori=$sto_num_ori-$cantidad_traspaso_ori;
			$dts=$oStock->modificar($sto_id_ori,$stock_nuevo_ori);
        }
	
	mysql_free_result($dts1);
	
	//anularkardex
	//($tiporeg,$tipo,$documento_id,$tipoperacion_id,$operacion_id)
	$dts= $oKardex->consulta_eliminar(1,1,$doc_id,2,$_POST['com_id']);
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
		$msj_n='No se pudo eliminar Kardex.';
	}
	//----------------------------------------
	
	
	$error1=0;
	$data['act']='correcto';
	$data['msj'].='Se anuló compra correctamente. '.$msj_n;
	echo json_encode($data);
}

}//estado cancelada
else
{
	$data['msj'].='Compra ya ha sido anulada.';
	echo json_encode($data);
}
?>