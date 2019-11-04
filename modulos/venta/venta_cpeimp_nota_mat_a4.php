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

$tipodoc = 'NOTA DE SALIDA';

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
        global $estado;
        if($estado=="ANULADA") {
            // set bacground image
            $img_file = '../../images/anulado.jpg';
            $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 150, '', false, false, 0);
            // restore auto-page-break status
            //$this->SetAutoPageBreak($auto_page_break, $bMargin);
            // set the starting point for the page content
            $this->setPageMark();
        }
    }

    public function Footer()
    {
        global $html2;
        $this -> SetY(-100);
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
        border-bottom: 0.9px solid #008f39;
        border-right: 0.9px solid #008f39;
        border-left: 0.9px solid #008f39;
        background-color: #008f39;
        text-transform:uppercase;
    }

    .row td{
        border-right: 0.9px solid #008f39;
        border-left: 0.9px solid #008f39;
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

<style media="print">
    .oculto{
        display: none;
    }

</style>
<body>';
$bordelineas="1px solid #008f39;";
$bordetop="border-top: 1px solid #008f39;";
$html.='
<table style="width: 100%; margin-bottom: 50mm;" border="0" class="datos-empresa" height="100pt">';
$html.='<tr>
        <td width="25%" height="130">';
if($image_info[1]<70){
    $html.='<table width="100%" height="100%" border="0">
            <tr>
                <td valign="middle" align="center">
                <table>
                    <tr>
                        <td>
                             <div align="center"><img src="'.$empresa_logo.'" border="0"  width="'.$image_info[0].'" height="'.$image_info[1].'" style="line-height:50%;"/></div>
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
</table>';
$html.='        
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

<table style="width: 100%; border:'.$bordelineas.'; border-collapse:collapse;">
    <tbody>
        <tr class="header_row">
            <th style="text-align: center; width: 6%;"><b>ITEM</b></th>
            <th style="text-align: center; width: 7%;"><b>CANT.</b></th>
             
            <th style="text-align: center; width: 41%;"><b>DESCRIPCION</b></th>
            <th style="text-align: center; width: 8%;"><b>UNIDAD</b></th>
            <!--<th style="text-align: center; width: 7%;"><b>VALOR U.</b></th>-->
            <th style="text-align: right; width: 13%;"><b>PRECIO UNIT.</b></th>
            <th style="text-align: right; width: 12%;"><b>DESCUENT.</b></th>
            <!--<th style="text-align: center; width: 8%;"><b>VALOR VENTA</b></th>-->
            <th style="text-align: right; width: 13%;"><b>IMPORTE</b></th>
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
                
                 <td style="text-align: left">' . $dt["tb_ventadetalle_nom"]. $ven_det_serie .' ';

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

while ($cont<=35) {
    $html .= '<tr class="row">
        <td style="text-align: center"></td>
        <td style="text-align: center"></td>
        <td style="text-align: right"></td>
        <td style="text-align: right"></td>
        <td style="text-align: right"></td>
        <td style="text-align: right"></td>
     ';
    $html .= '</tr>';
    $cont++;
}
$html.='</tbody>
</table>';


////////////////////////////////////////////////////////////////////////////////////////////////////////
/// TOTALES Y LETRA MONTO
$html2="";
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
    <tr><td></td></tr>
</table>

<table width="100%"  border="0">
    <tr>
		<td valign="middle" align="left" width="66%" height="70" style="border: '.$bordelineas.'">	    
            <table style="width: 100%;font-size:8pt">
            <tr class="row">
                <td colspan="2" style="font-size:9pt"><b>INFORMACIÓN ADICIONAL</b></td>
                <td></td>
            </tr>';
//if($num_rows_vp==1)$texto_pago=trim($texto_pago1[0]);

if($num_rows_vp>=1)
{
    $texto_pago="";
    foreach($texto_pago2 as $indice=>$valor)
    {
        $texto_pago.='<br>'.trim($valor);
    }
}

$html2.='
            <tr class="row">
                <td width="18%" style="text-align: left;"><b>1) Forma Pago:</b></td>
                <td width="84%" style="text-align: left;">'.$texto_pago.'</td>
            </tr>
            <tr class="row">
                <td width="18%" style="text-align: left;"><b>2) Vendedor: </b></td>
                <td width="84%" style="text-align: left;">'.$texto_vendedor.'</td>
            </tr>';
$html2.='
            <tr class="row">
                <td width="18%" style="text-align: left;"><b>3) Otros: </b></td>
                <td width="84%" style="text-align: left;">';
if($lab1!="")
{
    $html2.='<span width="100%" style="text-align: left;"><b>Núm. de Placa:</b> '.$lab1.'</span>';
}
if($lab2!="")
{
    $html2.='<span width="100%" style="text-align: left;"><b> Kilometraje:</b> '.$lab2.'</span>';
}
if($lab3!="")
{
    $html2.='<span width="100%" style="text-align: left;"><b> Ord. Servicio:</b> '.$lab3.'</span>';
}
$html2.='
                </td>
            </tr>';
$html2.='
            </table>';
$html2.='
        </td>
        <td width="1%">
            <table><tr><td></td></tr></table>
        </td>
		<td valign="middle"  border="0" width="33%">
		    <table style="width: 100%;font-size:8pt;mapadding-top: 10px"  border="0">';
            $html2.='             
               <tr>                   
                    <td width="65%" style="text-align: left;"><b>IMPORTE TOTAL:</b> </td>
                    <td width="5%" style="text-align: right">'.$mon.'</td>
                    <td width="30%" style="text-align: right;font-weight: bold;font-size: 9pt">'.$importetotal.'</td>
                </tr>           
            </table>
		</td>
	</tr>
</table>';

$html2.='
<br/>
<br/>
<table width="100%" border="0" style="line-height: 6px">
    <tr>
        <td width="50%">
            <table>
                <tr><td colspan="2"><b>CUENTAS BANCARIAS</b></td></tr>
                <tr><td width="40%"><b>BCP Soles: </b></td> <td width="60%">191-2266774-0-05</td></tr>
               <!-- <tr><td width="40%"><b>BCP Dólares: </b></td> <td width="60%">191-2266744-0-02</td></tr>
                <tr><td width="40%"><b>BBVA Soles: </b></td> <td width="60%">0011-056602000-52070</td></tr>
                <tr><td width="40%"><b>BBVA Dólares: </b></td> <td width="0%">0011-056602000-34045</td></tr>
                <tr><td width="40%"><b>Cta. de Detracciones: </b></td> <td width="60%">00-099-099283</td></tr>-->
            </table>
        </td>
        <td width="20%">
           <table>
                <tr><td height="80px"></td></tr>
                <tr><td></td></tr>
            </table>
        </td>
        <td width="30%">
           <table>
                <tr><td height="80px"></td></tr>
                <tr><td style="text-align: center;'.$bordetop.'"><b>OBSERVACIÓN</b></td></tr>
            </table>
        </td>
    </tr>
</table>
<br><br>
<table border="0" width="100%">
    <tr>
        <td>
            <img src="../empresa/logos/logo_pie_chint.jpg" border="0"  width="225" height="85" style="line-height:50%;"/>
        </td>
        <td>
            <img src="../empresa/logos/logo_pie_elcope.jpg" border="0"  width="253" height="126" style="line-height:50%;"/>
        </td>
        <td>
            <img src="../empresa/logos/logo_pie_hager.jpg" border="0"  width="300" height="98" style="line-height:50%;"/>
        </td>
        <td>
            <img src="../empresa/logos/logo_pie_leviton.png" border="0"  width="345" height="146" style="line-height:50%;"/>
        </td>
        <td>
            <img src="../empresa/logos/logo_pie_mennekes.jpg" border="0"  width="350" height="97" style="line-height:50%;"/>
        </td>
        <td>
            <img src="../empresa/logos/logo_pie_philips.png" border="0"  width="300" height="54" style="line-height:50%;"/>
        </td>
        <td>
            <img src="../empresa/logos/logo_pie_thorgel.jpg" border="0"  width="373" height="135" style="line-height:50%;"/>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td style="font-size: 8pt;text-align: center;line-height: 8px;"><i>Representación Impresa de la '.$tipodoc.' , Esta puede ser consultada en: '.$d_documentos_app.'</i></td>
    </tr>
</table>';

$html2.='

</body>
</html>';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->writeHTML($html, true, 0, true, true);
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
