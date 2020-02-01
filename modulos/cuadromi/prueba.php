<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../resumenboleta/cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/formato.php");

//contar para declarar
$dts1=$oVenta->mostrar_filtro_pendiente($_SESSION['empresa_id']);
$num_row1 = mysql_num_rows($dts1);

while($dt1 = mysql_fetch_array($dts1))
{
    $dts2=$oVenta->comparar_resumenboleta_detalle($dt1['tb_venta_id'],2);
    $d=mysql_num_rows($dts2);

    if($d==0)
    {
        $num++;
    }

    if($d==1)
    {
        if($dt1['tb_venta_est']=='CANCELADA')$dec++;
        if($dt1['tb_venta_est']=='ANULADA')$num++;
    }
    if($d==2)
    {

    }

    mysql_free_result($dts2);
}
mysql_free_result($dts1);

$dts1=$oVenta->mostrar_filtro_pendiente($_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts1);

//nota de credito relacionados a solo boletas para comparar
$dts22=$oVenta->mostrar_filtro_nc_pendiente($_SESSION['empresa_id']);
$num_row22 = mysql_num_rows($dts22);

while($dtn = mysql_fetch_array($dts22))
{
    $dts222=$oVenta->comparar_resumenboleta_detalle_notas($dtn['tb_venta_id'],3);
    $d=mysql_num_rows($dts222);

    if($d==0)
    {
        $num++;
    }

    if($d==1)
    {
        if($dtn['tb_venta_est']=='CANCELADA')$dec++;
    }
    if($d==2)
    {

    }

    mysql_free_result($dts222);
}
mysql_free_result($dts22);

// para mostrar
$dts22=$oVenta->mostrar_filtro_nc_pendiente($_SESSION['empresa_id']);
$num_row22 = mysql_num_rows($dts22);
//===========================fin notas

?>

<script type="text/javascript">
    $(function() {
        $('.btn_sunat, .btn_ticket').button({
            text: true
        });

        $("#tabla_venta").tablesorter({
            widgets: ['zebra', 'zebraHover'],
            headers: {
                //0: {sorter: 'shortDate' },
                //10: { sorter: false}
            },
            //sortForce: [[0,0]],
            //sortList: [[0,0],[2,1],[1,1]]
        });

    });
</script>
<table cellspacing="1" id="cuadro" class="ui-widget ui-widget-content">
    <thead>
    <tr class="ui-widget-header ">
        <th colspan="3" align="left">FECHAS PENDIENTES</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="3" align="left">Boletas pendiente de envío a SUNAT:</td>
    </tr>
    <?php
    $filas=0;
    while ($dt1 = mysql_fetch_array($dts1))
    {
        $filas++;
        $estado="";

        //sumatorias
        $opegra=($dt1['tb_venta_gra']);
        $igv=($dt1['tb_venta_igv']);
        $total=($dt1['tb_venta_tot']);
        ?>
        <tr>
            <td align="center"><?php echo $filas?></td>
            <td align="center"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
            <td align="center">
            <form action="../resumenboleta/venta_vista.php" method="post">
                <input type="hidden" name="fecha" value="<?php echo mostrarFecha($dt1['tb_venta_fec'])?>">
                <button type="submit" class="btn_sunat"  title="Generar" formtarget="_blank">Generar</button>
            </form>
            </td>
        </tr>
    <?php }
    mysql_free_result($dts1); ?>

    <!--    ==============nota de credito================== -->
    <?php
    //$filas=0;
    while ($dt22 = mysql_fetch_array($dts22))
    {
        $filas++;
        $estado="";

        //sumatorias
        $opegra=($dt22['tb_venta_gra']);
        $igv=($dt22['tb_venta_igv']);
        $total=($dt22['tb_venta_tot']);
        ?>
		<tr>
            <td align="center"><?php echo $filas?></td>
            <td align="center"><?php echo mostrarFecha($dt22['tb_venta_fec'])?></td>
            <td align="center">
                NOTA DE CRÉDITO -> Se genera automático.
            </td>
        </tr>
    <?php }
    mysql_free_result($dts22); ?>
    <!--          fin nota de crédito-->
    </tbody>
</table>
