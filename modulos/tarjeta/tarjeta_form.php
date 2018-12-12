<?php
require_once ("../../config/Cado.php");
require_once ("cTarjeta.php");
$oTarjeta = new cTarjeta();

if($_POST['action']=="editar")
{
	$dts=$oTarjeta->mostrarUno($_POST['tar_id']);
	$dt = mysql_fetch_array($dts);
		$tar_nom	=$dt['tb_tarjeta_nom'];
		$caj_id		=$dt['tb_caja_id'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

function cmb_caj_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../caja/cmb_caj_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			caj_id: ids
		}),
		beforeSend: function() {
			$('#cmb_caj_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_caj_id').html(html);
		}
	});
}

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_tar_nom').focus();
	<?php }?>

	cmb_caj_id(<?php echo $caj_id?>);
	
	$('#txt_tar_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_tar").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../tarjeta/tarjeta_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_tar").serialize(),
				beforeSend: function() {
					$("#div_tarjeta_form" ).dialog( "close" );
					$('#msj_tarjeta').html("Guardando...");
					$('#msj_tarjeta').show(100);
				},
				success: function(data){						
					$('#msj_tarjeta').html(data.tar_msj);
					<?php
					if($_POST['vista']=="cmb_tar_id")
					{
						echo $_POST['vista'].'(data.tar_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="tarjeta_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_tar_nom: {
				required: true
			},
			cmb_caj_id: {
				required: true
			}
		},
		messages: {
			txt_tar_nom: {
				required: '*'
			},
			cmb_caj_id: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_tar">
<input name="action_tarjeta" id="action_tarjeta" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tar_id" id="hdd_tar_id" type="hidden" value="<?php echo $_POST['tar_id']?>">
    <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_tar_nom" type="text" id="txt_tar_nom" value="<?php echo $tar_nom?>" size="55" maxlength="50"></td>
        </tr>
        <tr>
          	<td align="right"><label for="cmb_caj_id">Caja:</label></td>
      		<td>
        		<select name="cmb_caj_id" id="cmb_caj_id">
        		</select>
        	</td>
        </tr>
    </table>
</form>