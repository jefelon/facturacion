<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cEncarte.php");
$oEncarte = new cEncarte();

require_once("../formatos/formato.php");
require_once("../menu/acceso.php");

if($_POST['action']=="insertar"){
	$fecini=date('d-m-Y');
	//$fecfin=date('d-m-Y');
	$est='ACTIVO';
	unset($_SESSION['precio_car']);
}

if($_POST['action']=="editar"){
	$dts= $oEncarte->mostrarUno($_POST['enc_id']);
	$dt = mysql_fetch_array($dts);
		$fecini	=mostrarFecha($dt['tb_encarte_fecini']);
		$fecfin	=mostrarFecha($dt['tb_encarte_fecfin']);

		$des	=$dt['tb_encarte_des'];
		$despor	=$dt['tb_encarte_despor'];

		$est	=$dt['tb_encarte_est'];
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

$('.porcentaje').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99.99'
});

var dates = $( "#txt_enc_fecini, #txt_enc_fecfin" ).datepicker({
		//defaultDate: "+1w",
		minDate: "0D", 
		//maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_enc_fecini" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});

function encarte_car(act,idf)
{
    /*if($('#chk_cat_igv_'+idf).is(':checked')) {  
		var chk=1;  
	} else {  
		var chk=0;   
	}*/
	$.ajax({
		type: "POST",
		url: "encarte_car.php",
		async:true,
		dataType: "html",                      
		data: ({
			action:	 act,
			cat_id:	 idf,
			cat_cos: 		$('#txt_cat_precos_'+idf).val(),
			cat_uti1: 		$('#txt_cat_uti1_'+idf).val(),
			cat_preven1:	 	$('#txt_cat_preven1_'+idf).val(),
			encdet_despor: 	$('#txt_encdet_despor_'+idf).val(),
			cat_uti2: 		$('#txt_cat_uti2_'+idf).val(),
			cat_preven2:	 	$('#txt_cat_preven2_'+idf).val()
		}),
		beforeSend: function() {
			$('#div_encarte_car_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_encarte_car_tabla').html(html);
		},
		complete: function(){			
			$('#div_encarte_car_tabla').removeClass("ui-state-disabled");
		}
	});   
}

/*function encarte_car_prorrateo()
{
	$.ajax({
		type: "POST",
		url: "encarte_car_prorrateo.php",
		async:true,
		dataType: "json",                      
		data: ({
			enc_des: 	$('#txt_enc_des').val(),
			enc_fle:	$('#txt_enc_fle').val(),
			enc_ajupos:	$('#txt_enc_ajupos').val(),
			enc_ajuneg:	$('#txt_enc_ajuneg').val(),
			enc_tipfle: $('#cmb_enc_tipfle').val()		
		}),
		beforeSend: function(){
			$('#msj_encarte_car_item').html("Cargando...");
			$('#msj_encarte_car_item').show(100);				
		},
		success: function(data){
			$('#msj_encarte_car_item').html(data.msj);
		},
		complete: function(){
			encarte_car('actualizar');			
		}
	});   
}*/

function catalogo_encarte(){
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_encarte.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//tippre:	$('#cmb_enc_tippre').val()
		}),
		beforeSend: function() {
			$('#msj_encarte').hide();
			$('#div_catalogo_encarte').dialog("open");
			$('#div_catalogo_encarte').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_encarte').html(html);				
		}
	});
}

function encarte_detalle_tabla()
{
	$.ajax({
		type: "POST",
		url: "../encarte/encarte_detalle_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			enc_id:	'<?php echo $_POST['enc_id']?>'
		}),
		beforeSend: function() {
			$('#div_encarte_detalle_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_encarte_detalle_tabla').html(html);
		},
		complete: function(){			
			$('#div_encarte_detalle_tabla').removeClass("ui-state-disabled");
		}
	});     
}

//adicionales

function editar_datos_item(idf, nom){	
	$.ajax({
		type: "POST",
		url: "../encarte/encarte_car_item.php",
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

$(function() {
	
	<?php
	if($_POST['action']=="insertar"){
	?>
	encarte_car('restablecer');
	encarte_car();
	<?php
	}
	if($_POST['action']=="editar"){
	?>
	encarte_detalle_tabla();
	//$('#cmb_enc_est').attr('disabled', 'disabled');
	$('#txt_enc_fecini,#txt_enc_fecfin,#txt_enc_despor').attr('disabled', 'disabled');
	//$("#cmb_enc_alm_id").addClass("ui-state-disabled");

	<?php }?>

	$( "#div_catalogo_encarte" ).dialog({
		title:'Catálogo de Encarte',
		autoOpen: false,
		resizable: false,
		height: 480,
		width: 980,
		zIndex: 2,
		modal: false,
		position: ["center",120],
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	//Formulario para actualizar Item de Detalle de Encarte
	$( "#div_item_form" ).dialog({
		title:'Información de Item',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 300,
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
	
//formulario			
	$("#for_enc").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../encarte/encarte_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_enc").serialize(),
				beforeSend: function(){
					$('#div_encarte_form').dialog("close");
					$('#msj_encarte').html("Guardando...");
					$('#msj_encarte').show(100);
				},
				success: function(data){
					$('#msj_encarte').html(data.enc_msj);
				},
				complete: function(){
					encarte_tabla();
				}
			});			
		},
		rules: {
			txt_enc_fecini: {
				required: true,
				dateITA: true
			},
			txt_enc_fecfin: {
				required: true,
				dateITA: true
			},
			txt_enc_des: {
				required: true
			},
			cmb_enc_est: {
				required: true
			},
			hdd_enc_numite: {
				required: true
			}
		},
		messages: {
			txt_enc_fecini: {
				required: '*'
			},
			txt_enc_fecfin: {
				required: '*'
			},
			txt_enc_des: {
				required: '*'
			},
			cmb_enc_est: {
				required: '*'
			},
			hdd_enc_numite: {
				required: 'Agregue producto a detalle de encarte.'
			}
		}
	});
	
	$(document).shortkeys({
	  'a+p':       function () { catalogo_encarte() }
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
<form id="for_enc">
<input name="action_encarte" id="action_encarte" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_enc_id" id="hdd_enc_id" type="hidden" value="<?php echo $_POST['enc_id']?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $_SESSION['empresa_id']?>">
<fieldset>
  <legend>Datos Principales</legend>
  <table>
  	<tr>
    	<td align="right"><label for="txt_enc_fecini">Fecha inicio:</label>
          <input name="txt_enc_fecini" type="text" class="fecha" id="txt_enc_fecini" value="<?php echo $fecini?>" size="10" maxlength="10" readonly></td>
    	<td><label for="txt_enc_fecfin">Fecha fin:</label>
        <input name="txt_enc_fecfin" type="text" class="fecha" id="txt_enc_fecfin" value="<?php echo $fecfin?>" size="10" maxlength="10" readonly></td>
    	<td><label for="txt_enc_des">Descripción:</label></td>
    	<td rowspan="2"><textarea name="txt_enc_des" cols="50" rows="3" id="txt_enc_des"><?php echo $des?></textarea></td>
    	<td><?php
      $url=ir_principal($_SESSION['usuariogrupo_id']);
	  ?>
      <a class="btn_newwin" target="_blank" title="Saltar a otra pestaña" href="<?php echo $url?>">Saltar</a></td>
    </tr>
  	<tr>
  	  <td><label for="cmb_enc_est">Estado:</label>
  	    <select name="cmb_enc_est" id="cmb_enc_est">
  	      <option value="">-</option>
  	      <option value="ACTIVO" <?php if($est=='ACTIVO')echo 'selected'?>>ACTIVO</option>
          <?php if($_POST['action']=='editar'){?>
  	      <option value="INACTIVO" <?php if($est=='INACTIVO')echo 'selected'?>>INACTIVO</option>
          <?php }?>
	      </select></td>
  	  <td><label for="txt_enc_despor">Descuento:</label> 
  	    <input name="txt_enc_despor" type="text" id="txt_enc_despor" class="porcentaje" value="<?php if($despor!=0) echo $despor?>" size="4" maxlength="5" style="text-align:right" onChange="calculo_descuento_porcentaje()">
  	    %</td>
  	  <td>&nbsp;</td>
  	  <td>&nbsp;</td>
	  </tr>
  </table>
     
</fieldset>
<?php
if($_POST['action']=="insertar"){
?>
<div id="div_encarte_car_tabla">
</div>
<div id="div_item_form">
</div>
<?php }?>
</form>
<?php
if($_POST['action']=="insertar"){
?>
<div id="div_catalogo_encarte">
</div>
<?php
}
if($_POST['action']=="editar"){
?>
<div id="div_encarte_detalle_tabla">
</div>
<?php }?>