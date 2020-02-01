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
require_once ("../cajadetalle/cCajadetalle.php");
$oCajadetalle = new cCajadetalle();
require_once ("../caja/cCaja.php");
$oCaja = new cCaja();

require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa = $dt['tb_empresa_ruc'];

$fec_cierre=date('d-m-Y h:i:s a');


$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);

$cdets=$oCajadetalle->mostrarTodosCaja($pv['tb_caja_id'],$_SESSION['usuario_id'],20);
$num_rows= mysql_num_rows($cdets);


?>

<script type="text/javascript">
    $(function() {
        $('.btn_accion').button({
            icons: {primary: "ui-icon-mail-closed"},
            text: false
        });
        $('.btn_detalle').button({
            icons: {primary: "ui-icon-extlink"},
            text: false
        });

        $("#tabla_cajadetalle").tablesorter({
            widgets: ['zebra', 'zebraHover']
            //sortForce: [[0,0]],

        });

    });
</script>
<table cellspacing="1" id="tabla_cajadetalle" class="tablesorter">
    <thead>
    <tr>
        <th align="center">NOMBRE CAJA</th>
        <th align="center">FECHA APERTURA</th>
        <th align="center">FECHA CIERRE</th>
        <th align="center">ESTADO</th>
        <th align="center">MONTO INICIAL</th>
        <th align="center">MONTO CIERRE</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <?php
    if($num_rows>0){
        ?>
        <tbody>
        <?php
        while($cdet = mysql_fetch_array($cdets)){
            $cjs=$oCaja->mostrarUno($cdet['tb_caja_id']);
            $cj = mysql_fetch_array($cjs);
            ?>
            <tr>
                <td nowrap="nowrap"><?php echo $cj['tb_caja_nom']; ?></td>
                <td nowrap="nowrap"><?php echo $cdet['tb_caja_apertura']; ?></td>
                <td nowrap="nowrap"><?php if ($cdet['tb_caja_estado']==0){ echo $cdet['tb_caja_cierre']; }?></td>
                <td nowrap="nowrap"><?php if ($cdet['tb_caja_estado']==1){echo 'Abierta';}else{echo 'Cerrada';}?></td>
                <td nowrap="nowrap"><?php echo formato_moneda($cdet['tb_caja_inicial']); ?></td>
                <td nowrap="nowrap"><?php echo formato_moneda($cdet['tb_caja_final']); ?></td>
                <td align="center"><a class="btn_detalle" href="#" onclick="caja_detalle_consulta('actualizar','<?php echo mostrarFechaHora($cdet['tb_caja_apertura']); ?>','<?php if ($cdet['tb_caja_estado']==1){echo mostrarFechaHora($fec_cierre);}else{echo mostrarFechaHora($cdet['tb_caja_cierre']);} ?>','<?php echo $cdet['tb_cajadetalle_id'];?>','<?php echo $cdet['tb_caja_inicial']; ?>','<?php echo $cdet['tb_usuario_id']; ?>')">Ver Detalle</a></td>
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