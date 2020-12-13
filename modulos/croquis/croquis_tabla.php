<?php
require_once ("../../config/Cado.php");
require_once ("cCroquis.php");
$oCroquis = new cCroquis();

$dts=$oCroquis->mostrarTodos();
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

        $('.btn_croquis').button({
            icons: {primary: "ui-icon-grip-dotted-horizontal"},
            text: false
        });

        $.tablesorter.defaults.widgets = ['zebra'];
        $("#tabla_croquis").tablesorter({
            headers: {
                1: {sorter: false },
                2: { sorter: false}},
            //sortForce: [[0,0]],
            sortList: [[0,0]]
        });
    });
</script>
<table cellspacing="1" id="tabla_croquis" class="tablesorter">
    <thead>
    <tr>
        <th>Codigo</th>
        <th>Vehículo</th>
        <th>Editar Croquis</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>
    </thead>
    <?php
    if($num_rows>=1){
        ?>
        <tbody>
        <?php
        while($dt = mysql_fetch_array($dts)){
            ?>
            <tr>
                <td> <?php echo $dt['tb_croquis_id'] ?>  </td>
                <td><?php echo $dt['tb_vehiculo_id']. ' '.$dt['tb_vehiculo_marca']. ' - '.$dt['tb_vehiculo_placa'].' de '.$dt['tb_vehiculo_numasi'].' Asientos.' ?></td>
                <td align="center"><a class="btn_croquis" href="#" onClick="croquis_distribucion_form('editar_croquis','<?php echo $dt['tb_croquis_id']?>','<?php echo $dt['tb_vehiculo_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_editar" href="#" onClick="croquis_form('editar','<?php echo $dt['tb_croquis_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar_croquis('<?php echo $dt['tb_croquis_id']?>','<?php echo $dt['tb_vehiculo_id']?>')">Eliminar</a></td>
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