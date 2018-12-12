<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cAlmacen.php");
$oAlmacen = new cAlmacen();

if($_POST['action']=="editar")
{
	$dts=$oAlmacen->mostrarUno($_POST['alm_id']);
	$dt = mysql_fetch_array($dts);
		$alm_nom=$dt['tb_almacen_nom'];
		$alm_ven=$dt['tb_almacen_ven'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	$('#txt_alm_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_alm").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "almacen_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_alm").serialize(),
				beforeSend: function() {
					$("#div_almacen_form" ).dialog( "close" );
					$('#msj_almacen').html("Guardando...");
					$('#msj_almacen').show(100);
				},
				success: function(html){						
					$('#msj_almacen').html(html);
				},
				complete: function(){
					<?php
					if($_POST['vista']=="almacen_tabla")
					{
						echo $_POST['vista'].'()';
					}
					
					if($_POST['vista']=="cmb_alm_id")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_alm_nom: {
				required: true
			}
		},
		messages: {
			txt_alm_nom: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_alm">
<input name="action_almacen" id="action_almacen" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_alm_id" id="hdd_alm_id" type="hidden" value="<?php echo $_POST['alm_id']?>">
    <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_alm_nom" type="text" id="txt_alm_nom" value="<?php echo $alm_nom?>" size="55" maxlength="50"></td>
        </tr>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td><input name="chk_alm_ven" type="checkbox" id="chk_alm_ven" value="1" <?php if($alm_ven==1)echo 'checked'?>>
          <label for="chk_alm_ven">Para ventas</label></td>
        </tr>
    </table>
</form>