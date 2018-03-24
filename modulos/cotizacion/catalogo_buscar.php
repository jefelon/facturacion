<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../venta/cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once("../producto/cPrecio.php");
$oPrecio = new cPrecio();
require_once ("../stock/cStock.php");
$oStock = new cStock();

require_once ("../formatos/formato.php");
require_once ("../catalogo/cst_producto.php");

$unico_id=$_POST['unico_id'];

$est="Activo";
$lim="";

$dts0=$oCatalogo->filtrar($_POST['txt_bus_pro_nom'],$_POST['txt_bus_pro_codbar'],$est,$_SESSION['almacen_id'],$lim);
$dt0 = mysql_fetch_array($dts0);

$num_rows= mysql_num_rows($dts0);
if($num_rows>0)
{
///arreglar el buscar
	if($num_rows==1)
	{	
		$dts1=$oCatalogo->filtrar($_POST['txt_bus_pro_nom'],$_POST['txt_bus_pro_codbar'],$est,$_SESSION['almacen_id'],$lim);
		$dt1 = mysql_fetch_array($dts1);

			$data['pro_id']		=$dt1['tb_producto_id'];
			$data['cat_id']		=$dt1['tb_catalogo_id'];

			$data['pro_codbar'] =$dt1['tb_presentacion_cod'];
			$data['pro_nom']	=$dt1['tb_producto_nom'];

			//precio venta
			$data['cat_preven'] =$dt1['tb_catalogo_preven'];
			
			//precio minimo
			$precio=1;
			$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt1['tb_catalogo_id']);
			$rw = mysql_fetch_array($rws);
            $data['cat_premin']=$rw['tb_preciodetalle_val'];
			mysql_free_result($rws);

			//precio mayorista
			$precio=2;
			$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt1['tb_catalogo_id']);
			$rw = mysql_fetch_array($rws);
            $data['cat_premay']=$rw['tb_preciodetalle_val'];
			mysql_free_result($rws);

            //stock
            $stock = mysql_fetch_array($oStock->stock_por_presentacion($dt1["tb_presentacion_id"],$_SESSION['almacen_id']))['tb_stock_num'];
            $data['cat_stouni']=$stock*1;

            //costo ponderado
            $costo_ponderado="";
            $stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
            $costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$dt1['tb_catalogo_precos'],$precosdol,$_SESSION['empresa_id']);
            $costo_ponderado=$costo_ponderado_array['soles'];
            $data['cat_cospro']=$costo_ponderado;

			//cantidad		
			if($_SESSION['venta_car'][$unico_id][$dt1['tb_catalogo_id']]>0)
			{
				$cat_can=$_SESSION['venta_car'][$unico_id][$dt1['tb_catalogo_id']]+1;
			}
			else {
				$cat_can='1';
			}
			
			$data['cat_can']=$cat_can;
            $data['ojo'] = $_SESSION['venta_car'][$unico_id][$dt1['tb_catalogo_id']];
            $data['oreja'] = $_SESSION['venta_car'][$unico_id][$dt1['tb_catalogo_id']];

			//unidad
			$data['cat_uni']='<option value="'.$dt1['tb_unidad_id'].'"selected>'.$dt1['tb_unidad_nom'].'</option>';

		mysql_free_result($dts1);

		$data['accion']=1;
	}


	if($num_rows>1)
	{
		$dts1=$oCatalogo->filtrar($_POST['txt_bus_pro_nom'],$_POST['txt_bus_pro_codbar'],$est,$_SESSION['almacen_id'],$lim);
		while ($dt1 = mysql_fetch_array($dts1))
		{
			$f++;

			if($_POST['hdd_bus_cat_id']>0)
			{
				if($_POST['hdd_bus_cat_id']==$dt1['tb_catalogo_id'])
				{
					$mostrar=1;
				}
			}
			else
			{
				if($f==1)
				{
					$mostrar=1;
				}
			}

			if($mostrar==1)
			{

				$data['pro_id']		=$dt1['tb_producto_id'];
				$data['cat_id']		=$dt1['tb_catalogo_id'];

				$data['pro_codbar'] =$dt1['tb_presentacion_codbar'];
				$data['pro_nom']	=$dt1['tb_producto_nom'];

				//precio venta
				$data['cat_preven'] =$dt1['tb_catalogo_preven'];
			
				//precio minimo
				$precio=1;
				$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt1['tb_catalogo_id']);
				$rw = mysql_fetch_array($rws);
                $data['cat_premin']=$rw['tb_preciodetalle_val'];
				mysql_free_result($rws);

				//precio mayorista
				$precio=2;
				$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt1['tb_catalogo_id']);
				$rw = mysql_fetch_array($rws);
                $data['cat_premay']=$rw['tb_preciodetalle_val'];
				mysql_free_result($rws);

				//stock
                $stock = mysql_fetch_array($oStock->stock_por_presentacion($dt1["tb_presentacion_id"],$_SESSION['almacen_id']))['tb_stock_num'];
                $data['cat_stouni']=$stock*1;

                //costo ponderado
                $costo_ponderado="";
                $stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
                $costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$dt1['tb_catalogo_precos'],$precosdol,$_SESSION['empresa_id']);
                $costo_ponderado=$costo_ponderado_array['soles'];
                $data['cat_cospro']=$costo_ponderado;
				
				//cantidad
				if($_SESSION['venta_car'][$unico_id][$dt1['tb_catalogo_id']]>0)
				{
					$cat_can=$_SESSION['venta_car'][$unico_id][$dt1['tb_catalogo_id']]+1;
				}
				else {
					$cat_can='1';
				}
				
				$data['cat_can']=$cat_can;

				break;
			}

		}
		mysql_free_result($dts1);

		//unidad
		$dts2=$oCatalogo->filtrar($_POST['txt_bus_pro_nom'],$_POST['txt_bus_pro_codbar'],$est,$_SESSION['almacen_id'],$lim);
		while ($dt2 = mysql_fetch_array($dts2))
		{
			$i++;
			$selected="";
			if($_POST['hdd_bus_cat_id']==$dt2['tb_catalogo_id'])$selected="selected";

			//precio venta
			$preven =$dt2['tb_catalogo_preven'];
			
			//precio minimo
			$premin="";
			$precio=1;
			$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt2['tb_catalogo_id']);
			$rw = mysql_fetch_array($rws);
            $premin=$rw['tb_preciodetalle_val'];
			mysql_free_result($rws);

			//precio mayorista
			$premay="";
			$precio=2;
			$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt2['tb_catalogo_id']);
			$rw = mysql_fetch_array($rws);
            $premay=$rw['tb_preciodetalle_val'];
			mysql_free_result($rws);

			//cantidad
			$cat_can="";	
			if($_SESSION['venta_car'][$unico_id][$dt2['tb_catalogo_id']]>0)
			{
				$cat_can=$_SESSION['venta_car'][$unico_id][$dt2['tb_catalogo_id']]+1;
			}
			else
			{
				$cat_can=1;
			}

			$cat_uni.='<option value="'.$dt2['tb_unidad_id'].'"'.$selected.' 
			data-cat_id="'.$dt2['tb_catalogo_id'].'" 
			data-preven="'.$preven.'"
			data-premin="'.$premin.'"
			data-premay="'.$premay.'"
			data-can="'.$cat_can.'"
			>'.$dt2['tb_unidad_nom'].'</option>';
		}
		mysql_free_result($dts2);

		$data['cat_uni']=$cat_uni;

		$data['accion']=2;
	}
}
else
{
	$data['accion']=0;
}

mysql_free_result($dts0);

echo json_encode($data);
?>