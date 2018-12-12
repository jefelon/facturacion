<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../grafico/cVenta.php");
$oVenta = new cVenta();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once ("../formatos/formato.php");
require_once ("../formatos/fechas.php");

//$y=2013;
$y=$_POST['cmb_fil_ven_y'];
$mes=date('m')*1;

$array = array();

//todos los puntos de venta
$rws=$oPuntoventa->mostrar_filtro_punven($_SESSION['empresa_id'],$_POST['cmb_fil_ven_punven']);
$puntos_venta= mysql_num_rows($rws);

while($rw = mysql_fetch_array($rws))
{
	$monto=array();
	$div=0;
	$suma=0;
	for($i = 1; $i <= 12; $i++)
	{
		$total_ventas=0;
		$dts1=$oVenta->mostrar_filtro_adm($y,$i,$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$rw['tb_puntoventa_id'],$_SESSION['empresa_id'],$_POST['chk_fil_ven_may']);
		$num_rows= mysql_num_rows($dts1);
		while($dt1 = mysql_fetch_array($dts1))
		{
			$total_ventas+=$dt1['tb_venta_tot'];
		}
		mysql_free_result($dts1);
		array_push($monto, $total_ventas);
		
		if($puntos_venta==1)
		{
			if($i<$mes)
			{
				$div++;
				$suma+=$total_ventas;
			}
		}
	}
	
	//if($div>0)$promedio=moneda_mysql(formato_money($suma/$div))*1;;
	
	//datos punto de venta
	$dts=$oPuntoventa->mostrarUno($rw['tb_puntoventa_id']);
	$dt = mysql_fetch_array($dts);
		$punven_nom=$dt['tb_puntoventa_nom'];
		$alm_id=$dt['tb_almacen_id'];
	mysql_free_result($dts);
	
	$serie1 = array( 'name' => $punven_nom , 'data' => $monto);

	array_push( $array, $serie1);
	
	/*if($puntos_venta==1)
	{
		$pronostico=array();
		for($i = 1; $i <= $div; $i++)
		{
			$dato="";
			array_push($pronostico, $dato);
		}
		$dato2=moneda_mysql(formato_money($promedio))*1;
		array_push($pronostico, $dato2);
		
		//$serie2 = array( 'name' => 'PRONÓSTICO' , 'data' => $pronostico) ;
		//array_push( $array, $serie2);
	}*/
}

mysql_free_result($rws);

//if($puntos_venta==1)$texto_subtitle="Pronóstico de Ventas para ".nombre_mes($mes).": S/. ".formato_money($dato2)."";
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Gráfico</title>
<script type="text/javascript">
$(function () {
	
		var datos =  <?php echo json_encode($array) ?>;
		
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
                text: '<?php //echo $texto_subtitle?>'
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