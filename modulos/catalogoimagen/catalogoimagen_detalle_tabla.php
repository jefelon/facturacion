<?php
require_once ("../../config/Cado.php");
require_once ("cCatalogoimagen.php");
$oCatimagen = new cCatalogoimagen();

$dts=$oCatimagen->mostrar_todo_det($_POST['catimg_id']);
$num_rows= mysql_num_rows($dts);

?>
<script type="text/javascript">
$(function() {  
    $('.btn_editar').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });
    
    $('.btn_eliminar').button({
        icons: {primary: "ui-icon-trash"},
        text: false
    });

    $('#btn_agregar_producto').button({
    icons: {primary: "ui-icon-plus"},
    text: true
    });

    $.tablesorter.defaults.widgets = ['zebra'];
    $("#tabla_marca").tablesorter({ 
        headers: {
            1: {sorter: false }, 
            2: { sorter: false}},
        //sortForce: [[0,0]],
        sortList: [[0,0]]
    });
}); 
</script>

<!--     <a href="#" id="btn_agregar_producto" title="Abrir Catálogo" onClick="catalogo_catalogoimagen_tab()">Seleccionar Producto</a> -->


        <table cellspacing="1" id="tabla_catalogo_imagen" class="tablesorter">
            <thead>
                <tr>                
                    <th align="right">CODIGO</th>
                    <th>NOMBRE</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        <?php
        if($num_rows>=1){
        ?>  
            <tbody>
            <?php
            while($dt = mysql_fetch_array($dts)){
            ?>
                <tr class="even">
                <td><?php echo $dt['tb_presentacion_cod']?></td>
                <td><?php echo $dt['tb_producto_nom']?></td>             
                <td align="center"><a class="btn_eliminar" href="#eli" onClick="eliminar_catalogoimagendetalle('<?php echo $dt['tb_catalogoimagendetalle_id']?>')">Eliminar</a></td>
                </tr>
            <?php
                }
                mysql_free_result($dts);
            ?>
            </tbody>
        <?php
        }
        ?>
                <tr class="even">
                  <td colspan="3"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>