<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();
require_once ("../venta/cVentacorreo.php");
$oVentacorreo = new cVentacorreo();
require_once ("../formatos/formato.php");

require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa = $dt['tb_empresa_ruc'];

$dts1=$oCotizacion->mostrar_filtro(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],'',$_SESSION['usuario_id'],$_SESSION['puntoventa_id'],$_POST['chk_fil_ven_may']);
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

        $('.btn_anular').button({
            icons: {primary: "ui-icon-cancel"},
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
                    }?>
                </td>
                <td align="right"><?php echo formato_money($dt1['tb_venta_tot'])?></td>
                <td><?php echo $dt1['tb_venta_est']?></td>
                <td align="left" nowrap="nowrap">
                    <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">Editar</a>
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