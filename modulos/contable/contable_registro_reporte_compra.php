<?php
session_start();
require_once ("../../config/Cado.php");
require_once('../../libreriasphp/html2pdf/_tcpdf_5.9.206/tcpdf.php');
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../compra/cCompra.php");
$oCompra = new cCompra();
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once("../formatos/formato.php");
require_once("../formatos/fechas.php");

$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa=$dt['tb_empresa_ruc'];
$razon_defecto = $dt['tb_empresa_razsoc'];
$direccion_defecto = $dt['tb_empresa_dir'];

$mes = strtoupper(nombre_mes($_POST['cmb_fil_mes']));

$fecha_actual=$d=date('d/m/Y');
$titulo='REPORTE DE VENTAS';

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
$pdf->AddPage('L', 'A4');

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
        font-size: 5pt;
    }

    .header_major_row th {
        border: 0.9px solid #000000;
        background-color: #d6d6d6;
        color: black;
        text-transform:uppercase;
        vertical-align: middle;
    }
    .header_minor_row th {
        border-bottom: 0.9px solid #000000;
        border-right: 0.9px solid #000000;
        border-left: 0.9px solid #000000;
        background-color: #FFF;
        color: black;
        text-transform:uppercase;
    }
    .total{
        text-align: center; 
        border-top: 1px black solid; 
        padding-top: 10px; 
        padding-bottom: 10px;
        margin-bottom: 40px;
        margin-top: 40px;
    }
    .total_general{
        text-align: center; 
        border-top: 2px black solid;
        border-bottom: 2px black solid;  
        padding-top: 10px; 
        padding-bottom: 10px;
        margin-bottom: 40px;
        margin-top: 40px;
    }
    
</style>

<style media="print">
    .oculto{
        display: none;
    }

</style>
<body>
<div style="font-size: 30px;">
<b>'.$razon_defecto.'</b><br>
'.$direccion_defecto.'<br>
RUC:'.$ruc_empresa.'<br>
</div>
<div style="font-size: 30px; text-align: center">
<b>*** REGISTRO DE COMPRAS DEL MES DE '.$mes.' DEL '.$_POST['cmb_fil_anio'].'*** </b><br>
<b>SOLES</b>
</div>
<div style="font-size: 25px; text-align: right">
<b>'.$fecha_actual.'</b>
</div>
<br>
<br>
<br>
<table style="width: 100%; border-collapse:collapse;">
        <thead>
            <tr class="header_major_row">
            <th rowspan="2" style="text-align: center; width: 2%;"><br><br><b>O.</b></th>
            <th rowspan="2" style="text-align: center; width: 3%;"><br><br><b>N° VOU</b></th>
            <th rowspan="2" style="text-align: center; width: 5%;"><br><br><b>F. Emisión</b></th>
            <th rowspan="2" style="text-align: center; width: 5%;"><br><br><b>F. Venc.</b></th>
            <th colspan="3" scope="colgroup"  style="text-align: center;"><br><br>Datos del Documento</th>
            <th colspan="4" scope="colgroup"  style="text-align: center;"><br><br>Referencia del Documento</th>
            <th colspan="3" scope="colgroup"  style="text-align: center; width: 15%"><br><br>Datos del Proveedor</th>
            <th rowspan="2" style="text-align: center;"><b>Base Imp. Adq Grav. y de Exp. A</b></th>
            <th rowspan="2" style="text-align: center;"><b>Base Imp. Adq Grav.  y de Exp. y no Grav. B</b></th>
            <th rowspan="2" style="text-align: center;"><b>Base Imp. Adq Grav. sin Der. Credito Fiscal C</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Adq. no Gravadas</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>I.S.C.</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>I.G.V. A</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>I.G.V. B</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>I.G.V. C</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Otros Tributos</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Total</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>T/C</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Spot Fecha</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Spot Numero</b></th>
        </tr>
        <tr class="header_minor_row">
            <th style="text-align: center;"><br><br><b>T/D</b></th>
            <th style="text-align: center;"><br><br><b>Serie</b></th>
            <th style="text-align: center;"><br><br><b>Número</b></th>
            
            <th style="text-align: center;"><br><br><b>Fecha</b></th>
            <th style="text-align: center;"><br><br><b>T/D</b></th>
            <th style="text-align: center;;"><br><br><b>Serie</b></th>
            <th style="text-align: center;;"><br><br><b>Número</b></th>
            
            <th style="text-align: center;"><br><br><b>Doc</b></th>
            <th style="text-align: center;"><br><br><b>Número</b></th>
            <th style="text-align: center;"><br><br><b>Razón Social</b></th>  
        </tr><thead>';

        $dts1=$oCompra->mostrar_filtro_por_mes_anio($_POST['cmb_fil_mes'],$_POST['cmb_fil_anio'],$_SESSION['empresa_id']);
        $num_rows= mysql_num_rows($dts1);
        $base = 0;
        $igv = 0;
        $total = 0;

        $html .= '<tbody>
        <tr><td colspan="20"></td></tr><tr><td colspan="22"></td></tr>
        <tr><td colspan="20"></td></tr><tr><td colspan="20"></td></tr>';
        while ($dt = mysql_fetch_array($dts1)) {
            $base+=$dt['tb_compra_valven'];
            $igv+=$dt['tb_compra_igv'];
            $total+=$dt['tb_compra_tot'];
            $numdoc = split('-', $dt['tb_compra_numdoc']);
            $html .= '<tr>';
            $html .= '
                        <td style="text-align: center">1</td>
                        <td style="text-align: center">' . $dt['tb_compra_id'] . '</td>
                        <td style="text-align: center">' . $dt['tb_compra_fec'] . '</td>
                        <td style="text-align: center">' . $dt['tb_compra_fec'] . '</td>
                        <td style="text-align: center">' . $dt["tb_documento_id"] . '</td>               
                        <td style="text-align: center">' . $numdoc[0] . '</td>
                        <td style="text-align: center">' . $numdoc[1] . '</td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center">' . $dt['tb_proveedor_tip'] . '</td>
                        <td style="text-align: center">' . $dt['tb_proveedor_doc'] . '</td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center">' . $dt['tb_compra_valven'] . '</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">' . $dt['tb_compra_igv'] . '</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">' . $dt['tb_compra_tot'] . '</td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        ';
            $html .= '</tr>';
            $cont++;
        }
        $html .= '<tr><td colspan="22"></td></tr><tr><td colspan="22"></td></tr>';
        $html .= '<tr class="row_total">
                    <td colspan="13" style="text-align: right;">TOTALES:</td>       
                    <td class="total"></td>
                    <td class="total">'.$base.'</td>
                    <td class="total">0.00</td>
                    <td class="total">0.00</td>
                    <td class="total">0.00</td>
                    <td class="total">0.00</td>
                    <td class="total">'.$igv.'</td>
                    <td class="total">0.00</td>
                    <td class="total">0.00</td>
                    <td class="total">0.00</td>
                    <td class="total">'.$total.'</td>
                 </tr>';
        $html .= '<tr class="row_total_general">
                    <td colspan="13" style="text-align: right;">TOTAL GENERAL:</td> 
                    <td class="total_general"></td>
                    <td class="total_general">'.$base.'</td>
                    <td class="total_general">0.00</td>
                    <td class="total_general">0.00</td>
                    <td class="total_general">0.00</td>
                    <td class="total_general">0.00</td>
                    <td class="total_general">'.$igv.'</td>
                    <td class="total_general">0.00</td>
                    <td class="total_general">0.00</td>
                    <td class="total_general">0.00</td>
                    <td class="total_general">'.$total.'</td>
                 </tr>';
        $html .= '</tbody></table>;
        <br/>
        <br/>
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



$html .= '
</td>
</tr>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);

//$pdf->write2DBarcode($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$idtipodni.'|'.$ruc.'|', 'QRCODE,Q', 157, 99, 40, 40, $style, 'N');

$pdf->Output($nombre_archivo, 'I');



