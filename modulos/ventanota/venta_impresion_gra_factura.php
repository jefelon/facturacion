<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../ventanota/cVentanota.php");
$oVentanota = new cVentanota();
require_once ("cVentanotapago.php");
$oVentanotapago = new cVentanotapago();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();

require_once("../formula/cFormula.php");
$oFormula = new cFormula();

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
//$tipo_de_letra="arial";
//$tipo_de_letra="courier";
//$tipo_de_letra="helvetica";
//$tipo_de_letra="ArialUnicodeMS";

//$tipo_de_letra_arch="dejavusans.php";
//$tipo_de_letra_arch="arialunicid0.php";

$rs = $oFormula->consultar_dato_formula('VEN_IMP_DIR');
	$dt = mysql_fetch_array($rs);
	$imprimir_direccion = $dt['tb_formula_dat'];
	mysql_free_result($rs);

$pager_formato='format="168x215" orientation="L" style="font-size: 11pt; font-family:'.$tipo_de_letra.'"';

$pager_margen='backtop="0mm" backbottom="0mm" backleft="3mm" backright="0mm"';

//html2pdf
$orientacion_impresion='P';
$formato_impresion='A4';
$margen_array=array(10, 10, 10, 10);
//$margen_array=0;

$borde_tablas=0;

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
$dts= $oVentanota->mostrarUno($ven_id);
$dt = mysql_fetch_array($dts);
	//$reg	=mostrarFechaHora($dt['tb_venta_reg']);
	$reg	=mostrarFechaHoraH($dt['tb_venta_reg']);
	
	$fec	=mostrarFecha($dt['tb_venta_fec']);
	
	$doc_id	=$dt['tb_documento_id'];
	$doc_nom=$dt['tb_documento_nom'];
	$numdoc	=$dt['tb_venta_numdoc'];
	
	$cli_id	=$dt['tb_cliente_id'];
	$cli_nom=$dt['tb_cliente_nom'];
	$cli_doc=$dt['tb_cliente_doc'];
	$cli_dir=$dt['tb_cliente_dir'];
	
	$valven	=$dt['tb_venta_valven'];
	$igv	=$dt['tb_venta_igv'];
	$tot	=$dt['tb_venta_tot'];
	
	$lab1	=$dt['tb_venta_lab1'];
	
	$usu_id	=$dt['tb_usuario_id'];
mysql_free_result($dts);

//pagos
$rws1=$oVentanotapago->mostrar_pagos($ven_id);
$num_rows_vp= mysql_num_rows($rws1);

if($num_rows_vp>0){
	while($rw1 = mysql_fetch_array($rws1)){
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
	
		$pago_mon=formato_money($rw1['tb_ventapago_mon']);
		
		$texto_pago1[]=$forma.' '.$modo;
		$texto_pago2[]=$forma.' '.$modo.': S/.  '.$pago_mon;
	}
	mysql_free_result($rws1);
}

//vendedor
$dts=$oUsuario->mostrarUno($usu_id);
$dt = mysql_fetch_array($dts);
	$usu_nom	=$dt['tb_usuario_nom'];
	$usu_apepat	=$dt['tb_usuario_apepat'];
	$usu_apemat	=$dt['tb_usuario_apemat'];
mysql_free_result($dts);
$texto_vendedor="$usu_nom $usu_apepat $usu_apemat";
$texto_vendedor=substr($usu_nom, 0, 3).substr($usu_apepat, 0, 1).substr($usu_apemat, 0, 1);

$dts1=$oVentanota->mostrar_venta_detalle($ven_id);
$num_rows= mysql_num_rows($dts1);

$dts2=$oVentanota->mostrar_venta_detalle_servicio($ven_id);
$num_rows_2= mysql_num_rows($dts2);

$numero_filas=$num_rows+$num_rows_2;

$impresion='pdf';

/*header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=nombre_archivo.doc");
header("Pragma: no-cache");
header("Expires: 0");
*/
if($impresion=='pdf')ob_start();

?>
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
                <td style="text-align: left; width: 40mm; font-size: 10pt;">R: <?php echo $reg//date('d/m/Y'); ?></td>
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
    <td style="width: 125mm; height:40mm; vertical-align:bottom;">
        <table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0" style="width: 124mm; height:40mm; vertical-align:top;">
        <tr>
        	<td><span style="font-size: 13pt;"><?php //echo $emp_razsoc?></span></td>
        </tr>
        <tr>
        	<td><?php //echo $emp_dir?></td>
        </tr>
        <tr>
        	<td><?php //echo $emp_dir2?></td>
        </tr>
        <tr>
          	<td style="font-size: 8pt; height:5mm; vertical-align:top"><?php //if($imprimir_direccion==1)echo $emp_dir.' '.$emp_dir2?></td>
        </tr>
        </table>
	</td>
    <td style="width: 34mm; text-align:right;" valign="bottom">
        <table align="right" style="width: 34mm;">
            <tr>
            <td style="width: 33mm; height: 7mm; text-align: center;"><span style="font-size: 12pt;"><?php //echo 'R.U.C. N° '.$emp_ruc?></span></td>
            </tr>
            <tr>
            <td align="center"><span style="font-size: 12pt; font-weight: bold;"><?php //echo $doc_nom?></span></td>
            </tr>
            <tr>
            <td style="text-align: right; font-size: 10pt;"><?php echo 'N° '.$numdoc?></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="width: 100mm; vertical-align:top">
    	<table border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
        <tr>
          <td style="width: 23mm; height:6mm"><span style="font-size: 8pt;"><!--CLIENTE:--></span></td>
        <td colspan="5" style="width:125mm; font-size: 11pt;"><?php echo $cli_nom?></td>
        </tr>
        <tr>
          <td style="width: 23mm; height:6mm"><span style="font-size: 8pt;"><!--DIRECCION:--></span></td>
          <td colspan="3" style="width:105mm; height:6mm; font-size: 10pt;"><?php echo $cli_dir?></td>
          <td colspan="2" style=" text-align:right; height:6mm; width:45mm; font-size: 10pt;"><?php if($num_rows_vp==1)echo $texto_pago1[0]?></td>
          </tr>
        <tr>
          <td style="width: 23mm; height:6mm"><span style="font-size: 8pt;"><!--DOC. IDENT.:--></span></td>
        <td style="width: 15mm; font-size: 11pt;"><?php echo $cli_doc?></td>
        <td style="width: 22mm; font-size: 10pt;"><?php if($lab1!="")echo 'PLACA: '.$lab1?></td>
        <td style="width: 18mm; font-size: 10pt;"><?php echo 'VEND: '.$texto_vendedor?></td>
        <td style="width: 20mm; text-align:right; font-size: 10pt;">&nbsp;</td>
        <td style="width: 20mm; text-align:right; font-size: 10pt;"><?php echo $fec?></td>
        </tr>
        </table>
    </td>
  </tr>
</table>
<table width="100%" border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
  <tr>
    <td style="height:5mm;">&nbsp;</td>
  </tr>
  <tr>
    <td style="height:44mm; vertical-align:top">
    <table cellspacing="1" id="tabla_venta_detalle" class="tablesorter">
            <!--<thead>
                <tr>
                  <th>CANT</th>
                  <th>DESCRIPCION</th>
                  <th align="right">PRECIO UNIT</th>
                  <th align="right">VALOR VEN</th>
              </tr>
            </thead>-->
			<?php
            if($numero_filas>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
				?>
                        <tr class="even">
                          	<td style="text-align: right; width: 11mm; font-size: 11pt;"><?php echo $dt1['tb_ventadetalle_can']?></td>
                          	<td style="text-align: right; width: 5mm; font-size: 11pt;">&nbsp;</td>
                        	<td style="text-align: left; width: 115mm; font-size: 11pt;">
							<?php 
							//echo $dt1['tb_unidad_abr'].' | ';
							echo ''.$dt1['tb_producto_nom'].'';
							//echo ' | '.$dt1['tb_presentacion_nom'];
							//echo ' | '.$dt1['tb_categoria_nom'];
							//echo ' | '.$dt1['tb_marca_nom'];
							//echo ' | '.$dt1['tb_unidad_abr'];
							?></td>
                            <td style="text-align: right; width: 20mm; font-size: 11pt;"><?php echo formato_money($dt1['tb_ventadetalle_preuni'])?></td>
                            <td style="text-align: right; width: 22mm; font-size: 11pt;"><?php echo formato_money($dt1['tb_ventadetalle_valven'])?></td>
                        </tr>
                        <?php
                	}
                mysql_free_result($dts1);
                ?>
                <?php
					while($dt2 = mysql_fetch_array($dts2)){
						?>
                        <tr>
                          <td style="text-align: right; width: 11mm; font-size: 11pt;"><?php echo $dt2['tb_ventadetalle_can'];?></td>
                          <td style="text-align: right; width: 5mm; font-size: 11pt;">&nbsp;</td>
                        	<td style="text-align: left; width: 115mm; font-size: 11pt;">
							<?php 
							echo ''.$dt2['tb_servicio_nom'].'';
							//echo ' | '.$dt2['tb_categoria_nom'];?></td>
                          <td style="text-align: right; width: 20mm; font-size: 11pt;"><?php echo formato_money($dt2['tb_ventadetalle_preuni'])?></td>
                          <td style="text-align: right; width: 22mm; font-size: 11pt;"><?php echo formato_money($dt2['tb_ventadetalle_valven'])?></td>                                                        
              </tr><?php						
                	}
                mysql_free_result($dts2);
                ?>
                
          </tbody>
                <?php
				}
				?>
        </table>
    </td>
  </tr>
</table>
<?php if($numero_filas<10){?>
<br>
<?php }?>
<table border="<?php echo $borde_tablas?>" cellpadding="0" cellspacing="0" style="font-family:Arial;">
  <tr>
    <td style="text-align: right; width: 13mm; font-size: 10pt; height:5mm;">&nbsp;</td>
    <td style="text-align: left; width: 127mm; font-size: 10pt;"><?php echo numtoletras($tot)?></td>
    <td style="text-align: left; width: 15mm; font-size: 10pt;"><!--SUB TOTAL--></td>
    <td style="text-align: left; width: 2mm; font-size: 10pt;">S/.</td>
    <td style="text-align: right; width: 20mm; font-size: 11pt;"><?php echo formato_money($valven)?></td>
  </tr>
  <tr>
    <td style="height:5mm;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align: left; font-size: 10pt;"><!--IGV--></td>
    <td style="text-align: left; font-size: 10pt;">S/.</td>
    <td style="text-align: right; font-size: 11pt;"><?php echo formato_money($igv)?></td>
  </tr>
  <tr>
    <td style="height:5mm;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align: left; font-size: 10pt;"><!--TOTAL--></td>
    <td style="text-align: left; font-size: 10pt;">S/.</td>
    <td style="text-align: right; font-size: 12pt;"><?php echo formato_money($tot)?></td>
  </tr>
</table>
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
  require_once('../../libreriasphp/html2pdf-old/html2pdf.class.php');

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
		
		

		$nombre_arc='venta_'.$numdoc.'.pdf';
        $html2pdf->Output($nombre_arc);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
?>