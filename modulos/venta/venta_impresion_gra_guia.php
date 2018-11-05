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
if($estado=="ANULADA"){
    $html.='<tr>
	    <td width="50%"></td>
	    <td width="10%"></td>
	    <td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
	    </tr>';
}
$html.='<tr>
        <td style="text-align: left" width="15%" align="left">
        <img src="'.$empresa_logo.'" alt="" width: "100%">
        </td>   
        <td style="text-align: left" width="55%" align="left"><strong style="font-size: 11pt">'.$razon_defecto.'</strong><br>'.$direccion_defecto.'
        </td>
        <!-- <td width="20%" style="text-align: center">
            <img src="../../images/banderas.jpg" alt="" style="max-width: 50%" height="40px" align="left">
        </td> -->
        <td style="text-align: center;" width="30%" border="1">
            <strong style="font-size: 11pt">'.$tipodoc.'<br>
            RUC: '.$ruc_empresa.'<br>
            '.$serie.'-'.$numero.'</strong>
        </td>
    </tr>
</table>
<br/>
<br/>
<br/>
<table style="width: 100%;" border="0">
    <tr>
        <td style="text-align: left" width="20%">FECHA DE EMISIÓN</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="18%">'.$fecha.'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="20%">PUNTO DE PARTIDA</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$guia['tb_guia_punpar'].'</td>
    </tr>
    <tr>
     <td style="text-align: left" width="20%">DESTINATARIO</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$guia['tb_guia_des'].'</td>
       </tr>
    
    <tr>
        <td style="text-align: left" width="20%">RUC</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$ruc_empresa.'</td>
    </tr>
    <tr>
        <td style="text-align: left; vertical-align:top;" width="20%">PUNTO DE LLEGADA</td>
        <td style="text-align: left; vertical-align:top;" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$guia['tb_guia_punlle'].'</td>
    </tr>
</table>
<br/>
<br/>
<br/>
<table border="0.5" style="border-color: #00aa00;">
    <thead>
        <tr>
        <th width="40%" style="text-align: left; background-color: #00aa00; color: white;">
           Unidad de Transporte y Conductor
        </th>
         <th width="40%" style="text-align: left; background-color: #00aa00; color: white;">
           Empresa de Transportes
        </th>
         <th width="20%" style="text-align: left; background-color: #00aa00; color: white;">
           Motivo de Traslado
        </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="40%" style="text-align: left;"><b>MARCA Y N° DE PLACA: </b> ' . $guia['tb_guia_pla'] / $guia['tb_guia_mar'] . '</td>
            <td width="40%" style="text-align: left;"><b>NOMBRE O RAZON SOCIAL: </b> ' . $trans_razsoc . '</td>
            <td width="20%" style="text-align: left;" rowspan="2"><b>MOTIVO: </b>' . $guia_ope . '</td>
        </tr>
        <tr>
            <td width="40%" style="text-align: left;"><b>CONDUCTOR: </b>' . $cond_nombre . '</td>
            <td width="40%" style="text-align: left;"><b>RUC: </b>' . $trans_ruc . '</td>
        </tr>
    </tbody>
</table>
<br>
<br>
<table style="width: 100%; border: 0.5px solid #01a2e6; border-collapse:collapse;">
    <tbody>
        <tr class="header_row">
            <th style="text-align: center; width: 20%;"><b>CANT.</b></th>
            <th style="text-align: center; width: 60%;"><b>NOMBRE/PRESENTACIÓN</b></th>
            
            <th style="text-align: center; width: 20%;"><b>CATEGORIA/MARCA</b></th>
        </tr>';
$dts = $oGuia->mostrar_guia_detalle($guia_id);
$cont = 1;
while($dt = mysql_fetch_array($dts)){
    $codigo = $cont;
    $html.='<tr class="row">';

    $html .= '<td style="text-align:center">' . $dt["tb_guiadetalle_can"] . '</td>
                 <td style="text-align: center">' . $dt["tb_producto_nom"] . ' / '.$dt['tb_presentacion_nom'].'</td>
                 <td style="text-align: left">' . $dt["tb_categoria_nom"] . ' / ' . $dt['tb_marca_nom'] . '</td>';
    $html.='</tr>';
    $cont++;
}
$html.='</tbody>
</table>
<br>
<br>';

$html.='
<br>
<br>
<table>
<tr>
<td style="width:78%">';
$html.='<br/>
<p style="font-size:7pt">
Código de Seguridad (Hash): '.$digval.'<br>
Representación Impresa de la '.$tipodoc.'.<br>Esta puede ser consultada en: '.$d_documentos_app.'<br>
'.$d_resolucion.'
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


$params = $pdf->serializeTCPDFtagParameters(array($ruc_empresa.'|'.$serie.'|'.$numero.'|'.mostrarfecha($fecha).'|'.$ruc.'|', 'QRCODE,Q', '', '', 30, 30, $style, 'N'));
$html .= '<tcpdf method="write2DBarcode" params="'.$params.'" />
</td>
</tr>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);


$pdf->Output($nombre_archivo, 'I');
