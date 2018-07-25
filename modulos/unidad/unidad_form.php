<?php
require_once ("../../config/Cado.php");
require_once ("cUnidad.php");
$oUnidad = new cUnidad();

if($_POST['action']=="editar")
{
	$dts=$oUnidad->mostrarUno($_POST['uni_id']);
	$dt = mysql_fetch_array($dts);
		$uni_tip=$dt['tb_unidad_tip'];
		$uni_abr=$dt['tb_unidad_abr'];
		$uni_nom=$dt['tb_unidad_nom'];
	mysql_free_result($dts);
}
if($_POST['vista']=="cmb_cat_uni_bas" and $_POST['action']=="insertar")
{
	$disable_tipo=1;
	$uni_tip=1;
}

if($_POST['vista']=="cmb_cat_uni_id_bas" and $_POST['action']=="insertar")
{
	$disable_tipo=1;
	$uni_tip=1;
}

if($_POST['vista']=="cmb_cat_uni_alt" and $_POST['action']=="insertar")
{
	$disable_tipo=1;
	$uni_tip=2;
}

?>
<script type="text/javascript">

$(function() {
	
	$('#txt_uni_abr, #txt_uni_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_uni").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../unidad/unidad_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_uni").serialize(),
				beforeSend: function() {
					$("#div_unidad_form" ).dialog( "close" );
					$('#msj_unidad').html("Guardando...");
					$('#msj_unidad').show(100);
				},
				success: function(data){						
					$('#msj_unidad').html(data.uni_msj);
					<?php
					if($_POST['vista']=="cmb_cat_uni_bas")
					{
						echo $_POST['vista'].'(data.uni_id)';
					}
					
					if($_POST['vista']=="cmb_cat_uni_id_bas")
					{
						echo $_POST['vista'].'(data.uni_id)';
					}
					
					if($_POST['vista']=="cmb_cat_uni_alt")
					{
						echo $_POST['vista'].'(data.uni_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="unidad_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			cmb_uni_tip: {
				required: true
			},
			txt_uni_abr: {
				required: true
			},
			txt_uni_nom: {
				required: true
			}
		},
		messages: {
			cmb_uni_tip: {
				required: '*'
			},
			txt_uni_abr: {
				required: '*'
			},
			txt_uni_nom: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_uni">
<input name="action_unidad" id="action_unidad" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_uni_id" id="hdd_uni_id" type="hidden" value="<?php echo $_POST['uni_id']?>">
<input name="hdd_uni_tip" id="hdd_uni_tip" type="hidden" value="<?php echo $uni_tip?>">
    <table>
        <tr>
          <td align="right" valign="top"><label for="cmb_uni_tip">Tipo:</label></td>
          <td><select name="cmb_uni_tip" id="cmb_uni_tip" <?php if($disable_tipo==1)echo 'disabled'?>>
            <option value="">-</option>
            <option value="1" <?php if($uni_tip=='1')echo 'selected'?>>UNIDAD BASE</option>
            <option value="2" <?php if($uni_tip=='2')echo 'selected'?>>UNIDAD ALTERNATIVA</option>
          </select></td>
        </tr>
        <tr>
          <td align="right" valign="top"><label for="txt_uni_abr">Abreviatura:</label></td>
          <td>
          <input name="txt_uni_abr" type="text" id="txt_uni_abr" value="<?php echo $uni_abr?>" size="15" maxlength="10"></td>
        </tr>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_uni_nom" type="text" id="txt_uni_nom" value="<?php echo $uni_nom?>" size="35" maxlength="25"></td>
        </tr>
    </table>
</form>