<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTipoperacion.php");
$oTipoperacion = new cTipoperacion();

if($_POST['action']=="editar")
{
	$dts=$oTipoperacion->mostrarUno($_POST['tipope_id']);
	$dt = mysql_fetch_array($dts);
		$tipope_nom=$dt['tb_tipoperacion_nom'];
		$tipope_tip=$dt['tb_tipoperacion_tip'];
		$tipope_man=$dt['tb_tipoperacion_man'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	$('#txt_tipope_nom').focus();
	
	$('#txt_tipope_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_tipope").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../tipoperacion/tipoperacion_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_tipope").serialize(),
				beforeSend: function() {
					$("#div_tipoperacion_form" ).dialog( "close" );
					$('#msj_tipoperacion').html("Guardando...");
					$('#msj_tipoperacion').show(100);
				},
				success: function(html){						
					$('#msj_tipoperacion').html(html);
				},
				complete: function(){
					<?php
					if($_POST['vista']=="tipoperacion_tabla")
					{
						echo $_POST['vista'].'()';
					}
					
					if($_POST['vista']=="cmb_tipope_id")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_tipope_nom: {
				required: true
			},
			cmb_tip: {
				required: true
			}
		},
		messages: {
			txt_tipope_nom: {
				required: '*'
			},
			cmb_tip: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_tipope">
<input name="action_tipoperacion" id="action_tipoperacion" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tipope_id" id="hdd_tipope_id" type="hidden" value="<?php echo $_POST['tipope_id']?>">
    <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_tipope_nom" type="text" id="txt_tipope_nom" value="<?php echo $tipope_nom?>" size="55" maxlength="50"></td>
        </tr>
        <tr>
          <td align="right" valign="top"><label for="cmb_tip">Tipo:</label></td>
          <td valign="top"><select name="cmb_tip" id="cmb_tip">
            <option value="">-</option>
            <option value="1" <?php if($tipope_tip==1)echo 'selected'?>>ENTRADA (Aumentar Stock)</option>
            <option value="2" <?php if($tipope_tip==2)echo 'selected'?>>SALIDA (Disminuir Stock)</option>
          </select></td>
        </tr>
        <?php /*?>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td valign="top"><input name="chk_tipope_man" type="checkbox" id="chk_tipope_man" value="1" <?php if($tipope_man==1)echo 'checked'?>>
          <label for="chk_tipope_man">Manual</label></td>
        </tr>
        <?php */?>
    </table>
</form>