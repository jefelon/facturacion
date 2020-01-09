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

        $('.btn_desactivar').button({
            icons: {primary: "ui-icon-close"},
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
                                sort1:(($("#sortable1").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                sort2:(($("#sortable2").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                sort3:(($("#sortable3").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                sort4:(($("#sortable4").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                                sort5:(($("#sortable5").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
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
                            sort1:(($("#sortable1").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                            sort2:(($("#sortable2").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                            sort3:(($("#sortable3").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                            sort4:(($("#sortable4").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
                            sort5:(($("#sortable5").sortable('toArray')).join(';')).split('"').pop().split('"')[0],
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
    function desactivar_fila(fila) {
        $.ajax({
            type: "POST",
            url: "../croquis/croquis_actualizar_posicion.php",
            async: true,
            dataType: "json",
            data: ({
                veh_id:$("#hdd_veh_id").val(),
                veh_pis:$("#cmb_piso").val(),
                fila: fila,
                estado:"0",
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
    .d{
        background: #f5f5f5 !important;
        color: transparent;
        /*visibility: hidden;*/
    }
    .tv {
        width: 33px !important;
        height: 50px !important;
        background: url(../../images/tv2.png) !important;
        background-size: 100% !important;
        padding: 0 !important;
        color: transparent;
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

    .estado_0>div{
       height: 3px;
    }

</style>

<?php
if($num_rows>=1){
    ?>
    <div id="bus">
        <div id="frentera"><!--FRENTE--></div>
        <div id="lugares">
            <div id="sortable1" class="connectedSortable <?php echo "estado_".$estado_filas1?>">
                <a class="btn_desactivar" href="#" onClick="desactivar_fila('<?php echo "1"?>')">Desactivar Fila</a>
                <?php
                if($orden1!=""){ //solo si hay distribucion creada
                    $lugares = explode(';',$orden1);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>"><?php echo $lugar[1] ?></div>
                        <?php
                    }
                }
                mysql_free_result($dts1);

                ?>
            </div>
            <div class="clear"></div>
            <div id="sortable2" class="connectedSortable <?php echo "estado_".$estado_filas1?>">
                <a class="btn_desactivar" href="#" onClick="desactivar_fila('<?php echo "2"?>')">Desactivar Fila</a>
                <?php
                if($orden2!=""){
                    $lugares = explode(';',$orden2);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>"><?php echo $lugar[1] ?></div>
                        <?php
                    }
                }
                mysql_free_result($dts2);

                ?>
            </div>
            <div class="clear"></div>
            <?php if($estado_filas3==1) {?>
            <div id="sortable3" class="connectedSortable pasadizo">
                <a class="btn_desactivar" href="#" onClick="desactivar_fila('<?php echo "3"?>')">Desactivar Fila</a>
                <?php
                if($orden3!=""){
                    $lugares = explode(';',$orden3);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>"><?php echo $lugar[1] ?></div>
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
                <a class="btn_desactivar" href="#" onClick="desactivar_fila('<?php echo "4"?>')">Desactivar Fila</a>
                <?php
                if($orden4!=""){
                    $lugares = explode(';',$orden4);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>"><?php echo $lugar[1] ?></div>
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
                <a class="btn_desactivar" href="#" onClick="desactivar_fila('<?php echo "5"?>')">Desactivar Fila</a>
                <?php
                if($orden5!="" && $estado_filas5==1){
                    $lugares = explode(';',$orden5);
                    foreach ($lugares as $lugar) {
                        $lugar=explode('_',$lugar);//0=id 1=numero 2=vista ejm tv, oculto, grada, activo, desactivado
                        ?>
                        <div id="<?php echo $lugar[0]."_".$lugar[1]."_".$lugar[2] ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $lugar[1]?>); return false;" class="asiento <?php echo $lugar[2]?>"><?php echo $lugar[1] ?></div>
                        <?php
                    }
                }
                mysql_free_result($dts5);

                ?>
            </div>
            <?php }?>
        </div>
    </div>
    <?php


}
?>

