<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cDeclaracionimpuestos.php");
$Declaracionimpuestos = new cDeclaracionimpuestos();

if($_POST['action']=="insertar") {
    $recdoc_fech = date('d-m-Y');
    $recdoc_fech = date('d-m-Y');

}

if($_POST['action']=="editar")
{
	$dts=$Declaracionimpuestos->mostrarUno($_POST['recepcion_id']);
	$dt = mysql_fetch_array($dts);
	$doc_empresa = $dt['tb_cliente_doc'];
    $nom_empresa = $dt['tb_cliente_nom'];
    $id_empresa = $dt['tb_cliente_id'];
    $fecha_declaracion = mostrarFecha($dt['tb_fecha_declaracion']);
    $fecha_vencimiento = mostrarFecha($dt['tb_fecha_vencimiento']);
    $fecha_envio = mostrarFecha($dt['tb_fecha_envio']);
    $estado_envio = $dt['	tb_estado_correo'];
    $pdt_nodeclarados = $dt['tb_pdt_nodeclarados'];
    $pago_realizado = $dt['tb_estadopago'];
    $deudas = $dt['tb_deudas'];
    $doc_persdecl = $dt['tb_persdecl_doc'];
    $nom_persdecl = $dt['tb_persdecl_nom'];
    $id_persdecl = $dt['tb_persdecl_id'];
    $observaciones = $dt['tb_observaciones'];

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

    $( "#txt_docrecepdocumentos" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_recepdocumentos_id").val(ui.item.id);
            $("#txt_nomrecepdocumentos").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_recepdocumentos_id').change();
        }
    });

    $( "#txt_docpersrecojo" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_docpersrecojo_id").val(ui.item.id);
            $("#txt_nompersrecojo").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_docpersrecojo_id').change();
        }
    });

	$("#for_recdoc").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../declaracionimpuestos/declaracionimpuestos_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_recdoc").serialize(),
				beforeSend: function() {
					$("#div_declaracionimpuestos_form" ).dialog( "close" );
					$('#msj_declaracionimpuestos').html("Guardando...");
					$('#msj_declaracionimpuestos').show(100);
				},
				success: function(data){						
					$('#msj_declaracionimpuestos').html(data.recdoc_msj);
					<?php
					if($_POST['vista']=="cmb_recdoc_id")
					{
						echo $_POST['vista'].'(data.recdoc_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="declaracionimpuestos_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
            txt_recnom_empresa: {
				required: true
			},
            txt_nomperspentrega: {
                required: true
            },
            txt_nomrecepdocumentos: {
                required: true
            },
            txt_nompersrecojo: {
                required: true
            }

		},
		messages: {
            txt_recnom_empresa: {
				required: '*'
			},
            txt_nomperspentrega: {
                required: '*'
            },
            txt_nomrecepdocumentos: {
                required: '*'
            },
            txt_nompersrecojo: {
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
<input name="action_declaracionimpuestos" id="action_declaracionimpuestos" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_declaracionimpuestos_id" id="hdd_declaracionimpuestos_id" type="hidden" value="<?php echo $_POST['recepcion_id'] ?>">
    <input name="hdd_empresa_id" id="hdd_empresa_id" type="hidden" value="<?php echo $id_empresa ?>">
    <input name="hdd_persdecl_id" id="hdd_persdecl_id" type="hidden" value="<?php echo $id_persdecl ?>">

    <table>
        <tr>
            <td align="right" valign="top">Empresa:</td>
            <td>
                <input name="txt_doc_empresa" type="text" id="txt_doc_empresa" value="<?php echo $doc_empresa?>" size="10" maxlength="11">
                <input name="txt_nom_empresa" type="text" id="txt_nom_empresa" value="<?php echo $nom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Declaración:</td>
            <td><input name="txt_fecha_declaracion" type="text" id="txt_fecha_declaracion" value="<?php echo $fecha_declaracion?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Vencimiento:</td>
            <td><input name="txt_fecha_vencimiento" type="text" id="txt_fecha_vencimiento"
                       value="<?php echo $fecha_vencimiento?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Envio Correo:</td>
            <td><input name="txt_fecha_envio" type="text" id="txt_fecha_envio" value="<?php echo $fecha_envio?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Estado Envio:</td>
            <td>
                <select name="cmb_estado_envio" id="cmb_estado_envio">
                    <option value="1"<?php if($estado_envio==True)echo 'selected'?>>Enviado</option>
                    <option value="0"<?php if($estado_envio==False)echo 'selected'?>>Pendiente</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">PDT No declarados:</td>
            <td>
                <input name="txt_pdt_nodeclarados" type="text" id="txt_pdt_nodeclarados" value="<?php echo $pdt_nodeclarados?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Pago Realizado:</td>
            <td>
                <select name="cmb_pago_realizado" id="cmb_pago_realizado">
                    <option value="1"<?php if($pago_realizado==True)echo 'selected'?>>Efectuado</option>
                    <option value="0"<?php if($pago_realizado==False)echo 'selected'?>>Pendiente</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Deudas pendientes:</td>
            <td>
                <input name="txt_deudas" type="text" id="txt_deudas" value="<?php echo $deudas?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Responsable de la Declaración:</td>
            <td>
                <input name="txt_docpersdecl" type="text" id="txt_docpersdecl" value="<?php echo $doc_persdecl?>" size="10" maxlength="11">
                <input name="txt_docpersdecl" type="text" id="txt_nompersdecl" value="<?php echo $nom_persdecl?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Observaciones:</td>
            <td>
                <textarea name="txt_observaciones" type="textarea" id="txt_observaciones" rows="4" cols="50" maxlength="300"><?php echo $observaciones?></textarea>
            </td>
        </tr>
    </table>
</form>