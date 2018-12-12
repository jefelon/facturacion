<?php
require_once('../../libreriasphp/html2pdf/_tcpdf_5.9.206/tcpdf.php');

$title='Factura Electrónica';
$codigo='E001-82';

require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/numletras.php");
require_once ("../formatos/formato.php");

$id = "11118";
$tipdoc = "1";//1 FACTURA
$tipdoccli = "6";//1 DNI | 6 RUC

$dts = $oVenta->mostrarUno($id);
while($dt = mysql_fetch_array($dts)){
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
}

$estado = "1";
$razon_defecto = "IMPORTACIONES Y DISTRIBUCIONES GRANADOS SRL";
$direccion_defecto = "AV. AUGUSTO B. LEGUIA 1160 URB. SAN LORENZO";
$direccion_defecto .= "<br/>" . "LAMBAYEQUE - JOSE LEONARDO ORTIZ - JOSE LEONARDO ORTIZ";
$ruc_empresa = "20479676861";
$serie = "E001";//-------
$numero = "82";//--------
if($moneda==1){
    $moneda  = "SOLES";
    $mon = "S/ ";
}else{
    $moneda  = "DOLARES";
    $mon = "US$ ";
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('www.a-zetasoft.com');
$pdf->SetTitle($title);
$pdf->SetSubject('www.a-zetasoft.com');
$pdf->SetKeywords('www.a-zetasoft.com');

// set header and footer fonts
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(10, 10, 10);// left top right

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// add a page
$pdf->AddPage('P', 'A4');
//Sistem variable

    $html='
<style type="text/css">
    body {
        background-color: transparent;
        color: black;
        font-family: Consolas, monaco, monospace;
        margin: 0px;
        padding-top: 0px;
        font-size: .6em;
    }
    .header_row th {
        /*background-color: transparent;*/
        border-bottom: 0.9px solid #ddd;
        border-right: 0.9px solid #ddd;
        border-left: 0.9px solid #ddd;
        /*padding-top: 20px;
        padding-bottom: 5px;*/
        height: 30px;
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
<table style="width: 100%; margin-bottom: 10px">';
    if($estado=="0"){
        $html.='<tr>
            <td width="50%"></td>
            <td width="10%"></td>
            <td td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
            </tr>';
        }
    $html.='<tr>
        <td style="text-align: left" width="50%">
            <strong style="font-size: 14px">'.$razon_defecto.'</strong><br>
            '.$direccion_defecto.'
        </td>
        <td style="text-align: left" width="10%"><input type="button" name="btnPrint" value="Imprimir" class="oculto" onClick="window.print()"></td>

        <td style="text-align: center;border:1px;border-style:solid;" width="40%">
            <strong style="font-size: 14px">FACTURA ELECTRONICA<br>
            RUC: '.$ruc_empresa.'<br>
            '.$serie.'-'.$numero.'</strong>
        </td>
    </tr>
</table>
<table style="width: 100%; padding-top: 10px;padding-bottom: 10px;">
    <tr>
        <td style="text-align: left" width="10%">SEÑOR(ES)</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="59%">'.$razon.'</td>

        <td style="text-align: left" width="10%">FECHA</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="19%">'.$fecha.'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="10%">RUC</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="59%">'.$ruc.'</td>

        <td style="text-align: left" width="10%">MONEDA</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="19%">'.$moneda.'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="10%">DIRECCIÓN</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="59%">'.$direccion.'</td>
    </tr>
</table>

';

// set core font
$pdf->SetFont('arial', '', 10);

// output the HTML content
$pdf->writeHTML($html, true, 0, true, true);

$pdf->Ln();

$style = array(
  'position' => 'L',
  'align' => 'L',
  'stretch' => false,
  'fitwidth' => true,
  'cellfitalign' => '',
  'border' => false,
  'padding' => 0,
  'fgcolor' => array(0,0,0),
  'bgcolor' => false,
  'text' => false
//     'font' => 'helvetica',
//     'fontsize' => 8,
//     'stretchtext' => 4
);

$pdf->SetY(-26);
// Page number
$pdf->SetFont('helvetica', '', 9);
//$this->SetTextColor(0,0,0);
$pdf->Cell(0, 0, 'Página '.$pdf->getAliasNumPage().' de '.$pdf->getAliasNbPages(), 'T', 1, 'R', 0, '', 0, false, 'T', 'M');

$codigo='CAV-'.str_pad($_GET['d1'], 4, "0", STR_PAD_LEFT);

$pdf->write1DBarcode($codigo, 'C128', '', 271, '', 6, 0.3, $style, 'N');
$pdf->Cell(0, 0, 'www.prestamosdelnortechiclayo.com', 0, 1, 'C', 0, '', 0, false, 'T', 'M'); 


// output the HTML content
//$pdf->writeHTML($html, true, 0, true, true);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$nombre_archivo=$codigo."_".$title.".pdf";
$pdf->Output($nombre_archivo, 'I');
//============================================================+
// END OF FILE                                                
//============================================================+
?>