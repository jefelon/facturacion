<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("cTransferencia.php");
$oTransferencia = new cTransferencia();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../caja/cCaja.php");
$oCaja = new cCaja();
/*require_once ("cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();*/

require_once("../formatos/formato.php");

$tra_id=$_POST['tra_id'];

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


//traspaso
$dts= $oTransferencia->mostrarUno($tra_id);
	$dt = mysql_fetch_array($dts);
		$reg		=mostrarFechaHora($dt['tb_transferencia_reg']);
		$mod		=mostrarFechaHora($dt['tb_transferencia_mod']);

		$fec		=mostrarFecha($dt['tb_transferencia_fec']);
		$cod		=$dt['tb_transferencia_cod'];
		
		$des		=$dt['tb_transferencia_des'];
		$mon		=$dt['tb_transferencia_mon'];
		
		$caj_id_ori		=$dt['tb_caja_id_ori'];
		$caj_id_des		=$dt['tb_caja_id_des'];
		
		$mon_id		=$dt['tb_moneda_id'];
		
		$est		=$dt['tb_transferencia_est'];
		
		$usu_id_reg	=$dt['tb_usuario_id_reg'];
		$usu_id_mod	=$dt['tb_usuario_id_mod'];
	mysql_free_result($dts);

//USUARIO
$dts=$oUsuario->mostrarUno($usu_id_reg);
$dt = mysql_fetch_array($dts);

	$usu_nom		=$dt['tb_usuario_nom'];
	$usu_apepat		=$dt['tb_usuario_apepat'];
	$usu_apemat		=$dt['tb_usuario_apemat'];

	$usu_ema		=$dt['tb_usuario_ema'];

mysql_free_result($dts);

$texto_usuario=$usu_apepat.' '.$usu_apemat.' '.$usu_nom;

/*	$dts=$oUsuariodetalle->mostrarUno($usu_id);
	$dt = mysql_fetch_array($dts);
	
		$dni		=$dt['tb_usuario_dni'];
		$punven_id	=$dt['tb_puntoventa_id'];
		$hor_id		=$dt['tb_horario_id'];

	mysql_free_result($dts);*/

//cajas
$dts=$oCaja->mostrarUno($caj_id_ori);
$dt = mysql_fetch_array($dts);
	$caja1=$dt['tb_caja_nom'];
mysql_free_result($dts);

$dts=$oCaja->mostrarUno($caj_id_des);
$dt = mysql_fetch_array($dts);
	$caja2=$dt['tb_caja_nom'];
mysql_free_result($dts);

//monto
if($mon_id==1)$texto_monto='S/ '.formato_money($mon); 
if($mon_id==2)$texto_monto='US$ '.formato_money($mon);


$impresion='pdf';

if($impresion=='pdf')ob_start();

?>
<page id="contenido_pdf" format="168x215" orientation="L" style="font-size: 10pt"  backtop="5mm" backbottom="5mm" backleft="4mm" backright="30mm">
<link rel="stylesheet" href="../../css/Estilo/documento_transferencia.css" type="text/css" media="print, projection, screen" />
<?php if($impresion=='pdf'){?>
    <page_header>
        <table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: left;    width: 20%">&nbsp;</td>
                <td style="text-align: center;    width: 20%"></td>
                <td style="text-align: right;    width: 60%"><span style="text-align: right; font-size: 10pt; width: 35%"><span style="text-align: left; width: 35%; font-size: 10pt;">Impresión: <?php echo date('d-m-Y H:i:s')//;$reg ?></span> Página [[page_cu]]/[[page_nb]]</span>                  <?php //echo date('d/m/Y'); ?></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: left; width: 35%; font-size: 10pt;"><!--Impresión: <?php //echo date('d-m-Y H:i:s')//;$reg ?>--></td>
                <td style="text-align: center; width: 30%; font-size: 10pt;"><!--Sistema de Ventas. www.inticap.com--></td>
                <td style="text-align: right; font-size: 10pt; width: 35%"><!--Página [[page_cu]]/[[page_nb]]--></td>
            </tr>
        </table>
    </page_footer>
<?php }?>
<table>
  <tr>
    <td style="width: 118mm; vertical-align:top">
        <table width="450px" border="0" cellspacing="0" cellpadding="0">
        <tr>
        	<td><span style="font-size: 11pt;"><?php echo $emp_razsoc?></span></td>
        </tr>
        <tr>
        	<td><?php //echo $emp_dir?></td>
        </tr>
        <tr>
        	<td><?php //echo $emp_dir2?></td>
        </tr>
        <tr>
          	<td><span style="font-size: 8pt;"><?php //echo $texto_telefono.' '.$texto_email?></span></td>
        </tr>
        </table>
	</td>
    <td style="width: 52mm; text-align:right;">
        <table align="right" style="width: 51mm;">
            <!--<tr>
            <td style="width: 50mm; height: 7mm; text-align: center;"><span style="font-size: 12pt;">R.U.C. N° <?php //echo $emp_ruc?></span></td>
            </tr>-->
            <tr>
            <td style="font-size: 11pt; font-weight: bold; text-align:center">TRANSFERENCIA CAJA</td>
            </tr>
            <tr>
            <td align="center"><span style="font-size: 12pt;">N° <?php echo $cod?></span></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td style="width: 118mm; vertical-align:top">
    	<table width="450px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="width: 35mm; font-size: 10pt;">USUARIO:</td>
          <td style="width: 80mm; font-size: 10pt;"><?php echo $texto_usuario?></td>
        </tr>
        <tr>
          <td style="width: 35mm; font-size: 10pt;">CAJA ORIGEN:</td>
        <td style="font-size: 10pt;"><?php echo $caja1?></td>
        </tr>
        <tr>
          <td style="font-size: 10pt;">CAJA DESTINO:</td>
        <td style="font-size: 10pt;"><?php echo $caja2?></td>
        </tr>
        <tr>
          <td style="font-size: 10pt;">REFERENCIA:</td>
          <td style="font-size: 10pt;"><?php echo $des?></td>
        </tr>
        <tr>
          <td style="font-size: 10pt;">MONTO:</td>
          <td style="font-size: 10pt;"><?php echo $texto_monto?></td>
        </tr>
        </table>
    </td>
    <td valign="top" style="width: 52mm; text-align:center; font-size: 10pt;">Fecha: <?php echo $fec?><!--<br>Registro: <?php //echo $reg?>--></td>
  </tr>
</table>
</page>
<?php
if($impresion=='pdf')
{
    $content = ob_get_clean();
	
	//require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	require_once('../../libreriasphp/html2pdf/html2pdf.class.php');

    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', array(15, 10, 15, 10));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		//$html2pdf->pdf->IncludeJS("print(true);");
		//$html2pdf->pdf->IncludeJS("app.alert('inticap.com');");

		$nombre_arc='transferencia_'.$cod.'.pdf';
        $html2pdf->Output($nombre_arc);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
?>