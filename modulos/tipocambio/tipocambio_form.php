<?php
require_once ("../../config/Cado.php");
require_once ("../tipocambio/cTipoCambio.php");
require_once("../formatos/formato.php");
$oTipoCambio = new cTipoCambio();

if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
}

if($_POST['action']=="editar"){
	$dts=$oTipoCambio->mostrarUno($_POST['tipcam_id']);
	$dt = mysql_fetch_array($dts);
		
		$reg=mostrarFechaHora($dt['tb_tipocambio_reg']);
		$mod=mostrarFechaHora($dt['tb_tipocambio_mod']);
		$fec=mostrarFecha($dt['tb_tipocambio_fec']);
		$dolsun=$dt['tb_tipocambio_dolsun'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">
$( "#txt_tipcam_fec" ).datepicker({
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
$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.000',
	vMax: '9.999'
});

$(function() {
	
	$("#txt_tipcam_dolsun").focus();
	
	$("#for_tipcam").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../tipocambio/tipocambio_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_tipcam").serialize(),
				beforeSend: function(){
					$('#div_tipocambio_form').dialog("close");
					$('#msj_tipocambio').html("Guardando...");
					$('#msj_tipocambio').show(100);
				},
				success: function(data){
					
					$('#msj_tipocambio').html(data.tipcam_msj);
					<?php
					if($_POST['vista']=="cmb_tipcam_id")
					{
						echo $_POST['vista'].'(data.tipcam_id);';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="tipocambio_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			txt_tipcam_fec: {
				required: true,
				dateITA: true
			},
			txt_tipcam_dolsun: {
				required: true
			}
		},
		messages: {
			txt_tipcam_fec: {
				required: '*'
			},
			txt_tipcam_dolsun: {
				required: '*'
			}
		}
	});	
	
});
</script>
<form id="for_tipcam">
<input name="action_tipocambio" id="action_tipocambio" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tipcam_id" id="hdd_tipcam_id" type="hidden" value="<?php echo $_POST['tipcam_id']?>">
    <table>    	
    	<tr>        
    	  <td align="right" valign="top"><label for="txt_tipcam_fec">Fecha:</label></td>
    	  <td><input name="txt_tipcam_fec" class="fecha" id="txt_tipcam_fec" type="text" value="<?php echo $fec?>" size="10" maxlength="10"></td>
  	  </tr>
    	<tr>
            <td align="right" valign="top"><label for="txt_tipcam_dolsun">Dólar Sunat:</label></td>
          <td><input name="txt_tipcam_dolsun" type="text" class='moneda' id="txt_tipcam_dolsun" style="text-align:right" value="<?php echo $dolsun?>" size="8" maxlength="5"></td>
        </tr>       
     </table>
</form>