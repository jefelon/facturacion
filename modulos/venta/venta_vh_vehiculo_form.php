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
                    cmb_vehiculo: $('#cmb_vehiculo').val()
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
            }
		},
		messages: {
            cmb_vehiculo: {
                required: '*'
            }
		}
	});
    cmb_vehiculo();
});
</script>
<form id="for_hor">
    <table>
        <tr>
            <td valign="top">
                <label for="cmb_vehiculo">Vehiculo</label><br>
                <select name="cmb_vehiculo" id="cmb_vehiculo">
                </select>
            </td>
        </tr>
    </table>
</form>