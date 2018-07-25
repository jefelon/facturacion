<?php
require_once ("../../config/Cado.php");
require_once ("../notalmacen/cNotalmacendetalle.php");
$oNotalmacendetalle = new cNotalmacendetalle();

require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	//$fec=date('d-m-Y');
}

if($_POST['action']=="editar"){
	$dts= $oNotalmacendetalle->mostrarUno($_POST['notalmdet_id']);
	$dt = mysql_fetch_array($dts);
		$docnom	=$dt['tb_documento_nom'];
		$numdoc	=$dt['tb_notalmacen_cod'];
		
		$can	=$dt['tb_notalmacendetalle_can'];
		$cos	=$dt['tb_notalmacendetalle_cos'];
		$pre	=$dt['tb_notalmacendetalle_pre'];

	mysql_free_result($dts);
}
?>
<script type="text/javascript">
$('.cantidad_nad').autoNumeric({
	aSep: '',
	aDec: '.',
	vMin: '0',
	vMax: '99999'
});
$('.moneda_nad').autoNumeric({
	aSep: ',',
	aDec: '.',
	vMin: '0.00',
	vMax: '99999.00'
});
$(function() {

//formulario			
	$("#for_notalm_det").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../notalmacen/notalmacen_detalle_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_notalm_det").serialize(),
				beforeSend: function(){
					$('#div_notalmacen_detalle_form').dialog("close");
					$('#msj_notalmacen').html("Guardando...");
					$('#msj_notalmacen').show(100);
				},
				success: function(data){
					$('#msj_notalmacen').html(data.notalm_msj);
				},
				complete: function(){
					historial_tabla();
				}
			});			
		},
		rules: {
			txt_notalmdet_can: {
				required: true
			},
			txt_notalmdet_cos: {
				required: true
			},
			txt_notalmdet_pre: {
				required: true
			}
		},
		messages: {
			txt_notalmdet_can: {
				required: '*'
			},
			txt_notalmdet_cos: {
				required: '*'
			},
			txt_notalmdet_pre: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_notalm_det">
<input name="action_notalmacen_detalle" id="action_notalmacen_detalle" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_notalmdet_id" id="hdd_notalmdet_id" type="hidden" value="<?php echo $_POST['notalmdet_id']?>">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">Documento: </td>
    <td><?php echo $docnom?></td>
    <td align="right">N° Doc: </td>
    <td><?php echo $numdoc?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><label for="txt_notalmdet_can">Cantidad:</label></td>
    <td><input class="cantidad_nad" name="txt_notalmdet_can" type="text" id="txt_notalmdet_can" size="10" maxlength="10" value="<?php echo $can?>" style="text-align:right;"></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td align="right"><label for="txt_notalmdet_cos">P. Costo:</label></td>
    <td><input class="moneda_nad" name="txt_notalmdet_cos" type="text" id="txt_notalmdet_cos" size="15" maxlength="15" value="<?php echo formato_money($cos)?>" style="text-align:right;"></td>
    <td align="right"><label for="txt_notalmdet_pre">P. Venta:</label></td>
    <td><input class="moneda_nad" name="txt_notalmdet_pre" type="text" id="txt_notalmdet_pre" size="15" maxlength="15" value="<?php echo formato_money($pre)?>" style="text-align:right;"></td>
    </tr>
</table>
</form>