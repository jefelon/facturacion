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

$dts1=$oVenta->mostrar_filtro_enc(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['hdd_fil_con_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id']);

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
<table cellspacing="1" id="tabla_venta" class="tablesorter">
    <thead>
    <tr>
        <th align="center">TIPO DE DOCUMENTO</th>
        <th align="center">MUMERO</th>
        <th align="center">FECHA EMISIÓN</th>
        <th align="center">CHOFER</th>
        <th align="center">DNI CHOFER</th>
        <th align="center">TOTAL ENCOMIENDAS</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <?php
    if($num_rows>0){
        ?>
        <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){
            ?>
            <tr>
                <td nowrap="nowrap">MANIFIESTO DE ENCOMIENDAS</td>
                <td nowrap="nowrap" align="center"><?php echo $dt1['tb_encomiendaventa_id']?></td>
                <td nowrap="nowrap" align="center"><?php echo mostrarFecha($dt1['tb_viajehorario_fecha'])?></td>
                <td><?php echo $dt1['tb_conductor_nom']?></td>
                <td><?php echo $dt1['tb_conductor_doc']?></td>
                <td align="right"><?php echo formato_money($dt1['total'])?> </td>
                <td align="center" nowrap="nowrap">
                    <form action="venta_impresion_gra_manifiesto_enc.php" target="_blank" method="post" style="text-align: center">
                        <input name="hdd_vh_id" type="hidden" id="hdd_vh_id" name="hdd_vh_id"  value="<?php echo $dt1['tb_viajehorario_id']?>">
                        <button class="btn_pdf" id="btn_pdf"  type="submit" title="Imprimir manifiesto de pasajeros">Imprimir Manifiesto</button>
                    </form>
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
        <td colspan="13"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>