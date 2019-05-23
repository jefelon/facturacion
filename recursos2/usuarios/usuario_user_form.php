<?php
require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();
require_once ("cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();


if($_POST['action']=="editar")
{
	$usu_id=$_POST['id'];
	$dts=$oUsuario->mostrarUno($_POST['id']);
	$dt = mysql_fetch_array($dts);
		$usugru		=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$nom		=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$use		=$dt['tb_usuario_use'];
		$ema		=$dt['tb_usuario_ema'];

	mysql_free_result($dts);
	
	$dts=$oUsuariodetalle->mostrarUno($_POST['id']);
	$dt = mysql_fetch_array($dts);
	
		$dni	=$dt['tb_usuario_dni'];

	mysql_free_result($dts);
}

?>

<script type="text/javascript">

//function
$(function() {
	
//formulario
	$("#for_usu_use").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "usuario_user_reg.php",
				async:true,
				dataType: "html",
				data: ({
					action: 	$('#user_action').val(),
					hdd_usu_id: $('#hdd_usu_id').val(),
					txt_use:	$('#txt_use').val()
		
				}),
				beforeSend: function() {
					$("#div_usuario_user_form" ).dialog( "close" );
					$('#msj_usuario').html("Guardando...");
			        $('#msj_usuario').show(100);
				},
				success: function(html){
					$('#msj_usuario').html(html);
				},
				complete: function(){			
					cargar_usuario_detalle();
				}
			});

		},
		rules: {
			txt_use: {
				required: true,
				minlength: 3,
				remote: "../usuarios/users.php"
			}
		},
		messages: {
			txt_use: {
				//remote: jQuery.format("El nombre de usuario: '{0}', no está disponible.")
				remote: "Nombre de usuario, no disponible."
			}
		}
	});

});

</script>
<div style="padding:2px">
	<strong><?php //echo $apepat.' '.$apemat.' '.$nom?></strong>
</div>
<form id="for_usu_use">
	<input name="user_action" id="user_action" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_POST['id']?>">
    <table align="left">
    <tr>
      <td>Nombre de Usuario: <strong><?php echo $use?></strong></td>
      </tr>
    <tr>
      <td align="right">&nbsp;</td>
      </tr>
    <tr>
    <td>Nuevo Nombre de usuario:</td>
    </tr>
    <tr>
      <td align="right"><input name="txt_use" type="text" id="txt_use" value="" size="30"></td>
      </tr>
    <tr>
      <td align="right">&nbsp;</td>
      </tr>

    </table>
</form>