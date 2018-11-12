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

require_once("../guia/cGuia.php");
$oGuia = new cGuia();

require_once ("../conductor/cConductor.php");
$oConductor = new cConductor();

require_once ("../transporte/cTransporte.php");
$oTransporte = new cTransporte();

$ven_id=$_POST['ven_id'];

$guias = $oGuia->mostrarGuiaUno($ven_id);
$guia = mysql_fetch_array($guias);
$guia_id = $guia['tb_guia_id'];
$fecha  = mostrarFecha($guia['tb_guia_fec']);

if($guia['tb_guia_tipope'] == 1){
    $guia_ope = "Transferencia";
}elseif ($guia['tb_guia_tipope'] == 2) {
    $guia_ope = "Venta";
}
$serie=$guia['tb_guia_serie'];
$numero=$guia["tb_guia_num"];


$cond_id=0;
if ($guia["tb_conductor_id"]){
    $cond_id = $guia["tb_conductor_id"];
}
$dts=$oConductor->mostrarUno($cond_id);
$dt = mysql_fetch_array($dts);
$cond_nombre=$dt['tb_conductor_nom'];
mysql_free_result($dts);

$dts=$oTransporte->mostrarUno($guia["tb_transporte_id"]);
$dt = mysql_fetch_array($dts);
$trans_razsoc=$dt['tb_transporte_razsoc'];
$trans_ruc=$dt['tb_transporte_ruc'];
mysql_free_result($dts);

$dts=$oEmpresa->mostrarUno($guia["tb_empresa_id"]);
$dt = mysql_fetch_array($dts);
$ruc_empresa=$dt['tb_empresa_ruc'];
$razon_defecto = $dt['tb_empresa_razsoc'];
$direccion_defecto = $dt['tb_empresa_dir'];
$contacto_empresa = "Teléfono:" . $dt['tb_empresa_tel'] ."Correo:" . $dt['tb_empresa_ema'];
$empresa_logo = '../empresa/'.$dt['tb_empresa_logo'];
if(!is_file($empresa_logo)){
    $empresa_logo='../../images/logo.jpg';
}
mysql_free_result($dts);

$dts=$oUsuario->mostrarUno($guia["tb_usuario_id"]);
$dt = mysql_fetch_array($dts);
$usugru		=$dt['tb_usuariogrupo_id'];
$usugru_nom	=$dt['tb_usuariogrupo_nom'];
$usu_nom	=$dt['tb_usuario_nom'];
$apepat		=$dt['tb_usuario_apepat'];
$apemat		=$dt['tb_usuario_apemat'];
$ema		=$dt['tb_usuario_ema'];
mysql_free_result($dts);

$tipodoc = 'GUIA DE REMISIÓN';

$ven_id=$_POST['ven_id'];

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
$pdf->SetMargins(10, 10, 10);// left top right
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
    table{
        border:1px solid #000;
    }
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
<body><table style="width: 190mm;" border="1">';
if($estado=="ANULADA"){
    $html.='<tr>
	    <td width="50%"></td>
	    <td width="10%"></td>
	    <td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
	    </tr>';
}
$html.='
    <tr>
        <td colspan="5" style="text-align: left; height:46mm;">hula</td>
    </tr>
</table>
<table style="190mm" border="1">
    <tr><!--punto de partida -->
        <td style="text-align: left;" width="25mm">&nbsp;</td>
        <td style="text-align: left;" width="70mm">'.$guia['tb_guia_punpar'].'</td>
        <td style="text-align: left;" width="23mm"></td>
        <td style="text-align: left;" width="72mm">-'.$guia['tb_guia_punlle'].'</td>
    </tr>
     <tr>
        <td colspan="4" style="text-align: left;height: 4mm"></td>
    </tr>
    <tr>
        <!--razon social destinatario -->
        <td style="text-align: left;" width="30mm"></td>
        <td style="text-align: left;" width="50mm">RAZON SOCIAL DESTINATARIO</td>
        <td style="text-align: left;" width="20mm"></td>
        <td style="text-align: left;" width="50mm">N° RUC</td>
    </tr>
    <tr>
        <!--fecha inicio traslado -->
        <td style="text-align: left;" width="30mm"></td>
        <td style="text-align: left;" width="50mm">FECHA INICIO TRASLADO</td>
        <td style="text-align: left;" width="20mm"></td>
        <td style="text-align: left;" width="45mm">FAC.002-4667</td>
        <td style="text-align: left;" width="45mm">COSTO MINIMO</td>
    </tr>
 </table>
 
 <table style="190mm" border="1"> 
    <tr> <!--ESPACIO UNIDAD TRASNSPORTE Y CONDUCTOR-->
        <td colspan="4" style="text-align: left;height: 5mm"></td>
    </tr>
    <tr>
        <!--marca y placa -->
        <td style="text-align: left;" width="25mm"></td>
        <td style="text-align: left;" width="60mm">MARCA PLACA</td>
        <td style="text-align: left;" width="20mm"></td>
        <td style="text-align: left;" width="85mm">RAZON SOCIAL EMPRESA</td>
    </tr>
    <tr>
        <!--constancia inscripcion-->
        <td style="text-align: left; width:30mm"></td>
        <td style="text-align: left;width:50mm">CONSTANCIA INSCRIPCION</td>
        <td style="text-align: left;width:25mm"></td>
        <td style="text-align: left;width:85mm"></td>
    </tr>
    <tr>
        <!--n licencia de conducir-->
        <td style="text-align: left;width:35mm"></td>
        <td style="text-align: left;width:70mm">LICENCIA</td>
        <td style="text-align: left;width:35mm">RUC TRANSPORTE</td>
        <td style="text-align: right;width:50mm">CERTIFICADO</td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%">&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align: left" width="100%">&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align: left; height:4mm;" width="18%">&nbsp;</td>
        <td width="40%" style="text-align: left;">' . $guia['tb_guia_pla'] / $guia['tb_guia_mar'] . '</td>
        <td style="text-align: left;" width="14%">&nbsp;</td>
        <td width="40%" style="text-align: left;">' . $trans_razsoc . '</td>
    </tr>
    <tr>
        <td style="text-align: left; height:4mm;" width="27%">&nbsp;</td>
        <td width="80%" style="text-align: left; "> ' . $guia['tb_guia_pla'] / $guia['tb_guia_mar'] . '</td>
    
    </tr>
    <tr>
        <td style="text-align: left;  height:4mm;" width="27%">&nbsp;</td>
        <td width="31%" style="text-align: left; ">' . $cond_nombre . '</td>
        <td style="text-align: left;" width="11%">&nbsp;</td>
        <td width="18%" style="text-align: left; ">' . $trans_ruc . '</td>
        <td style="text-align: left;" width="10%">&nbsp;</td>
        <td width="40%" style="text-align: left;">' . $trans_ruc . '</td>
    </tr>
</table>
<br>
<br>


 <!--DETALLES-->
<table border="1" style="width: 190mm;">
    <tbody>
        <tr class="header_row">
            <th style="text-align: center; width: 17mm;"></th>
            <th style="text-align: center; width: 113mm;"></th>
            <th style="text-align: center; width: 17mm;"></th>
            <th style="text-align: center; width: 23mm;"></th>
            <th style="text-align: center; width: 20mm;"></th>
        </tr>';
$dts = $oGuia->mostrar_guia_detalle($guia_id);
$cont = 1;
while($dt = mysql_fetch_array($dts)){
    $codigo = $cont;
    $html.='<tr>';

    $html .= '<td style="text-align:center; width: 20mm">-</td>
                <td style="text-align:center;width: 17mm">00530033</td>
                 <td style="text-align: center; width: 113mm; font-size; 10pt;">' . $dt["tb_producto_nom"] .' / '. $dt["tb_categoria_nom"] . ' / ' . $dt['tb_marca_nom'] .'</td>
                 <td style="text-align:center; width: 17mm">' . $dt["tb_guiadetalle_can"] . '</td>
                 <td style="text-align:center; width: 23mm">NIU</td>
                 <td style="text-align:center; width: 20mm">-</td>';
    $html.='</tr>';
    $cont++;
}
$html.='</tbody>
</table>';

$html.='
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);


$pdf->Output($nombre_archivo, 'I');
