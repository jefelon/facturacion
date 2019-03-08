<?php
session_start();
if ($_SESSION["autentificado"] != "SI") {
    if ($_SESSION["autentificado2"] == "SI") {

    }
    else{
        header("location: ../../index.php");
        exit();
    }
}
require_once ("../../config/Cado.php");
require_once ("../../config/datos.php");
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
//$tipo_de_letra="Consolas";

//$tipo_de_letra_arch="dejavusans.php";
//$tipo_de_letra_arch="arialunicid0.php";

$rs = $oFormula->consultar_dato_formula('VEN_IMP_DIR');
  $dt = mysql_fetch_array($rs);
  $imprimir_direccion = $dt['tb_formula_dat'];
  mysql_free_result($rs);

$pager_formato='format="350x90" orientation="P" style="font-size: 9pt; font-family:'.$tipo_de_letra.'"';

$pager_margen='backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm"';

//html2pdf
$orientacion_impresion='P';
$formato_impresion='A4';
$margen_array=array(2, 2, 2, 2);
//$margen_array=1;

$borde_tablas=0;

$ven_id=$_POST['ven_id'];

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
  $empresa_logo = '../empresa/'.$dt['tb_empresa_logo'];
mysql_free_result($dts);

if($emp_tel!="")$texto_telefono='Teléfono: '.$emp_tel;
if($emp_ema!="")$texto_email='Correo: '.$emp_ema;
if($emp_ruc==0)$emp_ruc="";
//venta

$ven_id=$_POST['ven_id'];

$dts= $oVenta->mostrarUno($ven_id);
$dt = mysql_fetch_array($dts);
  //$reg  =mostrarFechaHora($dt['tb_venta_reg']);
  $reg  =mostrarFechaHoraH($dt['tb_venta_reg']);
  $hora = mostrarHora($dt['tb_venta_reg']);
  
  $fec  =mostrarFecha($dt['tb_venta_fec']);
  
  $doc_id =$dt['tb_documento_id'];
  $doc_nom=$dt['tb_documento_nom'];
  $numdoc =$dt['tb_venta_numdoc'];
  
  $cli_id =$dt['tb_cliente_id'];
  $cli_nom=$dt['tb_cliente_nom'];
  $cli_doc=$dt['tb_cliente_doc'];
  $cli_dir=$dt['tb_cliente_dir'];
  $cui = $dt['tb_cliente_cui'];
  
  $valven =$dt['tb_venta_valven'];
  $igv  =$dt['tb_venta_igv'];
  $tot  =$dt['tb_venta_tot'];
  
  $lab1 =$dt['tb_venta_lab1'];
  
  $usu_id =$dt['tb_usuario_id'];
mysql_free_result($dts);


$dts= $oVenta->mostrarUno($ven_id);
while($dt = mysql_fetch_array($dts))
{
    $idcomprobante=$dt["cs_tipodocumento_cod"];

    $serie=$dt["tb_venta_ser"];
    $numero=$dt["tb_venta_num"];

    $ruc=$dt["tb_cliente_doc"];
    $razon=$dt["tb_cliente_nom"];
    $direccion=$dt["tb_cliente_dir"];
    if($dt["tb_cliente_tip"]==1)$idtipodni=1;
    if($dt["tb_cliente_tip"]==2)$idtipodni=6;

    $fecha=mostrarFecha($dt["tb_venta_fec"]);

    $toigv=$dt["tb_venta_igv"];
    $importetotal=$dt["tb_venta_tot"];
    $totopgrat=$dt["tb_venta_grat"];
    $subtotal=$dt["tb_venta_gra"];
    $valorventa=$dt["tb_venta_valven"];
    $toisc="0.00";
    $totdes=$dt["tb_venta_des"];
    $totanti="0.00";
    $moneda=1;


    $estsun=$dt['tb_venta_estsun'];
      $fecenvsun=mostrarFechaHora($dt['tb_venta_fecenvsun']);
      $faucod=$dt['tb_venta_faucod'];
      $digval=$dt['tb_venta_digval'];
      $sigval=$dt['tb_venta_sigval'];
      $val=$dt['tb_venta_val'];

    $estado=$dt['tb_venta_est'];

    $lab1=$dt['tb_venta_lab1'];
    $lab2=$dt['tb_venta_lab2'];
    $lab3=$dt['tb_venta_lab3'];
    $pun_nom = $dt['tb_puntoventa_nom'];
}

$vvs = $oVenta->mostrar_viajeventa($ven_id);
$vv = mysql_fetch_array($vvs);

$evs = $oVenta->mostrar_encomienda_viaje($ven_id);
$ev = mysql_fetch_array($evs);
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
  $usu_nom  =$dt['tb_usuario_nom'];
  $usu_apepat =$dt['tb_usuario_apepat'];
  $usu_apemat =$dt['tb_usuario_apemat'];
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
    .centrado{
      text-align: center;
    }
    .izquierda{
      text-align: left;
    }
    .derecha{
      text-align: right;
    }
    tr.bordetop{border-top: 0.8px solid #000}

    th, td {

      padding: 0px;
      white-space: pre; /* CSS 2.0 */
      white-space: pre-wrap; /* CSS 2.1 */
      white-space: pre-line; /* CSS 3.0 */
      white-space: -pre-wrap; /* Opera 4-6 */
      white-space: -o-pre-wrap; /* Opera 7 */
      white-space: -moz-pre-wrap; /* Mozilla */
      white-space: -hp-pre-wrap; /* HP */
      word-wrap: break-word; /* IE 5+ */
      }

      .negrita {
        font-weight:bold;
      }

      .py-5{
        padding-top: 2.5mm;
        padding-bottom: 2.5mm;
      }
      .pt-5{
        padding-top: 2.5mm;
      }

</style>

<page id="contenido_pdf" <?php echo $pager_formato?> <?php echo $pager_margen?>>
<link rel="stylesheet" href="../../css/Estilo/documento_venta.css" type="text/css" media="print, projection, screen" />
<?php if($impresion=='pdf' or $impresion=='html'){?>
 
<table width="80mm">
    <thead>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </thead>
    <tr>
        <td colspan="4" class="centrado">
            <?php //echo //'<h3>'.$emp_nomcom .'</h3>'?>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="centrado negrita" style="font-size: 15px;">
            <?php echo $emp_razsoc ?>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="centrado negrita">
            RUC: <?php echo $emp_ruc ?>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="centrado">
            <?php if ($imprimir_direccion == 1) echo $emp_dir . ' - ' . $emp_tel . ' ' . $emp_dir2 ?>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="centrado">
            SUC: <?php echo $pun_nom ?>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="centrado"></td>
    </tr>
    <tr>
        <td colspan="4" height="10mm">
            .............................................................................................
        </td>
    </tr>
    <tr>
        <td colspan="4" class="centrado negrita py-5">FACTURA DE VENTA ELECTRÓNICA</td>
    </tr>
    <tr>
        <td colspan="2"><?php echo 'Nro. Factura: ' .$serie . ' - ' . $numero ?></td>
        <td colspan="2"><?php echo ' Fecha: ' . $fec ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="2"><?php echo ' Hora: ' . $hora ?></td>
    </tr>
    <tr>
        <td colspan="4" height="10mm">
            .............................................................................................
        </td>
    </tr>
    <tr>
        <td colspan="4"> <?php echo 'CLIENTE: ' .$razon ?></td>
    </tr>
    <tr>
        <td colspan="4"> <?php echo 'RUC: ' .$ruc ?></td>
    </tr>
    <tr>
        <td colspan="4"> <?php echo 'DIRECCIÓN: ' .$direccion ?></td>
    </tr>
    <tr>
        <td colspan="4"> <?php echo 'REMITENTE: ' . $ev['crtb_cliente'] ?></td>
    </tr>
    <tr>
        <td colspan="4"> <?php echo 'DESTINATARIO: ' . $ev['cdtb_cliente'] ?></td>
    </tr>
    <tr>
        <td colspan="4"> <?php echo 'ORIGEN: ' . $ev['ltb_origen'] ?></td>
    </tr>
    <tr>
        <td colspan="4"> <?php echo 'DESTINO: ' . $ev['ltb_destino'] ?></td>
    </tr>
    <tr>
        <td colspan="4" height="10mm">
            .............................................................................................
        </td>
    </tr>
<tr>
    <td colspan="4">
        <table width="80mm">
          <thead>
            <tr>
                <td style="width: 10mm" class="izquierda negrita">CANT</td>
                <td style="width: 30mm" class="izquierda negrita" >DESCRIPCION</td>
                <td style="width: 20mm" class="derecha negrita">P. UNIT</td>
                <td style="width: 20mm" class="derecha negrita">IMPORTE</td>
            </tr>
          </thead>
          <?php  if($numero_filas>=1){ ?>
          <?php while($dt1 = mysql_fetch_array($dts1)){ ?>
            <tr>
              <td class="izquierda" style="width: 10mm"><?php echo $dt1["tb_ventadetalle_can"] ?></td>
              <td class="izquierda" style="width: 30mm"><?php echo $dt1['tb_producto_nom']?></td>
              <td class="derecha" style="width: 20mm"><?php echo formato_money($dt1['tb_ventadetalle_preun'])?></td>
              <td class="derecha" style="width: 20mm"><?php echo formato_money($dt1['tb_ventadetalle_preun']*$dt1['tb_ventadetalle_can'])?></td>
            </tr>

          <?php } mysql_free_result($dts1);?>
          <?php } ?>

          <?php while($dt2 = mysql_fetch_array($dts2)){ ?>
            <tr>
                <td class="izquierda"
                    style="width: 10mm"><?php echo $dt2["tb_ventadetalle_can"] ?></td>
              <td class="izquierda" style="width: 30mm"><?php echo ''.$dt2['tb_servicio_nom'].'';?></td>
              <td class="derecha" style="width: 20mm"><?php echo formato_money($dt2['tb_ventadetalle_preuni'])?></td>
              <td class="derecha" style="width: 20mm"><?php echo formato_money($dt2['tb_ventadetalle_preuni']*$dt2['tb_ventadetalle_can'])?></td>
            </tr>
            <?php  } mysql_free_result($dts2); ?>
          </table>
    </td>
</tr>

<tr>
  <td colspan="4">
    <table  width="80mm">
      <thead>
        <tr>
          <td style="width: 20mm"></td>
          <td style="width: 20mm"></td>
          <td style="width:20mm"></td>
          <td style="width: 20mm"></td>
        </tr>
      </thead>
      <tbody>
      <tr>
          <td colspan="2" class="izquierda mt-5 negrita">OP. GRAVADA:</td>
          <td colspan="2" class="derecha" style="text-align: right;">
              S/ <?php echo formato_money($valven) ?></td>
      </tr>
      <tr>
          <td colspan="2" class="izquierda negrita">OP. EXONERADA:</td>
          <td colspan="2" class="derecha" style="text-align: right;">
              S/ <?php echo formato_money($exo) ?></td>
      </tr>
      <tr>
          <td colspan="2" class="izquierda negrita">IGV:</td>
          <td colspan="2" class="derecha" style="text-align: right;">
              S/ <?php echo formato_money($igv) ?></td>
      </tr>
      <tr>
          <td colspan="2" class="izquierda negrita">TOTAL A PAGAR:</td>
          <td colspan="2" class="derecha" style="text-align: right;">
              S/ <?php echo formato_money($tot) ?></td>
      </tr>
      <tr>
          <td colspan="4" class="izquierda pt-5">SON: <?php echo numtoletras($tot)?></td>
      </tr>
        <tr>
          <td colspan="4" class="centrado py-5" ><?php echo $digval ?></td>
        </tr>
        <tr>
          <td colspan="4" class="centrado"><qrcode value="<?php echo $ruc_empresa.'|'.$idcomprobante.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.mostrarfecha($fecha).'|'.$idtipodni.'|'.$ruc.'|' ?>" ec="L" style="width: 20mm;"></qrcode></td>
        </tr>
        <tr>
          <td colspan="4" style="width: 80mm" class="centrado">Representación impresa de la  Factura  de Venta  Electrónica,  esta puede ser
        consultada en: <br><?php echo $d_documentos_app ?></td>
        </tr>
        <tr>
            <td colspan="4" height="10mm">
                .............................................................................................
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width: 80mm;" class="centrado negrita">Todo reclamo es realizado dentro los días
                hábiles.</td>
        </tr>
      </tbody>
    </table>
  </td>
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