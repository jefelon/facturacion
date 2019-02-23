<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cMarcacionpersonal.php");
$oMarcacionpersonal = new cMarcacionpersonal;

if($_POST['action']=="insertar") {
    $recdoc_fech = date('d-m-Y');
}

if($_POST['action']=="editar")
{
	$dts=$oMarcacionpersonal->mostrarUno($_POST['marcacionpersonal_id']);
	$dt = mysql_fetch_array($dts);
    $recdoc_fech = mostrarFecha($dt['tb_recepciondocumentos_fecha']);
	$recdoc_empresa = $dt['tb_cliente_doc'];
    $recnom_empresa = $dt['tb_cliente_nom'];
    $recid_empresa = $dt['tb_cliente_id'];
    $fecha_ingreso = $dt['tb_fecha_ingreso'];
    $fecha_salida = $dt['tb_fecha_salida'];
    $tardanza = $dt['tb_tardanza'];
    $falta = $dt['tb_falta'];
    $permisos = $dt['tb_permisos'];
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


	$("#for_recdoc").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../marcacionpersonal/marcacionpersonal_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_recdoc").serialize(),
				beforeSend: function() {
					$("#div_marcacionpersonal_form" ).dialog( "close" );
					$('#msj_marcacionpersonal').html("Guardando...");
					$('#msj_marcacionpersonal').show(100);
				},
				success: function(data){						
					$('#msj_marcacionpersonal').html(data.recdoc_msj);
					<?php
					if($_POST['vista']=="cmb_marper_id")
					{
						echo $_POST['vista'].'(data.marper_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="marcacionpersonal_tabla")
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
<input name="action_marcacionpersonal" id="action_marcacionpersonal" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_marcacionpersonal_id" id="hdd_marcacionpersonal_id" type="hidden" value="<?php echo $_POST['recepcion_id'] ?>">
    <input name="hdd_recdoc_empresa_id" id="hdd_recdoc_empresa_id" type="hidden" value="<?php echo $recid_empresa ?>">
    <table>
        <tr>
            <td align="right" valign="top">Personal:</td>
            <td>
                <input name="txt_recdoc_empresa" type="text" id="txt_recdoc_empresa" value="<?php echo $recdoc_empresa?>" size="10" maxlength="11">
                <input name="txt_recnom_empresa" type="text" id="txt_recnom_empresa" value="<?php echo $recnom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Ingreso:</td>
            <td><input name="txt_fecha_ingreso" type="text" id="txt_fecha_ingreso" value="<?php echo $fecha_ingreso?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Salida:</td>
            <td><input name="txt_fecha_salida" type="text" id="txt_fecha_salida" value="<?php echo $fecha_salida?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Tardanza:</td>
            <td><input name="txt_tardanza" type="text" id="txt_tardanza" value="<?php echo $tardanza?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Falta:</td>
            <td><input name="txt_falta" type="text" id="txt_falta" value="<?php echo $falta?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Permisos:</td>
            <td><input name="txt_permisos" type="text" id="txt_permisos" value="<?php echo $permisos?>" size="41" maxlength="10"></td>
        </tr>
    </table>
</form>