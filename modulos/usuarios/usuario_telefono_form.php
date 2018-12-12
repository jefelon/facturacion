<?php
require_once ("../../config/Cado.php");
require_once ("cTelefono.php");
$oTelefono = new cTelefono();

if($_POST['action']=="editar")
{
	$dts=$oTelefono->mostrarUno($_POST['id']);
	$dt = mysql_fetch_array($dts);
		$tip=$dt['tb_telefono_tip'];
		$ope=$dt['tb_telefono_ope'];
		$num=$dt['tb_telefono_num'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">
$(function() {

	$("#for_tel").validate({
		
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "usuario_telefono_reg.php",
				async:true,
				dataType: "html",
				data: ({
					action:			$('#action_telefono').val(),
					hdd_tel_id:		$('#hdd_tel_id').val(),
					cmb_tel_tip:	$('#cmb_tel_tip').val(),
					cmb_tel_ope:	$('#cmb_tel_ope').val(),
					txt_tel_num:	$('#txt_tel_num').val(),
					hdd_usu_id:		$('#hdd_usu_id').val()
				}),
				beforeSend: function() {
					$("#div_usuario_telefono_form" ).dialog( "close" );
				},
				success: function(html){
					$('#for_tel').each (function(){this.reset();});
				},
				complete: function(){
					cargar_usuario_telefono_tabla();
				}
			});
		},
		rules: {
			cmb_tel_tip: {
				required: true
			},
			cmb_tel_ope: {
				required: true
			},
			txt_tel_num: {
				required: true,
				//minlength: 6,
				//digits: true
			}
		},
		messages: {
			cmb_tel_tip: {
				//remote: jQuery.format("El nombre de usuario: '{0}', no está disponible.")
				//remote: "Este nombre de usuario, no está disponible."
			},
			cmb_tel_ope: {
				//minlength: "Por favor, escriba la misma contraseña.",
				//equalTo: "Por favor, escriba la misma contraseña."
			},
			txt_tel_num: {
				//required: "Por favor, escriba nuevamente la contraseña."
			}
		}
	});
	
});
</script>
<form id="for_tel">
<input name="action_telefono" id="action_telefono" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tel_id" id="hdd_tel_id" type="hidden" value="<?php echo $_POST['id']?>">
    <table align="center">
        <tr>
          <td align="right"><label for="cmb_tel_tip">Tipo:</label></td>
          <td><select name="cmb_tel_tip" id="cmb_tel_tip" tabindex="1">
            <option value="Fijo"<?php if($tip=='Fijo') echo 'selected'?>>Fijo</option>
            <option value="Móvil"<?php if($tip=='Móvil') echo 'selected'?>>Móvil</option>
            <option value="Red Privada"<?php if($tip=='Red Privada') echo 'selected'?>>Red Privada</option>
          </select></td>
        </tr>
        <tr>
          <td align="right"><label for="cmb_tel_ope">Operador:</label></td>
          <td><select name="cmb_tel_ope" id="cmb_tel_ope" tabindex="2">
            <option value="Movistar"<?php if($ope=='Movistar') echo 'selected'?>>Movistar</option>
            <option value="Claro"<?php if($ope=='Claro') echo 'selected'?>>Claro</option>
            <option value="Nextel"<?php if($ope=='Nextel') echo 'selected'?>>Nextel</option>
          </select></td>
        </tr>
        <tr>
          <td align="right">Número:</td>
          <td><input name="txt_tel_num" type="text" id="txt_tel_num" tabindex="3" value="<?php echo $num?>"></td>
        </tr>
    </table>
</form>