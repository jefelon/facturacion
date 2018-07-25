<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("cVentanota.php");
$oVenta = new cVenta();

require_once("../formatos/formato.php");
require_once("../formatos/numletras.php");

$formato_impresion=$_POST['rad_formato'];

if($formato_impresion=='A4')
{
	$parametro_impresion='style="font-size: 10pt"  backtop="5mm" backbottom="5mm" backleft="4mm" backright="4mm"';
	$orientacion_impresion='P';
	$margen_array=array(15, 10, 15, 10);
}

if($formato_impresion=='A5')
{
	$parametro_impresion='style="font-size: 10pt"  backtop="5mm" backbottom="5mm" backleft="4mm" backright="4mm"';
	$orientacion_impresion='L';
	$margen_array=array(15, 10, 15, 10);
}

if($formato_impresion=='A6')
{
	$parametro_impresion='style="font-size: 8pt"  backtop="2mm" backbottom="2mm" backleft="1mm" backright="1mm"';
	$orientacion_impresion='L';
	$margen_array=array(8, 5, 8, 5);
}

$ven_id=$_POST['ven_id'];

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
//venta
$dts= $oVenta->mostrarUno($ven_id);
$dt = mysql_fetch_array($dts);
	$reg	=mostrarFechaHora($dt['tb_venta_reg']);
	$fec	=mostrarFecha($dt['tb_venta_fec']);
	
	$doc_id	=$dt['tb_documento_id'];
	$doc_nom=$dt['tb_documento_nom'];
	$numdoc	=$dt['tb_venta_numdoc'];
	
	$cli_id	=$dt['tb_cliente_id'];
	$cli_nom=$dt['tb_cliente_nom'];
	$cli_doc=$dt['tb_cliente_doc'];
	$cli_dir=$dt['tb_cliente_dir'];
	
	$subtot	=$dt['tb_venta_subtot'];
	$igv	=$dt['tb_venta_igv'];
	$tot	=$dt['tb_venta_tot'];
mysql_free_result($dts);


$dts1=$oVenta->mostrar_venta_detalle($ven_id);
$num_rows= mysql_num_rows($dts1);

$impresion='pdf';

if($impresion=='pdf')ob_start();

?>
<page id="contenido_pdf" <?php echo $parametro_impresion?>>
<link rel="stylesheet" href="../../css/Estilo/documento.css" type="text/css" media="print, projection, screen" />
<?php if($impresion=='pdf'){?>
    <page_header>
        <?php /*?><table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: left;    width: 33%"></td>
                <td style="text-align: center;    width: 34%"></td>
                <td style="text-align: right;    width: 33%"><?php //echo date('d/m/Y'); ?></td>
            </tr>
        </table><?php */?>
    </page_header>
    <page_footer>
        <table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: left; width: 35%; font-size: 7pt;">Registro: <?php echo $reg//date('d/m/Y'); ?></td>
                <td style="text-align: center; width: 30%; font-size: 6pt;">Sistema de Ventas. www.a-zetasoft.com</td>
                <td style="text-align: right;    width: 35%; font-size: 7pt;">Página [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
<?php }?>
<?php
if($formato_impresion=='A4' or $formato_impresion=='A5')
{
?>
<table>
  <tr>
    <td style="width: 118mm; vertical-align:top">
        <table width="450px" border="0" cellspacing="0" cellpadding="0">
        <tr>
        	<td><span style="font-size: 13pt;"><?php echo $emp_razsoc?></span></td>
        </tr>
        <tr>
        	<td><?php echo $emp_dir?></td>
        </tr>
        <tr>
        	<td><?php echo $emp_dir2?></td>
        </tr>
        <tr>
          	<td><span style="font-size: 8pt;"><?php echo $texto_telefono.' '.$texto_email?></span></td>
        </tr>
        </table>
	</td>
    <td style="width: 52mm; text-align:right;">
        <table align="right" style="width: 51mm; border-radius: 2mm; border: solid 1px; border-color:#999; background:#F6F6F6;">
            <tr>
            <td style="width: 50mm; height: 7mm; text-align: center;"><span style="font-size: 12pt;">R.U.C. N° <?php echo $emp_ruc?></span></td>
            </tr>
            <tr>
            <td align="center"><span style="font-size: 12pt; font-weight: bold;"><?php echo $doc_nom?></span></td>
            </tr>
            <tr>
            <td align="center"><span style="font-size: 12pt;">N° <?php echo $numdoc?></span></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td style="width: 118mm; vertical-align:top">
    	<table width="450px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="width: 23mm;"><span style="font-size: 8pt;">CLIENTE:</span></td>
        <td><span style="font-size: 8pt;"><?php echo $cli_nom?></span></td>
        </tr>
        <tr>
          <td><span style="font-size: 8pt;">DIRECCION:</span></td>
        <td><span style="font-size: 8pt;"><?php echo $cli_dir?></span></td>
        </tr>
        <tr>
          <td><span style="font-size: 8pt;">DOC. IDENT.:</span></td>
        <td><span style="font-size: 8pt;"><?php echo $cli_doc?></span></td>
        </tr>
        </table>
    </td>
    <td style="width: 52mm; text-align:right;"><span style="font-size: 7pt;">Fecha: <?php echo $fec?></span><!--<br>Registro: <?php //echo $reg?>--></td>
  </tr>
</table>
<br>
        <table cellspacing="1" id="tabla_venta_detalle" class="tablesorter">
            <thead>
                <tr>
                  <th width="39">CANTIDAD</th>
                  <th width="50">UNIDAD</th>
                  <th width="340">DESCRIPCION</th>
                  <th width="60" align="right">PRECIO UNIT</th>
                  <th width="60" align="right">IMPORTE</th>
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
                          <td><?php 
							echo $dt1['tb_ventadetalle_can'];
							?></td>
                        <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                            <td>
							<?php 
							echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
							echo ' - '.$dt1['tb_presentacion_nom'];
							//echo $dt1['tb_categoria_nom'];
							echo ' - '.$dt1['tb_marca_nom'];
							?></td>
                            <td align="right"><?php echo $dt1['tb_ventadetalle_pre']?></td>
                            <td align="right"><?php echo $dt1['tb_ventadetalle_imp']?></td>
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
<div>
<table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td width="420">&nbsp;</td>
    <td width="90"><span style="font-size: 9pt;">SUB TOTAL</span></td>
    <td width="10"><span style="font-size: 9pt;">S/.</span></td>
    <td width="110" align="right"><span style="font-size: 9pt;"><?php echo formato_money($subtot)?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span style="font-size: 9pt;">IGV</span></td>
    <td><span style="font-size: 9pt;">S/.</span></td>
    <td align="right"><span style="font-size: 9pt;"><?php echo formato_money($igv)?></span></td>
  </tr>
  <tr>
    <td valign="bottom"><span style="font-size: 7pt;">SON: <?php echo numtoletras($tot)?></span></td>
    <td height="20" valign="bottom"><span style="font-size: 9pt; font-weight: bold;">TOTAL</span></td>
    <td valign="bottom"><span style="font-size: 9pt; font-weight: bold;">S/.</span></td>
    <td align="right" valign="bottom"><span style="font-size: 9pt; font-weight: bold;"><?php echo formato_money($tot)?></span></td>
  </tr>
</table>
</div>
<?php 
}
if($formato_impresion=='A6')
{
?>
<table>
  <tr>
    <td style="width: 76mm; vertical-align:top">
        <table width="350px" border="0" cellspacing="0" cellpadding="0">
        <tr>
        	<td><span style="font-size: 13pt;"><?php echo $emp_razsoc?></span></td>
        </tr>
        <tr>
        	<td><?php echo $emp_dir?></td>
        </tr>
        <tr>
        	<td><?php echo $emp_dir2?></td>
        </tr>
        <tr>
          	<td><span style="font-size: 8pt;"><?php echo $texto_telefono.' '.$texto_email?></span></td>
        </tr>
        </table>
	</td>
    <td style="width: 50mm; text-align:right;">
        <table align="right" style="width: 51mm; border-radius: 2mm; border: solid 1px; border-color:#999; background:#F6F6F6;">
            <tr>
            <td style="width: 50mm; height: 7mm; text-align: center;"><span style="font-size: 12pt;">R.U.C. N° <?php echo $emp_ruc?></span></td>
            </tr>
            <tr>
            <td align="center"><span style="font-size: 12pt; font-weight: bold;"><?php echo $doc_nom?></span></td>
            </tr>
            <tr>
            <td align="center"><span style="font-size: 12pt;">N° <?php echo $numdoc?></span></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td style="vertical-align:top">
    	<table width="330px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="width: 18mm;"><span style="font-size: 8pt;">CLIENTE:</span></td>
        <td><span style="font-size: 8pt;"><?php echo $cli_nom?></span></td>
        </tr>
        <tr>
          <td><span style="font-size: 8pt;">DIRECCION:</span></td>
        <td><span style="font-size: 8pt;"><?php echo $cli_dir?></span></td>
        </tr>
        <tr>
          <td><span style="font-size: 8pt;">DOC. IDENT.:</span></td>
        <td><span style="font-size: 8pt;"><?php echo $cli_doc?></span></td>
        </tr>
        </table>
    </td>
    <td style="text-align:right;"><span style="font-size: 7pt;">Fecha: <?php echo $fec?></span><!--<br>Registro: <?php //echo $reg?>--></td>
  </tr>
</table>
<br>
        <table cellspacing="1" id="tabla_venta_detalle" class="tablesorter">
            <thead>
                <tr>
                  <th width="15">CANT</th>
                  <th width="40">UNIDAD</th>
                  <th width="240">DESCRIPCION</th>
                  <th width="57" align="right">PRECIO UN.</th>
                  <th width="40" align="right">IMPORTE</th>
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
                          <td><?php 
							echo $dt1['tb_ventadetalle_can'];
							?></td>
                        <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                            <td>
							<?php 
							echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
							echo ' - '.$dt1['tb_presentacion_nom'];
							//echo $dt1['tb_categoria_nom'];
							echo ' - '.substr($dt1['tb_marca_nom'], 0, 10);
							?></td>
                            <td align="right"><?php echo $dt1['tb_ventadetalle_pre']?></td>
                            <td align="right"><?php echo $dt1['tb_ventadetalle_imp']?></td>
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
<div>
<table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td width="345">&nbsp;</td>
    <td width="65"><span style="font-size: 8pt;">SUB TOTAL</span></td>
    <td width="10"><span style="font-size: 8pt;">S/.</span></td>
    <td width="50" align="right"><span style="font-size: 8pt;"><?php echo formato_money($subtot)?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span style="font-size: 8pt;">IGV</span></td>
    <td><span style="font-size: 8pt;">S/.</span></td>
    <td align="right"><span style="font-size: 8pt;"><?php echo formato_money($igv)?></span></td>
  </tr>
  <tr>
    <td valign="bottom"><span style="font-size: 7pt;">SON: <?php echo numtoletras($tot)?></span></td>
    <td height="20" valign="bottom"><span style="font-size: 8pt; font-weight: bold;">TOTAL</span></td>
    <td valign="bottom"><span style="font-size: 8pt; font-weight: bold;">S/.</span></td>
    <td align="right" valign="bottom"><span style="font-size: 8pt; font-weight: bold;"><?php echo formato_money($tot)?></span></td>
  </tr>
</table>
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
	require_once('../../libreriasphp/html2pdf/html2pdf.class.php');

    try
    {
        $html2pdf = new HTML2PDF($orientacion_impresion, $formato_impresion, 'es', true, 'UTF-8', $margen_array);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		//$html2pdf->pdf->IncludeJS("print(true);");
		//$html2pdf->pdf->IncludeJS("app.alert('a-zetasoft.com');");

		$nombre_arc='venta_'.$numdoc.'.pdf';
        $html2pdf->Output($nombre_arc);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
?>