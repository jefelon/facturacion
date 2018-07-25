<?php
session_start();
//if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../../modulos/empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../../modulos/guiapagocontrol/cGuiapago.php");
$oGuiapago = new cGuiapago();
require_once ("../../modulos/cliente/cCliente.php");
$oCliente = new cCliente();
require_once ("../../modulos/usuarios/cUsuario.php");
$oUsuario = new cUsuario();

require_once("../../modulos/formatos/formato.php");
require_once("../../modulos/formatos/fechas.php");
require_once("../../modulos/formatos/numletras.php");

$tipo_de_letra="DejaVuSansCondensed";
//$tipo_de_letra="DejaVuSans";
//$tipo_de_letra="DejaVuSansMono";
//$tipo_de_letra="DejaVuSerif";
//$tipo_de_letra="DejaVuSerifCondensed";
//$tipo_de_letra="FreeMono";
//$tipo_de_letra="FreeSans";
//$tipo_de_letra="times";
//$tipo_de_letra="arial";
//$tipo_de_letra="courier";
//$tipo_de_letra="helvetica";
//$tipo_de_letra="ArialUnicodeMS";

//$tipo_de_letra_arch="dejavusans.php";
//$tipo_de_letra_arch="arialunicid0.php";

$pager_formato='format="148x210" orientation="L" style="font-size: 11pt; font-family:'.$tipo_de_letra.'"';

$pager_margen='backtop="0mm" backbottom="0mm" backleft="2mm" backright="0mm"';

//html2pdf
$orientacion_impresion='P';
$formato_impresion='A4';
$margen_array=array(10, 10, 10, 5);
//$margen_array=0;

$borde_tablas=0;
/*
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
*/
//
$dts= $oGuiapago->mostrarUno($_GET['d1']);
  $dt = mysql_fetch_array($dts);
    $fecreg   =mostrarFechaHora($dt['tb_guiapago_fecreg']);
    $fecmod   =mostrarFechaHora($dt['tb_guiapago_fecmod']);
    $usureg   =$dt['tb_guiapago_usureg'];
    $usumod   =$dt['tb_guiapago_usumod'];

    $guipagtip_id=$dt['tb_guiapagotipo_id'];
    $fecven   =mostrarFecha($dt['tb_guiapago_fecven']);
    $fecpag   =mostrarFecha($dt['tb_guiapago_fecpag']);
    $des      =$dt['tb_guiapago_des'];
    $imppagbas=formato_money($dt['tb_guiapago_imppagbas']);
    $est      =$dt['tb_guiapago_est'];
    
    $cli_id =$dt['tb_cliente_id'];

    $per    =$dt['tb_periodo_id'];
    $per    =str_pad($per, 2, "0", STR_PAD_LEFT);
    $eje    =$dt['tb_ejercicio_id'];
    
    $pag    =$dt['tb_guiapago_pag'];
    $codtri =$dt['tb_guiapago_codtri'];
    $imppag =formato_money($dt['tb_guiapago_imppag']);

    $codtriaso =$dt['tb_guiapago_codtriaso'];
    $numdoc =$dt['tb_guiapago_numdoc'];
    
    
  mysql_free_result($dts);

  //fecha guiapago
  $guiapago_fec_d  =date('d', strtotime($fec));
  $guiapago_fec_m  =date('m', strtotime($fec));
  $guiapago_fec_m  =$guiapago_fec_m*1;
  $guiapago_fec_m  =nombre_mes($guiapago_fec_m);
  $guiapago_fec_y  =date('Y', strtotime($fec));

//cliente
$dts=$oCliente->mostrarUno($cli_id);
$dt = mysql_fetch_array($dts);
  $cli_nom  =$dt['tb_cliente_nom'];
  $cli_doc  =$dt['tb_cliente_doc'];
mysql_free_result($dts);

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

$mostrar='0';
if($_GET['d2']==$cli_id)$mostrar='1';


if($mostrar=='1')$impresion='pdf';

if($impresion=='pdf')ob_start();
?>
<page id="contenido_pdf" <?php echo $pager_formato?> <?php echo $pager_margen?>>
<link rel="stylesheet" href="guiapago_impresion.css" type="text/css" media="print, projection, screen" />
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
              <td style="text-align: left; width: 92mm; font-size: 7pt;">Registrado: <?php echo date('H:i:s d/m/Y', strtotime($fecreg)); ?></td>
              <td style="text-align: right; width: 92mm; font-size: 7pt;">Impresión: <?php echo date('H:i:s d/m/Y'); ?>
          <!--Página [[page_cu]]/[[page_nb]]--></td>
          </tr>
      </table>
  </page_footer>

<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
  <tr style="border: 1px solid #000;">
    <td style="font-size: 9pt; width: 185mm; border: 1px solid #000;" colspan="2"><?php echo "<strong>SÓLO PARA SER USADO COMO BORRADOR:</strong> UTILICE ESTA GUÍA PARA FACILITAR SU DECLARACION Y PAGO"?></td>
  </tr>
  <tr>
    <td style="font-size: 11pt;" colspan="2"></td>
  </tr>
  <tr>
    <td style="width: 130mm; font-size: 14pt; border: 1px solid #000;" align="center"><?php echo "<strong>GUÍA PARA PAGOS VARIOS</strong>"?></td>
    <td style="width: 53mm; font-size: 11pt;" align="right"><img src="logo-sunat.gif" width="170"  height="30" border="0" align="" alt="logo"></td>
  </tr>
  <tr>
    <td style="font-size: 11pt;" colspan="2"></td>
  </tr>
  <tr>
    <td style="font-size: 9pt; border: 1px solid #000;" align="center" colspan="2"><?php echo "UTILICE ESTA GUÍA SOLO SI ES MEDIANO O PEQUEÑO CONTRIBUYENTE"?></td>
  </tr>
</table>

<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:184mm; height:3mm; font-size: 9pt;" colspan="2"><?php echo "MARQUE LO QUE DESEA PAGAR"?></td>
  </tr>
  <tr>
    <td style="width:120mm; height:5mm;">
      <table style="border-collapse: collapse;">
          <tr>
            <td style="width:5mm; height:2mm; border: 1px solid #000; font-size: 9pt; text-align:center;"><?php if($pag=='1')echo "X"?></td>
            <td style="font-size: 8pt;">TRIBUTOS (Incluye ORDENES DE PAGO Y RESOLUCIONES)</td>
          </tr>
          <tr>
            <td style="width:5mm; height:2mm; border: 1px solid #000; font-size: 9pt; text-align:center;"><?php if($pag=='2')echo "X"?></td>
            <td style="font-size: 8pt;">MULTAS (Incluidas las del Nuevo Régimen Único Simplificado)</td>
          </tr>
          <tr>
            <td style="width:5mm; height:2mm; border: 1px solid #000; font-size: 9pt; text-align:center;"><?php if($pag=='3')echo "X"?></td>
            <td style="font-size: 8pt;">COSTAS Y GASTOS ADMINISTRATIVOS</td>
          </tr>
          <tr>
            <td style="width:5mm; height:2mm; border: 1px solid #000; font-size: 9pt; text-align:center;"><?php if($pag=='4')echo "X"?></td>
            <td style="font-size: 8pt;">FRACCIONAMIENTOS (ART 36º CODIGO TRIBUTARIO, D.LEG 848 ,PER,REFT,SEAP,RESIT)</td>
          </tr>
      </table>
    </td>
    <td style="width:56mm; " valign="top">
      <table style="border-collapse: collapse;">
        <tr>
          <td style="width:55mm; height:3mm; font-size: 8pt; text-align:center; "><?php echo $des.' | Fecha de Pago: '.$fecpag?></td>
        </tr>
        <tr>
          <td style="height:3mm; font-size: 8pt; text-align:center;"><?php echo $cli_nom?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
    <tr>
      <td style="width:60mm; height:5mm; font-size: 10pt;"><strong>NÚMERO DE RUC</strong></td>
      <td style="width:122mm; " colspan="2">
        <table style="border: 1px solid #000;">
          <tr>
            <td style="width:50mm; height:5mm; font-size: 13pt; text-align:center;" valign="middle"><?php echo $cli_doc?></td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td style="height:4mm; font-size: 10pt;" valign="top"><strong>PERIODO TRIBUTARIO</strong><br>que corresponda a la declaración</td>
      <td>
        <table class="tabledata">
          <tr>
            <td style="width:10mm; height:3mm; font-size: 9pt; text-align:center; ">MES</td>
            <td style="width:20mm; font-size: 9pt; text-align:center;">AÑO</td>
          </tr>
          <tr>
            <td style="height:4mm; font-size: 11pt; text-align:center;" valign="middle"><?php echo $per?></td>
            <td style="font-size: 11pt; text-align:center;" valign="middle"><?php echo $eje?></td>
          </tr>
        </table>
      </td>
      <td style="width:60mm; font-size: 8pt;" rowspan="3">
        <table style="border: 1px solid #000;" align="right">
          <tr>
            <td style="width:75mm; height:5mm; font-size: 9pt;" valign="top">
              <p style="margin-left:10px; text-align:justify; ">
              <u>IMPORTANTE</u><br>
              1. Si realiza pago por MULTAS verifique
              si debe consignar adicionalmente información
              en el rubro <u>Tributo Asociado a la Multa</u><br>
              2. SOLO si realiza pago por fracc.Art 36
              codigo tributario, costas, gastos, indique
              el número de documento
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td style="height:5mm; font-size: 10pt;"><strong>CÓDIGO DE TRIBUTO, CONCEPTO</strong><br><strong>O MULTA</strong></td>
      <td>
        <table style="border: 1px solid #000;">
          <tr>
            <td style="width:25mm; height:5mm; font-size: 13pt; text-align:center;" valign="middle"><?php echo $codtri?></td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td style="height:4mm; font-size: 10pt;"><strong>IMPORTE A PAGAR</strong><br>(Sin decimales)</td>
      <td>
        <table style="border: 1px solid #000;">
          <tr>
            <td style="width:25mm; height:5mm; font-size: 12pt; text-align:right;" valign="middle"><?php echo $imppag?></td>
          </tr>
        </table>
      </td>
    </tr>
</table>

<table>
  <tr>
    <td style="width: 180mm; font-size: 8pt; height:3mm;" colspan="2"></td>
  </tr>
  <tr>
    <td valign="top" style="border: 1px solid #000;">
      <table border="<?php echo $borde_tablas?>" cellpadding="0" cellspacing="0">
        <tr>
          <td style="width: 89mm; font-size: 8pt; height:3mm; text-align:center; " colspan="2">TRIBUTO ASOCIADO A LA MULTA </td>
        </tr>
        <tr>
          <td style="text-align: left; width: 45mm; font-size: 8pt; height:5mm;" valign="middle">CÓDIGO DE TRIBUTO ASOCIADO</td>
          <td>
              <table style="border: 1px solid #000;">
                <tr>
                  <td style="width:25mm; height:5mm; font-size: 13pt; text-align:center;" valign="middle"><?php echo $codtriaso?></td>
                </tr>
              </table>
          </td>
        </tr>
        <tr>
          <td style="text-align: left; width: 90mm; font-size: 8pt;" colspan="2">
            <p style="margin:0; text-align:justify;">
              Consigne informacion en este rubro SOLO SI el codigo de la multa
              corresponde a cualquiera de los siguientes : 6041; 6441; 6051
              6451; 6061; 6461; 6064; 6464; 6071; 6471; 6072; 6472; 6089
              6489; 6091; 6491; 6111; 6411; ó 6113.
            </p>
          </td>
        </tr>
      </table>
    </td>
    <td valign="top" style="border: 1px solid #000;">
      <table border="<?php echo $borde_tablas?>" cellpadding="0" cellspacing="0">
        <tr>
          <td style="width: 90mm; font-size: 8pt; height:3mm; text-align:center; " colspan="2">NÚMERO DE DOCUMENTO</td>
        </tr>
        <tr>
          <td style="text-align: left; width: 45mm; font-size: 8pt; height:5mm;" valign="middle">NÚMERO DE DOCUMENTO</td>
          <td style="">
              <table style="border: 1px solid #000;">
                <tr>
                  <td style="width:40mm; height:5mm; font-size: 13pt; text-align:center;" valign="middle"><?php echo $numdoc?></td>
                </tr>
              </table>
          </td>
        </tr>
        <tr>
          <td style="text-align: left; width: 90mm; font-size: 8pt;" colspan="2">
            <p style="margin:0; text-align:justify; ">
              consigne el NUMERO DE DOCUMENTO si efectúa pagos por
              alguno de los siguientes códigos o conceptos:<br>
              - FRACC ART. 36 DEL C.T. (8021;5216;5315 ó 5031) consigne
              el número de resolucion que aprueba el fraccionamiento<br>
              - COSTAS (5224;8061 ó 8063) consigne el Nro Expediente de
              cobranza coactiva<br>
              - GASTOS (codigo de tributo 5225;8062;8064 ó 8091)
            </p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table style="border: 1px solid #000;">
  <tr>
    <td style="width:184mm; height:4mm; font-size: 10pt; text-align:center;"><strong>VER TABLA DE CÓDIGOS DE TRIBUTOS DE USO FRECUENTE AL DORSO</strong></td>
  </tr>
</table>

<?php 
}//fin impresion pdf
else
{
  echo "Datos incorrectos.";
}
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
		//$html2pdf->pdf->IncludeJS("print(true);");
		//$html2pdf->pdf->IncludeJS("app.alert('a-zetasoft.com');");
		
		

		$nombre_arc='guiapago_'.$_GET['d2'].$_GET['d1'].'.pdf';
        $html2pdf->Output($nombre_arc);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
?>