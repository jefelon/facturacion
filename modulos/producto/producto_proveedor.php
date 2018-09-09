<?php
require_once("../../config/Cado.php");
require_once("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();
require_once("cProducto.php");
$oProducto = new cProducto();

require_once("../formatos/formato.php");

?>

<script type="text/javascript">
    $(function () {
        $('.btn_editar').button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });

        $('.btn_agregar_proveedor').button({
            icons: {primary: "ui-icon-plus"},
            text: false
        });

        $('.btn_eliminar').button({
            icons: {primary: "ui-icon-trash"},
            text: false
        });
    });
</script>
<style>
    div#tabla_pre_unidad {
        margin: 0 0;
    }

    div#tabla_pre_unidad table {
        margin: 0 0;
        border-collapse: collapse;
        width: 100%;
    }

    div#tabla_pre_unidad table td, div#tabla_pre_unidad table th {
        border: 1px solid #eee;
        padding: 2px 3px;
        font-size: 10px;
    }

    div#tabla_pre_unidad table th {
        height: 16px
    }
</style>
<table cellspacing="0">
    <?php
    $dts1 = $oProducto->mostrar_por_proveedor($_POST['pro_id']);
    $num_rows = mysql_num_rows($dts1);
    if ($num_rows >= 1) {
        $num_pre = 0;
        ?>
        <tbody>

        <tr>
            <td valign="top">
                <div id="tabla_pre_unidad" class="ui-widget">
                    <table class="ui-widget ui-widget-content">
                        <thead>
                        <tr class="ui-widget-header">
                            <th>PROVEEDOR</th>
                            <th title="UNIDAD">CANT MIN</th>
                            <th align="right" nowrap title="PRECIO DE COSTO">DESC %</th>
                            <th align="right" nowrap title="PRECIO DE COSTO">DESDE</th>
                            <th align="right" nowrap title="PRECIO DE COSTO">HASTA</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="even">
                            <?php
                            while ($dt1 = mysql_fetch_array($dts1)){
                            $num_pre++;
                            ?>
                            <td><?php echo $num_pre . '.- ' . $dt1['tb_proveedor_nom'] ?></td>
                            <td><?php echo $dt1['tb_productoproveedor_cantmin'] ?></td>
                            <td><?php echo $dt1['tb_productoproveedor_desc'] ?></td>
                            <td><?php echo $dt1['tb_productoproveedor_fechaini'] ?></td>
                            <td><?php echo $dt1['tb_productoproveedor_fechafin'] ?></td>
                            <td>
                                <a class="btn_editar"
                                   onClick="producto_proveedor_form('editar','<?php echo $dt1['tb_productoproveedor_id'] ?>')">Editar
                                    Unidad</a>
                                <?php if ($dt1['tb_productoproveedor_id'] != 1) { ?>
                                    <a class="btn_eliminar"
                                       onClick="eliminar_catalogo(<?php echo $dt1['tb_productoproveedor_id'] ?>)">Eliminar
                                        Unidad</a>
                                <?php } ?>
                            </td>

                        </tr>
                        <?php
                        }
                        mysql_free_result($dts1);
                        ?>
                        </tbody>
                    </table>
                </div>
            </td>
            <td valign="top">
                <a class="btn_agregar_proveedor" onClick="producto_proveedor_form('insertar',6)">Agregar Proveedor
                </a>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        </tbody>
        <?php
    }
    ?>
</table>