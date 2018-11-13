<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("cVentapago.php");
$oVentapago = new cVentapago();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();

require_once("../formula/cFormula.php");
$oFormula = new cFormula();

require_once("../formatos/formato.php");
require_once("../formatos/numletras.php");

require_once ("../letras/cLetras.php");
$cLetras = new cLetras();

require_once ("../lote/cVentaDetalleLote.php");
$oVentaDetalleLote = new cVentaDetalleLote();

require_once("../guia/cGuia.php");
$oGuia = new cGuia();

$guias = $oGuia->mostrarGuiaUno($_POST['ven_id']);
$guia = mysql_fetch_array($guias);
$guia_id = $guia['tb_guia_id'];

$numguia=$guia['tb_guia_serie'].'-'.$guia["tb_guia_num"];
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

$pager_formato='format="210x215" orientation="P" style="font-size: 11pt; font-family:'.$tipo_de_letra.'"';

$pager_margen='backtop="0mm" backbottom="0mm" backright="0mm"';

//html2pdf
$orientacion_impresion='P';
$formato_impresion='A4';
$margen_array=array(10, 10, 10, 10);
//$margen_array=0;

$borde_tablas=0;

$ven_id=$_POST['ven_id'];

$dts=$oEmpresa->mostrarUno($ven_id);
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

    $moneda=$dt["cs_tipomoneda_id"];
	$valven	=$dt['tb_venta_valven'];
	$igv	=$dt['tb_venta_igv'];
	$tot	=$dt['tb_venta_tot'];

    $lab1=$dt['tb_venta_lab1'];
    $lab2=$dt['tb_venta_lab2'];
    $lab3=$dt['tb_venta_lab3'];
	
	$usu_id	=$dt['tb_usuario_id'];
mysql_free_result($dts);

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

$guias = $oGuia->mostrarGuiaUno($ven_id);
$guia = mysql_fetch_array($guias);
$guia_id = $guia['tb_guia_id'];

$serie=$guia['tb_guia_serie'];
$numero=$guia["tb_guia_num"];

//pagos
$rws1=$oVentapago->mostrar_pagos($ven_id);
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
				$modo=' DEP. OP: '.$rw1['tb_ventapago_numope'];
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
			$forma='CRED.'.$rw1['tb_ventapago_numdia'].'D';
		
			//modo
			if($rw1['tb_modopago_id']==1)
			{
				$forma='CRED. '.$rw1['tb_ventapago_numdia'].'D';
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
        if($rw1['tb_formapago_id']==3)
        {

            $forma='L.';
            $suma_pago7+=$rw1['tb_ventapago_mon'];

            $ltrs1=$cLetras->mostrar_letras($_POST['ven_id']);

            $date1 = new  DateTime($fec);

            $cont=1;
            while($ltr= mysql_fetch_array($ltrs1)){
                $date2 = new DateTime($ltr['tb_letras_fecha']);
               $interval = $date1->diff($date2 );
                $diferencia=$interval->format('%a');
                $modo.=' '.$diferencia;

            }

            //$modo.='CANJE'.$vence_letras;
//            }
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

$dts1=$oVenta->mostrar_venta_detalle($ven_id);
$num_rows= mysql_num_rows($dts1);

$dts2=$oVenta->mostrar_venta_detalle_servicio($ven_id);
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
    <style>
        .cliente tr td{
            font-size: 8pt;
        }
        .items tbody tr td{
            font-size: 8pt;
        }
        .total tr td{
            font-size: 11pt;
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
        <table style="width: 100%;" border="<?php echo $borde_tablas?>">
            <tr>
<!--                <td style="text-align: left; width: 40mm; font-size: 10pt;">R: --><?php //// echo $reg//date('d/m/Y'); ?><!--</td>-->
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
<table border="<?php echo $borde_tablas?>" class="cliente">
  <tbody>
  <tr>
    <td style="width: 17mm; height:45mm"></td>
    <td colspan="2" style="width: 100mm;"></td>
    <td style="width: 73mm;"></td>
  </tr>
  <tr>
      <td><span style=""><!--RAZON .:--></span></td>
      <td  colspan="2" style="width: 100mm;"><?php echo $cli_nom?></td>
      <td></td>
  </tr>

  <tr>
      <td><span style=""><!--DIRECCION.:--></span></td>
      <td  colspan="2" style="height:4mm;width: 100mm;"><?php echo $cli_dir?></td>
      <td>
          <table border="<?php echo $borde_tablas?>">
              <tr>
                  <td style="width: 13mm;"></td>
                  <td style="width: 20mm; text-align:center;"><?php if($num_rows_vp==1)echo $texto_pago1[0]?></td>
                  <td style="width: 15mm; text-align:center;"></td>
                  <td style="width: 16mm; text-align:right;"><?php echo $lab3 ?></td>
              </tr>
          </table>
      </td>
  </tr>
  <tr>
      <td><span style=""><!--DOC. IDENT.:--></span></td>
      <td><?php echo $cli_doc?></td>
      <td style="text-align: center"><?php echo $numguia?> </td>
      <td>
          <table border="<?php echo $borde_tablas?>">
              <tr>
                  <td style="width: 5mm;"></td>
                  <td style="width: 15mm; text-align:center;"><?php echo mostrarDiaMesAnio(1, $fec)?></td>
                  <td style="width: 20mm; text-align:center;"><?php echo mostrarDiaMesAnio(2, $fec)?></td>
                  <td style="width: 24mm; text-align:right;"><?php echo substr(mostrarDiaMesAnio(3, $fec),2)?></td>
              </tr>
          </table>
      </td>
  </tr>
  </tbody>
</table>
<table width="100%" border="<?php echo $borde_tablas?>" cellspacing="0" cellpadding="0">
  <tr>
    <td style="height:4mm;"></td>
  </tr>
  <tr>
    <td style="height:47mm; vertical-align:top">
    <table cellspacing="1" id="tabla_venta_detalle" class="tablesorter items" border="<?php echo $borde_tablas?>">
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
                            <td style="text-align: center; width: 17mm;"><?php echo $dt1['tb_presentacion_cod']?></td>
                        	<td style="text-align: left; width: 80mm;">
							<?php 
							//echo $dt1['tb_unidad_abr'].' | ';
							echo ''.$dt1['tb_ventadetalle_nom'].' - '.$dt1['tb_marca_nom'].'';
                            if ($dt1['tb_ventadetalle_serie']!=''){
                                echo ' - '.$dt1['tb_ventadetalle_serie'];
                            }
							//echo ' | '.$dt1['tb_presentacion_nom'];
							//echo ' | '.$dt1['tb_categoria_nom'];
							//echo ' | '.$dt1['tb_marca_nom'];
							//echo ' | '.$dt1['tb_unidad_abr'];
                            $html_lotes.=' - ';
                            $lotes=$oVentaDetalleLote->mostrar_filtro_venta_detalle($dt1["tb_ventadetalle_id"]);
                            while($lote = mysql_fetch_array($lotes)) {
                                $html_lotes.= 'L. '. $lote["tb_ventadetalle_lotenum"]. ' F.V. '. $lote["tb_fecha_ven"].', ';
                            }
                            ?>
                                <?php echo $html_lotes ?>
                            </td>

                            <td style="text-align: center; width: 7mm;"><?php echo $dt1['tb_unidad_abr']?></td>
                            <td style="text-align: center; width: 10mm;"><?php echo $dt1['tb_ventadetalle_can']?></td>
                            <td style="text-align: center; width: 7mm;">
                                <?php
                                if($dt1['tb_ventadetalle_preunilin']<=0){
                                    echo "SI";
                                }else{
                                    echo "NO";
                                }
                                ?>
                            </td>
                            <td style="text-align: center; width: 10mm;">
                                <?php
                                if($dt['tb_ventadetalle_des']<=0){
                                    echo "0.00";
                                }else{
                                    echo formato_money($dt['tb_ventadetalle_des']);
                                }
                                ?>
                            </td>
                            <td style="text-align: right; width: 20mm;"><?php echo formato_money($dt1['tb_ventadetalle_preunilin'])?>&nbsp;</td>
                            <td style="text-align: right; width: 23mm;"><?php echo formato_money($dt1['tb_ventadetalle_valven']*1.18)?>&nbsp;</td>
                        </tr>
                        <?php
                	}
                mysql_free_result($dts1);
                ?>
                <?php
					while($dt2 = mysql_fetch_array($dts2)){
						?>
                        <tr>
                          <td style="text-align: right; width: 5mm; font-size: 11pt;">&nbsp;</td>
                          <td style="text-align: left; width: 115mm; font-size: 11pt;">
							<?php 
							echo ''.$dt2['tb_ventadetalle_nom'].'';
							//echo ' | '.$dt2['tb_categoria_nom'];?>
                          </td>
                            <td style="text-align: center; width: 7mm;"><?php echo $dt1['tb_unidad_abr']?></td>
                            <td style="text-align: center; width: 10mm;"><?php echo $dt1['tb_ventadetalle_can']?></td>
                            <td style="text-align: center; width: 7mm;">
                                <?php
                                if($dt1['tb_ventadetalle_preunilin']<=0){
                                    echo "SI";
                                }else{
                                    echo "NO";
                                }
                                ?>
                            </td>
                            <td style="text-align: center; width: 10mm;">
                                <?php
                                if($dt['tb_ventadetalle_des']<=0){
                                    echo "0.00";
                                }else{
                                    echo formato_money($dt['tb_ventadetalle_des']);
                                }
                                ?>
                            </td>
                            <td style="text-align: right; width: 20mm;"><?php echo formato_money($dt1['tb_ventadetalle_preunilin'])?>&nbsp;</td>
                            <td style="text-align: right; width: 23mm;"><?php echo formato_money($dt1['tb_ventadetalle_valven']*1.18)?>&nbsp;</td>
                        </tr>
                        <?php
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
<table border="<?php echo $borde_tablas?>" cellpadding="0" cellspacing="0" style="font-family:Arial;" class="total">
  <tr>
    <td style="text-align: right; width: 13mm; height:4mm;">&nbsp;</td>
    <td  valign="bottom" style="text-align: left; width: 140mm;"><?php echo numtoletras($tot,$monedaval)?></td>
    <td style="text-align: left; width: 10mm;"><!--SUB TOTAL--></td>
    <td style="text-align: right; width: 5mm;"><?php echo $mon?></td>
    <td style="text-align: right; width: 20mm;"><?php echo formato_money($valven)?>&nbsp;</td>
  </tr>
  <tr>
    <td style="height:5mm;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align: right;">18%<!--IGV--></td>
    <td style="text-align: right;"><?php echo $mon?></td>
    <td style="text-align: right;"><?php echo formato_money($igv)?>&nbsp;</td>
  </tr>
  <tr>
    <td style="height:5mm;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align: left;"><!--TOTAL--></td>
    <td style="text-align: right;"><?php echo $mon?></td>
    <td style="text-align: right;"><?php echo formato_money($tot)?>&nbsp;</td>
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



		$nombre_arc='venta_'.$numdoc.'.pdf';
        $html2pdf->Output($nombre_arc);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
?>