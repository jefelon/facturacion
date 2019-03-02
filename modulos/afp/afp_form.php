<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cAfp.php");
$oAfp = new cComisionista();

if($_POST['action']=="insertar") {
    $recdoc_fech = date('d-m-Y');
}

if($_POST['action']=="editar")
{
	$dts=$oAfp->mostrarUno($_POST['afp_id']);
	$dt = mysql_fetch_array($dts);
    $recid_empresa = $dt['tb_cliente_id'];
    $recdoc_empresa = $dt['tb_cliente_doc'];
    $recnom_empresa = $dt['tb_cliente_nom'];
    $recdoc_fech = mostrarFecha($dt['tb_fecha_declaracion']);
    $recdoc_fech_ven = mostrarFecha($dt['tb_fecha_vencimiento']);
    $fecha_envio = $dt['tb_fecha_envio'];
    $estado_correo = $dt['tb_estado_correo'];
    $afp_nodeclarados = $dt['tb_afp_nodeclarados'];
    $afp_estadopago = $dt['tb_afp_estadopago'];
    $afp_deudas = $dt['tb_afp_deudas'];
    $docpersdecl = $dt['tb_persdecl_doc'];
    $nompersdecl = $dt['tb_persdecl_nom'];
    $idpersdecl = $dt['tb_persdecl_id'];
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

    $( "#txt_docpersdecl" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_persdecl_id").val(ui.item.id);
            $("#txt_nompersdecl").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_perspdecl_id').change();
        }
    });



	$("#for_recdoc").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../afp/afp_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_recdoc").serialize(),
				beforeSend: function() {
					$("#div_declaraciondocumentos_form" ).dialog( "close" );
					$('#msj_declaraciondocumentos').html("Guardando...");
					$('#msj_declaraciondocumentos').show(100);
				},
				success: function(data){						
					$('#msj_declaraciondocumentos').html(data.decldoc_msj);
					<?php
					if($_POST['vista']=="cmb_decldoc_id")
					{
						echo $_POST['vista'].'(data.decldoc_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="declaraciondocumentos_tabla")
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
    $( "#txt_fech_decl,#txt_fech_ven,#txt_fech_envio" ).datepicker({
        minDate: "-1Y",
        maxDate:"+2Y",
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
<input name="action_afp" id="action_afp" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_afp_id" id="hdd_afp_id" type="hidden" value="<?php echo $_POST['afp_id'] ?>">
    <input name="hdd_recdoc_empresa_id" id="hdd_recdoc_empresa_id" type="hidden" value="<?php echo $recid_empresa ?>">
    <input name="hdd_persdecl_id" id="hdd_persdecl_id" type="hidden" value="<?php echo $idpersdecl ?>">

    <table>
        <tr>
            <td align="right" valign="top">Empresa:</td>
            <td>
                <input name="txt_recdoc_empresa" type="text" id="txt_recdoc_empresa" value="<?php echo $recdoc_empresa?>" size="10" maxlength="11">
                <input name="txt_recnom_empresa" type="text" id="txt_recnom_empresa" value="<?php echo $recnom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Declaración:</td>
            <td><input name="txt_fech_decl" type="text" id="txt_fech_decl" value="<?php echo $recdoc_fech?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Vencimiento:</td>
            <td><input name="txt_fech_ven" type="text" id="txt_fech_ven" value="<?php echo $recdoc_fech_ven?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Envio Correo:</td>
            <td><input name="txt_fech_envio" type="text" id="txt_fech_envio" value="<?php echo $fecha_envio?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Estado Envio:</td>
            <td>
                <select name="cmb_estado_envio" id="cmb_estado_envio">
                    <option value="1"<?php if($estado_correo==True)echo 'selected'?>>Enviado</option>
                    <option value="0"<?php if($estado_correo==False)echo 'selected'?>>Pendiente</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">AFP No declarados:</td>
            <td>
                <input name="txt_afp_decl" type="text" id="txt_afp_decl" value="<?php echo $afp_nodeclarados?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Pago Realizado:</td>
            <td>
                <select name="cmb_pago_realizado" id="cmb_pago_realizado">
                    <option value="1"<?php if($afp_estadopago==True)echo 'selected'?>>Efectuado</option>
                    <option value="0"<?php if($afp_estadopago==False)echo 'selected'?>>Pendiente</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Deudas pendientes:</td>
            <td>
                <input name="txt_deudas" type="text" id="txt_deudas" value="<?php echo $afp_deudas?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Resp. Declaración:</td>
            <td>
                <input name="txt_docpersdecl" type="text" id="txt_docpersdecl" value="<?php echo $docpersdecl?>" size="10" maxlength="11">
                <input name="txt_docpersdecl" type="text" id="txt_nompersdecl" value="<?php echo $nompersdecl?>" size="30">
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