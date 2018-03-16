<?php
require_once ("../../config/Cado.php");
require_once("cHorario.php");
$oHorario = new cHorario();
require_once ("../formatos/formato.php");

if($_POST['action']=="editar"){
	$dts= $oHorario->mostrarUno($_POST['hor_id']);
	$dt = mysql_fetch_array($dts);
	
		$nom	=$dt['tb_horario_nom'];
		$fecini	=mostrarFecha($dt['tb_horario_fecini']);
		$fecfin	=mostrarFecha($dt['tb_horario_fecfin']);
		$est	=$dt['tb_horario_est'];
		
		$lun	=$dt['tb_horario_lun'];
		$mar	=$dt['tb_horario_mar'];
		$mie	=$dt['tb_horario_mie'];
		$jue	=$dt['tb_horario_jue'];
		$vie	=$dt['tb_horario_vie'];
		$sab	=$dt['tb_horario_sab'];
		$dom	=$dt['tb_horario_dom'];
		
		$horini1	=formato_hora($dt['tb_horario_horini1']);
		$horfin1	=formato_hora($dt['tb_horario_horfin1']);
		$horini2	=formato_hora($dt['tb_horario_horini2']);
		$horfin2	=formato_hora($dt['tb_horario_horfin2']);
	
	mysql_free_result($dts);
}
?>
<script type="text/javascript">
function verifica_dia()
{
	var dato='';
	if($('#chk_hor_lun').is(':checked')) {
		dato='1';
	}
	if($('#chk_hor_mar').is(':checked')) {
		dato='1';
	}
	if($('#chk_hor_mie').is(':checked')) {
		dato='1';
	}
	if($('#chk_hor_jue').is(':checked')) {
		dato='1';
	}
	if($('#chk_hor_vie').is(':checked')) {
		dato='1';
	}
	if($('#chk_hor_sab').is(':checked')) {
		dato='1';
	}
	if($('#chk_hor_dom').is(':checked')) {
		dato='1';
	}
	
	$('#hdd_bandia').val(dato);
}

//function	
$(function() {
	
	verifica_dia();
		
//calendario
	var dates = $( "#txt_hor_fecini, #txt_hor_fecfin" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_hor_fecini" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	$( "#format_checks" ).buttonset();	
	
	$('#banhor').val(1);
	var mm='Error en horas.';
	var dathorini2=false;
	
	$('#txt_hor_horfin1,#txt_hor_horini2,#txt_hor_horfin2').attr('disabled', 'disabled');
	$('#txt_hor_horfin1,#txt_hor_horini2,#txt_hor_horfin2').addClass("ui-state-disabled");	
	
	$('#txt_hor_horini1').timepicker({
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
		//hourMin: 7,
		//hourMax: 23,,
		,onClose: function(dateText, inst) {
			if($('#txt_hor_horini1').val()!='' & $('#txt_hor_horfin1').val()!='')
			{
				if($('#txt_hor_horini1').val()>=$('#txt_hor_horfin1').val())
				{
					$('#banhor').val(0);
					mm='TURNO 1: Hora Inicio debe ser MENOR que Hora Fin.';
					alert(mm);
				}
				else
				{
					$('#banhor').val(1);
				}
			}
			
			if($('#txt_hor_horini1').val()!='')
			{
				$('#txt_hor_horfin1').removeAttr('disabled');
				$('#txt_hor_horfin1').removeClass("ui-state-disabled");
			}
			else
			{
				$('#txt_hor_horfin1').attr('disabled', 'disabled');
				$('#txt_hor_horfin1').addClass("ui-state-disabled");
				$('#txt_hor_horfin1').val('');
				
				$('#txt_hor_horini2').attr('disabled', 'disabled');
				$('#txt_hor_horini2').addClass("ui-state-disabled");
				$('#txt_hor_horini2').val('');
				
				$('#txt_hor_horfin2').attr('disabled', 'disabled');
				$('#txt_hor_horfin2').addClass("ui-state-disabled");
				$('#txt_hor_horfin2').val('');
			}
		}
	});
	
	$('#txt_hor_horfin1').timepicker({
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
		showButtonPanel: false,
		onClose: function(dateText, inst) {
			if($('#txt_hor_horini1').val()!='' & $('#txt_hor_horfin1').val()!='')
			{
				if($('#txt_hor_horini1').val()>=$('#txt_hor_horfin1').val())
				{
					$('#banhor').val(0);
					mm='TURNO 1: Hora Fin debe ser MAYOR que Hora Inicio.';
					alert(mm);
					
					$('#txt_hor_horini2').attr('disabled', 'disabled');
					$('#txt_hor_horini2').addClass("ui-state-disabled");
					$('#txt_hor_horini2').val('');
					dathorini2=false;
				}
				else
				{
					$('#banhor').val(1);
					$('#txt_hor_horini2').removeAttr('disabled');
					$('#txt_hor_horini2').removeClass("ui-state-disabled");
				}
			}
			
			if($('#txt_hor_horfin1').val()!='' & $('#txt_hor_horini2').val()!='')
			{
				if($('#txt_hor_horfin1').val()>=$('#txt_hor_horini2').val())
				{
					$('#banhor').val(0);
					mm='Hora Fin de TURNO 1 debe ser MENOR que Hora Inicio de TURNO 2.';
					alert(mm);
				}
				else
				{
					$('#banhor').val(1);
				}
			}
			
			if($('#txt_hor_horfin1').val()=='')
			{
				$('#txt_hor_horini2').attr('disabled', 'disabled');
				$('#txt_hor_horini2').addClass("ui-state-disabled");
				$('#txt_hor_horini2').val('');
				
				$('#txt_hor_horfin2').attr('disabled', 'disabled');
				$('#txt_hor_horfin2').addClass("ui-state-disabled");
				$('#txt_hor_horfin2').val('');
			}
		}
	}); 

	$('#txt_hor_horini2').timepicker({
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
		//hourMin: 7,
		//hourMax: 23,,
		,onClose: function(dateText, inst) {
			
			if($('#txt_hor_horfin1').val()!='' & $('#txt_hor_horini2').val()!='')
			{
				if($('#txt_hor_horfin1').val()>=$('#txt_hor_horini2').val())
				{
					$('#txt_hor_horfin2').val('');
					$('#banhor').val(0);
					mm='Hora Inicio de TURNO 2 debe ser MAYOR que Hora Fin de TURNO 1.';
					alert(mm);
				}
				else
				{
					$('#banhor').val(1);
				}
			}
			
			if($('#txt_hor_horini2').val()!='' & $('#txt_hor_horfin2').val()!='')
			{
				if($('#txt_hor_horini2').val()>=$('#txt_hor_horfin2').val())
				{
					$('#banhor').val(0);
					mm='TURNO 2: Hora Inicio debe ser MENOR que Hora Fin.';
					alert(mm);
				}
				else
				{
					$('#banhor').val(1);
				}
			}
			
			if($('#txt_hor_horini2').val()!='')
			{
				$('#txt_hor_horfin2').removeAttr('disabled');
				$('#txt_hor_horfin2').removeClass("ui-state-disabled");
			}
			else
			{
				$('#txt_hor_horfin2').attr('disabled', 'disabled');
				$('#txt_hor_horfin2').addClass("ui-state-disabled");
				$('#txt_hor_horfin2').val('');
			}
		}
	});
	
	$('#txt_hor_horfin2').timepicker({
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
		showButtonPanel: false,
		onClose: function(dateText, inst) {
			if($('#txt_hor_horini2').val()!='' & $('#txt_hor_horfin2').val()!='')
			{
				if($('#txt_hor_horini2').val()>=$('#txt_hor_horfin2').val())
				{
					$('#banhor').val(0);
					mm='TURNO 2: Hora Fin debe ser MAYOR que Hora Inicio.';
					alert(mm);
				}
			}
		}
	});

	<?php if($_POST['action']=='editar' and $horini1!=""){?>
	$('#txt_hor_horfin1').removeAttr('disabled');
	$('#txt_hor_horfin1').removeClass("ui-state-disabled");
	<?php }?>
	
	<?php if($_POST['action']=='editar' and $horini2!=""){?>
	$('#txt_hor_horini2').removeAttr('disabled');
	$('#txt_hor_horini2').removeClass("ui-state-disabled");
	$('#txt_hor_horfin2').removeAttr('disabled');
	$('#txt_hor_horfin2').removeClass("ui-state-disabled");
	<?php }?>

//formulario
	$("#for_hor").validate({
		submitHandler: function() {			
			$.ajax({
				type: "POST",
				url: "horario_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_hor").serialize(),
				beforeSend: function() {
					$("#div_horario_form" ).dialog( "close" );
					$('#msj_horario').html("Guardando...");
					$('#msj_horario').show(100);
				},
				success: function(html){						
					$('#msj_horario').html(html);
				},
				complete: function(){
					horario_tabla();
				}
			});			
		},
		rules: {								
			txt_hor_nom: {
				required: true
			},
			txt_hor_fecini: {
				required: true,
				dateITA: true
			},
			txt_hor_fecfin: {
				required: true,
				dateITA: true
			},
			hdd_bandia: {
				required: true
			},
			txt_hor_horini1: {
				required: true,
				time:true
			},
			txt_hor_horfin1: {
				required: true,
				time: true
			},
			txt_hor_horini2: {
				required: dathorini2,
				time:true
			},
			txt_hor_horfin2: {
				required: true,
				time: true
			},
			hdd_banhor: {
				equalTo: "#banhor"
			},
			cmb_hor_est: {
				required: true
			}
		},
		messages: {
			txt_hor_nom: {
				required: '*'
			},
			txt_hor_fecini: {
				required: '*'
			},
			txt_hor_fecfin: {
				required: '*'
			},
			hdd_bandia: {
				required: 'Seleccione al menos un día.'
			},
			txt_hor_horini1: {
				required: '*'
			},
			txt_hor_horfin1: {
				required: '*'
			},
			txt_hor_horini2: {
				required: '*'
			},
			txt_hor_horfin2: {
				required: '*'
			},
			hdd_banhor: {
				equalTo: mm
			},
			cmb_hor_est: {
				required: '*'
			}
		}
	});

});
</script>
<style>
.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
.ui-timepicker-div dl { text-align: left; }
.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
.ui-timepicker-div td { font-size: 90%; }
.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
</style>
<form id="for_hor">
<input name="action_horario" id="action_horario" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_hor_id" id="hdd_hor_id" type="hidden" value="<?php echo $_POST['hor_id']?>">
<fieldset><legend>General</legend>
<label for="txt_hor_nom">Nombre de Horario:</label>
<input name="txt_hor_nom" type="text" id="txt_hor_nom" size="55" maxlength="50" value="<?php echo $nom?>">
<br>
<label for="txt_hor_fecini">Horario válido desde:</label>
<input name="txt_hor_fecini" type="text" id="txt_hor_fecini" value="<?php echo $fecini?>" size="8" readonly>
<label for="txt_hor_fecfin"> hasta</label>
<input name="txt_hor_fecfin" type="text" id="txt_hor_fecfin" value="<?php echo $fecfin?>" size="8" readonly>

<label for="cmb_hor_est">Estado</label>
<select name="cmb_hor_est" id="cmb_hor_est">
<option value="">-</option>
<option value="ACTIVO" <?php if($est=='ACTIVO')echo 'selected'?>>ACTIVO</option>
<option value="INACTIVO" <?php if($est=='INACTIVO')echo 'selected'?>>INACTIVO</option>
</select>
</fieldset>
<fieldset><legend>Detalle Horario</legend>
    <table>                
        <tr>
          <td>Día(s): <input type="hidden" name="hdd_bandia" id="hdd_bandia"></td>
        </tr>
        <tr>
          <td>
          <div id="format_checks">
          <input name="chk_hor_lun" type="checkbox" id="chk_hor_lun" value="1" <?php if($lun==1)echo 'checked'?> onChange="verifica_dia()">
          <label for="chk_hor_lun">Lunes</label>
          <input name="chk_hor_mar" type="checkbox" id="chk_hor_mar" value="1" <?php if($mar==1)echo 'checked'?> onChange="verifica_dia()">
          <label for="chk_hor_mar">Martes</label>
          <input name="chk_hor_mie" type="checkbox" id="chk_hor_mie" value="1" <?php if($mie==1)echo 'checked'?> onChange="verifica_dia()">
          <label for="chk_hor_mie">Miércoles</label>
          <input name="chk_hor_jue" type="checkbox" id="chk_hor_jue" value="1" <?php if($jue==1)echo 'checked'?> onChange="verifica_dia()">
          <label for="chk_hor_jue">Jueves</label>
          <input name="chk_hor_vie" type="checkbox" id="chk_hor_vie" value="1" <?php if($vie==1)echo 'checked'?> onChange="verifica_dia()">
          <label for="chk_hor_vie">Viernes</label>
          <input name="chk_hor_sab" type="checkbox" id="chk_hor_sab" value="1" <?php if($sab==1)echo 'checked'?> onChange="verifica_dia()">
          <label for="chk_hor_sab">Sábado</label>
          <input name="chk_hor_dom" type="checkbox" id="chk_hor_dom" value="1" <?php if($dom==1)echo 'checked'?> onChange="verifica_dia()">
          <label for="chk_hor_dom">Domingo</label>
          </div>        
          </td>
        </tr>
        <tr>
          <td><input type="hidden" name="hdd_banhor" id="hdd_banhor" value="1"><input type="hidden" name="banhor" id="banhor"></td>
        </tr>
        <tr>
          <td>
          TURNO 1: 
            <label for="txt_hor_horini1">Hora Inicio</label>
          	<input name="txt_hor_horini1" type="text" id="txt_hor_horini1" value="<?php echo $horini1?>" size="10" maxlength="5" />
            <label for="txt_hor_horfin1">Hora Fin</label>
          <input name="txt_hor_horfin1" type="text" id="txt_hor_horfin1" value="<?php echo $horfin1?>" size="10" maxlength="5" /></td>
        </tr>
        <tr>
          <td>TURNO 2:
            <label for="txt_hor_horini2">Hora Inicio</label>
            <input name="txt_hor_horini2" type="text" id="txt_hor_horini2" value="<?php echo $horini2?>" size="10" maxlength="5" />
            <label for="txt_hor_horfin2">Hora Fin</label>
          <input name="txt_hor_horfin2" type="text" id="txt_hor_horfin2" value="<?php echo $horfin2?>" size="10" maxlength="5"/></td>
        </tr>        
    </table>
</fieldset>
</form>