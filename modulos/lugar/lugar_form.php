<?php
require_once ("../../config/Cado.php");
require_once ("cLugar.php");
$oLugar = new cLugar();

if($_POST['action']=="editar")
{
	$dts=$oLugar->mostrarUno($_POST['lugar_id']);
	$dt = mysql_fetch_array($dts);
		$lugar_nom=$dt['tb_lugar_nom'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_lugar_nom').focus();
	<?php }?>
	
	// $('#txt_lugar_nom').keyup(function(){
	// 	$(this).val($(this).val().toUpperCase());
	// });

	$("#for_lugar").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../lugar/lugar_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_lugar").serialize(),
				beforeSend: function() {
					$("#div_lugar_form" ).dialog( "close" );
					$('#msj_lugar').html("Guardando...");
					$('#msj_lugar').show(100);
				},
				success: function(data){						
					$('#msj_lugar').html(data.lugar_msj);
					<?php
					if($_POST['vista']=="cmb_lugar_id")
					{
						echo $_POST['vista'].'(data.lugar_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="lugar_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_lugar_nom: {
				required: true
			}
		},
		messages: {
			txt_lugar_nom: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_lugar">
<input name="action_lugar" id="action_lugar" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_lugar_id" id="hdd_lugar_id" type="hidden" value="<?php echo $_POST['lugar_id']?>">
    <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_lugar_nom" type="text" id="txt_lugar_nom" value="<?php echo $lugar_nom?>" size="55" maxlength="50"></td>
        </tr>
    </table>
</form>