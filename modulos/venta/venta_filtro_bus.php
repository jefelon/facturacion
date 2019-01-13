<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../asiento/cAsiento.php");
$oAsiento = new cAsiento();

require_once ("../formatos/formato.php");

$dts1=$oAsiento->mostrarFiltroFila(1,14, $_POST['txt_vehiculo_id']);
$dts2=$oAsiento->mostrarFiltroFila(15,28, $_POST['txt_vehiculo_id']);
$dts3=$oAsiento->mostrarFiltroFila(36,49, $_POST['txt_vehiculo_id']);
$dts4=$oAsiento->mostrarFiltroFila(29,42, $_POST['txt_vehiculo_id']);
$dts5=$oAsiento->mostrarFiltroFila(43,56, $_POST['txt_vehiculo_id']);

$num_rows= mysql_num_rows($dts1);

$dts11=$oAsiento->mostrar_distribucionasiento(1,1, $_POST['txt_vehiculo_id']);
$dts22=$oAsiento->mostrar_distribucionasiento(2,1, $_POST['txt_vehiculo_id']);
$dts33=$oAsiento->mostrar_distribucionasiento(3,1, $_POST['txt_vehiculo_id']);
$dts44=$oAsiento->mostrar_distribucionasiento(4,1, $_POST['txt_vehiculo_id']);
$dts55=$oAsiento->mostrar_distribucionasiento(5,1, $_POST['txt_vehiculo_id']);

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




    });

    function cambiar_color(selector) {
        $('.seleccionado').removeClass('seleccionado');
        if  ($(selector).hasClass('ocupado')){
            alert('Esta ocupado!!!');
        }else {
            $(selector).addClass('seleccionado');
        }

        $('#txt_precio').focus();

    }




    $(function () {

    });
</script>
<style>

    /*.oculto{*/
        /*visibility: hidden;*/
    /*}*/

    /*.seleccionado, .ocupado {*/
        /*background-color: orange !important;*/
        /*color: white;*/
    /*}*/
    /*#sortable1, #sortable2,#sortable3,#sortable4,#sortable5 {*/
        /*border: 1px solid #eee;*/
        /*min-height: 40px;*/
        /*list-style-type: none;*/
        /*margin: 0;*/
        /*padding: 5px 0 0 0;*/
        /*!*float: left;*!*/
        /*margin-right: 10px;*/
    /*}*/

    /*#sortable1 .asiento, #sortable2 .asiento,#sortable3 .asiento,#sortable4 .asiento,#sortable5 .asiento {*/
        /*margin: 0 5px 5px 5px;*/
        /*padding: 5px;*/
        /*font-size: 1.2em;*/
        /*width: 35px;*/
        /*height: 50px;*/
        /*cursor: move;*/
        /*position: relative;*/
        /*float: left;*/
        /*background: #00aa00;*/
    /*}*/

    /*.clear{*/
        /*clear: both;*/
    /*}*/
    /*#frentera{*/
        /*height: 200px;*/
        /*width: 220px;*/
        /*!*background: #0D8BBD;*!*/
        /*float: left;*/
    /*}*/
    /*#lugares{*/
        /*float: left;*/
        /*height: 200px;*/
        /*margin-top: 100px;*/
    /*}*/
    /*.pasadizo{*/
        /*height: 40px;*/
    /*}*/
    /*#bus{*/
        /*width: 1180px;*/
        /*height: 550px;*/
        /*background: url("../../images/bus_fondo.png");*/
        /*background-size: 95%;*/
        /*background-repeat: no-repeat;*/
        /*background-position-x: -52px;*/
    /*}*/

</style>



            <?php
            if($num_rows>=1){
            ?>
            <div id="frentera"><!--FRENTE--></div>
            <div id="lugares">
                <div id="sortable1" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden11);
                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombre($nom_lugar,$_POST['txt_vehiculo_id']);
                            $ast = mysql_fetch_array($asts);

                            ?>

                                <div id="<?php echo $lugar ?>" class="asiento <?php if ($ast['tb_estado']){echo 'ocupado';}?>"
                                     onclick="cambiar_color(this)">
                                    <?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                        }
                    mysql_free_result($dts1);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable2" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden22);

                        foreach ($lugares as $lugar) {
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento" onclick="cambiar_color(this)"><?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                        }

                    mysql_free_result($dts2);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable3" class="connectedSortable pasadizo">
                    <?php
                    $lugares = explode(';',$orden33);

                        foreach ($lugares as $lugar) {
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento" onclick="cambiar_color(this)"><?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                        }
                    mysql_free_result($dts3);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable4" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden44);

                        foreach ($lugares as $lugar) {
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento" onclick="cambiar_color(this)"><?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                        }

                    mysql_free_result($dts4);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable5" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden55);

                        foreach ($lugares as $lugar) {
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento" onclick="cambiar_color(this)"><?php echo explode('_',$lugar)[1] ?></div>
                            <?php
                        }
                    mysql_free_result($dts5);

                    ?>
                </div>
                <?php
            }?>

