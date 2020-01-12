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
require_once ("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();

$cot_id=$_POST['cot_id'];
$dts = $oCotizacion->mostrarUno($cot_id);
$dt = mysql_fetch_array($dts);

$dts=$oUsuario->mostrarUno($dt['tb_usuario_id']);
$dt = mysql_fetch_array($dts);
$usugru		=$dt['tb_usuariogrupo_id'];
$usugru_nom	=$dt['tb_usuariogrupo_nom'];
$usu_nom	=$dt['tb_usuario_nom'];
$apepat		=$dt['tb_usuario_apepat'];
$apemat		=$dt['tb_usuario_apemat'];
$ema		=$dt['tb_usuario_ema'];

mysql_free_result($dts);

$texto_vendedor="$usu_nom $apepat $apemat";

$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa=$dt['tb_empresa_ruc'];
$razon_defecto = $dt['tb_empresa_razsoc'];
$direccion_defecto = $dt['tb_empresa_dir'];
$contacto_empresa = "<b>Teléfono:</b> " . $dt['tb_empresa_tel'] ."<b> Correo:</b>" . $dt['tb_empresa_ema'];
$texto_venta_producto="<i>".$dt['tb_empresa_teximp']."</i>";
$empresa_logo = '../empresa/'.$dt['tb_empresa_logo'];
mysql_free_result($dts);

$sucursales='
<table style="font-size:7pt" border="0">
    <tr>
        <td width="80">PRINCIPAL:</td>
        <td width="580">'.$dt['tb_empresa_dir'] .'</td>
    </tr>
    <tr>
        <td>TELEFONO: </td>
        <td>'.$dt['tb_empresa_tel'] .'</td>
    </tr>

    <tr>
        <td>CORREO:</td>
        <td>'.$dt['tb_empresa_ema'].'</td>
    </tr>
    <tr>
        <td>VENDEDOR:</td>
        <td>'.$texto_vendedor.'</td>
    </tr>
</table>';

$tipodoc = 'COTIZACIÓN';

$dts = $oCotizacion->mostrarUno($cot_id);
while($dt = mysql_fetch_array($dts))
{
    $idcomprobante=$dt["cs_tipodocumento_cod"];

    $serie=$dt["tb_cotizacion_ser"];
    $numero=$dt["tb_cotizacion_num"];
    $punto_venta_dir=$dt["tb_puntoventa_direccion"];
    $ruc=$dt["tb_cliente_doc"];
    $razon=$dt["tb_cliente_nom"];
    $direccion=$dt["tb_cliente_dir"];
    if($dt["tb_cliente_tip"]==1)$idtipodni=1;
    if($dt["tb_cliente_tip"]==2)$idtipodni=6;

    $fecha=mostrarFecha($dt["tb_cotizacion_fec"]);

    $toigv=$dt["tb_cotizacion_igv"];
    $importetotal=$dt["tb_cotizacion_tot"];
    $totopgrat=$dt["tb_cotizacion_grat"];
    $subtotal=$dt["tb_cotizacion_gra"];
    $valorventa=$dt["tb_cotizacion_valven"];
    $toisc="0.00";
    $totdes=$dt["tb_cotizacion_des"];
    $totanti="0.00";
    $moneda=1;

    $estsun=$dt['tb_cotizacion_estsun'];
      $fecenvsun=mostrarFechaHora($dt['tb_cotizacion_fecenvsun']);
      $faucod=$dt['tb_cotizacion_faucod'];

      $val=$dt['tb_cotizacion_val'];

    $estado=$dt['tb_cotizacion_est'];

    $lab1=$dt['tb_cotizacion_lab1'];
    $lab2=$dt['tb_cotizacion_lab2'];
    $lab3=$dt['tb_cotizacion_lab3'];
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

//pagos
$rws1=$oVentapago->mostrar_pagos($cot_id);
$num_rows_vp= mysql_num_rows($rws1);

if($num_rows_vp>0)
{
    while($rw1 = mysql_fetch_array($rws1))
    {
        //forma
        if($rw1['tb_formapago_id']==1)
        {
            $forma='';
            //modo
            if($rw1['tb_modopago_id']==1)
            {
                $modo=' EFECTIVO';
                $suma_pago1+=$rw1['tb_ventapago_mon'];
            }
            if($rw1['tb_modopago_id']==2)
            {
                $modo=' DEPOSITO OP: '.$rw1['tb_ventapago_numope'];
                $suma_pago2+=$rw1['tb_ventapago_mon'];
            }
            if($rw1['tb_modopago_id']==3)
            {
                $modo=''.$rw1['tb_tarjeta_nom'].' OP: '.$rw1['tb_ventapago_numope'];
                $suma_pago3+=$rw1['tb_ventapago_mon'];
            }
        }

        if($rw1['tb_formapago_id']==2)
        {
            $forma='CREDITO '.$rw1['tb_ventapago_numdia'].'D, FV: '.mostrarFecha($rw1['tb_ventapago_fecven']);

            //modo
            if($rw1['tb_modopago_id']==1)
            {
                $forma='CREDITO '.$rw1['tb_ventapago_numdia'].'D, FV: '.mostrarFecha($rw1['tb_ventapago_fecven']);
                $modo=' ';
                $suma_pago4+=$rw1['tb_ventapago_mon'];
            }
            if($rw1['tb_modopago_id']==2)
            {
                //$modo=' DEPOSITO N° Oper: '.$rw1['tb_ventapago_numope'];
                $suma_pago5+=$rw1['tb_ventapago_mon'];
            }
            if($rw1['tb_modopago_id']==3)
            {
                $forma='CDT ';
                $modo=''.$rw1['tb_tarjeta_nom'].' OP: '.$rw1['tb_ventapago_numope'];
                $suma_pago6+=$rw1['tb_ventapago_mon'];
            }
        }

        $pago_mon=formato_money($rw1['tb_ventapago_mon']);

        $texto_pago1[]=$forma.' '.$modo;
        $texto_pago2[]=$forma.' '.$modo.': S/.  '.$pago_mon;
    }
    mysql_free_result($rws1);
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
        $this -> SetY(-45);
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
        border: 0.9px solid #ddd;
        background-color: #01a2e6
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
        background-color: #01a2e6;
        border-bottom: 0.9px solid #01a2e6;
    }
    .row td{
        border-right: 0.9px solid #01a2e6;
        border-left: 0.9px solid #01a2e6;
        line-height: 7px;
    }
</style>

<style media="print">
    .oculto{
        display: none;
    }

</style>';
$bordelineas="1px solid #01a2e6;";
$html.='
<body><table style="width: 100%; margin-bottom: 50mm" border="0">';
if($estado=="ANULADA"){
	$html.='<tr>
	    <td width="50%"></td>
	    <td width="10%"></td>
	    <td td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
	    </tr>';
}
$html.='<tr>
        <td style="text-align: left" width="25%" align="left">
            <img src="'.$empresa_logo.'" alt="" width: "100%">
        </td>    
        <td style="text-align: left;font-size: 9pt" width="50%" align="center"><strong style="font-size: 12pt">'.$razon_defecto.'</strong><br>
        '.$direccion_defecto.'
        <br>'.$contacto_empresa.'
        <div style="height: 2px"></div><b>PUNTO DE VENTA:</b> '.$punto_venta_dir.'
        <br>'.$texto_venta_producto.'
        <br>
        </td>
      
        <td style="text-align: center;line-height: 5px" width="25%" border="1">
        <div style="height: 24px"></div>
            <strong style="font-size: 12pt">'.$tipodoc.'<br>
            RUC: '.$ruc_empresa.'<br>
            '.$serie.'-'.$numero.'</strong>
        </td>
    </tr>
</table>
<br/>
<br/>
<table style="width: 100%;" border="0">
    <tr>
        <td style="text-align: left" width="10%">SEÑOR(ES)</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$razon.'</td>

        <td style="text-align: left" width="10%">FECHA</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="18%">'.$fecha.'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="10%">RUC</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$ruc.'</td>

        <td style="text-align: left" width="10%">MONEDA</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="18%">'.$moneda.'</td>
    </tr>
    <tr>
        <td style="text-align: left; vertical-align:top;" width="10%">DIRECCIÓN</td>
        <td style="text-align: left; vertical-align:top;" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$direccion.'</td>
    </tr>
</table>
<br/>
<br/>
<table style="width: 100%;border:'.$bordelineas.'; border-collapse:collapse;line-height: 10px">
    <tbody>
        <tr class="header_row">
            <th style="text-align: center; width: 5%;"><b>ITEM</b></th>
            <th style="text-align: center; width: 7%;"><b>CANT</b></th>
            <th style="text-align: center; width: 7%;"><b>UNIDAD</b></th>
            <th style="text-align: center; width: 45%;"><b>DESCRIPCION</b></th>
            <th style="text-align: center; width: 12%;"><b>VALOR UNIT</b></th>
            <th style="text-align: center; width: 12%;"><b>PRECIO UNIT</b></th>
            <th style="text-align: center; width: 12%;"><b>IMPORTE</b></th>
        </tr>';
            $dts = $oCotizacion->mostrar_venta_detalle_ps($cot_id);
            $cont = 1;
            while($dt = mysql_fetch_array($dts)){
            	$codigo = $cont;
$html.='<tr class="row">';
            if($dt["tb_cotizaciondetalle_tipven"]==1){
                if ($dt['tb_marca_nom']!='NA'){
                    $ven_det_marca= ' - '.$dt['tb_marca_nom'];
                }
                if(strlen($dt["tb_ventadetalle_nom"].$ven_det_marca. $ven_det_serie)>66){
                    $max_lin++;
                }
                $html.='<td style="text-align: center">'.$cont.'</td>
                <td style="text-align: center">'.$dt["tb_cotizaciondetalle_can"].'</td>
                <td style="text-align: center">'.$dt['tb_unidad_abr'].'</td>
                <td style="text-align: left">'.$dt["tb_producto_nom"].$ven_det_marca.'</td>
                <td style="text-align: right">'.$dt["tb_cotizaciondetalle_preunilin"].'</td>
                <td style="text-align: right">'.$dt["tb_cotizaciondetalle_preuni"].'</td>';
                $html.='<td style="text-align: right">'.formato_moneda($dt["tb_cotizaciondetalle_preuni"]*$dt["tb_cotizaciondetalle_can"]).'</td>';
            }else{
                $html.='<td style="text-align: center">'.$cont.'</td>
                <td style="text-align: center">'.$dt["tb_cotizaciondetalle_can"].'</td>
                <td style="text-align: center">'.$dt['tb_unidad_abr'].'</td>
                <td style="text-align: left">'.$dt["tb_servicio_nom"].'</td>
                <td style="text-align: right">'.$dt["tb_cotizaciondetalle_preunilin"].'</td>
                <td style="text-align: right">'.$dt["tb_cotizaciondetalle_preuni"].'</td>';
                $html.='<td style="text-align: right">'.formato_moneda($dt['tb_cotizaciondetalle_preuni']+$dt['tb_cotizaciondetalle_can']).'</td>';
            }
            $html.='</tr>';
        $cont++;
    	}
    while ($cont<=32) {
        $html .= '<tr class="row">
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>';
        $html .= '</tr>';
        $cont++;
    }
    $html.='</tbody>
</table>';
$html2.='
<table class="total-letras" width="100%" style="font-size:8pt;text-align: left;margin-top: 8px">
    <tr>
        <td style="line-height: 7px;border:'.$bordelineas.'"><b>  SON: </b>';
            if($importetotal>0){
                $html2.='' . numtoletras($importetotal,$monedaval);
            }else{
                $html2.='Leyenda TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE';
            }
        $html2.='
        </td>
    </tr>
</table>
<br>
<br>
<table>
    <tr>
    <td width="60%" style="height: 60px; border: '.$bordelineas.'">
        <table>
            <tr>
                <td>';
                    $html2.='
                    <table style="line-height: 7px">
                        <tr class="row">
                                <th colspan="3" style="text-align: left;"><b>INFORMACIÓN ADICIONAL</b></th>
                        </tr>
                        <tr class="row">
                                <td width="5%" style="text-align: left;">1 )</td>
                                <td width="25%" style="text-align: left;"><b>Vendedor:</b></td>
                                <td width="70%" style="text-align: left;">'.$texto_vendedor.'</td>
                        </tr>
                        <tr class="row">
                                <td width="5%" style="text-align: left;">2 )</td>
                                <td width="25%" style="text-align: left;"><b>Otros:</b></td>
                                <td width="70%" style="text-align: left;"></td>
                        </tr>';
                    $html2.='
                    </table>
                </td>
            </tr>
          </table>
        
        </td>
        <td width="7%"></td>
        <td width="33%">
            <table>';
                if($totopgrat > 0){
                $html2.='<tr>
                    <td width="63%" style="text-align: left;"><b>VTAS GRATUITAS: </b></td>
                    <td width="7%" style="text-align: right">'.$mon.'</td>
                    <td width="30%" style="text-align: right;">'.$totopgrat.'</td>
                </tr>';
                }
                $html2.='<tr>
                    <td width="63%" style="text-align: left;"><b>SUB TOTAL:</b> </td>
                    <td width="7%" style="text-align: right">'.$mon.'</td>
                    <td width="30%" style="text-align: right;">'.$subtotal.'</td>
                </tr>';
                if($totanti > 0){
                    $html2.='<tr>
                        <td width="63%" style="text-align: left;"><b>ANTICIPOS: </b></td>
                        <td width="7%" style="text-align: right">'.$mon.'</td>
                        <td width="30%" style="text-align: right;">'.$totanti.'</td>
                    </tr';
                }
                $html2.='<tr>
                    <td width="63%" style="text-align: left;"><b>DESCUENTOS:</b> </td>
                    <td width="7%" style="text-align: right">'.$mon.'</td>
                    <td width="30%" style="text-align: right;">'.$totdes.'</td>
                </tr>
                <tr>
                    <td width="63%" style="text-align: left;"><b>VALOR VENTA: </b></td>
                    <td width="7%" style="text-align: right">'.$mon.'</td>
                    <td width="30%" style="text-align: right;">'.$valorventa.'</td>
                </tr>
                <tr>
                    <td  width="63%" style="text-align: left;"><b>IGV:</b> </td>
                    <td width="7%" style="text-align: right">'.$mon.'</td>
                    <td width="30%" style="text-align: right;">'.$toigv.'</td>
                </tr>
                <tr>                   
                     <td width="63%" style="text-align: left;"><b>IMPORTE TOTAL:</b> </td>
                     <td width="7%" style="text-align: right">'.$mon.'</td>
                     <td width="30%" style="text-align: right;font-weight: bold;font-size: 9pt">'.$importetotal.'</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br/>
<br/>';
$html2.='
<br/>
<br/>
<table>
<tr>
<td style="width:78%">
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);

//$pdf->write2DBarcode($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$idtipodni.'|'.$ruc.'|', 'QRCODE,Q', 157, 99, 40, 40, $style, 'N');

$pdf->Output($nombre_archivo, 'I');
