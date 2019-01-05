<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

if($_SESSION['usuariogrupo_id']==2)$titulo='Registrar Ventas - Administrador';
if($_SESSION['usuariogrupo_id']==3)$titulo='Registrar Ventas - Vendedor';
require_once ("../../config/Cado.php");
require_once ("../producto/cProducto.php");
$oProducto = new cProducto();

require_once ("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");


$dts1=$oProducto->mostrar_filtro2('Activo');
$num_rows= mysql_num_rows($dts1);

//orden
if($_POST['ordby']=='tb_producto_mod DESC')$sort='[5,1]';
if($_POST['ordby']=='tb_producto_nom')$sort='[0,0]';
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.btn_presentacion').button({
            icons: {primary: "ui-icon-clipboard"},
            text: false
        });
        $('.btn_editar').button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });

        $('.btn_eliminar').button({
            icons: {primary: "ui-icon-trash"},
            text: false
        });

        $.tablesorter.defaults.widgets = ['zebra'];
        $("#tabla_producto").tablesorter({
            headers: {
                4: {sorter: 'shortDate' },
                7: {sorter: false },
                8: { sorter: false}
            },
            //sortForce: [[0,0]],
            <?php if($num_rows>0){?>
            sortList: [<?php echo $sort?>]
            <?php }?>
        });
    });
</script>

<table cellspacing="1" id="tabla_producto" class="tablesorter">
    <thead>
    <tr>
        <th>CODIGO</th>
        <th>NOMBRE</th>
        <th>DESCRIPCION</th>
        <th>MARCA</th>
        <th>CATEGORIA</th>
        <th>TIPO AFECT.</th>
        <th>LOTE</th>
        <th>MODIFICACION</th>
        <th>ESTADO</th>
        <th align="center" title="N° PRESENTACIONES">PRES</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <?php
    if($num_rows>=1){
        ?>
        <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){?>
            <tr>
                <td><?php echo $dt1['tb_presentacion_cod']?></td>
                <td><?php echo $dt1['tb_producto_nom']?></td>
                <td><?php echo $dt1['tb_producto_des']?></td>
                <td><?php echo $dt1['tb_marca_nom']?></td>
                <td><?php echo $dt1['tb_categoria_nom']?></td>
                <td><?php if ($dt1['tb_afectacion_id']=='1') echo 'Gravado'; if ($dt1['tb_afectacion_id']=='9') echo 'Exonerado'; if ($dt1['tb_afectacion_id']=='11') echo 'Inafecto'?></td>
                <td><?php echo $dt1['tb_producto_lote']?></td>
                <td><?php echo mostrarFechaHora($dt1['tb_producto_mod'])?></td>
                <td><?php echo $dt1['tb_producto_est']?></td>
                <td align="center"><?php
                    $dts2=$oPresentacion->mostrar_por_producto($dt1['tb_producto_id']);
                    echo mysql_num_rows($dts2);
                    mysql_free_result($dts2);
                    ?></td>
                <td align="center" nowrap><a class="btn_editar" href="#editar" onClick="producto_form('editar','<?php echo $dt1['tb_producto_id']?>')">Editar</a><a class="btn_eliminar" href="#eliminar" onClick="eliminar_producto('<?php echo $dt1['tb_producto_id']?>')"> Eliminar</a></td>
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
        <td colspan="8"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>
