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

require_once ("../lote/cVentaDetalleLote.php");
$oVentaDetalleLote = new cVentaDetalleLote();

$ven_id=$_POST['ven_id'];
$dts = $oVenta->mostrarUno($ven_id);
$dt = mysql_fetch_array($dts);

$dts=$oUsuario->mostrarUno($dt['tb_vendedor_id']);
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
$contacto_empresa = "Teléfono:" . $dt['tb_empresa_tel'] ."Correo:" . $dt['tb_empresa_ema'];
$empresa_logo = '../empresa/'.$dt['tb_empresa_logo'];
if(!is_file($empresa_logo)){
    $empresa_logo='../../images/logo.jpg';
}
mysql_free_result($dts);

$sucursales='
<table style="font-size:7pt" border="0">
    <tr>
        <td width="80">PRINCIPAL:</td>
        <td width="580">'.$dt['tb_empresa_dir'] .'</td>
    </tr>
    <!--<tr>
        <td width="80">SUCURSAL:</td>
        <td width="580">CAR.AREQUIPA KM. 9 (CC AREQUIPA NORTE GO 15 Y GO 16)<br> AREQUIPA - AREQUIPA - CERRO COLORADO</td>
    </tr>-->
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

$tipodoc = 'FACTURA ELECTRONICA';

$ven_id=$_POST['ven_id'];

$dts = $oVenta->mostrarUno($ven_id);
while($dt = mysql_fetch_array($dts))
{
    $idcomprobante=$dt["cs_tipodocumento_cod"];

    $serie=$dt["tb_venta_ser"];
    $numero=$dt["tb_venta_num"];

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


//pagos
$rws1=$oVentapago->mostrar_pagos($ven_id);
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

        if($rw1['tb_formapago_id']==3)
        {

                $forma='LETRAS ';
                $suma_pago7+=$rw1['tb_ventapago_mon'];

                $ltrs1=$cLetras->mostrar_letras($_POST['ven_id']);

            $date1 = new  DateTime($fecha);

            $cont=1;
            while($ltr= mysql_fetch_array($ltrs1)){
                $date2 = new DateTime($ltr['tb_letras_fecha']);
                $interval = $date1->diff( $date2 );
                $diferencia=$interval->format('%a dias');

                    $modo.= '<br>L'.$ltr['tb_letras_orden'].' '.$diferencia.' '.mostrarFecha($ltr['tb_letras_fecha']). ' M. '.$ltr['tb_letras_monto'];

                }

                //$modo.='CANJE'.$vence_letras;
//            }
        }


        $pago_mon=formato_money($rw1['tb_ventapago_mon']);

        $texto_pago1[]=$forma.' '.$modo;
        $texto_pago2[]=$forma.' '.$modo.':'.$diff.$mon.'  '.$pago_mon;
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
	    <td td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
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
<br/>
<table style="width: 100%; border: 0.5px solid #01a2e6; border-collapse:collapse;">
    <tbody>
        <tr class="header_row">
            <th style="text-align: center; width: 6%;"><b>ITEM</b></th>
            <th style="text-align: center; width: 7%;"><b>CANT.</b></th>
             <th style="text-align: center; width: 8%;"><b>UNIDAD</b></th>
            <th style="text-align: center; width: 41%;"><b>DESCRIPCION</b></th>
            <!--<th style="text-align: center; width: 7%;"><b>VALOR U.</b></th>-->
            <th style="text-align: right; width: 13%;"><b>VALOR UNIT.</b></th>
            <th style="text-align: right; width: 13%;"><b>DESCUENT.</b></th>
            <!--<th style="text-align: center; width: 8%;"><b>VALOR VENTA</b></th>-->
            <th style="text-align: right; width: 12%;"><b>VALOR VENTA</b></th>
        </tr>';
$dts = $oVenta->mostrar_venta_detalle_ps($ven_id);
$cont = 1;
while($dt = mysql_fetch_array($dts)){
    $codigo = $cont;
    $valor_unitario_linea = $dt["tb_ventadetalle_preunilin"];
    $html.='<tr class="row">';
    if($dt["tb_ventadetalle_tipven"]==1){

        $ven_det_serie= '';
        if ($dt['tb_ventadetalle_serie']!=''){
            $ven_det_serie= ' - '.$dt['tb_ventadetalle_serie'];
        }

        $html .='<td style="text-align:center">' . $cont . '</td>
                 <td style="text-align: center">' . $dt["tb_ventadetalle_can"] . '</td>
                 <td style="text-align: center">' . $dt['tb_unidad_abr'] . '</td>
                 <td style="text-align: left">' . $dt["tb_ventadetalle_nom"] . ' - ' . $dt['tb_marca_nom'] . $ven_det_serie . ' - ';
                $lotes=$oVentaDetalleLote->mostrar_filtro_venta_detalle($dt["tb_ventadetalle_id"]);
                while($lote = mysql_fetch_array($lotes)) {
                    $html.= 'L. '. $lote["tb_ventadetalle_lotenum"]. ' F.V. '. $lote["tb_fecha_ven"].', ';
                }

        $html .= '</td><td style="text-align: right">' . formato_moneda($valor_unitario_linea) . '</td>
                  <td style="text-align: right">' . formato_moneda($dt['tb_ventadetalle_des']) . '</td>
                  <td style="text-align: right">' . formato_moneda($dt['tb_ventadetalle_valven']) . '</td>';

    }else{
        $html .='<td style="text-align:center">' . $cont . '</td>
                 <td style="text-align: center">' . $dt["tb_ventadetalle_can"] . '</td>
                 <td style="text-align: center">' . $dt['tb_unidad_abr'] . '</td>
                 <td style="text-align: left">' . $dt["tb_ventadetalle_nom"] . ' - ' . $dt['tb_marca_nom'] . $ven_det_serie;
        $lotes=$oVentaDetalleLote->mostrar_filtro_venta_detalle($dt["tb_ventadetalle_id"]);
        while($lote = mysql_fetch_array($lotes)) {
            $html.=$lote["tb_ventadetalle_lotenum"].', ';
        }

        $html .= '</td><td style="text-align: right">' . formato_moneda($valor_unitario_linea) . '</td>
                  <td style="text-align: right">' . formato_moneda($dt['tb_ventadetalle_des']) . '</td>
                  <td style="text-align: right">' . formato_moneda($dt['tb_ventadetalle_valven']) . '</td>';
    }

    $html.='</tr>';
    $cont++;
}
$html.='</tbody>
</table>
<br/>
<br/>
<table style="width: 100%"  border="0">
    <tr>
        <td style="text-align: left;" colspan="3">'.$observacion.'</td>
    </tr>';
if($totopgrat > 0){
    $html.='<tr>
        <td width="78%" style="text-align: right;" colspan="2">Vtas. Gratuitas: </td>
        <td width="23%" style="text-align: right;">'.$mon . $totopgrat.'</td>
    </tr>';
}

$html.='
    <tr>
        <td width="78%" style="text-align: right;" colspan="2">Ope Grav: </td>
        <td width="23%" style="text-align: right;">'.$mon . $totopgrav.'</td>
    </tr>
    <tr>
        <td width="78%" style="text-align: right;" colspan="2">Ope Exo: </td>
        <td width="23%" style="text-align: right;">'.$mon . $totopexo.'</td>
    </tr>
    <tr>
        <td width="78%" style="text-align: right;" colspan="2">Ope Ina: </td>
        <td width="23%" style="text-align: right;">'.$mon . $totopeina.'</td>
    </tr>';
if($totanti > 0){
    $html.='<tr>
            <td width="78%" style="text-align: right;" colspan="2">Anticipos: </td>
            <td width="23%" style="text-align: right;">'.$mon . $totanti.'</td>
        </tr>';
}
$html.='
    <tr>
        <td width="78%" style="text-align: right;" colspan="2">Total Descuento: </td>
        <td width="23%" style="text-align: right;">'.$mon . $totdes.'</td>
    </tr>
    <tr>
        <td  width="78%" style="text-align: right;" colspan="2">IGV: </td>
        <td width="23%" style="text-align: right;">'.$mon . $toigv.'</td>
    </tr>
        <tr>
            <td width="60%" style="text-align: left;">';
if($importetotal>0){
    $html.='SON: ' . numtoletras($importetotal,$monedaval);
}else{
    $html.='Leyenda TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE';
}
$html.='</td>
            <td width="18%" style="text-align: right;">Importe Total: </td>
            <td width="23%" style="text-align: right;  border-top: 1px solid black;">'.$mon . $importetotal.'</td>
        </tr>

</table>
<br/>
<br/>';

if($num_rows_vp==1)$texto_pago=trim($texto_pago1[0]);

if($num_rows_vp>1)
{
    $texto_pago="";
    foreach($texto_pago2 as $indice=>$valor)
    {
        $texto_pago.='<br>'.trim($valor).'';
    }
}

$num=0;
$html.='INFORMACIÓN ADICIONAL<br>
<table style="width: 50%; border: 0.5px solid #01a2e6; border-collapse:collapse;">';
$num++;
$html.='
    <tr class="row">
        <td width="5%" style="text-align: left;">'.$num.')</td>
        <td width="25%" style="text-align: left;">Forma de Pago:</td>
        <td width="70%" style="text-align: left;">'.$texto_pago.'</td>
    </tr>';

if($lab1!="")
{
    $num++;
    $html.='
    <tr class="row">
        <td width="5%" style="text-align: left;">'.$num.')</td>
        <td width="25%" style="text-align: left;">Nro. de Placa:</td>
        <td width="70%" style="text-align: left;">'.$lab1.'</td>
    </tr>';
}
if($lab2!="")
{
    $num++;
    $html.='
    <tr class="row">
        <td width="5%" style="text-align: left;">'.$num.')</td>
        <td width="25%" style="text-align: left;">Kilometraje:</td>
        <td width="70%" style="text-align: left;">'.$lab2.'</td>
    </tr>';
}
if($lab3!="")
{
    $num++;
    $html.='
    <tr class="row">
        <td width="5%" style="text-align: left;">'.$num.')</td>
        <td width="25%" style="text-align: left;">Ord. Servicio:</td>
        <td width="70%" style="text-align: left;">'.$lab3.'</td>
    </tr>';
}

$html.='
</table>';


$html.='
<br/>
<br/>
<table>
<tr>
<td style="width:78%">';

$html.='<br/>'.$sucursales;

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


$params = $pdf->serializeTCPDFtagParameters(array($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.mostrarfecha($fecha).'|'.$idtipodni.'|'.$ruc.'|', 'QRCODE,Q', '', '', 30, 30, $style, 'N'));
$html .= '<tcpdf method="write2DBarcode" params="'.$params.'" />
</td>
</tr>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);

//$pdf->write2DBarcode($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$idtipodni.'|'.$ruc.'|', 'QRCODE,Q', 157, 99, 40, 40, $style, 'N');

$pdf->Output($nombre_archivo, 'I');
