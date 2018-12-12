<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once("../formatos/formato.php");


if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
	$mot="CANCELACION";

	$fecref = fecha_mysql($_POST['fec']);
	$fec=date('Y-m-d');//fecha generacion

	$dts = $oVenta->ultimo_numero($fec);
	$dt = mysql_fetch_array($dts);
	$num = $dt['ultimo_numero'] + 1;
	
	$cod = 'RA-'.str_replace('-','',$fec).'-'.str_pad($num, 3, "0", STR_PAD_LEFT);
}

if($_POST['action']=="editar"){

}
?>
<script type="text/javascript">



$(function(){
	
	$('#txt_combaj_mot').change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});

//formulario			
	$("#for_combaj").validate({
		submitHandler: function(){
			$.ajax({
				type: "POST",
				url: "../comunicacionbaja/combaja_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_combaj").serialize(),
				beforeSend: function(){
					//alert($("#for_combaj").serialize());
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
					combaja_tabla();
					venta_tabla();
				}
			});			
		},
		rules: {
			txt_combaj_mot: {
				required: true
			}
		},
		messages: {
			txt_combaj_mot: {
				required: '*'
			}
		}
	});
	
});
</script>
<div>
<form id="for_combaj">
<input name="action_combaja" id="action_combaja" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_combaj_fec" id="hdd_combaj_fec" type="hidden" value="<?php echo $_POST['fec']?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>Código:</td>
      <td align="left"><?php echo $cod?></td>
    </tr>
    <tr>
      <td>&nbsp</td>
      <td align="left"></td>
    </tr>
    <tr>
      <td><label for="txt_combaj_mot">Motivo de Anulación:</label></td>
      <td align="left">
      	<input type="text" name="txt_combaj_mot" id="txt_combaj_mot" value="<?php echo $mot?>" size="60">
      </td>
    </tr>
  </table>