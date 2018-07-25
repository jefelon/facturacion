<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../venta/cVentacorreo.php");
$oVentacorreo = new cVentacorreo();
require_once ("../formatos/formato.php");
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa = $dt['tb_empresa_ruc'];




$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);

$dts1=$oVenta->mostrar_filtro(fechahora_mysql($_POST['txt_fil_ven_fec1']), fechahora_mysql_agregar_dias($_POST['txt_fil_ven_fec2'],'+24 hours'), $_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_SESSION['usuario_id'],$_SESSION['puntoventa_id'],$_POST['chk_fil_ven_may']);
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
        <th align="center">TIENDA</th>
        <th align="center">TIPO</th>
        <th align="center">FECHA PEDIDO</th>
        <th align="center">FECHA DE ENTREGA</th>
        <th align="center">CLIENTE</th>
        <th align="center">RUC/DNI</th>
        <th align="center">MONEDA</th>
        <th align="center">IMPORTE TOTAL</th>
        <th align="center">ESTADO DOC.</th>

        <th>&nbsp;</th>
    </tr>
    </thead>
    <?php
    if($num_rows>0){
        ?>
        <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){
            if($dt1['tb_venta_est']=='CANCELADA'){
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
                <td nowrap="nowrap"><?php echo $pv['tb_puntoventa_nom']?></td>
                <td>
                <?php if ($dt1['tb_venta_tipven']==1) {
                    echo 'Bordado';
                }elseif ($dt1['tb_venta_tipven']==2){
                    echo 'Sublimado';
                }elseif ($dt1['tb_venta_tipven']==3){
                    echo 'Confección';
                }elseif ($dt1['tb_venta_tipven']==4){
                    echo 'Venta de Artículos';
                }elseif ($dt1['tb_venta_tipven']==5){
                    echo 'Hojal y Boton';
                }?>
                </td>
                <td nowrap="nowrap" align="center"><?php echo mostrarFechaHora($dt1['tb_venta_fec'])?></td>
                <td nowrap="nowrap" align="center"><?php echo mostrarFechaHora($dt1['tb_venta_fec'])?></td>
                <td><?php echo $dt1['tb_cliente_nom']?></td>
                <td><?php echo $dt1['tb_cliente_doc']?></td>
                <td align="center">
                    <?php
                    if($dt1['cs_tipomoneda_id']=='1'){
                        echo 'SOLES';
                    }?>
                </td>
                <td align="right"><?php echo formato_money($dt1['tb_venta_tot'])?></td>
                <td><?php echo $dt1['tb_venta_est']?></td>
                <td align="left" nowrap="nowrap">
                    <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">Editar</a>
                    <?php if($dt1['tb_documento_ele']==1):?>
                            <a class="btn_accion" id="btn_accion" href="#correo" title="Enviar correo" onClick="venta_correo_form('enviar',
                                    '<?php echo $dt1['tb_venta_id']?>'
                                    )">Enviar Correo</a>
                            <a class="btn_pdf" id="btn_pdf" href="#print" title="Descargar pdf" onClick="venta_impresion('<?php echo $dt1['tb_venta_id']?>')">PDF</a>
                    <?php endif;?>
                    <?php //if($dt1['tb_documento_ele']==0):?>
                    <?php if($dt1['tb_venta_est']!='ANULADA' and $_POST['chk_ven_anu']==1){?>
                        <a class="btn_anular" href="#anular" onClick="venta_anular('<?php echo $dt1['tb_venta_id']?>','<?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_numdoc']?>')">Anular</a>
                    <?php } ?>
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
        <td align="right"><strong><?php echo formato_money($total_ventas)?></strong></td>
        <td colspan="5" align="right">&nbsp;</td>
    </tr>
    <tr class="even">
        <td colspan="13"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>