<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cBalancesanuales.php");
$oBalancesanuales = new cBalancesanuales();

if($_POST['action']=="insertar") {
    $fecha_comienza = date('d-m-Y');
    $fecha_culminacion = date('d-m-Y');
    $fecha_declaracion = date('d-m-Y');
    $fecha_vencimiento = date('d-m-Y');
}

if($_POST['action']=="editar")
{
	$dts=$oBalancesanuales->mostrarUno($_POST['balancesanuales_id']);
	$dt = mysql_fetch_array($dts);
	$doc_empresa = $dt['tb_cliente_doc'];
    $nom_empresa = $dt['tb_cliente_nom'];
    $id_empresa = $dt['tb_cliente_id'];
    $fecha_comienza = mostrarFecha($dt['tb_fecha_comienza']);
    $fecha_culminacion = mostrarFecha($dt['tb_fecha_culminacion']);
    $fecha_declaracion = mostrarFecha($dt['tb_fecha_declaracion']);
    $fecha_vencimiento = mostrarFecha($dt['tb_fecha_vencimiento']);
    $balances_declarados = $dt['tb_balances_declarados'];
    $balances_nodeclarados = $dt['tb_balances_nodeclarados'];
    $a_pagar = $dt['tb_apagar'];
    $pago_anual = $dt['tb_pago_anual'];
    $id_responsable_elaboracion = $dt['tb_responsable_elaboracion_id'];
    $doc_responsable_elaboracion = $dt['tb_responsable_elaboracion_doc'];
    $nom_responsable_elaboracion = $dt['tb_responsable_elaboracion_nom'];
    $id_responsable_declaracion = $dt['tb_responsable_declaracion_id'];
    $doc_responsable_declaracion = $dt['tb_responsable_declaracion_doc'];
    $nom_responsable_declaracion = $dt['tb_responsable_declaracion_nom'];
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

    $( "#txt_doc_empresa" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_empresa_id").val(ui.item.id);
            $("#txt_nom_empresa").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_empresa_id').change();
        }
    });

    $( "#txt_doc_responsable_elaboracion" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_responsable_elaboracion_id").val(ui.item.id);
            $("#txt_nom_responsable_elaboracion").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_responsable_elaboracion_id').change();
        }
    });

    $( "#txt_doc_responsable_declaracion" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_responsable_declaracion_id").val(ui.item.id);
            $("#txt_nom_responsable_declaracion").val(ui.item.nombre);
            // $("#txt_ven_cli_dir").val(ui.item.direccion);
            // $("#txt_fil_gui_cod").val(ui.item.codigo);
            // $("#hdd_ven_cli_tip").val(ui.item.tipo);
            // $("#hdd_ven_cli_ret").val(ui.item.retiene);
            // $("#hdd_cli_precio_id").val(ui.item.precio_id);
            $('#hdd_responsable_declaracion_id').change();
        }
    });

	$("#for_balanu").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../balancesanuales/balancesanuales_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_balanu").serialize(),
				beforeSend: function() {
					$("#div_balancesanuales_form" ).dialog( "close" );
					$('#msj_balancesanuales').html("Guardando...");
					$('#msj_balancesanuales').show(100);
				},
				success: function(data){						
					$('#msj_balancesanuales').html(data.balanu_msj);
					<?php
					if($_POST['vista']=="cmb_balanu_id")
					{
						echo $_POST['vista'].'(data.balanu_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="balancesanuales_tabla")
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
    $( "#txt_fecha_comienza,#txt_fecha_culminacion,#txt_fecha_declaracion,#txt_fecha_vencimiento" ).datepicker({
        minDate: "-7Y",
        maxDate:"+7Y",
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
    $('.moneda').autoNumeric({
        aSep: ',',
        aDec: '.',
        //aSign: 'S/. ',
        //pSign: 's',
        vMin: '0.00',
        vMax: '99999.99'
    });
});
</script>
<form id="for_balanu">
<input name="action_balancesanuales" id="action_balancesanuales" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_balancesanuales_id" id="hdd_balancesanuales_id" type="hidden" value="<?php echo $_POST['balancesanuales_id'] ?>">
    <input name="hdd_empresa_id" id="hdd_empresa_id" type="hidden" value="<?php echo $id_empresa ?>">
    <input name="hdd_persona_elaboracion_id" id="hdd_responsable_elaboracion_id" type="hidden" value="<?php echo $id_responsable_elaboracion ?>">
    <input name="hdd_persona_declaracion_id" id="hdd_responsable_declaracion_id" type="hidden" value="<?php echo $id_responsable_declaracion ?>">


    <table>
        <tr>
            <td align="right" valign="top">Empresa:</td>
            <td>
                <input name="txt_doc_empresa" type="text" id="txt_doc_empresa" value="<?php echo $doc_empresa?>" size="10" maxlength="11">
                <input name="txt_nom_empresa" type="text" id="txt_nom_empresa" value="<?php echo $nom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha que comienza a elaborar balances anuales:</td>
            <td><input name="txt_fecha_comienza" type="text" id="txt_fecha_comienza" value="<?php echo $fecha_comienza?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de culminación balances anuales:</td>
            <td><input name="txt_fecha_culminacion" type="text" id="txt_fecha_culminacion" value="<?php echo $fecha_culminacion?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Declaración:</td>
            <td><input name="txt_fecha_declaracion" type="text" id="txt_fecha_declaracion" value="<?php echo $fecha_declaracion?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Vencimiento:</td>
            <td><input name="txt_fecha_vencimiento" type="text" id="txt_fecha_vencimiento" value="<?php echo $fecha_vencimiento?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Balances Declarados:</td>
            <td>
                <select name="cmb_balances_declarados" id="cmb_balances_declarados">
                    <option value="1"<?php if($balances_declarados==True)echo 'selected'?>>Enviado</option>
                    <option value="0"<?php if($balances_declarados==False)echo 'selected'?>>Pendiente</option>
                </select>
            </td>
        </tr>

        <tr>
            <td align="right" valign="top">Balances No Declarados:</td>
            <td>
                <select name="cmb_balances_nodeclarados" id="cmb_balances_nodeclarados">
                    <option value="1"<?php if($balances_nodeclarados==True)echo 'selected'?>>Enviado</option>
                    <option value="0"<?php if($balances_nodeclarados==False)echo 'selected'?>>Pendiente</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Sale a pagar del balance anual:</td>
            <td>
                <input name="txt_apagar" class="moneda" type="text" id="txt_apagar" value="<?php echo $a_pagar?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Realizo pago anual:</td>
            <td>
                <select name="cmb_pago_anual" id="cmb_pago_anual">
                    <option value="1"<?php if($pago_anual==True)echo 'selected'?>>Efectuado</option>
                    <option value="0"<?php if($pago_anual==False)echo 'selected'?>>Pendiente</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Responsable de Elaboración:</td>
            <td>
                <input name="txt_doc_responsable_elaboracion" type="text" id="txt_doc_responsable_elaboracion"
                       value="<?php echo $doc_responsable_elaboracion?>" size="10" maxlength="11">
                <input name="txt_nom_responsable_elaboracion" type="text" id="txt_nom_responsable_elaboracion"
                       value="<?php echo $nom_responsable_elaboracion?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Responsable de Declaracion:</td>
            <td>
                <input name="txt_doc_responsable_declaracion" type="text" id="txt_doc_responsable_declaracion"
                       value="<?php echo $doc_responsable_declaracion?>" size="10" maxlength="11">
                <input name="txt_nom_responsable_declaracion" type="text" id="txt_nom_responsable_declaracion"
                       value="<?php echo $nom_responsable_declaracion?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Observaciones:</td>
            <td>
                <textarea name="txt_observaciones" type="textarea" id="txt_observaciones" rows="4" cols="50"
                          maxlength="300"><?php echo $observaciones?></textarea>
            </td>
        </tr>
    </table>
</form>