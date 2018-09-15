<?php
require_once("../../config/Cado.php");
require_once("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();
require_once("cProducto.php");
$oProducto = new cProducto();

require_once("../formatos/formato.php");
$dts=$oProducto->ultimoIdProducto();
$dt = mysql_fetch_array($dts);
$prod_id=$dt['tb_producto_id']+1;


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

    <tbody>

    <tr>
        <td valign="top">
            <div id="tabla_pre_unidad" class="ui-widget">
                <table id="tabla_prov_pro" class="ui-widget ui-widget-content">
                    <thead>
                    <tr class="ui-widget-header">
                        <th>PROVEEDOR</th>
                        <th title="UNIDAD">CANT MIN</th>
                        <th align="right" nowrap title="PRECIO DE COSTO">DESC %</th>
                        <th align="right" nowrap title="PRECIO DE COSTO">DESDE</th>
                        <th align="right" nowrap title="PRECIO DE COSTO">HASTA</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </td>
        <td valign="top">
            <a class="btn_agregar_proveedor" onClick="producto_proveedor_form('insertar',<?php echo $prod_id?>)">Agregar Proveedor
            </a>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    </tbody>
</table>