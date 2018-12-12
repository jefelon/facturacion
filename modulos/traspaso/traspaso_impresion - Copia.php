<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("cTraspaso.php");
$oTraspaso = new cTraspaso();

require_once("../formatos/formato.php");

$tra_id=$_POST['tra_id'];

$dts=$oEmpresa->mostrarUno(1);
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
$dts= $oTraspaso->mostrarUno($tra_id);
$dt = mysql_fetch_array($dts);
	$reg		=mostrarFechaHora($dt['tb_traspaso_reg']);
	$fec		=mostrarFecha($dt['tb_traspaso_fec']);
	$cod=str_pad($dt['tb_traspaso_cod'],4, "0", STR_PAD_LEFT);
	$alm_ori	=$dt['almacen_ori'];
	$alm_des	=$dt['almacen_des'];
	$doc		=$dt['tb_traspaso_doc'];
mysql_free_result($dts);


$dts1=$oTraspaso->mostrar_traspaso_detalle($tra_id);
$num_rows= mysql_num_rows($dts1);

$impresion='pdf';

if($impresion=='pdf')ob_start();

?>
<page id="contenido_pdf" style="font-size: 10pt"  backtop="5mm" backbottom="5mm" backleft="4mm" backright="30mm">
<link rel="stylesheet" href="../../css/Estilo/documento.css" type="text/css" media="print, projection, screen" />
<?php if($impresion=='pdf'){?>
    <page_header>
        <table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: left;    width: 33%"></td>
                <td style="text-align: center;    width: 34%"></td>
                <td style="text-align: right;    width: 33%"><?php //echo date('d/m/Y'); ?></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: left; width: 35%; font-size: 8pt;">Impresión: <?php echo date('d-m-Y h:i:s a')//;$reg ?></td>
                <td style="text-align: center; width: 30%; font-size: 7pt;"><!--Sistema de Ventas. www.a-zetasoft.com--></td>
                <td style="text-align: right; font-size: 8pt; width: 35%">Página [[page_cu]]/[[page_nb]]</td>
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
        <table align="right" style="width: 51mm; border-radius: 2mm; border: solid 1px; border-color:#999; background:#F6F6F6;">
            <tr>
            <td style="width: 50mm; height: 7mm; text-align: center;"><span style="font-size: 12pt;">R.U.C. N° <?php echo $emp_ruc?></span></td>
            </tr>
            <tr>
            <td align="center"><span style="font-size: 12pt; font-weight: bold;">TRANSFERENCIA</span></td>
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
          <td style="width: 30mm;"><span style="font-size: 8pt;">ALMACEN ORIGEN:</span></td>
        <td><span style="font-size: 8pt;"><?php echo $alm_ori?></span></td>
        </tr>
        <tr>
          <td><span style="font-size: 8pt;">ALMACEN DESTINO:</span></td>
        <td><span style="font-size: 8pt;"><?php echo $alm_des?></span></td>
        </tr>
        <tr>
          <td><span style="font-size: 8pt;">DOCUMENTO:</span></td>
          <td><span style="font-size: 8pt;"><?php echo $doc?></span></td>
        </tr>
        </table>
    </td>
    <td style="width: 52mm; text-align:right;"><span style="font-size: 7pt;">Fecha: <?php echo $fec?></span><!--<br>Registro: <?php //echo $reg?>--></td>
  </tr>
</table>
<br>
        <table class="tablesorter">
            <thead>
                <tr>
                  <th>CAN</th>
                  <th>UNI</th>
                  <th>CODIGO</th>
                  <th>DESCRIPCION</th>
              </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
				?>
                        <tr class="even">
                            <td style="text-align: right; width: 4mm; font-size: 7pt;"><?php	echo $dt1['tb_traspasodetalle_can'];?></td>
                            <td style="text-align: left; width: 8mm; font-size: 7pt;"><?php echo $dt1['tb_unidad_abr']?></td>
                            <td style="text-align: left; width: 15mm; font-size: 7pt;"><?php echo $dt1['tb_presentacion_cod']?></td>
                            <td style="text-align: left; width: 140mm; font-size: 7pt;">
							<?php 
							echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
							echo ' | '.$dt1['tb_presentacion_nom'];
							echo ' | '.$dt1['tb_marca_nom'];
							echo ' | '.$dt1['tb_categoria_nom'];
							?></td>
                        </tr>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
          </tbody>
                <?php
				}
				?>
        </table>
        <br>
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
		//$html2pdf->pdf->IncludeJS("app.alert('a-zetasoft.com');");

		$nombre_arc='transferencia_'.$cod.'.pdf';
        $html2pdf->Output($nombre_arc);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
?>