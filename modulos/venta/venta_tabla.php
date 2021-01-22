<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../venta/cVentacorreo.php");
$oVentacorreo = new cVentacorreo();
require_once ("../formatos/formato.php");

require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once ("../venta/cVentapago.php");
$oVentapago = new cVentapago();
require_once ("../clientecuenta/cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../letras/cLetras.php");
$cLetras = new cLetras();

$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa = $dt['tb_empresa_ruc'];


$dts1=$oVenta->mostrar_filtro(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_SESSION['usuario_id'],$_SESSION['puntoventa_id'],$_POST['chk_fil_ven_may'],$_POST['cmb_fil_ven_tip']);
$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
    $(function() {
        $('.btn_accion').button({
            icons: {primary: "ui-icon-mail-closed"},
            text: false
        });
        $('.btn_editar').button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });
        $('.btn_sunat').button({
            text: true
        });
        $('.btn_eliminar').button({
            icons: {primary: "ui-icon-trash"},
            text: false
        });

        $('.btn_anular').button({
            icons: {primary: "ui-icon-cancel"},
            text: false
        });
        $('.btn_pdf').button({
            //icons: {primary: "ui-icon-document"},
            //text: false
        });
        $('.btn_xml,.btn_cdr').button({
            //icons: {primary: "ui-icon-document"},
            //text: false
        });

        $("#tabla_venta").tablesorter({
            widgets: ['zebra', 'zebraHover'],
            headers: {
                0: {sorter: 'shortDate' },
                10: { sorter: false}
            },
            //sortForce: [[0,0]],
            sortList: [[2,0],[0,0],[1,0]]
        });

    });
</script>
<table cellspacing="1" id="tabla_venta" class="tablesorter">
    <thead>
    <tr>
        <th align="center">TIPO DE DOCUMENTO</th>
        <th align="center">DOCUMENTO</th>
        <th align="center">FECHA EMISIÓN</th>
        <th align="center">CLIENTE</th>
        <th lign="center">RUC/DNI</th>
        <th align="center">MONEDA</th>

        <th align="center"> <?php if ($_POST['cmb_fil_ven_tip']=='ENCOMIENDA'){
                        echo 'VALOR VENTA';
                    }else{
                        echo 'OP EXO';;
                    } ?>
        </th>
        <th align="center">IGV</th>
        <th align="center">IMPORTE TOTAL</th>
        <th align="center">ESTADO DOC.</th>
        <th align="center">ESTADO SUNAT</th>
        <th align="center">FECHA DE ENVIO SUNAT</th>
        <th align="center">CORREO</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <?php
    if($num_rows>0){
        ?>
        <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){
            $estado = $dt1['tb_venta_est'];
            $total_revisado=0;
            $por_pagar=false;
            $dts11=$oVentapago->mostrar_pagos($dt1['tb_venta_id']);
            while($dt11 = mysql_fetch_array($dts11)){
                if($dt11['tb_formapago_id']==4){ //por pagar
                    $total_revisado=0;
                    $por_pagar=true;
                }
                else{
                    $total_revisado=$dt11['tb_ventapago_mon'];
                    $por_pagar=false;
                }
            }

            $doc_id = $dt1['tb_documento_id'];
            if($dt1['tb_venta_est']=='CANCELADA' && $por_pagar==false && $doc_id!=15){
                $total_val_ven+=$dt1['tb_venta_valven'];
                $total_igv+=$dt1['tb_venta_igv'];
            }
            if($dt1['tb_venta_est']=='CANCELADA' && $por_pagar==false){
                $total_ventas+=$dt1['tb_venta_tot'];
            }
            $tipodoc = $dt1['cs_tipodocumento_cod'];
            $xml="";
            $xml=$ruc_empresa."-0".$dt1['cs_tipodocumento_cod']."-".$dt1['tb_venta_ser']."-".$dt1['tb_venta_num'];
            $cdr="";
            $cdr="R-".$ruc_empresa."-0".$dt1['cs_tipodocumento_cod']."-".$dt1['tb_venta_ser']."-".$dt1['tb_venta_num'];
            ?>
            <tr>
                <td nowrap="nowrap"><?php echo $dt1['tb_documento_nom'];?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_venta_ser'].'-'.$dt1['tb_venta_num']?></td>
                <td nowrap="nowrap" align="center"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                <td><?php echo $dt1['tb_cliente_nom']?></td>
                <td><?php echo $dt1['tb_cliente_doc']?></td>
                <td align="center">
                    <?php
                    if($dt1['cs_tipomoneda_id']=='1'){
                        echo 'SOLES';
                    }
                    if($dt1['cs_tipomoneda_id']=='2'){
                        echo 'DOLARES';
                    }
                    ?>
                </td>
                <td align="right">
                    <?php
                    if ($estado == "ANULADA" || $doc_id==15) {
                        echo "0";
                    } else {
                        echo formato_money($dt1['tb_venta_valven']);
                    }
                    ?>
                </td>
                <td align="right">
                <?php
                if ($estado == "ANULADA" || $doc_id==15) {
                    echo "0";
                } else {
                    echo formato_money($dt1['tb_venta_igv']);
                }
                ?>
            </td>
            <td align="right">
                <?php
                if ($estado == "ANULADA") {
                    echo "0";
                }
                else if($doc_id==15){//nota de salida
                    echo $total_revisado;
                }
                else {
                    echo formato_money($dt1['tb_venta_tot']);
                }
                ?>
            </td>
            <td>
                <?php
                if($estado=="ANULADA") {
                    echo "ANULADA";
                }
                else{
                    $dts2 = $oVentapago->mostrar_pagos($dt1['tb_venta_id']);
                    $num_rows2 = mysql_num_rows($dts2);

                    while ($dt2 = mysql_fetch_array($dts2)) {
                        if ($dt2['tb_formapago_id'] == 1) echo 'CONTADO ';
                        if ($dt2['tb_formapago_id'] == 2) echo 'CREDITO ' . $dt2['tb_ventapago_numdia'] . 'D | FV: ' . mostrarFecha($dt2['tb_ventapago_fecven']);
                        if ($dt2['tb_formapago_id'] == 3) {
                            echo 'LETRAS: ';
                            $ltrs1 = $cLetras->mostrar_letras($dt1['tb_venta_id']);

                            $date1 = new  DateTime($fecha);

                            $cont = 1;
                            while ($ltr = mysql_fetch_array($ltrs1)) {
                                $date2 = new DateTime($ltr['tb_letras_fecha']);
                                $interval = $date1->diff($date2);
                                $diferencia = $interval->format('%a dias');

    //                                $modo.= '<br>L'.$ltr['tb_letras_orden'].' '.$diferencia.' '.mostrarFecha($ltr['tb_letras_fecha']). ' M. '.$ltr['tb_letras_monto'];
                                echo 'L' . $ltr['tb_letras_orden'] . " ";

                            }

                        }
                        if ($dt2['tb_formapago_id'] == 4) echo 'POR PAGAR ';

                        echo $simb_moneda . " " . $dt2['tb_ventapago_mon'];

                    }
                }

                mysql_free_result($dts2);
                ?>

                </td>
                <td>
                    <?php
                    $mostrar_envio_sunat=0;
                    if($dt1['tb_documento_ele']==1)
                    {
                        if($dt1['tb_venta_estsun']=='0')
                        {
                            echo 'PENDIENTE ENVIO';
                            $mostrar_envio_sunat=1;
                        }
                        if($dt1['tb_venta_estsun']=='1')
                        {
                            echo 'ACEPTADO';
                        }
                        if($dt1['tb_venta_estsun']=='2')
                        {
                            echo 'RECHAZADO';
                        }
                        if($dt1['tb_venta_estsun']=='10')
                        {
                            echo 'RESUMEN';
                        }

                    }
                    else
                    {
                        echo '';
                    }
                    ?>
                </td>
                <td align="center" nowrap>
                    <?php
                    echo mostrarFechaHora($dt1['tb_venta_fecenvsun']);
                    ?></td>
                <td>
                    <?php
                    $cant = $oVentacorreo->contar($dt1['tb_venta_id']);
                    if($cant>0)echo '<a href="#email" tittle="Ver Correos" onClick="venta_correo_email('.$dt1['tb_venta_id'].')">Correos('.$cant.')</a>';
                    ?>
                </td>
                <td align="left" nowrap="nowrap">
                    <a class="btn_pdf" id="btn_pdf" href="#print" title="Descargar pdf" onClick="venta_impresion_pas(<?php echo $dt1['tb_venta_id']?>)"> PDF</a>
                    <?php if($dt1['tb_documento_ele']==1):?>
                        <?php if($mostrar_envio_sunat==1):?>
                            <a class="btn_sunat" href="#sunat" onClick="enviar_sunat('<?php echo $dt1['tb_venta_id']?>')">E. Sunat</a><?php endif;?>
                            <a class="btn_accion" id="btn_accion" href="#correo" title="Enviar correo" onClick="venta_correo_form('enviar',
                                    '<?php echo $dt1['tb_venta_id']?>'
                                    )">Enviar Correo</a>
                            <a class="btn_xml" id="btn_xml" target="_blank" href="<?php echo "../../cperepositorio/send/$xml.zip";?>" title="Descargar XML">XML</a>
                        <?php
                        if($dt1['cs_tipodocumento_cod']==1){
                            if(file_exists("../../cperepositorio/cdr/$cdr.xml")){
                                ?>
                                <a class="btn_xml" id="btn_xml" target="_blank" href="<?php echo "../../cperepositorio/cdr/$cdr.zip";?>" title="Descargar CDR">CDR</a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a class="btn_cdr" href="#getcdr" onClick="cpe_cdr('<?php echo $dt1['tb_venta_id']?>')">Obt. CDR</a>
                                <?php
                            }
                        }
                        ?>
                    <?php endif;?>
                    <?php //if($dt1['tb_documento_ele']==0):?>
                    <?php if($dt1['tb_venta_est']!='ANULADA' and $_POST['chk_ven_anu']==1){?>
                        <a class="btn_anular" href="#anular" onClick="venta_anular('<?php echo $dt1['tb_venta_id']?>','<?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_numdoc']?>')">Anular</a>
                    <?php } ?>
                    <?php //endif?>
                    <!--<a class="btn_eliminar" href="#delete" onClick="eliminar_venta('<?php //echo $dt1['tb_venta_id']?>')">Eliminarr</a>-->
                </td>
            </tr>
            <?php
        }
        mysql_free_result($dts1);
        ?>
        </tbody>
        <?php
    }
    ?>
    <tr class="even">
        <td colspan="6">TOTAL</td>
        <td align="right"><strong><?php echo formato_money($total_val_ven)?></strong></td>
        <td align="right"><strong><?php echo formato_money($total_igv)?></strong></td>
        <td align="right"><strong><?php echo formato_money($total_ventas)?></strong></td>
        <td colspan="5" align="right">&nbsp;</td>
    </tr>
    <tr class="even">
        <td colspan="14"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>