<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 14/09/2019
 * Time: 16:09
 */
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once("../../config/Cado.php");
require_once ("./cCuadromi.php");
$oCuadromi = new cCuadromi();
require_once("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once("../formatos/formatos.php");
require_once("../venta/cVenta.php");
$oVenta = new cVenta();

$y=date('Y');
$m=date('m');
$d=date('d');

$com_est='CANCELADA';
$ven_est='CANCELADA';

$dts1=$oVenta->mostrar_filtro_pendFacturas($_SESSION['puntoventa_id'],$_SESSION['empresa_id']);

$num_rows= mysql_num_rows($dts1);

?>
<script>
    $(function() {
        $('.btn_sunat').button({
            text: true
        });
    });
</script>
<table id="cuadro" class="ui-widget ui-widget-content">
    <thead>
    <tr class="ui-widget-header ">
        <th colspan="2" align="left">RESUMEN DIARIO PENDIENTES</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="2" align="left" height="50">Resúmenes pendientes de envío a SUNAT.
            <ul style="list-style: none">
                <?php
                $mostrar_envio_sunat=0;
                $estado="";
                $hoy=date('Y-m-d');
                $diasTrans=0;
                while($dt1 = mysql_fetch_array($dts1))
                {
                    $date1 = new DateTime($dt1['tb_venta_fec']);
                    $date2 = new DateTime($hoy);
                    $diff = $date1->diff($date2);
                    $diasTrans= $diff->days;

                    ?>
                    <li style="line-height: 2.5em">
                        <?php echo $dt1['tb_venta_numdoc']?>
                        <span style="color:red"> Días restantes <?php echo 8-$diasTrans; ?></span>
                        <form action="../resumenboleta/venta_vista.php" method="post">
                            <input type="hidden" name="fecha" value="07-06-2019">
                        <button type="submit" class="btn_sunat"  title="Generar">Generar</button>
                        </form>
                    </li>
                    <?php
                }
                mysql_free_result($dts1);
                ?>
            </ul>
        </td>
    </tr>
    </tbody>
</table>
