<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../egreso/cEgreso.php");
$oEgreso = new cEgreso();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();

require_once("../formatos/formato.php");
require_once("../formatos/fechas.php");
require_once("../formatos/numletras.php");

//$tipo_de_letra="DejaVuSansCondensed";
//$tipo_de_letra="DejaVuSans";
//$tipo_de_letra="DejaVuSansMono";
//$tipo_de_letra="DejaVuSerif";
//$tipo_de_letra="DejaVuSerifCondensed";
//$tipo_de_letra="FreeMono";
//$tipo_de_letra="FreeSans";
//$tipo_de_letra="times";
$tipo_de_letra="arial";
//$tipo_de_letra="courier";
//$tipo_de_letra="helvetica";
//$tipo_de_letra="ArialUnicodeMS";

//$tipo_de_letra_arch="dejavusans.php";
//$tipo_de_letra_arch="arialunicid0.php";

$pager_formato='format="148x210" orientation="P" style="font-size: 11pt; font-family:'.$tipo_de_letra.'"';

$pager_margen='backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm"';

//html2pdf
$orientacion_impresion='P';
$formato_impresion='A4';
$margen_array=array(10, 10, 10, 10);
//$margen_array=0;

$borde_tablas=0;

$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
	$emp_ruc=$dt['tb_empresa_ruc'];
	$emp_nomcom=$dt['tb_empresa_nomcom'];
	$emp_razsoc=$dt['tb_empresa_razsoc'];
	$emp_dir=$dt['tb_empresa_dir'];
	$emp_dir2=$dt['tb_empresa_dir2'];
	$emp_tel=$dt['tb_empresa_tel'];
	$emp_ema=$dt['tb_empresa_ema'];
	$emp_fir=$dt['tb_empresa_fir'];		
mysql_free_result($dts);

if($emp_tel!="")$texto_telefono='Teléfono: '.$emp_tel;
if($emp_ema!="")$texto_email='Correo: '.$emp_ema;
if($emp_ruc==0)$emp_ruc="";

//INGRESO
$dts= $oEgreso->mostrarUno($_POST['egr_id']);
  $dt = mysql_fetch_array($dts);
    $fecreg   =mostrarFechaHora($dt['tb_egreso_fecreg']);
    $fecmod   =mostrarFechaHora($dt['tb_egreso_fecmod']);
    $usureg   =$dt['tb_egreso_usureg'];
    $usumod   =$dt['tb_egreso_usumod'];
    
    $fec    =mostrarFecha($dt['tb_egreso_fec']);
    $doc_id   =$dt['tb_documento_id'];
    $doc_nom    =$dt['tb_documento_nom'];
    $numdoc   =$dt['tb_egreso_numdoc'];
    
    $det    =$dt['tb_egreso_det'];
    
    $cue_id   =$dt['tb_cuenta_id'];
    $subcue_id  =$dt['tb_subcuenta_id'];

    $pro_id   =$dt['tb_proveedor_id'];
    $pro_nom  =$dt['tb_proveedor_nom'];
    $pro_doc  =$dt['tb_proveedor_doc'];
    $pro_dir  =$dt['tb_proveedor_dir'];
    $pro_tip  =$dt['tb_proveedor_tip'];
    $pro_tipdoc  =$dt['tb_proveedor_tipdoc'];
    
    $imp    =formato_money($dt['tb_egreso_imp']);
    
    $caj_id   =$dt['tb_caja_id'];
    $caj_nom  =$dt['tb_caja_nom'];

    $ven_id   =$dt['tb_venta_id'];
    
    $est    =$dt['tb_egreso_est'];
    
  mysql_free_result($dts);

$monto_letras=numtoletras($dt['tb_egreso_imp']);

//fecha 
  $fec_d  =date('d', strtotime($fec));
  $fec_m  =date('m', strtotime($fec));
  $fec_m  =$fec_m*1;
  $fec_m  =nombre_mes($fec_m);
  $fec_y  =date('Y', strtotime($fec));

if($pro_tipdoc==1)$pro_doc_nom='RUC';
if($pro_tipdoc==2)$pro_doc_nom='DNI';

/*
//vendedor
$dts=$oUsuario->mostrarUno($usu_id);
$dt = mysql_fetch_array($dts);
	$usu_nom	=$dt['tb_usuario_nom'];
	$usu_apepat	=$dt['tb_usuario_apepat'];
	$usu_apemat	=$dt['tb_usuario_apemat'];
mysql_free_result($dts);
$texto_vendedor="$usu_nom $usu_apepat $usu_apemat";
$texto_vendedor=substr($usu_nom, 0, 3).substr($usu_apepat, 0, 1).substr($usu_apemat, 0, 1);
*/

$impresion='pdf';

if($impresion=='pdf')ob_start();
?>
<page id="contenido_pdf" <?php echo $pager_formato?> <?php echo $pager_margen?>>
<link rel="stylesheet" href="../../css/Estilo/documento_venta.css" type="text/css" media="print, projection, screen" />
<?php 
if($impresion=='pdf' or $impresion=='html'){
?>
    <page_header style="font-family:<?php //echo $tipo_de_letra?>">
        <?php /*?><table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: left;    width: 33%"></td>
                <td style="text-align: center;    width: 34%"></td>
                <td style="text-align: right;    width: 33%"><?php //echo date('d/m/Y'); ?></td>
            </tr>
        </table><?php */?>
    </page_header>
    <page_footer style="font-family:<?php //echo $tipo_de_letra?>">
        <table border="<?php echo $borde_tablas?>">
            <tr>
                <td style="text-align: left; width: 50%; font-size: 7pt;"><?php //echo 'www.uneworld.com' //echo 'Registrado: '.date('H:i:s d/m/Y', strtotime($fecreg)); ?></td>
                <td style="text-align: right; width: 50%; font-size: 7pt;"><?php //echo 'Impresión: '.date('H:i:s d/m/Y'); ?>
            <!--Página [[page_cu]]/[[page_nb]]--></td>
            </tr>
        </table>
    </page_footer>
<table border="<?php echo $borde_tablas?>">
  <tr>
    <td style="width: 70mm; height:12mm; vertical-align:top;">
        <table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="logo.jpg" width="100"  height="45" border="0" align="" alt="logo"></td>
        	<td>
            <table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
            <tr>
              <td style="font-size: 7pt; font-weight:bold;"><?php echo $emp_razsoc?></td>
            </tr>
            <tr>
              <td style="font-size: 7pt;"><?php echo $emp_dir.' '.$emp_dir2?></td>
            </tr>
            <tr>
              <td style="font-size: 7pt;"><?php echo 'Telf: '.$emp_tel?></td>
            </tr>
            </table>
          </td>
        </tr>
        </table>
	  </td>
    <td style="width: 38mm; text-align:right; vertical-align:top;" border="<?php echo $borde_tablas?>">
        <table align="right" border="<?php echo $borde_tablas?>">
            <tr>
            <td align="center"><span style="font-size: 9pt; font-weight: bold;"><?php echo $doc_nom?></span></td>
            </tr>
            <tr>
            <td style="text-align: center; font-size: 10pt;"><?php echo 'N° '.$numdoc?></td>
            </tr>
        </table>
    </td>
  </tr>
</table>
<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0" style="width: 80mm;">
  <tr>
    <td colspan="3" style=" width:128mm; text-align:right;">
    <table border="<?php echo '0';//$borde_tablas?>" align="right">
      <tr>
        <td style=" width:30mm; font-size: 10pt; height:3mm; text-align:right; background:#E6E6E6; font-weight: bold;">
          <?php echo 'S/. '.$imp;?>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td valign="top" style="width:20mm; font-size: 8pt; height:5mm;"><?php echo '<strong>NOMBRE</strong>'?></td>
    <td valign="top" style="width:1mm; font-size: 8pt;"><?php echo '<strong>:</strong>'?></td>
    <td valign="top" style="width:105mm; font-size: 8pt;"><?php echo $pro_nom?></td>
  </tr>
  <tr>
    <td valign="top" style="font-size: 8pt; height:5mm;"><?php echo '<strong>IDENTIFICADO</strong>'?></td>
    <td valign="top" style="font-size: 8pt;"><?php echo '<strong>:</strong>'?></td>
    <td valign="top" style="font-size: 8pt;"><?php echo $pro_doc_nom.' '.$pro_doc?></td>
  </tr>
  <tr>
    <td valign="top" style="font-size: 8pt; height:5mm;"><?php echo '<strong>IMPORTE</strong>'?></td>
    <td valign="top" style="font-size: 8pt;"><?php echo '<strong>:</strong>'?></td>
    <td valign="top" style="width:105mm; font-size: 8pt;"><?php echo $monto_letras?></td>
  </tr>
  <tr>
    <td valign="top" style="font-size: 8pt; height:5mm;"><?php echo '<strong>CONCEPTO</strong>'?></td>
    <td valign="top" style="font-size: 8pt;"><?php echo '<strong>:</strong>'?></td>
    <td valign="top" style="width:105mm; font-size: 8pt; height:9mm;"><?php echo $det?></td>
  </tr>
  <tr>
    <td valign="top" colspan="3" style="font-size: 8pt; height:2mm;"><?php echo ''?></td>
  </tr>
  <tr>
    <td valign="top" colspan="3" style="font-size: 8pt; height:5mm; text-align:right;"><?php echo "Chiclayo, $fec_d de $fec_m de $fec_y.";?></td>
  </tr>
  <tr>
    <td valign="top" colspan="3" style="font-size: 8pt; height:2mm;"><?php echo ''?></td>
  </tr>
</table>
<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0" style="width: 80mm;">
  <tr>
    <td valign="top" style="width:64mm; font-size: 7pt; height:5mm;"><?php echo 'V°B°'?></td>
    <td valign="top" style="width:64mm; font-size: 7pt;"><?php echo 'RECIBÍ CONFORME'?></td>
  </tr>
  <tr>
    <td valign="top"align="center" style="font-size: 8pt; height:1mm;"><?php echo '________________________'?></td>
    <td valign="top" align="center" style="font-size: 8pt;"><?php echo '________________________'?></td>
  </tr>
  <tr>
    <td valign="top" align="center" style="font-size: 7pt; height:3mm;"><?php echo 'Nombres y Apellidos'?></td>
    <td valign="top" align="center" style="font-size: 7pt;"><?php echo 'Nombres y Apellidos'?></td>
  </tr>
</table>
<br>
<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0" style="width: 80mm;">
  <tr>
    <td valign="top" style="width:64mm; font-size: 7pt; height:5mm;"><?php echo 'www.uneworld.com'?></td>
    <td valign="top" align="right" style="width:64mm; font-size: 5pt;"><?php echo 'EGRESO | '.$caj_nom?></td>
  </tr>
</table>

<br>
<br>
<br>
<br>
<br>

<table border="<?php echo $borde_tablas?>">
  <tr>
    <td style="width: 70mm; height:12mm; vertical-align:top;">
        <table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="logo.jpg" width="100"  height="45" border="0" align="" alt="logo"></td>
          <td>
            <table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
            <tr>
              <td style="font-size: 7pt; font-weight:bold;"><?php echo $emp_razsoc?></td>
            </tr>
            <tr>
              <td style="font-size: 7pt;"><?php echo $emp_dir.' '.$emp_dir2?></td>
            </tr>
            <tr>
              <td style="font-size: 7pt;"><?php echo 'Telf: '.$emp_tel?></td>
            </tr>
            </table>
          </td>
        </tr>
        </table>
    </td>
    <td style="width: 38mm; text-align:right; vertical-align:top;" border="<?php echo $borde_tablas?>">
        <table align="right" border="<?php echo $borde_tablas?>">
            <tr>
            <td align="center"><span style="font-size: 9pt; font-weight: bold;"><?php echo $doc_nom?></span></td>
            </tr>
            <tr>
            <td style="text-align: center; font-size: 10pt;"><?php echo 'N° '.$numdoc?></td>
            </tr>
        </table>
    </td>
  </tr>
</table>
<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0" style="width: 80mm;">
  <tr>
    <td colspan="3" style=" width:128mm; text-align:right;">
    <table border="<?php echo '0';//$borde_tablas?>" align="right">
      <tr>
        <td style=" width:30mm; font-size: 10pt; height:3mm; text-align:right; background:#E6E6E6; font-weight: bold;">
          <?php echo 'S/. '.$imp;?>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td valign="top" style="width:20mm; font-size: 8pt; height:5mm;"><?php echo '<strong>NOMBRE</strong>'?></td>
    <td valign="top" style="width:1mm; font-size: 8pt;"><?php echo '<strong>:</strong>'?></td>
    <td valign="top" style="width:105mm; font-size: 8pt;"><?php echo $pro_nom?></td>
  </tr>
  <tr>
    <td valign="top" style="font-size: 8pt; height:5mm;"><?php echo '<strong>IDENTIFICADO</strong>'?></td>
    <td valign="top" style="font-size: 8pt;"><?php echo '<strong>:</strong>'?></td>
    <td valign="top" style="font-size: 8pt;"><?php echo $pro_doc_nom.' '.$pro_doc?></td>
  </tr>
  <tr>
    <td valign="top" style="font-size: 8pt; height:5mm;"><?php echo '<strong>IMPORTE</strong>'?></td>
    <td valign="top" style="font-size: 8pt;"><?php echo '<strong>:</strong>'?></td>
    <td valign="top" style="width:105mm; font-size: 8pt;"><?php echo $monto_letras?></td>
  </tr>
  <tr>
    <td valign="top" style="font-size: 8pt; height:5mm;"><?php echo '<strong>CONCEPTO</strong>'?></td>
    <td valign="top" style="font-size: 8pt;"><?php echo '<strong>:</strong>'?></td>
    <td valign="top" style="width:105mm; font-size: 8pt; height:9mm;"><?php echo $det?></td>
  </tr>
  <tr>
    <td valign="top" colspan="3" style="font-size: 8pt; height:2mm;"><?php echo ''?></td>
  </tr>
  <tr>
    <td valign="top" colspan="3" style="font-size: 8pt; height:5mm; text-align:right;"><?php echo "Chiclayo, $fec_d de $fec_m de $fec_y.";?></td>
  </tr>
  <tr>
    <td valign="top" colspan="3" style="font-size: 8pt; height:2mm;"><?php echo ''?></td>
  </tr>
</table>
<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0" style="width: 80mm;">
  <tr>
    <td valign="top" style="width:64mm; font-size: 7pt; height:5mm;"><?php echo 'V°B°'?></td>
    <td valign="top" style="width:64mm; font-size: 7pt;"><?php echo 'RECIBÍ CONFORME'?></td>
  </tr>
  <tr>
    <td valign="top"align="center" style="font-size: 8pt; height:1mm;"><?php echo '________________________'?></td>
    <td valign="top" align="center" style="font-size: 8pt;"><?php echo '________________________'?></td>
  </tr>
  <tr>
    <td valign="top" align="center" style="font-size: 7pt; height:3mm;"><?php echo 'Nombres y Apellidos'?></td>
    <td valign="top" align="center" style="font-size: 7pt;"><?php echo 'Nombres y Apellidos'?></td>
  </tr>
</table>
<br>
<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0" style="width: 80mm;">
  <tr>
    <td valign="top" style="width:64mm; font-size: 7pt; height:5mm;"><?php echo 'www.uneworld.com'?></td>
    <td valign="top" align="right" style="width:64mm; font-size: 5pt;"><?php echo 'COPIA | EGRESO | '.$caj_nom?></td>
  </tr>
</table>

<?php 
}//fin impresion pdf
?>
</page>
<?php
if($impresion=='pdf')
{
    $content = ob_get_clean();
	
	//require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	require_once('../../libreriasphp/html2pdf/html2pdf.class.php');

    try
    {
        $html2pdf = new HTML2PDF($orientacion_impresion, $formato_impresion, 'es', true, 'UTF-8', $margen_array);
        $html2pdf->pdf->SetDisplayMode('fullpage');
		
		//$html2pdf->AddFont($tipo_de_letra, '',"../../libreriasphp/html2pdf/_tcpdf_5.0.002/fonts/$tipo_de_letra_arch");
		//$html2pdf->pdf->SetFont($tipo_de_letra, '', 11);
		
		$html_d=$_GET['vuehtml'];
		//$html_d=1;
		
        $html2pdf->writeHTML($content, isset($html_d));
		$html2pdf->pdf->IncludeJS("print(true);");
		//$html2pdf->pdf->IncludeJS("app.alert('inticap.com');");
		
		

		$nombre_arc='recibo_'.$numdoc.'.pdf';
        $html2pdf->Output($nombre_arc);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
?>