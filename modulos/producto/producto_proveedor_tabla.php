<?php
require_once("../../config/Cado.php");
require_once("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();
require_once("cProducto.php");
$oProducto = new cProducto();

require_once("../formatos/formato.php");
$dts=$oProducto->mostrarUno($_POST['pro_id']);
$dt = mysql_fetch_array($dts);
$prod_id=$dt['tb_producto_id'];


?>

<script type="text/javascript">
    $(function () {
        $('.btn_editar').button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });

        $('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
        });
        
        $('.btn_agregar_proveedor').button({
            icons: {primary: "ui-icon-plus"},
            text: false
        });

        $( "#div_producto_proveedor_form" ).dialog({
            title:'Información de Proveedor para el producto',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 600,
            position: 'top',
            modal: true,
            buttons: {
                Guardar: function() {
                    $("#for_prodprov").submit();
                },
                Cancelar: function() {
                    $('#for_prodprov').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            }
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
<div id="tabla_pre_unidad" class="ui-widget">
    <table id="tabla_prov_pro" class="ui-widget ui-widget-content">
        <thead>
        <tr class="ui-widget-header">
            <th>PROVEEDOR</th>
            <th title="UNIDAD">CANT MIN </th>
            <th align="right" nowrap title="PRECIO DE COSTO">DESC %</th>
            <th align="right" nowrap title="PRECIO DE COSTO">DESDE</th>
            <th align="right" nowrap title="PRECIO DE COSTO">HASTA</th>
            <th align="right" nowrap title="Agregar"> <a class="btn_agregar_proveedor" onClick="producto_proveedor_form('insertar',<?php echo $prod_id?>)">Agregar Proveedor
                </a></th>
            <div id="div_producto_proveedor_form">
            </div>
        </tr>
        </thead>
        <?php
        $dts1 = $oProducto->mostrar_por_proveedor($prod_id);
        $num_rows = mysql_num_rows($dts1);
        $num_pre = 0;
        ?>

        <tbody>
        <?php
        while ($dt1 = mysql_fetch_array($dts1)) {
            ?>
            <tr>
            <td><?php echo $dt1['tb_proveedor_nom'] ?></td>
            <td><?php echo $dt1['tb_productoproveedor_cantmin'] ?></td>
            <td><?php echo $dt1['tb_productoproveedor_desc'] ?></td>
            <td><?php echo $dt1['tb_productoproveedor_fechaini'] ?></td>
            <td><?php echo $dt1['tb_productoproveedor_fechafin'] ?></td>
            <td><a class="btn_eliminar" onClick="eliminar_productoproveedor('<?php echo $dt1['tb_productoproveedor_id']?>')"> Eliminar Registro</a></td>
            </tr><?php
        }
        ?>
        </tbody>
    </table>

</div>
