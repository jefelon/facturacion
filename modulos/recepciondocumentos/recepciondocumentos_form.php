<?php
require_once ("../../config/Cado.php");
require_once ("cRecepcionDocumentos.php");
$oRecepcionDocumentos = new cRecepcionDocumentos;

if($_POST['action']=="insertar") {
    $recdoc_fech = date('d-m-Y');
}

if($_POST['action']=="editar")
{
	$dts=$oRecepcionDocumentos->mostrarUno($_POST['recdoc_id']);
	$dt = mysql_fetch_array($dts);
	$recdoc_nom=$dt['tb_recepciondocumentos_nom'];
    $recnom_empresa=$dt['tb_recepciondocumentos_nom'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_recdoc_nom').focus();
	<?php }?>
	
	$('#txt_recdoc_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

    $( "#txt_recdoc_empresa" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_recdoc_empresa_id").val(ui.item.id);
            $("#txt_recnom_empresa").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_recdoc_empresa_id').change();
        }
    });

    $( "#txt_docpersentrega" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_perspentrega_id").val(ui.item.id);
            $("#txt_nompersentrega").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_perspentrega_id').change();
        }
    });

	$("#for_recdoc").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../recepciondocumentos/recepciondocumentos_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_recdoc").serialize(),
				beforeSend: function() {
					$("#div_recepciondocumentos_form" ).dialog( "close" );
					$('#msj_recepciondocumentos').html("Guardando...");
					$('#msj_recepciondocumentos').show(100);
				},
				success: function(data){						
					$('#msj_recepciondocumentos').html(data.mar_msj);
					<?php
					if($_POST['vista']=="cmb_recdoc_id")
					{
						echo $_POST['vista'].'(data.recdoc_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="recepciondocumentos_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_recdoc_nom: {
				required: true
			}
		},
		messages: {
			txt_recdoc_nom: {
				required: '*'
			}
		}
	});
    $( "#txt_recdoc_fech" ).datepicker({
        minDate: "-7D",
        maxDate:"+0D",
        yearRange: 'c-0:c+0',
        changeMonth: true,
        changeYear: false,
        dateFormat: 'dd-mm-yy',
        //altField: fecha,
        //altFormat: 'yy-mm-dd',
        showOn: "button",
        buttonImage: "../../images/calendar.gif",
        buttonImageOnly: true
    });
});
</script>
<form id="for_recdoc">
<input name="action_recepciondocumentos" id="action_recepciondocumentos" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_recdoc_id" id="hdd_recdoc_id" type="hidden" value="<?php echo $_POST['recdoc_id']?>">
<input name="hdd_recdoc_empresa_id" id="hdd_recdoc_empresa_id" type="hidden" value="<?php echo $_POST['recdoc_empresa_id']?>">
<input name="hdd_perspentrega_id" id="hdd_perspentrega_id" type="hidden" value="<?php echo $_POST['perspentrega_id']?>">
    <table>
        <tr>
            <td align="right" valign="top">Fecha:</td>
            <td><input name="txt_recdoc_fech" type="text" id="txt_recdoc_fech" value="<?php echo $recdoc_fech?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Empresa:</td>
            <td>
                <input name="txt_recdoc_empresa" type="text" id="txt_recdoc_empresa" value="<?php echo $recdoc_empresa?>" size="10" maxlength="11">
                <input name="txt_recnom_empresa" type="text" id="txt_recnom_empresa" value="<?php echo $recnom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Resp. Entrega:</td>
            <td>
                <input name="txt_docpersentrega" type="text" id="txt_docpersentrega" value="<?php echo $docpersentrega?>" size="10" maxlength="11">
                <input name="txt_nomperspentrega" type="text" id="txt_nompersentrega" value="<?php echo $nompersentrega?>" size="30">
            </td>
        </tr>
    </table>
</form>