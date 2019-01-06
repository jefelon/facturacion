<?php
require_once ("../../config/Cado.php");
require_once ("cAsiento.php");
$oAsiento = new cAsiento();

if($_POST['action']=="editar")
{
	$dts=$oAsiento->mostrarUno($_POST['asiento_id']);
	$dt = mysql_fetch_array($dts);
		$asiento_nom=$dt['tb_asiento_nom'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_asiento_nom').focus();
	<?php }?>
	
	$('#txt_asiento_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_asiento").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../asiento/asiento_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_asiento").serialize(),
				beforeSend: function() {
					$("#div_asiento_form" ).dialog( "close" );
					$('#msj_asiento').html("Guardando...");
					$('#msj_asiento').show(100);
				},
				success: function(data){						
					$('#msj_asiento').html(data.asiento_msj);
					<?php
					if($_POST['vista']=="cmb_asiento_id")
					{
						echo $_POST['vista'].'(data.asiento_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="asiento_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_asiento_nom: {
				required: true
			}
		},
		messages: {
			txt_asiento_nom: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_asiento">
<input name="action_asiento" id="action_asiento" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_asiento_id" id="hdd_asiento_id" type="hidden" value="<?php echo $_POST['asiento_id']?>">
    <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_asiento_nom" type="text" id="txt_asiento_nom" value="<?php echo $asiento_nom?>" size="55" maxlength="50"></td>
        </tr>
    </table>
</form>