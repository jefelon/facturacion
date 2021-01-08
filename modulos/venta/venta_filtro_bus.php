<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../asiento/cAsiento.php");
$oAsiento = new cAsiento();

require_once ("../formatos/formato.php");

$fecha_salida=fecha_mysql($_POST['cmb_fech_sal']);
$hora_salida=$_POST['cmb_horario'];
$piso=$_POST['piso'];

$dts1=$oAsiento->mostrar_distribucionasiento(1,$piso, $_POST['txt_vehiculo_id']);
$dts2=$oAsiento->mostrar_distribucionasiento(2,$piso, $_POST['txt_vehiculo_id']);
$dts3=$oAsiento->mostrar_distribucionasiento(3,$piso, $_POST['txt_vehiculo_id']);
$dts4=$oAsiento->mostrar_distribucionasiento(4,$piso, $_POST['txt_vehiculo_id']);
$dts5=$oAsiento->mostrar_distribucionasiento(5,$piso, $_POST['txt_vehiculo_id']);

$num_rows= mysql_num_rows($dts1);

$dt1 = mysql_fetch_array($dts1);
$dt2 = mysql_fetch_array($dts2);
$dt3 = mysql_fetch_array($dts3);
$dt4 = mysql_fetch_array($dts4);
$dt5 = mysql_fetch_array($dts5);
$orden1=$dt1['tb_distribucionasiento_lugar'];
$orden2=$dt2['tb_distribucionasiento_lugar'];
$orden3=$dt3['tb_distribucionasiento_lugar'];
$orden4=$dt4['tb_distribucionasiento_lugar'];
$orden5=$dt5['tb_distribucionasiento_lugar'];

$estado_filas1=$dt1['tb_distribucionasiento_estado'];
$estado_filas2=$dt2['tb_distribucionasiento_estado'];
$estado_filas3=$dt3['tb_distribucionasiento_estado'];
$estado_filas4=$dt4['tb_distribucionasiento_estado'];
$estado_filas5=$dt5['tb_distribucionasiento_estado'];


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

        if($('.pasadizo >div:last').is("#item_45")){
            $('.pasadizo >div:last').css("margin-left","-45px");
        }
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

    function seleccionar(selector) {
        $('.seleccionado').removeClass('seleccionado');

            $(selector).addClass('seleccionado');

    }



    $(function () {

    });
</script>
<style>

    .oculto{
        visibility: hidden;
    }
    .seleccionado {
        background: orange !important;
        color: white;
    }

    .reserva{
        background: #dd09ff !important;
        color: white;
    }
    .ocupado {
        background: red !important;
        color: white;
    }
    #sortable1, #sortable2,#sortable3,#sortable4,#sortable5 {
        min-height: 40px;
        list-style-type: none;
        margin: 0;
        padding: 5px 0 0 0;
        /*float: left;*/
        margin-right: 10px;
        float: left;
    }

    #sortable1 table tr td, #sortable2 table tr td,#sortable3 table tr td,#sortable4 table tr td,#sortable5 table tr td{
        padding: 0;
    }
    #sortable1 .asiento, #sortable2 .asiento,#sortable3 .asiento,#sortable4 .asiento,#sortable5 .asiento {
        margin: 0 2px 5px 5px;
        padding: 5px;
        font-size: 1.2em;
        width: 35px;
        height: 42px;
        position: relative;
        float: left;
        background: #00aa00;
    }
    .opciones{
        margin: 5px 0px;
        font-size: 1.2em;
        width: 41px;
        height: 55px;
        float: left;
        background: #00b8ff;
        float: right;
        color: #fff;
        text-align: center;
    }

    .clear{
        clear: both;
    }
    #frentera {
    <?php
    if($estado_filas1=="0" || $estado_filas2=="0" || $estado_filas3=="0" || $estado_filas4=="0" || $estado_filas5=="0")
    {
        echo "height: 299px;";
        echo "width: 92px;";
    }
    else
    {
        echo "height: 372px;";
        echo "width: 114px;";
    }

    ?>
        background: url(../../images/frente-bus.jpg);
        float: left;
        background-size: contain;
        background-repeat: no-repeat;
        background-color: yellow;
    }
    #atras {
    <?php
    if($estado_filas1=="0" || $estado_filas2=="0" || $estado_filas3=="0" || $estado_filas4=="0" || $estado_filas5=="0")
    {
        echo "height: 273px;";
        echo "width: 44px;";
    }
    else
    {
        echo "height: 345px;";
        echo "width: 44px;";
    }
    ?>
        background: url(../../images/atras-bus.jpg);
        float: left;
        background-size: contain;
        background-repeat: no-repeat;
        margin-top: 13px;
    }
    #lugares{
        float: left;
    <?php
    if($estado_filas1=="0" || $estado_filas2=="0" || $estado_filas3=="0" || $estado_filas4=="0" || $estado_filas5=="0")
    {
        echo "margin-top: 20px;";
    }
    else
    {
        echo "margin-top: 24px;";
    }
    ?>
        background: #e4eaea;
        overflow: hidden;
    }
    .pasadizo{
        height: auto;
        padding: 0 !important;
    }
    #bus{
        width: 1000px;
        /*height: 550px;*/
        /*!*background: url("../../images/bus_fondo.png");*!*/
        /*background-size: 95%;*/
        /*background-repeat: no-repeat;*/
        /*background-position-x: -52px;*/
    }
    .o{
        background: #f5f5f5 !important
    }
    .d{
        background: #e4eaea !important;
        color: #e4eaea;
        /*visibility: hidden;*/
    }
    .tv {
        width: 45px !important;
        height: 55px !important;
        background: url(../../images/tv2.png) !important;
        padding: 0 !important;
        color: transparent;
        background-size: contain !important;
        background-repeat: no-repeat !important;
        padding: 0px !important;
        position: relative;
    <?php
        if($estado_filas1==1){
            echo "top: 33px;";
        }
        else{
            echo "top: 50px;";
        }
    ?>
        z-index: 2;
    }
    .g {
        width: 47px !important;
        height: 50px !important;
        background: url(../../images/grada.png) !important;
        background-size: 100% !important;
        padding: 0 !important;
        color: transparent;
    }
    .b {
        width: 33px !important;
        height: 50px !important;
        background: url(../../images/banio.png) !important;
        background-size: 100% !important;
        padding: 0 !important;
        color: transparent;
    }
    .seleccionado {
        background: orange !important;
        color: white;
    }

</style>
<div id="frentera"><!--FRENTE--></div>
<div id="lugares">
    <?php if($estado_filas1==1){ ?>
        <div id="sortable1" class="connectedSortable">
            <table><tr>
            <?php
            if($orden1!=""){ //solo si hay distribucion creada
                $lugares = explode(';',$orden1);
                foreach ($lugares as $lugar) {
                    $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                    $asts = $oAsiento->mostrarNombreEstado($lugar[1], $_POST['txt_vehiculo_id'], $fecha_salida, $hora_salida);
                    $ast = mysql_fetch_array($asts);
                    ?>
                    <td>
                    <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>"
                         oncontextmenu="click_derecho(event,$(this),<?php echo $ast['tb_clientereserva_id'] ?>); return false;"
                         class="asiento <?php echo $lugar[2] ?>
                            <?php
                             if ($ast['tb_asientoestado_id']) {
                                 if ($ast['tb_asientoestado_reserva'] == 1) {
                                     echo 'reserva';
                                 } else {
                                     echo 'ocupado';
                                 }
                             }
                             ?>"
                         onclick="cambiar_color(this)">
                        <div class="" style="padding-left: 4px;">
                            <?php echo $lugar[1] ?>
                        </div>

                        <div class=""
                             style="background-color: <?php echo $ast['tb_lugar_color']; ?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                     width: 34px;">
                            <?php echo substr($ast['tb_lugar_nom'], 0, 2) ?>
                        </div>
                    </div>
                    </td>
                    <?php
                }
            }
            mysql_free_result($dts1);
            ?>
            </tr></table>
        </div>
        <div class="clear"></div>
    <?php }?>
    <?php if($estado_filas2==1){?>
        <div id="sortable2" class="connectedSortable">
            <table><tr>
            <?php
            if($orden2!=""){ //solo si hay distribucion creada
                $lugares = explode(';',$orden2);
                foreach ($lugares as $lugar) {
                    $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                    $asts = $oAsiento->mostrarNombreEstado($lugar[1], $_POST['txt_vehiculo_id'], $fecha_salida, $hora_salida);
                    $ast = mysql_fetch_array($asts);
                    ?>
                    <td>
                    <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>"
                         oncontextmenu="click_derecho(event,$(this),<?php echo $ast['tb_clientereserva_id'] ?>); return false;"
                         class="asiento <?php echo $lugar[2] ?>
                            <?php
                         if ($ast['tb_asientoestado_id']) {
                             if ($ast['tb_asientoestado_reserva'] == 1) {
                                 echo 'reserva';
                             } else {
                                 echo 'ocupado';
                             }
                         }
                         ?>"
                         onclick="cambiar_color(this)">
                        <div class="" style="padding-left: 4px;">
                            <?php echo $lugar[1] ?>
                        </div>

                        <div class=""
                             style="background-color: <?php echo $ast['tb_lugar_color']; ?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                     width: 34px;">
                            <?php echo substr($ast['tb_lugar_nom'], 0, 2) ?>
                        </div>
                    </div>
                    </td>
                    <?php
                }
            }

            mysql_free_result($dts2);

            ?>
            </tr></table>
        </div>
        <div class="clear"></div>
    <?php }?>
    <?php if($estado_filas3==1){?>
        <div id="sortable3" class="connectedSortable pasadizo">
            <table><tr>
            <?php
            if($orden3!=""){ //solo si hay distribucion creada
                $lugares = explode(';',$orden3);
                foreach ($lugares as $lugar) {
                    $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                    $asts = $oAsiento->mostrarNombreEstado($lugar[1], $_POST['txt_vehiculo_id'], $fecha_salida, $hora_salida);
                    $ast = mysql_fetch_array($asts);
                    ?>
                    <td>
                    <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>"
                         oncontextmenu="click_derecho(event,$(this),<?php echo $ast['tb_clientereserva_id'] ?>); return false;"
                         class="asiento <?php echo $lugar[2] ?>
                            <?php
                         if ($ast['tb_asientoestado_id']) {
                             if ($ast['tb_asientoestado_reserva'] == 1) {
                                 echo 'reserva';
                             } else {
                                 echo 'ocupado';
                             }
                         }
                         ?>"
                         onclick="cambiar_color(this)">
                        <div class="" style="padding-left: 4px;">
                            <?php echo $lugar[1] ?>
                        </div>

                        <div class=""
                             style="background-color: <?php echo $ast['tb_lugar_color']; ?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                     width: 34px;">
                            <?php echo substr($ast['tb_lugar_nom'], 0, 2) ?>
                        </div>
                    </div>
                    </td>
                    <?php
                }
            }
            mysql_free_result($dts3);
            ?>
            </tr></table>
        </div>
        <div class="clear"></div>
    <?php }?>
    <?php if($estado_filas4==1){?>
        <div id="sortable4" class="connectedSortable">
            <table><tr>
            <?php
            if($orden4!=""){ //solo si hay distribucion creada
                $lugares = explode(';',$orden4);
                foreach ($lugares as $lugar) {
                    $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                    $asts = $oAsiento->mostrarNombreEstado($lugar[1], $_POST['txt_vehiculo_id'], $fecha_salida, $hora_salida);
                    $ast = mysql_fetch_array($asts);
                    ?>
                    <td>
                    <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>"
                         oncontextmenu="click_derecho(event,$(this),<?php echo $ast['tb_clientereserva_id'] ?>); return false;"
                         class="asiento <?php echo $lugar[2] ?>
                            <?php
                         if ($ast['tb_asientoestado_id']) {
                             if ($ast['tb_asientoestado_reserva'] == 1) {
                                 echo 'reserva';
                             } else {
                                 echo 'ocupado';
                             }
                         }
                         ?>"
                         onclick="cambiar_color(this)">
                        <div class="" style="padding-left: 4px;">
                            <?php echo $lugar[1] ?>
                        </div>

                        <div class=""
                             style="background-color: <?php echo $ast['tb_lugar_color']; ?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                     width: 34px;">
                            <?php echo substr($ast['tb_lugar_nom'], 0, 2) ?>
                        </div>
                    </div>
                    </td>
                    <?php
                }
            }
            mysql_free_result($dts4);
            ?>
            </tr></table>
        </div>
        <div class="clear"></div>
    <?php }?>
    <?php if($estado_filas5==1){?>
        <div id="sortable5" class="connectedSortable">
            <table><tr>
            <?php
            if($orden5!=""){ //solo si hay distribucion creada
                $lugares = explode(';',$orden5);
                foreach ($lugares as $lugar) {
                    $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                    $asts = $oAsiento->mostrarNombreEstado($lugar[1], $_POST['txt_vehiculo_id'], $fecha_salida, $hora_salida);
                    $ast = mysql_fetch_array($asts);
                    ?>
                    <td>
                    <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>"
                         oncontextmenu="click_derecho(event,$(this),<?php echo $ast['tb_clientereserva_id'] ?>); return false;"
                         class="asiento <?php echo $lugar[2] ?>
                            <?php
                         if ($ast['tb_asientoestado_id']) {
                             if ($ast['tb_asientoestado_reserva'] == 1) {
                                 echo 'reserva';
                             } else {
                                 echo 'ocupado';
                             }
                         }
                         ?>"
                         onclick="cambiar_color(this)">
                        <div class="" style="padding-left: 4px;">
                            <?php echo $lugar[1] ?>
                        </div>

                        <div class=""
                             style="background-color: <?php echo $ast['tb_lugar_color']; ?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                     width: 34px;">
                            <?php echo substr($ast['tb_lugar_nom'], 0, 2) ?>
                        </div>
                    </div>
                    </td>
                    <?php
                }
            }
            mysql_free_result($dts5);
            ?>
            </tr></table>
    </div>
    <?php }?>
</div>
<div id="atras"><!--atras--></div>
<div class="clear"></div>

