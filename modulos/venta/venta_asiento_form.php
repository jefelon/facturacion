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

?>

<script type="text/javascript">
    $('.venpag_moneda').autoNumeric({
        aSep: ',',
        aDec: '.',
        //aSign: 'S/. ',
        //pSign: 's',
        vMin: '0.00',
        vMax: '999999999999.99'
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
    function cmb_lugar()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:true,
            dataType: "html",
            beforeSend: function() {
                $('#cmb_salida_id').html('<option value="">Cargando...</option>');
                $('#cmb_llegada_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_salida_id').html(html);
                $('#cmb_llegada_id').html(html);
            },
            complete: function(){

            }
        });
    }

    function filtro_bus()
    {
        $.ajax({
            type: "POST",
            url: "../venta/venta_filtro_bus.php",
            async:true,
            dataType: "html",
            data: ({
                txt_fech_sal: $('#txt_fech_sal').val(),
                cmb_horario: $('#cmb_horario').val(),
                txt_vehiculo_id: $('#hdd_vehiculo').val()
            }),
            beforeSend: function() {
                $('#bus').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#bus').html(html);
            },
            complete: function(){

            }
        });
    }


    function cmb_lugar_horario()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_hor_id.php",
            async:true,
            dataType: "html",
            data: ({
                salida_id: $('#cmb_salida_id').val(),
                llegada_id: $('#cmb_llegada_id').val(),
                horario: $('#cmb_horario').val()
            }),
            beforeSend: function() {
                $('#cmb_horario').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_horario').html(html);
            },
            complete: function(){

            }
        });
    }
    function cmb_lugar_vehiculo()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_veh_id.php",
            async:false,
            dataType: "json",
            data: ({
                salida_id: $('#cmb_salida_id').val(),
                llegada_id: $('#cmb_llegada_id').val(),
                horario: $('#cmb_horario').val()
            }),
            beforeSend: function() {
                $('#placa_vehiculo').html('<option value="">Cargando...</option>');
            },
            success: function(data){
                $('#placa_vehiculo').html(data.vehiculo_placa);
                $('#hdd_vehiculo').val(data.vehiculo_id);
                $('#hdd_vi_ho').val(data.viajehorario_id);

            },
            complete: function(){

            }
        });
    }
    function buscar_dni() {
        var dni = $('#txt_pasaj_dni').val();
        var url = '../../libreriasphp/consultadni/consulta_reniec.php';
        $.ajax({
            type:'POST',
            url:url,
            data:'dni='+dni,
            success: function(datos_dni){
                var datos = eval(datos_dni);

                // $('#mostrar_dni').text(datos[0]);
                // $('#paterno').text(datos[1]);
                // $('#materno').text(datos[2]);
                // $('#nombres').text(datos[3]);
                if(datos[1]!="" && datos[2]!="" && datos[3]!="") {
                    $('#txt_pasaj_nom').val(datos[1] + " " + datos[2] + " " + datos[3]);
                    $( "#txt_pasaj_edad" ).focus();
                }else {
                    $('#txt_pasaj_nom').val("Datos no encontrados o menor de edad. Editar manualmente los datos.");
                    $( "#txt_pasaj_nom" ).focus();
                }
            }
        });
    }
    $(function () {
        cmb_lugar();
        $('#cmb_llegada_id,#cmb_salida_id').change(function(){
            $('#cmb_horario').val('');
            cmb_lugar_horario();
            $('#placa_vehiculo').html('');
            $('#bus').html('');

        });
        $('#cmb_horario').change(function(){
            cmb_lugar_vehiculo();
            filtro_bus();
        });

        $( "#txt_precio" ).keypress(function( event ) {
            if ( event.which == 13 ) {
                $( "#txt_pasaj_dni" ).focus();
            }

        });
        $( "#txt_pasaj_dni" ).keypress(function( event ) {
            if ( event.which == 13 ) {
                buscar_dni();
            }

        });





        $("#bus_form").validate({
            submitHandler: function () {
                if($('.seleccionado').length<=0){
                    alert('Seleccione un asiento');
                }else{
                    var id_seleccionado = ($('.seleccionado').attr("id")).split('_')[1];
                    $.ajax({
                        type: "POST",
                        url: "../venta/venta_form.php",
                        async:true,
                        dataType: "html",
                        data: ({
                            action: 'insertar',
                            ven_id:	'',
                            asiento_id: id_seleccionado,
                            precio: $('#txt_precio').val(),
                            viaje_fecha_sal: $('#txt_fech_sal').val(),
                            viaje_horario_id: $('#hdd_vi_ho').val(),
                            viaje_horario: $('#cmb_horario').val()
                        }),
                        beforeSend: function () {
                            $('#div_venta_asiento_form').dialog("close");
                            $('#div_venta_form').dialog("open");
                            $('#div_venta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
                        },
                        success: function (html) {
                            $('#div_venta_form').html(html);
                        },
                        complete: function () {
                            $( "#div_venta_form" ).dialog({
                                title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?> | Agregar',
                                height: 650,
                                width: 980,
                                buttons: {
                                    Guardar: function(){
                                        txt_ven_numdoc();
                                        if($('#hdd_ven_doc').val()==1){
                                            if($('#hdd_ven_numite').val()>0)
                                            {
                                                venta_check();
                                            }
                                            else{
                                                $("#for_ven").submit();
                                            }
                                        }
                                        else
                                        {
                                            $("#for_ven").submit();
                                        }
                                    },
                                    Cancelar: function() {
                                        $('#for_ven').each (function(){this.reset();});
                                        $( this ).dialog( "close" );
                                    }
                                }
                            });
                        }
                    });
                }
            },
            rules: {
                cmb_salida_id: {
                    required: true
                },
                cmb_llegada_id: {
                    required: true
                },
                cmb_horario: {
                    required: true
                },
                txt_precio: {
                    required: true
                }
            },
            messages: {
                cmb_salida_id: {
                    required: '*'
                },
                cmb_llegada_id: {
                    required: '*'
                },
                cmb_horario: {
                    required: '*'
                },
                txt_precio: {
                    required: '*'
                }
            }
        });
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
    .ocupado {
        background: red !important;
        color: white;
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
        width: 30px;
        height: 40px;
        cursor: pointer !important;
        position: relative;
        float: left;
        background: #00aa00;
    }

    .clear{
        clear: both;
    }
    #frentera{
        height: 200px;
        width: 185px;
        /*background: #0D8BBD;*/
        float: left;
    }
    #lugares{
        float: left;
        height: 200px;
        margin-top: 80px;
    }
    .pasadizo{
        height: 40px;
    }
    #bus{
        width: 1229px;
        height: 480px;
        background: url("../../images/bus_fondo.png");
        background-size: 99%;
        background-repeat: no-repeat;
        background-position-x: -45px;
        overflow: hidden;
    }

</style>


    <form id="bus_form">
        <input type="hidden" id="hdd_vehiculo" value="">
        <input type="hidden" id="hdd_vi_ho" value="">
        <div id="origen_destino">
            <fieldset><legend>Seleccionar Salida y Llegada</legend>

                <table border="0" cellspacing="2" cellpadding="0">
                    <tr>
                        <td valign="top">
                            <label for="cmb_salida_id">Salida</label><br>
                            <select name="cmb_salida_id" id="cmb_salida_id">
                            </select>
                        </td>
                        <td valign="top"><label for="cmb_llegada_id">Llegada:</label><br>
                            <select name="cmb_llegada_id" id="cmb_llegada_id">
                            </select>
                        </td>
                        <td valign="top">
                            <label for="txt_fech_sal">Fecha Salida:</label><br>
                            <input name="txt_fech_sal" type="text" class="fecha" id="txt_fech_sal" value="<?php echo $fec ?>" size="10" maxlength="10">
                        </td>
                        <td valign="top"><label for="cmb_horario">Hora Salida:</label><br>
                            <select name="cmb_horario" id="cmb_horario">
                            </select>
                        </td>
                        <td valign="top"><label>Vehiculo:</label><br>
                            <div id="placa_vehiculo">
                            </div>
                        </td>
                        <td valign="top"><label for="txt_precio">Precio:</label><br>
                            <input class="venpag_moneda" name="txt_precio" size="4" type="text" id="txt_precio">
                        </td>
                </table>
            </fieldset>
        </div>
        <div id="bus" style="width: 80%;float:left">

        </div>
        <div id="pasajero" style="width: 20%;float: right">
            <label for="txt_pasaj_dni">DNI:</label>
            <input name="txt_pasaj_dni" type="text"  id="txt_pasaj_dni" value="" size="20" maxlength="8"><br>
            <label for="txt_pasaj_nom">NOMBRE: </label>
            <input name="txt_pasaj_nom" type="text"  id="txt_pasaj_nom" value="" size="20"><br>
            <label for="txt_pasaj_edad">EDAD: </label>
            <input name="txt_pasaj_edad" type="text"  id="txt_pasaj_edad" value="" size="20" maxlength="3">
        </div>
        </form>


