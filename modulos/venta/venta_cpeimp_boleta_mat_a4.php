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

require_once ("../lote/cVentaDetalleLote.php");
$oVentaDetalleLote = new cVentaDetalleLote();

require_once ("../letras/cLetras.php");
$cLetras = new cLetras();

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
$contacto_empresa = "<b>Teléfono:</b> " . $dt['tb_empresa_tel'] ."<b> Correo:</b>" . $dt['tb_empresa_ema'];
$texto_venta_producto="<i>Venta de ferreteria en general, accesorios, focos, calaminas, cemento, pegamento. precios al por mayor y menor.</i>";
$empresa_logo = '../empresa/'.$dt['tb_empresa_logo'];
$image_info = getimagesize($empresa_logo);
if(!is_file($empresa_logo)){
    $empresa_logo='../../images/logo.jpg';
}
mysql_free_result($dts);

$sucursales='
<table style="font-size:7pt;text-align: left" border="0" width="70%">
    <tr>
        <td width="20%" style="font-weight: bold">PRINCIPAL:</td>
        <td width="80%">'.$dt['tb_empresa_dir'] .'</td>
    </tr>
    <tr>
        <td style="font-weight: bold">TELEFONO: </td>
        <td>'.$dt['tb_empresa_tel'] .'</td>
    </tr>

    <tr>
        <td style="font-weight: bold">CORREO:</td>
        <td>'.$dt['tb_empresa_ema'].'</td>
    </tr>
    <tr>
        <td style="font-weight: bold">VENDEDOR:</td>
        <td>'.$texto_vendedor.'</td>
    </tr>
    
</table>';

$tipodoc = 'BOLETA DE VENTA ELECTRONICA';

$ven_id=$_POST['ven_id'];

$dts = $oVenta->mostrarUno($ven_id);
while($dt = mysql_fetch_array($dts))
{
    $idcomprobante=$dt["cs_tipodocumento_cod"];

    $serie=$dt["tb_venta_ser"];
    $numero=$dt["tb_venta_num"];
    $punto_venta_dir=$dt["tb_puntoventa_direccion"];
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

        if($rw1['tb_formapago_id']==3){
            $modo='';
            $ltrs1=$cLetras->mostrar_letras($_POST['ven_id']);
            $forma = 'LETRAS ';
            while($ltr= mysql_fetch_array($ltrs1)){
                $modo = $modo .' L'.$ltr['tb_letras_orden'].' FV: '.mostrarFecha($ltr['tb_letras_fecha']). ' M. '.$ltr['tb_letras_monto'];
            }
            $modo=$modo . ' TOTAL: ';
        }

        $pago_mon=formato_money($rw1['tb_ventapago_mon']);

        $texto_pago1[]=$forma.' '.$modo;
        $texto_pago2[]=$forma.' '.$modo.':'.$mon.'  '.$pago_mon;
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
              'stretchtext' => 4
         );

         $this -> SetY(-24);
         // Page number
         $this->SetFont('helvetica', '', 9);
         //$this->SetTextColor(0,0,0);
         $this->Cell(0, 0, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 'T', 1, 'R', 0, '', 0, false, 'T', 'M');

         $codigo='CAV-'.str_pad($_GET['d1'], 4, "0", STR_PAD_LEFT);

         $this->write1DBarcode($codigo, 'C128', '', 273, '', 6, 0.3, $style, 'N');
         $this->Cell(0, 0, 'www.prestamosdelnortechiclayo.com', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
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
    .cliente{
        border: 1px solid #01a2e6;
        border-spacing:7px;
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

<style media="print">
    .oculto{
        display: none;
    }

</style>
<body>
<table style="width: 100%; margin-bottom: 50mm;" border="0" class="datos-empresa" height="100pt">';
if($estado=="ANULADA"){
    $html.='<tr>
	    <td width="50%"></td>
	    <td width="10%"></td>
	    <td td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
	    </tr>';
}
$html.='<tr>
        <td width="25%" height="130">';
        if($image_info[1]<70){
            $html.='<table width="100%" height="100%" border="0">
            <tr>
                <td valign="middle" align="center">
                <table>
                    <tr>
                        <td>                            
                             <div align="center"><img src="'.$empresa_logo.'" border="0" height="30" width="'.$image_info[0].'" height="'.$image_info[1].'" style="line-height:50%;"/></div>
                        </td>
                     </tr>
                </table>
                </td>
            </tr>
        </table>';
        }else{
        $html.='                           
              <div><img src="'.$empresa_logo.'" border="0"  width="'.$image_info[0].'" height="'.$image_info[1].'" /></div>
         ';
        }
         $html.='
         </td>   
        <td width="50%"><strong style="font-size: 13pt">'.$razon_defecto.'</strong>
        <br>'.$direccion_defecto.'
        <br><br>'.$contacto_empresa.'
        <b>PUNTO DE VENTA:</b> '.$punto_venta_dir.'
        <br><br>'.$texto_venta_producto.'
        </td>
        <td  width="25%" border="1" class="tipo-documento"> 
            <div style="line-height: 4px"></div>  
            <strong>'.$tipodoc.'<br>
            RUC: '.$ruc_empresa.'<br>
            '.$serie.'-'.$numero.'</strong>           
        </td>
    </tr>
</table>
<br/>
<br/>
<br/>
<table style="width: 100%;" class="cliente">
    <tr>
        <td style="text-align: left" width="10%"><b>SEÑOR(ES)</b></td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$razon.'</td>

        <td style="text-align: left" width="10%"><b>FECHA</b></td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="18%">'.$fecha.'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="10%"><b>DNI</b></td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$ruc.'</td>

        <td style="text-align: left" width="10%"><b>MONEDA</b></td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="18%">'.$moneda.'</td>
    </tr>
    <tr>
        <td style="text-align: left; vertical-align:top;" width="10%"><b>DIRECCIÓN</b></td>
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
             
            <th style="text-align: center; width: 41%;"><b>DESCRIPCION</b></th>
            <th style="text-align: center; width: 8%;"><b>UNIDAD</b></th>
            <!--<th style="text-align: center; width: 7%;"><b>VALOR U.</b></th>-->
            <th style="text-align: right; width: 13%;"><b>VALOR UNIT.</b></th>
            <th style="text-align: right; width: 12%;"><b>DESCUENT.</b></th>
            <!--<th style="text-align: center; width: 8%;"><b>VALOR VENTA</b></th>-->
            <th style="text-align: right; width: 13%;"><b>VALOR VENTA</b></th>
        </tr>';
$dts = $oVenta->mostrar_venta_detalle_ps($ven_id);
$cont = 1;
while($dt = mysql_fetch_array($dts)){
    $codigo = $cont;
    $valor_unitario_linea = $dt["tb_ventadetalle_preuni"];
    $html.='<tr class="row">';
    if($dt["tb_ventadetalle_tipven"]==1){

        $ven_det_serie= '';
        if ($dt['tb_ventadetalle_serie']!=''){
            $ven_det_serie= ' - '.$dt['tb_ventadetalle_serie'];
        }
        $html .='<td style="text-align:center">' . $cont . '</td>
                 <td style="text-align: center">' . $dt["tb_ventadetalle_can"] . '</td>
                
                 <td style="text-align: left">' . $dt["tb_ventadetalle_nom"] .' - ' . $ven_det_serie .' ';

        $lotes=$oVentaDetalleLote->mostrar_filtro_venta_detalle($dt["tb_ventadetalle_id"]);
        while($lote = mysql_fetch_array($lotes)) {
            $html.= '- L. '. $lote["tb_ventadetalle_lotenum"]. ' F.V. '. $lote["tb_fecha_ven"].'';
        }
        $html .= '</td>
                    <td style="text-align: center">' . $dt['tb_unidad_abr'] . '</td>
                    <td style="text-align: right">' . formato_moneda($valor_unitario_linea) . '</td>
                  <td style="text-align: right">' . formato_moneda($dt['tb_ventadetalle_des']) . '</td>
                  <td style="text-align: right">' . formato_moneda($dt['tb_ventadetalle_preuni'] * $dt['tb_ventadetalle_can']) . '</td>';
    }else{
        $html .='<td style="text-align:center">' . $cont . '</td>
                 <td style="text-align: center">' . $dt["tb_ventadetalle_can"] . '</td>
                
                 <td style="text-align: left">' . $dt["tb_ventadetalle_nom"] .'</td>';
        $html .= '<td style="text-align: center">ZZ</td>
                  <td style="text-align: right">' . formato_moneda($valor_unitario_linea) . '</td>
                  <td style="text-align: right">' . formato_moneda($dt['tb_ventadetalle_des']) . '</td>
                  <td style="text-align: right">' . formato_moneda($dt['tb_ventadetalle_preuni'] * $dt['tb_ventadetalle_can']) . '</td>';
    }
    $html.='</tr>';
    $cont++;
}

for ($i=$cont;$i<45;$i++) {
    $html .= '<tr class="row">
        <td style="text-align: left"></td>
        <td style="text-align: center"></td>
        <td style="text-align: right"></td>
        <td style="text-align: right"></td>
        <td style="text-align: right"></td>
     ';
    $html .= '</tr>';
    $i++;
}
$html.='</tbody>
</table>';


////////////////////////////////////////////////////////////////////////////////////////////////////////
/// TOTALES Y LETRA MONTO
$html2.='
<table class="total-letras" width="100%" style="font-size:8pt;text-align: left;margin-top: 10px">
    <tr>
        <td style="line-height: 6px" border="1" cellpadding="3"><b>SON: </b>';
            if($importetotal>0){
                $html2.='' . numtoletras($importetotal,$monedaval);
            }else{
                $html2.='Leyenda TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE';
            }
        $html2.='
        </td>
    </tr>
</table>

<table width="100%"  border="0">
    <tr>
		<td valign="middle" align="center">
		    
            <table style="width: 100%; border: 0.5px solid #01a2e6;font-size:7pt">
            <tr class="row">
                <td colspan="2">INFORMACIÓN ADICONAL</td>
                <td></td>
            </tr>';
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
            $num++;
            $html2.='
                <tr class="row">
                    <td width="10%" style="text-align: left;">'.$num.' )Forma de Pago:</td>
                    <td width="90%" style="text-align: left;">'.$texto_pago.'</td>
                </tr>';

            $lab1=2;
            $lab2=3;
            $lab3=4;
            $html2.='<tr class="row"><td colspan="2">';
            if($lab1!="")
            {
                $num++;
                $html2.='<span width="100%" style="text-align: left;">'.$num.'Número de Placa: '.$lab1.'</span>';
            }
            if($lab2!="")
            {
                $num++;
                $html2.='<span width="100%" style="text-align: left;">Kilometraje: '.$lab2.'</span>';
            }
            if($lab3!="")
            {
                $num++;
                $html2.='<span width="100%" style="text-align: left;">Ord. Servicio: '.$lab2.'</span>';
            }
            $html2.="</td></tr>";
            $html2.='
            </table>';
		$html2.='
        </td>
		<td valign="middle" align="center">
            <table>
                <tr>
                    <td>
                            tabla 2
                     </td>
                 </tr>
            </table>
		</td>
		<td valign="middle"  border="0">
		    <table style="width: 100%;font-size:8pt;mapadding-top: 10px"  border="0">';
            if($totopgrat > 0){
                $html2.='
                <tr>
                    <td width="70%" style="text-align: left;" ><b>TOTAL VTAS. GRATUITAS:</b> </td>
                    <td width="30%" style="text-align: right;">'.$mon . $totopgrat.'</td>
                </tr>';
            }

            $html2.='
                <tr>
                    <td width="70%" style="text-align: left;" ><b>TOTAL OPE. GRABADAS:</b> </td>
                    <td width="30%" style="text-align: right;">'.$mon . $totopgrav.'</td>
                </tr>
                <tr>
                    <td width="70%" style="text-align: left;" ><b>TOTAL OPE EXONERADAS:</b> </td>
                    <td width="30%" style="text-align: right;">'.$mon . $totopexo.'</td>
                </tr>
                <tr>
                    <td width="70%" style="text-align: left;" ><b>TOTAL OPE. INAFECTAS:</b> </td>
                    <td width="30%" style="text-align: right;">'.$mon . $totopeina.'</td>
                </tr>';
            if($totanti > 0){
                $html2.='<tr>
                     <td width="70%" style="text-align: left;" ><b>ANTICIPOS: </b></td>
                    <td width="30%" style="text-align: right;">'.$mon . $totanti.'</td>
                </tr>';
            }
            $html2.='
                <tr>
                    <td width="70%" style="text-align: left;" ><b>TOTAL DESCUENTO:</b> </td>
                    <td width="30%" style="text-align: right;">'.$mon . $totdes.'</td>
                </tr>
                <tr>
                    <td  width="70%" style="text-align: left;" ><b>IGV: </b></td>
                    <td width="30%" style="text-align: right;">'.$mon . $toigv.'</td>
                </tr>
                <tr>                   
                    <td width="70%" style="text-align: left;"><b>IMPORTE TOTAL:</b> </td>
                    <td width="30%" style="text-align: right;font-weight: bold">'.$mon . $importetotal.'</td>
                </tr>
            
            </table>
		</td>
	</tr>
</table>';

$html2.='
<br/>
<br/>
<table>
<tr>
<td style="width:78%">';

$html2.='<br/>'.$sucursales;

$html2.='<br/>
<p style="font-size:7pt">
Código de Seguridad (Hash): '.$digval.'<br>
Representación Impresa de la '.$tipodoc.'.<br>Esta puede ser consultada en: '.$d_documentos_app.'<br>
'.$d_resolucion.'
</p>
</td>
<td>';

$style = array(
    'border' => 2,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);


$params2 = $pdf->serializeTCPDFtagParameters(array($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.mostrarfecha($fecha).'|'.$idtipodni.'|'.$ruc.'|'.$digval.'|', 'QRCODE,Q', '', '', 30, 30, $style, 'N'));
$html2 .= '<tcpdf method="write2DBarcode" params="'.$params2.'" />
</td>
</tr>
</table>';
$html2.='

</body>
</html>';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->writeHTML($html, true, 0, true, true);
$pdf->writeHTMLCell(0, 0, '', '190', $html2, 0, 0, false, "L", true);

//$pdf->write2DBarcode($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$idtipodni.'|'.$ruc.'|', 'QRCODE,Q', 157, 99, 40, 40, $style, 'N');

if ($_POST['tipo']=='correo'){
    $path = "../../cperepositorio/send";

// Supply a filename including the .pdf extension
    $filename = $nombre_archivo;
    $full_path = $path . '/' .$ruc_empresa.'-0'.$idcomprobante.'-'. $filename;
    if (!file_exists($full_path))
    {
        $pdf->Output($full_path, 'F');
    }
}else{
    $pdf->Output($nombre_archivo, 'I');
}
