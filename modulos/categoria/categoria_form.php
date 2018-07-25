<?php
require_once ("../../config/Cado.php");
require_once ("cCategoria.php");
$oCategoria = new cCategoria();

if($_POST['action']=="editar")
{
	$dts=$oCategoria->mostrarUno($_POST['cat_id']);
	$dt = mysql_fetch_array($dts);
		$cat_nom=$dt['tb_categoria_nom'];
		$cat_idp=$dt['tb_categoria_idp'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">
function cmb_cat_idp()
{	
	$.ajax({
		type: "POST",
		url: "../categoria/cmb_cat_idp.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id: "<?php echo $_POST['cat_id']?>",
			cat_idp: "<?php echo $cat_idp?>"
		}),
		beforeSend: function() {
			$('#cmb_cat_idp').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cat_idp').html(html);
		}
	});
}

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_cat_nom').focus();
	<?php }?>
	
	$('#txt_cat_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});
	
	cmb_cat_idp();

	$("#for_cat").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../categoria/categoria_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_cat").serialize(),
				beforeSend: function() {
					$("#div_categoria_form" ).dialog( "close" );
					$('#msj_categoria').html("Guardando...");
					$('#msj_categoria').show(100);
				},
				success: function(data){						
					$('#msj_categoria').html(data.cat_msj);
					<?php
					if($_POST['vista']=="cmb_cat_id")
					{
						echo $_POST['vista'].'(data.cat_id);';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="categoria_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_cat_nom: {
				required: true
			}
		},
		messages: {
			txt_cat_nom: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_cat">
<input name="action_categoria" id="action_categoria" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_cat_id" id="hdd_cat_id" type="hidden" value="<?php echo $_POST['cat_id']?>">
    <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_cat_nom" type="text" id="txt_cat_nom" value="<?php echo $cat_nom?>" size="55" maxlength="50"></td>
        </tr>
        <tr>
          <td align="right"><label for="cmb_cat_idp">Categoría Padre:</label></td>
          <td><select name="cmb_cat_idp" id="cmb_cat_idp">
          </select></td>
        </tr>
    </table>
</form>