<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

if($_SESSION['usuariogrupo_id']==2)$titulo='Registrar Ventas - Administrador';
if($_SESSION['usuariogrupo_id']==3)$titulo='Registrar Ventas - Vendedor';
require_once ("../../config/Cado.php");
require_once ("../asiento/cAsiento.php");
$oAsiento = new cAsiento();

require_once ("../formatos/formato.php");

$dts1=$oAsiento->mostrarFiltroFila(1,14);
$dts2=$oAsiento->mostrarFiltroFila(15,28);
$dts3=$oAsiento->mostrarFiltroFila(29,42);
$dts4=$oAsiento->mostrarFiltroFila(43,56);
$num_rows= mysql_num_rows($dts1);

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


        $("#sortable1, #sortable2,#sortable3,#sortable4").sortable({
            placeholder:'placeholder',
            connectWith: ".connectedSortable",
            update:function () {
                //$.post('actualizar_posicion.php',$(this).sortable('serialize'));
                //alert($(this).sortable('serialize'));
            }
        }).disableSelection();

    });
</script>
<style>


    #sortable1, #sortable2,#sortable3,#sortable4 {
        border: 1px solid #eee;
        min-height: 40px;
        list-style-type: none;
        margin: 0;
        padding: 5px 0 0 0;
        /*float: left;*/
        margin-right: 10px;
    }

    #sortable1 .asiento, #sortable2 .asiento,#sortable3 .asiento,#sortable4 .asiento {
        margin: 0 5px 5px 5px;
        padding: 5px;
        font-size: 1.2em;
        width: 35px;
        height: 50px;
        cursor: move;
        position: relative;
        float: left;
    }
    .clear{
        clear: both;
        height: 20px;
    }
    #frentera{
        height: 200px;
        width: 210px;
        /*background: #0D8BBD;*/
        float: left;
    }
    #lugares{
        float: left;
        height: 200px;
        margin-top: 80px;
    }
    #pasadizo{
        height: 40px;
    }
    #bus{
        width: 1180px;
        height: 550px;
        background: url("../../images/bus_fondo.png");
        background-size: 95%;
        background-repeat: no-repeat;
        background-position-x: -52px;
    }

</style>

    <?php
    if($num_rows>=1){
        ?>
        <div id="bus">
            <div id="frentera"><!--FRENTE--></div>
            <div id="lugares">
                <div id="sortable1" class="connectedSortable">
                    <?php

                    while($dt1 = mysql_fetch_array($dts1)){?>
                       <div id="<?php echo 'item_'.$dt1['tb_asiento_id'] ?>" class="ui-state-highlight asiento"><?php echo $dt1['tb_asiento_nom']?></div>
                     <?php
                    }
                    mysql_free_result($dts1);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable2" class="connectedSortable">
                    <?php

                    while($dt1 = mysql_fetch_array($dts2)){?>
                        <div id="<?php echo 'item_'.$dt1['tb_asiento_id'] ?>" class="ui-state-highlight asiento"><?php echo $dt1['tb_asiento_nom']?></div>
                        <?php
                    }
                    mysql_free_result($dts2);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="pasadizo"></div>
                <div id="sortable3" class="connectedSortable">
                    <?php

                    while($dt1 = mysql_fetch_array($dts3)){?>
                        <div id="<?php echo 'item_'.$dt1['tb_asiento_id'] ?>" class="ui-state-highlight asiento"><?php echo $dt1['tb_asiento_nom']?></div>
                        <?php
                    }
                    mysql_free_result($dts3);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable4" class="connectedSortable">
                    <?php

                    while($dt2 = mysql_fetch_array($dts4)){?>
                        <div id="<?php echo 'item_'.$dt2['tb_asiento_id'] ?>" class="ui-state-highlight asiento"><?php echo $dt2['tb_asiento_nom']?></div>
                        <?php
                    }
                    mysql_free_result($dts4);

                    ?>
                </div>
            </div>
        </div>
        <?php


    }
    ?>

