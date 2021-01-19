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
$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa=$dt['tb_empresa_ruc'];

$horario=$_POST['hdd_vi_ho'];

if($horario>0) {
    $dts1 = $oVenta->mostrar_filtro_detalle_armado_enc($_POST['hdd_fil_cli_id2'], $_SESSION['usuario_id'], $_SESSION['puntoventa_id'], $_POST['hdd_vi_ho']);
    $num_rows = mysql_num_rows($dts1);
}
?>

<script type="text/javascript">
    $(function() {

        $('.btn_accion').button({
            icons: {primary: "ui-icon-mail-closed"},
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
        $('.btn_retornar').button({
            icons: {primary: "ui-icon-circle-arrow-w"},
            text: false
        });

        $("#tabla_venta2").tablesorter({
            widgets: ['zebra', 'zebraHover'],
            // headers: {
            //     0: {sorter: 'shortDate' },
            //     11: { sorter: false}
            // },
            // //sortForce: [[0,0]],
            // sortList: [[2,0],[0,0],[1,0]]
        });

    });
</script>
<table cellspacing="1" id="tabla_venta2" class="tablesorter">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>FECHA</th>
        <th>HORA</th>
        <th>DOCUMENTO</th>
        <th>ARTICULO</th>
        <th align="right">CAN</th>
        <th align="right">IMPORTE</th>
    </tr>
    </thead>
    <?php
    if($num_rows>0 AND $horario>0){
        ?>
        <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){
            $sub_total=$dt1['tb_ventadetalle_valven']+$dt1['tb_ventadetalle_igv'];

            if($dt1['tb_venta_est']=='CANCELADA'){
                $total_valven	+=$dt1['tb_ventadetalle_valven'];
                $total_igv		+=$dt1['tb_ventadetalle_igv'];

                //$total_des		+=$dt1['tb_venta_des'];
                $total_ventas	+=$sub_total;
            }

            $total_cant+=$dt1['tb_ventadetalle_can'];
            ?>
            <tr>
                <td align="left" nowrap="nowrap">
                    <a class="btn_retornar" href="#update" onClick="retornar_encomieda(<?php echo $dt1['tb_venta_id']?>)">Retornar</a>
                </td>
                <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                <td nowrap="nowrap"><?php echo mostrarHora_fh($dt1['tb_venta_reg'])?></td>
                <td nowrap="nowrap" title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_venta_numdoc']?></td>
                <td><?php
                    if($dt1['tb_ventadetalle_tipven']==1)echo $dt1['tb_producto_nom'];
                    if($dt1['tb_ventadetalle_tipven']==2)echo $dt1['tb_servicio_nom'];
                    ?>
                </td>
                <td align="right"><?php echo $dt1['tb_ventadetalle_can']?></td>
                <td align="right"><?php echo formato_money($sub_total)?></td>
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
        <td colspan="5">TOTAL</td>
        <td align="right"><strong><?php echo $total_cant?></strong></td>
        <td align="right"><strong><?php echo formato_money($total_ventas)?></strong></td>
        <td colspan="2" align="right">&nbsp;</td>
    </tr>
    <tr class="even">
        <td colspan="13"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>