<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once ("cRecepcionDocumentos.php");
$oRecepcionDocumentos = new cRecepcionDocumentos();

if($_POST['action']=="insertar") {
    $recdoc_fech = date('d-m-Y');
}

if($_POST['action']=="editar")
{
	$dts=$oRecepcionDocumentos->mostrarUno($_POST['recepcion_id']);
	$dt = mysql_fetch_array($dts);
    $recdoc_fech = mostrarFecha($dt['tb_recepciondocumentos_fecha']);
	$recdoc_empresa = $dt['tb_cliente_doc'];
    $recnom_empresa = $dt['tb_cliente_nom'];
    $recid_empresa = $dt['tb_cliente_id'];
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
            txt_recdoc_fech:{
                required: true
            },
            hdd_recdoc_empresa_id:{
                required: true
            },
            txt_docnom_empresa: {
                required: true
            },
            txt_recnom_empresa: {
				required: true
			},
            hdd_perspentrega_id: {
                required: true
            },
            txt_docpersentrega:{
                required: true
            },
            txt_nomperspentrega:{
                required: true
            },
            hdd_recepdocumentos_id:{
                required: true
            },
            txt_docrecepdocumentos:{
                required: true
            },
            txt_nomrecepdocumentos: {
                required: true
            },
            hdd_docpersrecojo_id:{
                required: true
            },
            txt_docpersrecojo: {
                required: true
            },
            txt_nompersrecojo: {
                required: true
            },
            cmb_pendiente:{
                required:true
            }
		},
		messages: {
            txt_recdoc_fech:{
                required: '*'
            },
            hdd_recdoc_empresa_id:{
                required: 'Seleccione empresa, '
            },
            txt_docnom_empresa: {
                required: '*'
            },
            txt_recdoc_empresa: {
                required: '*'
            },
            hdd_perspentrega_id:{
                required: 'Seleccione persona que realiza entrega, '
            },
            txt_docpersentrega:{
                required: '*'
            },
            txt_nomperspentrega:{
                required: '*'
            },
            hdd_recepdocumentos_id:{
                required: 'Seleccione persona que recepeciona documentos, '
            },
            txt_docrecepdocumentos:{
                required: '*'
            },
            txt_nomrecepdocumentos: {
                required: '*'
            },
            hdd_docpersrecojo_id:{
                required: 'Seleccione persona que recoje documentos'
            },
            txt_docpersrecojo: {
                required: '*'
            },
            txt_nompersrecojo: {
                required: '*'
            },
            cmb_pendiente:{
                required:'*'
            }
		}
	});

    $( "#txt_recdoc_fech" ).datepicker({
        minDate: "-1Y",
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
    <input name="hdd_recepcion_id" id="hdd_recepcion_id" type="hidden" value="<?php echo $_POST['recepcion_id'] ?>">
    <input name="hdd_recdoc_empresa_id" id="hdd_recdoc_empresa_id" type="hidden" value="<?php echo $recid_empresa ?>">
    <input name="hdd_perspentrega_id" id="hdd_perspentrega_id" type="hidden" value="<?php echo $idpersentrega ?>">
    <input name="hdd_recepdocumentos_id" id="hdd_recepdocumentos_id" type="hidden" value="<?php echo $idrecepdocumentos?>">
    <input name="hdd_docpersrecojo_id" id="hdd_docpersrecojo_id" type="hidden" value="<?php echo $idpersrecojo?>">

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
        <tr>
            <td align="right" valign="top">Recep. Documentos:</td>
            <td>
                <input name="txt_docrecepdocumentos" type="text" id="txt_docrecepdocumentos" value="<?php echo $docrecepdocumentos?>" size="10" maxlength="11">
                <input name="txt_nomrecepdocumentos" type="text" id="txt_nomrecepdocumentos" value="<?php echo $nomrecepdocumentos?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Resp. Recojo:</td>
            <td>
                <input name="txt_docpersrecojo" type="text" id="txt_docpersrecojo" value="<?php echo $docpersrecojo?>" size="10" maxlength="11">
                <input name="txt_nompersrecojo" type="text" id="txt_nompersrecojo" value="<?php echo $nompersrecojo?>" size="30">
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