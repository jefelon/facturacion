<?php
session_start();
if ($_SESSION["autentificado"] != "SI") {
    header("location: ../../index.php");
    exit();
}
require_once("../../config/Cado.php");

require_once("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("../venta/cVenta.php");
$oVenta = new cVenta();

if ($_SESSION['usuariogrupo_id'] == 2) $titulo = 'Registrar Ventas - Administrador';
if ($_SESSION['usuariogrupo_id'] == 3) $titulo = 'Registrar Ventas - Vendedor';
require_once("../../config/Cado.php");

require_once("../formatos/formato.php");
require_once("../asientoestado/cAsientoestado.php");
$oAsientoestado = new cAsientoestado();

$fec = date('d-m-Y');

$vts = $oVenta->mostrar_venta_viaje2($_POST['viaje_horario_id'],$_POST['asiento_id']);
$vt = mysql_fetch_array($vts);

$nro_rows = mysql_num_rows($vts);
if ($nro_rows>0) {
    $dts = $oVenta->mostrarUno($vt['tb_venta_id']);
    $dt = mysql_fetch_array($dts);

    $numdoc = $dt['tb_venta_numdoc'];
    $cli_nom = $dt['tb_cliente_nom'];
    $cli_doc = $dt['tb_cliente_doc'];
    $doc_id = $dt['tb_documento_id'];
    $tot = $dt['tb_venta_tot'];

    if ($doc_id == 11) {
        $nom_doc = 'FACTURA';
    } elseif ($doc_id == 12) {
        $nom_doc = 'BOLETA';
    }
}else{
    $dts = $oAsientoestado->mostrar_asiento_estado($_POST['viaje_horario_id'],$_POST['asiento_id']);
    $dt = mysql_fetch_array($dts);
    $cli_nom = $dt['tb_cliente_nom'];
    $cli_doc = $dt['tb_cliente_doc'];
}
?>

<script type="text/javascript">
    $(function () {
        $("#tabla_detalleviaje").tablesorter({
            widgets: ['zebra', 'zebraHover'],
        });
    });
</script>

<table cellspacing="1" id="tabla_detalleviaje" class="tablesorter">
    <tbody>
    <?php if ($nro_rows>0) { ?>
        <tr>
            <th align="center">Nro de <?php echo $nom_doc;?>:  </th>
            <td align="center"><?php echo $numdoc;?></td>
        </tr>
    <?php } ?>
    <tr>
        <th align="center">NOMBRE CLIENTE:</th>
        <td align="center"><?php echo $cli_nom;?> </td>
    </tr>
    <tr>
        <th align="center">DOC. CLIENTE:</th>
        <td align="center"><?php echo $cli_doc;?> </td>
    </tr>
    <?php if ($nro_rows>0) { ?>
        <tr>
            <th align="center">TOTAL:</th>
            <td align="center"><?php echo $tot;?> </td>
        </tr>
    <?php } ?>

    </tbody>
</table>