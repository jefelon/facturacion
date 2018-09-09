<?php
require_once ("../../config/Cado.php");
require_once ("cPrecio.php");
$oPrecio = new cPrecio();

if($_POST['action']=="editar")
{
	$dts=$oPrecio->mostrarUno($_POST['precio_id']);
	$dt = mysql_fetch_array($dts);
		$precio_nom=$dt['tb_precio_nom'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_precio_nom').focus();
	<?php }?>
	
	$('#txt_precio_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_precio").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "precio_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_precio").serialize(),
				beforeSend: function() {
					$("#div_precio_form" ).dialog( "close" );
					$('#msj_precio').html("Guardando...");
					$('#msj_precio').show(100);
				},
				success: function(data){						
					$('#msj_precio').html(data.precio_msj);
					<?php
					if($_POST['vista']=="cmb_precio_id")
					{
						echo $_POST['vista'].'(data.precio_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="precio_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_precio_nom: {
				required: true
			}
		},
		messages: {
			txt_precio_nom: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_precio">
<input name="action_precio" id="action_precio" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_precio_id" id="hdd_precio_id" type="hidden" value="<?php echo $_POST['precio_id']?>">
    <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_precio_nom" type="text" id="txt_precio_nom" value="<?php echo $precio_nom?>" size="55" maxlength="50"></td>
        </tr>
    </table>
</form>