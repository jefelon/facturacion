<?php

require_once ("../../config/Cado.php");
require_once ("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();
require_once ("../formatos/numletras.php");
require_once ("../formatos/formato.php");

$id = $_GET['id_factura'];
$tipdoc = "1";//1 FACTURA
$tipdoccli = "6";//1 DNI | 6 RUC

$dts = $oCotizacion->convertir_hash($id);

while($dt = mysql_fetch_array($dts)){
    $id = $dt["tb_venta_id"];
}

$dts = $oCotizacion->mostrarUno($id);
while($dt = mysql_fetch_array($dts)){
    $serie=$dt["tb_venta_ser"];
    $numero=$dt["tb_venta_num"];

    $ruc=$dt["tb_cliente_doc"];
    $razon=$dt["tb_cliente_nom"];
    $direccion=$dt["tb_cliente_dir"];
    $fecha=mostrarFecha($dt["tb_venta_fec"]);

    $toigv=$dt["tb_venta_igv"];
    $importetotal=$dt["tb_venta_tot"];
    $totopgrat="0.00";
    $subtotal=$dt["tb_venta_valven"];
    $valorventa=$subtotal;
    $toisc="0.00";
    $totdes=$dt["tb_venta_des"];
    $totanti="0.00";
    $moneda=1;

    $digestvalue=$dt["tb_venta_digval"];
    $signaturevalue=$dt["tb_venta_sigval"];

    $id_fin = $dt["tb_venta_id"];
}

$estado = "1";
$razon_defecto = "IMPORTACIONES Y DISTRIBUCIONES GRANADOS SRL";
$direccion_defecto = "AV. AUGUSTO B. LEGUIA 1160 URB. SAN LORENZO";
$direccion_defecto .= "<br/>" . "LAMBAYEQUE - JOSE LEONARDO ORTIZ - JOSE LEONARDO ORTIZ";
$ruc_empresa = "20479676861";
if($moneda==1){
    $moneda  = "SOLES";
    $mon = "S/ ";
}else{
    $moneda  = "DOLARES";
    $mon = "US$ ";
}

@unlink("temp/codigo.png");
$file_name = 'FA-'.$serie.'-'.$numero.'-code.png';
$params = array(
    array('data',$ruc_empresa.'|'.$tipdoc.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$tipdoccli.'|'.$ruc.'|'.$digestvalue.'|'.$signaturevalue.'|'),array('compaction',4),array('modwidth',1),
    array('info',false),array('columns',8),array('errlevel',5),
    array('showtext',false),array('height',3),
    array('showframe',false),array('truncated',false),
    array('vertical',false) ,
    array('backend','IMAGE'), array('file','temp/'.$file_name),
    array('scale',2), array('pswidth','') );

    $n=count($params);
    $s='';
    for($i=0; $i < $n; ++$i ) {
        $v  = $params[$i][0];
        if( empty($_GET[$params[$i][0]]) ) {
            $$v = $params[$i][1];
        }
        else
            $$v = $_GET[$params[$i][0]];
        $s .= $v.'='.urlencode($$v).'&';
    }

    echo "<img src=\"generate.php?$s\" name=barcode style=\"width: 6cm; height: 2cm;display:none;\">";

?>

<html>
<head>
	<script>
      function load() {
        setTimeout(function(){
    		location.href="generarPDF.php?action=<?php echo $_GET['action'] ?>&id_factura=<?php echo $_GET['id_factura'] ?>";
            setTimeout(function(){
                window.close();
            }, 2000);
		}, 5000);
      }
      window.onload = load;
    </script>
</head>
<body>
	<h3>Cargando...</h3>
</body>
</html>