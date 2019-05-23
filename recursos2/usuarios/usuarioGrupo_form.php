<?php
require_once ("../../config/Cado.php");
require_once ("cUsuariogrupo.php");
$oUsuariogrupo = new cUsuariogrupo();

if($_POST['action']=="editar")
{
	$dts=$oUsuariogrupo->mostrarUno($_POST['id']);
	$dt = mysql_fetch_array($dts);
		$nom=$dt['tb_usuariogrupo_nom'];
		$des=$dt['tb_usuariogrupo_des'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">
$(function() {

	$("#for_usugru").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "usuarioGrupo_reg.php",
				async:true,
				dataType: "html",
				data: ({
					action:				$('#action').val(),
					hdd_usugru_id:		$('#hdd_usugru_id').val(),
					txt_usugru_nom:		$('#txt_usugru_nom').val(),
					txt_usugru_des:		$('#txt_usugru_des').val()		
				}),
				success: function(html){
					$("#i_loader" ).dialog( "open" );
					$('#i_loader').html(html);
					$("#i_loader" ).dialog( "close" );
					$('#for_usugru').each (function(){this.reset();});
					$("#div_usuarioGrupo_form" ).dialog( "close" );
				}
			});
			//$( "#i_loader" ).dialog( "open" );                  
			//return false;
		},
		rules: {
			txt_usugru_nom: {
				required: true,
				minlength: 3
			},
			txt_usugru_des:{
				required: false
			}
		}
	});
	
	/*$( "#btn_cancelar" ).button().click(function() {
		$( "#div_usuarioGrupo_form" ).dialog( "close" );
	});*/
	
});
</script>
<form id="for_usugru">
<input name="action" id="action" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_usugru_id" id="hdd_usugru_id" type="hidden" value="<?php echo $_POST['id']?>">
    <table align="center">
        <tr>
        <td align="right">Nombre:</td>
        <td><input name="txt_usugru_nom" id="txt_usugru_nom" type="text" value="<?php echo $nom?>" size="50" maxlength="50" tabindex="1"></td>
        </tr>
        <tr>
        <td align="right" valign="top">Descripción:</td>
        <td><textarea name="txt_usugru_des" cols="50" rows="2" id="txt_usugru_des" tabindex="2"><?php echo $des?></textarea></td>
        </tr>
    </table>
<!--<input type="submit" name="btn_guardar" id="btn_guardar" value="Guardar">
<input name="btn_cancelar" type="button" id="btn_cancelar" value="Cancelar">  -->
<!--<input type="reset" name="btn_limpiar" id="btn_limpiar" value="Limpiar">-->
</form>