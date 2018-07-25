<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once("../formatos/formato.php");


if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
	$mot="CANCELACION";

	$fecref = $_POST['fec'];
	$fec=date('Y-m-d');//fecha generacion

	$dts = $oVenta->ultimo_numero($fec);
	$dt = mysql_fetch_array($dts);
	$num = $dt['ultimo_numero'] + 1;
	$ruc="20479676861";
	
	$cod = $ruc.'-RF-'.str_replace('-','',$fecref).'-'.str_pad($num, 2, "0", STR_PAD_LEFT);
}

if($_POST['action']=="editar"){

}
?>
<script type="text/javascript">



$(function(){
	
	// $('#txt_con_mot').change(function()
	// {
	// 	$(this).val($(this).val().toUpperCase());
	// });

//formulario			
	$("#for_con").validate({
		submitHandler: function(){
			$.ajax({
				type: "POST",
				url: "../contingencia/contingencia_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_con").serialize(),
				beforeSend: function(){
					//alert($("#for_con").serialize());
					$('#div_venta_form').dialog("close");
					$('#msj_venta').html("Guardando...");
					$('#msj_venta').show(100);
				},
				success: function(data){
					$('#msj_venta').html(data.msj);
					//enviar_sunat(data.ven_id);
				},
				complete: function()
				{
					resumenboleta_tabla();
					venta_tabla();
				}
			});			
		},
		rules: {
			txt_con_mot: {
				required: true
			}
		},
		messages: {
			txt_con_mot: {
				required: '*'
			}
		}
	});
	
});
</script>
<div>
<form id="for_con">
<input name="action_con" id="action_con" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_con_fec" id="hdd_con_fec" type="hidden" value="<?php echo $_POST['fec']?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>Código:</td>
      <td align="left"><?php echo $cod?></td>
    </tr>
    <tr>
      <td>Motivo:</td>
      <td align="left">
      	<select name="cmb_con_mot" id="cmb_con_mot">
    		<option value="1">CONEXIÓN A INTERNET</option>
    		<option value="2">FALLAS FLUIDO ELÉCTRICO</option>
    		<option value="3">DESASTRES NATURALES</option>
    		<option value="4">ROBO</option>
    		<option value="5">FALLAS EN EL SISTEMA DE FACTURACIÓN</option>
    		<option value="7" selected>OTROS</option>
    	</select>
       </td>
    </tr>
    <tr>
      <td>&nbsp</td>
      <td align="left"></td>
    </tr>
  </table>