<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../asiento/cAsiento.php");
$oAsiento = new cAsiento();

require_once ("../formatos/formato.php");

$fecha_salida=fecha_mysql($_POST['cmb_fech_sal']);
$hora_salida=$_POST['cmb_horario'];

$dts1=$oAsiento->mostrarFiltroFila(1,14);
$dts2=$oAsiento->mostrarFiltroFila(15,28);
$dts3=$oAsiento->mostrarFiltroFila(36,49);
$dts4=$oAsiento->mostrarFiltroFila(29,42);
$dts5=$oAsiento->mostrarFiltroFila(43,56);

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
            <?php
            if(1){
            ?>
            <div id="frentera"><!--FRENTE--></div>
            <div id="lugares">
                <div id="sortable1" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden11);
                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombreEstado($nom_lugar,$_POST['txt_vehiculo_id'],$fecha_salida,$hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                                <div id="<?php echo $lugar ?>" class="asiento <?php if ($ast['tb_asientoestado_estado']){echo 'ocupado';}?>"
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
                        $lugares = explode(';',$orden22);

                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombreEstado($nom_lugar,$_POST['txt_vehiculo_id'],$fecha_salida,$hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento <?php if ($ast['tb_asientoestado_estado']){echo 'ocupado';}?>"
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
                    $lugares = explode(';',$orden33);

                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombreEstado($nom_lugar,$_POST['txt_vehiculo_id'],$fecha_salida,$hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento <?php if ($ast['tb_asientoestado_estado']){echo 'ocupado';}?>"
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
                    mysql_free_result($dts3);

                    ?>
                </div>
                <div class="clear"></div>
                <div id="sortable4" class="connectedSortable">
                    <?php
                        $lugares = explode(';',$orden44);

                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombreEstado($nom_lugar,$_POST['txt_vehiculo_id'],$fecha_salida,$hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento <?php if ($ast['tb_asientoestado_estado']){echo 'ocupado';}?>"
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
                        $lugares = explode(';',$orden55);

                        foreach ($lugares as $lugar) {
                            $nom_lugar = explode('_',$lugar)[1];
                            $asts = $oAsiento->mostrarNombreEstado($nom_lugar,$_POST['txt_vehiculo_id'],$fecha_salida,$hora_salida);
                            $ast = mysql_fetch_array($asts);
                            ?>
                            <div id="<?php echo $lugar ?>" class="asiento <?php if ($ast['tb_asientoestado_estado']){echo 'ocupado';}?>"
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

