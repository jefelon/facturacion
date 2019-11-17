<?php
session_start();
if ($_SESSION["autentificado"] != "SI") {
    if ($_SESSION["autentificado2"] == "SI") {

    }
    else{
        header("location: ../../index.php");
        exit();
    }
}
require_once('../../libreriasphp/html2pdf/_tcpdf_5.9.206/tcpdf.php');

require_once ("../../config/Cado.php");
require_once ("../venta/cVentapago.php");
$oVentapago = new cVentapago();
require_once ("../formatos/formato.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../reportes/cReporte.php");
$oReporte = new cReporte();

$texto_vendedor="$usu_nom $apepat $apemat";

$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa=$dt['tb_empresa_ruc'];
$razon_defecto = $dt['tb_empresa_razsoc'];
$direccion_defecto = $dt['tb_empresa_dir'];
$contacto_empresa = "<b>Teléfono:</b> " . $dt['tb_empresa_tel'] ." <b>Celular: </b> " . $dt['tb_empresa_cel'] ." <br><b> Correo:</b>" . $dt['tb_empresa_ema'];
$texto_venta_producto="<i>".$dt['tb_empresa_teximp']."</i>";
$empresa_logo = '../empresa/'.$dt['tb_empresa_logo'];
$image_info = getimagesize($empresa_logo);
if(!is_file($empresa_logo)){
    $empresa_logo='../../images/logo.jpg';
}
mysql_free_result($dts);

$desde=$_POST['txt_fil_ven_fec1'];
$hasta=$_POST['txt_fil_ven_fec2'];
$filas=$_POST['txt_fil_filas'];
$punt_vent=$_POST['cmb_fil_ven_punven'];
$punt_vennombre=$_POST['cmb_fil_ven_punvennom'];
if($punt_vennombre=="" ||$punt_vennombre=="-" )$punt_vennombre="Todos";
$titulo_reporte = 'Reporte de los '.$filas.' productos más vendidos.';

$nombre_archivo = ''.$serie.'-'.$numero.'.pdf';


class MYPDF extends TCPDF
{
    public function Header() {
        global $empresa_logo,$titulo_reporte,$razon_defecto,$direccion_defecto,$punt_vennombre,$desde,$hasta;
        $image_file = $empresa_logo;
       // $this->Image($image_file, 20, 10, 71, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $html="
        <div>
            <h1>$razon_defecto</h1>
            <span>$titulo_reporte</span><br>
            <b>Punto Venta: </b>$punt_vennombre <b>Desde:</b> $desde  <b> Hasta:</b> $hasta  <b>
        </div>
        ";
         //Set font
        //$this->SetFont('helvetica', 'B', 15);
        // Title
//        $this->Cell(0, 25, $razon_defecto, 0, 15, 'C', 0, '', 0, false, 'M', 'B');
//        $this->Cell(0, 15, $titulo_reporte, 0, 25, 'C', 0, '', 0, false, 'M', 'B');
//        $this->SetFont('helvetica', 'N', 12);
        $this->writeHTMLCell(0, 15, 0, 0, $html, 0, '', 0, false, 'C', 'B');
    }
    public function Footer()
    {
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
           'text' => false,
           'font' => 'helvetica',
           'fontsize' => 8,
           'stretchtext' => 4,
         );

         $this -> SetY(-20);
         // Page number
         $this->SetFont('helvetica', '', 9);
         //$this->SetTextColor(0,0,0);
         $this->Cell(0, 0, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 'T', 1, 'R', 0, '', 0, false, 'T', 'M');

         $this->Cell(0, 0, 'Imprima solo si es necesario.', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
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
$pdf->SetMargins(12, 35, 12);// left top right
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// add a page
$pdf->AddPage('P', 'A4');
$html .= '
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
        border-top: 1px solid #008f39;
        border-right: 1px solid #008f39;
        border-left: 1px solid #008f39;
        background-color: #008f39;
        text-transform:uppercase;
    }

    .row td{
        border-right: 0.9px solid #008f39;
        border-left: 0.9px solid #008f39;
        line-height: 5px;
    }
    .cliente{
        border: 1px solid #008f39;
        border-spacing:4px;
    }

    .datos-empresa{
        text-align: center;
        font-size: 8.5pt;
    }

    .tipo-documento{
        text-align: center;
        font-size: 11pt;
    }
    

</style>

<body>';
$bordelineas="1px solid #008f39;";
$bordetop="border-top: 1px solid #008f39;";
$html.='       
<table style="width: 100%; border:'.$bordelineas.'; border-collapse:collapse;font-size: 8.5pt;">
    <tbody>
        <tr class="header_row">
            <th style="text-align: center; width: 10%;"><b>ITEM</b></th>
            <th style="text-align: left; width: 65%;"><b>PRODUCTO</b></th>
             <th style="text-align: center; width:15%;"><b>CANT. VENDIDO</b></th>
            <th style="text-align: center; width: 10%;"><b>MONTO</b></th>
        </tr>';
$dts = $oReporte->producto_mas_vendido(fecha_mysql($desde),fecha_mysql($hasta),$_SESSION['empresa_id'],$punt_vent,$filas);
$cont = 1;
$max_lin=1;
while($dt = mysql_fetch_array($dts)){
    if(strlen($dt["tb_producto_nom"].$ven_det_marca. $ven_det_serie)>66){
        $max_lin++;
    }
    $html.='<tr class="row">';
        $html .='
    <td style="text-align:center;">' . $cont . '</td>
    <td style="text-align:left;border-bottom: 0.9px solid #F1F4F7;z-index: -1">' . $dt['tb_producto_nom'] . '</td>
    <td style="text-align:center;">' . $dt['numero']. ' veces</td>';
        $dts2=$oReporte->total_ope(fecha_mysql($desde),fecha_mysql($hasta),$dt["tb_catalogo_id"],'CANCELADA',$_SESSION['empresa_id']);
        $dt2 = mysql_fetch_array($dts2);
        if($dt2['total']!=""){
            $html.='<td style="text-align:right;">'.formato_moneda($dt2['total']).'</td>';
        }
        else{
            $html.='<td style="text-align:right;">'.formato_moneda($dt2['total']).'</td>';
        }
    $html.='</tr>';
    $cont++;
    $max_lin++;
}
while ($max_lin<=55) {
    $html .= '<tr class="row">
        <td style="text-align: center"></td>
        <td style="text-align: left"></td>
        <td style="text-align: center"></td>
        <td style="text-align: center"></td>
     ';
    $html .= '</tr>';
    $max_lin++;
    $cont++;
}
$html.='</tbody>
</table>
</body>
</html>';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->writeHTML($html, true, 0, true, true);

$pdf->Output($nombre_archivo, 'I');

