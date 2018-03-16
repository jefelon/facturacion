<?php
require_once('../../libreriasphp/html2pdf/_tcpdf_5.9.206/tcpdf.php');

require_once ("../../config/Cado.php");
require_once ("../notacredito/cNotacredito.php");
$oNotacredito = new cNotacredito();

require_once ("../formatos/numletras.php");
require_once ("../formatos/formato.php");

$razon_defecto = "IMPORTACIONES Y DISTRIBUCIONES GRANADOS SRL";
$direccion_defecto = "AV. AUGUSTO B. LEGUIA NRO. 1160 URB. SAN LORENZO";
$direccion_defecto .= "<br/>" . "JOSE LEONARDO ORTIZ - CHICLAYO - LAMBAYEQUE";
$ruc_empresa = "20479676861";

$contacto_empresa = "Teléfono:  Correo: idigrasrl@hotmail.com";

$sucursales='
<table style="font-size:10pt" border="0">
    <tr>
        <td width="80">PRINCIPAL:</td>
        <td width="580">AV. AUGUSTO B. LEGUÍA N° 1160 URB. SAN LORENZO J. L. ORTIZ - CHICLAYO - LAMBAYEQUE</td>
    </tr>
    <tr>
        <td></td>
        <td>TELÉFONO: 979532359 / 074 256797</td>
    </tr>
    <tr>
        <td>SUCURSAL:</td>
        <td>CALLE VIRGILIO D\'ALLORSO N° 177 CERCADO - CHICLAYO - CHICLAYO - LAMBAYEQUE</td>
    </tr>
    <tr>
        <td></td>
        <td>TELÉFONO: 954673888 / 074 236159</td>
    </tr>
    <tr>
        <td>SUCURSAL:</td>
        <td>AV. MIGUEL GRAU N° 470 URB. SANTA VICTORIA - CHICLAYO - CHICLAYO - LAMBAYEQUE</td>
    </tr>
    <tr>
        <td></td>
        <td>TELÉFONO: 979532353 / 074 227320</td>
    </tr>
    <tr>
        <td>CORREO:</td>
        <td>idigrasrl@hotmail.com</td>
    </tr>
</table>';

$tipodoc = 'NOTA DE CREDITO ELECTRONICA';

$ven_id=$_POST['ven_id'];

$dts = $oNotacredito->mostrarUno($ven_id);
while($dt = mysql_fetch_array($dts))
{
    $idcomprobante=$dt["cs_tipodocumento_cod"];

    $serie=$dt["tb_venta_ser"];
    $numero=$dt["tb_venta_num"];

    $ruc=$dt["tb_cliente_doc"];
    $razon=$dt["tb_cliente_nom"];
    $direccion=$dt["tb_cliente_dir"];
    if($dt["tb_cliente_tip"]==1)$idtipodni=1;
    if($dt["tb_cliente_tip"]==2)$idtipodni=6;

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

    $estsun=$dt['tb_venta_estsun'];
      $fecenvsun=mostrarFechaHora($dt['tb_venta_fecenvsun']);
      $faucod=$dt['tb_venta_faucod'];
      $digval=$dt['tb_venta_digval'];
      $sigval=$dt['tb_venta_sigval'];
      $val=$dt['tb_venta_val'];

    $estado=$dt['tb_venta_est'];

    $vennumdoc=$dt['tb_venta_vennumdoc'];
    $mot=$dt['tb_venta_mot'];
    $lab3=$dt['tb_venta_lab3'];
}

if($moneda==1){
    $moneda  = "SOLES";
    $mon = "S/ ";
}
   
 
$nombre_archivo = ''.$serie.'-'.$numero.'.pdf';

// $file_name = 'FA-'.$serie.'-'.$numero.'-code.png';
// $path = 'temp/'.$file_name;
// $type = pathinfo($path, PATHINFO_EXTENSION);
// $data = file_get_contents($path);
// $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


class MYPDF extends TCPDF
{

    public function Header() {
      //$image_file = K_PATH_IMAGES.'logo.jpg';
      //$this->Image($image_file, 20, 10, 71, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      // Set font
      //$this->SetFont('helvetica', 'B', 20);
      // Title
      //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    public function Footer() 
    {
      // $style = array(
      //   'position' => 'L',
      //   'align' => 'L',
      //   'stretch' => false,
      //   'fitwidth' => true,
      //   'cellfitalign' => '',
      //   'border' => false,
      //   'padding' => 0,
      //   'fgcolor' => array(0,0,0),
      //   'bgcolor' => false,
      //   'text' => false
      // //     'font' => 'helvetica',
      // //     'fontsize' => 8,
      // //     'stretchtext' => 4
      // );

      // $this -> SetY(-24);
      // // Page number
      // $this->SetFont('helvetica', '', 9);
      // //$this->SetTextColor(0,0,0);
      // $this->Cell(0, 0, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 'T', 1, 'R', 0, '', 0, false, 'T', 'M');
      
      // $codigo='CAV-'.str_pad($_GET['d1'], 4, "0", STR_PAD_LEFT);
      
      // $this->write1DBarcode($codigo, 'C128', '', 273, '', 6, 0.3, $style, 'N');
      // $this->Cell(0, 0, 'www.prestamosdelnortechiclayo.com', 0, 1, 'C', 0, '', 0, false, 'T', 'M');        
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('www.inticap.com');
$pdf->SetTitle($title);
$pdf->SetSubject('www.inticap.com');
$pdf->SetKeywords('www.inticap.com');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(12, 15, 12);// left top right
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// add a page
$pdf->AddPage('P', 'A4');

//font-family: Consolas, monaco, monospace;
//helvetica, monaco, monospace;

// Introducimos HTML de prueba
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<style type="text/css">
    body {
        color: black;
        font-family: Sans Serif, Arial, Consolas;
        margin: 0px;
        padding-top: 0px;
        font-size: 11pt;
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
<body><table style="width: 100%; margin-bottom: 50mm" border="0">';
if($estado=="ANULADA"){
	$html.='<tr>
	    <td width="50%"></td>
	    <td width="10%"></td>
	    <td td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
	    </tr>';
}
    $html.='<tr>
        <td style="text-align: left" width="60%" align="left"><strong style="font-size: 11pt">'.$razon_defecto.'</strong><br>'.$direccion_defecto.'
        </td>
        <td style="text-align: center;" width="40%" border="1">
            <strong style="font-size: 15pt">'.$tipodoc.'<br>
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
        <td style="text-align: left" width="13%">SEÑOR(ES)</td>
        <td style="text-align: left" width="3%">:</td>
        <td style="text-align: left" width="55%">'.$razon.'</td>

        <td style="text-align: left" width="13%">FECHA</td>
        <td style="text-align: left" width="3%">:</td>
        <td style="text-align: left" width="18%">'.$fecha.'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="13%">RUC</td>
        <td style="text-align: left" width="3%">:</td>
        <td style="text-align: left" width="55%">'.$ruc.'</td>

        <td style="text-align: left" width="13%">MONEDA</td>
        <td style="text-align: left" width="3%">:</td>
        <td style="text-align: left" width="18%">'.$moneda.'</td>
    </tr>
    <tr>
        <td style="text-align: left; vertical-align:top;" width="13%">DIRECCIÓN</td>
        <td style="text-align: left; vertical-align:top;" width="3%">:</td>
        <td style="text-align: left;" width="84%">'.$direccion.'</td>
    </tr>
</table>
<br/>
<br/>
<br/>
<table style="width: 100%; border: 0.5px solid #eeeeee; border-collapse:collapse;">
    <tbody>
        <tr class="header_row">
            <th style="text-align: right; width: 7%;"><b>CANT</b></th>
            <th style="text-align: center; width: 53%;"><b>DESCRIPCIÓN</b></th>
            <th style="text-align: center; width: 10%;"><b>UNIDAD</b></th>
            <th style="text-align: right; width: 15%;"><b>PRECIO UNITARIO</b></th>
            <th style="text-align: right; width: 15%;"><b>PRECIO VENTA</b></th>
        </tr>';
            $dts = $oNotacredito->mostrar_venta_detalle_ps($ven_id);
            $cont = 1;
            while($dt = mysql_fetch_array($dts)){
            	$codigo = $cont; 
$html.='<tr class="row">';
            if($dt["tb_ventadetalle_tipven"]==1){
                $html.='<td style="text-align: right">'.$dt["tb_ventadetalle_can"].'</td>
                <td style="text-align: left">'.$dt["tb_producto_nom"].'</td>
                <td style="text-align: center">UNIDAD</td>
                <td style="text-align: right">'.$dt["tb_ventadetalle_preuni"].'</td>';
                $html.='<td style="text-align: right">'.formato_moneda($dt["tb_ventadetalle_preunilin"]*$dt["tb_ventadetalle_can"]).'</td>';
            }else{
                $html.='<td style="text-align: right">'.$dt["tb_ventadetalle_can"].'</td>
                <td style="text-align: left">'.$dt["tb_servicio_nom"].'</td>
                <td style="text-align: center">UNIDAD</td>
                <td style="text-align: right">'.$dt["tb_ventadetalle_preuni"].'</td>';
                $html.='<td style="text-align: right">'.formato_moneda($dt['tb_ventadetalle_valven']+$dt['tb_ventadetalle_igv']).'</td>';
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
        <td style="text-align: left;" colspan="3">'.$observacion.'</td>
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
<br/>';

$num=0;
$html.='
<table style="width: 100%"  border="0">
    <tr>
        <td style="text-align: left;" colspan="3">INFORMACIÓN ADICIONAL</td>
    </tr>';

    $num++;
    $html.='
    <tr>
        <td width="5%" style="text-align: left;">'.$num.')</td>
        <td width="20%" style="text-align: left;">Doc. Vinculado:</td>
        <td width="75%" style="text-align: left;">'.$vennumdoc.'</td>
    </tr>';

    $num++;
    $html.='
    <tr>
        <td width="5%" style="text-align: left;">'.$num.')</td>
        <td width="20%" style="text-align: left;">Motivo:</td>
        <td width="75%" style="text-align: left;">'.$mot.'</td>
    </tr>';

    if($lab3!="")
    {
    $num++;
    $html.='
    <tr>
        <td width="5%" style="text-align: left;">'.$num.')</td>
        <td width="20%" style="text-align: left;">Ord. Servicio:</td>
        <td width="75%" style="text-align: left;">'.$lab3.'</td>
    </tr>';
    }

$html.='
</table>';

$html.='<br/><br/>'.$sucursales;

$html.='
<br/>
<br/>
<br/>
<table>
<tr>
<td style="width:78%">
<p style="font-size:11pt">
Código de Seguridad (Hash): '.$digval.'<br>
Representación Impresa de la '.$tipodoc.'.<br>Esta puede ser consultada en: www.granadosllantas.com<br>
Autorizado mediante Resolución de Intendencia N° 0720050000067/SUNAT
</p>
</td>
<td>
';


$style = array(
	'border' => 2,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);


//$params = $pdf->serializeTCPDFtagParameters(array($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.mostrarfecha($fecha).'|'.$idtipodni.'|'.$ruc.'|', 'QRCODE,Q', '', '', 40, 40, $style, 'N'));
//$html .= '<tcpdf method="write2DBarcode" params="'.$params.'" />
$html .= '</td>
</tr>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);

//$pdf->write2DBarcode($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$idtipodni.'|'.$ruc.'|', 'QRCODE,Q', 157, 99, 40, 40, $style, 'N');

$pdf->Output($nombre_archivo, 'I');
