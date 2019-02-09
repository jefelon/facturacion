<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

if($_SESSION['usuariogrupo_id']==2)$titulo='Registrar Ventas - Administrador';
if($_SESSION['usuariogrupo_id']==3)$titulo='Registrar Ventas - Vendedor';
require_once ("../../config/Cado.php");

require_once ("../formatos/formato.php");

$fec=date('d-m-Y');

require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);

?>

<script type="text/javascript">
    $('.venpag_moneda').autoNumeric({
        aSep: ',',
        aDec: '.',
        //aSign: 'S/. ',
        //pSign: 's',
        vMin: '0.00',
        vMax: '99999999.99'
    });
    $( "#txt_fech_sal" ).datepicker({
        minDate: "-0D",
        maxDate:"+7D",
        yearRange: 'c-0:c+0',
        changeMonth: true,
        changeYear: false,
        dateFormat: 'dd-mm-yy',
        //altField: fecha,
        //altFormat: 'yy-mm-dd',
        showOn: "button",
        buttonImage: "../../images/calendar.gif",
        buttonImageOnly: true
    });
    $('#btn_agregar_horario').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });

    $('#btn_manifiesto').button({
        icons: {primary: "ui-icon-print"},
        text: false

    });


    function cmb_lugar_origen_pos()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:false,
            dataType: "html",
            data: ({
                lug_id: <?php echo $pv['tb_lugar_id']?>
            }),
            beforeSend: function() {
                $('#cmb_salida_pos').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_salida_pos').html(html);
                $('#cmb_salida_pos').find('option').not(':selected').remove();
            },
            complete: function(){

            }
        });
    }

    function cmb_lugar_parada_pos()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:false,
            dataType: "html",
            data: ({
                lug_id: $('#cmb_parada_id').val()
            }),
            beforeSend: function() {
                $('#cmb_parada_pos').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_parada_pos').html(html);
                $("#cmb_parada_pos").find("option[value='<?php echo $pv['tb_lugar_id']?>']").remove();
            },
            complete: function(){

            }
        });
    }

    function cmb_lugar_destino_pos()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:false,
            dataType: "html",
            data: ({
                lug_id: $('#cmb_llegada_id').val()
            }),
            beforeSend: function() {
                $('#cmb_llegada_pos').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_llegada_pos').html(html);
                $("#cmb_llegada_pos").find("option[value='<?php echo $pv['tb_lugar_id']?>']").remove();
            },
            complete: function(){

            }
        });
    }

    function cmb_fecha_horario_pos()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_hor_id.php",
            async:false,
            dataType: "html",
            data: ({
                salida_id: $('#cmb_salida_pos').val(),
                llegada_id: $('#cmb_llegada_pos').val(),
                fecha: $('#cmb_fech_sal_pos').val()
            }),
            beforeSend: function() {
                $('#cmb_horario_pos').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_horario_pos').html(html);
            },
            complete: function(){

            }
        });
    }

    function cmb_horario_vehiculo_pos()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_veh_id.php",
            async:false,
            dataType: "json",
            data: ({
                salida_id: $('#cmb_salida_pos').val(),
                llegada_id: $('#cmb_llegada_pos').val(),
                horario: $('#cmb_horario_pos').val(),
                fecha: $('#cmb_fech_sal_pos').val()
            }),
            beforeSend: function() {

            },
            success: function(data){
                $('#hdd_vi_ho_pos').val(data.viajehorario_id);

            },
            complete: function(){

            }
        });
    }

    function cmb_fecha_pos()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_fecha.php",
            async:true,
            dataType: "html",
            data: ({
                salida_id: $('#cmb_salida_pos').val(),
                llegada_id: $('#cmb_llegada_pos').val()
            }),
            beforeSend: function() {
                $('#cmb_fech_sal_pos').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_fech_sal_pos').html(html);
            },
            complete: function(){

            }
        });
    }


    function venta_horario_form(act,idf){
        $.ajax({
            type: "POST",
            url: "../venta/venta_horario_form.php",
            // url: "../venta/croquis.php",
            async:true,
            dataType: "html",
            data: ({
                action: act
            }),
            beforeSend: function() {
                $('#msj_venta').hide();
                $('#div_venta_horario_form').dialog("open");
                $('#div_venta_horario_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_venta_horario_form').html(html);
            }
        });
    }

    function venta_cliente_reg(act, idf) {
        $.ajax({
            type: "POST",
            url: "../clientes/cliente_reg.php",
            async: true,
            dataType: "json",
            data: ({
                action_cliente: 'insertar',
                txt_cli_nom: $('#txt_pasaj_nom').val(),
                txt_cli_doc: $('#txt_pasaj_dni').val(),
                rad_cli_tip: $("input[name=rad_cli_tip]:checked").val()
            }),
            beforeSend: function () {
                $('#div_cliente_form').dialog("close");
                $('#msj_cliente').html("Guardando...");
                $('#msj_cliente').show(100);
            },
            success: function (data) {
                $('#msj_cliente').html(data.cli_msj);
                pasajero_cargar_datos(data.cli_id);
                cliente_cargar_datos(data.cli_id);
            },
            complete: function () {
            }
        })
    }

    function venta_clientereserva_reg() {
        var cli_id='';
        $.ajax({
            type: "POST",
            url: "../clientes/cliente_reg.php",
            async: false,
            dataType: "json",
            data: ({
                action_cliente: 'insertar',
                txt_cli_nom: $('#txt_pasaj_nom').val(),
                txt_cli_doc: $('#txt_pasaj_dni').val(),
                rad_cli_tip: $("input[name=rad_cli_tip]:checked").val()
            }),
            beforeSend: function () {
                $('#msj_cliente').html("Guardando...");
                $('#msj_cliente').show(100);
            },
            success: function (data) {
                $('#msj_cliente').html(data.cli_msj);
                cli_id = data.cli_id;

            },
            complete: function () {
            }
        });
        return cli_id;
    }

    function reserva_cargar_datos(idf){
        $.ajax({
            type: "POST",
            url: "../clientes/cliente_reg.php",
            async:true,
            dataType: "json",
            data: ({
                action: "obtener_datos",
                cli_id:	idf
            }),
            beforeSend: function() {
                //$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(data){
                $('#txt_pasaj_dni').val(data.documento);
                $('#txt_pasaj_nom').val(data.nombre);
            }
        });
    }




    $(function () {


        cmb_lugar_origen_pos();
        cmb_lugar_parada_pos();
        cmb_lugar_destino_pos();
        cmb_fecha_pos();
        $('#cmb_parada_pos').prop("disabled", true).addClass("ui-state-disabled");
        $('#cmb_llegada_pos').change(function(){
            $('#cmb_horario_pos').val('');
            cmb_fecha_pos();
            $('#hdd_vi_ho_pos').val('');
            $('#cmb_parada_pos').prop("disabled", false);
            $('#cmb_parada_pos').removeClass("ui-state-disabled");

        });

        $('#cmb_salida_pos').change(function(){
            $('#cmb_horario_pos').val('');
            cmb_fecha_pos();
            $('#hdd_vi_ho_pos').val('');

        });




        $('#cmb_horario_pos').change(function(){
            cmb_horario_vehiculo_pos();
        });

        $('#cmb_fech_sal_pos').change(function(){
            cmb_fecha_horario_pos();
        });





        $("#postergar_form").validate({
            submitHandler: function () {
                if($('.seleccionado').length<=0){
                    alert('Seleccione un asiento');
                }else{
                    var id_seleccionado = ($('.seleccionado').attr("id")).split('_')[1];
                    $.ajax({
                        type: "POST",
                        url: "../venta/venta_reg.php",
                        async:true,
                        dataType: "html",
                        data: ({
                            action: 'postergar',
                            asiento_id: id_seleccionado,
                            viaje_horario_id: $('#hdd_vi_ho').val(),
                            viaje_horario_pos: $('#hdd_vi_ho_pos').val(),
                            hdd_punven_id: <?php echo $_SESSION['puntoventa_id']?>,
                            hdd_emp_id: <?php echo $_SESSION['empresa_id']?>,
                            hdd_usu_id: <?php echo $_SESSION['usuario_id']?>
                        }),
                        beforeSend: function () {
                            $('#msj_asientoestado').html("Guardando...");
                            $('#msj_asientoestado').show(100);
                        },
                        success: function (html) {
                            $('#div_postergacion_form').dialog("close");
                            $('#msj_asientoestado').html(html);
                        },
                        complete: function () {
                            filtro_bus();
                        }
                    });
                }
            },
            rules: {
                cmb_salida_pos: {
                    required: true
                },
                cmb_llegada_pos: {
                    required: true
                },
                cmb_horario_pos: {
                    required: true
                }
            },
            messages: {
                cmb_salida_pos: {
                    required: '*'
                },
                cmb_llegada_pos: {
                    required: '*'
                },
                cmb_horario_pos: {
                    required: '*'
                }
            }
        });
    });
</script>




    <form id="postergar_form">
        <input type="hidden" id="hdd_vehiculo" value="">
        <input type="hidden" id="hdd_vi_ho_pos" value="">
        <div id="origen_destino">
            <fieldset><legend>Seleccionar Origen y Destino</legend>

                <table border="0" cellspacing="2" cellpadding="0">
                    <tr>
                        <td valign="top">
                            <label for="cmb_salida_pos">Origen</label><br>
                            <select name="cmb_salida_pos" id="cmb_salida_pos">
                            </select>
                        </td>
                        <td valign="top">
                            <label for="cmb_salida_pos">Parada</label><br>
                            <select name="cmb_parada_pos" id="cmb_parada_pos">
                            </select>
                        </td>
                        <td valign="top"><label for="cmb_llegada_pos">Destino:</label><br>
                            <select name="cmb_llegada_pos" id="cmb_llegada_pos">
                            </select>
                        </td>
                        <td valign="top">
                            <label for="cmb_fech_sal_pos">F. Salida</label><br>
                            <select name="cmb_fech_sal_pos" id="cmb_fech_sal_pos">
                            </select>
                        </td>
                        <td align="center" valign="top"><label for="cmb_horario_pos">Hora Salida:</label><br>
                            <select name="cmb_horario_pos" id="cmb_horario_pos">
                            </select>
                        </td>
                </table>
            </fieldset>
        </div>
        </form>




