<?php
require_once ("../../config/Cado.php");
require_once ("cCuentacorriente.php");
$oCuentacorriente = new cCuentacorriente();

if($_POST['action']=="editar")
{
	$dts=$oCuentacorriente->mostrarUno($_POST['cuecor_id']);
	$dt = mysql_fetch_array($dts);
		$cuecor_nom	=$dt['tb_cuentacorriente_nom'];
		$caj_id	=$dt['tb_caja_id'];
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
	$('#txt_cuecor_nom').focus();
	<?php }?>

	cmb_caj_id(<?php echo $caj_id?>);
	
	$('#txt_cuecor_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_cuecor").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../cuentacorriente/cuentacorriente_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_cuecor").serialize(),
				beforeSend: function() {
					$("#div_cuentacorriente_form" ).dialog( "close" );
					$('#msj_cuentacorriente').html("Guardando...");
					$('#msj_cuentacorriente').show(100);
				},
				success: function(data){						
					$('#msj_cuentacorriente').html(data.cuecor_msj);
					<?php
					if($_POST['vista']=="cmb_cuecor_id")
					{
						echo $_POST['vista'].'(data.cuecor_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="cuentacorriente_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_cuecor_nom: {
				required: true
			},
			cmb_caj_id: {
				required: true
			}
		},
		messages: {
			txt_cuecor_nom: {
				required: '*'
			},
			cmb_caj_id: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_cuecor">
<input name="action_cuentacorriente" id="action_cuentacorriente" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_cuecor_id" id="hdd_cuecor_id" type="hidden" value="<?php echo $_POST['cuecor_id']?>">
    <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_cuecor_nom" type="text" id="txt_cuecor_nom" value="<?php echo $cuecor_nom?>" size="55" maxlength="50"></td>
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