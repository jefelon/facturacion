<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../venta/cVentacorreo.php");
$oVentacorreo = new cVentacorreo();
require_once ("../formatos/formato.php");
require_once ("../venta/cVentapago.php");
$oVentapago = new cVentapago();
require_once ("../clientecuenta/cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../letras/cLetras.php");
$cLetras = new cLetras();
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa=$dt['tb_empresa_ruc'];

$dts1=$oVenta->mostrar_filtro_integracion(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id'],$_POST['chk_fil_ven_may']);

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
        $('.btn_anular').button({
            icons: {primary: "ui-icon-cancel"},
            text: false
        });
        $('.btn_eliminar').button({
            icons: {primary: "ui-icon-trash"},
            text: false
        });
        $('.btn_pdf').button({
            //icons: {primary: "ui-icon-document"},
            //text: false
        });
        $('.btn_xml').button({
            //icons: {primary: "ui-icon-document"},
            //text: false
        });

        $("#tabla_venta").tablesorter({
            widgets: ['zebra', 'zebraHover']
        });

    });
</script>
<table cellspacing="1" id="tabla_venta" class="tablesorter">
    <thead>
    <tr>
        <th align="center">SUCR_codigo</th>
        <th align="center">CABA_ano</th>
        <th align="center">CABA_mes</th>
        <th align="center">TIPO_tipReg</th>
        <th align="center">CABA_nrovoucher</th>
        <th align="center">CABA_Glosa</th>
        <th align="center">CABA_usrCrea</th>
        <th align="center">CABA_moneda</th>
        <th align="center">Deta_moneda</th>
        <th align="center">ENTC_ruc</th>
        <th align="center">ENTC_razonSoc</th>
        <th align="center">CUEN_codigo</th>
        <th align="center">DETA_elemento</th>
        <th align="center">DETA_Glosa</th>
        <th align="center">CENT_codigo</th>
        <th align="center">TIPO_tipOrigen</th>
        <th align="center">DETA_FecDocOrigen</th>
        <th align="center">DETA_SerieDocOrigen</th>
        <th align="center">DETA_nroDocOrigen</th>
        <th align="center">DETA_Referencia</th>
        <th align="center">DETA_debe</th>
        <th align="center">DETA_haber</th>
        <th align="center">DETA_DebeDol</th>
        <th align="center">DETA_HaberDol</th>
        <th align="center">TIPO_tipOpe</th>
        <th align="center">DETA_Tcambio</th>
    </tr>
    </thead>
    <?php
    if($num_rows>0){
        ?>
        <tbody>
        <?php
        $estado="";
        $cont_rel=1;
        while($dt1 = mysql_fetch_array($dts1)){
            $estado = $dt1['tb_venta_est'];
            $tipodoc = $dt1['cs_tipodocumento_cod'];
            $simb_moneda = "";

            ?>


            <tr>
                <td nowrap="nowrap">01</td>
                <td nowrap="nowrap"><?php echo mostrarDiaMesAnio(3,$dt1['tb_venta_fec']); ?></td>
                <td nowrap="nowrap"><?php echo date("m", strtotime($dt1['tb_venta_fec'])); ?></td>
                <td nowrap="nowrap">002</td>
                <td nowrap="nowrap"><?php echo str_pad($dt1['tb_venta_id'],6, "0", STR_PAD_LEFT); ?></td>
                <td nowrap="nowrap">VENTA MERCADERIA</td>
                <td nowrap="nowrap">contabilidad</td>
                <td nowrap="nowrap"><?php echo $dt1['cs_tipomoneda_id']; ?></td>
                <td nowrap="nowrap"><?php echo $dt1['cs_tipomoneda_id']; ?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_cliente_doc']; ?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']; ?></td>
                <td nowrap="nowrap">12.1.3.1</td>
                <td nowrap="nowrap">1</td>
                <td nowrap="nowrap">VENTA MERCADERIA</td>
                <td nowrap="nowrap"></td>
                <td nowrap="nowrap"></td>
                <td nowrap="nowrap"><?php echo date('d/m/Y', strtotime($dt1['tb_venta_fec'])); ?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_venta_ser'] ?></td>
                <td nowrap="nowrap" align="center"><?php echo $dt1['tb_venta_num'] ?></td>
                <td></td>
                <td><?php echo $dt1['tb_venta_tot'] ?></td>
                <td align="center">

                </td>
                <td align="right">
                    <?php echo formato_money($dt1['tb_venta_tot']/$dt1['tb_tipocambio_dolsunv']); ?>
                </td>
                <td align="right">
                </td>
                <td align="right">
                    001
                </td>
                <td><?php echo $dt1['tb_tipocambio_dolsunv'] ?></td>

            </tr>
            <tr>
                <td nowrap="nowrap">01</td>
                <td nowrap="nowrap"><?php echo mostrarDiaMesAnio(3,$dt1['tb_venta_fec']); ?></td>
                <td nowrap="nowrap"><?php echo date("m", strtotime($dt1['tb_venta_fec'])); ?></td>
                <td nowrap="nowrap">002</td>
                <td nowrap="nowrap"><?php echo str_pad($dt1['tb_venta_id'],6, "0", STR_PAD_LEFT); ?></td>
                <td nowrap="nowrap">VENTA MERCADERIA</td>
                <td nowrap="nowrap">contabilidad</td>
                <td nowrap="nowrap"><?php echo $dt1['cs_tipomoneda_id']; ?></td>
                <td nowrap="nowrap"><?php echo $dt1['cs_tipomoneda_id']; ?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_cliente_doc']; ?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']; ?></td>
                <td nowrap="nowrap">40.1.1.1</td>
                <td nowrap="nowrap">2</td>
                <td nowrap="nowrap">VENTA MERCADERIA</td>
                <td nowrap="nowrap"></td>
                <td nowrap="nowrap"></td>
                <td nowrap="nowrap"><?php echo date('d/m/Y', strtotime($dt1['tb_venta_fec'])); ?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_venta_ser'] ?></td>
                <td nowrap="nowrap" align="center"><?php echo $dt1['tb_venta_num'] ?></td>
                <td></td>
                <td></td>
                <td align="center">
                    <?php echo $dt1['tb_venta_igv'] ?>
                </td>
                <td align="right">

                </td>
                <td align="right">
                    <?php echo formato_money($dt1['tb_venta_igv']/$dt1['tb_tipocambio_dolsunv']); ?>
                </td>
                <td align="right">
                    001
                </td>
                <td><?php echo $dt1['tb_tipocambio_dolsunv'] ?></td>

            </tr>
            <?php
            $cont_rel++;
            $vds=$oVenta->mostrar_venta_detalle($dt1['tb_venta_id']);
            $num_rows= mysql_num_rows($vds);

            $vss=$oVenta->mostrar_venta_detalle_servicio($dt1['tb_venta_id']);
            $num_rows_2= mysql_num_rows($vss);

            $num_rows_total = ($num_rows + $num_rows_2);
            $cont_det=3;
            while($vd = mysql_fetch_array($vds)){
            ?>
                <tr>
                <td nowrap="nowrap">01</td>
                <td nowrap="nowrap"><?php echo mostrarDiaMesAnio(3,$dt1['tb_venta_fec']); ?></td>
                <td nowrap="nowrap"><?php echo date("m", strtotime($dt1['tb_venta_fec'])); ?></td>
                <td nowrap="nowrap">002</td>
                <td nowrap="nowrap"><?php echo str_pad($dt1['tb_venta_id'],6, "0", STR_PAD_LEFT); ?></td>
                <td nowrap="nowrap">VENTA MERCADERIA</td>
                <td nowrap="nowrap">contabilidad</td>
                <td nowrap="nowrap"><?php echo $dt1['cs_tipomoneda_id']; ?></td>
                <td nowrap="nowrap"><?php echo $dt1['cs_tipomoneda_id']; ?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_cliente_doc']; ?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']; ?></td>
                <td nowrap="nowrap">70.1.1.1</td>
                <td nowrap="nowrap"><?php echo $cont_det; ?></td>
                <td nowrap="nowrap">VENTA MERCADERIA</td>
                <td nowrap="nowrap">01.01.<?php echo str_pad($cont_det-2,2, "0", STR_PAD_LEFT); ?></td>
                <td nowrap="nowrap"></td>
                <td nowrap="nowrap"><?php echo date('d/m/Y', strtotime($dt1['tb_venta_fec'])); ?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_venta_ser'] ?></td>
                <td nowrap="nowrap" align="center"><?php echo $dt1['tb_venta_num'] ?></td>
                <td></td>
                <td></td>
                <td align="center">
                    <?php echo $vd['tb_ventadetalle_valven'] ?>
                </td>
                <td align="right">

                </td>
                <td align="right">
                    <?php echo formato_money($vd['tb_ventadetalle_valven']/$dt1['tb_tipocambio_dolsunv']); ?>
                </td>
                <td align="right">
                    001
                </td>
                <td><?php echo $dt1['tb_tipocambio_dolsunv'] ?></td>

                </tr>
                <?php
                $cont_det++;
            }
            while($vs = mysql_fetch_array($vss)){
                ?>
                <tr>
                    <td nowrap="nowrap">01 ?></td>
                    <td nowrap="nowrap"><?php echo mostrarDiaMesAnio(3,$dt1['tb_venta_fec']); ?></td>
                    <td nowrap="nowrap"><?php echo date("m", strtotime($dt1['tb_venta_fec'])); ?></td>
                    <td nowrap="nowrap">002</td>
                    <td nowrap="nowrap"><?php echo str_pad($dt1['tb_venta_id'],6, "0", STR_PAD_LEFT); ?></td>
                    <td nowrap="nowrap">VENTA MERCADERIA</td>
                    <td nowrap="nowrap">contabilidad</td>
                    <td nowrap="nowrap"><?php echo $dt1['cs_tipomoneda_id']; ?></td>
                    <td nowrap="nowrap"><?php echo $dt1['cs_tipomoneda_id']; ?></td>
                    <td nowrap="nowrap"><?php echo $dt1['tb_cliente_doc']; ?></td>
                    <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']; ?></td>
                    <td nowrap="nowrap">70.1.1.1</td>
                    <td nowrap="nowrap"><?php echo $cont_det; ?></td>
                    <td nowrap="nowrap">VENTA MERCADERIA</td>
                    <td nowrap="nowrap">01.01.<?php echo str_pad($cont_det-2,2, "0", STR_PAD_LEFT); ?></td>
                    <td nowrap="nowrap"></td>
                    <td nowrap="nowrap"><?php echo date('d/m/Y', strtotime($dt1['tb_venta_fec'])); ?></td>
                    <td nowrap="nowrap"><?php echo $dt1['tb_venta_ser'] ?></td>
                    <td nowrap="nowrap" align="center"><?php echo $dt1['tb_venta_num'] ?></td>
                    <td></td>
                    <td></td>
                    <td align="center">
                        <?php echo $vs['tb_ventadetalle_valven'] ?>
                    </td>
                    <td align="right">

                    </td>
                    <td align="right">
                    </td>
                    <td align="right">
                        001
                    </td>
                    <td><?php echo $dt1['tb_tipocambio_dolsunv'] ?></td>

                </tr>
                <?php
                $cont_det++;
        }

        }
        mysql_free_result($dts1);
        ?>
        </tbody>
        <?php
    }
    ?>
</table>