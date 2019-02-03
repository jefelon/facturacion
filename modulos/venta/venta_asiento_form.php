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


    function cmb_lugar_origen()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:true,
            dataType: "html",
            data: ({
                lug_id: <?php echo $pv['tb_lugar_id']?>
            }),
            beforeSend: function() {
                $('#cmb_salida_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_salida_id').html(html);
                $('#cmb_salida_id').prop('disabled', 'disabled');
            },
            complete: function(){

            }
        });
    }

    function cmb_lugar_parada()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:true,
            dataType: "html",
            beforeSend: function() {
                $('#cmb_parada_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_parada_id').html(html);
                $("#cmb_parada_id").find("option[value='<?php echo $pv['tb_lugar_id']?>']").remove();
            },
            complete: function(){

            }
        });
    }

    function cmb_lugar_destino()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:true,
            dataType: "html",
            beforeSend: function() {
                $('#cmb_llegada_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_llegada_id').html(html);
                $("#cmb_llegada_id").find("option[value='<?php echo $pv['tb_lugar_id']?>']").remove();
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
                cmb_fech_sal: $('#cmb_fech_sal').val(),
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


    function cmb_fecha_horario()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_hor_id.php",
            async:true,
            dataType: "html",
            data: ({
                salida_id: $('#cmb_salida_id').val(),
                llegada_id: $('#cmb_llegada_id').val(),
                fecha: $('#cmb_fech_sal').val()
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

    function asientoestado_reg(act) {
        if($('.seleccionado').length<=0){
            alert('Seleccione un asiento');
        }else{

            if($('#txt_pasaj_dni').val()=='' || $('#txt_precio').val()==''){
                var mensaje = '';
                if ($('#txt_pasaj_dni').val()==''){
                    mensaje = mensaje + 'Falta Documento';
                    alert(mensaje);
                    $('#txt_pasaj_dni').focus();
                }
               else if ($('#txt_pasaj_dni').val()=='' && $('#txt_precio').val()==''){
                    mensaje = mensaje + ',';
                    alert(mensaje);
                    $('#txt_precio').focus();
                }
               else if ($('#txt_precio').val()==''){
                    mensaje = mensaje + 'Falta Precio';
                    alert(mensaje);
                    $('#txt_precio').focus();
                }

            }else {
                var id_seleccionado = ($('.seleccionado').attr("id")).split('_')[1];
                var cli_id = venta_clientereserva_reg();
                var destino_id;
                if($('#cmb_parada_id').val()>0){
                    destino_id=$('#cmb_parada_id').val();
                }else{
                    destino_id=$('#cmb_llegada_id').val();
                }
                $.ajax({
                    type: "POST",
                    url: "../asientoestado/asientoestado_reg.php",
                    async: true,
                    dataType: "json",
                    data: ({
                        action_asientoestado: act,
                        txt_asiento_id: id_seleccionado,
                        hdd_vh_id: $('#hdd_vi_ho').val(),
                        txt_destpar: destino_id,
                        cli_id: cli_id,
                        txt_precio: $('#txt_precio').val()
                    }),
                    beforeSend: function () {
                        $('#msj_asientoestado').html("Guardando...");
                        $('#msj_asientoestado').show(100);
                    },
                    success: function (data) {
                        $('#msj_asientoestado').html(data.asientoestado_msj);
                    },
                    complete: function () {
                        filtro_bus();
                        $('#txt_pasaj_dni').val('');
                        $('#txt_pasaj_nom').val('');
                        cmb_lugar_parada();
                    }
                })
            }

        }
    }

    function eliminar_asientoestado(act) {
        if($('.reserva').length<=0){
            alert('Seleccione un asiento');
        }else{
            var id_seleccionado = ($('.seleccionado').attr("id")).split('_')[1];
            $.ajax({
                type: "POST",
                url: "../asientoestado/asientoestado_reg.php",
                async: true,
                dataType: "json",
                data: ({
                    action_asientoestado: act,
                    txt_asiento_id: id_seleccionado,
                    hdd_vh_id: $('#hdd_vi_ho').val()
                }),
                beforeSend: function () {
                    $('#msj_asientoestado').html("Guardando...");
                    $('#msj_asientoestado').show(100);
                },
                success: function (data) {
                    $('#msj_asientoestado').html(data.asientoestado_msj);
                },
                complete: function () {
                    filtro_bus();
                }
            })

        }
    }

    function cmb_horario_vehiculo()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_veh_id.php",
            async:false,
            dataType: "json",
            data: ({
                salida_id: $('#cmb_salida_id').val(),
                llegada_id: $('#cmb_llegada_id').val(),
                horario: $('#cmb_horario').val(),
                fecha: $('#cmb_fech_sal').val()
            }),
            beforeSend: function() {
                $('#txt_placa_vehiculo').val('<option value="">Cargando...</option>');
            },
            success: function(data){
                $('#txt_placa_vehiculo').val(data.vehiculo_placa);
                $('#txt_modelo_vehiculo').val(data.vehiculo_marca);
                $('#txt_asientos_vehiculo').val(data.vehiculo_numasi);
                $('#hdd_vehiculo').val(data.vehiculo_id);
                $('#hdd_vi_ho').val(data.viajehorario_id);
                $('#hdd_vh_id').val(data.viajehorario_id);

            },
            complete: function(){

            }
        });
    }

    function cmb_fecha()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_fecha.php",
            async:true,
            dataType: "html",
            data: ({
                salida_id: $('#cmb_salida_id').val(),
                llegada_id: $('#cmb_llegada_id').val()
            }),
            beforeSend: function() {
                $('#cmb_fech_sal').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_fech_sal').html(html);
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
                }else {
                    $('#txt_pasaj_nom').val("Datos no encontrados o menor de edad. Editar manualmente los datos.");
                    $( "#txt_pasaj_nom" ).focus();
                }
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

    function reserva_cargar_precio(){
        if($('.reserva').length<=0){
            alert('Seleccione un asiento');
        }else{
            var id_seleccionado = ($('.seleccionado').attr("id")).split('_')[1];
            $.ajax({
                type: "POST",
                url: "../asientoestado/asientoestado_reg.php",
                async: true,
                dataType: "json",
                data: ({
                    action_asientoestado: 'obtener_datos',
                    txt_asiento_id: id_seleccionado,
                    hdd_vh_id: $('#hdd_vi_ho').val()
                }),
                beforeSend: function () {

                },
                success: function (data) {
                    $('#txt_precio').val(data.asientoestado_precio);
                    if(data.asientoestado_destpar_id  == $('#cmb_llegada_id').val())
                    {
                        cmb_lugar_parada();
                    }else {
                        $('#cmb_parada_id').val(data.asientoestado_destpar_id);
                    }

                },
                complete: function () {
                    filtro_bus();
                }
            })

        }
    }


    function getPosition(el) {
        var xPos = 0;
        var yPos = 0;

        while (el) {
            if (el.tagName == "BODY") {
                // deal with browser quirks with body/window/document and page scroll
                var xScroll = el.scrollLeft || document.documentElement.scrollLeft;
                var yScroll = el.scrollTop || document.documentElement.scrollTop;

                xPos += (el.offsetLeft - xScroll + el.clientLeft);
                yPos += (el.offsetTop - yScroll + el.clientTop);
            } else {
                // for all other non-BODY elements
                xPos += (el.offsetLeft - el.scrollLeft + el.clientLeft);
                yPos += (el.offsetTop - el.scrollTop + el.clientTop);
            }

            el = el.offsetParent;
        }
        return {
            x: xPos,
            y: yPos
        };
    }

    function click_derecho(event,selector,cli_id){
        var id_selector = selector.attr('id');
        var position = $("#"+id_selector).position();
        if($(selector).hasClass('ocupado')){
            alert('Esta ocupado!!!');
        }else if($(selector).hasClass('reserva')){
            $("#menu-click").css({'display': 'block', 'left': position.left+40, 'top': position.top+40 });
            $("#reservar").css({'display': 'none'});
            $("#eliminar").css({'display': 'block'});
            $("#vender").css({'display': 'block'});
            $("#hdd_act_res").val(cli_id);
            $(selector).addClass( "seleccionado" );

        }else {
            seleccionar_reserva(selector);
            $("#menu-click").css({'display': 'block', 'left': position.left+40, 'top': position.top+40 });
            $("#reservar").css({'display': 'block'});
            $("#vender").css({'display': 'none'});
            $("#eliminar").css({'display': 'none'});
        }
    }

    $(function () {
        //Ocultamos el menú al cargar la página
        $("#menu-click").hide();

        //cuando hagamos click, el menú desaparecerá
        $(document).click(function(e){
            if(e.button == 0){
                $("#menu-click").css("display", "none");
            }
        });

        //si pulsamos escape, el menú desaparecerá
        $(document).keydown(function(e){
            if(e.keyCode == 27){
                $("#menu-click").css("display", "none");
            }
        });

        //controlamos los botones del menú
        $("#menu-click").click(function(e){

            // El switch utiliza los IDs de los <li> del menú
            switch(e.target.id){
                case "reservar":
                    asientoestado_reg('insertar');
                    break;
                case "eliminar":
                    eliminar_asientoestado('eliminar');
                    break;
                case "vender":
                    reserva_cargar_precio();
                    reserva_cargar_datos($("#hdd_act_res").val());
                    $("#bus_form").submit();
                    break;
                // case "detalle":
                //     reserva_cargar_precio();
                //     reserva_cargar_datos($("#hdd_act_res").val());
                //     $( "#bus_form" ).submit();
                //     break;
            }

        });


        $("input[id=radio1]").change(function(){
            if($("input[id=radio1]").is(":checked")){
                $('#lbl_cli_doc').html("DNI:");
                $( "#txt_pasaj_dni" ).attr('maxlength','8');
                $( "#txt_pasaj_dni").val('');
            }
        });

        $("input[id=radio3]").change(function(){
            if($("input[id=radio3]").is(":checked")){
                $('#lbl_cli_doc').html("DOC:");
                $( "#txt_pasaj_dni").attr('maxlength','11');
                $( "#txt_pasaj_dni").val('');
                $( "#validar_ruc").hide(200);
            }
        });

        cmb_lugar_origen();
        cmb_lugar_parada();
        cmb_lugar_destino();
        $('#cmb_parada_id').prop("disabled", true).addClass("ui-state-disabled");
        $('#cmb_llegada_id').change(function(){
            $('#cmb_horario').val('');
            cmb_fecha();
            $('#txt_placa_vehiculo').val('');
            $('#txt_modelo_vehiculo').val('');
            $('#txt_asientos_vehiculo').val('');
            $('#bus').html('');
            $('#hdd_vi_ho').val('');
            $('#cmb_parada_id').prop("disabled", false);
            $('#cmb_parada_id').removeClass("ui-state-disabled");

        });

        $('#cmb_salida_id').change(function(){
            $('#cmb_horario').val('');
            cmb_fecha();
            $('#txt_placa_vehiculo').val('');
            $('#txt_modelo_vehiculo').val('');
            $('#txt_asientos_vehiculo').val('');
            $('#bus').html('');
            $('#hdd_vi_ho').val('');

        });




        $('#cmb_horario').change(function(){
            cmb_horario_vehiculo();
            filtro_bus();

        });

        $('#cmb_fech_sal').change(function(){
            cmb_fecha_horario();
            $('#txt_placa_vehiculo').val('');
            $('#txt_modelo_vehiculo').val('');
            $('#txt_asientos_vehiculo').val('');
            $('#bus').html('');
            $('#hdd_vi_ho').val('');
        });



        $( "#txt_precio" ).keypress(function( event ) {
            if ( event.which == 13 ) {
                $( "#txt_pasaj_dni" ).focus();
            }

        });
        $( "#txt_pasaj_dni" ).keypress(function( event ) {
            if ( event.which == 13 && $("input[name=rad_cli_tip]:checked").val()==1) {
                buscar_dni();
            }

        });

        $( "#div_venta_horario_form" ).dialog({
            title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?>',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 'auto',
            zIndex: 1,
            modal: true,
            position: "center",
            closeOnEscape: false,
            buttons: {
                Guardar: function() {
                    $("#for_hor").submit();
                },
                Cancelar: function() {
                    $('#for_hor').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
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
                            viaje_fecha_sal: $('#cmb_fech_sal').val(),
                            viaje_horario_id: $('#hdd_vi_ho').val(),
                            viaje_horario: $('#cmb_horario').val(),
                            pasaj_dni:$('#txt_pasaj_dni').val(),
                            pasaj_nom:$('#txt_pasaj_nom').val(),
                            viaje_parada: $('#cmb_parada_id').val(),
                            viaje_llegada: $('#cmb_llegada_id').val()
                        }),
                        beforeSend: function () {
                            //$('#div_venta_asiento_form').dialog("close");
                            $('#div_venta_form').dialog("open");
                            $('#div_venta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
                        },
                        success: function (html) {
                            $('#div_venta_form').html(html);
                                venta_cliente_reg();
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
                                            cmb_lugar_vehiculo();
                                            filtro_bus();
                                        }
                                    },
                                    Cancelar: function() {
                                        $('#for_ven').each (function(){this.reset();});
                                        $('#cmb_parada_id').val('');
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

    .reserva{
        background: #dd09ff !important;
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
        padding: 0px;
        font-size: 1.2em;
        width: 40px;
        height: 50px;
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
        <input type="hidden" id="hdd_cli_res" value="">
        <input type="hidden" id="hdd_act_res" value="">
        <div id="origen_destino">
            <fieldset><legend>Seleccionar Origen y Destino</legend>

                <table border="0" cellspacing="2" cellpadding="0">
                    <tr>
                        <td valign="top">
                            <label for="cmb_salida_id">Origen</label><br>
                            <select name="cmb_salida_id" id="cmb_salida_id">
                            </select>
                        </td>
                        <td valign="top">
                            <label for="cmb_salida_id">Parada</label><br>
                            <select name="cmb_parada_id" id="cmb_parada_id">
                            </select>
                        </td>
                        <td valign="top"><label for="cmb_llegada_id">Destino:</label><br>
                            <select name="cmb_llegada_id" id="cmb_llegada_id">
                            </select>
                        </td>
                        <td valign="top">
                            <label for="cmb_fech_sal">F. Salida</label><br>
                            <select name="cmb_fech_sal" id="cmb_fech_sal">
                            </select>
                        </td>
                        <td align="center" valign="top"><label for="cmb_horario">Hora Salida:</label><br>
                            <select name="cmb_horario" id="cmb_horario">
                            </select>
                        </td>

                        <td valign="top"><label for="txt_precio">Precio:</label><br>
                            <input class="venpag_moneda__" name="txt_precio" size="4" type="text" id="txt_precio">
                        </td>
                        <td align="left" valign="middle">
                            <a id="btn_agregar_horario" title="Agregar Horarios de salida de bus" href="#" onClick="venta_horario_form()">Agregar Horario</a>
                        </td>
                        <td align="center" valign="top">
                            <div id="msj_horario" class="ui-state-highlight ui-corner-all" style="width: 195px;display: none;position: absolute;top: 8%;right: 3%;"></div>
                            <div id="msj_asientoestado" class="ui-state-highlight ui-corner-all" style="width: 195px;display: none;position: absolute;top: 8%;right: 3%;"></div>
                        </td>
                </table>
            </fieldset>
        </div>
        <div id="bus" style="width: 80%;float:left">

        </div>
        <div id="pasajero" style="width: 20%;float: right">
            <fieldset><legend>Datos Pasajero</legend>
                <div id="radio">
                    <input name="rad_cli_tip" type="radio" id="radio1" value="1" checked="checked"/><label for="radio1">DNI</label>
                    <input name="rad_cli_tip" type="radio" id="radio3" value="3"><label for="radio3">OTROS</label>
                </div>
                <label for="txt_pasaj_dni" id="lbl_cli_doc">DNI:</label><br>
                <input name="txt_pasaj_dni" type="text"  id="txt_pasaj_dni" value="" size="20" maxlength="8"><br>
                <label for="txt_pasaj_nom">NOMBRE: </label><br>
                <input name="txt_pasaj_nom" type="text"  id="txt_pasaj_nom" value="" size="20"><br>
            </fieldset>
            <br>
            <br>
        </div>
        <div id="datos-vehiculo" style="width: 20%;float: right">
            <fieldset><legend>Datos Vehiculo</legend>
                <table>
                    <tr>
                        <td width="100%" align="left"  valign="top">
                            <label for="txt_placa_vehiculo">VEHICULO:</label><br>
                            <input name="txt_placa_vehiculo" type="text" id="txt_placa_vehiculo" value="" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" align="left"  valign="top"><br>
                            <label for="txt_asientos_vehiculo">ASIENTOS:</label><br>
                            <input name="txt_asientos_vehiculo" type="text" id="txt_asientos_vehiculo" value="" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" align="left"  valign="top">
                            <label for="txt_modelo_vehiculo">MODELO:</label><br>
                            <input name="txt_modelo_vehiculo" type="text" id="txt_modelo_vehiculo" value="" disabled >
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <br>
        </div>

        <div id="div_venta_horario_form">

        </div>
        </form>

<div>
    <fieldset><legend>Imprimir Manifiesto</legend>
        <form action="venta_impresion_gra_manifiesto.php" target="_blank" method="post" style="text-align: center">
            <input name="hdd_vh_id" type="hidden" id="hdd_vh_id" name="hdd_vh_id"  value="">
            <button class="btn_manifiesto" id="btn_manifiesto"  type="submit" title="Imprimir manifiesto de pasajeros">Imprimir Manifiesto</button>
        </form>
    </fieldset>
</div>

<div id="menu-click">
    <ul>
        <li id="reservar">Reservar</li>
        <li id="vender">Vender</li>
        <li id="eliminar">Eliminar</li>
        <li id="detalle">Ver Detalle</li>
    </ul>
</div>


