<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cLegalizacionlibros.php");
$oLegalizacionlibros = new cLegalizacionlibros();

if($_POST['action']=="insertar") {
    $recdoc_fech = date('d-m-Y');
}

if($_POST['action']=="editar")
{
	$dts=$oLegalizacionlibros->mostrarUno($_POST['recepcion_id']);
	$dt = mysql_fetch_array($dts);
    $recdoc_fech = mostrarFecha($dt['tb_recepciondocumentos_fecha']);
    $id_empresa = $dt['tb_cliente_id'];
    $doc_empresa = $dt['tb_cliente_doc'];
    $nom_empresa = $dt['tb_cliente_nom'];
    $docpersentrega = $dt['tb_persentrega_doc'];
    $nompersentrega = $dt['tb_persentrega_nom'];
    $idpersentrega = $dt['tb_persentrega_id'];
    $docrecepdocumentos = $dt['tb_persrecepcion_doc'];
    $nomrecepdocumentos = $dt['tb_persrecepcion_nom'];
    $idrecepdocumentos = $dt['tb_persrecepcion_id'];
    $docpersrecojo = $dt['tb_persrecoge_doc'];
    $nompersrecojo = $dt['tb_persrecoge_nom'];
    $idpersrecojo = $dt['tb_persrecoge_id'];
    $pendiente = $dt['tb_recepciondocumentos_pendientes'];
    $observaciones = $dt['tb_recepciondocumentos_observacion'];

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
					$('#msj_recepciondocumentos').html(data.recdoc_msj);
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
<input name="action_afp" id="action_afp" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_afp_id" id="hdd_afp_id" type="hidden" value="<?php echo $_POST['recepcion_id'] ?>">
    <input name="hdd_recdoc_empresa_id" id="hdd_recdoc_empresa_id" type="hidden" value="<?php echo $recid_empresa ?>">
    <input name="hdd_perspentrega_id" id="hdd_perspentrega_id" type="hidden" value="<?php echo $idpersentrega ?>">
    <input name="hdd_recepdocumentos_id" id="hdd_recepdocumentos_id" type="hidden" value="<?php echo $idrecepdocumentos?>">
    <input name="hdd_docpersrecojo_id" id="hdd_docpersrecojo_id" type="hidden" value="<?php echo $idpersrecojo?>">

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
            <td><input name="txt_fech_decl" type="text" id="txt_fech_decl" value="<?php echo $fech_decl?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Vencimiento:</td>
            <td><input name="txt_fech_ven" type="text" id="txt_fech_ven" value="<?php echo $fech_ven?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Envio Correo:</td>
            <td><input name="txt_fech_envio" type="text" id="txt_fech_decl" value="<?php echo $fech_envio?>" size="41" maxlength="10"></td>
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
            <td align="right" valign="top">AFP No declarados:</td>
            <td>
                <input name="txt_afp_decl" type="text" id="txt_afp_decl" value="<?php echo $afp_decl?>" size="30">
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
            <td align="right" valign="top">Resp. Recojo:</td>
            <td>
                <input name="txt_docpersdecl" type="text" id="txt_docpersdecl" value="<?php echo $docpersdecl?>" size="10" maxlength="11">
                <input name="txt_docpersdecl" type="text" id="txt_nompersdecl" value="<?php echo $nompersdecl?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Pendientes:</td>
            <td>
                <select name="cmb_pendiente" id="cmb_pendiente">
                    <option value="1"<?php if($pendiente==True)echo 'selected'?>>Trajo</option>
                    <option value="0"<?php if($pendiente==False)echo 'selected'?>>No Trajo</option>
                </select>
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