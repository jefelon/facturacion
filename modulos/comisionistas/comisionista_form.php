<?php
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once("cComisionista.php");
$oComisionista = new cComisionista;

if($_POST['action']=="insertar") {
    $fecha_consiguio = date('d-m-Y');
}

if($_POST['action']=="editar")
{
	$dts=$oComisionista->mostrarUno($_POST['comisionista_id']);
	$dt = mysql_fetch_array($dts);
    $id_intermediario = $dt['tb_intermediario_id'];
    $doc_intermediario = $dt['tb_intermediario_doc'];
    $nom_intermediario = $dt['tb_intermediario_nom'];
    $id_empresa = $dt['tb_cliente_id'];
    $doc_empresa = $dt['tb_cliente_doc'];
    $nom_empresa = $dt['tb_cliente_nom'];
    $fecha_consiguio = mostrarFecha($dt['tb_fecha_consiguio']);
    $opcion_com = $dt['tb_opcion_com'];
	$cobro = $dt['tb_cobro'];
    $comision = $dt['tb_comision'];
    $mes1 = $dt['tb_mes1'];
    $mes2 = $dt['tb_mes2'];
    $mes3 = $dt['tb_mes3'];
    $monto_total = $dt['tb_monto_total'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_doc_nom').focus();
	<?php }?>
	
	$('#txt_doc_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

    $( "#txt_doc_empresa" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_empresa_id").val(ui.item.id);
            $("#txt_nom_empresa").val(ui.item.nombre);
            $('#hdd_empresa_id').change();
        }
    });

    $( "#txt_doc_intermediario" ).autocomplete({
        minLength: 1,
        source: "../clientes/cliente_complete_doc.php",
        select: function(event, ui){
            $("#hdd_intermediario_id").val(ui.item.id);
            $("#txt_nom_intermediario").val(ui.item.nombre);
            $('#hdd_intermediario_id').change();
        }
    });


	$("#for_com").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../comisionistas/comisionista_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_com").serialize(),
				beforeSend: function() {
					$("#div_comisionista_form" ).dialog( "close" );
					$('#msj_comisionista').html("Guardando...");
					$('#msj_comisionista').show(100);
				},
				success: function(data){						
					$('#msj_comisionista').html(data.com_msj);
					<?php
					if($_POST['vista']=="cmb_com_id")
					{
						echo $_POST['vista'].'(data.com_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="comisionista_tabla")
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
    $( "#txt_fecha_consiguio" ).datepicker({
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
        vMax: '999999999999.99'
    });
});
</script>
<form id="for_com">
<input name="action_comisionista" id="action_comisionista" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_comisionista_id" id="hdd_comisionista_id" type="hidden" value="<?php echo $_POST['comisionista_id'] ?>">
    <input name="hdd_empresa_id" id="hdd_empresa_id" type="hidden" value="<?php echo $id_empresa ?>">
    <input name="hdd_intermediario_id" id="hdd_intermediario_id" type="hidden" value="<?php echo $id_intermediario ?>">

    <table>
        <tr>
            <td align="right" valign="top">Comisionista:</td>
            <td>
                <input name="txt_doc_intermediario" type="text" id="txt_doc_intermediario" value="<?php echo $doc_intermediario?>" size="10" maxlength="11">
                <input name="txt_nom_intermediario" type="text" id="txt_nom_intermediario" value="<?php echo $nom_intermediario?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Empresa:</td>
            <td>
                <input name="txt_doc_empresa" type="text" id="txt_doc_empresa" value="<?php echo $doc_empresa?>" size="10" maxlength="11">
                <input name="txt_nom_empresa" type="text" id="txt_nom_empresa" value="<?php echo $nom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha que consiguio el cliente:</td>
            <td><input name="txt_fecha_consiguio" type="text" id="txt_fecha_consiguio" value="<?php echo $fecha_consiguio?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Opcion de Comisionistas:</td>
            <td>
                <select name="cmb_opcion_com" id="cmb_opcion_com">
                    <option value="1"<?php if($opcion_com==1)echo 'selected'?>>Concepto que se realizo</option>
                    <option value="2"<?php if($opcion_com==2)echo 'selected'?>>Llevado de contabilidad</option>
                    <option value="3"<?php if($opcion_com==3)echo 'selected'?>>Constitución de Empresa</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Cobro:</td>
            <td>
                <input name="txt_cobro" type="text" class="moneda" id="txt_cobro" style="text-align:right;" size="10" maxlength="10" value="<?php echo $cobro; ?>">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Comisión:</td>
            <td>
                <input name="txt_comision" type="text" class="moneda" id="txt_comision" style="text-align:right;" size="10" maxlength="10" value="<?php echo $comision; ?>">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Mes 1:</td>
            <td>
                <input name="txt_mes1" type="text" class="moneda" id="txt_mes1" style="text-align:right;" size="10" maxlength="10" value="<?php echo $mes1; ?>">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Mes 2:</td>
            <td>
                <input name="txt_mes2" type="text" class="moneda" id="txt_mes2" style="text-align:right;" size="10" maxlength="10" value="<?php echo $mes2; ?>">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Mes 3:</td>
            <td>
                <input name="txt_mes3" type="text" class="moneda" id="txt_mes3" style="text-align:right;" size="10" maxlength="10" value="<?php echo $mes3; ?>">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Monto Total:</td>
            <td>
                <input name="txt_monto_total" type="text" class="moneda" id="txt_monto_total" style="text-align:right;" size="10" maxlength="10" value="<?php echo $monto_total; ?>">
            </td>
        </tr>

    </table>
</form>