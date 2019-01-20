<?php
session_start();
require_once('../../libreriasphp/html2pdf/_tcpdf_5.9.206/tcpdf.php');

require_once ("../../config/Cado.php");
require_once ("../../config/datos.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../venta/cVentapago.php");
$oVentapago = new cVentapago();
require_once ("../formatos/numletras.php");
require_once ("../formatos/formato.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();

$dts= $oVenta->mostrar_cabecera_manifiesto($_POST['hdd_vh_id']);
$dt = mysql_fetch_array($dts);

$fecha=$dt['tb_viajehorario_fecha'];
$hora=$dt['tb_viajehorario_horario'];
$origen=$dt['Origen'];
$destino=$dt['Destino'];
$marca=$dt['tb_vehiculo_marca'];
$placa=$dt['tb_vehiculo_placa'];
$conductor=$dt['tb_conductor_nom'];
$licencia=$dt['tb_conductor_lic'];

mysql_free_result($dts);



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
$pdf->SetMargins(7, 10, 10);// left top right
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
        font-family: Verdana, Arial, Consolas;
        margin: 0px;
        padding-top: 0px;
        font-size: 7.5pt;
    }

    .header_row th {
      
        text-transform:uppercase;
    }
    .odd_row td {
        background-color: transparent;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .even_row td {
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: #f6f6f6;
    }
    .row td{
    
    }
</style>

<style media="print">
    .oculto{
        display: none;
    }

</style>
<body>
<table style="width: 194mm;" border="0">';
if($estado=="ANULADA"){
    $html.='<tr>
	    <td width="50%"></td>
	    <td width="10%"></td>
	    <td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
	    </tr>';
}
$html.='
    <tr>
        <td colspan="4" style="text-align: left; height:48mm;"></td>
    </tr>
</table>
<table style="width: 194mm;" border="0">
    <tr><!--punto de partida -->
        <td style="text-align: left;width:26mm; height:11mm;">&nbsp;</td>
        <td style="text-align: left;width:74mm;">'.$fecha.'</td>
        <td style="text-align: left;width:23mm;"></td>
        <td style="text-align: left;width:74mm;">'.$hora.'</td>
    </tr>
 </table>

<table border="0" style="width: 194mm;">
    <tbody>
        <tr>
            <td colspan="5" style="height: 6mm;"></td>
        </tr>';
    $dts=$oVenta->mostrar_manifiesto($_POST['hdd_vh_id']);
    $cont = 1;
    $tipo_doc="";
    while($dt = mysql_fetch_array($dts)){
        if($dt['tb_cliente_tip']==1){$tipo_doc="DNI";}elseif ($dt['tb_cliente_tip']==3){$tipo_doc="OTROS";}
        $html.='<tr>';

        $html .= '   
                    <td style="text-align:center; width: 8mm">'.$cont.'</td>
                    <td style="text-align:left;width: 90mm">' .$dt["tb_cliente_nom"] .'</td>
                    <td style="text-align: center; width: 10mm">' .$tipo_doc.'</td>
                    <td style="text-align:center; width: 25mm">' .$dt["tb_cliente_doc"]. '</td>
                    <td style="text-align:center; width: 10mm">' .$dt["tb_asiento_nom"].'</td>
                    <td style="text-align:center; width: 25mm">' .$dt["tb_venta_numdoc"].'</td>
                    <td style="text-align:center; width: 25mm">' .$dt["tb_venta_tot"].'</td>';
        $html.='</tr>';
        $cont++;
    }
    mysql_free_result($dts);
    $html.='
    </tbody>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);


$pdf->Output($nombre_archivo, 'I');
