<?php
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/numletras.php");
require_once ("../formatos/formato.php");

$id = $_GET['id_factura'];
$tipdoc = "1";//1 FACTURA
$tipdoccli = "6";//1 DNI | 6 RUC

$dts = $oVenta->convertir_hash($id);

while($dt = mysql_fetch_array($dts)){
    $id = $dt["tb_venta_id"];
}

$dts = $oVenta->mostrarUno($id);
while($dt = mysql_fetch_array($dts)){
    $serie=$dt["tb_venta_ser"];
    $numero=$dt["tb_venta_num"];

    $ruc=$dt["tb_cliente_doc"];
    $razon=$dt["tb_cliente_nom"];
    $direccion=$dt["tb_cliente_dir"];
    $fecha=mostrarFecha($dt["tb_venta_fec"]);

    $toigv=$dt["tb_venta_igv"];
    $importetotal=$dt["tb_venta_tot"];
    $totopgrat=$dt["tb_venta_grat"];
    $subtotal=$dt["tb_venta_gra"];
    $valorventa=$dt["tb_venta_valven"];
    $toisc="0.00";
    $totdes=$dt["tb_venta_des"];
    $totanti="0.00";
    $moneda=1;

    $digestvalue=$dt["tb_venta_digval"];
    $signaturevalue=$dt["tb_venta_sigval"];
}

$tipodoc = 'FACTURA ELECTRONICA';

$estado = "1";
$razon_defecto = "IMPORTACIONES Y DISTRIBUCIONES GRANADOS SRL";
$direccion_defecto = "AV. AUGUSTO B. LEGUIA 1160 URB. SAN LORENZO";
$direccion_defecto .= "<br/>" . "LAMBAYEQUE - JOSE LEONARDO ORTIZ - JOSE LEONARDO ORTIZ";
$ruc_empresa = "20479676861";
//$serie = "E001";//-------
//$numero = "82";//--------
if($moneda==1){
    $moneda  = "SOLES";
    $mon = "S/ ";
}else{
    $moneda  = "DOLARES";
    $mon = "US$ ";
}
    

$file_name = 'FA-'.$serie.'-'.$numero.'-code.png';
$path = 'temp/'.$file_name;
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


// Introducimos HTML de prueba
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<style type="text/css">
    body {
        color: black;
        font-family: Consolas, monaco, monospace;
        margin: 0px;
        padding-top: 0px;
        font-size: .6em;
    }
    .header_row th {
        border-bottom: 0.9px solid #ddd;
        border-right: 0.9px solid #ddd;
        border-left: 0.9px solid #ddd;
    }
    .odd_row td {
        background-color: transparent;
        border-bottom: 0.9px solid #ddd;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .even_row td {
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: #f6f6f6;
        border-bottom: 0.9px solid #ddd;
    }
    .row td{
        border-right: 0.9px solid #ddd;
        border-left: 0.9px solid #ddd;
    }
</style>

<style media="print">
    .oculto{
        display: none;
    }

</style>
<table style="width: 100%; margin-bottom: 10px" border="0">';
if($estado=="0"){
	$html.='<tr>
	    <td width="50%"></td>
	    <td width="10%"></td>
	    <td td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
	    </tr>';
}
    $html.='<tr>
        <td style="text-align: left" width="60%"><strong style="font-size: 30px">'.$razon_defecto.'</strong><br>'.$direccion_defecto.'
        </td>
        <td style="text-align: center;" width="40%" border="1"><strong style="font-size: 26px">'.$tipodoc.'<br>
            RUC: '.$ruc_empresa.'<br>
            '.$serie.'-'.$numero.'</strong>
        </td>
    </tr>
</table>
<br/>
<br/>
<br/>
<br/>
<table style="width: 100%;" border="0">
    <tr>
        <td style="text-align: left" width="10%">SEÑOR(ES)</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$razon.'</td>

        <td style="text-align: left" width="10%">FECHA</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="18%">'.$fecha.'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="10%">RUC</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$ruc.'</td>

        <td style="text-align: left" width="10%">MONEDA</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="18%">'.$moneda.'</td>
    </tr>
    <tr>
        <td style="text-align: left; vertical-align:top;" width="10%">DIRECCIÓN</td>
        <td style="text-align: left; vertical-align:top;" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$direccion.'</td>
    </tr>
</table>
<br/>
<br/>
<br/>
<table style="width: 100%; border-top: 0.9px solid #eeeeee;  border-collapse:collapse;">
    <tbody style="border-bottom: 0.9px solid #eeeeee;">
        <tr class="header_row">
            <th style="text-align: center; width: 5%;"><b>Ítem</b></th>
            <th style="text-align: center; width: 40%;"><b>Descripción</b></th>
            <th style="text-align: center; width: 7%;"><b>Unidad</b></th>
            <th style="text-align: center; width: 8%;"><b>Cantidad</b></th>
            <th style="text-align: center; width: 10%;"><b>Precio Unitario</b></th>
            <th style="text-align: center; width: 10%;"><b>Descuento</b></th>
            <th style="text-align: center; width: 10%;"><b>Valor Venta</b></th>
            <th style="text-align: center; width: 10%;"><b>Precio Venta</b></th>
        </tr>';
            $dts = $oVenta->mostrar_venta_detalle_ps($id);
            $cont = 1;
            while($dt = mysql_fetch_array($dts)){
            	$codigo = $cont; 
$html.='<tr class="row">';
            if($dt["tb_ventadetalle_tipven"]==1){
                $html.='<td style="text-align: left">'.$cont.'</td>
                <td style="text-align: left">'.$dt["tb_producto_nom"].'</td>
                <td style="text-align: center">UNIDAD</td>
                <td style="text-align: right">'.$dt["tb_ventadetalle_can"].'</td>
                <td style="text-align: right">'.$dt["tb_ventadetalle_preuni"].'</td>
                <td style="text-align: right">'.$dt["tb_ventadetalle_des"].'</td>
                <td style="text-align: right">'.formato_moneda($dt["tb_ventadetalle_valven"]).'</td>';
                $html.='<td style="text-align: right">'.formato_moneda($dt["tb_ventadetalle_preunilin"]*$dt["tb_ventadetalle_can"]).'</td>';
            }else{
                $html.='<td style="text-align: left">'.$cont.'</td>
                <td style="text-align: left">'.$dt["tb_servicio_nom"].'</td>
                <td style="text-align: center">UNIDAD</td>
                <td style="text-align: right">'.$dt["tb_ventadetalle_can"].'</td>
                <td style="text-align: right">'.$dt["tb_ventadetalle_preuni"].'</td>
                <td style="text-align: right">'.$dt["tb_ventadetalle_des"].'</td>
                <td style="text-align: right">'.formato_moneda($dt["tb_ventadetalle_valven"]).'</td>';
                $html.='<td style="text-align: right">'.formato_moneda($dt["tb_ventadetalle_preunilin"]*$dt["tb_ventadetalle_can"]).'</td>';
            }
            $html.='</tr>';
        $cont++;
    	}
    $html.='</tbody>
</table>
<br/>
<br/>
<table style="width: 100%"  border="0">
    <tr>
        <td style="text-align: left;" colspan="3">Observacion:</td>
    </tr>';
    if($totopgrat > 0){
    $html.='<tr>
        <td width="80%" style="text-align: right;" colspan="2">Vtas. Gratuitas: </td>
        <td width="20%" style="text-align: right;">'.$mon . $totopgrat.'</td>
    </tr>';
    }
    $html.='<tr>
        <td width="80%" style="text-align: right;" colspan="2">Sub Total: </td>
        <td width="20%" style="text-align: right;">'.$mon . $subtotal.'</td>
    </tr>';
    if($totanti > 0){
        $html.='<tr>
            <td width="80%" style="text-align: right;" colspan="2">Anticipos: </td>
            <td width="20%" style="text-align: right;">'.$mon . $totanti.'</td>
        </tr';
    }
    $html.='<tr>
        <td width="80%" style="text-align: right;" colspan="2">Descuentos: </td>
        <td width="20%" style="text-align: right;">'.$mon . $totdes.'</td>
    </tr>
    <tr>
        <td width="80%" style="text-align: right;" colspan="2">Valor Venta: </td>
        <td width="20%" style="text-align: right;">'.$mon . $valorventa.'</td>
    </tr>
    <tr>
        <td width="80%" style="text-align: right;" colspan="2">ISC: </td>
        <td width="20%" style="text-align: right;">'.$mon . $toisc.'</td>
    </tr>
    <tr>
        <td  width="80%" style="text-align: right;" colspan="2">IGV: </td>
        <td width="20%" style="text-align: right;">'.$mon . $toigv.'</td>
    </tr>
        <tr>
            <td width="60%" style="text-align: left;">';
            if($importetotal>0){
            	$html.='SON: ' . numtoletras($importetotal);
            }else{
            	$html.='Leyenda TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE';
            }
            $html.='</td>
            <td width="20%" style="text-align: right;">Importe Total: </td>
            <td width="20%" style="text-align: right;">'.$mon . $importetotal.'</td>
        </tr>

</table>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<p style="font-size:15px">
Código de Seguridad (Hash): '.$codhash.'<br>
Representación Impresa de la '.$tipodoc.'. Esta puede ser consultada en: www.granadosllantas.com<br>
Autorizado mediante Resolución de Intendencia N° 000000065
</p>
</body>
</html>
';

require_once('../../libreriasphp/html2pdf/_tcpdf_5.9.206/tcpdf.php');

$pdf = new TCPDF();

$pdf->AddPage();

$style = array(
	'border' => 2,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

$pdf->writeHTML($html, true, 0, true, true);

$pdf->write2DBarcode($ruc_empresa.'|'.$tipdoc.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$tipdoccli.'|'.$ruc.'|'.$digestvalue.'|'.$signaturevalue.'|', 'QRCODE,Q', 157, 99, 40, 40, $style, 'N');

$pdf->Output('example_050.pdf', 'I');
