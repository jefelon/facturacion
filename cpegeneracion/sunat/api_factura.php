<?php
//require_once($_SERVER['DOCUMENT_ROOT'] ."granadosllantas/facturacion/cpegeneracion/sunat/".'funciones.php');
require_once('../../cpegeneracion/sunat/funciones.php');
require_once('../../cpegeneracion/sunat/toarray.php');
require_once('../../cpegeneracion/sunat/toxml.php');
require_once('../../config/datos.php');
require_once ("../../modulos/formatos/formatos.php");

$_POST = json_decode(file_get_contents("php://input"), true);

////EMPRESA
//$empresa[] = array();
$empresa[0]['certificado']			= $_POST['empresa_certificado'];
$empresa[0]['clave_certificado']	= $_POST['empresa_clave_certificado'];
$empresa[0]['usuario_sunat']		= $_POST['empresa_usuario_sunat'];
$empresa[0]['clave_sunat']			= $_POST['empresa_clave_sunat'];
$empresa[0]['idempresa']			= $_POST['empresa_ruc'];
$empresa[0]['signature_id']			= $_POST['empresa_signature_id'];
$empresa[0]['signature_id2']		= $_POST['empresa_signature_id2'];
$empresa[0]['razon']				= $_POST['empresa_razon_social'];
$empresa[0]['idtipodni']			= $_POST['empresa_tipo_de_documento'];
$empresa[0]['nomcomercial']			= $_POST['empresa_nombre_comercial'];
$empresa[0]['iddistrito']			= $_POST['empresa_numero_de_distrito'];
$empresa[0]['direccion']			= $_POST['empresa_direccion'];
$empresa[0]['subdivision']			= $_POST['empresa_subdivision'];
$empresa[0]['departamento']			= $_POST['empresa_departamento'];
$empresa[0]['provincia']			= $_POST['empresa_provincia'];
$empresa[0]['distrito']				= $_POST['empresa_distrito'];

$empresa = json_decode(json_encode($empresa));

//================================================================================================
require_once ("../../config/Cado.php");
require_once ("../../modulos/venta/cVenta.php");
require_once ("../../modulos/formatos/numletras.php");

$header[0]['idcomprobante']		=$_POST["tipo_de_comprobante"];//1FACTURA 3BOLETA 7NCREDITO 8NDEBITO
$header[0]['serie']				=$_POST['serie'];
$header[0]['numero']			=$_POST['numero'];

$header[0]['fechadoc']			=$_POST['fecha_de_emision'];

$header[0]['identidad']			=$_POST['cliente_numero_de_documento'];


$header[0]['idtipodni']			=$_POST['cliente_tipo_de_documento'];

$header[0]['razon']				=$_POST['cliente_razon_social'];

$header[0]['isomoneda']			=$_POST['tipo_de_moneda'];

$header[0]['totopgra']			=$_POST['total_operaciones_gravadas'];
$header[0]['totopina']			=$_POST['total_operaciones_inafectas'];
$header[0]['totopexo']			=$_POST['total_operaciones_exoneradas'];
$header[0]['totopgrat']			=$_POST['total_operaciones_gratuitas'];
$header[0]['totdescto']			=$_POST['total_descuento'];
$header[0]['totigv']			=$_POST['total_igv'];
$header[0]['totisc']			=$_POST['total_impuesto_selectivo_al_consumo'];
$header[0]['tototh']			=$_POST['total_otros_tributos'];	//sumatoria otros tributos
$header[0]['desctoglobal']		=$_POST['descuento_global'];//descuentos globales
$header[0]['tototroca']			=$_POST['total_otros_cargos'];	//otros cargos
$header[0]['importetotal']		=$_POST['importe_total'];

$header[0]['idtoperacion']		=$_POST['idtoperacion'];//VENTA INTERNA

$header[0]['totanti']			=$_POST['total_anticipos'];//si es mayor a cero concidera
$header[0]['iddoctributario']	=$_POST['serie_y_numero_de_documento_que_se_realizo_el_anticipo'];//CATALOGO 12
$header[0]['iddoctriref']		=$_POST['tipo_de_comprobante_que_se_realizo_el_anticipo'];

$header[0]['nroplaca']			=$_POST['numero_de_placa'];//placa

$header[0]['AdditionalProperty_Value']=$_POST['AdditionalProperty_Value'];

$header = json_decode(json_encode($header));


//===============================================================================================
$autoin=0;

$dts = $_POST["items"];
foreach ($dts as $key => $dt)
{

    $detalle[$autoin]['idafectaciond']			=$dt["tipo_de_afectacion"]; //10AFECTO 20EXONERADO 31BONO
    $detalle[$autoin]['nro']					=$dt["nro"];

    $detalle[$autoin]['idmedida']				=$dt["unidad_de_medida"];

    $detalle[$autoin]['cantidad']				=$dt["cantidad"];
    $detalle[$autoin]['idproducto']				=$dt["idproducto"];
    $detalle[$autoin]['codigo']					=$dt["codigo"];
    $detalle[$autoin]['detalle']				=$dt["descripcion"];

    //$igv 										=$_POST["tb_ventadetalle_igv"] / $_POST["tb_ventadetalle_can"];
    $detalle[$autoin]['precio']					=$dt["valor_unitario"];
    //oculto ya se calcula en base datos
    //$detalle[$autoin]['valorref']				=($_POST["tb_ventadetalle_valven"]+$_POST["tb_ventadetalle_igv"])/$_POST["tb_ventadetalle_can"];// precio de venta
    $detalle[$autoin]['valorref']				=$dt["precio_unitario"];

    $detalle[$autoin]['igv']					=$dt["igv"];//sumatoria con cantidad
    $detalle[$autoin]['valorventa']				=$dt["valor_de_venta"];//sumatoria con cantidad
    $detalle[$autoin]['descto']					=$dt["descuento"];

    $detalle[$autoin]['idtiposcisc']			=$dt["tipo_de_sistema_de_impuesto_selectivo_al_consumo"];
    $detalle[$autoin]['isc']					=$dt["impuesto_selectivo_al_consumo"];

    $autoin++;
}
mysql_free_result($dts);

$detalle = json_decode(json_encode($detalle));
//===============================================================================================
$enviar=true;
$r = run(datatoarray($header, $detalle, $empresa, 'Invoice'), "../../cperepositorio/send/", "../../cperepositorio/cdr/", $nodo="", "Invoice", $enviar);

//Generar PDF
$nombre_archivo = $_POST['empresa_ruc'].'-'.$_POST['tipo_de_comprobante'].'-'.$_POST['serie'].'-'.$_POST['numero'].'.pdf';
require_once('../../libreriasphp/html2pdf/_tcpdf_5.9.206/tcpdf.php');
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
    }
    
   
</style>

<style media="print">
    .oculto{
        display: none;
    }

</style>


<body><table style="width: 100%; margin-bottom: 50mm" border="0">';

$sucursales='
<table style="font-size:7pt" border="0">
    <tr>
        <td width="80">PRINCIPAL:</td>
        <td width="580">'.$_POST['empresa_direccion'] .' - '.$_POST['empresa_provincia'].' - '.$_POST['empresa_provincia'].'</td>
    </tr>
    <tr>
        <td>CORREO:</td>
        <td>'.$_POST['cliente_email'].'</td>
    </tr>
</table>';

if ((int)$_POST['tipo_de_comprobante']==1){
    $tipodoc = 'BOLETA ELECTRONICA';
}elseif((int)$_POST['tipo_de_comprobante']==6){
    $tipodoc = 'FACTURA ELECTRONICA';
}else{
    $tipodoc = 'VENTA';
}

if($_POST['tipo_de_moneda']=='PEN'){
    $moneda  = "SOLES";
    $mon = "S/ ";
}

$html.='<tr>
        <td style="text-align: left" width="60%" align="left"><strong style="font-size: 11pt">'.$_POST['empresa_razon_social'].'</strong><br>'.$_POST['empresa_direccion'] .' - '.$_POST['empresa_provincia'].' - '.$_POST['empresa_provincia'].'
        </td>
        <td style="text-align: center;" width="40%" border="1">
            <strong style="font-size: 11pt">'.$tipodoc.'<br>
            RUC: '.$_POST['empresa_ruc'].'<br>
            '.$_POST['serie'].'-'.$_POST['numero'].'</strong>
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
        <td style="text-align: left" width="58%">'.$_POST['cliente_razon_social'].'</td>

        <td style="text-align: left" width="10%">FECHA</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="18%">'.mostrarFecha($_POST['fecha_de_emision']).'</td>
    </tr>
    <tr>
        <td style="text-align: left" width="10%">DNI o RUC</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$_POST['cliente_numero_de_documento'].'</td>

        <td style="text-align: left" width="10%">MONEDA</td>
        <td style="text-align: left" width="2%">:</td>
        <td style="text-align: left" width="18%">'.$moneda.'</td>
    </tr>
    <tr>
        <td style="text-align: left; vertical-align:top;" width="10%">DIRECCIÓN</td>
        <td style="text-align: left; vertical-align:top;" width="2%">:</td>
        <td style="text-align: left" width="58%">'.$_POST['cliente_direccion'].'</td>
    </tr>
</table>
<br/>
<br/>
<br/>

<table style="width: 100%; border: 0.5px solid #01a2e6; border-collapse:collapse;">
    
        <tr class="header_row">
            <th style="text-align: center; width: 5%;"><b>ITEM</b></th>
            <th style="text-align: center; width: 50%;"><b>DESCRIPCION</b></th>
            <th style="text-align: center; width: 7%;"><b>UNIDAD</b></th>
            <th style="text-align: center; width: 6%;"><b>CANT.</b></th>
            <th style="text-align: center; width: 7%;"><b>VALOR U.</b></th>
            <th style="text-align: center; width: 8%;"><b>PRECIO U.</b></th>
            <th style="text-align: center; width: 8%;"><b>VALOR VENTA</b></th>
            <th style="text-align: center; width: 8%;"><b>PRECIO VENTA</b></th>
        </tr>';
$cont = 1;
foreach ($dts as $key => $dt) {
    $html .= '<tr class="row">';
    $html .= '<td style="text-align: center">' . $cont . '</td>
                <td style="text-align: left">' . $dt["descripcion"] . '</td>
                <td style="text-align: center">' . $dt['unidad_de_medida'] . '</td>
                <td style="text-align: right">' . $dt["cantidad"] . '</td>
                <td style="text-align: right">' . $dt["valor_unitario"] . '</td>
                <td style="text-align: right">' . formato_moneda($dt["precio_unitario"]) . '</td>
                <td style="text-align: right">' . formato_moneda($dt["valor_de_venta"]) . '</td>';
    $html.='<td style="text-align: right">'.formato_moneda($dt["precio_unitario"]*$dt["cantidad"]).'</td>';
    $html.='</tr>';
    $cont++;
}

$html.='
</table>
<br/>
<br/>
<table style="width: 100%"  border="0">';
if($_POST['total_operaciones_gratuitas'] > 0){
    $html.='<tr>
        <td width="80%" style="text-align: right;" colspan="2">Vtas. Gratuitas: </td>
        <td width="20%" style="text-align: right;">'.$mon . $_POST['total_operaciones_gratuitas'].'</td>
    </tr>';
}

if($_POST['total_anticipos'] > 0){
    $html.='<tr>
            <td width="80%" style="text-align: right;" colspan="2">Anticipos: </td>
            <td width="20%" style="text-align: right;">'.$mon . $_POST['total_anticipos'].'</td>
        </tr>';
}
$html.='<tr>
        <td width="80%" style="text-align: right;" colspan="2">Descuentos: </td>
        <td width="20%" style="text-align: right;">'.$mon . $_POST['total_descuento'].'</td>
    </tr>
    <tr>
        <td width="80%" style="text-align: right;" colspan="2">Valor Venta: </td>
        <td width="20%" style="text-align: right;">'.$mon . $_POST['total_operaciones_gravadas'].'</td>
    </tr>
    <tr>
        <td  width="80%" style="text-align: right;" colspan="2">IGV: </td>
        <td width="20%" style="text-align: right;">'.$mon . $_POST['total_igv'].'</td>
    </tr>
        <tr>
            <td width="60%" style="text-align: left;">';
if($_POST['importe_total']>0){
    $html.='SON: ' . numtoletras($_POST['importe_total']);
}else{
    $html.='Leyenda TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE';
}
$html.='</td>
            <td width="20%" style="text-align: right;">Importe Total: </td>
            <td width="20%" style="text-align: right;">'.$mon . $_POST['importe_total'].'</td>
        </tr>

</table>
<br/>
<br/>';



$num=0;
$html.='INFORMACIÓN ADICIONAL<br>
<table style="width: 50%; border-collapse:collapse;">';
$num++;

if($_POST['numero_de_placa']!="")
{
    $num++;
    $html.='
    <tr class="row">
        <td width="5%" style="text-align: left;">'.$num.')</td>
        <td width="25%" style="text-align: left;">Nro. de Placa:</td>
        <td width="70%" style="text-align: left;">'.$_POST['numero_de_placa'].'</td>
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
Código de Seguridad (Hash): '.$r['digvalue'].'<br>
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


$params = $pdf->serializeTCPDFtagParameters(array($_POST['ruc_empresa'].'|'.$_POST["tipo_de_comprobante"].'|'.$_POST['serie'].'|'.$_POST['numero'].'|'.$_POST['total_igv'].'|'.$_POST['importe_total'].'|'.$_POST['fecha_de_emision'].'|'.$_POST['cliente_tipo_de_documento'].'|'.$_POST['cliente_numero_de_documento'].'|', 'QRCODE,Q', '', '', 40, 40, $style, 'N'));
$html .= '<tcpdf method="write2DBarcode" params="'.$params.'" />
</td>
</tr>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, true);

//$pdf->write2DBarcode($ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$idtipodni.'|'.$ruc.'|', 'QRCODE,Q', 157, 99, 40, 40, $style, 'N');

$pdf->Output('../../cperepositorio/pdf/'.$nombre_archivo, 'F');


$data['tipo_de_comprobante'] = $_POST['tipo_de_comprobante'];
$data['serie'] = $_POST['serie'];
$data['numero'] = $_POST['numero'];
if ($r['faultcode']=='0'){
    $data['aceptado_por_sunat'] = true;
}else{
    $data['aceptado_por_sunat'] = false;
}
$data['sunat_responsecode'] = $r['faultcode'];
$data['digvalue'] = $r['digvalue'];
$data['signvalue'] = $r['signvalue'];
$data['valid'] = $r['valid'];
$data['cadena_para_codigo_qr'] = $_POST['ruc_empresa'].'|'.$_POST["tipo_de_comprobante"].'|'.$_POST['serie'].'|'.$_POST['numero'].'|'.$_POST['total_igv'].'|'.$_POST['importe_total'].'|'.$_POST['fecha_de_emision'].'|'.$_POST['cliente_tipo_de_documento'].'|'.$_POST['cliente_numero_de_documento'].'|';
$data['enlace_del_pdf'] = $d_dominio_app . 'cperepositorio/pdf/' . $nombre_archivo;
$data['enlace_del_cdr'] = $d_dominio_app . 'cperepositorio/cdr/'.'R-'. $_POST['empresa_ruc']."-".$_POST["tipo_de_comprobante"]."-".$_POST['serie']."-".$_POST['numero'].'.xml';
$data['enlace_del_xml'] = $d_dominio_app . 'cperepositorio/send/'.$_POST['empresa_ruc']."-".$_POST["tipo_de_comprobante"]."-".$_POST['serie']."-".$_POST['numero'].'.xml';
echo json_encode($data,JSON_UNESCAPED_SLASHES);
?>