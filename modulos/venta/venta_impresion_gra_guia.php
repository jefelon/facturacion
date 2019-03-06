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
$marca= $guia['tb_guia_mar'];
$placa= $guia['tb_guia_pla'];

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
$cond_lic=$dt['tb_conductor_lic'];
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
        <td colspan="4" style="text-align: left; height:38mm;"></td>
    </tr>
</table>
<table style="width: 194mm;" border="0">
    <tr>
        <!--fecha inicio traslado -->
        <td style="text-align: left; width:18mm; height:4mm;">&nbsp;</td>
        <td style="text-align: left; width:46mm; font-size: 40px;">'.mostrarFechaEspacios($guia['tb_guia_fec']).'</td>
        <td style="text-align: left; width:10mm;"></td>
        <td style="text-align: left; width:46mm; font-size: 40px;">'.mostrarFechaEspacios($guia['tb_guia_fec']).'</td>
        <td style="text-align: left; width:25mm;"></td>
        <td style="text-align: right; width:30mm;">-</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: left; height:3mm;"></td>
    </tr>
    <tr><!--punto de partida -->
        <td style="text-align: left;width:20mm; height:16mm;">&nbsp;</td>
        <td style="text-align: left;width:80mm;">'.$guia['tb_guia_punpar'].'</td>
        <td style="text-align: left;width:23mm;"></td>
        <td style="text-align: left;width:74mm;"></td>
    </tr>
    <tr><!--punto de partida -->
        <td style="text-align: left;width:15mm; height:7mm;">&nbsp;</td>
        <td style="text-align: left;width:80mm;vertical-align : middle;">&nbsp;<br>'.$guia['tb_guia_des'].'</td>
        <td style="text-align: left;width:23mm;"></td>
        <td style="text-align: left;width:74mm;"></td>
    </tr>
    <tr><!--punto de partida -->
        <td style="text-align: left;width:28mm; height:7mm;">&nbsp;</td>
        <td style="text-align: left;width:72mm;">'.$guia['tb_cliente_dir'].'</td>
        <td style="text-align: left;width:23mm;"></td>
        <td style="text-align: left;width:74mm;"></td>
    </tr>
     <tr><!--punto de partida -->
        <td style="text-align: left;width:25mm; height:9mm;">&nbsp;</td>
        <td style="text-align: left;width:75mm;">'.$guia['tb_cliente_doc'].'</td>
        <td style="text-align: left;width:23mm;"></td>
        <td style="text-align: left;width:74mm;"></td>
    </tr>
    <tr><!--punto de partida -->
        <td style="text-align: left;width:25mm; height:10mm;">&nbsp;</td>
        <td style="text-align: left;width:75mm;">'.$guia['tb_guia_punlle'].'</td>
        <td style="text-align: left;width:23mm;"></td>
        <td style="text-align: left;width:74mm;"></td>
    </tr>
    <tr><!--punto de partida -->
        <td style="text-align: left;width:25mm; height:10mm;">&nbsp;</td>
        <td style="text-align: left;width:75mm;">'.$guia['tb_guia_numdoc'].'</td>
        <td style="text-align: left;width:23mm;"></td>
        <td style="text-align: left;width:74mm;"></td>
    </tr>
 </table>
 
<table border="0" style="width: 188mm;">
    <tbody>
        <tr>
            <td colspan="5" style="height: 23mm;"></td>
        </tr>';
$dts = $oGuia->mostrar_guia_detalle($guia_id);
$cont = 1;
while($dt = mysql_fetch_array($dts)){
    $codigo = $cont;
    $html.='<tr>';

    $html .= '   <td style="text-align:center;width: 4mm"></td>
                 <td style="text-align:center;width: 18mm">' . $dt["tb_guiadetalle_can"] .'</td>
                 <td style="text-align:center; width: 18mm">' . $dt["tb_unidad_abr"] .'</td>
                 <td style="text-align: left; width: 127mm; font-size; 10pt;"> &nbsp; &nbsp; ' . $dt["tb_producto_nom"] .' / '. $dt["tb_categoria_nom"] . ' / ' . $dt['tb_marca_nom'] .'</td>
                 <td style="text-align:center; width: 21mm">-</td>';
    $html.='</tr>';
    $cont++;
}
$html.='
</tbody>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);


$pdf->Output($nombre_archivo, 'I');
