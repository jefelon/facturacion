<?php
require_once ("../../config/Cado.php");
require_once ("cDocumento.php");
$oDocumento = new cDocumento();

if($_POST['action']=="editar")
{
	$dts=$oDocumento->mostrarUno($_POST['doc_id']);
	$dt = mysql_fetch_array($dts);
		$doc_tip=$dt['tb_documento_tip'];
		$doc_abr=$dt['tb_documento_abr'];
		$doc_nom=$dt['tb_documento_nom'];
		$doc_def=$dt['tb_documento_def'];
		$doc_mos=$dt['tb_documento_mos'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {

	$("#txt_doc_abr, #txt_doc_nom").keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_doc").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../documento/documento_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_doc").serialize(),
				beforeSend: function() {
					$("#div_documento_form" ).dialog( "close" );
					$('#msj_documento').html("Guardando...");
					$('#msj_documento').show(100);
				},
				success: function(html){						
					$('#msj_documento').html(html);
				},
				complete: function(){
					documento_tabla();
				}
			});
		},
		rules: {
			cmb_doc_tip: {
				required: true
			},
			txt_doc_abr: {
				required: true
			},
			txt_doc_nom: {
				required: true
			}
		},
		messages: {
			cmb_doc_tip: {
				required: '*'
			},
			txt_doc_abr: {
				required: '*'
			},
			txt_doc_nom: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_doc">
<input name="action_documento" id="action_documento" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_doc_id" id="hdd_doc_id" type="hidden" value="<?php echo $_POST['doc_id']?>">
    <table>
        <tr>
          <td align="right" valign="top"><label for="cmb_doc_tip">Mostrar en:</label></td>
          <td><select name="cmb_doc_tip" id="cmb_doc_tip">
            <option value="">-</option>
            <option value="1" <?php if($doc_tip=='1')echo 'selected'?>>COMPRAS</option>
            <option value="2" <?php if($doc_tip=='2')echo 'selected'?>>VENTAS</option>
            <option value="3" <?php if($doc_tip=='3')echo 'selected'?>>NOTA DE VENTA</option>
            <option value="4" <?php if($doc_tip=='4')echo 'selected'?>>NOTA DE ALMACEN</option>
            <option value="5" <?php if($doc_tip=='5')echo 'selected'?>>TRANSFERENCIA</option>
                  <option value="9" <?php if($doc_tip=='9')echo 'selected'?>>NOTA DE CREDITO</option>
                  <option value="10" <?php if($doc_tip=='10')echo 'selected'?>>NOTA DE DEBITO</option>
<!--                  <option value="11" --><?php //if($doc_tip=='11')echo 'selected'?><!-->COTIZACIÓN</option>-->
          </select></td>
        </tr>
        <tr>
          <td align="right" valign="top"><label for="txt_doc_abr">Abreviatura:</label></td>
          <td>
          <input name="txt_doc_abr" type="text" id="txt_doc_abr" value="<?php echo $doc_abr?>" size="15" maxlength="10"></td>
        </tr>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_doc_nom" type="text" id="txt_doc_nom" value="<?php echo $doc_nom?>" size="35" maxlength="30"></td>
        </tr>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td><input name="chk_doc_def" type="checkbox" id="chk_doc_def" value="1" <?php if($doc_def==1)echo 'checked'?>>
          <label for="chk_doc_def">Mostrar por defecto</label></td>
        </tr>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td><input name="chk_doc_mos" type="checkbox" id="chk_doc_mos" value="1" <?php if($doc_mos==1)echo 'checked'?>>
          <label for="chk_doc_mos">Disponible Para Ventas</label></td>
        </tr>
    </table>
</form>