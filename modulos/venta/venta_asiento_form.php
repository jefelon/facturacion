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

$fec=date('Y-m-d');

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

    $('#btn_editar_horario').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });

    $('#btn_manifiesto').button({
        icons: {primary: "ui-icon-print"},
        text: false

    });

    $('.btn_newwin').button({
        icons: {primary: "ui-icon-newwin"},
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
                //$('#cmb_salida_id').find('option').not(':selected').remove();
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
                //$("#cmb_llegada_id").find("option[value='<?php echo $pv['tb_lugar_id']?>']").remove();
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
                txt_vehiculo_id: $('#hdd_vehiculo').val(),
                piso:$('#cmb_piso').val()
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

            if($('#txt_cli_dni').val()=='' || $('#txt_precio').val()==''){
                var mensaje = '';
                if ($('#txt_cli_dni').val()==''){
                    mensaje = mensaje + 'Falta Documento';
                    alert(mensaje);
                    $('#txt_cli_dni').focus();
                }
                else if ($('#txt_cli_dni').val()=='' && $('#txt_precio').val()==''){
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
                        $('#txt_cli_dni').val('');
                        $('#txt_cli_nom').val('');
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
                $('#txt_placa_vehiculo').val(data.vehiculo_placa+ " "+data.vehiculo_marca);
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

    function buscar() {
        obtener_cliente_nombre();
        if ($('#txt_cli_nom').val()=="") {

            if ($('#rad_cli_tip_pas').val() == '1') {
                $('#msj_busqueda_sunat').html("Buscando en RENIEC...");
                $('#msj_busqueda_sunat').show(100);
                var dni = $('#txt_cli_dni').val();
                var url = '../../libreriasphp/consultadni/consulta_reniec.php';
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: url,
                    data: 'dni=' + dni,
                    success: function (datos_dni) {
                        $('#txt_cli_nom').val(datos_dni.persona);
                        if (datos_dni.persona != "" && datos_dni.persona != "Datos no encontrados, completa el nombre manualmente.") {
                            venta_cliente_reg();
                        }
                    }
                });
            } else if($('#rad_cli_tip_pas').val() == '2'){
                $('#msj_busqueda_sunat').html("Buscando en Sunat...");
                $('#msj_busqueda_sunat').show(100);
                $.post('../../libreriasphp/consultaruc/index.php', {
                        vruc: $('#txt_cli_dni').val(),
                        vtipod: 6
                    },
                    function (data, textStatus) {
                        if (data == null) {
                            alert('Intente nuevamente...Sunat');
                        }
                        if (data.length == 1) {

                            $('#msj_busqueda_sunat').hide();
                        } else {
                            $('#txt_cli_nom').val(data['RazonSocial']);
                            $('#txt_cli_dir').val(data['DireccionCompleta']);
                            $('#hdd_cli_est').html(data['Estado']);
                            $('#msj_busqueda_sunat').hide();
                            venta_cliente_reg();
                            $('#txt_pas_doc').focus();

                        }
                    }, "json");
            }
        }
    }
    function buscar_pas() {
            if ($('#rad_cli_tip_pas').val() == '2') {
                $('#msj_busqueda_sunat').html("Buscando en RENIEC...");
                $('#msj_busqueda_sunat').show(100);
                var dni = $('#txt_pas_doc').val();
                var url = '../../libreriasphp/consultadni/consulta_reniec.php';
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: url,
                    data: 'dni=' + dni,
                    success: function (datos_dni) {
                        $('#txt_pas_nom').val(datos_dni.persona);
                        if (datos_dni.persona != "" && datos_dni.persona != "Datos no encontrados, completa el nombre manualmente.") {
                            venta_pas_reg();
                        }
                    }
                });
            }
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

    function venta_vh_vehiculo_form(act,idf){
        $.ajax({
            type: "POST",
            url: "../venta/venta_vh_vehiculo_form.php",
            // url: "../venta/croquis.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                veh_id: $('#hdd_vehiculo').val(),
                vh_id: $('#hdd_vi_ho').val()
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

    function venta_postergar_form(act){
        $.ajax({
            type: "POST",
            url: "../venta/venta_postergar_form.php",
            // url: "../venta/croquis.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                hdd_vehiculo:$('#hdd_vehiculo').val(),
                hdd_vi_ho_pos:$('#hdd_vi_ho_pos').val(),
            }),
            beforeSend: function() {
                $('#msj_venta').hide();
                $('#div_postergacion_form').dialog("open");
                $('#div_postergacion_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_postergacion_form').html(html);
            }
        });
    }

    function venta_detalle_viaje(){
        var id_seleccionado = ($('.seleccionado').attr("id")).split('_')[1];
        $.ajax({
            type: "POST",
            url: "../venta/venta_detalleviaje.php",
            // url: "../venta/croquis.php",
            async:true,
            dataType: "html",
            data: ({
                asiento_id: id_seleccionado,
                viaje_horario_id: $('#hdd_vi_ho').val()
            }),
            beforeSend: function() {
                $('#msj_venta').hide();
                $('#div_detalleviaje').dialog("open");
                $('#div_detalleviaje').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_detalleviaje').html(html);
            }
        });
    }

    function venta_cliente_reg() {
        $.ajax({
            type: "POST",
            url: "../clientes/cliente_reg.php",
            async: true,
            dataType: "json",
            data: ({
                action_cliente: 'insertar',
                txt_cli_nom: $('#txt_cli_nom').val(),
                txt_cli_doc: $('#txt_cli_dni').val(),
                rad_cli_tip: $("#rad_cli_tip_pas").val(),
                txt_cli_dir: $('#txt_cli_dir').val(),
            }),
            beforeSend: function () {
                $('#msj_cliente').html("Guardando...");
                $('#msj_cliente').show(100);
            },
            success: function (data) {
                $('#msj_cliente').html(data.cli_msj);
               cliente_cargar_datos(data.cli_id);
            },
            complete: function () {
            }
        })
    }
    function venta_pas_reg() {
        $.ajax({
            type: "POST",
            url: "../clientes/cliente_reg.php",
            async: true,
            dataType: "json",
            data: ({
                action_cliente: 'insertar',
                txt_cli_nom: $('#txt_pas_nom').val(),
                txt_cli_doc: $('#txt_pas_doc').val(),
                rad_cli_tip: 1,
                txt_cli_dir:'',
            }),
            beforeSend: function () {
                $('#msj_cliente').html("Guardando...");
                $('#msj_cliente').show(100);
            },
            success: function (data) {
                $('#msj_cliente').html(data.cli_msj);
                $('#hdd_ven_pas_id').val(data.cli_id);
                //$('#txt_pas_nom').val(data.cli_nom);
            },
            complete: function () {
            }
        })
    }

    function cliente_cargar_datos(idf){
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
                $('#hdd_ven_cli_id').val(idf);
                $('#txt_cli_nom').val(data.nombre);
                $('#txt_cli_dni').val(data.documento);
                $('#txt_cli_dir').val(data.direccion);
            }
        });
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
                txt_cli_nom: $('#txt_cli_nom').val(),
                txt_cli_doc: $('#txt_cli_dni').val(),
                rad_cli_tip: $("#rad_cli_tip_pas").val()
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

    function obtener_cliente_nombre(){
        $.ajax({
            type: "POST",
            url: "../clientes/cliente_reg.php",
            async:false,
            dataType: "json",
            data: ({
                action: "obtener_nombre",
                txt_cli_doc:	$('#txt_cli_dni').val()
            }),
            beforeSend: function() {
                //$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(data){
                $('#hdd_ven_cli_id').val(data.cli_id);
                //$('#txt_cli_dni').val(data.cli_doc);
                $('#txt_cli_nom').val(data.cli_nom);
                $('#txt_cli_dir').val(data.cli_dir);

            }
        });
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
                $('#txt_cli_dni').val(data.documento);
                $('#txt_cli_nom').val(data.nombre);
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
                async: false,
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
                }
            })

        }
    }
    function validar_reserva(){
        var result='';
        $.ajax({
            type: "POST",
            url: "../venta/venta_valida_asiento.php",
            async:false,
            dataType: "json",
            data: ({
                veh_id:$('#hdd_vehiculo').val(),
                num_asi:($('.seleccionado').attr("id")).split('_')[1],
                txt_cli_doc:$('#txt_cli_dni').val(),
                cmb_fech_sal:$('#cmb_fech_sal').val(),
                cmb_horario:$('#cmb_horario').val()
            }),
            beforeSend: function() {

            },
            success: function(data){
                result = data.estado;
            }
        });
        return result
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
            $("#menu-click").css({'display': 'block', 'left': position.left+40, 'top': position.top+40 });
            $("#reservar").css({'display': 'none'});
            $("#vender").css({'display': 'none'});
            $("#eliminar").css({'display': 'none'});
            $("#postergar").css({'display': 'block'});
            $("#detalle").css({'display': 'block'});
            seleccionar(selector);

        }else if($(selector).hasClass('reserva')){
            $("#menu-click").css({'display': 'block', 'left': position.left+40, 'top': position.top+40 });
            $("#reservar").css({'display': 'none'});
            $("#eliminar").css({'display': 'block'});
            $("#vender").css({'display': 'block'});
            $("#postergar").css({'display': 'none'});
            $("#detalle").css({'display': 'block'});
            $("#hdd_act_res").val(cli_id);
            $("#hdd_ven_cli_id").val(cli_id);
            $("#hdd_ven_pas_id").val(cli_id);
            seleccionar(selector);

        }else {
            seleccionar(selector);
            $("#menu-click").css({'display': 'block', 'left': position.left+40, 'top': position.top+40 });
            $("#reservar").css({'display': 'block'});
            $("#vender").css({'display': 'none'});
            $("#eliminar").css({'display': 'none'});
            $("#postergar").css({'display': 'none'});
            $("#detalle").css({'display': 'none'});
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
                case "postergar":
                    venta_postergar_form();
                    break;
                case "detalle":
                    venta_detalle_viaje();
                    break;
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
            $('#bus').html('');
            $('#hdd_vi_ho').val('');
            $('#cmb_parada_id').prop("disabled", false);
            $('#cmb_parada_id').removeClass("ui-state-disabled");

        });

        $('#cmb_salida_id').change(function(){
            $('#cmb_horario').val('');
            cmb_fecha();
            $('#txt_placa_vehiculo').val('');
            $('#bus').html('');
            $('#hdd_vi_ho').val('');

        });




        $('#cmb_horario').change(function(){
            cmb_horario_vehiculo();
            filtro_bus();

        });
        $('#cmb_piso').change(function(){
            filtro_bus();
        });

        $('#cmb_fech_sal').change(function(){
            cmb_fecha_horario();
            $('#txt_placa_vehiculo').val('');
            $('#bus').html('');
            $('#hdd_vi_ho').val('');
        });



        $( "#txt_precio" ).keypress(function( event ) {
            if ( event.which == 13 ) {
                $( "#txt_cli_dni" ).focus();
            }

        });
        $( "#txt_cli_dni" ).keypress(function( event ) {
            if ( event.which == 13) {
                buscar();
                $( "#txt_pas_doc" ).focus();
            }

        });
        $( "#txt_pas_doc" ).keypress(function( event ) {
            if ( event.which == 13) {
                buscar_pas();
            }

        });
        $("#txt_cli_dni").keydown(function (e) {

            if($("#rad_cli_tip_pas").val()==1 || $("#rad_cli_tip_pas").val()==2) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && e.ctrlKey === true) || (e.keyCode >= 35 && e.keyCode <= 39)) {
                    return;
                }

                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            }
        });

        $("#txt_precio").keydown(function (e){
            // Capturamos qué telca ha sido
            var keyCode= e.which;
            // Si la tecla es el Intro/Enter
            if (keyCode == 13){
                // Evitamos que se ejecute eventos
                event.preventDefault();
                // Devolvemos falso
                $("#txt_cli_dni").focus();
                return false;
            }
        });

        $('#cmb_ven_doc').change( function(){
           if( $('#cmb_ven_doc').val()=='12' ||  $('#cmb_ven_doc').val()=='15') //boleta o nota
           {
               $('#rad_cli_tip_pas').val('1');
               $('#txt_cli_dni').attr('maxlength', 8);
               $('#field_pasajero').css("display", "none");
           }
           else{
               $('#rad_cli_tip_pas').val('2');
               $('#txt_cli_dni').attr('maxlength', 11);
               $('#field_pasajero').css("display", "block");
            }

            $('#hdd_ven_cli_id').val("");
            $('#txt_cli_dni').val("");
            $('#txt_cli_nom').val("");
            $('#txt_cli_dir').val("");

           $('#txt_cli_dni').focus();
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

        $( "#div_postergacion_form" ).dialog({
            title:'Postergación de Viaje | <?php echo $_SESSION['empresa_nombre']?>',
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
                    $("#postergar_form").submit();
                },
                Cancelar: function() {
                    $('#postergar_form').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            }
        });

        $( "#div_detalleviaje" ).dialog({
            title:'Detalle de Viaje | <?php echo $_SESSION['empresa_nombre']?>',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 'auto',
            zIndex: 1,
            modal: true,
            position: "center",
            closeOnEscape: false,
            buttons: {
                Cerrar: function() {
                    $( this ).dialog( "close" );
                }
            }
        });






        $("#bus_form").validate({
            submitHandler: function () {
                var asi_est=validar_reserva();
                if(asi_est=="ocupado" || asi_est=="reserva"){
                    alert("Este asiento fue reservado o vendido en otro punto hace instantes...\n Si hizo esta reserva, intente otra vez. \n Se recargará el croquis de asientos.");
                    return false;
                    filtro_bus();
                }
                if($('.seleccionado').length<=0){
                    alert('Seleccione un asiento');
                }else{
                    venta_cliente_reg();
                    var id_seleccionado = ($('.seleccionado').attr("id")).split('_')[1];
                    $.ajax({
                        type: "POST",
                        url: "../venta/venta_reg_rapida.php",
                        async:true,
                        dataType: "json",
                        data: ({
                            action_venta: 'insertar',
                            ven_id:	'',
                            txt_num_asi: id_seleccionado,
                            txt_ven_opegra:0,
                            txt_ven_opeexo: $('#txt_precio').val(),
                            txt_fech_sal: $('#cmb_fech_sal').val(),
                            hdd_vi_ho_id: $('#hdd_vi_ho').val(),
                            txt_hor_sal: $('#cmb_horario').val(),
                            hdd_ven_cli_id:$('#hdd_ven_cli_id').val(),
                            hdd_ven_pas_id:$('#hdd_ven_pas_id').val(),
                            viaje_partida_text:$('#cmb_salida_id option:selected').html(),
                            viaje_parada_text:$('#cmb_parada_id option:selected').html(),
                            viaje_llegada_text:$('#cmb_llegada_id option:selected').html(),
                            viaje_salida: $('#cmb_salida_id').val(),
                            viaje_parada: $('#cmb_parada_id').val(),
                            viaje_llegada: $('#cmb_llegada_id').val(),
                            chk_venpag_aut:1,
                            hdd_tipo:'pasaje',
                            detalle_array:1,
                            servicio_tip:9,
                            hdd_punven_id: <?php echo $_SESSION['puntoventa_id']?>,
                            hdd_emp_id:<?php echo $_SESSION['empresa_id']?>,
                            cmb_ven_doc:$('#cmb_ven_doc').val(),
                            cmb_forpag_id:1,
                            chk_imprimir:1,
                            txt_ven_fec:'<?php echo $fec ?>',
                            txt_venpag_mon:$('#txt_precio').val(),
                            txt_venpag_fecven:'<?php echo $fec ?>',
                            cmb_modpag_id:1,
                            txt_ven_valven:0,
                            txt_ven_igv:0,
                            txt_com_destotal:0,
                            txt_ven_tot:$('#txt_precio').val(),
                            cmb_ven_est:"CANCELADA",
                            cmb_ven_moneda:1,
                            hdd_usu_id:<?php echo $_SESSION['usuario_id'] ?>

                        }),
                        beforeSend: function () {

                        },
                        success: function (data) {

                            if(data.redireccionar){
                                alert("Venta No Registrada.\n Por Favor Inicie Sesión Nuevamente.");
                                window.location.href = "../usuarios/cerrar_sesion.php";
                                return;
                            }

                            $('#msj_venta').html(data.ven_msj);

                            if(data.ven_sun=='enviar')
                            {
                                console.log('enviar sunat');
                                enviar_sunat(data.ven_id,data.ven_act);
                            }
                            else
                            {
                                if(data.ven_act=='imprime')
                                {
                                    console.log('imprimir');
                                    venta_impresion_pas(data.ven_id);
                                }
                            }

                        },
                        complete: function () {
                            venta_tabla();
                            filtro_bus();
                            $('#txt_cli_dni').val('');
                            $('#txt_cli_nom').val('');
                            $('#txt_cli_dir').val('');
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
                },
                txt_cli_dni:{
                    required: true
                },
                txt_cli_nom:{
                    required: true
                },
                rad_cli_tip_pas: {
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
                },
                txt_cli_dni:{
                    required: '*'
                },
                txt_cli_nom:{
                    required: '*'
                },
                rad_cli_tip_pas: {
                    required: '*'
                }
            }
        });
    });
</script>

<style>
    #bus{
        width: 1000px;
        height: 480px;
        /*background: url("../../images/bus_fondo.png");*/
        /*background-size: 99%;*/
        /*background-repeat: no-repeat;*/
        /*background-position-x: -45px;*/
        /*overflow: hidden;*/
    }
</style>

<form id="bus_form">
    <input type="hidden" id="hdd_vehiculo" value="">
    <input type="hidden" id="hdd_vi_ho" value="">
    <input type="hidden" id="hdd_cli_res" value="">
    <input type="hidden" id="hdd_act_res" value="">
    <input type="hidden" id="hdd_precio" value="">
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
                        <select name="cmb_horario" id="cmb_horario" style="width: 100%;font-size: 1.6em;">
                        </select>
                    </td>

                    <td valign="top"><label for="txt_precio">Precio:</label><br>
                        <input class="venpag_moneda__" name="txt_precio" size="4" type="text" id="txt_precio">
                    </td>
                    <td align="left" valign="middle">
                        <a id="btn_agregar_horario" title="Agregar Horarios de salida de bus" href="#" onClick="venta_horario_form()">Agregar Horario</a>
                    </td>
                    <td align="left" valign="middle">
                        <a id="btn_editar_horario" title="Editar Horario de salida de bus" href="#" onClick="venta_vh_vehiculo_form()">Agregar Horario</a>
                    </td>
                    <td align="center" valign="top">
                        <div id="msj_horario" class="ui-state-highlight ui-corner-all" style="width: 195px;display: none;position: absolute;top: 8%;right: 3%;"></div>
                        <div id="msj_asientoestado" class="ui-state-highlight ui-corner-all" style="width: 195px;display: none;position: absolute;top: 8%;right: 3%;"></div>
                    </td>
                    <td align="center" valign="top">
                    <a class="btn_newwin" target="_blank" title="Saltar a otra pestaña" href="venta_vista_encomienda.php">Saltar</a>
                    </td>
            </table>
        </fieldset>
    </div>
    <div id="bus" style="width: 80%;float:left">

    </div>
</form>
    <div style="width: 20%;float: right">
        <div id="documento">
                <fieldset><legend>Tipo Comprobante</legend>
                    <select name="cmb_ven_doc" id="cmb_ven_doc">
                        <option value="12" selected="">BE | BOLETA ELECTRONICA</option>
                        <option value="11">FE | FACTURA ELECTRONICA</option>
                        <option value="15">NS | NOTA DE SALIDA</option>
                    </select>
                </fieldset>
        </div>
        <div id="pasajero">
            <form id="datos_pasajero">
            <fieldset><legend>Datos Cliente</legend>
                <div id="radiopas">
                    <input type="hidden" name="hdd_ven_cli_id" id="hdd_ven_cli_id" value="">
                    <select name="rad_cli_tip_pas" id="rad_cli_tip_pas">
                        <option value="1">DNI</option>
                        <option value="2">RUC</option>
                        <option value="3">OTROS</option>
                    </select>
                    <input name="txt_cli_dni" type="text"  id="txt_cli_dni" value="" size="20" maxlength="8">
                </div>
                <br>
                <label for="txt_cli_nom">NOMBRE: </label><br>
                <input name="txt_cli_nom" type="text"  id="txt_cli_nom" value="" size="29"><br>
                <label for="txt_cli_nom">DIRECCION: </label><br>
                <input name="txt_cli_dir" type="text"  id="txt_cli_dir" value="" size="29">
            </fieldset>
            <fieldset id="field_pasajero" style="display: none">
                <legend>Datos Pasajero</legend>

                    <input type="hidden" name="hdd_ven_pas_id" id="hdd_ven_pas_id" value="">
                    <label for="txt_pas_doc">DNI: </label><input name="txt_pas_doc" type="text"  id="txt_pas_doc" value="" size="20" maxlength="8">
                    <label for="txt_cli_nom">NOMBRE: </label>
                    <input name="txt_pas_nom" type="text"  id="txt_pas_nom" value="" size="20" maxlength="8">
            </fieldset>
            </form>
        </div>
        <div id="datos-vehiculo">
            <fieldset><legend>Datos Vehiculo</legend>
                <table>
                    <tr>
                        <td width="100%" align="left"  valign="top">
                            <label for="txt_placa_vehiculo">VEHICULO:</label><br>
                            <input name="txt_placa_vehiculo" type="text" id="txt_placa_vehiculo" value="" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" align="left"  valign="top">
                            <label for="cmb_piso">PISO:</label>
                            <select name="cmb_piso" id="cmb_piso">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </td>
                    </tr>

                </table>
            </fieldset>
        </div>
        <div>
            <fieldset><legend>Imprimir Manifiesto</legend>
                <form action="venta_impresion_gra_manifiesto.php" target="_blank" method="post" style="text-align: center">
                    <input name="hdd_vh_id" type="hidden" id="hdd_vh_id" name="hdd_vh_id"  value="">
                    <button class="btn_manifiesto" id="btn_manifiesto"  type="submit" title="Imprimir manifiesto de pasajeros">Imprimir Manifiesto</button>
                </form>
            </fieldset>
        </div>
    </div>

    <div id="div_venta_horario_form">

    </div>

<div id="div_postergacion_form">

</div>
<div id="div_detalleviaje">

</div>

<div id="menu-click">
    <ul>
        <li id="reservar">Reservar</li>
        <li id="vender">Vender</li>
        <li id="postergar">Postergar</li>
        <li id="eliminar">Eliminar</li>
        <li id="detalle">Ver Detalle</li>
    </ul>
</div>


