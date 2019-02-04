<?php
require_once ("../../config/Cado.php");
require_once ("../lugar/cLugar.php");

session_start();
$fec=date('d-m-Y');
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);
?>

<script type="text/javascript">


    <?php echo $pv['tb_lugar_id']?>

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
                $('#cmb_salida').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_salida').html(html);
                $('#cmb_salida').find('option').not(':selected').remove();
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
                $('#cmb_llegada').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_llegada').html(html);
                $("#cmb_llegada").find("option[value='<?php echo $pv['tb_lugar_id']?>']").remove();
            },
            complete: function(){

            }
        });
    }

    function cmb_vehiculo()
    {
        $.ajax({
            type: "POST",
            url: "../vehiculo/cmb_veh_id.php",
            async:false,
            dataType: "html",
            beforeSend: function() {
                $('#cmb_vehiculo').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_vehiculo').html(html);

            },
            complete: function(){

            }
        });
    }


$(function() {
    $( "#txt_fech_salida" ).datepicker({
        minDate: new Date(),
        maxDate:"+5D",
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

    $('#txt_hora').timepicker({
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

	$("#for_hor").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../venta/venta_horario_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_hor").serialize(),
				beforeSend: function() {
					$("#div_venta_horario_form" ).dialog( "close" );
					$('#msj_horario').html("Guardando...");
					$('#msj_horario').show(100);
				},
				success: function(data){

				    $('#cmb_salida_id').val(data.vh_sal);
                    $('#cmb_llegada_id').val(data.vh_lleg);
                    cmb_fecha();
                    $('#cmb_fech_salida').val(data.vh_fecha);
                    cmb_fecha_horario();
                    $('#cmb_horario').val(data.vh_horario);
                    cmb_vehiculo();
                    filtro_bus();
                    // $('#cmb_horario').val(data.vh_horario);
					$('#msj_horario').html(data.ven_ho_msj);
                    $("#div_venta_horario_form" ).dialog( "close" );
                    $('#msj_horario').delay(5000).hide(600);
				},
				complete: function(){

				}
			});
		},
		rules: {
            cmb_salida: {
				required: true
			},
            cmb_llegada: {
                required: true
            },
            txt_fech_salida: {
                required: true
            },
            txt_hora: {
                required: true
            },
            cmb_vehiculo: {
                required: true
            }
		},
		messages: {
            cmb_salida: {
				required: '*'
			},
            cmb_llegada: {
                required: '*'
            },
            txt_fech_salida: {
                required: '*'
            },
            txt_hora: {
                required: '*'
            },
            cmb_vehiculo: {
                required: '*'
            }
		}
	});
    cmb_lugar_origen();
    cmb_lugar_destino();
    cmb_vehiculo();
});
</script>
<form id="for_hor">
    <input name="action" id="action" type="hidden" value="insertar">
    <table>
        <tr>
            <td valign="top">
                <label for="cmb_salida">Salida</label><br>
                <select name="cmb_salida" id="cmb_salida">
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top"><label for="cmb_llegada">Llegada:</label><br>
                <select name="cmb_llegada" id="cmb_llegada">
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="txt_fech_salida">Fecha Salida:</label><br>
                <input name="txt_fech_salida" type="text" class="fecha" id="txt_fech_salida" value="<?php echo $fec ?>" size="10" maxlength="10">
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="txt_hora">Hora</label><br>
                <input name="txt_hora" type="text" id="txt_hora" value="<?php echo $horini1?>" size="10" maxlength="5" />
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="cmb_vehiculo">Vehiculo</label><br>
                <select name="cmb_vehiculo" id="cmb_vehiculo">
                </select>
            </td>
        </tr>
    </table>
</form>