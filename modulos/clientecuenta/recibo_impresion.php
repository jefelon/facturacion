<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../ventanota/cVentanota.php");
$oVentanota = new cVentanota();
/*require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();*/
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();

require_once("../formatos/formato.php");
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

$pager_formato='format="90x205" orientation="P" style="font-size: 9pt; font-family:'.$tipo_de_letra.'"';

$pager_margen='backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm"';

//html2pdf
$orientacion_impresion='P';
$formato_impresion='A4';
$margen_array=array(2, 2, 2, 5);
//$margen_array=0;

$borde_tablas=0;

//recibo

$clicue_id=$_POST['clicue_id'];

$dts=$oClientecuenta->mostrarUno($_POST['clicue_id']);
	$dt = mysql_fetch_array($dts);
		$reg	=$dt['tb_clientecuenta_fecreg'];
		$clicue_fec	=$dt['tb_clientecuenta_fec'];
		$clicue_glo	=$dt['tb_clientecuenta_glo'];
		$clicue_tip	=$dt['tb_clientecuenta_tip'];//Tipo
		$clicue_mon	=$dt['tb_clientecuenta_mon'];//Monto
		$clicue_est	=$dt['tb_clientecuenta_est'];//Estado
		
		$ventip		=$dt['tb_clientecuenta_ventip'];
		$ven_id		=$dt['tb_clientecuenta_ven_id'];
		
		$forpag_id	=$dt['tb_formapago_id'];
		$modpag_id	=$dt['tb_modopago_id'];
		$tar_id		=$dt['tb_tarjeta_id'];
		$tar_nom		=$dt['tb_tarjeta_nom'];
		
		$numope		=$dt['tb_clientecuenta_numope'];
		$numdia		=$dt['clientecuenta_numdia'];
		$fecven		=$dt['tb_clientecuenta_fecven'];		
		
		$cli_id		=$dt['tb_cliente_id'];
		$cli_nom		=$dt['tb_cliente_nom'];
		$cli_doc		=$dt['tb_cliente_doc'];
		$cli_dir		=$dt['tb_cliente_dir'];
		
		$clicue_ver	=$dt['tb_clientecuenta_ver'];
		
		$usu_id	=$dt['tb_usuario_id'];
		
	mysql_free_result($dts);

	$doc_nom='RECIBO';

//forma pago
$forma='';
//modo
if($modpag_id==1)
{
	$modo=' EFECTIVO';
}
if($modpag_id==2)
{
	$modo=' DEPOSITO OP: '.$numope;
}
if($modpag_id==3)
{
	$modo=''.$tar_nom.' OP: '.$numope;
}

$texto_pago=$forma.''.$modo;

//TIPO DE VENTA
	if($ventip==1)//venta
	{
		//datos de venta
		$dts= $oVenta->mostrarUno($ven_id);
		$dt = mysql_fetch_array($dts);
			$ven_reg	=mostrarFechaHoraH($dt['tb_venta_reg']);
			$ven_fec	=mostrarFecha($dt['tb_venta_fec']);
			
			//$doc_id	=$dt['tb_documento_id'];
			//$ven_numdoc	=$dt['tb_venta_numdoc'];
			//$cli_id	=$dt['tb_cliente_id'];
			//$cli_nom = $dt['tb_cliente_nom'];
			//$cli_doc = $dt['tb_cliente_doc'];
			//$cli_dir = $dt['tb_cliente_dir'];
			//$subtot	=$dt['tb_venta_subtot'];
			//$igv	=$dt['tb_venta_igv'];
			//$ven_tot	=$dt['tb_venta_tot'];
			//$est	=$dt['tb_venta_est'];
			
			//$lab1	=$dt['tb_venta_lab1'];
		mysql_free_result($dts);
		
		$texto_titulo='VENTA';
	}
	
	if($ventip==2)//nota venta
	{
		//datos de nota venta
		$dts= $oVentanota->mostrarUno($ven_id);
		$dt = mysql_fetch_array($dts);
			$ven_reg	=mostrarFechaHoraH($dt['tb_venta_reg']);
			$ven_fec	=mostrarFecha($dt['tb_venta_fec']);
			
			//$doc_id	=$dt['tb_documento_id'];
			//$ven_numdoc	=$dt['tb_venta_numdoc'];
			//$cli_id	=$dt['tb_cliente_id'];
			//$cli_nom = $dt['tb_cliente_nom'];
			//$cli_doc = $dt['tb_cliente_doc'];
			//$cli_dir = $dt['tb_cliente_dir'];
			//$subtot	=$dt['tb_venta_subtot'];
			//$igv	=$dt['tb_venta_igv'];
			//$ven_tot	=$dt['tb_venta_tot'];
			//$est	=$dt['tb_venta_est'];
			
			//$lab1	=$dt['tb_venta_lab1'];
		mysql_free_result($dts);
		
		$texto_titulo='NOTA VENTA';
		
	}

//empresa
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

//vendedor
if($usu_id>0)
{
$dts=$oUsuario->mostrarUno($usu_id);
$dt = mysql_fetch_array($dts);
	$usu_nom	=$dt['tb_usuario_nom'];
	$usu_apepat	=$dt['tb_usuario_apepat'];
	$usu_apemat	=$dt['tb_usuario_apemat'];
mysql_free_result($dts);
$texto_vendedor="$usu_nom $usu_apepat $usu_apemat";
$texto_vendedor=substr($usu_nom, 0, 3).substr($usu_apepat, 0, 1).substr($usu_apemat, 0, 1);
}


$impresion='pdf';

/*header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=nombre_archivo.doc");
header("Pragma: no-cache");
header("Expires: 0");
*/
if($impresion=='pdf')ob_start();

?>

<style>
    .centrado{
        text-align: center;
    }
</style>
<page id="contenido_pdf" <?php echo $pager_formato?> <?php echo $pager_margen?>>
<link rel="stylesheet" href="../../css/Estilo/documento_venta.css" type="text/css" media="print, projection, screen" />
<?php if($impresion=='pdf' or $impresion=='html'){?>
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
        <table style="width: 100%;" border="0">
            <tr>
                <td style="text-align: left; width: 40mm; font-size: 10pt;"><?php //echo 'R: '.$reg//date('d/m/Y'); ?></td>
                <td style="text-align: left; width: 130mm; font-size: 11pt;">
                  <?php
				  if($num_rows_vp>1){
			//echo '* ';
        foreach($texto_pago2 as $indice=>$valor){
			echo '* '.$valor.'  ';
		}
				  }
		?>
            <!--Página [[page_cu]]/[[page_nb]]--></td>
            </tr>
        </table>
    </page_footer>
<table border="<?php echo $borde_tablas?>">
        <tr>
        	<td class="centrado"><span style="font-size: 13pt;"><?php echo $emp_razsoc?></span></td>
        </tr>
        <tr>
        	<td class="centrado"><span style="font-size: 10pt;"><?php echo $emp_dir?></span></td>
        </tr>
        <tr>
        	<td class="centrado"><span style="font-size: 10pt;"><?php echo $emp_dir2?></span></td>
        </tr>
        <tr>
          	<td class="centrado"><span style="font-size: 8pt;"><?php echo $texto_telefono.' '.$texto_email?></span></td>
        </tr>

        <tr>
            <td class="centrado"><span style="font-size: 12pt;"><?php echo 'R.U.C. N° '.$emp_ruc?></span></td>
        </tr>
        <tr>
            <td class="centrado"><span style="font-size: 15pt; font-weight: bold;"><?php echo $doc_nom .' - '.'N° '.$clicue_id?></span></td>
        </tr>

        <tr>
            <td class="centrado"><span style="font-size: 12pt;"><?php echo 'FECHA: '.mostrarFecha($clicue_fec)?></span></td>
        </tr>
    <tr>
        <td colspan="4" height="10mm">.............................................................................................</td>
    </tr>
        <tr>
          <td><span style="font-size: 11pt;">CLIENTE:</span><?php echo $cli_nom?></td>
        </tr>
        <tr>
          <td><span style="font-size: 11pt;">DIRECCION: </span> <?php echo $cli_dir?></td>
        </tr>
    <tr>
        <td colspan="4" height="10mm">.............................................................................................</td>
    </tr>
        <tr>
            <td style="font-size: 10pt;">FORMA PAGO: <?php echo $texto_pago?></td>
        </tr>
        <tr>
          <td><span style="font-size: 11pt;">DOCUMENTO: </span> <?php echo $cli_doc?></td>
        </tr>
    <tr>
        <td style="font-size: 10pt;"><?php if($texto_vendedor!="")echo 'VENDEDOR: '.$texto_vendedor?></td>
    </tr>
    <tr>
        <td colspan="4" height="10mm">.............................................................................................</td>
    </tr>
</table>
<table border="<?php echo $borde_tablas?>" cellpadding="0" cellspacing="0" style="font-family:Arial;">
  <tr>
    <td style="text-align: left;font-size: 10pt;"><?php echo 'POR CONCEPTO DE: '.$clicue_glo.' FECHA VENTA: '.$ven_fec?></td>
  </tr>
  <tr>
      <td height="15mm"></td>
  </tr>
  <tr>
    <td><span style="text-align: left; font-size: 10pt;">SON:  <?php echo numtoletras($clicue_mon)?></span></td>
  </tr>
  <tr>
     <td colspan="2" style="text-align: right">S/. <?php echo formato_money($clicue_mon)?></td>
  </tr>
</table>
<br>
<br>
<div style="text-align:left">
<?php echo 'REG: '.$reg//date('d/m/Y'); ?>
</div>
    <div style="text-align:center">
        <h5>GRACIAS POR SU PREFERENCIA</h5>
    </div>
<?php
}
?>
</page>
<?php
if($impresion=='pdf')
{
    $content = ob_get_clean();
	
	//require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	//require_once('../../libreriasphp/html2pdf/html2pdf.class.php');
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
		//$html2pdf->pdf->IncludeJS("app.alert('a-zetasoft.com');");
		
		

		$nombre_arc='recibo_'.$numdoc.'.pdf';
        $html2pdf->Output($nombre_arc);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
?>
