<?php
require_once ("../../config/Cado.php");
require_once ("cMarca.php");
$oMarca = new cMarca();

if($_POST['action']=="editar")
{
	$dts=$oMarca->mostrarUno($_POST['mar_id']);
	$dt = mysql_fetch_array($dts);
		$mar_nom=$dt['tb_marca_nom'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_mar_nom').focus();
	<?php }?>
	
	$('#txt_mar_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_mar").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../marca/marca_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_mar").serialize(),
				beforeSend: function() {
					$("#div_marca_form" ).dialog( "close" );
					$('#msj_marca').html("Guardando...");
					$('#msj_marca').show(100);
				},
				success: function(data){						
					$('#msj_marca').html(data.mar_msj);
					<?php
					if($_POST['vista']=="cmb_mar_id")
					{
						echo $_POST['vista'].'(data.mar_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="marca_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_mar_nom: {
				required: true
			}
		},
		messages: {
			txt_mar_nom: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_mar">
<input name="action_marca" id="action_marca" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_mar_id" id="hdd_mar_id" type="hidden" value="<?php echo $_POST['mar_id']?>">
    <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_mar_nom" type="text" id="txt_mar_nom" value="<?php echo $mar_nom?>" size="55" maxlength="50"></td>
        </tr>
    </table>
</form>