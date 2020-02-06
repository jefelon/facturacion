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
            <?php
            if($num_rows>=1){
            ?>
            <div id="frentera"><!--FRENTE--></div>
            <div id="lugares">
                <div id="sortable1" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden1);
                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombreEstado($nom_lugar,$_POST['txt_vehiculo_id'],$fecha_salida,$hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                                <div id="<?php echo $lugar ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $ast['tb_clientereserva_id']?>); return false;" class="asiento
                                <?php
                                if ($ast['tb_asientoestado_id']){
                                    if($ast['tb_asientoestado_reserva']==1){
                                        echo 'reserva';
                                    }else{
                                        echo 'ocupado';
                                    }
                                }?>"
                                     onclick="cambiar_color(this)">
                                    <div class="" style="padding-left: 4px;">
                                        <?php echo explode('_',$lugar)[1] ?>
                                    </div>

                                    <div class="" style="background-color: <?php echo $ast['tb_lugar_color'];?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                            width: 100%;">
                                        <?php echo substr($ast['tb_lugar_nom'],0,2) ?>
                                    </div>
                                </div>
                            <?php
                        }
                    mysql_free_result($dts1);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable2" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden2);

                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombreEstado($nom_lugar,$_POST['txt_vehiculo_id'],$fecha_salida,$hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                            <div id="<?php echo $lugar ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $ast['tb_clientereserva_id']?>); return false;" class="asiento
                            <?php if ($ast['tb_asientoestado_id']){
                                if($ast['tb_asientoestado_reserva']==1){
                                    echo 'reserva';
                                }else{
                                    echo 'ocupado';
                                }
                            }?>"
                                 onclick="cambiar_color(this)">
                                <div class="" style="padding-left: 4px;">
                                    <?php echo explode('_',$lugar)[1] ?>
                                </div>

                                <div class="" style="background-color: <?php echo $ast['tb_lugar_color'];?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                        width: 100%;">
                                    <?php echo substr($ast['tb_lugar_nom'],0,2) ?>
                                </div>
                            </div>
                            <?php
                        }

                    mysql_free_result($dts2);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable3" class="connectedSortable pasadizo">
                    <?php
                    $asientos = explode(';',$orden3);

                        foreach ($asientos as $asiento) {
                            $asiento=explode('_',$asiento);//0=item 1=numero 2=vista ejm tv, oculto, grada
                            $asts = $oAsiento->mostrarNombreEstado($asiento[1], $_POST['txt_vehiculo_id'], $fecha_salida, $hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                            <div id="<?php echo $asiento[0]."_".$asiento[1]."_".$asiento[2] ?>"
                                 oncontextmenu="click_derecho(event,$(this),<?php echo $ast['tb_clientereserva_id'] ?>); return false;"
                                 class="asiento
                            <?php if ($ast['tb_asientoestado_id']) {
                                     if ($ast['tb_asientoestado_reserva'] == 1) {
                                         echo 'reserva';
                                     } else {
                                         echo 'ocupado';
                                     }
                                 } ?> <?php echo $asiento[2]?>"
                                 onclick="cambiar_color(this)">
                                <div class="" style="padding-left: 4px;">
                                    <?php echo  $asiento[1] ?>
                                </div>

                                <div class=""
                                     style="background-color: <?php echo $ast['tb_lugar_color']; ?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                             width: 100%;">
                                    <?php echo substr($ast['tb_lugar_nom'], 0, 2) ?>
                                </div>
                            </div>
                            <?php
                        }
                    mysql_free_result($dts3);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable4" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden4);

                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombreEstado($nom_lugar,$_POST['txt_vehiculo_id'],$fecha_salida,$hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                            <div id="<?php echo $lugar ?>" oncontextmenu="click_derecho(event,$(this),<?php echo $ast['tb_clientereserva_id']?>); return false;" class="asiento
                            <?php if ($ast['tb_asientoestado_id']){
                                if($ast['tb_asientoestado_reserva']==1){
                                    echo 'reserva';
                                }else{
                                    echo 'ocupado';
                                }
                            }?>"
                                 onclick="cambiar_color(this)">
                                <div class="" style="padding-left: 4px;">
                                    <?php echo explode('_',$lugar)[1] ?>
                                </div>

                                <div class="" style="background-color: <?php echo $ast['tb_lugar_color'];?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                        width: 100%;">
                                    <?php echo substr($ast['tb_lugar_nom'],0,2) ?>
                                </div>
                            </div>
                            <?php
                        }

                    mysql_free_result($dts4);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable5" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden5);

                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombreEstado($nom_lugar,$_POST['txt_vehiculo_id'],$fecha_salida,$hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                            <div id="<?php echo $lugar ?>" oncontextmenu="click_derecho(event,$(this)); return false;" class="asiento
                            <?php if ($ast['tb_asientoestado_id']){
                                        if($ast['tb_asientoestado_reserva']==1){
                                            echo 'reserva';
                                        }else{
                                            echo 'ocupado';
                                        }
                            }?>"
                                 onclick="cambiar_color(this)">
                                <div class="" style="padding-left: 4px;">
                                    <?php echo explode('_',$lugar)[1] ?>
                                </div>

                                <div class="" style="background-color: <?php echo $ast['tb_lugar_color'];?>; color: #000000; position: absolute;bottom: 4px; text-align: center;
                                        width: 100%;">
                                    <?php echo substr($ast['tb_lugar_nom'],0,2) ?>
                                </div>
                            </div>
                            <?php
                        }
                    mysql_free_result($dts5);

                    ?>
                </div>
                <?php
            }?>

