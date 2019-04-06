<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
$oCompra = new cCompra();

require_once("../formatos/formato.php");
require_once("../menu/acceso.php");
require_once("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();

if($_POST['action']=="insertar"){
    $fec=date('d-m-Y');
    $dias=0;
    $fecven=date('d-m-Y');
    $unico_id=uniqid();
    unset($_SESSION['precio_car']);
}

if($_POST['action']=="editar"){
    $dts= $oCompra->mostrarUno($_POST['com_id']);
    $dt = mysql_fetch_array($dts);
    $fec	=mostrarFecha($dt['tb_compra_fec']);
    $fecven	=mostrarFecha($dt['tb_compra_fecven']);

    $doc_id	=$dt['tb_documento_id'];
    $numdoc	=$dt['tb_compra_numdoc'];
    $mon	=$dt['tb_compra_mon'];
    $tipcam	=$dt['tb_compra_tipcam'];

    $pro_id	=$dt['tb_proveedor_id'];
    $subtot	=$dt['tb_compra_subtot'];
    $des	=$dt['tb_compra_des'];
    $descal	=$dt['tb_compra_descal'];
    $fle	=$dt['tb_compra_fle'];
    $tipfle	=$dt['tb_compra_tipfle'];
    $ajupos	=$dt['tb_compra_ajupos'];
    $ajuneg	=$dt['tb_compra_ajuneg'];
    $valven	=$dt['tb_compra_valven'];
    $igv	=$dt['tb_compra_igv'];
    $tot	=$dt['tb_compra_tot'];

    $tipper	=$dt['tb_compra_tipper'];
    $per	=$dt['tb_compra_per'];

    $alm_id	=$dt['tb_almacen_id'];
    $est	=$dt['tb_compra_est'];
    $numorden	=$dt['tb_compra_orden'];
    $tiporenta_id	=$dt['tb_tiporenta_id'];
    mysql_free_result($dts);
}
?>
<script type="text/javascript">
    $('.btn_newwin').button({
        icons: {primary: "ui-icon-newwin"},
        text: false
    });
    $('#btn_pro_form_agregar').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });
    $("#btn_pro_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_pro_form_modificar').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });
    $("#btn_pro_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

    $('#btn_compra_precio_form').button({
        icons: {primary: "ui-icon-newwin"},
        text: true
    }).keyup(function(e){
        if(e.keyCode != '8'){
            if (e.target.value.length == 2) e.target.value = e.target.value + "-";
            if (e.target.value.length == 5) e.target.value = e.target.value + "-";
        }
    });



    $( "#txt_com_fec,.txt_com_fec" ).datepicker({
        minDate: "-2Y",
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

    }).keyup(function(e){
        if(e.keyCode != '8'){
            if (e.target.value.length == 2) e.target.value = e.target.value + "-";
            if (e.target.value.length == 5) e.target.value = e.target.value + "-";
        }
    });

    $( "#txt_com_fecven" ).datepicker({
        //minDate: "0D",
        //maxDate:"+0D",
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

    function cmb_pro_id(ids)
    {
        $.ajax({
            type: "POST",
            url: "../proveedor/cmb_pro_id.php",
            async:true,
            dataType: "html",
            data: ({
                pro_id: ids
            }),
            beforeSend: function() {
                $('#cmb_pro_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_pro_id').html(html);
            }
        });
    }

    function cmb_com_doc()
    {
        $.ajax({
            type: "POST",
            url: "../documento/cmb_doc_id.php",
            async:true,
            dataType: "html",
            data: ({
                doc_tip:	'1',
                doc_id: '<?php echo $doc_id?>',
                vista:	'<?php echo $_POST['action']?>'
            }),
            beforeSend: function() {
                $('#cmb_com_doc').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_com_doc').html(html);
            }
        });
    }

    function cmb_com_alm_id()
    {
        $.ajax({
            type: "POST",
            url: "../almacen/cmb_alm_id.php",
            async:true,
            dataType: "html",
            data: ({
                alm_id: '<?php echo $alm_id?>'
            }),
            beforeSend: function() {
                $('#cmb_com_alm_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_com_alm_id').html(html);
            }
        });
    }


    function lote_form(act,cat_id, lote_num){
        $.ajax({
            type: "POST",
            url: "../lote/lote_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                cat_id: cat_id,
                lote_num: lote_num
            }),
            beforeSend: function() {
                $('#msj_presentacion_lote').hide();
                $('#div_lote_form').dialog("open");
                $('#div_lote_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_lote_form').html(html);
            }
        });
    }

    function lote_car(act,idf,cant,lote_num)
    {

        $.ajax({
            type: "POST",
            url: "../lote/lote_car.php",
            async:true,
            dataType: "html",
            data: ({
                action:	 act,
                cat_id:	 idf,
                txt_cant: cant,
                txt_lote_num: lote_num
            }),
            beforeSend: function() {
                $('#div_tabla_lote_car').dialog("open");
                $('#div_tabla_lote_car').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_tabla_lote_car').html(html);
            },
            complete: function(){
            }
        });
    }

    function compra_car(act,idf,pre)
    {
        /*if($('#chk_cat_igv_'+idf).is(':checked')) {
            var chk=1;
        } else {
            var chk=0;
        }*/
        if($('#chk_com_tipper').is(':checked')) {
            var tipper=1;
        } else {
            var tipper=0;
        }
        var imp_dol = [];
        for (var i=1;i<=5;i++){
            imp_dol.push($('#imp_dol'+i).val())
        }
        $.ajax({
            type: "POST",
            url: "compra_car.php",
            async:true,
            dataType: "html",
            data: ({
                action:	 act,
                cat_id:	 idf,
                cat_can: 		$('#txt_cat_can_'+idf).val(),
                cat_precom: 	$('#txt_cat_precom_'+idf).val(),
                cat_des: 		$('#txt_detcom_des_'+idf).val(),
                cat_fle:	 	$('#txt_detcom_fle_'+idf).val(),
                tipo_cambio: 	$('#txt_com_tipcam').val(),
                tipo_precio:	pre,
                cmb_afec_id: 	$('#cmb_afec_id_'+idf).val(),
                com_tipper:	tipper,
                unico_id: $('#unico_id').val(),
                imp_dol: imp_dol,
                cmb_com_doc: $('#cmb_com_doc').val()

            }),
            beforeSend: function() {
                //$("#txt_fil_pro_nom").val(''); $("#txt_fil_pro_nom").focus();
                $('#div_compra_car_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_compra_car_tabla').html(html);
            },
            complete: function(){
                $('#div_compra_car_tabla').removeClass("ui-state-disabled");
            }
        });
    }

    function compra_car_prorrateo()
    {
        $.ajax({
            type: "POST",
            url: "compra_car_prorrateo.php",
            async:true,
            dataType: "json",
            data: ({
                com_des: 	$('#txt_com_des').val(),
                com_fle:	$('#txt_com_fle').val(),
                com_ajupos:	$('#txt_com_ajupos').val(),
                com_ajuneg:	$('#txt_com_ajuneg').val(),
                com_tipfle: $('#cmb_com_tipfle').val()
            }),
            beforeSend: function(){
                $('#msj_compra_car_item').html("Cargando...");
                $('#msj_compra_car_item').show(100);
            },
            success: function(data){
                $('#msj_compra_car_item').html(data.msj);
            },
            complete: function(){
                compra_car('actualizar');
            }
        });
    }

    function catalogo_compra(){
        $.ajax({
            type: "POST",
            url: "../catalogo/catalogo_compra.php",
            async:true,
            dataType: "html",
            data: ({
                //action: act,
                //tippre:	$('#cmb_com_tippre').val()
            }),
            beforeSend: function() {
                $('#div_tab_producto').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_tab_producto').html(html);
            }
        });
    }

    function compra_detalle_tabla()
    {
        $.ajax({
            type: "POST",
            url: "../compra/compra_detalle_tabla.php",
            async:true,
            dataType: "html",
            data: ({
                com_id:	'<?php echo $_POST['com_id']?>'
            }),
            beforeSend: function() {
                $('#div_compra_detalle_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_compra_detalle_tabla').html(html);
            },
            complete: function(){
                $('#div_compra_detalle_tabla').removeClass("ui-state-disabled");
            }
        });
    }

    function catalogo_compra_tab(){
        $.ajax({
            type: "POST",
            url: "../catalogo/catalogo_compra_tab.php",
            async:true,
            dataType: "html",
            data: ({
                //action: act,
                //ven_id:	idf
            }),
            beforeSend: function() {
                $('#msj_venta').hide();
                $('#div_catalogo_compra').dialog("open");
                $('#div_catalogo_compra').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_catalogo_compra').html(html);
            },
            complete: function(){
                catalogo_compra();
                catalogo_servicio_compra();
            }
        });
    }

    function compra_car_servicio(act,idf,pre){
        console.log('pre');
        console.log(pre);
        var imp_dol = [];
        for (var i=1;i<=5;i++){
            imp_dol.push($('#imp_dol'+i).val())
        }
        $.ajax({
            type: "POST",
            url: "../compra/compra_car.php",
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
                ser_pre: $('#txt_servicio_pre_'+idf).val(),
                imp_dol: imp_dol,
                tipo_precio: pre,
                tipo_cambio: 	$('#txt_com_tipcam').val(),
            }),
            beforeSend: function() {
                $("#txt_fil_ser_nom").val(''); $("#txt_fil_ser_nom").focus();
                $('#div_compra_car_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_compra_car_tabla').html(html);
            },
            complete: function(){
                $('#div_compra_car_tabla').removeClass("ui-state-disabled");
            }
        });
    }

    function catalogo_servicio_compra(){
        $.ajax({
            type: "POST",
            url: "../catalogo/catalogo_servicio_compra.php",
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
    //adicionales

    function proveedor_cargar_datos(idf){
        $.ajax({
            type: "POST",
            url: "../proveedor/proveedor_reg.php",
            async:true,
            dataType: "json",
            data: ({
                action: "obtener_datos",
                pro_id:	idf
            }),
            beforeSend: function() {
                //$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(data){
                $('#hdd_com_pro_id').val(idf);
                $('#txt_com_pro_nom').val(data.nombre);
                $('#txt_com_pro_doc').val(data.documento);
                $('#txt_com_pro_dir').val(data.direccion);
            }
        });
    }

    function proveedor_form_i(act,idf){
        $.ajax({
            type: "POST",
            url: "../proveedor/proveedor_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                pro_id:	idf,
                vista:	'hdd_pro_id'
            }),
            beforeSend: function() {
                //$('#msj_proveedor').hide();
                //$("#btn_cmb_pro_id").click(function(e){
                $("#btn_pro_form_agregar").click(function(e){
                    x=e.pageX+5;
                    y=e.pageY+15;
                    $('#div_proveedor_form').dialog({ position: [x,y] });
                    $('#div_proveedor_form').dialog("open");
                });

                if(act=='editar'){
                    if(idf>0){
                        $("#btn_pro_form_modificar").click(function(e){
                            x=e.pageX+5;
                            y=e.pageY+15;
                            $('#div_proveedor_form').dialog({ position: [x,y] });
                            $('#div_proveedor_form').dialog("open");
                        });
                    }
                    else{
                        alert('Seleccione Proveedor');
                    }
                }

                $('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_proveedor_form').html(html);
            }
        });
    }

    function txt_venpag_fecven_compra(){
        $.ajax({
            type: "POST",
            url: "../venta/venta_txt_fecven.php",
            async:true,
            dataType: "json",
            data: ({
                ven_fec: 		$('#txt_com_fec').val(),
                venpag_numdia: 	$('#txt_fecven_dias').val()
            }),
            beforeSend: function() {
                //$('#txt_ven_numdoc').val('Cargando...');
            },
            success: function(data){
                //alert(data.fecha);
                $('#txt_com_fecven').val(data.fecha);
            },

        });
    }


    function editar_datos_item(idf, nom){
        $.ajax({
            type: "POST",
            url: "../compra/compra_car_item.php",
            async:true,
            dataType: "html",
            data: ({
                cat_id:	idf,
                action: "editar",
                pro_nom: nom
            }),
            beforeSend: function() {
                //$('#msj_proveedor').hide();
                $(".btn_item").click(function(e){
                    x=e.pageX-200;
                    y=e.pageY+15;
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

    function tipo_cambio(mon){
        $.ajax({
            type: "POST",
            url: "../tipocambio/tipocambio_reg.php",
            async:true,
            dataType: "json",
            data: ({
                action: "obtener_dato",
                fecha:	$('#txt_com_fec').val(),
                moneda:	mon
            }),
            beforeSend: function() {
                //$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(data){
                $('#txt_com_tipcam').val(data.tipcam);
            },
            complete: function(){
                //catalogo_compra_tab(); //NI IDEA
            }
        });
    }

    function verificar_duplicidad_compra(com_doc,com_numdoc,com_numruc){
        $.ajax({
            type: "POST",
            url: "../compra/compra_duplicidad.php",
            async:true,
            dataType: "html",
            data: ({
                doc: com_doc,
                numdoc:	com_numdoc,
                numruc:	com_numruc
            }),
            beforeSend: function(){

            },
            success: function(html){
                $('#div_duplicidad').dialog("open");
                $('#div_duplicidad').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
                $('#div_duplicidad').html(html);
            }
        });
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
    function cmb_tiporenta_id()
    {
        $.ajax({
            type: "POST",
            url: "cmb_tiporenta_id.php",
            async:true,
            dataType: "html",
            data: ({
                tiporenta_id: '<?php echo $tiporenta_id; ?>'
            }),
            beforeSend: function() {
                $('#cmb_tiporenta_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_tiporenta_id').html(html);
            }
        });

    }


    $(function() {

        $('#txt_com_fec').keyup(function(e) {
            var patron = new Array(2, 2, 4);
            mascara(this,'-',patron,false);
        });
        $('#txt_com_fecven').keyup(function(e) {
            var patron = new Array(2, 2, 4);
                mascara(this,'-',patron,false);
        });

        $('#cmb_com_doc').change(function(e) {
            $('#txt_com_numdoc').focus();
        });



        cmb_com_doc();
        cmb_com_alm_id();
        cmb_tiporenta_id();

        <?php
        if($_POST['action']=="insertar"){
        ?>
        compra_car('restablecer');
        compra_car();
        lote_car('restablecer');

        tipo_cambio($('#cmb_com_mon').val());

        $('#cmb_com_mon').change(function(e) {
            compra_car('restablecer');
            tipo_cambio($('#cmb_com_mon').val());
            //catalogo_compra_tabla();
        });
        $('#txt_com_fec').change(function(e) {
            tipo_cambio($('#cmb_com_mon').val());
        });

        $('#chk_com_tipper').change( function() {
            compra_car('actualizar');
        });
        $("#txt_fecven_dias").keyup(function() {
            txt_venpag_fecven_compra();
        });

        $("#txt_com_fec").keyup(function() {
            txt_venpag_fecven_compra();
        });
        $("#cmb_com_doc").change(function() {
            if ($(this).val()=='20' || $(this).val()=='21'){
                $('#nota-debito-credito').show();
                $("#txt_com_ser_nota").attr('disabled', false);
                $("#txt_com_num_nota").attr('disabled', false);
                $("#cmb_com_tip").attr('disabled', false);

            }else{
                $('#nota-debito-credito').hide();
                $("#txt_com_ser_nota").attr('disabled', true);
                $("#txt_com_num_nota").attr('disabled', true);
                $("#cmb_com_tip").attr('disabled', true);
            }
            if ($(this).val()=='19' || $(this).val()=='23') {
                $("#cmb_com_tippre").val('2');
                $('#doc_compra_serv').css('display', 'block');
                $('.tipo_renta').css('display', 'block');
            }else{
                $("#cmb_com_tippre").val('1');
                $('#doc_compra_serv').css('display', 'none');
                $('.tipo_renta').css('display', 'none');
            }
        });

        $("#txt_com_numdoc").change(function() {

            if($('#txt_com_pro_doc').val()>0 && $('#txt_com_numdoc').val()!="")
            {
                verificar_duplicidad_compra($('#cmb_com_doc').val(),$('#txt_com_numdoc').val(),$('#txt_com_pro_doc').val());

            }

        });

        <?php
        }
        if($_POST['action']=="editar"){
        ?>
        proveedor_cargar_datos(<?php echo $pro_id?>);
        compra_detalle_tabla();
        $('#cmb_com_alm_id').attr('disabled', 'disabled');
        $('#txt_com_pro_nom,#txt_com_pro_doc,#txt_com_pro_dir,#cmb_com_mon,#txt_com_tipcam').attr('disabled', 'disabled');
        //$("#cmb_com_alm_id").addClass("ui-state-disabled");
        $('#chk_com_tipper').attr('disabled', 'disabled');
        <?php }?>

        $( "#txt_com_pro_nom").autocomplete({
            minLength: 1,
            source: "../proveedor/proveedor_complete_nom.php",
            select: function(event, ui){
                $("#hdd_com_pro_id").val(ui.item.id);
                $("#txt_com_pro_doc").val(ui.item.documento);
                $("#txt_com_pro_dir").val(ui.item.direccion);
                if($('#txt_com_pro_doc').val()>0 && $('#txt_com_numdoc').val()!="")
                {
                    verificar_duplicidad_compra($('#cmb_com_doc').val(),$('#txt_com_numdoc').val(),$('#txt_com_pro_doc').val());
                }
            }

        });

        $( "#txt_com_pro_doc" ).autocomplete({
            minLength: 1,
            source: "../proveedor/proveedor_complete_doc.php",
            select: function(event, ui){
                $("#hdd_com_pro_id").val(ui.item.id);
                $("#txt_com_pro_nom").val(ui.item.nombre);
                $("#txt_com_pro_dir").val(ui.item.direccion);
                if($('#txt_com_pro_doc').val()>0 && $('#txt_com_numdoc').val()!="")
                {
                    verificar_duplicidad_compra($('#cmb_com_doc').val(),$('#txt_com_numdoc').val(),$('#txt_com_pro_doc').val());
                }
            }

        });

        $( "#div_proveedor_form" ).dialog({
            title:'Información Proveedor',
            autoOpen: false,
            resizable: false,
            height: 300,
            width: 530,
            //modal: true,
            buttons: {
                Guardar: function() {
                    $("#for_pro").submit();
                },
                Cancelar: function() {
                    $('#for_pro').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            }
        });

        $( "#div_lote_form" ).dialog({
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

        $( "#div_catalogo_compra" ).dialog({
            title:'Catálogo de Compra',
            autoOpen: false,
            resizable: true,
            height: 300,
            width: 950,
            modal: false,
            position: "bottom"/*,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}*/
        });

        //Formulario para actualizar Item de Detalle de Compra
        $( "#div_item_form" ).dialog({
            title:'Información de Item',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 220,
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

        //Duplicidad de compra
        $( "#div_duplicidad" ).dialog({
            title:'Consulta de registro de compras por N° de Documento.',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 850,
            modal: true,
            open: function(event, ui) { $(this).parent().find(".ui-dialog-titlebar-close").remove(); },
            buttons: {
                OK: function() {
                    $( this ).dialog( "close" );
                    $('#txt_com_numdoc').val('');
                    $('#hdd_com_pro_id').val('');
                    $('#txt_com_pro_doc').val('');
                    $('#txt_com_pro_nom').val('');
                    $('#txt_com_pro_dir').val('');
                    $('#txt_com_numdoc').focus();
                }
            }
        });

        $( "#div_tabla_lote_car" ).dialog({
            title:'Información de Lotes',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 650,
            modal: true,
            buttons: {
                Cerrar: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                $("#div_tabla_lote_car").html('Cargando...');
            }
        });

        $(function() {
            $( "#dialog" ).dialog({
                open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
            });

        });



//formulario
        $("#for_com").validate({
            submitHandler: function() {
                $.ajax({
                    type: "POST",
                    url: "../compra/compra_reg.php",
                    async:true,
                    dataType: "json",
                    data: $("#for_com").serialize(),
                    beforeSend: function(){
                        $('#div_compra_form').dialog("close");
                        $('#msj_compra').html("Guardando...");
                        $('#msj_compra').show(100);
                    },
                    success: function(data){
                        if(data.redireccionar){
                            alert("Compra No Registrada.\n Por Favor Inicie Sesión Nuevamente.");
                            window.location.href = "../usuarios/cerrar_sesion.php";
                            return;
                        }

                        $('#msj_compra').html(data.com_msj);

                        <?php if($_POST['action']=='insertar'){?>
                        if (data.com_id){
                            compra_precio_form('insertar',data.com_id);
                        }
                        <?php }?>
                    },
                    complete: function(){
                        compra_tabla();
                    }
                });
            },
            rules: {
                txt_com_fec: {
                    required: true,
                    dateITA: true
                },
                txt_com_fecven: {
                    required: true,
                    dateITA: true
                },
                cmb_com_doc: {
                    required: true
                },
                txt_com_numdoc: {
                    required: true
                },
                hdd_com_pro_id: {
                    required: true
                },
                cmb_com_mon: {
                    required: true
                },
                txt_com_tipcam: {
                    required: true
                },
                cmb_com_alm_id: {
                    required: true
                },
                hdd_com_numite: {
                    required: true
                },
                cmb_com_est: {
                    required: true
                }
            },
            messages: {
                txt_com_fec: {
                    required: '*'
                },
                txt_com_fecven: {
                    required: '*'
                },
                cmb_com_doc: {
                    required: '*'
                },
                txt_com_numdoc: {
                    required: '*'
                },
                hdd_com_pro_id: {
                    required: 'Seleccione Proveedor.'
                },
                cmb_com_mon: {
                    required: '*'
                },
                txt_com_tipcam: {
                    required: '*'
                },
                cmb_com_alm_id: {
                    required: '*'
                },
                hdd_com_numite: {
                    required: 'Agregue producto a detalle de compra.'
                },
                cmb_com_est: {
                    required: '*'
                }
            }
        });

        $(document).shortkeys({
            //'a+p':       function () { catalogo_compra() },
            'Ctrl+Alt+a':  function () { $("#txt_fil_pro_nom").val(''); $("#txt_fil_pro_nom").focus(); },
            'Ctrl+Alt+n':  function () { $("#txt_fil_pro_nom").focus(); },
            'Ctrl+Alt+v': function () { $('input[name*="txt_cat_precom_"]:first').focus(); }
        });

    });

</script>
<style>
    .ui-cmb_pro_id {
        position: relative;
        display: inline-block;
    }
    .ui-cmb_pro_id-input {
        margin: 0;
        padding: 0.3em;
    }
</style>
<form id="for_com">
    <input name="action_compra" id="action_compra" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_com_id" id="hdd_com_id" type="hidden" value="<?php echo $_POST['com_id']?>">
    <input name="hdd_com_est" id="hdd_com_est" type="hidden" value="<?php echo $est?>">
    <input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
    <input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_SESSION['puntoventa_id']?>">
    <input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $_SESSION['empresa_id']?>">
    <input name="unico_id" id="unico_id" type="hidden" value="<?php echo $unico_id?>">

    <fieldset>
        <legend>Datos Principales</legend>
        <label for="txt_com_fec">Fecha:</label>
        <input name="txt_com_fec" placeholder="dd-mm-aaaa" class="fecha" id="txt_com_fec"  pattern="\d{1,2}/\d{1,2}/\d{4}" value="<?php echo $fec?>" size="10" maxlength="10">
        <label for="txt_fecven_dias">Dias:</label>
        <input name="txt_fecven_dias" type="text" class="dias" id="txt_fecven_dias" value="<?php echo $dias?>" size="2" maxlength="5">
        <label for="txt_com_fecven" title="Fecha de Vencimiento">Fecha Vcto:</label>
        <input name="txt_com_fecven" placeholder="dd-mm-aaaa"  type="text" class="fecha" id="txt_com_fecven"  pattern="\d{1,2}/\d{1,2}/\d{4}" value="<?php echo $fecven?>" size="10" maxlength="10">

        <label for="cmb_com_doc">Documento:</label>
        <select name="cmb_com_doc" id="cmb_com_doc" style="width: 140px">
        </select>
        <label for="txt_com_numdoc">N° Doc:</label>
        <input style="width:80px" type="text" name="txt_com_numdoc" id="txt_com_numdoc"  value="<?php echo $numdoc?>">
        <label for="txt_com_numorden">N° Orden:</label>
        <input style="width:80px" type="text" name="txt_com_numorden" id="txt_com_numorden"  value="<?php echo $numorden?>">
        <?php /*?>
    <label for="chk_com_tipper">Percepción(2%)</label><input name="chk_com_tipper" type="checkbox" id="chk_com_tipper" value="1" <?php if($tipper==1)echo 'checked'?>><?php */?>
        <?php
        $url=ir_principal($_SESSION['usuariogrupo_id']);
        ?>
        <a class="btn_newwin" target="_blank" title="Saltar a otra pestaña" href="<?php echo $url?>">Saltar</a>
        <br />
        <label for="cmb_com_mon">Moneda:</label>
        <select name="cmb_com_mon" id="cmb_com_mon">
            <option value="1" <?php if($mon==1)echo 'selected'?>>NUEVO SOL | S/.</option>
            <option value="2" <?php if($mon==2)echo 'selected'?>>DOLAR AME | US$</option>
        </select>
        <?php if($_POST['action']=='insertar'){?>
            <a class="btn_newwin" target="_blank" title="Tipo de Cambio" href="../tipocambio">Tipo de Cambio</a>
        <?php }?>
        <label for="txt_com_tipcam">Cambio:</label>
        <input name="txt_com_tipcam" type="text" value="<?php echo $tipcam?>" id="txt_com_tipcam" size="5" maxlength="5" style="text-align:right" readonly>
        <label for="cmb_com_alm_id">Colocar producto en:</label>
        <select name="cmb_com_alm_id" id="cmb_com_alm_id">
        </select>

        <label for="cmb_com_est">Estado:</label>
        <select name="cmb_com_est" id="cmb_com_est">
            <option value="">-</option>
            <option value="CREDITO" <?php if($est=='CREDITO')echo 'selected'?>>CREDITO</option>
            <option value="CONTADO" <?php if($est=='CONTADO')echo 'selected'?>>CONTADO</option>
        </select>
        <fieldset class="tipo_renta" style="display: none;">
            <legend>Tipo de Renta</legend>
            <select name="cmb_tiporenta_id" id="cmb_tiporenta_id">
            </select>
        </fieldset>
        <?php if($_POST['action']=='insertar'){?>
            <label for="cmb_com_tippre">Mostrar  con:</label>
            <select name="cmb_com_tippre" id="cmb_com_tippre">
                <option value="1" selected="selected">Valor Venta(sin IGV)</option>
                <option value="2">Precio Venta(con IGV)</option>
            </select>
            <div id="nota-debito-credito" style="display:none;width: 45%">
                <label for="cmb_com_tip">Tipo:</label>
                <select name="cmb_com_tip" id="cmb_com_tip">
                    <option value="0" selected="selected">-</option>
                    <option value="6">DEVOLUCIÓN TOTAL</option>
                    <option value="9">DISMINUICIÓN EN EL VALOR</option>
                </select>
                <label for="txt_com_ser_nota">Serie:</label>
                <input name="txt_com_ser_nota" type="text" id="txt_com_ser_nota" disabled
                       style="text-align:right; font-size:14px" value=""
                       maxlength="4" size="6">
                <label for="txt_com_num_nota">Número:</label>
                <input name="txt_com_num_nota" type="text" id="txt_com_num_nota" disabled
                       style="text-align:right; font-size:14px" value=""
                       maxlength="8" size="10">
            </div>
            <div id="tipobase" style="width: 45%">
                <label for="cmb_baseimp_tip">Tipo de base imponible - IGV:</label>
                <select name="cmb_baseimp_tip" id="cmb_baseimp_tip">
                    <option value="1" selected="selected" title="Base imponible de las adquisiciones gravadas que dan derecho a crédito fiscal y/o saldo a favor por exportación, destinadas exclusivamente a operaciones gravadas y/o de exportación
                    ">BI1 - CRÉDITO FIZCAL
                    </option>
                    <option value="2" title="Base imponible de las adquisiciones gravadas que dan derecho a crédito fiscal y/o saldo a favor por exportación, destinadas a operaciones gravadas y/o de exportación y a operaciones no gravadas
                    ">BI2 - PRÓRRATA
                    </option>
                    <option value="3" title="Base imponible de las adquisiciones gravadas que no dan derecho a crédito fiscal y/o saldo a favor por exportación, por no estar destinadas a operaciones gravadas y/o de exportación.
                    ">BI3 - COSTO/GASTO
                    </option>
                </select>
            </div>
        <?php }?>
        <?php //if($_POST['action']=='editar') echo 'COMPRA: '.$est?>
        <?php if($_POST['action']=='editar'){?>
            <a id="btn_compra_precio_form" href="#precio" onClick="compra_precio_form('insertar','<?php echo $_POST['com_id']?>')">Actualizar Precios</a>
        <?php }?>

        </table>
    </fieldset>
    <input type="hidden" id="hdd_com_pro_id" name="hdd_com_pro_id" value="<?php echo $pro_id?>" />
    <fieldset>
        <legend>Datos Proveedor</legend>
        <div id="div_proveedor_form">
        </div>
        <?php if($_POST['action']=='insertar'){?>
            <a id="btn_pro_form_agregar" href="#" onClick="proveedor_form_i('insertar')">Agregar Proveedor</a>
            <a id="btn_pro_form_modificar" href="#" onClick='proveedor_form_i("editar",$("#hdd_com_pro_id").val())'>Modificar Proveedor</a>
        <?php }?>
        <label for="txt_com_pro_doc">RUC/DNI:</label>
        <input type="text" id="txt_com_pro_doc" name="txt_com_pro_doc" size="11" value="<?php echo $pro_doc?>" />
        <label for="txt_com_pro">Proveedor:</label>
        <input type="text" id="txt_com_pro_nom" name="txt_com_pro_nom" size="39" value="<?php echo $pro_nom?>" />
        <label for="txt_com_pro_dir">Dirección:</label>
        <input type="text" id="txt_com_pro_dir" name="txt_com_pro_dir" size="39" value="<?php echo $pro_dir?>" disabled="disabled"/>
    </fieldset>
    <?php
    if($_POST['action']=="insertar"){
        ?>
        <div id="div_compra_car_tabla">
        </div>
        <div id="div_item_form">
        </div>
    <?php }?>

    <?php
    if($_POST['action']=="insertar"){
        ?>
        <div id="div_catalogo_compra">
        </div>
        <div id="div_duplicidad">
        </div>
        <?php
    }
    if($_POST['action']=="editar"){
        ?>
        <div id="div_compra_detalle_tabla">
        </div>
    <?php }?>

    <div id="div_tabla_lote_car">

    </div>

    <div id="div_lote_form">
    </div>

    <fieldset id="doc_compra_serv" style="display: none;">
        <legend>Documentos</legend>
        <div>
            <div id="msj_producto_proveedor" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none">
            </div>

            <div id="div_producto_proveedor" class="">

                <style>
                    div#tabla_pre_unidad {
                        margin: 0 0;
                    }

                    div#tabla_pre_unidad table {
                        margin: 0 0;
                        border-collapse: collapse;
                        width: 100%;
                    }

                    div#tabla_pre_unidad table td, div#tabla_pre_unidad table th {
                        border: 1px solid #eee;
                        padding: 2px 3px;
                        font-size: 10px;
                    }

                    div#tabla_pre_unidad table th {
                        height: 16px
                    }
                </style>
                <table cellspacing="0">

                    <tbody>

                    <tr>
                        <td valign="top">
                            <div id="tabla_pre_unidad" class="ui-widget">
                                <table id="tabla_prov_pro" class="ui-widget ui-widget-content">
                                    <thead>
                                    <tr class="ui-widget-header">
                                        <th title="Fecha">Fecha</th>
                                        <th title="Detalle de Dua">Detalle</th>
                                        <th align="right" nowrap="" title="Proveedor">Proveedor</th>
                                        <th align="right" nowrap="" title="Producto">Producto</th>
                                        <th align="right" nowrap="" title="Importe Dolares">Importe Dolares</th>
                                        <th align="right" nowrap="" title="Importe Soles">Importe Soles</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($_POST['action']=="editar"){
                                        $dts= $oCompra->mostrar_compra_relacionadas($_POST['com_id']);
                                        while($dt = mysql_fetch_array($dts)){
                                            $dt2s= $oCompra->mostrarUno($dt['tb_compra_relacionada']);
                                            $dt2 = mysql_fetch_array($dt2s);
                                            $provs= $oProveedor->mostrarUno($dt2['tb_proveedor_id']);
                                            $prov = mysql_fetch_array($provs);
                                            $comp_dets= $oCompra->mostrar_compra_detalle_servicio($dt['tb_compra_relacionada']);
                                            $comp_det = mysql_fetch_array($comp_dets);
                                            ?>

                                            <tr>
                                                <td title="Fecha"><input type="text" class="txt_com_fec fecha" name="fec_ser[]" size="10" maxlength="10" value="<?php echo $dt2['tb_compra_fec']?>" readonly></td>
                                                <td title="Detalle de Dua"><input type="text" value="<?php echo $dt2['tb_compra_numdoc']?>" name="dua[]"></td>
                                                <td align="right" nowrap="" title="Proveedor"><?php echo $prov['tb_proveedor_nom']?></td>
                                                <td align="right" nowrap="" title="Servicio"><?php echo $comp_det['tb_servicio_nom']?></td>
                                                <td align="right" nowrap="" title="Importe Dolares"> <input type="text" class="moneda_" name="imp_dol[]" value="<?php echo $dt2['tb_compra_tot']?>"> </td>
                                                <td align="right" nowrap="" title="Importe Soles"><input type="text" class="moneda_" name="imp_sol[]" value="<?php echo $dt2['tb_compra_tot']* $dt2['tb_compra_tipcam']?>"></td>
                                            </tr>
                                        <?php }?>
                                    <?php }else{?>
                                        <tr>
                                            <td title="Fecha"><input type="text" name="fec_ser[]" class="txt_com_fec fecha" size="10" maxlength="10" value="<?php echo $fec?>" readonly></td>
                                            <td title="Detalle de Dua"><input type="text" name="dua[]" readonly></td>
                                            <input type="hidden" name="proveedor[]" value="1">
                                            <td></td>
                                            <input type="hidden" name="servicio[]" value="1">
                                            <td align="right" nowrap="" title="Servicio">SEGURO</td>

                                            <td align="right" nowrap="" title="Importe Dolares"><input type="text"
                                                                                                       class="moneda_"
                                                                                                       name="imp_dol[]"
                                                                                                       placeholder="0.00"></td>
                                            <td align="right" nowrap="" title="Importe Soles"><input type="text"
                                                                                                     class="moneda_"
                                                                                                     name="imp_sol[]"
                                                                                                     placeholder="0.00"></td>
                                            <td align="right"><input name="chk_invoice[]" type="checkbox" id="chk_invoice" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td title="Fecha"><input type="text"  name="fec_ser[]" class="txt_com_fec fecha" size="10" maxlength="10" value="<?php echo $fec?>" readonly></td>
                                            <td title="Detalle de Dua"><input type="text" placeholder="F066-35053"
                                                                               name="dua[]"></td>
                                            <input type="hidden" name="proveedor[]" value="10" >
                                            <td align="right">ADVALOREM ADUANAS</td>
                                            <input type="hidden" name="servicio[]" value="10">
                                            <td align="right" nowrap="" title="Servicio">ADVALOREM</td>
                                            <td align="right" nowrap="" title="Importe Dolares"><input id="imp_dol1"
                                                                                                        type="text"
                                                                                                       class="moneda_"
                                                                                                       name="imp_dol[]"
                                                                                                       placeholder="5.89">
                                            </td>
                                            <td align="right" nowrap="" title="Importe Soles"><input type="text"
                                                                                                     class="moneda_"
                                                                                                     name="imp_sol[]"
                                                                                                     placeholder="19.00"></td>
                                            <td align="right">
                                                <input name="chk_invoice[]" type="checkbox" id="chk_invoice1" value="1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td title="Fecha"><input type="text" class="txt_com_fec fecha" name="fec_ser[]" size="10" maxlength="10" value="<?php echo $fec?>" readonly></td>
                                            <td title="Detalle de Dua"><input type="text" placeholder="F066-35053" name="dua[]"></td>
                                            <input type="hidden" name="proveedor[]" value="11">
                                            <td align="right" nowrap="" title="Proveedor">TALMA SERVICIOS AEROPORTUARIOS</td>
                                            <input type="hidden" name="servicio[]" value="11">
                                            <td align="right" nowrap="" title="Servicio">ALMACENAJE, ESTIBA</td>
                                            <td align="right" nowrap="" title="Importe Dolares"> <input id="imp_dol2" type="text" class="moneda_" name="imp_dol[]" placeholder="150.60"> </td>
                                            <td align="right" nowrap="" title="Importe Soles"><input type="text" class="moneda_" name="imp_sol[]" placeholder="485.68"></td>
                                            <td align="right"><input name="chk_invoice[]" type="checkbox" id="chk_invoice2" value="2"></td>
                                        </tr>
                                        <tr>
                                            <td title="Fecha"><input type="text" class="txt_com_fec fecha" name="fec_ser[]" size="10" maxlength="10" value="<?php echo $fec?>" readonly></td>
                                            <td title="Detalle de Dua"><input type="text" placeholder="F003-7747" name="dua[]"></td>
                                            <input type="hidden" name="proveedor[]" value="12">
                                            <td align="right" nowrap="" title="Proveedor">SCHENKER PERU SRL</td>
                                            <input type="hidden" name="servicio[]" value="12">
                                            <td align="right" nowrap="" title="Servicio">TRAMITE DOCUMENTARIO</td>
                                            <td align="right" nowrap="" title="Importe Dolares"><input type="text" id="imp_dol3" class="moneda_" name="imp_dol[]" placeholder="110.00"> </td>
                                            <td align="right" nowrap="" title="Importe Soles"><input type="text" class="moneda_" name="imp_sol[]" placeholder="354.75"></td>
                                            <td align="right"><input name="chk_invoice[]" type="checkbox" id="chk_invoice3" value="3"></td>
                                        </tr>
                                        <tr>
                                            <td title="Fecha"><input type="text" class="txt_com_fec fecha" name="fec_ser[]" size="10" maxlength="10" value="<?php echo $fec?>" readonly></td>
                                            <td title="Detalle de Dua"><input type="text" placeholder="F001-10637" name="dua[]"></td>
                                            <input type="hidden" name="proveedor[]" value="13">
                                            <td align="right" nowrap="" title="Proveedor">MILLENNIUM AGENES DE ADUANA SAC</td>
                                            <input type="hidden" name="servicio[]" value="13">
                                            <td align="right" nowrap="" title="Servicio">GASTOS OPERATIVOS</td>
                                            <td align="right" nowrap="" title="Importe Dolares"><input type="text" class="moneda_" id="imp_dol4" name="imp_dol[]" placeholder="247.93"> </td>
                                            <td align="right" nowrap="" title="Importe Soles"><input type="text" class="moneda_" name="imp_sol[]" placeholder="806.02"></td>
                                            <td align="right"><input name="chk_invoice[]" type="checkbox" id="chk_invoice4" value="4"></td>
                                        </tr>
                                        <tr>
                                            <td title="Fecha"><input type="text" class="txt_com_fec fecha" name="fec_ser[]" size="10" maxlength="10" value="<?php echo $fec?>" readonly></td>
                                            <td title="Detalle de Dua"><input type="text" placeholder="0001-13376" name="dua[]"></td>
                                            <input type="hidden" name="proveedor[]" value="14">
                                            <td align="right" nowrap="" title="Proveedor">PACIFICO DEL SUR SAC</td>
                                            <input type="hidden" name="servicio[]" value="14">
                                            <td align="right" nowrap="" title="Servicio">TRANSPORTE LM-AQP</td>
                                            <td align="right" nowrap="" title="Importe Dolares"><input type="text" class="moneda_" name="imp_dol[]" id="imp_dol5" placeholder="15.80"> </td>
                                            <td align="right" nowrap="" title="Importe Soles"><input type="text" class="moneda_" name="imp_sol[]" placeholder="50.85"></td>
                                            <td align="right"><input name="chk_invoice[]" type="checkbox" id="chk_invoice5" value="5"></td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
    </fieldset>

        </form>
                             </div>
                        </td>
                        <td valign="top">

                        </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        </tbody>
             </table>
        </div>
    </div>

