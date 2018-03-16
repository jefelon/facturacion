<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<style type="text/css">
    body {
        background-color: transparent;
        color: black;
        font-family: Consolas, monaco, monospace;
        margin: 0px;
        padding-top: 0px;
        font-size: .6em;
    }
    .header_row th {
        /*background-color: transparent;*/
        border-bottom: 0.9px solid #ddd;
        border-right: 0.9px solid #ddd;
        border-left: 0.9px solid #ddd;
        /*padding-top: 20px;
        padding-bottom: 5px;*/
        height: 30px;
    }
    .odd_row td {
        background-color: transparent;
        border-bottom: 0.9px solid #ddd;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .even_row td {
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: #f6f6f6;
        border-bottom: 0.9px solid #ddd;
    }
    .row td{
        border-right: 0.9px solid #ddd;
        border-left: 0.9px solid #ddd;
    }
</style>

<style media="print">
    .oculto{
        display: none;
    }

</style>

<?php
//onload="window.print()"
    require_once ("../../config/Cado.php");
    require_once ("../venta/cVenta.php");
    $oVenta = new cVenta();
    require_once ("../formatos/numletras.php");
    require_once ("../formatos/formato.php");

    $id = "11118";
    $tipdoc = "1";//1 FACTURA
    $tipdoccli = "6";//1 DNI | 6 RUC

    $dts = $oVenta->mostrarUno($id);
    while($dt = mysql_fetch_array($dts)){
        $serie=$dt["tb_venta_ser"];
        $numero=$dt["tb_venta_num"];

        $ruc=$dt["tb_cliente_doc"];
        $razon=$dt["tb_cliente_nom"];
        $direccion=$dt["tb_cliente_dir"];
        $fecha=mostrarFecha($dt["tb_venta_fec"]);

        $toigv=$dt["tb_venta_igv"];
        $importetotal=$dt["tb_venta_tot"];
        $totopgrat="0.00";
        $subtotal=$dt["tb_venta_valven"];
        $valorventa=$subtotal;
        $toisc="0.00";
        $totdes=$dt["tb_venta_des"];
        $totanti="0.00";
        $moneda=1;
    }

    $estado = "1";
    $razon_defecto = "IMPORTACIONES Y DISTRIBUCIONES GRANADOS SRL";
    $direccion_defecto = "AV. AUGUSTO B. LEGUIA 1160 URB. SAN LORENZO";
    $direccion_defecto .= "<br/>" . "LAMBAYEQUE - JOSE LEONARDO ORTIZ - JOSE LEONARDO ORTIZ";
    $ruc_empresa = "20479676861";
    //$serie = "E001";//-------
    //$numero = "82";//--------
    if($moneda==1){
        $moneda  = "SOLES";
        $mon = "S/ ";
    }else{
        $moneda  = "DOLARES";
        $mon = "US$ ";
    }
    
?>

<table style="width: 100%; margin-bottom: 10px">
    <?php
    
        if($estado=="0"){
        echo '<tr>
            <td width="50%"></td>
            <td width="10%"></td>
            <td td width="40%" style="text-align: center"><strong>ANULADO</strong></td>
            </tr>';
        }
    ?>
    <tr>
        <td style="text-align: left" width="50%">
            <strong style="font-size: 14px"><?php echo $razon_defecto; ?></strong><br>
            <?php echo $direccion_defecto; ?>
        </td>
        <td style="text-align: left" width="10%"><input type="button" name="btnPrint" value="Imprimir" class="oculto" onClick="window.print()"></td>

        <td style="text-align: center;border:1px;border-style:solid;" width="40%">
            <strong style="font-size: 14px">FACTURA ELECTRONICA<br>
            RUC: <?php echo $ruc_empresa; ?><br>
            <?php echo $serie; ?>-<?php echo $numero; ?></strong>
        </td>
    </tr>
</table>
<table style="width: 100%; padding-top: 10px;padding-bottom: 10px;">
    <tr>
        <td style="text-align: left" width="10%">SEÑOR(ES)</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="59%"><?php echo $razon; ?></td>

        <td style="text-align: left" width="10%">FECHA</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="19%"><?php echo $fecha; ?></td>
    </tr>
    <tr>
        <td style="text-align: left" width="10%">RUC</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="59%"><?php echo $ruc; ?></td>

        <td style="text-align: left" width="10%">MONEDA</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="19%"><?php echo $moneda; ?></td>
    </tr>
    <tr>
        <td style="text-align: left" width="10%">DIRECCIÓN</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="59%"><?php echo $direccion; ?></td>

        <?php /*<td style="text-align: left" width="10%">GUIA</td>
        <td style="text-align: left" width="1%">:</td>
        <td style="text-align: left" width="19%"></td>*/ ?>
    </tr>
</table>
<table style="width: 100%; border-top: 0.9px solid #eeeeee; padding-top: 10px; border-collapse:collapse;">
    <tbody style="border-bottom: 0.9px solid #eeeeee">
        <tr class="header_row">
            <th style="text-align: center;">Ítem</th>
            <?php /*<th style="text-align: center;">Código</th>*/ ?>
            <th style="text-align: center; width: 350px;">Descripción</th>
            <th style="text-align: center">Unidad</th>
            <th style="text-align: center">Cantidad</th>
            <th style="text-align: center">Valor Unitario</th>
            <th style="text-align: center">Precio Unitario</th>
            <th style="text-align: center">Descuento</th>
            <th style="text-align: center">Valor Total</th>
        </tr>
        <?php
            $dts = $oVenta->mostrar_venta_detalle_ps($id);
            $cont = 1;
            while($dt = mysql_fetch_array($dts)){
                $codigo = $cont;
                
        ?>
            <tr class="row">
            <?php if($dt["tb_ventadetalle_tipven"]==1){ ?>
                <td style="text-align: left"><?php echo $cont; ?></td>
                <?php /*<td style="text-align: left"><?php echo "P".str_pad($dt["tb_catalogo_id"], 4, "0", STR_PAD_LEFT); ?></td>*/ ?>
                <td style="text-align: left"><?php echo $dt["tb_producto_nom"]; ?></td>
                <td style="text-align: center">UNIDAD</td>
                <td style="text-align: right"><?php echo $dt["tb_ventadetalle_can"]; ?></td>
                <td style="text-align: right"><?php echo $dt["tb_ventadetalle_preuni"]; ?></td>
                <td style="text-align: right"><?php echo ($dt["tb_ventadetalle_valven"]+$dt["tb_ventadetalle_igv"])/$dt["tb_ventadetalle_can"]; ?></td>
                <td style="text-align: right"><?php echo $dt["tb_ventadetalle_des"]; ?></td>
                <td style="text-align: right"><?php echo $dt["tb_ventadetalle_valven"]; ?></td>
            <?php }else{ ?>
                <td style="text-align: left"><?php echo $cont; ?></td>
                <?php /*<td style="text-align: left"><?php echo "S".str_pad($dt["tb_servicio_id"], 4, "0", STR_PAD_LEFT); ?></td>*/ ?>
                <td style="text-align: left"><?php echo $dt["tb_servicio_nom"]; ?></td>
                <td style="text-align: center">UNIDAD</td>
                <td style="text-align: right"><?php echo $dt["tb_ventadetalle_can"]; ?></td>
                <td style="text-align: right"><?php echo $dt["tb_ventadetalle_preuni"]; ?></td>
                <td style="text-align: right"><?php echo ($dt["tb_ventadetalle_valven"]+$dt["tb_ventadetalle_igv"])/$dt["tb_ventadetalle_can"]; ?></td>
                <td style="text-align: right"><?php echo $dt["tb_ventadetalle_des"]; ?></td>
                <td style="text-align: right"><?php echo $dt["tb_ventadetalle_valven"]; ?></td>
            <?php } ?>
            </tr>
        <?php $cont++;} ?>
    </tbody>
</table>
<table style="width: 100%">
    <tr>
        <td style="text-align: left;" colspan="3">Observacion:</td>
    </tr>
    <?php if($totopgrat > 0){ ?>
    <tr>
        <td width="90%" style="text-align: right;" colspan="2">Vtas. Gratuitas: </td>
        <td width="10%" style="text-align: right;"><?php echo $mon . $totopgrat; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td width="90%" style="text-align: right;" colspan="2">Sub Total: </td>
        <td width="10%" style="text-align: right;"><?php echo $mon . $subtotal; ?></td>
    </tr>
    <?php if($totanti > 0){ ?>
        <tr>
            <td width="90%" style="text-align: right;" colspan="2">Anticipos: </td>
            <td width="10%" style="text-align: right;"><?php echo $mon . $totanti; ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td width="90%" style="text-align: right;" colspan="2">Descuentos: </td>
        <td width="10%" style="text-align: right;"><?php echo $mon . $totdes; ?></td>
    </tr>
    <tr>
        <td width="90%" style="text-align: right;" colspan="2">Valor Venta: </td>
        <td width="10%" style="text-align: right;"><?php echo $mon . $valorventa; ?></td>
    </tr>
    <tr>
        <td width="90%" style="text-align: right;" colspan="2">ISC: </td>
        <td width="10%" style="text-align: right;"><?php echo $mon . $toisc; ?></td>
    </tr>
    <tr>
        <td  width="90%" style="text-align: right;" colspan="2">IGV: </td>
        <td width="10%" style="text-align: right;"><?php echo $mon . $toigv; ?></td>
    </tr>
        <tr>
            <td width="70%" style="text-align: left;"><?php if($importetotal>0){echo "SON: " . numtoletras($importetotal);}else{echo "Leyenda TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE";}?></td>
            <td width="20%" style="text-align: right;">Importe Total: </td>
            <td width="10%" style="text-align: right;"><?php echo $mon . $importetotal; ?></td>
        </tr>

</table>
<div align="center" style="margin: 1cm 1cm 0.5cm 1cm ">
<?php 
    //echo '<img src="barcode.php?code='.$ruc_empresa.'|'.$tipdoc.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$tipdoccli.'|'.$ruc.'|'.$digestvalue.'|'.$signaturevalue.'|" alt="" style="width: 6cm; height: 2cm; image-rendering: pixelated;"/>';
    $params = array(
    array('data',$ruc_empresa.'|'.$tipdoc.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$tipdoccli.'|'.$ruc.'|'.$digestvalue.'|'.$signaturevalue.'|'),array('compaction',4),array('modwidth',1),
    array('info',false),array('columns',8),array('errlevel',5),
    array('showtext',false),array('height',3),
    array('showframe',false),array('truncated',false),
    array('vertical',false) ,
    array('backend','IMAGE'), array('file',''),
    array('scale',2), array('pswidth','') );

    $n=count($params);
    $s='';
    for($i=0; $i < $n; ++$i ) {
        $v  = $params[$i][0];
        if( empty($_GET[$params[$i][0]]) ) {
            $$v = $params[$i][1];
        }
        else
            $$v = $_GET[$params[$i][0]];
        $s .= $v.'='.urlencode($$v).'&';
    }
    echo "<img src=\"generate.php?$s\" name=barcode style=\"width: 6cm; height: 2cm; image-rendering: pixelated;\">";
    //echo '<br/>'.$ruc_empresa.'|'.$tipdoc.'|'.$serie.'|'.$numero.'|'.$toigv.'|'.$importetotal.'|'.fecha_mysql($fecha).'|'.$tipdoccli.'|'.$ruc.'|'.$digestvalue.'|'.$signaturevalue.'|';
    
?>
</div>
<p style="font-size:8px" align="center">
    Representación Impresa de la Factura Electronica. Esta puede ser consultada en: <?php echo $server_name ?><br>
    Autorizado mediante Resolución de Intendencia N° <?php echo $num_aprobacion ?>
</p>
</body>
</html>
