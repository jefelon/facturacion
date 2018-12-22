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


$dts1=$oVenta->mostrar_filtro(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_SESSION['usuario_id'],$_SESSION['puntoventa_id'],$_POST['chk_fil_ven_may']);
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
        <th align="center">RUC/DNI</th>
        <th align="center">MONEDA</th>
        <th align="center">VALOR VENTA</th>
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
            if($dt1['tb_venta_est']=='CANCELADA') {
                if ($dt1['cs_tipomoneda_id'] == '1') {
                    $total_ventas_soles += $dt1['tb_venta_tot'];
                }else{
                    $total_ventas_dolares += $dt1['tb_venta_tot'];
                }
            }
            $tipodoc = $dt1['cs_tipodocumento_cod'];
            $simb_moneda="";

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
                        $simb_moneda="S/ ";
                        echo 'SOLES';
                    }
                    if($dt1['cs_tipomoneda_id']=='2'){
                        $simb_moneda= "$ ";
                        echo 'DOLARES';
                    }
                    ?>
                </td>
                <td align="right"><?php echo formato_money($dt1['tb_venta_valven'])?></td>
                <td align="right"><?php echo formato_money($dt1['tb_venta_igv'])?></td>
                <td align="right"><?php echo formato_money($dt1['tb_venta_tot'])?></td>
                <td>
                    <?php
                    $dts2=$oVentapago->mostrar_pagos($dt1['tb_venta_id']);
                    $num_rows2= mysql_num_rows($dts2);

                    while($dt2 = mysql_fetch_array($dts2)){
                        if($dt2['tb_formapago_id']==1)echo 'CONTADO ';
                        if($dt2['tb_formapago_id']==2)echo 'CREDITO '.$dt2['tb_ventapago_numdia'].'D | FV: '.mostrarFecha($dt2['tb_ventapago_fecven']);
                        if($dt2['tb_formapago_id']==3){
                            echo 'LETRAS: ';
                            $ltrs1=$cLetras->mostrar_letras($dt1['tb_venta_id']);

                            $date1 = new  DateTime($fecha);

                            $cont=1;
                            while($ltr= mysql_fetch_array($ltrs1)){
                                $date2 = new DateTime($ltr['tb_letras_fecha']);
                                $interval = $date1->diff( $date2 );
                                $diferencia=$interval->format('%a dias');

//                                $modo.= '<br>L'.$ltr['tb_letras_orden'].' '.$diferencia.' '.mostrarFecha($ltr['tb_letras_fecha']). ' M. '.$ltr['tb_letras_monto'];
                                echo 'L'.$ltr['tb_letras_orden'] . " ";

                            }

                        }

                    }
                    mysql_free_result($dts2);

                    //Saldo A Cuenta
                    $ventip=1;
                    $tipo=2;
                    $tipo_registro=2;
                    $total_pagado=0;

                    $dts3=$oClientecuenta->mostrar_por_tipo_venta($ventip, $dt1['tb_venta_id'],$tipo,$tipo_registro);
                    while($dt3 = mysql_fetch_array($dts3)){
                        $total_pagado+=$dt3['tb_clientecuenta_mon'];
                    }
                    mysql_free_result($dts3);
                    echo $simb_moneda." " .$total_pagado;
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
                    <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">Editar</a>
                    <?php if($dt1['tb_documento_ele']==1):?>
                        <?php if($mostrar_envio_sunat==1):?>
                            <a class="btn_sunat" href="#sunat" onClick="enviar_sunat('<?php echo $dt1['tb_venta_id']?>')">E. Sunat</a><?php endif;?>
                            <a class="btn_accion" id="btn_accion" href="#correo" title="Enviar correo" onClick="venta_correo_form('enviar',
                                    '<?php echo $dt1['tb_venta_id']?>'
                                    )">Enviar Correo</a>
                            <a class="btn_pdf" id="btn_pdf" href="#print" title="Descargar pdf" onClick="venta_impresion('<?php echo $dt1['tb_venta_id']?>')">PDF</a>
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
        <td colspan="6"></td>
        <td colspan="2">TOTAL SOLES</td>
        <td align="right"><strong><?php echo formato_money($total_ventas_soles)?></strong></td>
        <td colspan="5" align="right">&nbsp;</td>
    </tr>
    <tr class="even">
        <td colspan="6"></td>
        <td colspan="2">TOTAL DOLARES</td>
        <td align="right"><strong><?php echo formato_money($total_ventas_dolares)?></strong></td>
        <td colspan="5" align="right">&nbsp;</td>
    </tr>
    <tr class="even">
        <td colspan="13"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>