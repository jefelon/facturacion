<?php
require_once ("../../config/Cado.php");
require_once ("cCatalogo.php");
$oCatalogo = new cCatalogo();

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

$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.000',
	vMax: '9.999'
});

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_tipcam').focus();
	<?php }?>
	
	$("#for_cam").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "catalogo_precio_cambio_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_cam").serialize(),
				beforeSend: function() {
					$("#div_catalogo_precio_cambio_form" ).dialog( "close" );
					$('#msj_catalogo').html("Guardando...");
					$('#msj_catalogo').show(100);
				},
				success: function(data){						
					$('#msj_catalogo').html(data.msj);
				},
				complete: function(){
					catalogo_tabla();
				}
			});
		},
		rules: {
			txt_tipcam: {
				required: true
			}
		},
		messages: {
			txt_tipcam: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_cam">
<input name="action" id="action" type="hidden" value="<?php echo $_POST['action']?>">

    <table>
        <tr>
            <td align="right" valign="top"><label for="txt_tipcam">Tipo de Cambio:</label></td>
          <td><input name="txt_tipcam" type="text" class='moneda' id="txt_tipcam" style="text-align:right" value="<?php echo $tipcam?>" size="8" maxlength="5"></td>
        </tr>   
    </table>
</form>