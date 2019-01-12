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
$dts3=$oAsiento->mostrarFiltroFila(36,49);
$dts4=$oAsiento->mostrarFiltroFila(29,42);
$dts5=$oAsiento->mostrarFiltroFila(43,56);

$num_rows= mysql_num_rows($dts1);

$dts11=$oAsiento->mostrar_distribucionasiento(1);
$dts22=$oAsiento->mostrar_distribucionasiento(2);
$dts33=$oAsiento->mostrar_distribucionasiento(3);
$dts44=$oAsiento->mostrar_distribucionasiento(4);
$dts55=$oAsiento->mostrar_distribucionasiento(5);

$dt11 = mysql_fetch_array($dts11);
$dt22 = mysql_fetch_array($dts22);
$dt33 = mysql_fetch_array($dts33);
$dt44 = mysql_fetch_array($dts44);
$dt55 = mysql_fetch_array($dts55);
$orden11=$dt11['tb_distribucionasiento_lugar'];
$orden22=$dt22['tb_distribucionasiento_lugar'];
$orden33=$dt33['tb_distribucionasiento_lugar'];
$orden44=$dt44['tb_distribucionasiento_lugar'];
$orden55=$dt55['tb_distribucionasiento_lugar'];


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


        $('.pasadizo >div').addClass('oculto');
        $('.pasadizo >div:last').removeClass('oculto');


        $("#sortable1, #sortable2,#sortable3,#sortable4, #sortable5").sortable({
            placeholder:'placeholder',
            connectWith: ".connectedSortable",
            update:function () {
                //$.post('../asiento/actualizar_posicion.php',$(this).sortable('serialize'));
                $.ajax(
                    {
                        type: "POST",
                        url: "../asiento/actualizar_posicion.php",
                        data:
                            {
                                sort1:(($("#sortable1").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                sort2:(($("#sortable2").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                sort3:(($("#sortable3").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                sort4:(($("#sortable4").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                sort5:(($("#sortable5").sortable('toArray')).join(';')).split('"').pop().split('"')[0]
                            },
                        success: function(html)
                        {
                            $('.success').fadeIn(500);
                            $('.success').fadeOut(500);
                        }
                    });
            }
        }).disableSelection();

    });
</script>
<style>

    .oculto{
        visibility: hidden;
    }
    #sortable1, #sortable2,#sortable3,#sortable4,#sortable5 {
        border: 1px solid #eee;
        min-height: 40px;
        list-style-type: none;
        margin: 0;
        padding: 5px 0 0 0;
        /*float: left;*/
        margin-right: 10px;
    }

    #sortable1 .asiento, #sortable2 .asiento,#sortable3 .asiento,#sortable4 .asiento,#sortable5 .asiento {
        margin: 0 5px 5px 5px;
        padding: 5px;
        font-size: 1.2em;
        width: 35px;
        height: 50px;
        cursor: move;
        position: relative;
        float: left;
        background: #00aa00;
    }

    .clear{
        clear: both;
    }
    #frentera{
        height: 200px;
        width: 220px;
        /*background: #0D8BBD;*/
        float: left;
    }
    #lugares{
        float: left;
        height: 200px;
        margin-top: 100px;
    }
    .pasadizo{
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
                    if($orden11==""){
                        while($dt1 = mysql_fetch_array($dts1)){?>
                           <div id="<?php echo 'item_'.$dt1['tb_asiento_nom'] ?>" class="asiento"><?php echo $dt1['tb_asiento_nom']?></div>
                    <?php
                        }
                    }else{
                        $lugares = explode(';',$orden11);

                        foreach ($lugares as $lugar) {
                            ?>
                                <div id="<?php echo $lugar ?>" class="asiento"><?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                            }
                         }
                    mysql_free_result($dts1);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable2" class="connectedSortable">
                    <?php
                    if($orden22==""){
                        while($dt1 = mysql_fetch_array($dts2)){?>
                            <div id="<?php echo 'item_'.$dt1['tb_asiento_nom'] ?>" class="asiento"><?php echo $dt1['tb_asiento_nom']?></div>
                            <?php
                        }
                    }else{
                        $lugares = explode(';',$orden22);

                        foreach ($lugares as $lugar) {
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento"><?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                        }
                    }
                    mysql_free_result($dts2);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable3" class="connectedSortable pasadizo">
                    <?php
                    if($orden33==""){
                        while($dt1 = mysql_fetch_array($dts3)){?>
                            <div id="<?php echo 'item_'.$dt1['tb_asiento_nom'] ?>" class="asiento"><?php echo $dt1['tb_asiento_nom']?></div>
                            <?php
                        }
                    }else{

                        $lugares = explode(';',$orden33);

                        foreach ($lugares as $lugar) {
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento"><?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                        }
                    }
                    mysql_free_result($dts3);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable4" class="connectedSortable">
                    <?php
                    if($orden44==""){
                        while($dt1 = mysql_fetch_array($dts4)){?>
                            <div id="<?php echo 'item_'.$dt1['tb_asiento_nom'] ?>" class="asiento"><?php echo $dt1['tb_asiento_nom']?></div>
                            <?php
                        }
                    }else{
                        $lugares = explode(';',$orden44);

                        foreach ($lugares as $lugar) {
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento"><?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                        }
                    }
                    mysql_free_result($dts4);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable5" class="connectedSortable">
                    <?php
                    if($orden55==""){
                        while($dt1 = mysql_fetch_array($dts5)){?>
                            <div id="<?php echo 'item_'.$dt1['tb_asiento_id'] ?>" class="asiento"><?php echo $dt1['tb_asiento_nom']?></div>
                            <?php
                        }
                    }else{
                        $lugares = explode(';',$orden55);

                        foreach ($lugares as $lugar) {
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento"><?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                        }
                    }
                    mysql_free_result($dts5);

                    ?>
                </div>
            </div>
        </div>
        <?php


    }
    ?>

