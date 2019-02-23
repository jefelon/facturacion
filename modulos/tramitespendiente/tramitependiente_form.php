<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cTramitependiente.php");
$oTramitependiente = new cTramitependiente;

if($_POST['action']=="insertar") {
    $recdoc_fech = date('d-m-Y');
}

if($_POST['action']=="editar")
{
	$dts=$oTramitependiente->mostrarUno($_POST['tramitependiente_id']);
	$dt = mysql_fetch_array($dts);
    $recdoc_fech = mostrarFecha($dt['tb_tramitependiente_fecha']);
	$recdoc_empresa = $dt['tb_cliente_doc'];
    $recnom_empresa = $dt['tb_cliente_nom'];
    $recid_empresa = $dt['tb_cliente_id'];
    $fecha_finalizado = $dt['tb_fecha_finalizado'];
    $tramite_ejecutar = $dt['tb_tramite_ejecutar'];
    $fecha_acuerdo = $dt['tb_fecha_acuerdo'];
    $fecha_conteo = $dt['tb_fecha_conteo'];
    $fecha_plazo = $dt['tb_fecha_plazo'];
    $persdecl_id = $dt['tb_persdecl_id'];
    $docpersdecl = $dt['tb_persdecl_doc'];
    $nompersdecl = $dt['tb_persdecl_nom'];
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
				url: "../tramitependiente/tramitependiente_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_recdoc").serialize(),
				beforeSend: function() {
					$("#div_tramitependiente_form" ).dialog( "close" );
					$('#msj_tramitependiente').html("Guardando...");
					$('#msj_tramitependiente').show(100);
				},
				success: function(data){						
					$('#msj_tramitependiente').html(data.recdoc_msj);
					<?php
					if($_POST['vista']=="cmb_trapen_id")
					{
						echo $_POST['vista'].'(data.trapen_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="tramitependiente_tabla")
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
<input name="action_tramitependiente" id="action_tramitependiente" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_tramitependiente_id" id="hdd_tramitependiente_id" type="hidden" value="<?php echo $_POST['tramitependiente_id'] ?>">
    <input name="hdd_recdoc_empresa_id" id="hdd_recdoc_empresa_id" type="hidden" value="<?php echo $recid_empresa ?>">
    <input name="hdd_persdecl_id" id="hdd_persdecl_id" type="hidden" value="<?php echo $persdecl_id ?>">

    <table>
        <tr>
            <td align="right" valign="top">Empresa:</td>
            <td>
                <input name="txt_recdoc_empresa" type="text" id="txt_recdoc_empresa" value="<?php echo $recdoc_empresa?>" size="10" maxlength="11">
                <input name="txt_recnom_empresa" type="text" id="txt_recnom_empresa" value="<?php echo $recnom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Acuerdo:</td>
            <td><input name="txt_fecha_acuerdo" type="text" id="txt_fecha_acuerdo" value="<?php echo $fecha_acuerdo?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Tramite Finalizado:</td>
            <td><input name="txt_fecha_finalizado" type="text" id="txt_fecha_finalizado" value="<?php echo $fecha_finalizado?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Tramite por ejecutar:</td>
            <td>
                <input name="txt_afp_decl" type="text" id="txt_tramite_ejecutar" value="<?php echo $tramite_ejecutar?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha que empieza conteo:</td>
            <td><input name="txt_fecha_conteo" type="text" id="txt_fecha_conteo" value="<?php echo $fecha_conteo?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Tramite Finalizado:</td>
            <td><input name="tb_fecha_plazo" type="text" id="tb_fecha_plazo" value="<?php echo $fecha_plazo?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Persona Responsable:</td>
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