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
    

    $toting =formato_money($dt['tb_guiapago_toting']);
    $cat =$dt['tb_guiapago_cat'];
    $moncom =formato_money($dt['tb_guiapago_moncom']);
    $rusimppag =formato_money($dt['tb_guiapago_rusimppag']);
    $privez =$dt['tb_guiapago_privez'];
    $compag =formato_money($dt['tb_guiapago_compag']);
    
    
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
    <td style="font-size: 9pt; width: 185mm; border: 1px solid #000;" colspan="2" align="center"><?php echo "<strong>SÓLO PARA SER USADO COMO BORRADOR - PARA PERIODOS TRIBUTARIOS ENERO 2007 EN ADELANTE</strong>"?></td>
  </tr>
  <tr>
    <td style="font-size: 11pt;" colspan="2"></td>
  </tr>
  <tr>
    <td style="width: 130mm; font-size: 14pt; border: 0px solid #000;" align="center"><?php echo "<strong>Guía
PAGO FÁCIL<br>
NUEVO RÉGIMEN ÚNICO SIMPLIFICADO</strong>"?></td>
    <td style="width: 53mm; font-size: 11pt;" align="right"><img src="logo-sunat.gif" width="170"  height="30" border="0" align="" alt="logo"></td>
  </tr>
  <tr>
    <td style="font-size: 11pt;" colspan="2"></td>
  </tr>
  <tr>
    <td style="font-size: 9pt; border: 1px solid #000;" align="center" colspan="2"><?php echo "<u>EN CASO DE RECTIFICATORIA</u>: SÓLO PODRÁ RECTIFICAR LA CATEGORÍA Y/O EL TOTAL INGRESOS BRUTOS
 DEL MES,<br> PARA LO CUAL DEBERÁ LLENAR TODOS LOS DATOS DE ESTA GUÍA"?></td>
  </tr>
</table>

<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:184mm; font-size: 8pt;" valign="top" align="right">
    <?php echo $des.' | Fecha de Pago: '.$fecpag?>
    </td>
  </tr>
  <tr>
    <td style="height:3mm; font-size: 8pt; text-align:right;"><?php echo $cli_nom?></td>
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
      <td style="width:60mm; font-size: 8pt;" rowspan="5">
        <table>
          <tr>
            <td style="width:84mm; height:5mm; font-size: 9pt;" valign="top" align="center">
              <strong>¿ES LA PRIMERA VEZ QUE DECLARA PARA ESTE PERIODO?</strong><br>(Marque con X según corresponda)
            </td>
          </tr>
          <tr>
            <td align="center">
              <table style="width:50mm;">
                <tr>
                  <td style="width:20mm;" ></td>
                  <td style="width:5mm; height:2mm; border: 1px solid #000; font-size: 9pt; text-align:center;"><?php if($privez=='1')echo "X"?></td>
                  <td style="width:12mm; font-size: 8pt;">NO</td>
                  <td style="width:6mm;" ></td>
                  <td style="width:5mm; height:2mm; border: 1px solid #000; font-size: 9pt; text-align:center;"><?php if($privez=='2')echo "X"?></td>
                  <td style="width:12mm; font-size: 8pt;">SI</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
        <table style="border: 1px solid #000;">
          <tr>
            <td style="width:60mm; height:5mm; font-size: 9pt;" valign="top">
              <table>
                <tr>
                  <td style="width:84mm; height:2mm; border: 0px solid #000; font-size: 8pt;" colspan="2">
                    De haber marcado <strong>NO</strong>, deberá proporcionar la información de la
                    Compensación de las Percepciones de IGV y/o de los pagos
                    efectuados en la declaración original que se está rectificando.
                  </td>
                </tr>
                <tr>
                  <td style="width:47mm; height:5mm; font-size: 10pt;" valign="middle">
                      <strong>COMPENSACIÓN Y/O<br> PAGOS EFECTUADOS</strong>
                  </td>
                  <td style="width:36mm; height:5mm; border: 1px solid #000; font-size: 10pt; text-align:right;" valign="middle"><?php echo $compag?></td>
                </tr>
                <tr>
                  <td style=" width:84mm; height:2mm; border: 0px solid #000; font-size: 8pt;" colspan="2">
                      <strong><u>IMPORTANTE</u></strong>: Si está presentando una declaración rectificatoria,
                      <strong>NO OLVIDE</strong> consignar los <strong>montos compensados</strong> y/o los <strong>pagos
                      efectuados</strong> en la <strong>declaración original</strong>.
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td style="height:4mm; font-size: 10pt;"><strong>TOTAL INGRESOS<br>BRUTOS DEL MES</strong></td>
      <td>
        <table style="border: 1px solid #000;">
          <tr>
            <td style="width:25mm; height:5mm; font-size: 12pt; text-align:right;" valign="middle"><?php echo $toting?></td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td style="height:5mm; font-size: 10pt;"><strong>CATEGORÍA</strong></td>
      <td>
        <table style="border: 1px solid #000;">
          <tr>
            <td style="width:12mm; height:5mm; font-size: 13pt; text-align:center;" valign="middle"><?php echo $cat?></td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td style="height:13mm; font-size: 10pt;"><strong>MONTO A COMPENSAR POR <br>PERCEPCIONES DE IGV QUE LE<br> HUBIESEN AFECTUADO</strong></td>
      <td>
        <table style="border: 1px solid #000;">
          <tr>
            <td style="width:25mm; height:5mm; font-size: 12pt; text-align:right;" valign="middle"><?php echo $moncom?></td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td style="height:4mm; font-size: 10pt;"><strong>IMPORTE A PAGAR</strong><br>(Ver tabla al reverso)</td>
      <td>
        <table style="border: 1px solid #000;">
          <tr>
            <td style="width:25mm; height:5mm; font-size: 12pt; text-align:right;" valign="middle"><?php echo $rusimppag?></td>
          </tr>
        </table>
      </td>
    </tr>
</table>

<table>
  <tr>
    <td style="width: 180mm; font-size: 8pt; height:1mm;" ></td>
  </tr>
  <tr>
    <td style="width: 180mm; font-size: 10pt; " >
        <table style="border: 1px solid #000;">
          <tr>
            <td style="width: 182mm; height:5mm; text-align:justify; font-size: 9pt;" valign="middle">
              <strong><u>IMPORTANTE</u></strong>:<br>
(1) Este importe se obtendrá de la suma de los comprobantes de pago emitidos durante el período tributario a declarar.<br>
(2) Consigne información sólo si le hubiesen efectuado Percepciones de IGV y opte por compensarlas. El monto
máximo que puede compensar es el monto de la cuota (incluye intereses moratorios, sólo si corresponde).<br>
(3) Si el pago lo está realizando fuera de plazo, incluya en el IMPORTE A PAGAR los intereses moratorios
correspondientes.
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td style="width: 180mm; font-size: 8pt; height:1mm;" ></td>
  </tr>

</table>

<table style="border: 1px solid #000;">
  <tr>
    <td style="width:184mm; height:4mm; font-size: 9pt; text-align:center;"><strong>VER INSTRUCCIONES AL REVERSO</strong></td>
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