<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../usuarios/cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();
require_once ("../formatos/formatos.php");

if($_POST['action']=="insertar")
{
    $emp_id=$_SESSION['empresa_id'];
    $usugru_id=2;
    $usu_id=$_POST['id'];
}

if($_POST['action']=="editar")
{
    $usu_id=$_POST['id'];
    $dts=$oUsuario->mostrarUno($_POST['id']);
    $dt = mysql_fetch_array($dts);
    $usugru_id	=$dt['tb_usuariogrupo_id'];
    $usugru_nom	=$dt['tb_usuariogrupo_nom'];
    $nom		=$dt['tb_usuario_nom'];
    $apepat		=$dt['tb_usuario_apepat'];
    $apemat		=$dt['tb_usuario_apemat'];
    $use		=$dt['tb_usuario_use'];
    $ema		=$dt['tb_usuario_ema'];

    $emp_id		=$dt['tb_empresa_id'];

    mysql_free_result($dts);

    $dts=$oUsuariodetalle->mostrarUno($_POST['id']);
    $dt = mysql_fetch_array($dts);

    $dni		=$dt['tb_usuario_dni'];
    $punven_id	=$dt['tb_puntoventa_id'];
    $hor_id		=$dt['tb_horario_id'];

    mysql_free_result($dts);
}

?>

<script type="text/javascript">
    //botones y vista

    $('.btn_ir').button({
        icons: {primary: "ui-icon-newwin"},
        text: false
    });
    $(".btn_ir").css({width: "14px", height: "15px" });

    $('#btn_agregar_telefono').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });
    $('#btn_agregar_direccion').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });

    $('#btn_agregar_puntoventa').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });

    function tabsUsuario()
    {
        switch ($('#action_usuario').val())
        {
            case 'insertar':
                $("#tabs").tabs({disabled:[1,2]});
                break
            case 'editar':
                $("#tabs").tabs({disabled:[]});
                $("#txt_use").attr('readonly',true);
                $("#txt_pas").attr('readonly',true);
                break
            //default:
            //Sentencias a ejecutar si el valor no es ninguno de los anteriores
        }
    }


    //cargar

    function cargar_cmb_usugru()
    {
        $.ajax({
            type: "POST",
            url: "../usuarios/cmb_usugru.php",
            async:true,
            dataType: "html",
            data: ({
                usugru: "<?php echo '2'?>"
            }),
            success: function(html){
                $('#cmb_usugru').html(html);
            },
        });
        $('#cmb_usugru').attr('disabled', 'disabled');
    }

    function cmb_emp_id(idf)
    {
        $.ajax({
            type: "POST",
            url: "../empresa/cmb_emp_id.php",
            async:true,
            dataType: "html",
            data: ({
                emp_id: idf
            }),
            beforeSend: function() {
                $('#cmb_emp_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_emp_id').html(html);
            },
        });
    }

    function cmb_punven_id(empid,idf)
    {
        $.ajax({
            type: "POST",
            url: "../puntoventa/cmb_punven_id.php",
            async:true,
            dataType: "html",
            data: ({
                emp_id: empid,
                punven_id: idf
            }),
            beforeSend: function() {
                $('#cmb_punven_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_punven_id').html(html);
            }
        });
    }



    function usuario_puntoventa_form(act,idf)
    {
        $.ajax({
            type: "POST",
            url: "../usuarios/usuario_puntoventa_form.php",
            async:true,
            dataType: "html",
            data: ({
                action		: act,
                usu_id		: $('#hdd_usu_id').val(),
                punven_id	: idf
            }),
            beforeSend: function() {
                $('#div_usuario_puntoventa_form').dialog( "open" );
                $('#div_usuario_puntoventa_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_usuario_puntoventa_form').html(html);
            }
        });
    }
    function eliminar_usuario_puntoventa(id)
    {
        if(confirm("Realmente desea eliminar?")){
            $.ajax({
                type: "POST",
                url: "../usuarios/usuario_puntoventa_reg.php",
                async:true,
                dataType: "html",
                data: ({
                    action: "eliminar",
                    id:		id
                }),
                beforeSend: function() {
                    $('#msj_usuario_form').html("Cargando...");
                    $('#msj_usuario_form').show(100);
                },
                success: function(html){
                    $('#msj_usuario_form').html(html);
                },
                complete: function(){
                    usuario_puntoventa_tabla();
                }
            });
        }
    }
    function usuario_puntoventa_tabla()
    {
        $.ajax({
            type: "POST",
            url: "../usuarios/usuario_puntoventa_tabla.php",
            async:true,
            dataType: "html",
            data: ({
                usu_id: "<?php echo $usu_id?>"
            }),
            beforeSend: function() {
                $('#div_usuario_puntoventa_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_usuario_puntoventa_tabla').html(html);
            },
            complete: function(){
                $('#div_usuario_puntoventa_tabla').removeClass("ui-state-disabled");
            }
        });
    }


    //function
    $(function() {

        tabsUsuario();

        cargar_cmb_usugru();

        cmb_emp_id('<?php echo $emp_id?>');

        cmb_punven_id('<?php echo $emp_id?>','<?php echo $punven_id?>');

        usuario_puntoventa_tabla();

        $('#cmb_emp_id').change(function() {
            var empresa_id = $('#cmb_emp_id').val();
            cmb_punven_id(empresa_id,'<?php echo $punven_id?>');
        });

//dialogos

        $( "#div_usuario_direccion_form" ).dialog({
            title:'Form Dirección',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 400,
            modal: true,
            buttons: {
                Guardar: function() {
                    $("#for_dir").submit();
                },
                Cancelar: function() {
                    $('#for_dir').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            }
        });

        $( "#div_usuario_telefono_form" ).dialog({
            title:'Form Teléfono',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 'auto',
            modal: true,
            buttons: {
                Guardar: function() {
                    $("#for_tel").submit();
                },
                Cancelar: function() {
                    $('#for_tel').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            }
        });

        $( "#div_usuario_puntoventa_form" ).dialog({
            title:'Información de Punto de Venta',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 'auto',
            modal: true,
            buttons: {
                Agregar: function() {
                    $("#for_punven_usu").submit();
                },
                Cancelar: function() {
                    $('#for_punven_usu').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            }
        });

// propuesta de user
        <?php if($_POST['action']=="insertar")
        { ?>
        $("#txt_ema").keyup(function() {
        });
        <?php }else{?>
        $("#txt_use").attr("value", $("#txt_ema").val());
        $("#txt_use").attr('readonly',true);
        $("#txt_pas").attr('readonly',true);
        <?php }?>



        //formulario
        $("#for_usu").validate({
            submitHandler: function() {
                $.ajax({
                    type: "POST",
                    url: "usuario_reg_adm.php",
                    async:true,
                    dataType: "html",
                    data: $("#for_usu").serialize(),
                    beforeSend: function() {
                        if($('#action_usuario').val()=='editar')
                        {
                            $("#div_usuario_form" ).dialog( "close" );
                        }
                        else
                        {
                            blok_usuario_form();
                        }
                        $('#msj_usuario').html("Guardando...");
                        $('#msj_usuario').show(100);
                    },
                    success: function(html){
                        var arrayDatos = html.split("-");

                        if($('#action_usuario').val()=='insertar')
                        {
                            editar_usuario(arrayDatos[0],1);
                        }
                        else
                        {
                            $("#div_usuario_form" ).dialog( "close" );
                        }

                        $('#msj_usuario').html(arrayDatos[1]);

                    },
                    complete: function(){
                        cargar_tabla_usuario();
                    }
                });
            },
            rules: {
                //cmb_usugru: "required",
                txt_use: {
                    //required: true,
                    //minlength: 3,
                    <?php if($_POST['action']=="insertar")echo 'remote: "../usuarios/users.php"'?>
                },
                txt_pas:{
                    //required: true,
                    minlength: 5
                },
                txt_apepat:{
                    required: true
                },
                txt_apemat:{
                    required: true
                },
                txt_nom:{
                    required: true
                },
                txt_dni:{
                    //required: true,
                    digits: true
                },
                txt_ema:{
                    required: true,
                    email: true
                },
                cmb_emp_id:{
                    required: true
                }
            },
            messages: {
                txt_use: {
                    //remote: jQuery.format("El nombre de usuario: '{0}', no está disponible.")
                    remote: "Este nombre de usuario, no está disponible."
                },
                txt_repass: {
                    //required: "Por favor, escriba nuevamente la contraseña.",
                    minlength: "Por favor, escriba la misma contraseña.",
                    equalTo: "Por favor, escriba la misma contraseña."
                },
                txt_apepat:{
                    required: '*'
                },
                txt_apemat:{
                    required: '*'
                },
                txt_nom:{
                    required: '*'
                },
                txt_dni:{
                    //required: true,
                    //digits: '*'
                },
                txt_ema:{
                    required: '*',
                    //email: true
                },
                cmb_emp_id:{
                    required: '*'
                }
            }
        });

    });

</script>

<div style="padding:2px">
    <strong><?php echo $apepat.' '.$apemat.' '.$nom?></strong>
</div>
<form id="for_usu">
    <input name="action_usuario" id="action_usuario" type="hidden" value="<?php echo $_POST['action'] ?>">
    <input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_POST['id'] ?>">
    <input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $emp_id ?>">
    <input name="hdd_usugru_id" id="hdd_usugru_id" type="hidden" value="<?php echo $usugru_id ?>">

    <fieldset>
        <legend>Acceso a Puntos de Venta</legend>
        <a id="btn_agregar_puntoventa" href="#" onClick="usuario_puntoventa_form('insertar')">Agregars Punto de Venta</a>
        <div id="div_usuario_puntoventa_tabla">
        </div>
        <div id="div_usuario_puntoventa_form">
        </div>
    </fieldset>
</form>