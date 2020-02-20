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

$fecha=strtotime($dt['tb_viajehorario_fecha']);
$hora=$dt['tb_viajehorario_horario'];
$origen=$dt['Origen'];
$destino=$dt['Destino'];
$max_asientos=$dt['tb_vehiculo_numasi'];
$marca=$dt['tb_vehiculo_marca'];
$placa=$dt['tb_vehiculo_placa'];
$conductor=$dt['tb_conductor_nom'];
$copiloto=$dt['tb_copiloto_nom'];
$licencia=$dt['tb_conductor_lic'];
$copiloto_lic=$dt['tb_copiloto_lic'];

$ruc=$_SESSION['empresa_ruc'];

$certmtc="";

mysql_free_result($dts);


$dts=$oVenta->mostrar_manifiesto($_POST['hdd_vh_id']);
$num_asientos_ocupados= mysql_num_rows($dts);


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

         $this -> SetY(-8);
         // Page number
         $this->SetFont('helvetica', '', 6);
         //$this->SetTextColor(0,0,0);
         $this->Cell(0, 0, 'NUMERO DE AUTORIZACIÓN DE IMPRESIÓN: 0599155053', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
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
        font-size: 7.2pt;
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
<table style="width: 194mm;" border="0">
<tbody>
    <tr>
        <td style="text-align: center; width: 106mm">
            <tr>
                <td style="width: 78mm;">
                    <table style="width: 78mm; height: 18mm;" border="0">
                        <tr><td style="text-align: center; font-size: 4mm;">Transportes y Turismo</td></tr>
                        <tr><td style="text-align: center; font-size: 4mm;">Angeles Tour Jul Perú S.a.c</td></tr>
                        <tr><td style="text-align: center; font-size: 1.5mm;">Domic. Fiscal Av. Lima 749 - Cercado</td></tr>
                        <tr><td style="text-align: center; font-size: 1.5mm;">CAMANÁ - CAMANÁ - AREQUIPA</td></tr>
                        <tr><td style="text-align: center; font-size: 2.5mm;">Sucursal: Terminal Terrestre Counter B-16</td></tr>
                        <tr><td style="text-align: center; font-size: 2.5mm;">JACOBO HUNTER - AREQUIPA - AREQUIPA</td></tr>
                    </table>
                </td>
                <td style="height: 23mm; width: 28mm;">
                    <table style="width: 30mm;" border="0">
                        <tr>
                            <td style="width: 28mm; height: 8mm;">
                                <table style="width: 27mm; height: 8mm;" border="1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;width:8mm;background-color: orange; color: black;">DÍA</th>
                                            <th style="text-align: center;width:8mm;background-color: orange; color: black;">MES</th>
                                            <th style="text-align: center;width:8mm;background-color: orange; color: black;">AÑO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center;width:8mm;">'.date("d", $fecha).'</td>
                                            <td style="text-align: center;width:8mm;">'.date("m", $fecha).'</td>
                                            <td style="text-align: center;width:8mm;">'.date("Y", $fecha).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>  
                            <td style="width: 28mm; height: 8mm;">
                                <table style="width: 24mm; height 8mm;" border="1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;width:24mm;background-color: orange; color: black;">HORA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center;width:24mm;">'.$hora.'</td>
                                        </tr>
                                    </tbody>
                                </table>  
                            </td>    
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: left; width:10mm; font-weight: bold;">Origen:</td>
                <td style="text-align: left; width:43mm;"><div style="border-bottom: solid 1mm black;">'.$origen.'</div></td>
                <td style="text-align: left; width:11mm; font-weight: bold;">Destino:</td>
                <td style="text-align: left; width:43mm; border-bottom: solid 1mm black;"><div style="border-bottom: solid 1mm black;">'.$destino.'</div></td>
            </tr>
            <tr>
                <td valign="bottom" style="text-align: left;width:25mm; height:2mm; font-weight: bold;">Marca de Vehiculo:</td>
                <td valign="bottom" style="text-align: left;width:41mm; "><div style="border-bottom: solid 1mm black;">'.$marca.'</div></td>
                <td valign="bottom" style="text-align: left;width:9mm; font-weight: bold;">Placa:</td>
                <td valign="bottom" style="text-align: left;width:32mm;"><div style="border-bottom: solid 1mm black;">'.$placa.'</div></td>
            </tr>
            <tr>
                <td valign="bottom" style="text-align: left;width:23mm; height:2mm; font-weight: bold;">Nro de Cetif MTC:</td>
                <td valign="bottom" style="text-align: left;width:84mm;"><div style=" border-bottom: 1px solid black;">'.$certmtc.'</div></td>
            </tr>
        </td>
        <td style="text-align: center; height:40mm; width: 2mm;">
       
        </td>
        <td style="text-align: center; height:40mm; width: 82mm;">
            <table style="width: 82mm; margin-right: 25mm;" border="1">
               <tr>
                  <td style="text-align: center; font-size: 7mm; font-weight: bolder" width="82mm">R.U.C.'.$ruc.'</td>
               </tr>
               <tr style="background-color: orange; color: black;">
                  <td style="text-align: center; font-size: 5mm; font-weight: bold" width="82mm">MANIFIESTO DE PASAJEROS</td>
               </tr>
               <tr>
                  <td style="text-align: center; font-size: 4mm; font-weight: bold" width="82mm">'.$dt['tb_viajehorario_ser'].'-'.$dt['tb_viajehorario_num'].'</td>
               </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td valign="bottom" style="width: 94mm;" border="1">
            <tr>
                <td style="text-align: left;width:21mm; font-weight: bold;">Conductor:</td>
                <td style="text-align: right;width:71mm; font-weight: bold;">Nro de Licencia:</td>
            </tr>
            <tr>
                <td style="text-align: left;width:46mm;">
                    1.-'.$conductor.'
                </td>
                <td style="text-align: right;width:46mm;">
                    '.$licencia.'
                </td>
            </tr>
        </td>
        <td style="text-align: left;width:5mm;" ></td>
        <td valign="bottom" style="width: 94mm;" border="1">
            <tr>
                <td style="text-align: left;width:21mm; font-weight: bold;">Conductor:</td>
                <td style="text-align: right;width:71mm; font-weight: bold;">Nro de Licencia:</td>
            </tr>            <tr>
                <td style="text-align: left;width:46mm;">
                    2.-'.$copiloto.'
                </td>
                <td style="text-align: right;width:46mm;">
                    '.$copiloto_lic.'
                </td>
            </tr>
        </td>
    </tr>
    <tr>
        <td style="width: 194mm; height: 0.5mm;"></td>
    </tr>
    <tr>
        <td valign="bottom" style="text-align: left;width:34mm;">Cantidad Max de Asientos:</td>
        <td valign="bottom" style="text-align: center;width:7mm; border: 1px solid black;">'.$max_asientos.'</td>
        <td valign="bottom" style="text-align: left;width:34mm;">Ocupados por Tripulación:</td>
        <td valign="bottom" style="text-align: center;width:7mm; border: 1px solid black;">'.$num_asientos_ocupados.'</td>
        <td valign="bottom" style="text-align: left;width:46mm;">Pasajero embarcados en el terminal:</td>
        <td valign="bottom" style="text-align: center;width:7mm;border: 1px solid black;">'.$num_asientos_ocupados.'</td>
        <td valign="bottom" style="text-align: left;width:51mm;">Cantidad de pasajeros recogidos en ruta:</td>
        <td valign="bottom" style="text-align: center;width:7mm;border: 1px solid black;">'.'0'.'</td>
  
    </tr>
    <tr>
        <td style="width: 194mm; height: 0.1mm;"></td>
    </tr>
    </tbody>
 </table>

<table border="0" style="width: 194mm; font-size: 2.55mm;">
    <thead>
        <tr>
            <th style="border: 1px solid #000; text-align:center; width: 8mm; font-weight: bold;">Item</th>
            <th style="border: 1px solid #000; text-align:left; width: 80mm; font-weight: bold;">NOMBRES Y APELLIDOS</th>
            <th style="border: 1px solid #000; text-align:center; width: 16mm; font-weight: bold;">TIPO DOC.</th>
            <th style="border: 1px solid #000; text-align:center; width: 20mm; font-weight: bold;">Nº DE DOC</th>
            <th style="border: 1px solid #000; text-align:center; width: 18mm; font-weight: bold;">Nº ASIENTO</th>
            <th style="border: 1px solid #000; text-align:center; width: 30mm; font-weight: bold;">SERIE Nº BOLETO</th>
            <th style="border: 1px solid #000; text-align:right; width: 21mm; font-weight: bold;">IMPORTE S/</th>
        </tr>
    </thead>
    <tbody>';

$cont = 1;
$tipo_doc="";
while($dt = mysql_fetch_array($dts)){
    if($dt['tb_cliente_tip']==1){$tipo_doc="DNI";}elseif ($dt['tb_cliente_tip']==3){$tipo_doc="OTROS";}
    $html.='<tr>';

    $html .= '   
                    <td style="text-align:center;  width: 8mm; height: 2mm; border-left: 1px solid #000;
    border-right: 1px solid #000;">'.$cont.'</td>
                    <td style="text-align:left;border-left: 1px solid #000; width: 80mm;
    border-right: 1px solid #000;">' .$dt["tb_cliente_nom"] .'</td>
                    <td style="text-align: center; border-left: 1px solid #000; width: 16mm;
    border-right: 1px solid #000;">' .$tipo_doc.'</td>
                    <td style="text-align:center; border-left: 1px solid #000; width: 20mm;
    border-right: 1px solid #000;">' .$dt["tb_cliente_doc"]. '</td>
                    <td style="text-align:center; border-left: 1px solid #000; width: 18mm;
    border-right: 1px solid #000;">' .$dt["tb_asiento_nom"].'</td>
                    <td style="text-align:center; border-left: 1px solid #000; width: 30mm;
    border-right: 1px solid #000;">' .$dt["tb_venta_numdoc"].'</td>
                    <td style="text-align:right; border-left: 1px solid #000; width: 21mm;
    border-right: 1px solid #000;">' .$dt["tb_venta_tot"].'</td>';
    $html.='</tr>';
    $cont++;
}
mysql_free_result($dts);
$html.='
    </tbody>
</table>

<table style="font-size: 2.5mm">
    <tr>
        <td style="width: 194mm; height: 0.1mm;"></td>
    </tr>
    <tr>
        <td style="width: 28mm">OBSERVACIONES:</td><td style="border-bottom: 1px solid black; width: 166mm"></td>
    </tr>
    <tr>
        <td style="width: 194mm; height: 6mm;"></td>
    </tr>
    <tr>
        <td style="width: 10mm"></td>
        <td style="border-bottom: 1px solid black; width: 80mm"></td>
        <td style="width: 14mm"></td>
        <td style="border-bottom: 1px solid black; width: 80mm"></td>
        <td style="width: 10mm"></td>
    </tr>
    <tr>
        <td style="width: 10mm"></td>
        <td style="width: 80mm; text-align: center">CHOFER</td>
        <td style="width: 14mm"></td>
        <td style="width: 80mm; text-align: center">COPILOTO</td>
        <td style="width: 10mm"></td>
    </tr>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);


$pdf->Output($nombre_archivo, 'I');
