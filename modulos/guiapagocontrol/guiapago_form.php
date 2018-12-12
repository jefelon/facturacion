<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../cliente/cCliente.php");
$oCliente = new cCliente();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../guiapagocontrol/cGuiapago.php");
$oGuiapago = new cGuiapago();
require_once ("../declaracion/cDeclaracion.php");
$oDeclaracion = new cDeclaracion();

require_once("../formatos/formato.php");

if($_POST['cli_id']>0){
	$dts=$oCliente->mostrarUno($_POST['cli_id']);
	$dt = mysql_fetch_array($dts);
		//$tip=$dt['tb_cliente_tip'];
		$cli_nom=$dt['tb_cliente_nom'];
		$cli_doc=$dt['tb_cliente_doc'];
		//$dir=$dt['tb_cliente_dir'];

		$cli_con=$dt['tb_cliente_con'];
		$cli_car=$dt['tb_cliente_car'];
		$cli_tel=$dt['tb_cliente_tel'];
		$cli_ema=$dt['tb_cliente_ema'];

		$cli_con1=$dt['tb_cliente_con1'];
		$cli_car1=$dt['tb_cliente_car1'];
		$$cli_tel1=$dt['tb_cliente_tel1'];
		$cli_ema1=$dt['tb_cliente_ema1'];

		$cli_con2=$dt['tb_cliente_con2'];
		$cli_car2=$dt['tb_cliente_car2'];
		$cli_tel2=$dt['tb_cliente_tel2'];
		$cli_ema2=$dt['tb_cliente_ema2'];

		$cli_ultdig=$dt['tb_cliente_ultdig'];

	mysql_free_result($dts);

}

//usuarios
/*if($_SESSION['usuario_id']>0)
{
	$dts=$oUsuario->mostrarUno($_SESSION['usuario_id']);
	$dt = mysql_fetch_array($dts);
		$usugru		=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$usu_nom	=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$ema		=$dt['tb_usuario_ema'];
	
	mysql_free_result($dts);
	
	$usuario_reg="$usu_nom $apepat $apemat";
}

$empresa=$_SESSION['empresa_nombre'];

*/

/*if($_POST['action']=='insertar')
{
	//CONSULTA CRONOGRAMA FECHA
	$cro_id=1; // por defecto el cronograma de vencimiento de igv
    $rws=$oDeclaracion->cronograma_fecha($cro_id,$_POST['eje_id'],$_POST['per_id'],$cli_ultdig);
    $rw = mysql_fetch_array($rws);
    	$crofec_id  =$rw['tb_cronogramafecha_id'];
    	$crofec_fec1=$rw['tb_cronogramafecha_fec1'];
    mysql_free_result($rws);

    $fecven=mostrarFecha($crofec_fec1);
    $fecpag=mostrarFecha($crofec_fec1);
}*/

if($_POST['action']=='insertar_actualizacion')
{
	if($_POST['guipag_id']>0)
	{
		$dts=$oGuiapago->mostrarUno($_POST['guipag_id']);
		$dt = mysql_fetch_array($dts);
			$guipagtip_id=$dt['tb_guiapagotipo_id'];
			$fecven 	=mostrarFecha($dt['tb_guiapago_fecven']);
			$fecpag 	=mostrarFecha($dt['tb_guiapago_fecpag']);
			$des 		=$dt['tb_guiapago_des'];
			$imppagbas 	=formato_money($dt['tb_guiapago_imppagbas']);
			$est 		=$dt['tb_guiapago_est'];

			if($guipagtip_id==1){
				$pag 		=$dt['tb_guiapago_pag'];
				$codtri 	=$dt['tb_guiapago_codtri'];
				$imppag 	=formato_money($dt['tb_guiapago_imppag']);
				$codtriaso 	=$dt['tb_guiapago_codtriaso'];
				$numdoc		=$dt['tb_guiapago_numdoc'];
			}

			if($guipagtip_id==2){
				$tipdocinq 	=$dt['tb_guiapago_tipdocinq'];
				$numdocinq 	=$dt['tb_guiapago_numdocinq'];
				$monalq 	=formato_money($dt['tb_guiapago_monalq']);
				$arrrec 	=$dt['tb_guiapago_arrrec'];
				if($arrrec==2)
				{
					$numordope 	=$dt['tb_guiapago_numordope'];
					$arrimppag 	=$dt['tb_guiapago_arrimppag'];
				}
			}
			
			if($guipagtip_id==3){
				$toting 	=formato_money($dt['tb_guiapago_toting']);
				$cat 		=$dt['tb_guiapago_cat'];
				if($dt['tb_guiapago_moncom']>0)$moncom 	=formato_money($dt['tb_guiapago_moncom']);

				$rusimppag 	=formato_money($dt['tb_guiapago_rusimppag']);
				$privez 	=$dt['tb_guiapago_privez'];
				if($privez==2)
				{
					$compag 	=formato_money($dt['tb_guiapago_compag']);
				}
			}

			if($guipagtip_id==4){
				$numrucarr 		=$dt['tb_guiapago_numrucarr'];
				$tipdocinq2 	=$dt['tb_guiapago_tipdocinq'];
				$numdocinq2 	=$dt['tb_guiapago_numdocinq'];
				$monalq2 		=formato_money($dt['tb_guiapago_monalq']);
				$arrrec2 		=$dt['tb_guiapago_arrrec'];
				if($arrrec2==2)
				{
					$numordope2 	=$dt['tb_guiapago_numordope'];
					$arrimppag2 	=$dt['tb_guiapago_arrimppag'];
				}
			}

		mysql_free_result($dts);
	}
}

$periodo=str_pad($_POST['per_id'], 2, "0", STR_PAD_LEFT);
$ejercicio=$_POST['eje_id'];


?>
<script type="text/javascript">

$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.9999'
});

function cmb_guipagtip_id(idf)
{	
	$.ajax({
		type: "POST",
		url: "../guiapagotipo/cmb_guipagtip_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			guipagtip_id: idf
		}),
		beforeSend: function() {
			$('#cmb_guipagtip_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_guipagtip_id').html(html);
		},
		complete: function(){
			div_formato();
			cmb_guimod_id('',$('#cmb_guipagtip_id').val());
		}
	});
}

function cmb_guimod_id(idf,guipagtip)
{	
	$.ajax({
		type: "POST",
		url: "../guiamodelo/cmb_guimod_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			guimod_id: idf,
			guipagtip_id: guipagtip
		}),
		beforeSend: function() {
			$('#cmb_guimod_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_guimod_id').html(html);
		},
		complete: function(){
			//div_formato();
		}
	});
}

function guiamodelo_cargar(guimod)
{	
	$.ajax({
		type: "POST",
		url: "../guiamodelo/guiamodelo_cargar.php",
		async:true,
		dataType: "json",                      
		data: ({
			guimod_id: guimod
		}),
		beforeSend: function() {
			//$('#cmb_guimod_id').html('<option value="">Cargando...</option>');
        },
		success: function(data){
			$('#txt_guipag_des').val(data.guipag_des);		
			
			if(data.guipagtip==1)
			{
				$('#txt_guipag_codtri').val(data.guipag_codtri);
				$('#txt_guipag_codtriaso').val(data.guipag_codtriaso);
				$('#cmb_guipag_pag').val(data.guipag_pag);

				$('#txt_guipag_imppag').focus();
			}
			if(data.guipagtip==2)
			{
				$('#txt_guipag_tipdocinq').val(data.guipag_tipdocinq);

				$('#txt_guipag_numdocinq').focus();
			}
			if(data.guipagtip==3)
			{
				$('#txt_guipag_cat').val(data.guipag_cat);

				$('#txt_guipag_toting').focus();
			}
			if(data.guipagtip==4)
			{
				$('#txt_guipag_tipdocinq2').val(data.guipag_tipdocinq);

				$('#txt_guipag_numrucarr').focus();
			}
		},
		complete: function(){
			//div_formato();
			guiapago_fecha($('#cmb_guipagtip_id').val(),$('#cmb_guipag_pag').val(),<?php echo $_POST['eje_id']?>,<?php echo $_POST['per_id']?>,<?php echo $cli_ultdig?>)
		}
	});
}

function guiapago_fecha(guitip,pag,eje,per,ultdig)
{	
	$.ajax({
		type: "POST",
		url: "../guiapagocontrol/guiapago_fecha.php",
		async:false,
		dataType: "html",     
		data: ({
			guitip: guitip,
			pag: 	pag,
			eje_id: eje,
			per_id: per,
			cli_ultdig: ultdig
		}),
		beforeSend: function() {
			//alert(guitip+'/'+pag+'/'+eje+'/'+per+'/'+ultdig);
			//$('#cmb_guimod_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#div_fechas').html(html);
			//$('#txt_guipag_fecven').val(data.fecven);
			//$('#txt_guipag_fecpag').val(data.fecpag);
		},
		complete: function(){
			//div_formato();
			actualizar_datos();
		}
	});
}

function div_formato()
{
	$('#div_formato1').hide('100');
	$('#div_formato2').hide('100');
	$('#div_formato3').hide('100');
	$('#div_formato4').hide('100');
	//$('#div_calculo_interes').hide('10');

	if($('#cmb_guipagtip_id').val()>0)
	{
		$('#div_calculo_interes').show('10');
	}
	else
	{
		$('#div_calculo_interes').hide('10');
	}

	if($('#cmb_guipagtip_id').val()=='1')
	{
		$('#div_formato1').show('100');
	}

	if($('#cmb_guipagtip_id').val()=='2')
	{
		$('#div_formato2').show('100');
	}

	if($('#cmb_guipagtip_id').val()=='3')
	{
		$('#div_formato3').show('100');
	}

	if($('#cmb_guipagtip_id').val()=='4')
	{
		$('#div_formato4').show('100');
	}
}

function calculo()
{	
	<?php
	if($_POST['action']=='insertar_actualizacion')
	{
	?>
		$.ajax({
			type: "POST",
			url: "../guiapagocontrol/guiapago_calculo.php",
			async:true,
			dataType: "html",                      
			data: ({
				guipagtip_id: $('#cmb_guipagtip_id').val(),
				fecven: $('#txt_guipag_fecven').val(),
				fecpag: $('#txt_guipag_fecpag').val(),
				imppagbas: $('#txt_guipag_imppagbas').autoNumericGet()
			}),
			beforeSend: function() {
				$('#div_calculo').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
	        },
			success: function(html){			
				$('#div_calculo').html(html);
			},
			complete: function(){
			}
		});
	<?php }?>
}

function actualizar_datos()
{
	var tipo=$('#cmb_guipagtip_id').val();
	if(tipo==1)
	{
		$('#txt_guipag_imppagbas').val($('#txt_guipag_imppag').val());
	}

	if(tipo==2)
	{
		var resultado=$('#txt_guipag_monalq').autoNumericGet()*0.05;
		$('#txt_guipag_imppagbas').autoNumericSet(resultado);
	}

	if(tipo==3)
	{
		$('#txt_guipag_imppagbas').val($('#txt_guipag_rusimppag').val());
	}

	if(tipo==4)
	{
		var resultado=$('#txt_guipag_monalq2').autoNumericGet()*0.05;
		$('#txt_guipag_imppagbas').autoNumericSet(resultado);
	}

	calculo();
}

$(function() {

	//$('#txt_guipag_des').focus();

	cmb_guipagtip_id('<?php echo $guipagtip_id?>');

	$('#cmb_guipagtip_id').change(function(event) {
		div_formato();
		cmb_guimod_id('',$('#cmb_guipagtip_id').val());
		guiapago_fecha($('#cmb_guipagtip_id').val(),$('#cmb_guipag_pag').val(),<?php echo $_POST['eje_id']?>,<?php echo $_POST['per_id']?>,<?php echo $cli_ultdig?>)
	});

	$('#cmb_guimod_id').change(function(event) {
		guiamodelo_cargar($('#cmb_guimod_id').val());
		guiapago_fecha($('#cmb_guipagtip_id').val(),$('#cmb_guipag_pag').val(),<?php echo $_POST['eje_id']?>,<?php echo $_POST['per_id']?>,<?php echo $cli_ultdig?>)
	});

	$('#txt_guipag_des').autocomplete({
		minLength: 1,
		source: "../guiapagocontrol/guiapago_complete_des.php"
	});

	$('#txt_guipag_des').change(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$('#cmb_guipag_pag').change(function(event) {
		guiapago_fecha($('#cmb_guipagtip_id').val(),$('#cmb_guipag_pag').val(),<?php echo $_POST['eje_id']?>,<?php echo $_POST['per_id']?>,<?php echo $cli_ultdig?>)
	});

	<?php
	if($_POST['action']=='insertar')
	{
	?>
		/*var dates = $( "#txt_guipag_fecven, #txt_guipag_fecpag" ).datepicker({
			//defaultDate: "+1w",
			//maxDate:"+0D",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: 'dd-mm-yy',
			buttonImage: "../../images/calendar.gif",
			buttonImageOnly: true,
			onSelect: function( selectedDate ) {
				var option = this.id == "txt_guipag_fecven" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
				calculo();
			}
		});*/
	<?php }?>

	<?php
	if($_POST['action']=='insertar_actualizacion')
	{
	?>

	$('#txt_guipag_fecven, #cmb_guipagtip_id').attr('disabled', 'true');

	$('#cmb_guipag_pag, #txt_guipag_codtri, #txt_guipag_codtriaso, #txt_guipag_numdoc').attr('disabled', 'true');
	//$('#txt_guipag_imppag').removeClass('moneda');
	//$('#txt_guipag_imppag').attr('readonly', 'true');
	$('#txt_guipag_imppag').attr('disabled', 'true');

	$('#txt_guipag_tipdocinq, #txt_guipag_numdocinq, #txt_guipag_monalq, #cmb_guipag_arrrec, #txt_guipag_numordope, #txt_guipag_imppagser').attr('disabled', 'true');

	$('#txt_guipag_toting, #txt_guipag_cat, #txt_guipag_moncom, #txt_guipag_rusimppag, #cmb_guipag_privez, #txt_guipag_compag').attr('disabled', 'true');

	$('#txt_guipag_numrucarr, #txt_guipag_tipdocinq2, #txt_guipag_numdocinq2, #txt_guipag_monalq2, #cmb_guipag_arrrec2, #txt_guipag_numordope2, #txt_guipag_imppagser2').attr('disabled', 'true');

	$("#txt_guipag_fecpag").datepicker({
		minDate: "<?php echo $fecven;?>", 
		//maxDate:"+0D",
		yearRange: 'c-1:c+1',
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd-mm-yy',
		//altField: fecha,
		//altFormat: 'yy-mm-dd',
		showOn: "button",
		buttonImage: "../../images/calendar.gif",
		buttonImageOnly: true,
		onSelect: function( selectedDate ) {
			calculo();
		}
	});

	<?php }?>

	calculo();

//formulario			
	$("#for_guipag").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../guiapagocontrol/guiapago_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_guipag").serialize(),
				beforeSend: function(){
					$('#div_guiapago_form').dialog("close");
					$('#msj_guiapagocontrol').html("Guardando...");
					$('#msj_guiapagocontrol').show(100);
				},
				success: function(data){
					$('#msj_guiapagocontrol').html(data.guipag_msj);
				},
				complete: function(){
					guiapagocontrol_tabla();
				}
			});			
		},
		rules: {
			cmb_guipagtip_id: {
				required: true
			},
			txt_guipag_des: {
				required: true
			},
			txt_guipag_fecven: {
				required: true
			},
			txt_guipag_fecpag: {
				required: true
			},
			txt_guipag_imppagbas: {
				required: true
			}
		},
		messages: {
			cmb_guipagtip_id: {
				required: '*'
			},
			txt_guipag_des: {
				required: '*'
			},
			txt_guipag_fecven: {
				required: '*'
			},
			txt_guipag_fecpag: {
				required: '*'
			},
			txt_guipag_imppagbas: {
				required: '*'
			}
		}
	});

});
</script>

<div>
<form id="for_guipag">
<input type="hidden" id="action" name="action" value="<?php echo $_POST['action']?>">
<input type="hidden" id="hdd_guipag_id" name="hdd_guipag_id" value="<?php echo $_POST['guipag_id']?>" />
<input type="hidden" id="hdd_cli_id" name="hdd_cli_id" value="<?php echo $_POST['cli_id']?>" />
<input type="hidden" id="hdd_per_id" name="hdd_per_id" value="<?php echo $_POST['per_id']?>" />
<input type="hidden" id="hdd_eje_id" name="hdd_eje_id" value="<?php echo $_POST['eje_id']?>" />


<table border="0" cellspacing="0" cellpadding="1" >

  	<tr>
		<td><label for="cmb_guipagtip_id">Tipo de Guía:</label></td>
      	<td><select name="cmb_guipagtip_id" id="cmb_guipagtip_id">
        </select></td>
    </tr>
	<?php if($_POST['action']=='insertar'){?>
    <tr>
		<td><label for="cmb_guimod_id">Modelo de Guía:</label></td>
      	<td><select name="cmb_guimod_id" id="cmb_guimod_id">
        </select></td>
    </tr>
	<?php }?>

	<tr>
    	<td>&nbsp</td>
		<td align="center">&nbsp</td>
    </tr>
    
    <tr>
      <td><label for="txt_guipag_des">Descripción:</label></td>
      <td><input type="text" name="txt_guipag_des" id="txt_guipag_des" size="50" value="<?php echo $des?>" /></td>
    </tr>

	<tr>
    	<td>&nbsp</td>
		<td align="center">&nbsp</td>
    </tr>
</table>

<div id="div_formato1" style="display:none; float:left; ">
<table border="0" cellspacing="0" cellpadding="1" >
	<tr>
		<td><label for="cmb_guipag_pag">Pagar:</label></td>
      	<td>
      		<select name="cmb_guipag_pag" id="cmb_guipag_pag">
        		<option value="1" <?php if($pag=='1')echo 'selected'?>>TRIBUTOS</option>
        		<option value="2" <?php if($pag=='2')echo 'selected'?>>MULTAS</option>
        		<option value="3" <?php if($pag=='3')echo 'selected'?>>COSTAS Y GASTOS ADMS</option>
        		<option value="4" <?php if($pag=='4')echo 'selected'?>>FRACCIONAMIENTO</option>
        	</select>
        </td>
    </tr>
    <tr>
    	<td>Número de RUC: </td>
		<td align="left">
			<span style="font-weight:bold; font-size: 10pt;">
			<?php echo "$cli_doc"?>
			</span>
		</td>
    </tr>
    <tr>
    	<td>Periodo Tributario: </td>
		<td align="left">
			<span style="font-weight:bold; font-size: 10pt;">
			<?php echo "$periodo/$ejercicio"?>
			</span>
		</td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_codtri">Código de Tributo, Concepto o Multa:</label></td>
      <td><input type="text" name="txt_guipag_codtri" id="txt_guipag_codtri" maxlength="4" size="4" style="font-size:11pt;" value="<?php echo $codtri?>" /></td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_imppag">Importe a Pagar:</label></td>
      <td><input type="text" name="txt_guipag_imppag" id="txt_guipag_imppag" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $imppag?>" onChange="actualizar_datos()" /></td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_codtriaso">Código de Tributo Asociado:</label></td>
      <td><input type="text" name="txt_guipag_codtriaso" id="txt_guipag_codtriaso" maxlength="4" size="4" style="font-size:11pt;" value="<?php echo $codtriaso?>" /></td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_numdoc">N° de Documento:</label></td>
      <td><input type="text" name="txt_guipag_numdoc" id="txt_guipag_numdoc" size="25" style="font-size:11pt;" value="<?php echo $numdoc?>" /></td>
    </tr>
</table>
</div>

<div id="div_formato2" style="display:none; float:left;">
<table border="0" cellspacing="0" cellpadding="1" >

    <tr>
    	<td>Número RUC del Arrendador: </td>
		<td align="left">
			<span style="font-weight:bold; font-size: 10pt;">
			<?php echo "$cli_doc"?>
			</span>
		</td>
    </tr>
    <tr>
    	<td>Periodo Tributario: </td>
		<td align="left">
			<span style="font-weight:bold; font-size: 10pt;">
			<?php echo "$periodo/$ejercicio"?>
			</span>
		</td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_tipdocinq">Código del Tipo de Documento de Identidad del Inquilino:</label></td>
      <td><input type="text" name="txt_guipag_tipdocinq" id="txt_guipag_tipdocinq" maxlength="2" size="2" style="font-size:11pt;" value="<?php echo $tipdocinq?>" /></td>
    </tr>

	<tr>
      <td valign="middle"><label for="txt_guipag_numdocinq">N° de Documento de Identidad del Inquilino:</label></td>
      <td><input type="text" name="txt_guipag_numdocinq" id="txt_guipag_numdocinq" maxlength="11" size="11" style="font-size:11pt;" value="<?php echo $numdocinq?>" /></td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_monalq">Monto del Alquiler en Moneda Nacional:</label></td>
      <td><input type="text" name="txt_guipag_monalq" id="txt_guipag_monalq" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $monalq?>" onChange="actualizar_datos()" /></td>
    </tr>

	<tr>
		<td><label for="cmb_guipag_arrrec">¿Es ésta una declaración rectificatoria/sustitutoria?:</label></td>
      	<td>
      		<select name="cmb_guipag_arrrec" id="cmb_guipag_arrrec">
        		<option value="1" <?php if($arrrec=='1')echo 'selected'?>>NO</option>
        		<option value="2" <?php if($arrrec=='2')echo 'selected'?>>SI</option>
        	</select>
        </td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_numordope">Número de Orden u Operación:</label></td>
      <td><input type="text" name="txt_guipag_numordope" id="txt_guipag_numordope" maxlength="15" size="15" style="font-size:11pt;" value="<?php echo $numordope?>" /></td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_imppagser">Importe a Pagar (de ser el caso):</label></td>
      <td><input type="text" name="txt_guipag_imppagser" id="txt_guipag_imppagser" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $imppagser?>" /></td>
    </tr>
</table>
</div>

<div id="div_formato3" style="display:none; float:left;">
<table border="0" cellspacing="0" cellpadding="1" >

    <tr>
    	<td>Número de RUC: </td>
		<td align="left">
			<span style="font-weight:bold; font-size: 10pt;">
			<?php echo "$cli_doc"?>
			</span>
		</td>
    </tr>
    <tr>
    	<td>Periodo Tributario: </td>
		<td align="left">
			<span style="font-weight:bold; font-size: 10pt;">
			<?php echo "$periodo/$ejercicio"?>
			</span>
		</td>
    </tr>

	<tr>
      <td valign="middle"><label for="txt_guipag_toting">Total Ingresos Brutos del Mes:</label></td>
      <td><input type="text" name="txt_guipag_toting" id="txt_guipag_toting" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $toting?>" /></td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_cat">Categoría:</label></td>
      <td><input type="text" name="txt_guipag_cat" id="txt_guipag_cat" maxlength="2" size="2" style="font-size:11pt;" value="<?php echo $cat?>" /></td>
    </tr>

	<tr>
      <td valign="middle"><label for="txt_guipag_moncom">Monto a Compensar por Percepciones de IGV que le hubiesen afectado:</label></td>
      <td><input type="text" name="txt_guipag_moncom" id="txt_guipag_moncom" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $moncom?>" /></td>
    </tr>
    
    <tr>
      <td valign="middle"><label for="txt_guipag_rusimppag">Importe a Pagar:</label></td>
      <td><input type="text" name="txt_guipag_rusimppag" id="txt_guipag_rusimppag" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $rusimppag?>" onChange="actualizar_datos()" /></td>
    </tr>

    <tr>
		<td><label for="cmb_guipag_privez">¿Es la primera vez que declara para este periodo?:</label></td>
      	<td>
      		<select name="cmb_guipag_privez" id="cmb_guipag_privez">
        		<option value="1" <?php if($privez=='1')echo 'selected'?>>NO</option>
        		<option value="2" <?php if($privez=='2')echo 'selected'?>>SI</option>
        	</select>
        </td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_compag">Compensación y/o Pagos Efectuados:</label></td>
      <td><input type="text" name="txt_guipag_compag" id="txt_guipag_compag" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $compag?>" /></td>
    </tr>

</table>
</div>

<div id="div_formato4" style="display:none; float:left;">
<table border="0" cellspacing="0" cellpadding="1" >

	<tr>
      <td valign="middle"><label for="txt_guipag_numrucarr">Número RUC del Arrendador: </label></td>
      <td><input type="text" name="txt_guipag_numrucarr" id="txt_guipag_numrucarr" maxlength="11" size="11" style="font-size:11pt;" value="<?php echo $numrucarr?>" /></td>
    </tr>

    <tr>
    	<td>Periodo Tributario: </td>
		<td align="left">
			<span style="font-weight:bold; font-size: 10pt;">
			<?php echo "$periodo/$ejercicio"?>
			</span>
		</td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_tipdocinq2">Código del Tipo de Documento de Identidad del Inquilino:</label></td>
      <td><input type="text" name="txt_guipag_tipdocinq2" id="txt_guipag_tipdocinq2" maxlength="2" size="2" style="font-size:11pt;" value="<?php echo $tipdocinq2?>" /></td>
    </tr>

	<tr>
      <td valign="middle">N° de Documento de Identidad del Inquilino:</td>
      <td align="left">
			<span style="font-weight:bold; font-size: 10pt;">
			<?php echo "$cli_doc"?>
			</span>
		</td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_monalq2">Monto del Alquiler en Moneda Nacional:</label></td>
      <td><input type="text" name="txt_guipag_monalq2" id="txt_guipag_monalq2" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $monalq2?>" onChange="actualizar_datos()" /></td>
    </tr>

	<tr>
		<td><label for="cmb_guipag_arrrec2">¿Es ésta una declaración rectificatoria/sustitutoria?:</label></td>
      	<td>
      		<select name="cmb_guipag_arrrec2" id="cmb_guipag_arrrec2">
        		<option value="1" <?php if($arrrec2=='1')echo 'selected'?>>NO</option>
        		<option value="2" <?php if($arrrec2=='2')echo 'selected'?>>SI</option>
        	</select>
        </td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_numordope2">Número de Orden u Operación:</label></td>
      <td><input type="text" name="txt_guipag_numordope2" id="txt_guipag_numordope2" maxlength="15" size="15" style="font-size:11pt;" value="<?php echo $numordope2?>" /></td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_imppagser2">Importe a Pagar (de ser el caso):</label></td>
      <td><input type="text" name="txt_guipag_imppagser2" id="txt_guipag_imppagser2" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $imppagser2?>" /></td>
    </tr>
</table>
</div>

<div id="div_calculo_interes" style="display:none; float:left; margin-left:10px; ">

<div id="div_fechas">
</div>
<?php if($_POST['action']=='insertar_actualizacion'){?>
	<table border="0" cellspacing="0" cellpadding="1" >
	  	<tr>
			<td><label for="txt_guipag_fecven">Fecha de Vencimiento:</label></td>
	      	<td><input name="txt_guipag_fecven" type="text" class="fecha" id="txt_guipag_fecven" value="<?php echo $fecven?>" size="10" maxlength="10" readonly></td>
	    </tr>
	    <tr>
			<td><label for="txt_guipag_fecpag">Fecha de Act/Pago:</label></td>
	      	<td><input name="txt_guipag_fecpag" type="text" class="fecha" id="txt_guipag_fecpag" value="<?php echo $fecpag?>" size="10" maxlength="10" readonly><?php if($_POST['action']=='insertar_actualizacion')echo "<span style='color:red;'><= Seleccione Fecha</span>";?></td>
	    </tr>

	    <tr>
	      <td valign="middle"><label for="txt_guipag_imppagbas">Importe Sin Intereses:</label></td>
	      <td><input type="text" name="txt_guipag_imppagbas" id="txt_guipag_imppagbas" maxlength="10" size="10" style="font-size:11pt; text-align:right;" value="<?php echo $imppagbas?>" readonly /></td>
	    </tr>

	</table>
<?php }?>
<div id="div_calculo">
</div>

</div>

</form>
</div>
