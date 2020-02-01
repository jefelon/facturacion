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

$dts7= $oVenta->mostrarUno($ven_id);
$dt7 = mysql_fetch_array($dts7);

$cli_id	=$dt7['tb_cliente_id'];
$cli_doc=$dt7['tb_cliente_doc'];

mysql_free_result($dts7);

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
        global $html2;
        $this -> SetY(-39);
        $this->SetFont('helvetica', '', 9);
        $this->writeHTML($html2, true, 0, true, true);
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
        font-size: 8pt;
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
<table style="width: 110mm;" border="0">';
if($estado=="ANULADA"){
    $html.='<tr>
	    <td width="50%"></td>
	    <td width="10%"></td>
	    <td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
	    </tr>';
}
$html.='
    <tr>
        <td style="text-align: left; height:40mm;"></td>
    </tr>
    <tr>
        <td style="text-align: left;width:21mm;">&nbsp;</td>
        <td style="width: 35mm">
            <table><tr><td>'.mostrarDiaMesAnio3(1,$guia['tb_guia_fec']).'</td><td>'.mostrarDiaMesAnio3(2,$guia['tb_guia_fec']).'</td><td>'.mostrarDiaMesAnio3(3,$guia['tb_guia_fec']).'</td></tr></table>
        </td>
        <td style="width:17mm;"></td>
        <td style="width: 35mm">
            <table><tr><td>'.mostrarDiaMesAnio3(1,$guia['tb_guia_fec']).'</td><td>'.mostrarDiaMesAnio3(2,$guia['tb_guia_fec']).'</td><td>'.mostrarDiaMesAnio3(3,$guia['tb_guia_fec']).'</td></tr></table>
        </td>
    </tr>
    <tr><td style="width: 100%;height: 8mm"></td></tr>
</table>
<table style="width: 194mm;" border="0">
    <tr><!--punto de partida -->
        <td style="text-align: left;width:95mm;height: 15mm">'.$guia['tb_guia_punpar'].'</td>
        <td style="text-align: left;width:4mm;"></td>
        <td style="text-align: left;width:95mm;">'.$guia['tb_guia_punlle'].'</td>
    </tr>
    <tr><td style="height: 4mm" colspan="3"></td></tr>
    <tr>
        <td style="text-align: left; width:90mm;height: 15mm">&nbsp;
            <table><!--razon social destinatario -->
                <tr><td style="width: 27mm; height: 7mm"></td><td>'.$guia['tb_guia_des'].'</td></tr>
                <tr><td style="width: 50mm"></td><td>'.$cli_doc.'</td></tr>
            </table>
        </td>
        <td style="text-align: left; width:14mm"></td>
        <td style="text-align: left; width:90mm;">&nbsp;
            <table><!--UNIDAD DE TRANSPORTE -->
                <tr><td style="width: 27mm;height: 7mm"></td><td>'. $marca.' / '.$placa .'</td></tr>
                <tr><td style="width: 50mm;height: 5mm"></td><td>-</td></tr>
                <tr><td style="width: 50mm;height: 5mm"></td><td>'.$cond_lic.'</td></tr>
            </table>
        </td>
    </tr>
 </table>

<table border="0" style="width: 194mm;font-size: 9pt">
    <tbody>
        <tr>
            <td colspan="5" style="height: 6mm;"></td>
        </tr>';
$dts = $oGuia->mostrar_guia_detalle($guia_id);
$cont = 1;
while($dt = mysql_fetch_array($dts)){
    $codigo = $cont;
    $html.='<tr>';

    $html .= '
                 <td style="text-align: left; width: 135mm;">'. $dt["tb_presentacion_cod"] .' ' . $dt["tb_producto_nom"] .' - ' . $dt['tb_marca_nom'] .'</td>
                 <td style="text-align:center; width: 17mm">NIU</td>
                 <td style="text-align:right; width: 19mm">' . $dt["tb_guiadetalle_can"] . '</td>
                 <td style="text-align:center; width: 23mm">-</td>';
    $html.='</tr>';
    $cont++;
}
$html.='
</tbody>
</table>';

$html2='';
$html2.='
 <table width="96mm" border="0"> 
    <tr>
        <td style="width: 13mm"></td>
        <td style="text-align: left;width:85mm;height: 9mm;">' . $trans_razsoc . '</td>
    </tr>
    <tr>
        <td style="width: 10mm"></td>
        <td style="text-align: left;width:88mm ;height: 10mm">' . $trans_ruc . '</td>
    </tr>
    <tr>
        <td style="width: 10mm"></td>
        <td style="text-align: left;width:88mm">FAC.: '.$guia['tb_guia_numdoc'].'</td>
    </tr>
 </table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);


$pdf->Output($nombre_archivo, 'I');
