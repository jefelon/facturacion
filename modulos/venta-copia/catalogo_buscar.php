<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once("../producto/cPrecio.php");
$oPrecio = new cPrecio();

require_once ("../formatos/formato.php");

$dts1=$oCatalogo->catalogo_venta_filtro_codbar($_SESSION['almacen_id'],$_POST['txt_bus_pro_nom'],$_POST['pro_cod'],$_POST['txt_bus_pro_codbar'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['limit']);
$num_rows= mysql_num_rows($dts1);

if($num_rows>0)
{

	if($num_rows==1)
	{
		$dt1 = mysql_fetch_array($dts1);

			$stock=$dt1['tb_stock_num'];
			$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
			$st_res=$stock%$dt1['tb_catalogo_mul'];
			if($st_res!=0){
				//$stock_unidad="$st_uni + r$st_res";
				$stock_unidad="$st_uni";
			} else{
				$stock_unidad="$st_uni";
			}

			$data['cat_id']=$dt1['tb_catalogo_id'];
			$data['cat_stouni']=$stock_unidad;
			$data['pro_codbar']=$_POST['txt_bus_pro_codbar'];
			$data['pro_nom']=$dt1['tb_producto_nom'];
			$data['cat_preven']=$dt1['tb_catalogo_preven'];
			
			if($_SESSION['venta_car'][$dt1['tb_catalogo_id']]>0)
			{
				$cat_can=$_SESSION['venta_car'][$dt1['tb_catalogo_id']]+1;
			}
			else
			{
				$cat_can=1;
			}
			
			$data['cat_can']=$cat_can;

			$cat_id=$dt1['tb_catalogo_id'];

		mysql_free_result($dts1);


		$precio=1;
			$rws = $oPrecio->consultar_precio_por_catalogo($precio,$cat_id);
			$rw = mysql_fetch_array($rws);
			$predet_id1=$rw['tb_preciodetalle_id'];
			$data['cat_premin']=$rw['tb_preciodetalle_val'];
			mysql_free_result($rws);
			
		$precio=2;
			$rws = $oPrecio->consultar_precio_por_catalogo($precio,$cat_id);
			$rw = mysql_fetch_array($rws);
			$predet_id2=$rw['tb_preciodetalle_id'];
			$data['cat_premay']=$rw['tb_preciodetalle_val'];
			mysql_free_result($rws);
		
	
		$data['accion']=1;
	}


	if($num_rows>1)
	{
		$data['accion']=2;
	}
}
else
{
	$data['accion']=0;
}

echo json_encode($data);
?>