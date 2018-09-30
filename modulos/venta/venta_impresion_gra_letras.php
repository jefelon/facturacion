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

require_once ("../letras/cLetras.php");
$cLetras = new cLetras();

$ven_id=$_POST['ven_id'];
$dts = $oVenta->mostrarUno($ven_id);

while($dt = mysql_fetch_array($dts))
{
    $idcomprobante=$dt["cs_tipodocumento_cod"];

    $serie=$dt["tb_venta_ser"];
    $numero=$dt["tb_venta_num"];

    $clicodigo=$dt["tb_cliente_id"];
    $ruc=$dt["tb_cliente_doc"];
    $razon=$dt["tb_cliente_nom"];
    $direccion=$dt["tb_cliente_dir"];
    if($dt["tb_cliente_tip"]==1)$idtipodni=1;
    if($dt["tb_cliente_tip"]==2)$idtipodni=6;

    $fecha=mostrarFecha($dt["tb_venta_fec"]);

    $toigv=$dt["tb_venta_igv"];
    $importetotal=$dt["tb_venta_tot"];
    $totopgrat=$dt["tb_venta_grat"];
    $totopexo=$dt["tb_venta_exo"];
    $totopgrav=$dt["tb_venta_gra"];
    $totopeina=$dt["tb_venta_ina"];
    $valorventa=$dt["tb_venta_valven"];
    $toisc="0.00";
    $totdes=$dt["tb_venta_des"];
    $totanti="0.00";
    $moneda=$dt["cs_tipomoneda_id"];

    $estsun=$dt['tb_venta_estsun'];
    $fecenvsun=mostrarFechaHora($dt['tb_venta_fecenvsun']);
    $faucod=$dt['tb_venta_faucod'];
    $digval=$dt['tb_venta_digval'];
    $sigval=$dt['tb_venta_sigval'];
    $val=$dt['tb_venta_val'];

    $estado=$dt['tb_venta_est'];

    $lab1=$dt['tb_venta_lab1'];
    $lab2=$dt['tb_venta_lab2'];
    $lab3=$dt['tb_venta_lab3'];
}


if($moneda==1){
    $moneda  = "SOLES";
    $mon = "S/ ";
    $monedaval=1;
}
if($moneda==2){
    $moneda  = "DOLARES";
    $mon = "$ ";
    $monedaval=2;
}


$ltrs1=$cLetras->mostrar_letras($_POST['ven_id']);


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
while($ltr= mysql_fetch_array($ltrs1)){
    $letras_monto =numtoletras($ltr['tb_letras_monto'],1);
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
<body><table style="width: 100%; margin-bottom: 50mm" border="0">';
$html.='
<table style="width: 100%;" border="0">
    <tr>
        <td style="text-align: left" width="15%"></td>
        <td style="text-align: left" width="8%">'.$ltr['tb_letras_numero'].'</td>
        <td style="text-align: left" width="20%"> '.$serie.'-'.$numero.'</td>
        <td style="text-align: left" width="18.5%">'.mostrarFecha($fecha).'</td>
        <td style="text-align: left" width="18.5%">'.mostrarFecha($ltr['tb_letras_fecha']).'</td>
        <td style="text-align: left" width="20%">'.$ltr['tb_letras_monto'].'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%"></td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%"></td>
    </tr>
    <tr>
        <td style="text-align: left" width="15%"></td>
        <td style="text-align: left" width="72%">'.$razon.'</td>
        <td style="text-align: left" width="13%">'.str_pad($clicodigo, 7, "0", STR_PAD_LEFT).'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%"></td>
    </tr>
    <tr>
        <td style="text-align: left" width="15%"></td>
        <td style="text-align: left" width="85%">'.$direccion.'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%"></td>
    </tr>
    <tr>
        <td style="text-align: left" width="15%"></td>
        <td style="text-align: left" width="3%"></td>
        <td style="text-align: left" width="3%">'.mostrarDiaMesAnio(1, $ltr['tb_letras_fecha']).'</td>
        <td style="text-align: left" width="3%"></td>
        <td style="text-align: left" width="10%">'.mostrarDiaMesAnio(2, $ltr['tb_letras_fecha']).'</td>
        <td style="text-align: left" width="3%"></td>
        <td style="text-align: left" width="5%">'.mostrarDiaMesAnio(3, $ltr['tb_letras_fecha']).'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%"></td>
    </tr>
    <tr>
        <td style="text-align: left" width="15%"></td>
        <td style="text-align: left" width="85%">'.$letras_monto.'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%"></td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%"></td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%"></td>
    </tr>
     <tr>
        <td style="text-align: justify" width="70%">Lorem ipsum es el texto que se usa habitualmente en diseño gráfico en demostraciones de tipografías o de borradores de diseño para probar el diseño visual 
        Lorem ipsum es el texto que se usa habitualmente en diseño gráfico en demostraciones de tipografías o de borradores de diseño para probar el diseño visual.
        Lorem ipsum es el texto que se usa habitualmente en diseño gráfico en demostraciones de tipografías o de borradores de diseño para probar el diseño visual
        </td>
    </tr>
</table>
<br/>
<br/>
<br/>';


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
</table>
</body>
</html>';
$pdf->writeHTML($html, true, 0, true, true);
}

$pdf->Output($nombre_archivo, 'I');
