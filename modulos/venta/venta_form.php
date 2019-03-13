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


$cot_id = $_POST['cot_id'];

if($_POST['action']=="insertar"){
    //$cli_id=1;
    $fec=date('d-m-Y');
    $est='CANCELADA';
    $venpag_fec=date('d-m-Y');

    $unico_id=uniqid();
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

    $('#btn_cli_form_agregar').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });
    $("#btn_cli_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_cli_form_modificar').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });
    $("#btn_cli_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_con_form_agregar').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });
    $("#btn_con_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_con_form_modificar').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });
    $("#btn_con_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_tra_form_agregar').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });
    $("#btn_tra_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_tra_form_modificar').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });
    $("#btn_tra_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('.venpag_moneda').autoNumeric({
        aSep: ',',
        aDec: '.',
        //aSign: 'S/. ',
        //pSign: 's',
        vMin: '0.00',
        vMax: '999999999999.99'
    });
    $('.dias').autoNumeric({
        aSep: ',',
        aDec: '.',
        //aSign: 'S/. ',
        //pSign: 's',
        vMin: '0',
        vMax: '365'
    });

    $( "#txt_ven_fec" ).datepicker({
        minDate: new Date((new Date()).getFullYear(), 0, 1),
        maxDate:"+0D",
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

    $( "#txt_venpag_fec" ).datepicker({
        //minDate: "-1M",
        maxDate:"+0D",
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
    //
    // $("#txt_letras_fecven1,#txt_letras_fecven2,#txt_letras_fecven3,#txt_letras_fecven4,#txt_letras_fecven5").datepicker({
    //     //minDate: "-1M",
    //     maxDate:"+0D",
    //     yearRange: 'c-0:c+0',
    //     changeMonth: true,
    //     changeYear: false,
    //     dateFormat: 'dd-mm-yy',
    //     //altField: fecha,
    //     //altFormat: 'yy-mm-dd',
    //     showOn: "button",
    //     buttonImage: "../../images/calendar.gif",
    //     buttonImageOnly: true
    // });


    $('.cantidad_letras').autoNumeric({
        aSep : '',
        vMax : '5',
        vMin : '0'
    });

    /*$( "#txt_venpag_fecven" ).datepicker({
        minDate: "-0D",
        //maxDate:"+0D",
        yearRange: 'c-0:c+0',
        changeMonth: true,
        changeYear: false,
        dateFormat: 'dd-mm-yy',
        //altField: fecha,
        //altFormat: 'yy-mm-dd',
        //showOn: "button",
        buttonImage: "../../images/calendar.gif",
        buttonImageOnly: true
    });*/

    // Validators
    jQuery.validator.addMethod("equalOr", function(value, element, parameter) {
        return $(parameter).val() === value || $(parameter).val() === '15';
    }, "Tipo de cliente no concuerda con tipo de documento.");

    jQuery.validator.addMethod("totalDoc", function(value, element, parameter) {
        if ($(parameter).val() === '12' && value==='1'){
            return parseFloat($('#txt_ven_tot').val()) <= parseFloat('700.00');
        }else{
            return true;
        }
    }, "Selecccione otro cliente, monto mayor a 700");

    function cmb_listaprecio_id(ids,cliente_id)
    {
        $.ajax({
            type: "POST",
            url: "../listaprecio/cmb_precio_id.php",
            async:true,
            dataType: "html",
            data: ({
                precio_id: ids,
                cliente_id: cliente_id
            }),
            beforeSend: function() {
                $('#cmb_listaprecio_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_listaprecio_id').html(html);
            }
        });

    }
    function cmb_cuecor_id(ids)
    {
        $.ajax({
            type: "POST",
            url: "../cuentacorriente/cmb_cuecor_id.php",
            async:true,
            dataType: "html",
            data: ({
                cuecor_id: ids
            }),
            beforeSend: function() {
                $('#cmb_cuecor_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_cuecor_id').html(html);
            }
        });
    }
    function cmb_tar_id(ids)
    {
        $.ajax({
            type: "POST",
            url: "../tarjeta/cmb_tar_id.php",
            async:true,
            dataType: "html",
            data: ({
                tar_id: ids
            }),
            beforeSend: function() {
                $('#cmb_tar_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_tar_id').html(html);
            }
        });
    }
    function cmb_ven_doc()
    {
        $.ajax({
            type: "POST",
            url: "../documento/cmb_doc_id.php",
            async:true,
            dataType: "html",
            data: ({
                doc_tip:	'2',
                doc_id: '<?php echo $doc_id?>',
                vista:	'<?php echo $_POST['action']?>'
            }),
            beforeSend: function() {
                $('#cmb_ven_doc').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_ven_doc').html(html);
            },
            complete: function(){
                <?php if($_POST['action']=="insertar" or $_POST['action']=="insertar_cot"){?>
                txt_ven_numdoc();
                if ($('#cmb_ven_doc').val()==12){
                    cliente_cargar_datos(1);
                }
                <?php }?>
            }
        });
    }
    function txt_ven_numdoc(){
        $.ajax({
            type: "POST",
            url: "../venta/venta_txt_numdoc.php",
            async:false,
            dataType: "json",
            data: ({
                doc_id: $('#cmb_ven_doc').val()
            }),
            beforeSend: function() {
                $('#txt_ven_numdoc').val('Cargando...');


                if($('#cmb_ven_doc').val()*1==2 || $('#cmb_ven_doc').val()*1==11)//factura
                {
                    txt_ven_numdocguia();
                    $('#hdd_val_cli_tip').val('2');
                }
                if($('#cmb_ven_doc').val()*1==3 || $('#cmb_ven_doc').val()*1==12)//boleta
                {
                    $('#hdd_val_cli_tip').val('1');
                }
                if($('#cmb_ven_doc').val()*1==15)//nota de salida
                {
                    $('#hdd_val_cli_tip').val('15');
                }
            },
            success: function(data){
                $('#txt_ven_numdoc').val(data.numero);
                if(data.msj!="")
                {
                    $('#msj_venta_form').html(data.msj);
                    $('#msj_venta_form').show(100);
                }
                else
                {
                    $('#msj_venta_form').hide();
                }
            },
            complete: function(){
                <?php if($_POST['action']=="insertar"){?>
                verificar_numdoc();
                <?php }?>
            }
        });
    }
    function txt_ven_numdocguia(){
        $.ajax({
            type: "POST",
            url: "../venta/venta_txt_numdocguia.php",
            async:false,
            dataType: "json",
            data: ({
                doc_id: 22
            }),
            beforeSend: function() {
                $('#txt_ven_numdocguia').val('Cargando...');

                //
                // if($('#cmb_ven_doc').val()*1==2 || $('#cmb_ven_doc').val()*1==11)//factura
                // {
                //     $('#hdd_val_cli_tip').val('2');
                // }
                // if($('#cmb_ven_doc').val()*1==3 || $('#cmb_ven_doc').val()*1==12)//boleta
                // {
                //     $('#hdd_val_cli_tip').val('1');
                // }
                // if($('#cmb_ven_doc').val()*1==15)//nota de salida
                // {
                //     $('#hdd_val_cli_tip').val('15');
                // }
            },
            success: function(data){
                $('#txt_ven_numdocguia').val(data.numero);
                if(data.msj!="")
                {
                    $('#msj_venta_form').html(data.msj);
                    $('#msj_venta_form').show(100);
                }
                else
                {
                    $('#msj_venta_form').hide();
                }
            },
            complete: function(){
                <?php if($_POST['action']=="insertar"){?>
                // verificar_numdoc();
                <?php }?>
            }
        });
    }
    function verificar_numdoc(){
        $.ajax({
            type: "POST",
            url: "../venta/venta_ver_numdoc.php",
            async:false,
            dataType: "json",
            data: ({
                doc_id: $('#cmb_ven_doc').val(),
                numdoc: $('#txt_ven_numdoc').val(),
                ven_est: $('#cmb_ven_est').val()
            }),
            beforeSend: function() {

            },
            success: function(data){
                $('#hdd_ven_doc').val(data.valor);
                if(data.msj!="")
                {
                    $('#div_venta_validar_form').dialog("open");
                    $('#div_venta_validar_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
                    $('#div_venta_validar_form').html(data.msj);
                    //alert(data.msj);
                    $('#msj_venta_form').html(data.msj);
                    //$('#msj_venta_form').show(100);
                }
                else
                {
                    //$('#msj_venta_form').hide();
                }
            }
        });
    }

    function cmb_ven_id()
    {
        $.ajax({
            type: "POST",
            url: "../usuarios/cmb_ven_id.php",
            async:true,
            dataType: "html",
            data: ({
                use_id: '<?php echo $use_id?>',
                vista:	'<?php echo $_POST['action']?>'
            }),
            beforeSend: function() {
                $('#hdd_usu_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#hdd_usu_id').html(html);
            },
            complete: function(){

            }
        });
    }

    function txt_venpag_fecven(){
        $.ajax({
            type: "POST",
            url: "../venta/venta_txt_fecven.php",
            async:true,
            dataType: "json",
            data: ({
                ven_fec: 		$('#txt_ven_fec').val(),
                venpag_numdia: 	$('#txt_venpag_numdia').val()
            }),
            beforeSend: function() {
                //$('#txt_ven_numdoc').val('Cargando...');
            },
            success: function(data){
                //alert(data.fecha);
                $('#txt_venpag_fecven').val(data.fecha);
            },

        });
    }

    function txt_venpag_fecletras(id, dias){
        $.ajax({
            type: "POST",
            url: "../venta/venta_txt_fecletras.php",
            async:true,
            dataType: "json",
            data: ({
                ven_fec: 		$('#txt_ven_fec').val(),
                ven_dia: 	dias
            }),
            beforeSend: function() {
                //$('#txt_ven_numdoc').val('Cargando...');
            },
            success: function(data){
                $('#txt_letras_fecven'+id).val(data.fecha);
                if ($('#hdd_ven_cli_ret').val()==='1'){
                    var monto_original = parseFloat($('#txt_venpag_mon').autoNumericGet());
                    var retencion = parseFloat($('#txt_venpag_mon').autoNumericGet())*0.03;
                    var nuevo_monto =monto_original-retencion;
                    $('#txt_letras_mon'+id).val((parseFloat(nuevo_monto)/parseFloat($('#txt_numletras').val())).toFixed(2));
                }else {
                    $('#txt_letras_mon'+id).val((parseFloat($('#txt_venpag_mon').autoNumericGet())/parseFloat($('#txt_numletras').val())).toFixed(2));
                }
            }
        });
    }


    function producto_form(act,idf){
        $.ajax({
            type: "POST",
            url: "../producto/producto_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                pro_id:		idf,
                tipo:		'insertar_venta',
                pro_nom: $('#txt_bus_pro_nom').val(),
                vista:	'venta_tabla'
            }),
            beforeSend: function() {
                $('#msj_producto').hide();
                $('#div_producto_form').dialog("open");
                $('#div_producto_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_producto_form').html(html);
            }
        });
    }


    function lote_venta_car(act,cat_id, lote_num, unico_id){
        $.ajax({
            type: "POST",
            url: "../lote/lote_venta_car.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                cat_id: cat_id,
                txt_lote_num: lote_num,
                unico_id: unico_id
            }),
            beforeSend: function() {
                $('#msj_presentacion_lote').hide();
                $('#div_tabla_lote_venta').dialog("open");
                $('#div_tabla_lote_venta').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_tabla_lote_venta').html(html);
            }
        });
    }

    function lote_venta_form(act,cat_id, lote_num, unico_id, cant_act){
        $.ajax({
            type: "POST",
            url: "../lote/lote_venta_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                cat_id: cat_id,
                lote_num: lote_num,
                unico_id: unico_id,
                cant_act: cant_act
            }),
            beforeSend: function() {
                $('#msj_presentacion_lote').hide();
                $('#div_lote_venta_form').dialog("open");
                $('#div_lote_venta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_lote_venta_form').html(html);
            }
        });
    }


    function actualizar_stock(preid,almid,stoid)
    {
        $.ajax({
            type: "POST",
            url: "../producto/stock_reg.php",
            async:true,
            dataType: "html",
            data: ({
                action:	'actualizar_stock',
                tipo:	'insertar',
                alm_id: almid,
                pre_id: preid,
                sto_id: stoid,
                sto_num: 0
            }),
            beforeSend: function() {
                //$('#div_catalogo_filtro').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){

            },
            complete: function(){

            }
        });
    }

    function producto_reg(){

        var result='';
        $.ajax({
            type: "POST",
            url: "../producto/producto_reg.php",
            async: false,
            dataType: "json",
            data: ({
                action_producto: "insertar",
                hdd_usu_id: <?php echo $_SESSION['usuario_id']?>,
                txt_pro_nom: $('#txt_bus_pro_nom').val(),
                txt_pro_des: $('#txt_bus_pro_nom').val(),
                num_alm: "",
                tipo_accion: "insertar_venta",
                cmb_cat_id: 9,
                cmb_mar_id: 1,
                cmb_afec_id: 1,
                cmb_lote: "",
                cmb_pro_est: "Activo",
                hdd_prod_img:"",
                txt_pre_cod:"",
                txt_pre_stomin: "",
                cmb_pre_est: "Activo",
                cmb_cat_uni_bas: 1,
                txt_cat_tipcam:"",
                txt_cat_precosdol:"",
                txt_cat_precos:"",
                txt_cat_descprov:"",
                txt_cat_uti: "",
                txt_cat_valven: "",
                txt_cat_preven: $('#txt_bus_cat_preven').val(),
                chk_cat_vercom: 1,
                chk_cat_verven: 1
            }),
            beforeSend: function(){
                // $('#msj_producto').html("Guardando...");
                // $('#msj_producto').show(100);
            },
            success: function(data){

                result = data.cat_id;
                // $('#msj_producto').html(data.pro_msj);
                if(data.tipo_accion=='insertar_venta'){
                    actualizar_stock(data.pre_id,<?php echo $_SESSION['almacen_id']?>,'');
                }

            },
            complete: function(){

            }
        });
        return result
    }

    function venta_car(act,cat_id){

        var cat_tip=$('#hdd_detven_tip').val();

        if(act=='agregar') {
            var stouni=$('#hdd_bus_cat_stouni').val();
            var cantidad=$('#txt_bus_cat_can').val();

            var dif = stouni-$('#txt_bus_cat_can').val();

            // if($('#txt_bus_cat_preven').autoNumericGet()>0) {
            var precio=$('#txt_bus_cat_preven').autoNumericGet()-$('#hdd_bus_cat_cospro').autoNumericGet();
            // } else {
            // 	var precio=0;
            // }
        }
        if(act!='quitar'){
            cat_id =  $('#hdd_bus_cat_id').val();
        }



        if(act=='agregar' & (dif < 0) && $('#hdd_stock_neg').val()!=='1')
        {
            alert('Stock insuficiente. Diferencia en '+(cantidad-stouni)+'.');
            $('#txt_bus_cat_can').val(stouni);
        } else {

            //if(precio<0) {
            //	precio=precio.toFixed(2);
            //	alert('Precio debe ser mayor al costo. Diferencia en '+(precio)+'.');
            //	$('#txt_bus_cat_preven').autoNumericSet($('#hdd_bus_cat_cospro').autoNumericGet());
            //}
            //else {
            var cot_id = '';
            cot_id = $('#hdd_cot_id').val();

            if(!cat_id && $('#txt_bus_cat_can').val() && $('#txt_bus_cat_preven').val()){
                cat_id = producto_reg();
                cat_tip = 1;
            }

            $.ajax({
                type: "POST",
                url: "../venta/venta_car.php",
                async:false,
                dataType: "html",
                data: ({
                    action:	 act,
                    unico_id: $('#unico_id').val(),
                    cat_id:	 cat_id,
                    cat_can: $('#txt_bus_cat_can').val(),
                    cat_tip: cat_tip,
                    cat_preven: $('#txt_bus_cat_preven').val(),
                    cat_des: $('#txt_detcom_des').val(),
                    cot_id: cot_id
                }),
                beforeSend: function() {
                    $("#txt_fil_pro_nom").val(''); $("#txt_fil_pro_nom").focus();
                    $('#div_venta_car_tabla').addClass("ui-state-disabled");
                },
                success: function(html){

                    $('#div_venta_car_tabla').html(html);
                },
                complete: function(){
                    $('#div_venta_car_tabla').removeClass("ui-state-disabled");
                    if(!($('#chk_modo').is(':checked'))) {
                        $('#hdd_bus_cat_id').val('');
                        $('#hdd_bus_cat_stouni').val('');
                        $('#hdd_bus_cat_cospro').val('');
                        $('#txt_bus_pro_codbar').val('');
                        $('#txt_bus_pro_nom').val('');
                        $('#txt_bus_cat_preven').val('');
                        $('#txt_bus_cat_can').val('');
                        $('#txt_precio_min').val('');
                        $('#txt_precio_may').val('');
                        $('#txt_detcom_des').val('0.00')
                    }
                }
            });
            //}
        }
    }

    function venta_car_form(act,idf){
        if(act=='agregar')
        {
            var stouni=$('#hdd_cat_stouni_'+idf).val();
            var cantidad=$('#txt_cat_can_'+idf).val();

            var dif=$('#hdd_cat_stouni_'+idf).val()-$('#txt_cat_can_'+idf).val();
        }


        if(act=='agregar' & (dif < 0))
        {
            alert('Stock insuficiente. Diferencia en '+(cantidad-stouni)+'.');
            $('#txt_cat_can_'+idf).val(stouni);
        }
        else
        {
            /*if($('#chk_cat_igv_'+idf).is(':checked')) {
                var chk=1;
            } else {
                var chk=0;
            }*/

            $.ajax({
                type: "POST",
                url: "../venta/venta_car.php",
                async:true,
                dataType: "html",
                data: ({
                    action:	 act,
                    cat_id:	 idf,
                    unico_id: $('#unico_id').val(),
                    cat_can: $('#txt_cat_can_'+idf).val(),
                    cat_des: $('#txt_detven_des_'+idf).val(),//Descuento
                    cat_nom: $('#txt_detven_nom_'+idf).val(),//Descuento
                    cat_tip: $('#hdd_detven_tip_'+idf).val(),//Tipo Gravado/Exonerado/Inafecto
                    cat_tipdes: $("input[name='rad_cat_tip_des_"+idf+"']:checked").val(),//Radio Button
                    cat_preven: $('#txt_cat_preven_'+idf).val()
                }),
                beforeSend: function() {
                    $("#txt_fil_pro_nom").val(''); $("#txt_fil_pro_nom").focus();
                    $('#div_venta_car_tabla').addClass("ui-state-disabled");
                },
                success: function(html){
                    $('#div_venta_car_tabla').html(html);
                },
                complete: function(){
                    $('#div_venta_car_tabla').removeClass("ui-state-disabled");
                }
            });
        }
    }


    function venta_car_servicio(act,idf){
        $.ajax({
            type: "POST",
            url: "../venta/venta_car.php",
            async:false,
            dataType: "html",
            data: ({
                action:	 act,
                unico_id: $('#unico_id').val(),
                ser_id:	 idf,
                ser_nom: $('#hdd_ser_nom_'+idf).val(),
                ser_can: $('#txt_ser_can_'+idf).val(),
                ser_tip: $('#cmb_detven_tip_'+idf).val(),
                ser_des: $('#txt_ser_detven_des_'+idf).val(),//Descuento
                ser_rad_tipdes: $("input[name='rad_ser_tip_des_"+idf+"']:checked").val(),
                ser_pre: $('#txt_servicio_pre_'+idf).val()
            }),
            beforeSend: function() {
                $("#txt_fil_ser_nom").val(''); $("#txt_fil_ser_nom").focus();
                $('#div_venta_car_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_venta_car_tabla').html(html);
            },
            complete: function(){
                $('#div_venta_car_tabla').removeClass("ui-state-disabled");
            }
        });
    }



    function catalogo_venta(){
        $.ajax({
            type: "POST",
            url: "../catalogo/catalogo_venta.php",
            async:true,
            dataType: "html",
            data: ({
                //action: act,
                //ven_id:	idf
            }),
            beforeSend: function() {
                //$('#msj_venta').hide();
                //$('#div_catalogo_venta').dialog("open");
                $('#div_tab_producto').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_tab_producto').html(html);
            }
        });
    }

    function catalogo_servicio(){
        $.ajax({
            type: "POST",
            url: "../catalogo/catalogo_servicio.php",
            async:true,
            dataType: "html",
            data: ({
                //action: act,
                //ven_id:	idf
            }),
            beforeSend: function() {
                //$('#msj_venta').hide();
                //$('#div_catalogo_venta').dialog("open");
                $('#div_tab_servicio').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_tab_servicio').html(html);
            }
        });
    }

    function catalogo_venta_tab(){
        $.ajax({
            type: "POST",
            url: "../catalogo/catalogo_venta_tab.php",
            async:true,
            dataType: "html",
            data: ({
                //action: act,
                //ven_id:	idf
            }),
            beforeSend: function() {
                $('#msj_venta').hide();
                $('#div_catalogo_venta').dialog("open");
                $('#div_catalogo_venta').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_catalogo_venta').html(html);
            },
            complete: function(){
                catalogo_venta();
                catalogo_servicio();
            }
        });
    }

    function venta_pago_tabla()
    {
        $.ajax({
            type: "POST",
            url: "../venta/venta_pago_tabla.php",
            async:true,
            dataType: "html",
            data: ({
                ven_id:	'<?php echo $_POST['ven_id']?>'
            }),
            beforeSend: function() {
                $('#div_venta_pago_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_venta_pago_tabla').html(html);
            },
            complete: function(){
                $('#div_venta_pago_tabla').removeClass("ui-state-disabled");
            }
        });
    }

    function venta_detalle_tabla()
    {
        $.ajax({
            type: "POST",
            url: "../venta/venta_detalle_tabla.php",
            async:true,
            dataType: "html",
            data: ({
                ven_id:	'<?php echo $_POST['ven_id']?>'
            }),
            beforeSend: function() {
                $('#div_venta_detalle_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_venta_detalle_tabla').html(html);
            },
            complete: function(){
                $('#div_venta_detalle_tabla').removeClass("ui-state-disabled");
            }
        });
    }

    function cotizacion_detalle_tabla()
    {
        $.ajax({
            type: "POST",
            url: "../cotizacion/cotizacion_detalle_tabla.php",
            async:true,
            dataType: "html",
            data: ({
                ven_id:	'<?php echo $_POST['ven_id']?>',
                action: 'insertar_cot'
            }),
            beforeSend: function() {
                $('#div_venta_car_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_venta_car_tabla').html(html);
            },
            complete: function(){
                $('#div_venta_car_tabla').removeClass("ui-state-disabled");
            }
        });
    }

    function editar_datos_item(act,idf){
        $.ajax({
            type: "POST",
            url: "../venta/venta_car_item.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                unico_id: $('#unico_id').val(),
                ite_id:	idf
            }),
            beforeSend: function() {
                //$('#msj_proveedor').hide();
                $(".btn_item").click(function(e){
                    x=e.pageX-200;
                    y=e.pageY-200;
                    $('#div_item_form').dialog({ position: [x,y] });
                    $('#div_item_form').dialog("open");
                });
                $('#div_item_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_item_form').html(html);
            }
        });
    }

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

    function clientecuenta_detalle(ids)
    {
        $.ajax({
            type: "POST",
            url: "../clientecuenta/clientecuenta_detalle.php",
            async:true,
            dataType: "html",
            data: ({
                cli_id: ids,
                emp_id: '<?php echo $_SESSION['empresa_id']?>',
                vista: 0
            }),
            beforeSend: function() {
                $('#div_clientecuenta_detalle').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#div_clientecuenta_detalle').html(html);
            }
        });
        //$('#div_clientecuenta_detalle').html(ids);
    }

    function venta_pago_car(act,idf){
        $.ajax({
            type: "POST",
            url: "../venta/venta_pago_car.php",
            async:true,
            dataType: "html",
            data: ({
                action:	 act,
                unico_id: $('#unico_id').val(),
                item_id:	idf,
                venpag_mon: $('#txt_venpag_mon').val(),
                venpag_for: $('#cmb_forpag_id').val(),
                venpag_mod: $('#cmb_modpag_id').val(),
                venpag_cuecor: $('#cmb_cuecor_id').val(),
                venpag_tar: $('#cmb_tar_id').val(),
                venpag_numope: $('#txt_venpag_numope').val(),
                venpag_numdia: $('#txt_venpag_numdia').val(),
                venpag_fecven: $('#txt_venpag_fecven').val(),
                ven_tot: $('#txt_ven_tot').val()
            }),
            beforeSend: function() {
                $('#div_venta_pago_car').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_venta_pago_car').html(html);
            },
            complete: function(){
                $('#div_venta_pago_car').removeClass("ui-state-disabled");
            }
        });
    }

    function compararSunat(doc, nom, dir, id) {
        console.log("aca8");
        $.post('../../libreriasphp/consultaruc/index.php', {
                vruc: doc,
                vtipod: 6
            },
            function(data, textStatus){
                console.log("aca10");
                if(data == null){
                    alert('Intente nuevamente...Sunat');
                    $('#msj_busqueda_sunat').hide();
                    console.log("aca1");
                }
                if(data.length==1){
                    console.log("aca2");
                    alert(data[0]);
                }else{
                    console.log("aca3");
                    // var telefono = data['Telefonos'];
                    // telefono = telefono.replace(/ \/ /g, "/");
                    // telefono = telefono.replace("/ ", "");
                    // telefono = telefono.replace(/\//g, " / ");
                    // $('#txt_cli_tel').val(telefono);
                    $("#txt_ven_cli_est").val(data['Estado']);
                    console.log("aca4");
                    // if(data['RazonSocial'] != nom || data['Direccion'] != dir){
                    //     cliente_form_i('editarSunat',id,data['RazonSocial'],data['Direccion'],data['Contacto'],'',data['Estado']);
                    // }
                    console.log("aca5");
                    $('#msj_busqueda_sunat').hide();
                }
            },"json");
    }

    function sumaFecha(d, fecha)
    {
        var Fecha = new Date();
        var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
        var sep = sFecha.indexOf('/') != -1 ? '/' : '-';
        var aFecha = sFecha.split(sep);
        var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
        fecha= new Date(fecha);
        fecha.setDate(fecha.getDate()+parseInt(d));
        var anno=fecha.getFullYear();
        var mes= fecha.getMonth()+1;
        var dia= fecha.getDate();
        mes = (mes < 10) ? ("0" + mes) : mes;
        dia = (dia < 10) ? ("0" + dia) : dia;
        var fechaFinal = dia+sep+mes+sep+anno;
        return (fechaFinal);
    }

    function mascara(d, sep, pat, nums) {
        if (d.valant != d.value) {
            val = d.value
            largo = val.length
            val = val.split(sep)
            val2 = ''
            for (r = 0; r < val.length; r++) {
                val2 += val[r]
            }
            if (nums) {
                for (z = 0; z < val2.length; z++) {
                    if (isNaN(val2.charAt(z))) {
                        letra = new RegExp(val2.charAt(z), "g")
                        val2 = val2.replace(letra, "")
                    }
                }
            }
            val = ''
            val3 = new Array()
            for (s = 0; s < pat.length; s++) {
                val3[s] = val2.substring(0, pat[s])
                val2 = val2.substr(pat[s])
            }
            for (q = 0; q < val3.length; q++) {
                if (q == 0) {
                    val = val3[q]
                }
                else {
                    if (val3[q] != "") {
                        val += sep + val3[q]
                    }
                }
            }
            d.value = val
            d.valant = val
        }
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

    $(function() {

        $('#txt_ven_fec').keyup(function(e) {
            var patron = new Array(2, 2, 4);
            mascara(this,'-',patron,false);
        });
        $('#txt_com_fecven').keyup(function(e) {
            var patron = new Array(2, 2, 4);
            mascara(this,'-',patron,false);
        });

        $( "#div_productos_servicios_tab" ).tabs();

        cmb_ven_doc();
        //cmb_ven_id();
        cmb_listaprecio_id($('#hdd_cli_precio_id').val(),$('#hdd_ven_cli_id').val());
        lote_venta_car('restablecer');

        $("#txt_ven_numdoc").addClass("ui-state-active");
        $("#txt_ven_numdocguia").addClass("ui-state-active");

        $('#txt_ven_lab1').change(function(){
            $(this).val($(this).val().toUpperCase());
        });

        $('#cmb_listaprecio_id').change(function(){
            if($(this).val()){
                $('#che_mayorista').prop('disabled',true);
            }else{
                $('#che_mayorista').prop('disabled',false);
            }
        });

        $('#hdd_ven_cli_id').change(function(){
            if ($('#hdd_ven_cli_id').val()!=''){
                cmb_listaprecio_id($('#hdd_cli_precio_id').val(),$('#hdd_ven_cli_id').val());
                $('#cmb_listaprecio_id').change();
            }
        });


        $('#txt_ven_cli_nom').change(function(){
            $(this).val($(this).val().toUpperCase());
        });

        $('#hdd_ven_cli_id').change(function(){
            $('#txt_venpag_mon').change();
        });

        $("#txt_venpag_mon").change(function() {
            var num_letras = $('#txt_numletras').val();

            var ndias = $('#dias1').val();

            if(num_letras!=="") {
                var k = 30;
                for (var i = 1; i <= num_letras; i++) {
                    k=$('#dias'+i).val();
                    $(".letras_fecven" + i).show(100);
                    txt_venpag_fecletras(i,k);
                }
            }
        });

        cmb_tar_id(<?php echo $tar_id?>);
        cmb_cuecor_id(<?php echo $cuecor_id?>);


        $( "#txt_ven_cli_doc" ).autocomplete({
            minLength: 1,
            source: "../clientes/cliente_complete_doc.php",
            select: function(event, ui){
                $("#hdd_ven_cli_id").val(ui.item.id);
                $("#txt_ven_cli_nom").val(ui.item.nombre);
                $("#txt_ven_cli_dir").val(ui.item.direccion);
                $("#hdd_ven_cli_tip").val(ui.item.tipo);
                $("#hdd_ven_cli_ret").val(ui.item.retiene);
                $("#hdd_cli_precio_id").val(ui.item.precio_id);
                $('#hdd_ven_cli_id').change()
                clientecuenta_detalle(ui.item.id);
                if($("#hdd_ven_cli_id" ).val()>0){
                    cmb_dir_id($( "#hdd_ven_cli_id" ).val());

                }
                //alert(ui.item.value);
                $('#msj_busqueda_sunat').html("Buscando en Sunat...");
                $('#msj_busqueda_sunat').show(100);
                compararSunat(ui.item.value, ui.item.nombre, ui.item.direccion, ui.item.id);
            }
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
                clientecuenta_detalle(ui.item.id);
                if($("#hdd_ven_cli_id" ).val()>0){
                    cmb_dir_id($( "#hdd_ven_cli_id" ).val());
                }
                //alert(ui.item.value);
                $('#msj_busqueda_sunat').html("Buscando en Sunat...");
                $('#msj_busqueda_sunat').show(100);
                compararSunat(ui.item.documento, ui.item.value, ui.item.direccion, ui.item.id);
            }
        });


        <?php
        if($_POST['action']=="insertar" || $_POST['action']=='insertar_cot'){
        ?>
        $('#cmb_ven_doc').change( function() {
            txt_ven_numdoc();
            if ((this).value=== '12' || (this).value=== '15') {
                cliente_cargar_datos(1);
                $("#chk_imprimir_guia").attr('checked', false);

            }else{
                $('#hdd_ven_cli_id, #txt_ven_cli_nom, #txt_ven_cli_doc, #txt_ven_cli_dir, #hdd_ven_cli_tip, #hdd_ven_cli_ret, #txt_ven_cli_est').val('');
            }

            if ((this).value=== '2' || (this).value=== '11') {
                $('.imprimir_guia').show();
                // $('.insertar-guia').show();
                $('#txt_bus_cat_preven_noigv').show();
                $('#txt_bus_cat_preven').hide();
                $("#chk_imprimir_guia").attr('checked', false);
            }else{
                $('.imprimir_guia').hide();
                $('.insertar-guia').hide();
                $('#txt_bus_cat_preven_noigv').hide();
                $('#txt_bus_cat_preven').show();
                $("#chk_imprimir_guia").attr('checked', false);
            }

            $('#txt_ven_cli_doc').focus();
        });

        venta_car();

        $("#cmb_ven_est").change(function(){
            verificar_numdoc();
            var est = $("#cmb_ven_est").val();

            if(est == 'ANULADA'){
                $("#hdd_ven_numite").attr('disabled', 'disabled');
                $("#hdd_ven_cli_id").attr('disabled', 'disabled');
            }
            if(est == 'CANCELADA'){
                $("#hdd_ven_numite").attr('disabled', false);
                $("#hdd_ven_cli_id").attr('disabled', false);
            }
        });

        <?php }?>

        $("#chk_venpag_aut").change(function(){
            if($('#chk_venpag_aut').is(':checked')){
                //var chk=1;
                $("#div_pago_agregar").hide(100);
                $("#hdd_ven_pag_numite").attr('disabled', 'disabled');
                //venta_pago_car('restablecer');
                $("#hdd_ven_pag_numite").attr('disabled', 'disabled');
                $("#hdd_venpag_tot").attr('disabled', 'disabled');
            } else {
                //var chk=0;
                $("#div_pago_agregar").show(100);
                venta_pago_car('actualizar');
                $("#hdd_ven_pag_numite").attr('disabled', false);
                $("#hdd_venpag_tot").attr('disabled', false);
            }
        });

        $("#cmb_forpag_id").change(function(){
            var tipo = $("#cmb_forpag_id").val();

            //$('#cmb_forpag_id').val();

            //$('#txt_venpag_mon').val('');
            $('#cmb_modpag_id').val('');
            $('#cmb_cuecor_id').val('');
            $('#cmb_tar_id').val('');
            $('#txt_venpag_numope').val('');
            $('#txt_venpag_numdia').val('');
            $('#txt_venpag_fecven').val('');

            $("#div_cuentacorriente").hide(100);
            $("#div_tarjeta").hide(100);
            $("#div_operacion").hide(100);
            $(".div_fechaletras").hide(100);

            //contado
            if(tipo == 1){
                $("#div_dia").hide(100);
                $("#div_fecven").hide(100);
                $("#div_numeroletras").hide(100);
                $(".letras_fecven").hide(100);
                $("#cmb_modpag_id").show(100);
                //ocultar deposito y tarjeta
                $("#cmb_modpag_id").val(1);
                $("#cmb_modpag_id option[value='1']").attr("disabled",false);
                $("#cmb_modpag_id option[value='2']").attr("disabled",false);
                $("#cmb_modpag_id option[value='3']").attr("disabled",false);
                $("#cmb_modpag_id option[value='4']").attr("disabled","disabled");
            }
            //credito
            if(tipo == 2){
                $("#div_dia").show(100);
                $("#div_fecven").show(100);
                $("#div_numeroletras").hide(100);
                $(".letras_fecven").hide(100);
                $("#cmb_modpag_id").show(100);
                $("#cmb_modpag_id").val(1);
                //ocultar deposito y tarjeta
                $("#cmb_modpag_id option[value='2']").attr("disabled","disabled");
                $("#cmb_modpag_id option[value='3']").attr("disabled","disabled");
                $("#cmb_modpag_id option[value='4']").attr("disabled","disabled");

                $("#txt_venpag_numdia").focus();
            }
            //LETRAS
            if(tipo == 3){
                $("#div_dia").hide(100);
                $("#div_fecven").hide(100);
                $("#div_numeroletras").show(100);
                $(".letras_fecven").show(100);
                //ocultar deposito y tarjeta
                //$("#cmb_modpag_id").hide(100);
                $("#cmb_modpag_id").val(4);
                $("#cmb_modpag_id option[value='1']").attr("disabled","disabled");
                $("#cmb_modpag_id option[value='2']").attr("disabled","disabled");
                $("#cmb_modpag_id option[value='3']").attr("disabled","disabled");
                $("#cmb_modpag_id option[value='4']").attr("disabled",false);

                $("#txt_numletras").focus();
            }
        });

        $("#cmb_modpag_id").change(function(){
            var tipo = $("#cmb_modpag_id").val();

            $('#cmb_tar_id').val('');
            $('#cmb_cuecor_id').val('');
            $('#txt_venpag_numope').val('');
            $('#txt_venpag_numdia').val('');
            $('#txt_venpag_fecven').val('');

            //efectivo
            if(tipo == 1){
                $("#div_cuentacorriente").hide(100);
                $("#div_tarjeta").hide(100);
                $("#div_operacion").hide(100);
            }
            //deposito
            if(tipo == 2){
                $("#div_cuentacorriente").show(100);
                $("#div_tarjeta").hide(100);
                $("#div_operacion").show(100);
            }
            //tarjeta
            if(tipo == 3){
                $("#div_cuentacorriente").hide(100);
                $("#div_tarjeta").show(100);
                $("#div_operacion").show(100);
            }
        });

        $('#txt_venpag_numdia').change( function() {
            if($('#txt_venpag_numdia').val()!="")
            {
                txt_venpag_fecven();
            }
            else
            {
                $('#txt_venpag_fecven').val('');
            }
        });

        $('#chk_imprimir_guia').change( function() {
            if(this.checked)
            {
                $('.insertar-guia').show();
            }
            else
            {
                $('.insertar-guia').hide();
            }
        });




        $('#txt_numletras').keyup( function() {

            var num_letras = $('#txt_numletras').val();
            if(num_letras!=="")
            {
                var k = 30;
                for(var i=1;i<=num_letras;i++){
                    k=$('#dias'+i).val();
                    $(".letras_fecven"+i).show(100);
                    txt_venpag_fecletras(i,k);
                }


                //implementar inputs de acuerdo a la cantidad de letras txt_venumletras();
            }
            else
            {
                for(var i=1;i<=5;i++){
                    $(".letras_fecven"+i).hide(100);
                }
            }
        });

        $('#dias1').change( function() {
            var fechadoc = $("#txt_ven_fec").val();
            var fechaVence = sumaFecha($("#dias1").val(),fechadoc);
            $('#txt_letras_fecven1').val(fechaVence);

            if($("#dias1").val()=="")
            {
                var sumames=sumaFecha(30,fechadoc);
                $('#txt_letras_fecven1').val(sumames);
                $('#dias1').val(30);
            }
        });
        $('#dias2').change( function() {
            var fechadoc = $("#txt_ven_fec").val();
            var fechaVence = sumaFecha($("#dias2").val(),fechadoc);
            $('#txt_letras_fecven2').val(fechaVence);

            if($("#dias2").val()=="")
            {
                var sumames=sumaFecha(60,fechadoc);
                $('#txt_letras_fecven2').val(sumames);
                $('#dias2').val(60);
            }
        });
        $('#dias3').change( function() {
            var fechadoc = $("#txt_ven_fec").val();
            var fechaVence = sumaFecha($("#dias3").val(),fechadoc);
            $('#txt_letras_fecven3').val(fechaVence);

            if($("#dias3").val()=="")
            {
                var sumames=sumaFecha(90,fechadoc);
                $('#txt_letras_fecven3').val(sumames);
                $('#dias3').val(90);
            }
        });

        $('#dias4').change( function() {
            var fechadoc = $("#txt_ven_fec").val();
            var fechaVence = sumaFecha($("#dias4").val(),fechadoc);
            $('#txt_letras_fecven4').val(fechaVence);

            if($("#dias4").val()=="")
            {
                var sumames=sumaFecha(120,fechadoc);
                $('#txt_letras_fecven4').val(sumames);
                $('#dias4').val(120);
            }
        });
        $('#dias5').change( function() {
            var fechadoc = $("#txt_ven_fec").val();
            var fechaVence = sumaFecha($("#dias5").val(),fechadoc);
            $('#txt_letras_fecven5').val(fechaVence);

            if($("#dias5").val()=="")
            {
                var sumames=sumaFecha(150,fechadoc);
                $('#txt_letras_fecven5').val(sumames);
                $('#dias5').val(150);
            }
        });
        cmb_tar_id();

        <?php
        if($_POST['action']=="editar"){
        ?>
        venta_pago_tabla();
        venta_detalle_tabla();
        $('#cmb_ven_est').attr('disabled','disabled');
        $('#hdd_ven_doc').val('1');

        <?php }?>


        <?php
        if($_POST['action']=="insertar_cot"){
        ?>
        // cotizacion_detalle_tabla();
        $('#hdd_ven_doc').val('1');

        <?php }?>


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

        $( "#div_catalogo_venta" ).dialog({
            open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).show(); },
            title:'Catálogo de Venta',
            autoOpen: false,
            resizable: false,
            height: 500,
            width: 980,
            zIndex: 2,
            modal: true,
            position: 'top',
            position: ["center",0],
            buttons: {
                Cerrar: function() {
                    $( this ).dialog( "close" );
                }
            }
        });

        $( "#div_tabla_lote_venta" ).dialog({
            title:'Lote',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 550,
            modal: true,
            buttons: {
                Cerrar: function() {
                    $('#for_lote_form').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                $("#div_tabla_lote_venta").html('Cargando...');
            }
        });

        $( "#div_lote_venta_form" ).dialog({
            title:'Lote',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 550,
            modal: true,
            buttons: {
                Guardar: function() {
                    $("#for_lote_form").submit();
                },
                Cancelar: function() {
                    $('#for_lote_form').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                $("#div_lote_form").html('Cargando...');
            }
        });

        //Formulario para actualizar Item de Detalle de Venta
        $( "#div_item_form" ).dialog({
            title:'Información de Item',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 220,
            zIndex: 3,
            //modal: true,
            buttons: {
                Actualizar: function() {
                    $("#for_item").submit();
                },
                Cancelar: function() {
                    $('#for_item').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            }
        });

        $( "#div_venta_validar_form" ).dialog({
            title:'Validar venta...',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 300,
            zIndex: 3,
            //modal: true,
            buttons: {
                OK: function() {
                    $( this ).dialog( "close" );
                },
                Actualizar: function() {
                    txt_ven_numdoc();
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



        //botones agregar producto
        $('.btn_bus_agregar').button({
            icons: {
                //primary: "ui-icon-plusthick",
                //secondary:"ui-icon-cart"
            },
            text: true
        });

        $('.btn_bus_mas').button({
            icons: {
                primary: "ui-icon-plus"
            },
            text: false
        });
        $('.btn_bus_menos').button({
            icons: {
                primary: "ui-icon-minus"
            },
            text: false
        });

        $( "#txt_bus_pro_nom" ).autocomplete({
            minLength: 2,
            delay: 10,
            source: "../venta/catalogo_buscar_nom.php",
            select: function( event, ui ) {
                if (ui.item.value===""){
                    producto_form('insertar',"nuevo producto");
                    $("#txt_bus_pro_nom").val();
                    $("#txt_pro_nom").val("nuevo producto");
                }else{
                    $("#txt_bus_pro_nom").val(ui.item.label);
                    $("#hdd_bus_pro_nom").val(ui.item.value);
                    catalogo_buscar(ui.item.catid);
                }
            }
        });

        $( "#div_producto_form" ).dialog({
            title:'Información de Producto',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 990,
            modal: true,
            position: 'top',
            buttons: {
                Guardar: function() {
                    $("#for_pro").submit();
                },
                Cancelar: function() {
                    $('#for_pro').each (function(){this.reset();});
                    $( this ).dialog("close");
                }
            },
            close: function()
            {
                $("#div_producto_form").html('Cargando...');
            }
        });


        $('#txt_bus_pro_codbar').keypress(function(e){
            if(e.which == 13){
                catalogo_buscar_codigo();
                venta_car('agregar');
                $("#txt_bus_pro_nom").val('');
                $("#hdd_bus_pro_nom").val('');
                $('#hdd_bus_cat_id').val('');
                $('#hdd_bus_cat_stouni').val('');
                $('#hdd_bus_cat_cospro').val('');
                $('#txt_bus_pro_codbar').val('');
                $('#txt_bus_cat_preven').val('');
                $('#txt_bus_cat_can').val('');
                $('#txt_precio_min').val('');
                $('#txt_precio_may').val('');
                $("#txt_bus_pro_codbar").focus();
            }
        });

        $( "#txt_fil_gui_con_nom" ).autocomplete({
            minLength: 1,
            //source: "../conductor/conductor_complete_nom.php",
            source: function(request, response){
                $.ajax({
                    url: "../conductor/conductor_complete_nom.php",
                    dataType: "json",
                    data:{
                        term: request.term,
                        tra_id: $("#txt_fil_gui_tra_id").val()
                    },
                    success: function(data){
                        response(data);
                    }
                });
            },
            select: function(event, ui){
                $("#txt_fil_gui_con_id").val(ui.item.id);
                $("#txt_fil_gui_con_doc").val(ui.item.documento);
                $("#txt_fil_gui_con_dir").val(ui.item.direccion);
                $("#txt_fil_gui_con_lic").val(ui.item.licencia);
                $("#txt_fil_gui_con_cat").val(ui.item.categoria);

            }
        });

        $( "#txt_fil_gui_con_doc" ).autocomplete({
            minLength: 1,
            //source: "../conductor/conductor_complete_doc.php?tra_id="+$("#txt_fil_gui_tra_id").val()+"",
            source: function(request, response){
                $.ajax({
                    url: "../conductor/conductor_complete_doc.php",
                    dataType: "json",
                    data:{
                        term: request.term,
                        tra_id: $("#txt_fil_gui_tra_id").val()
                    },
                    success: function(data){
                        response(data);
                    }
                });
            },
            select: function(event, ui){
                $("#txt_fil_gui_con_id").val(ui.item.id);
                $("#txt_fil_gui_con_nom").val(ui.item.nombre);
                $("#txt_fil_gui_con_dir").val(ui.item.direccion);
                $("#txt_fil_gui_con_lic").val(ui.item.licencia);
                $("#txt_fil_gui_con_cat").val(ui.item.categoria);
            }
        });


        $( "#txt_fil_gui_tra_razsoc" ).autocomplete({
            minLength: 1,
            source: "../transporte/transporte_complete_razsoc.php",
            select: function(event, ui){
                $("#txt_fil_gui_tra_id").val(ui.item.id);
                $( "#txt_fil_gui_tra_razsoc" ).val(ui.item.razsoc);
                $("#txt_fil_gui_tra_ruc").val(ui.item.ruc);
                $("#txt_fil_gui_tra_dir").val(ui.item.direccion);
                limpiar_cajas_conductor();
                $("#fset_conductor").removeAttr("disabled");//Habilito Fielset conductor
                $("#txt_fil_gui_con_doc").focus();
            }
        });

        $( "#txt_fil_gui_tra_ruc" ).autocomplete({
            minLength: 1,
            source: "../transporte/transporte_complete_ruc.php",
            select: function(event, ui){
                $("#txt_fil_gui_tra_id").val(ui.item.id);
                $("#txt_fil_gui_tra_ruc").val(ui.item.ruc);
                $("#txt_fil_gui_tra_razsoc").val(ui.item.razonsocial);
                $("#txt_fil_gui_tra_dir").val(ui.item.direccion);
                limpiar_cajas_conductor();
                $("#fset_conductor").removeAttr("disabled");//Habilito Fielset conductor
                $("#txt_fil_gui_con_doc").focus();
            }
        });

        function limpiar_cajas_conductor(){
            $("#txt_fil_gui_con_id").val("");
            $("#txt_fil_gui_con_doc").val("");
            $("#txt_fil_gui_con_nom").val("");
            $("#txt_fil_gui_con_dir").val("");
        }
    });




    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function catalogo_buscar(cat_id) {
        $.ajax({
            type: "POST",
            url: "../venta/catalogo_buscar.php",
            async:false,
            dataType: "json",
            data: ({
                action:	 'dato',
                unico_id: $('#unico_id').val(),
                txt_bus_pro_codbar: $('#txt_bus_pro_codbar').val(),
                txt_bus_pro_nom: $('#hdd_bus_pro_nom').val(),
                cmb_listaprecio_id: $('#cmb_listaprecio_id').val(),
                cat_id: cat_id
            }),
            beforeSend: function() {
                //$('#div_venta_pago_car').addClass("ui-state-disabled");
                $('#msj_venta_det').html("Buscando...");
                $('#msj_venta_det').show(100);
            },
            success: function(data){

                if(data.accion==0)
                {
                    $('#hdd_bus_cat_id').val('');
                    $('#hdd_bus_cat_stouni').val('');
                    $('#hdd_bus_cat_cospro').val('');
                    //$('#txt_bus_pro_codbar').val('');
                    $('#txt_bus_pro_nom').val('');
                    $('#txt_bus_cat_preven').val('');
                    $('#txt_bus_cat_can').val('');

                    $('#txt_precio_min').val('');
                    $('#txt_precio_may').val('');
                    $('#hdd_detven_tip').val('');
                }

                if (data.accion == 1) {
                    if ($('#che_mayorista').is(':checked')) {
                        data.cat_preven = data.cat_premay;
                    }else{
                        if ($('#cmb_listaprecio_id').val()!='') {
                            data.cat_preven = data.cat_prelista;
                        }
                    }




                    $('#hdd_bus_cat_id').val(data.cat_id);
                    $('#hdd_bus_cat_stouni').val(data.cat_stouni);
                    $('#hdd_bus_cat_cospro').val(data.cat_cospro);
                    $('#txt_bus_pro_nom').val(data.pro_nom);
                    $('#txt_bus_cat_preven').val(data.cat_preven);
                    $('#txt_bus_cat_can').val(data.cat_can);

                    $('#txt_precio_min').val(data.cat_premin);
                    $('#txt_precio_may').val(data.cat_premay);
                    $('#hdd_detven_tip').val(data.ven_tip);

                    if ($('#chk_modo').is(':checked')) {
                        venta_car('agregar');

                        $('#hdd_bus_cat_id').val('');
                        $('#hdd_bus_cat_stouni').val('');
                        $('#hdd_bus_cat_cospro').val('');
                        $('#txt_bus_pro_codbar').val('');
                        $('#txt_bus_cat_preven').val('');
                        $('#txt_bus_cat_can').val('');
                        $('#txt_precio_min').val('');
                        $('#txt_precio_may').val('');
                        $('#hdd_bus_pro_nom').val('');
                        $('#txt_bus_pro_nom').val('');
                        $('#txt_bus_pro_nom').focus();
                    } else {
                        $('#txt_bus_pro_codbar').val(data.pro_codbar);
                        $('#hdd_bus_pro_nom').val('');
                            $('#txt_bus_cat_preven').focus();

                    }
                    //precios_min_may($('#hdd_bus_cat_id').val());
                }
                if (data.accion == 2) {
                    if ($('#cmb_listaprecio_id').val()) {
                        data.cat_preven = data.cat_prelista;
                    }
                    //$('#txt_bus_pro_codbar').val(data.pro_codbar);
                    ///catalogo_venta_tab1();
                    //alert(data.pro_codbar);
                    //$('#txt_fil_pro_codbar').val('hola');
                }
            },
            complete: function(){
                //$('#div_venta_pago_car').removeClass("ui-state-disabled");
                $('#msj_venta_det').hide(100);
            }
        });
    }

    function catalogo_buscar_codigo(cat_id) {
        $.ajax({
            type: "POST",
            url: "../venta/catalogo_buscar_codigo.php",
            async:false,
            dataType: "json",
            data: ({
                action:	 'dato',
                unico_id: $('#unico_id').val(),
                txt_bus_pro_codbar: $('#txt_bus_pro_codbar').val(),
                txt_bus_pro_nom: $('#hdd_bus_pro_nom').val(),
                cmb_listaprecio_id: $('#cmb_listaprecio_id').val(),
                cat_id: cat_id
            }),
            beforeSend: function() {
                //$('#div_venta_pago_car').addClass("ui-state-disabled");
                $('#msj_venta_det').html("Buscando...");
                $('#msj_venta_det').show(100);
            },
            success: function(data){

                if(data.accion==0)
                {
                    $('#hdd_bus_cat_id').val('');
                    $('#hdd_bus_cat_stouni').val('');
                    $('#hdd_bus_cat_cospro').val('');
                    //$('#txt_bus_pro_codbar').val('');
                    $('#txt_bus_pro_nom').val('');
                    $('#txt_bus_cat_preven').val('');
                    $('#txt_bus_cat_can').val('');

                    $('#txt_precio_min').val('');
                    $('#txt_precio_may').val('');
                    $('#hdd_detven_tip').val('');
                }

                if (data.accion == 1) {
                    if ($('#che_mayorista').is(':checked')) {
                        data.cat_preven = data.cat_premay;
                    }else{
                        if ($('#cmb_listaprecio_id').val()!='') {
                            data.cat_preven = data.cat_prelista;
                        }
                    }




                    $('#hdd_bus_cat_id').val(data.cat_id);
                    $('#hdd_bus_cat_stouni').val(data.cat_stouni);
                    $('#hdd_bus_cat_cospro').val(data.cat_cospro);
                    $('#txt_bus_pro_nom').val(data.pro_nom);
                    $('#txt_bus_cat_preven').val(data.cat_preven);
                    $('#txt_bus_cat_can').val(data.cat_can);

                    $('#txt_precio_min').val(data.cat_premin);
                    $('#txt_precio_may').val(data.cat_premay);
                    $('#hdd_detven_tip').val(data.ven_tip);

                    if ($('#chk_modo').is(':checked')) {
                        venta_car('agregar');

                        $('#hdd_bus_cat_id').val('');
                        $('#hdd_bus_cat_stouni').val('');
                        $('#hdd_bus_cat_cospro').val('');
                        $('#txt_bus_pro_codbar').val('');
                        $('#txt_bus_cat_preven').val('');
                        $('#txt_bus_cat_can').val('');
                        $('#txt_precio_min').val('');
                        $('#txt_precio_may').val('');
                        $('#hdd_bus_pro_nom').val('');
                        $('#txt_bus_pro_nom').val('');
                        $('#txt_bus_pro_nom').focus();
                    } else {
                        $('#txt_bus_pro_codbar').val(data.pro_codbar);
                        $('#hdd_bus_pro_nom').val('');
                        $('#txt_bus_cat_preven').focus();

                    }
                    //precios_min_may($('#hdd_bus_cat_id').val());
                }
                if (data.accion == 2) {
                    if ($('#cmb_listaprecio_id').val()) {
                        data.cat_preven = data.cat_prelista;
                    }
                    //$('#txt_bus_pro_codbar').val(data.pro_codbar);
                    ///catalogo_venta_tab1();
                    //alert(data.pro_codbar);
                    //$('#txt_fil_pro_codbar').val('hola');
                }
            },
            complete: function(){
                //$('#div_venta_pago_car').removeClass("ui-state-disabled");
                $('#msj_venta_det').hide(100);
            }
        });
    }


    function lote_tabla(idf)
    {

        $.ajax({
            type: "POST",
            url: "../lote/lote_ventadetalle_tabla.php",
            async:true,
            dataType: "html",
            data: ({
                vendet_id:	 idf
            }),
            beforeSend: function() {
                $('#div_lote_tabla').dialog("open");
                $('#div_lote_tabla').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_lote_tabla').html(html);
            },
            complete: function(){
            }
        });
    }

    function foco() {
        if($('#chk_modo').is(':checked')) {
            $('#txt_bus_pro_codbar').focus();
        }else{
            $('#txt_bus_pro_nom').focus();
        }

    }

    function bus_cantidad(act)
    {
        if($('#hdd_bus_cat_id').val()*1 > 0)
        {
            var can=($('#txt_bus_cat_can').val())*1;
            var sto=($('#hdd_bus_cat_stouni').val())*1;
            var valor=0;
            var sum=1;

            if(act=='mas')
            {
                valor=can+sum;
                if(valor<=sto)$('#txt_bus_cat_can').val(valor);
            }

            if(act=='menos')
            {
                valor=can-sum;
                if(valor>=1)$('#txt_bus_cat_can').val(valor);
            }
        }

    }

</script>

<style>
    .carro{
        overflow-x: hidden;
    }
</style>
<div class="carro">
    <form id="for_ven">
        <input name="action_venta" id="action_venta" type="hidden" value="<?php echo $_POST['action']?>">
        <input name="hdd_ven_id" id="hdd_ven_id" type="hidden" value="<?php echo $_POST['ven_id']?>">
        <input name="hdd_cot_id" id="hdd_cot_id" type="hidden" value="<?php echo $_POST['cot_id']?>">
        <input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_SESSION['puntoventa_id']?>">
        <input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $_SESSION['empresa_id']?>">
        <input name="hdd_ven_est" id="hdd_ven_est" type="hidden" value="<?php echo $est?>">
        <input name="hdd_stock_neg" id="hdd_stock_neg" type="hidden" value="<?php echo $stock_negativo?>">

        <input name="unico_id" id="unico_id" type="hidden" value="<?php echo $unico_id?>">

        <fieldset style="background-color: rgba(255,182,134,0.29);">
            <legend>Datos Principales</legend>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width:80%;"><label for="txt_ven_fec">Fecha:</label>
                        <input name="txt_ven_fec" type="text" class="fecha" id="txt_ven_fec" value="<?php echo $fec?>" size="10" maxlength="10">
                        <label for="cmb_ven_doc">Documento:<span style="color: #00aa00;font-size: 25px; font-weight: bold">1.</span></label>
                        <select name="cmb_ven_doc" id="cmb_ven_doc" <?php if($_POST['action']=='editar')echo 'disabled'?>>
                        </select>
                        <label for="txt_ven_numdoc">N° Doc:</label>
                        <input name="txt_ven_numdoc" type="text" id="txt_ven_numdoc" style="text-align:right; font-size:14px"  value="<?php echo $ser.'-'.$num?>" size="8" readonly>
                        <?php //if($_POST['action']=="editar")echo $est?>
                        <?php if($_POST['action']=="insertar" || $_POST['action']=="insertar_cot"){?>
                            <label for="chk_imprimir"> Imprimir Doc.</label>
                            <input name="chk_imprimir" type="checkbox" id="chk_imprimir" value="1" checked="CHECKED">
                        <?php }?>
                    </td>
                    <td class="imprimir_guia" style="display: none">
                        <?php if($_POST['action']=="insertar" || $_POST['action']=="insertar_cot"){?>
                            <label for="chk_imprimir_guia"> Registrar e Imprimir Guia</label>
                            <input name="chk_imprimir_guia" type="checkbox" id="chk_imprimir_guia" value="1"  title="Registrar guia? ">
                            <input name="txt_ven_numdocguia" type="text" id="txt_ven_numdocguia" class="insertar-guia" style="text-align:right; font-size:14px"  value="<?php echo $serguia.'-'.$numguia?>" size="10" readonly>
                        <?php }?>
                    </td>
                    <?php if($_POST['action']=="editar") {?>
                        <td>
                            <label for="chk_imprimir_guia"> Numero Guia</label>
                            <input name="txt_ven_numdocguia" type="text" id="txt_ven_numdocguia" style="text-align:right; font-size:14px"  value="<?php echo $serguia.'-'.$numguia?>" size="10" readonly>
                        </td>
                    <?php }?>

                    <td align="right">
                        <?php
                        if($_POST['action']=="editar")
                        {
                            echo "<span title='PUNTO DE VENTA'>PV: ".$punven_nom."</span>";
                            //echo " | A: ".$alm_nom;
                        }?>
                        <?php
                        if($_POST['action']=="editar"){
                            ?>
                            <a class="btn_imp" title="Imprimir" href="#imprimir" onClick="venta_impresion('<?php echo $_POST['ven_id']?>')">Imprimir</a>
                        <?php }?>
                        <?php
                        $url=ir_principal($_SESSION['usuariogrupo_id']);
                        ?>
                        <a class="btn_newwin" target="_blank" title="Saltar a otra pestaña" href="<?php echo $url?>">Saltar</a>
                    </td>
                </tr>
                <tr>
                    <td height="27">
                        <select name="cmb_ven_est" id="cmb_ven_est" hidden>
                            <option value="">-</option>
                            <option value="CANCELADA" <?php if($est=='CANCELADA')echo 'selected'?>>CANCELADA</option>
                            <option value="ANULADA" <?php if($est=='ANULADA')echo 'selected'?>>ANULADA</option>
                        </select>
                        <div id="msj_venta_form" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                        <input type="hidden" name="txt_ven_lab1" id="txt_ven_lab1" value="<?php echo $lab1?>" size="9" maxlength="8">
                        <input type="hidden" name="txt_ven_lab2" id="txt_ven_lab2" value="<?php echo $lab2?>" size="9" maxlength="8">
                        <label for="txt_ven_lab3">Ord. Compra:</label>
                        <input type="text" name="txt_ven_lab3" id="txt_ven_lab3" value="<?php echo $lab3?>" size="20" maxlength="20">
                        <input name="hdd_ven_doc" id="hdd_ven_doc" type="hidden" value="">
                        <label for="cmb_ven_imp">Formato:</label>
                        <select name="cmb_ven_imp" id="cmb_ven_imp">
                            <option value="1" selected>Ticket</option>
                            <option value="2" selected>A4</option>
                        </select>
                        <label for="cmb_ven_moneda">Moneda:</label>
                        <select name="cmb_ven_moneda" id="cmb_ven_moneda" <?php if($_POST['action']=='editar')echo 'disabled'?>>
                            <option value="1" <?php if($monval=='1')echo 'selected'?>>SOLES</option>
                            <option value="2" <?php if($monval=='2')echo 'selected'?>>DOLARES</option>
                        </select>
                        <label for="chk_ven_may">Venta al por mayor</label>
                        <input name="chk_ven_may" type="checkbox" id="chk_ven_may" value="1"  <?php if($may==1)echo 'checked'?>>
                    </td>
                    <td align="right">
                        <?php
                        if($_POST['action']=="insertar" || $_POST['action']=="insertar_cot"){
                            echo "PV: ".$_SESSION['puntoventa_nom'];
                            echo " | A: ".$_SESSION['almacen_nom'];
                        }
                        if($_POST['action']=="editar"){
                            echo "Registro: $reg";
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        <div style="float: left; width: 80%;">
            <input type="hidden" id="hdd_ven_cli_id" name="hdd_ven_cli_id" value="<?php echo $cli_id?>" />
            <input type="hidden" id="hdd_ven_cli_tip" name="hdd_ven_cli_tip" value="<?php echo $cli_ret?>" />
            <input type="hidden" id="hdd_ven_cli_ret" name="hdd_ven_cli_ret" value="<?php echo $cli_tip?>" />
            <input type="hidden" id="hdd_cli_precio_id" name="hdd_cli_precio_id" value="<?php echo $cli_prec_id?>" />
            <input type="hidden" id="hdd_val_cli_tip" name="hdd_val_cli_tip" value="<?php if($_POST['action']=='editar')echo $cli_tip;?>" />

            <fieldset style="background-color: rgba(0,239,230,0.22);">
                <legend>Datos Cliente</legend>
                <div id="div_cliente_form">
                </div>
                <table>
                    <tr>
                        <td align="right"><?php if($_POST['action']=='insertar'){?>
                                <a id="btn_cli_form_agregar" href="#" onClick="cliente_form_i('insertar')">Agregar Cliente</a>
                                <a id="btn_cli_form_modificar" href="#" onClick="cliente_form_i('editar',$('#hdd_ven_cli_id').val())">Modificar Cliente</a>
                            <?php }?>
                            <label for="txt_ven_cli_doc">RUC/DNI: <span style="color: #00aa00;font-size: 25px; font-weight: bold">2.</span></label>
                        </td>
                        <td>
                            <input name="txt_ven_cli_doc" type="text" id="txt_ven_cli_doc" value="<?php echo $cli_doc?>" size="12" maxlength="11" />
                            <label for="txt_ven_cli_nom">Cliente:</label>
                            <input type="text" id="txt_ven_cli_nom" name="txt_ven_cli_nom" size="40" value='<?php echo $cli_nom?>' />
                        </td>
                        <td rowspan="2" valign="top">
                            <div id="div_clientecuenta_detalle">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><label for="txt_ven_cli_dir">Dirección:</label></td>
                        <td><input type="text" id="txt_ven_cli_dir" name="txt_ven_cli_dir" size="62" value="<?php echo $cli_dir?>" readonly="readonly"/></td>
                    </tr>
                    <tr>
                        <td align="right"><label for="txt_ven_cli_est">Estado:</label></td>
                        <td>
                            <input type="text" id="txt_ven_cli_est" name="txt_ven_cli_est" size="40" value="" disabled="disabled"/>
                            <div id="msj_busqueda_sunat" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div style="float: left; width: 20%; display: none;" class="insertar-guia">
            <fieldset>
                <legend>Datos Vehículo</legend>
                <label for="txt_gui_mar">Marca:</label><br>
                <input type="text" id="txt_gui_mar" name="txt_gui_mar" value="<?php echo $mar?>" /><br>
                <label for="txt_gui_pla">Placa:</label><br>
                <input type="text" name="txt_gui_pla" id="txt_gui_pla"  value="<?php echo $pla?>">
            </fieldset>
        </div>
        <div style="float: left; width: 50%; display: none;" class="insertar-guia">
            <fieldset>
                <legend>Datos Transporte</legend>
                <?php if($_POST['action']=='insertar'){?>
                    <!--Boton Editar/Registrar Conductor-->
                    <a id="btn_tra_form_agregar" href="#" onClick="transporte_form('insertar')">Agregar Transporte</a>
                    <a id="btn_tra_form_modificar" href="#" onClick='transporte_form("editar", $("#txt_fil_gui_tra_id").val())'>Modificar Transporte</a>
                <?php }?>
                <input type="hidden" id="txt_fil_gui_tra_id" name="txt_fil_gui_tra_id" value="<?php echo $tra_id?>" />
                <label for="txt_fil_gui_tra_ruc">RUC:</label>
                <input type="text" id="txt_fil_gui_tra_ruc" name="txt_fil_gui_tra_ruc" size="15" value="<?php echo $tra_ruc?>" /><br>
                <!--<a id="btn_cmb_tra_id" class="btn_ir" href="#" onClick="verificarAccionTransporte()">Agregar Transporte</a>-->
                <label for="txt_fil_gui_tra_razsoc">Transporte:</label>
                <input type="text" id="txt_fil_gui_tra_razsoc" name="txt_fil_gui_tra_razsoc" size="40" value="<?php echo $tra_razsoc?>" /><br>
                <label for="txt_fil_gui_tra_dir">Direcci&oacute;n:</label>
                <input type="text" id="txt_fil_gui_tra_dir" name="txt_fil_gui_tra_dir" size="40" value="<?php echo $tra_dir?>" disabled="disabled"/>
            </fieldset>
            <label for="txt_ven_guia_dir">Punto de Llegada:</label>
            <input type="hidden" id="txt_ven_guia_dir" name="txt_ven_guia_dir" size="40" value="<?php echo $cli_dir?>"/>
            <select name="cmb_cli_suc" id="cmb_cli_suc">

            </select>


        </div>
        <div style="float: left; width: 50%; display: none;" class="insertar-guia" >
            <fieldset id="fset_conductor" disabled="disabled">
                <legend>Datos Conductor</legend>
                <?php if($_POST['action']=='insertar'){?>
                    <!--Boton Editar/Registrar Conductor-->
                    <a id="btn_con_form_agregar" href="#" onClick="conductor_form('insertar')">Agregar Conductor</a>
                    <a id="btn_con_form_modificar" href="#" onClick='conductor_form("editar", $("#txt_fil_gui_con_id").val())'>Modificar Conductor</a>
                <?php }?>
                <input type="hidden" id="txt_fil_gui_con_id" name="txt_fil_gui_con_id" value="<?php echo $con_id?>" />
                <label for="txt_fil_gui_con_doc">RUC/DNI:</label>
                <input type="text" id="txt_fil_gui_con_doc" name="txt_fil_gui_con_doc" size="15" value="<?php echo $con_doc?>" /><br>
                <!--<a id="btn_cmb_con_id" class="btn_ir" href="#" onClick="verificarAccionConductor()">Agregar Conductor</a>-->
                <label for="txt_fil_gui_con_nom">Conductor:</label>
                <input type="text" id="txt_fil_gui_con_nom" name="txt_fil_gui_con_nom" size="40" value="<?php echo $con_nom?>" /><br>
                <label for="txt_fil_gui_con_dir">Direcci&oacute;n:</label>
                <input type="text" id="txt_fil_gui_con_dir" name="txt_fil_gui_con_dir" size="40" value="<?php echo $con_dir?>" readonly="readonly"/><br>
                <label for="txt_fil_gui_con_lic">Licencia:</label>
                <input type="text" id="txt_fil_gui_con_lic" name="txt_fil_gui_con_lic" size="15" value="<?php echo $con_lic?>" readonly="readonly"/>
                <label for="txt_fil_gui_con_cat">Categoría:</label>
                <input type="text" id="txt_fil_gui_con_cat" name="txt_fil_gui_con_cat" size="10" value="<?php echo $con_cat?>" readonly="readonly"/>
            </fieldset>
        </div>

        <div style="float: left; width: 80%;">
            <fieldset><legend>Registro de Pagos</legend>
                <?php if($_POST['action']=='insertar' || $_POST['action']=='insertar_cot'){?>
                    <table border="0" cellspacing="2" cellpadding="0">
                        <tr>
                            <td width="70" valign="top"><label for="chk_venpag_aut" title="Registrar Pago Automaticamente">Reg Auto</label></br>
                                <input name="chk_venpag_aut" type="checkbox" id="chk_venpag_aut" value="1" checked="CHECKED">
                            </td>
                            <td width="40" valign="middle">
                                <div id="div_pago_agregar" style="display:none">
                                    <a class="btn_venpag_agregar" href="#" onClick="venta_pago_car('agregar')">Agregar</a>
                                </div>
                            </td>
                            <?php /*?><td>
    <label for="txt_venpag_fec">Fecha:</label>
      <input type="text" name="txt_venpag_fec" id="txt_venpag_fec" size="10" maxlength="10" value="<?php echo $venpag_fec?>" readonly>
    </td><?php */?>
                            <td valign="top"><label for="txt_venpag_mon">Monto:</label></br>
                                <input name="txt_venpag_mon" type="text" class="venpag_moneda" id="txt_venpag_mon" style="text-align:right;" size="10" maxlength="10"></td>
                            <td valign="top">
                                <label for="cmb_forpaf_id">Forma<!-- Pago-->:</label></br>
                                <select name="cmb_forpag_id" id="cmb_forpag_id">
                                    <option value="1" selected="selected">CONTADO</option>
                                    <option value="2">CREDITO</option>
                                    <option value="3">LETRAS</option>
                                </select>
                            </td>
                            <td valign="top"><!--<label for="cmb_modpaf_id">Modo Pago:</label>--></br>
                                <select name="cmb_modpag_id" id="cmb_modpag_id">
                                    <option value="1" selected="selected">EFECTIVO</option>
                                    <option value="2">DEPOSITO</option>
                                    <option value="3">TARJETA</option>
                                    <option value="4">CANJE</option>
                                </select></td>
                            <td valign="top">
                                <div id="div_tarjeta" style="display:none">
                                    <label for="cmb_tar_id">Tarjeta:</label></br>
                                    <select name="cmb_tar_id" id="cmb_tar_id">
                                    </select>
                                </div>
                                <div id="div_cuentacorriente" style="display:none">
                                    <label for="cmb_cuecor_id">Cuenta Corriente:</label></br>
                                    <select name="cmb_cuecor_id" id="cmb_cuecor_id">
                                    </select>
                                </div>
                            </td>
                            <td valign="top">
                                <div id="div_operacion" style="display:none">
                                    <label for="txt_venpag_numope">N° Operación:</label></br>
                                    <input type="text" name="txt_venpag_numope" id="txt_venpag_numope" size="15">
                                </div>
                            </td>

                            <td valign="top">
                                <div id="div_dia" style="display:none">
                                    <label for="txt_venpag_numdia">N° Días:</label></br>
                                    <input name="txt_venpag_numdia" id="txt_venpag_numdia" type="text" class="dias" size="5" maxlength="3">
                                </div>
                            </td>

                            <td valign="top">
                                <div id="div_fecven" style="display:none">
                                    <label for="txt_venpag_fecven">Fec Vencto:</label></br>
                                    <input type="text" name="txt_venpag_fecven" id="txt_venpag_fecven" size="10" maxlength="10" readonly>
                                </div>
                            </td>
                            <td valign="top">
                                <div id="div_numeroletras" style="display:none">
                                    <label for="txt_numletras">N° Letras:</label></br>
                                    <input name="txt_numletras" id="txt_numletras" type="text" class="cantidad_letras" size="10" maxlength="1">
                                </div>
                            </td>
                        </tr>
                        <tr style="width:100%;" class="letras_fecven">
                            <td colspan="3" style="display:none;" class="letras_fecven1">
                                <input type="text" id="dias1" for="txt_letras_fecven1" value="30"><br>
                                <input type="text" name="txt_letras_fecven1" id="txt_letras_fecven1" size="10" maxlength="10" readonly>
                            </td>
                            <td colspan="3" style="display:none;" class="letras_fecven2">
                                <input type="text" id="dias2" for="txt_letras_fecven2" value="60"><br>
                                <input type="text" name="txt_letras_fecven2" id="txt_letras_fecven2" size="10" maxlength="10" readonly>
                            </td>
                            <td colspan="3" style="display:none;" class="letras_fecven3">
                                <input type="text" id="dias3" for="txt_letras_fecven3" value="90"><br>
                                <input type="text" name="txt_letras_fecven3" id="txt_letras_fecven3" size="10" maxlength="10" readonly>
                            </td>
                            <td colspan="3" style="display:none;" class="letras_fecven4">
                                <input type="text" id="dias4" for="txt_letras_fecven4" value="120"><br>
                                <input type="text" name="txt_letras_fecven4" id="txt_letras_fecven4" size="10" maxlength="10" readonly>
                            </td>
                            <td colspan="3" style="display:none;" class="letras_fecven5">
                                <input type="text" id="dias5" for="txt_letras_fecven5" value="150"><br>
                                <input type="text" name="txt_letras_fecven5" id="txt_letras_fecven5" size="10" maxlength="10" readonly>
                            </td>
                        </tr>
                        <tr style="width:100%;" class="letras_fecven">
                            <td colspan="3" style="display:none;" class="letras_fecven1">
                                <label for="txt_letras_mon1">Monto 1:</label><br>
                                <input type="text" name="txt_letras_mon1" id="txt_letras_mon1" size="10" maxlength="120" readonly>
                            </td>
                            <td colspan="3" style="display:none;" class="letras_fecven2">
                                <label for="txt_letras_mon2">Monto 2:</label><br>
                                <input type="text" name="txt_letras_mon2" id="txt_letras_mon2" size="10" maxlength="20" readonly>
                            </td>
                            <td colspan="3" style="display:none;" class="letras_fecven3">
                                <label for="txt_letras_mon3">Monto 3:</label><br>
                                <input type="text" name="txt_letras_mon3" id="txt_letras_mon3" size="10" maxlength="20" readonly>
                            </td>
                            <td colspan="3" style="display:none;" class="letras_fecven4">
                                <label for="txt_letras_mon4">Monto 4:</label><br>
                                <input type="text" name="txt_letras_mon4" id="txt_letras_mon4" size="10" maxlength="10" readonly>
                            </td>
                            <td colspan="3" style="display:none;" class="letras_fecven5">
                                <label for="txt_letras_mon5">Monto 5:</label><br>
                                <input type="text" name="txt_letras_mon5" id="txt_letras_mon5" size="10" maxlength="10" readonly>
                            </td>
                        </tr>
                    </table>

                    <div id="div_venta_pago_car">
                    </div>
                <?php }?>
                <div id="div_venta_pago_tabla">
                </div>
                <div>
                    <?php
                    if($_SESSION['usuariogrupo_id']==2){
                        ?>
<!--                        <label for="hdd_usu_id">Vendedor:</label>-->
<!--                        <select name="hdd_usu_id" id="hdd_usu_id" --><?php //if($_POST['action']=='editar')echo 'disabled'?><!-->
<!--                        </select>-->
                        <input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
                        <?php if($_POST['action']=='insertar'||$_POST['action']=='insertar_cot') { ?>

                            <?php
                        }
                    }
                    ?>
                    <?php
                    if($_SESSION['usuariogrupo_id']==3){
                        ?>
                        <input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
                        <?php
                    }
                    ?>
                </div>
            </fieldset>
        </div>
        <div style="clear: both;"></div>
        <?php if($_POST['action']=='insertar'){?>
            <div id="div_productos_servicios_tab">
                <ul>
                    <li><a id="carga_productos" href="#div_productos">Agregar Productos</a></li>
                    <li><a id="carga_servicios" href="#div_servicios">Agregar Servicios</a></li>
                </ul>
                <div id="div_productos" style="background-color: rgba(220,240,5,0.25);">
                    <div id="cuadro-contain" class="ui-widget">
                        <!--              <legend>Agregar Producto</legend>-->
                        <input name="hdd_bus_cat_id" id="hdd_bus_cat_id"  type="hidden" value="">
                        <input name="hdd_detven_tip" id="hdd_detven_tip"  type="hidden" value="">
                        <input name="hdd_bus_cat_stouni" id="hdd_bus_cat_stouni"  type="hidden" value="">
                        <input name="hdd_bus_cat_cospro" id="hdd_bus_cat_cospro"  type="hidden" value="">
                        <span style="color: #00aa00;font-size: 25px; font-weight: bold">3.</span>
                        <label for="txt_bus_pro_codbar">COD</label>
                        <input name="txt_bus_pro_codbar" type="text" id="txt_bus_pro_codbar" size="7">
                        <label for="txt_bus_pro_nom">NOM</label>
                        <input name="txt_bus_pro_nom" type="text" id="txt_bus_pro_nom" size="25" style="font-size:13px; font-weight:bold">
                        <input name="hdd_bus_pro_nom" type="hidden" id="hdd_bus_pro_nom">

                        <label for="txt_bus_cat_preven">S/.</label>
                        <input name="txt_bus_cat_preven" type="text" id="txt_bus_cat_preven" value="" size="5" maxlength="9" style="text-align:right; font-size:13px; font-weight:bold" class="moneda">

                        <label for="txt_bus_cat_can">CAN</label>
                        <input name="txt_bus_cat_can" type="text" id="txt_bus_cat_can" class="cantidad_cat_ven" value="" size="4" maxlength="6" style="text-align:right; font-size:13px; font-weight:bold">

                        <a class="btn_bus_mas" href="#mas" onClick="bus_cantidad('mas')">Aumentar</a>
                        <a class="btn_bus_menos" href="#menos" onClick="bus_cantidad('menos')">Disminuir</a>
                        <label for="txt_detcom_des">DES</label>
                        <input type="text" name="txt_detcom_des" id="txt_detcom_des" class="moneda" value="<?php echo formato_money(0.00)?>" size="4" maxlength="5" style="text-align:right" >
                        <span style="color: #00aa00;font-size: 25px; font-weight: bold">4.</span>
                        <a class="btn_bus_agregar" href="#" onClick="foco(); venta_car('agregar')">Agregar</a>


                        <br>
                        <!--a class="btn_agregar_producto" title="Abrir Catálogo" href="#" onClick="catalogo_venta_tab1()">Catálogo</a -->
                        <a class="btn_rest_act" href="#" onClick="foco(); venta_car('actualizar')">Actualizar</a>
                        <a class="btn_rest_car" href="#" onClick="foco(); venta_car('restablecer')">Vaciar</a>

                        <label for="chk_modo">Automático</label>
                        <input name="chk_modo" type="checkbox" id="chk_modo" value="1" <?php if($modo_automatico==1)echo "checked"?>>

                        <label for="txt_precio_min">P.MIN.</label>
                        <input type="text" name="txt_precio_min" id="txt_precio_min" size="10" readonly>

                        <label for="txt_precio_min" style="color: red;">P.MAY.</label>
                        <input type="text" name="txt_precio_may" id="txt_precio_may" size="10" readonly>

                        <label for="che_mayorista">Precio Mayorista</label>
                        <input type="checkbox" id="che_mayorista" style="margin-top: 5px;">

                        <label for="cmb_listaprecio_id">Lista Precios:</label>
                        <select name="cmb_listaprecio_id" id="cmb_listaprecio_id">
                        </select>
                        <div id="div_listaprecio_form">
                        </div>
                        <div id="msj_venta_det" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                    </div>
                </div>

                <div id="div_servicios">
                    <div id="cuadro-contain" class="ui-widget">
                        <!--             <legend>Agregar Servicios</legend>-->
                        <?php if($_POST['vista']!='cange'){?>
                            <a class="btn_agregar_producto" title="Agregar Producto y/o Servicio (A+P)" href="#" onClick="catalogo_venta_tab()">Agregar</a>
                            <a class="btn_rest_car" href="#" onClick="venta_car('restablecer')">Vaciar</a>
                        <?php }?>
                        <a class="btn_rest_act" href="#" onClick="venta_car('actualizar')">Actualizar</a>
                        <div id="msj_ventanota_car" class="ui-state-error ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php if($msj!=""){echo 'block';} else{ echo 'none';}?>"><?php echo $msj?></div>
                        <div id="msj_venta_check" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php
        if($_POST['action']=="insertar" || $_POST['action']=="insertar_cot"){
            ?>
            <div id="div_venta_car_tabla">
            </div>
            <div id="div_item_form">
            </div>
            <div id="div_venta_validar_form">
            </div>
        <?php }?>
    </form>
</div>
<?php
if($_POST['action']=="insertar" || $_POST['action']=="insertar_cot"){
    ?>
    <div id="div_catalogo_venta">
    </div>
    <?php
}
if($_POST['action']=="editar"){
    ?>
    <br>
    <div id="div_venta_detalle_tabla">

    </div>

<?php }?>
<div id="div_producto_form">

</div>

<div id="div_tabla_lote_venta">
</div>

<div id="div_lote_venta_form">
</div>
<script type="text/javascript">
    //catalogo_venta_tab();
</script>
