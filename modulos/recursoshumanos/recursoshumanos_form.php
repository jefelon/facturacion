<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cRecursoshumanos.php");
$oRecursoshumanos = new cRecursoshumanos;

if($_POST['action']=="insertar") {
    $recdoc_fech = date('d-m-Y');
    $fecha_ingreso = date('d-m-Y');
    $fecha_salida = date('d-m-Y');
    $hora_ingreso = formato_hora('0:00');
    $hora_salida = formato_hora('0:00');
}

if($_POST['action']=="editar")
{
	$dts=$oRecursoshumanos->mostrarUno($_POST['recursoshumanos_id']);
	$dt = mysql_fetch_array($dts);
	$recdoc_empresa = $dt['tb_cliente_doc'];
    $recnom_empresa = $dt['tb_cliente_nom'];
    $recid_empresa = $dt['tb_cliente_id'];
    $fecha_ingreso = $dt['tb_fecha_ingreso'];
    $hora_ingreso = formato_hora($dt['tb_hora_ingreso']);
    $cargo = $dt['tb_cargo'];
    $fecha_salida = $dt['tb_fecha_salida'];
    $hora_salida = formato_hora($dt['tb_hora_salida']);
    $tardanza = $dt['tb_tardanza'];
    $falta = $dt['tb_falta'];
    $permisos = $dt['tb_permisos'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_recdoc_nom').focus();
	<?php }?>
	
	$('#txt_recdoc_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

    $( "#txt_recdoc_empresa" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_recdoc_empresa_id").val(ui.item.id);
            $("#txt_recnom_empresa").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_recdoc_empresa_id').change();
        }
    });


    $( "#txt_docpersdecl" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_persdecl_id").val(ui.item.id);
            $("#txt_nompersdecl").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_perspdecl_id').change();
        }
    });




    $("#for_recdoc").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../recursoshumanos/recursoshumanos_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_recdoc").serialize(),
				beforeSend: function() {
					$("#div_recursoshumanos_form" ).dialog( "close" );
					$('#msj_recursoshumanos').html("Guardando...");
					$('#msj_recursoshumanos').show(100);
				},
				success: function(data){						
					$('#msj_recursoshumanos').html(data.marper_msj);
					<?php
					if($_POST['vista']=="cmb_marper_id")
					{
						echo $_POST['vista'].'(data.marper_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="recursoshumanos_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
            txt_recnom_empresa: {
				required: true
			},
            txt_nomperspentrega: {
                required: true
            },
            txt_nomrecepdocumentos: {
                required: true
            },
            txt_nompersrecojo: {
                required: true
            }

		},
		messages: {
            txt_recnom_empresa: {
				required: '*'
			},
            txt_nomperspentrega: {
                required: '*'
            },
            txt_nomrecepdocumentos: {
                required: '*'
            },
            txt_nompersrecojo: {
                required: '*'
            }
		}
	});
    $( "#txt_fecha_ingreso,#txt_fecha_salida" ).datepicker({
        minDate: "-7D",
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

    $('#txt_hora_ingreso,#txt_hora_salida').timepicker({
        timeOnlyTitle: 'Seleccionar Hora',
        timeText: 'Hora',
        hourText: 'Hora',
        minuteText: 'Minuto',
        currentText: 'Hora Actual',
        closeText: 'Cerrar',
        timeFormat: 'hh:mm',
        stepHour: 1,
        stepMinute: 1,
        hourGrid: 4,
        minuteGrid: 10,
        showButtonPanel: false
    });
});
</script>
<form id="for_recdoc">
<input name="action_recursoshumanos" id="action_recursoshumanos" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_recursoshumanos_id" id="hdd_recursoshumanos_id" type="hidden" value="<?php echo $_POST['recursoshumanos_id'] ?>">
    <input name="hdd_recdoc_empresa_id" id="hdd_recdoc_empresa_id" type="hidden" value="<?php echo $recid_empresa ?>">
    <table>
        <tr>
            <td align="right" valign="top">Personal:</td>
            <td>
                <input name="txt_recdoc_empresa" type="text" id="txt_recdoc_empresa" value="<?php echo $recdoc_empresa?>" size="10" maxlength="11">
                <input name="txt_recnom_empresa" type="text" id="txt_recnom_empresa" value="<?php echo $recnom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Cargo:</td>
            <td><input name="txt_cargo" type="text" id="txt_cargo" value="<?php echo $cargo?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Ingreso:</td>
            <td><input name="txt_fecha_ingreso" type="text" id="txt_fecha_ingreso" value="<?php echo $fecha_ingreso?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Hora de Ingreso:</td>
            <td><input name="txt_hora_ingreso" type="text" id="txt_hora_ingreso" value="<?php echo $hora_ingreso?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Salida:</td>
            <td><input name="txt_fecha_salida" type="text" id="txt_fecha_salida" value="<?php echo $fecha_salida?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Hora de Salida:</td>
            <td><input name="txt_hora_salida" type="text" id="txt_hora_salida" value="<?php echo $hora_salida?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Tardanza:</td>
            <td><input name="txt_tardanza" type="text" id="txt_tardanza" value="<?php echo $tardanza?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Falta:</td>
            <td><input name="txt_falta" type="text" id="txt_falta" value="<?php echo $falta?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Permisos:</td>
            <td><input name="txt_permisos" type="text" id="txt_permisos" value="<?php echo $permisos?>" size="41" maxlength="10"></td>
        </tr>
    </table>
</form>