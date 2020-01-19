<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once("../../config/Cado.php");

require_once("../contenido/contenido.php");
$oContenido = new cContenido();

if($_SESSION['usuariogrupo_id']==2)$titulo='Registrar Ventas - Administrador';
if($_SESSION['usuariogrupo_id']==3)$titulo='Registrar Ventas - Vendedor';
require_once("../../config/Cado.php");
require_once("../asiento/cAsiento.php");
$oAsiento = new cAsiento();
require_once("../vehiculo/cVehiculo.php");
$oVehiculo= new cVehiculo();
require_once("../formatos/formato.php");
$vehiculo_id=$_POST["veh_id"];
$piso=$_POST["piso"];

$dts1=$oAsiento->mostrar_distribucionasiento(1,$piso, $vehiculo_id);
$dts2=$oAsiento->mostrar_distribucionasiento(2,$piso, $vehiculo_id);
$dts3=$oAsiento->mostrar_distribucionasiento(3,$piso, $vehiculo_id);
$dts4=$oAsiento->mostrar_distribucionasiento(4,$piso, $vehiculo_id);
$dts5=$oAsiento->mostrar_distribucionasiento(5,$piso, $vehiculo_id);

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

        $('.btn_desactivar').button({
            icons: {primary: "ui-icon-close"},
            text: false
        });

        $('.btn_activar').button({
            icons: {primary: "ui-icon-check"},
            text: false
        });




        // $('.pasadizo >div').addClass('oculto');
        // $('.pasadizo >div:last').removeClass('oculto');


        $("#sortable1, #sortable2,#sortable3,#sortable4, #sortable5").sortable({
            placeholder:'placeholder',
            connectWith: ".connectedSortable",
            update:function () {
                $.ajax(
                    {
                        type: "POST",
                        url: "../croquis/croquis_actualizar_posicion.php",
                        data:
                            {
                                <?php if($estado_filas1=='1'){?>
                                sort1:(($("#sortable1").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                <?php }?>
                                <?php if($estado_filas2=='1'){?>
                                sort2:(($("#sortable2").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                <?php }?>
                                <?php if($estado_filas3=='1'){?>
                                sort3:(($("#sortable3").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                <?php }?>
                                <?php if($estado_filas4=='1'){?>
                                sort4:(($("#sortable4").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                <?php }?>
                                <?php if($estado_filas5=='1'){?>
                                sort5:(($("#sortable5").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                <?php }?>
                                veh_id:$("#hdd_veh_id").val(),
                                veh_pis:$("#cmb_piso").val(),
                                vista:'actualizar_posicion'
                            },
                        success: function(html)
                        {
                            $('.success').fadeIn(500);
                            $('.success').fadeOut(500);
                        }
                    });
            }
        }).disableSelection();

        // Bind the update event manually
        $('#sortable1, #sortable2,#sortable3,#sortable4, #sortable5').live('sortupdate',function() {
            $.ajax(
                {
                    type: "POST",
                    url: "../croquis/croquis_actualizar_posicion.php",
                    data:
                        {
                            <?php if($estado_filas1=='1'){?>
                            sort1:(($("#sortable1").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                            <?php }?>
                            <?php if($estado_filas2=='1'){?>
                            sort2:(($("#sortable2").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                            <?php }?>
                            <?php if($estado_filas3=='1'){?>
                            sort3:(($("#sortable3").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                            <?php }?>
                            <?php if($estado_filas4=='1'){?>
                            sort4:(($("#sortable4").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                            <?php }?>
                            <?php if($estado_filas5=='1'){?>
                            sort5:(($("#sortable5").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                            <?php }?>
                            veh_id:$("#hdd_veh_id").val(),
                            veh_pis:$("#cmb_piso").val(),
                            vista:'actualizar_posicion'
                        },
                    success: function(html)
                    {
                        $('.success').fadeIn(500);
                        $('.success').fadeOut(500);
                    }
                });
            console.log('update')
        });

    });

    function seleccionar(selector) {
        $('.seleccionado').removeClass('seleccionado');

        $(selector).addClass('seleccionado');

    }
    function desactivar_fila(estado) {
        $.ajax({
            type: "POST",
            url: "../croquis/croquis_actualizar_posicion.php",
            async: true,
            dataType: "json",
            data: ({
                veh_id:$("#hdd_veh_id").val(),
                veh_pis:$("#cmb_piso").val(),
                fila: $("#cmb_fila").val(),
                estado:estado,
                vista: "desactivar_fila"
            }),
            beforeSend: function () {
                $('#msj_asientoestado').html("Guardando...");
                $('#msj_asientoestado').show(100);
            },
            success: function (data) {
                $('#msj_asientoestado').html(data.asientoestado_msj);
            },
            complete: function () {
                croquis_filtro(<?php echo $vehiculo_id ?>,$("#cmb_piso").val());
            }
        })
    }
    function cambiar_color(selector) {
        $('.seleccionado').removeClass('seleccionado');

        $(selector).addClass('seleccionado');
        $(selector).attr('contentEditable',true);
    }
</script>
<style>

    .oculto{
        visibility: hidden;
    }
    #sortable1, #sortable2,#sortable3,#sortable4,#sortable5 {
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
        height: 45px;
        cursor: move;
        position: relative;
        float: left;
        background: #00aa00;
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
        height: 40px;
    }
    #bus{
        width: 1000px;
        /*height: 550px;*/
        /*!*background: url("../../images/bus_fondo.png");*!*/
        /*background-size: 95%;*/
        /*background-repeat: no-repeat;*/
        /*background-position-x: -52px;*/
    }
    .d{
        background: #f5f5f5 !important;
        color: #dedede;
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
    <div id="bus">
        <div id="frentera"><!--FRENTE--></div>
        <div id="lugares">
            <?php if($estado_filas1==1){?>
            <div id="sortable1" class="connectedSortable">
                <?php
                if($orden1!=""){ //solo si hay distribucion creada
                    $lugares = explode(';',$orden1);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>" onclick="cambiar_color(this)"><?php echo $lugar[1]?></div>
                        <?php
                    }
                }
                mysql_free_result($dts1);

                ?>
            </div>
            <div class="clear"></div>
            <?php }?>
            <?php if($estado_filas2==1) {?>
            <div id="sortable2" class="connectedSortable">
                <?php
                if($orden2!=""){
                    $lugares = explode(';',$orden2);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>" onclick="cambiar_color(this)"><?php echo $lugar[1] ?></div>
                        <?php
                    }
                }
                mysql_free_result($dts2);

                ?>
            </div>
            <div class="clear"></div>
            <?php }?>
            <?php if($estado_filas3==1) {?>
            <div id="sortable3" class="connectedSortable pasadizo">
                <?php
                if($orden3!=""){
                    $lugares = explode(';',$orden3);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>" onclick="cambiar_color(this)"><?php echo $lugar[1] ?></div>
                        <?php
                    }
                }
                mysql_free_result($dts3);

                ?>
            </div>
            <div class="clear"></div>
            <?php }?>
            <?php if($estado_filas4==1) {?>
            <div id="sortable4" class="connectedSortable">
                <?php
                if($orden4!=""){
                    $lugares = explode(';',$orden4);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>" onclick="cambiar_color(this)"><?php echo $lugar[1] ?></div>
                        <?php
                    }
                }
                mysql_free_result($dts4);

                ?>
            </div>
            <div class="clear"></div>
            <?php }?>
            <?php if($estado_filas5==1) {?>
            <div id="sortable5" class="connectedSortable">
                <?php
                if($orden5!="" && $estado_filas5==1){
                    $lugares = explode(';',$orden5);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>" onclick="cambiar_color(this)"><?php echo $lugar[1] ?></div>
                        <?php
                    }
                }
                mysql_free_result($dts5);

                ?>
            </div>
            <?php }?>
        </div>
        <div id="atras"><!--atras--></div>
        <div class="clear"></div>
        <div id="desactivar_filas">
            <label for="cmb_estado"><b>Ocultar/Mostrar Fila:</b></label>
            <select name="cmb_fila" id="cmb_fila">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <a class="btn_desactivar" href="#" onClick="desactivar_fila(0)">Desactivar Fila</a>
            <a class="btn_activar" href="#" onClick="desactivar_fila(1)">Activar Fila</a>
        </div>
    </div>

