<?php


// Include the main TCPDF library (search for installation path).
require_once('../../libreriasphp/html2pdf/_tcpdf_5.9.206/tcpdf.php');

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
$custom_layout = array(104, 104);
$pdf = new MYPDF('P', 'mm', $custom_layout, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('www.a-zetasoft.com');
$pdf->SetTitle($title);
$pdf->SetSubject('www.a-zetasoft.com');
$pdf->SetKeywords('www.a-zetasoft.com');

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
$pdf->AddPage();

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
        font-family: Verdana, Arial, Consolas;
        margin: 0px;
        padding-top: 0px;
        font-size: 7.5pt;
    }

    .header_row th {
        border-bottom: 0.9px solid #01a2e6;
        border-right: 0.9px solid #01a2e6;
        border-left: 0.9px solid #01a2e6;
        background-color: #01a2e6;
        text-transform:uppercase;
    }
    .odd_row td {
        background-color: transparent;
        border-bottom: 0.9px solid #01a2e6;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .even_row td {
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: #f6f6f6;
        border-bottom: 0.9px solid #01a2e6;
    }
    .row td{
        border-right: 0.9px solid #01a2e6;
        border-left: 0.9px solid #01a2e6;
    }
</style>

<style media="print">
    .oculto{
        display: none;
    }

</style>
<body>';
$style = array(
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

$font_size = $pdf->pixelsToUnits('25');
$pdf->SetFont ('helvetica', '', $font_size , '', 'default', true );
$pdf->Rotate(90);

$pdf->MultiCell(30, 14, $_POST['precio_prod'], 0, 'C', 0, 0, -6,6, true, 0, false);
$pdf->write1DBarcode($_POST['barcode'], 'C128', -6, 10, 30, 14, 0.4, $style, 'N');
$pdf->MultiCell(34, 14, $_POST['barcode'], 0, 'C', 0, 0, -8, 25, true, 0, false);

$pdf->MultiCell(30, 14, $_POST['precio_prod'], 0, 'C', 0, 0, -40,6, true, 0, false);
$pdf->write1DBarcode($_POST['barcode'], 'C128', -40, 10, 30, 14, 0.4, $style, 'N');
$pdf->MultiCell(34, 14, $_POST['barcode'], 0, 'C', 0, 0, -42, 25, true, 0, false);

$pdf->MultiCell(30, 14, $_POST['precio_prod'], 0, 'C', 0, 0, -74,6, true, 0, false);
$pdf->write1DBarcode($_POST['barcode'], 'C128', -74, 10, 30, 14, 0.4, $style, 'N');
$pdf->MultiCell(34, 14, $_POST['barcode'], 0, 'C', 0, 0, -76, 25, true, 0, false);

$html .= '
</td>
</tr>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);

//$pdf->write2DBarcode($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$idtipodni.'|'.$ruc.'|', 'QRCODE,Q', 157, 99, 40, 40, $style, 'N');
$nombre_archivo = 'codbarras_'.$_POST['barcode'].'.pdf';
$pdf->Output($nombre_archivo, 'I');