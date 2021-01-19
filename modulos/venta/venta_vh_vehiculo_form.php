<?php
require_once ("../../config/Cado.php");
require_once ("../lugar/cLugar.php");

session_start();
$fec=date('d-m-Y');
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once("../venta/cVenta.php");
$oVenta = new cVenta();

$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);

$vhs = $oVenta->mostrar_viajehorario($_POST['vh_id']);
$vh = mysql_fetch_array($vhs);

?>

<script type="text/javascript">
    function cmb_conductor()
    {
        $.ajax({
            type: "POST",
            url: "../conductor/cmb_con_id.php",
            async:false,
            dataType: "html",
            data: ({
                con_id: <?php echo $vh['tb_conductor_id']?>
            }),
            beforeSend: function() {
                $('#cmb_conductor').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_conductor').html(html);
            },
            complete: function(){

            }
        });
    }
    function cmb_copiloto()
    {
        $.ajax({
            type: "POST",
            url: "../conductor/cmb_con_id.php",
            async:false,
            dataType: "html",
            data: ({
                con_id: <?php echo $vh['tb_copiloto_id']?>
            }),
            beforeSend: function() {
                $('#cmb_copiloto').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_copiloto').html(html);
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
            data: ({
                veh_id: <?php echo $_POST['veh_id']?>
            }),
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
                data: ({
                    action: 'actualizar-vehiculo',
                    hdd_vi_ho: $('#hdd_vi_ho').val(),
                    cmb_vehiculo: $('#cmb_vehiculo').val(),
                    cmb_conductor: $('#cmb_conductor').val(),
                    cmb_copiloto: $('#cmb_copiloto').val(),
                    txt_fech_salida:$('#txt_fech_salida').val(),
                    txt_hora:$('#txt_hora').val(),

                }),
				beforeSend: function() {
					$("#div_venta_horario_form" ).dialog( "close" );
					$('#msj_horario').html("Guardando...");
					$('#msj_horario').show(100);
				},
				success: function(data){
                    cmb_horario_vehiculo();
                    // $('#cmb_horario').val(data.vh_horario);
					$('#msj_horario').html(data.ven_ho_msj);
                    cmb_fecha();
                    cmb_fecha_horario();
                    $("#div_venta_horario_form" ).dialog( "close" );
                    $('#msj_horario').delay(5000).hide(600);
				},
				complete: function(){

				}
			});
		},
		rules: {
            cmb_vehiculo: {
                required: true
            },
            cmb_conductor: {
                required: true
            },
            cmb_copiloto: {
                required: true
            }
		},
		messages: {
            cmb_vehiculo: {
                required: '*'
            },
            cmb_conductor: {
                required: '*'
            },
            cmb_copiloto: {
                required: '*'
            }
		}
	});
    cmb_vehiculo();
    cmb_conductor();
    cmb_copiloto();

});
</script>
<form id="for_hor">
    <table>
        <tr>
            <td valign="top">
                <label for="txt_fech_salida">Fecha Salida:</label><br>
                <input name="txt_fech_salida" type="text" class="fecha" id="txt_fech_salida" value="<?php echo $fec ?>" size="10" maxlength="10">
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="txt_hora">Hora</label><br>
                <input name="txt_hora" type="text" id="txt_hora" value="<?php echo substr($vh['tb_viajehorario_horario'],0,5)?>" size="10" maxlength="5" />
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="cmb_vehiculo">Vehiculo</label><br>
                <select name="cmb_vehiculo" id="cmb_vehiculo">
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="cmb_conductor">Conductor</label><br>
                <select name="cmb_conductor" id="cmb_conductor">
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="cmb_copiloto">Copiloto</label><br>
                <select name="cmb_copiloto" id="cmb_copiloto">
                </select>
            </td>
        </tr>
    </table>
</form>