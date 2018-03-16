<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../grafico/cVenta.php");
$oVenta = new cVenta();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once ("../producto/cCatalogoproducto.php");	
$oCatalogoproducto = new cCatalogoproducto();

require_once ("../formatos/formato.php");

//$y=2013;
$y=$_POST['y'];

//datos de producto
$dts= $oCatalogoproducto->presentacion_catalogo($_POST['cat_id']);
$dt = mysql_fetch_array($dts);
	$mar_nom = $dt['tb_marca_nom'];//Marca			
	$cat_nom = $dt['tb_categoria_nom'];//Categoría
	$pro_nom = $dt['tb_producto_nom'];//descripcion
	$pro_id = $dt['tb_producto_id'];
mysql_free_result($dts);

$array = array();



//todos los puntos de venta
$rws=$oPuntoventa->mostrar_filtro_punven($_SESSION['empresa_id'],'');
while($rw = mysql_fetch_array($rws))
{

	$monto=array();
	for($i = 1; $i <= 12; $i++)
	{
		$total_ventas=0;
		$estado='CANCELADA';

		$dts1=$oVenta->grafico_productos_ventas($y,$i,$_POST['cat_id'],$cadena_categorias,$_POST['cmb_fil_pro_mar'],$_POST['hdd_fil_cli_id'],$estado,$_POST['cmb_fil_ven_ven'],$rw['tb_puntoventa_id'],$_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts1);

		$num_rows= mysql_num_rows($dts1);
		while($dt1 = mysql_fetch_array($dts1))
		{
			$total_ventas=$dt1['valven']+$dt1['igv'];
			$cantidad=$dt1['can'];
		}
		mysql_free_result($dts1);
		array_push($monto, $total_ventas);
	}
	
	//datos puento de venta
	$dts=$oPuntoventa->mostrarUno($rw['tb_puntoventa_id']);
	$dt = mysql_fetch_array($dts);
		$punven_nom=$dt['tb_puntoventa_nom'];
		$alm_id=$dt['tb_almacen_id'];
	mysql_free_result($dts);
	
	$serie1 = array( 'name' => $punven_nom , 'data' => $monto) ;
	
	//$serie2 = array( 'name' => 'TIENDA DALLORSO' , 'data' => array(-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5) ) ;
	
	array_push( $array, $serie1);
	//array_push( $array, $serie2);

}

mysql_free_result($rws);


?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Gráfico</title>

<script type="text/javascript">
$(function () {
	
		var datos =  <?php echo json_encode( $array) ?>;
		
		$('#container').highcharts({
				chart: {
						type: 'column',
						//type: 'bar',
						//renderTo: 'container',
            //type: 'line',
            //marginRight: 130,
            //marginBottom: 25
				},
				title: {
						text: 'VOLUMEN DE VENTAS'
				},
				subtitle: {
            text: '<?php echo $pro_nom.' | '.$mar_nom.' | '.$cat_nom?>'
        },
				xAxis: {
						title: {
								text: 'Año: <?php echo $y;?>'
						},
						categories: [
								'Ene',
								'Feb',
								'Mar',
								'Abr',
								'May',
								'Jun',
								'Jul',
								'Ago',
								'Sep',
								'Oct',
								'Nov',
								'Dic'
						]
				},
				yAxis: {
						min: 0,
						title: {
								text: 'Monto Ventas'
						}
				},
				tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
								'<td style="padding:0"><b> S/. {point.y}</b></td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
				},
				plotOptions: {
						column: {
								pointPadding: 0.2,
								borderWidth: 0,
								dataLabels: {
										enabled: true/*,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }*/
								}
						}
				},
				legend: {
					align: 'center',
					title: {
						text: 'Punto de Venta'
					}
        },
				series: datos,
				credits: {
						enabled: false
				},
		});
});
		</script>
	</head>
	<body>
<div id="container" style="min-width: 400px; height: 480px; margin: 0 auto"></div>

	</body>
</html>