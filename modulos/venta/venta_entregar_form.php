<?php
session_start();
require_once ("../../config/Cado.php");

require_once("../formula/cFormula.php");
$oFormula = new cFormula();

require_once("../venta/cVenta.php");
$oVenta = new cVenta();

require_once("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();

require_once ("../formatos/mysql.php");
$oMysql= new cMysql();

require_once("../formatos/formato.php");
require_once("../menu/acceso.php");

require_once("../guia/cGuia.php");
$oGuia = new cGuia();

$rs = $oFormula->consultar_dato_formula('VEN_VENTAS_NEGATIVAS');
$dt = mysql_fetch_array($rs);
$stock_negativo = $dt['tb_formula_dat'];


//$viaje_horario=$_POST['viaje_horario_id'];


$cot_id = $_POST['cot_id'];

if($_POST['action']=="insertar"){
    //$cli_id=1;
    $fec=date('d-m-Y');
    $est='CANCELADA';
    $venpag_fec=date('d-m-Y');
    $unico_id=uniqid();

//    $asiento_id=$_POST['asiento_id'];
//    $precio=$_POST['precio'];
//    $viaje_fecha_sal=$_POST['viaje_fecha_sal'];
//    $viaje_horario= $_POST['viaje_horario'];
//    $viaje_horario_id= $_POST['viaje_horario_id'];
}

if($_POST['action']=="insertar_cot"){
    $dts= $oCotizacion->mostrarUno($_POST['cot_id']);
    $dt = mysql_fetch_array($dts);
    $fec=date('d-m-Y');
    $est='CANCELADA';
    $unico_id=uniqid();
//    $reg	=mostrarFechaHora($dt['tb_venta_reg']);

//    $fec	=mostrarFecha($dt['tb_venta_fec']);


    //$numdoc	=$dt['tb_venta_numdoc'];
//    $ser	=$dt['tb__ser'];
//    $num	=$dt['tb_venta_num'];


    $cli_id	=$dt['tb_cliente_id'];
    $cli_nom = $dt['tb_cliente_nom'];
    $cli_doc = $dt['tb_cliente_doc'];
    $cli_dir = $dt['tb_cliente_dir'];
    $cli_tip = $dt['tb_cliente_tip'];
    $cli_ret = $dt['tb_cliente_retiene'];

    $subtot	=$dt['tb_venta_subtot'];
    $igv	=$dt['tb_cotizacion_igv'];
    $tot	=$dt['tb_cotizacion_tot'];

    $punven_nom	=$dt['tb_puntocotizacion_nom'];
    $alm_nom	=$dt['tb_almacen_nom'];

    $lab1	=$dt['tb_cotizacion_lab1'];
    $lab2	=$dt['tb_cotizacion_lab2'];
    $lab3	=$dt['tb_cotizacion_lab3'];

    $may	=$dt['tb_cotizacion_may'];
    mysql_free_result($dts);
}

if($_POST['action']=="editar"){
    $dts= $oVenta->mostrarUno($_POST['ven_id']);
    $dt = mysql_fetch_array($dts);
    $reg	=mostrarFechaHora($dt['tb_venta_reg']);

    $fec	=mostrarFecha($dt['tb_venta_fec']);

    $doc_id	=$dt['tb_documento_id'];
    //$numdoc	=$dt['tb_venta_numdoc'];
    $ser	=$dt['tb_venta_ser'];
    $num	=$dt['tb_venta_num'];
    $cli_id	=$dt['tb_cliente_id'];
    $cli_nom = $dt['tb_cliente_nom'];
    $cli_doc = $dt['tb_cliente_doc'];
    $cli_dir = $dt['tb_cliente_dir'];
    $cli_tip = $dt['tb_cliente_tip'];
    $cli_ret = $dt['tb_cliente_retiene'];

    $subtot	=$dt['tb_venta_subtot'];
    $igv	=$dt['tb_venta_igv'];
    $tot	=$dt['tb_venta_tot'];
    $est	=$dt['tb_venta_est'];
    $monval	=$dt['cs_tipomoneda_id'];

    $punven_nom	=$dt['tb_puntoventa_nom'];
    $alm_nom	=$dt['tb_almacen_nom'];

    $lab1	=$dt['tb_venta_lab1'];
    $lab2	=$dt['tb_venta_lab2'];
    $lab3	=$dt['tb_venta_lab3'];

    $may	= $dt['tb_venta_may'];
    $use_id = $dt['tb_vendedor_id'];

    mysql_free_result($dts);

    $guias = $oGuia->mostrarGuiaUno($_POST['ven_id']);
    $guia = mysql_fetch_array($guias);
    $guia_id = $guia['tb_guia_id'];

    $serguia	=$guia['tb_guia_serie'];
    $numguia	=$guia['tb_guia_num'];
    mysql_free_result($guias);
}
?>
<script type="text/javascript">
    $('.btn_imp').button({
        icons: {primary: "ui-icon-print"},
        text: false
    });

    $('.btn_venpag_agregar').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });

    $('.btn_ir').button({
        icons: {primary: "ui-icon-newwin"},
        text: false
    });
    $('.btn_newwin').button({
        icons: {primary: "ui-icon-newwin"},
        text: false
    });

    $('.btn_cli_reg').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });
    $(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_cli_form_agregar,#btn_pas_form_agregar,#btn_des_form_agregar').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });
    $("#btn_cli_form_agregar,#btn_pas_form_agregar,#btn_des_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_cli_form_modificar, #btn_pas_form_modificar,#btn_des_form_modificar').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });
    $("#btn_cli_form_modificar, #btn_pas_form_modificar,#btn_des_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_con_form_agregar').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });




    function cliente_form_i(act,idf,nom,dir,con,tel,est){
        $.ajax({
            type: "POST",
            url: "../clientes/cliente_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: 		act,
                cli_id:			idf,
                cli_nom:		nom,
                cli_dir:		dir,
                cli_con:		con,
                cli_tel:		tel,
                cli_est:		est,
                vista:			'hdd_cli_id'
            }),
            beforeSend: function(a) {
                //$('#msj_proveedor').hide();
                //$("#btn_cmb_pro_id").click(function(e){
                $("#btn_cli_form_agregar").click(function(e){
                    //x=e.pageX+5;
                    //y=e.pageY+15;
                    //$('#div_cliente_form').dialog({ position: [x,y] });
                    $('#div_cliente_form').dialog("open");
                });

                if(act=='editar'){
                    if(idf>0){
                        $("#btn_cli_form_modificar").click(function(e){
                            //x=e.pageX+5;
                            //y=e.pageY+15;
                            //$('#div_cliente_form').dialog({ position: [x,y] });
                            $('#div_cliente_form').dialog("open");
                        });
                    }
                    else{
                        alert('Seleccione Cliente');
                    }
                }

                if(act=='editarSunat'){
                    //x=a.pageX+5;
                    //y=a.pageY+15;
                    //$('#div_cliente_form').dialog({ position: [x,y] });
                    $('#div_cliente_form').dialog("open");
                }

                $('#div_cliente_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_cliente_form').html(html);
            },
            complete: function(){
                if(act=='insertar' & $('#hdd_ven_cli_id').val()=="")
                {
                    $('#txt_cli_doc').val($('#txt_ven_cli_doc').val());
                    $('#txt_cli_nom').val($('#txt_ven_cli_nom').val());
                }

            }
        });
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
                $('#hdd_ven_cli_id').change();
                $('#txt_ven_cli_nom').val(data.nombre);
                $('#txt_ven_cli_doc').val(data.documento);
                $('#txt_ven_cli_dir').val(data.direccion);
                $("#hdd_ven_cli_tip").val(data.tipo);
                $('#txt_ven_cli_est').val(data.estado);
                $('#hdd_ven_cli_ret').val(data.retiene);
                $('#hdd_cli_precio_id').val(data.precio_id);
            }
        });
    }


    function cmb_dir_id(ids)
    {
        $.ajax({
            type: "POST",
            url: "../clientes/cmb_cli_dir.php",
            async:true,
            dataType: "html",
            data: ({
                cli_id: ids
            }),
            beforeSend: function() {
                $('#cmb_cli_suc').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_cli_suc').html(html);

                var direccionPrincipal=  $('#txt_ven_cli_dir').val();
                if($("#hdd_ven_cli_id" ).val()>0){
                    $('#cmb_cli_suc').append($('<option>', {
                        value: 0,
                        text : direccionPrincipal
                    }));
                    $("#cmb_cli_suc option[value='0']").attr("selected", true);
                }

            }
        });
    }


    function venta_encomienda_tabla()
    {
        $.ajax({
            type: "POST",
            url: 'venta_encomienda_tabla.php',
            async:true,
            dataType: "html",
            data: ({
                hdd_ven_cli_id: $("#hdd_ven_cli_id").val()
            }),
            beforeSend: function(){
                $('#div-tabla-encomiendas').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div-tabla-encomiendas').html(html);
            },
            complete: function(){
                $('#div-tabla-encomiendas').removeClass("ui-state-disabled");
            }
        });
    }

    $(function() {

        $( "#div_cliente_form" ).dialog({
            title:'Información de Cliente',
            autoOpen: false,
            resizable: false,
            height: 330,
            width: 530,
            zIndex: 4,
            modal: true,
            position: ["center",0],
            buttons: {
                Guardar: function() {
                    $("#for_cli").submit();
                },
                Cancelar: function() {
                    $('#for_cli').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            }
        });




        $('#txt_ven_cli_nom').change(function(){
            $(this).val($(this).val().toUpperCase());
        });



        $( "#txt_ven_cli_nom" ).autocomplete({
            minLength: 1,
            source: "../clientes/cliente_complete_nom.php",
            select: function(event, ui){
                $("#hdd_ven_cli_id").val(ui.item.id);
                $("#txt_ven_cli_doc").val(ui.item.documento);
                $("#txt_ven_cli_dir").val(ui.item.direccion);
                $("#hdd_ven_cli_tip").val(ui.item.tipo);
                $("#hdd_ven_cli_ret").val(ui.item.retiene);
                $("#hdd_cli_precio_id").val(ui.item.precio_id);
                $('#hdd_ven_cli_id').change();
                venta_encomienda_tabla()

                //alert(ui.item.value);
                // $('#msj_busqueda_sunat').html("Buscando en Sunat...");
                // $('#msj_busqueda_sunat').show(100);
                // compararSunat(ui.item.documento, ui.item.value, ui.item.direccion, ui.item.id);
            }
        });



        $( "#txt_ven_cli_doc" ).autocomplete({
            minLength: 1,
            source: "../clientes/cliente_complete_doc.php",
            select: function(event, ui){
                $("#hdd_ven_cli_id").val(ui.item.id);
                $("#txt_ven_cli_nom").val(ui.item.nombre);
                $("#txt_ven_cli_dir").val(ui.item.direccion);
                $("#txt_fil_gui_cod").val(ui.item.codigo);
                $("#hdd_ven_cli_tip").val(ui.item.tipo);
                $("#hdd_ven_cli_ret").val(ui.item.retiene);
                $("#hdd_cli_precio_id").val(ui.item.precio_id);
                $('#hdd_ven_cli_id').change();
                venta_encomienda_tabla();
                //alert(ui.item.value);
                // $('#msj_busqueda_sunat').html("Buscando en Sunat...");
                // $('#msj_busqueda_sunat').show(100);
                // compararSunat(ui.item.value, ui.item.nombre, ui.item.direccion, ui.item.id);
            }
        });











        $( "#div_cliente_form" ).dialog({
            title:'Información de Cliente',
            autoOpen: false,
            resizable: false,
            height: 330,
            width: 530,
            zIndex: 4,
            modal: true,
            position: ["center",0],
            buttons: {
                Guardar: function() {
                    $("#for_cli").submit();
                },
                Cancelar: function() {
                    $('#for_cli').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            }
        });


//formulario
        $("#for_ven").validate({
            submitHandler: function(){

                $.ajax({
                    type: "POST",
                    url: "../venta/venta_reg.php",
                    async:true,
                    dataType: "json",
                    data: $("#for_ven").serialize(),
                    beforeSend: function(){
                        $('#div_venta_form').dialog("close");
                        $('#msj_venta').html("Guardando...");
                        $('#msj_venta').show(100);
                    },
                    success: function(data){
                        if(data.redireccionar){
                            alert("Venta No Registrada.\n Por Favor Inicie Sesión Nuevamente.");
                            window.location.href = "../usuarios/cerrar_sesion.php";
                            return;
                        }

                        $('#msj_venta').html(data.ven_msj);

                        if(data.ven_sun=='enviar')
                        {
                            enviar_sunat(data.ven_id,data.ven_act);
                        }
                        else
                        {
                            if(data.ven_act=='imprime')
                            {
                                venta_impresion(data.ven_id);
                            }
                        }
                    },
                    complete: function(){
                        venta_tabla();
                        //sventa_asiento_form();
                    }
                });
            },
            rules: {
                txt_ven_fec: {
                    required: true,
                    dateITA: true
                },
                cmb_ven_doc: {
                    required: true
                },
                txt_ven_numdoc: {
                    required: true
                },
                hdd_ven_cli_id: {
                    required: true,
                    totalDoc: "#cmb_ven_doc"
                },
                hdd_ven_pas_id: {
                    required: true,
                },
                hdd_ven_numite: {
                    required: true
                },
                cmb_ven_est: {
                    required: true
                },
                hdd_ven_pag_numite: {
                    required: true
                },
                hdd_venpag_tot: {
                    equalTo: "#txt_ven_tot"
                },
                hdd_ven_cli_tip: {
                    equalOr: "#hdd_val_cli_tip"
                },
                hdd_ven_doc: {
                    required: true
                }
            },
            messages: {
                txt_ven_fec: {
                    required: '*'
                },
                cmb_ven_doc: {
                    required: '*'
                },
                txt_ven_numdoc: {
                    required: '*'
                },
                hdd_ven_cli_id: {
                    required: 'Seleccione Cliente.'
                },
                hdd_pas_cli_id: {
                    required: 'Seleccione Cliente.'
                },
                hdd_ven_numite: {
                    required: 'Agregue producto a detalle de venta.'
                },
                cmb_ven_est: {
                    required: '*'
                },
                hdd_ven_pag_numite: {
                    required: 'Agregue registro de pagos.'
                },
                hdd_venpag_tot: {
                    equalTo: "No es igual a Monto Total de Venta."
                },
                hdd_ven_doc: {
                    required: "Existe registro con mismo N° Documento."
                }
            }
        });
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>

<style>
    .carro{
        overflow-x: hidden;
    }
</style>
<div class="carro">
    <form id="for_ven">
            <div id="datos-cliente" style="width: 100%%;">
                <input type="hidden" id="hdd_ven_cli_id" name="hdd_ven_cli_id" value="<?php echo $cli_id?>" />

                <fieldset>
                    <legend>Datos Cliente</legend>
                    <div id="div_cliente_form">
                    </div>
                    <table>
                        <tr>
                            <td align="right"><?php if($_POST['action']=='insertar'){?>
                                    <a id="btn_cli_form_agregar" href="#" onClick="cliente_form_i('insertar')">Agregar Cliente</a>
                                    <a id="btn_cli_form_modificar" href="#" onClick="cliente_form_i('editar',$('#hdd_ven_cli_id').val())">Modificar Cliente</a>
                                <?php }?>

                            </td>

                            <td align="right">
                                <label for="txt_ven_cli_doc">RUC/DNI:</label>
                            </td>
                            <td>
                                <input name="txt_ven_cli_doc" type="text" id="txt_ven_cli_doc" value="<?php echo $cli_doc?>" size="11" maxlength="11" />

                                <label for="txt_ven_cli_nom">Cliente:</label>
                                <input type="text" id="txt_ven_cli_nom" name="txt_ven_cli_nom" size="40" value='<?php echo $cli_nom?>' />
                            </td>

    <!--                        <td align="right"><label for="txt_ven_cli_est">Estado:</label></td>-->
                            <td>
                                <input type="hidden" id="txt_ven_cli_est" name="txt_ven_cli_est" size="40" value="" disabled="disabled"/>
                                <div id="msj_busqueda_sunat" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
        <div id="msj_encomienda" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
            <div id="div-tabla-encomiendas">

            </div>
        
<script type="text/javascript">
    //catalogo_venta_tab();
</script>
