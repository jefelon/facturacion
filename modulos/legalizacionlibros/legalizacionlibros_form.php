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
	$dts=$oLegalizacionlibros->mostrarUno($_POST['legalizacionlibros_id']);
	$dt = mysql_fetch_array($dts);
    $id_empresa = $dt['tb_cliente_id'];
    $doc_empresa = $dt['tb_cliente_doc'];
    $nom_empresa = $dt['tb_cliente_nom'];
    $domicilio_fiscal = $dt['tb_domicilio_fiscal'];
    $fecha_recepcion = mostrarFecha($dt['tb_fecha_recepcion']);
    $notaria = $dt['tb_notaria'];
    $fecha_legalizacion = mostrarFecha($dt['tb_fecha_legalizacion']);
    $fecha_recojo = mostrarFecha($dt['tb_fecha_recojo']);
    $numdoc = $dt['tb_numdoc'];
    $regimen = $dt['tb_regimen_tributario'];
    $cantidad_libros = $dt['tb_cantidad_libros'];
    $id_responsable = $dt['tb_responsable_id'];
    $doc_responsable = $dt['tb_responsable_doc'];
    $nom_responsable = $dt['tb_responsable_nom'];
    $libros_legalizados = $dt['tb_libros_legalizados'];
    $libros_nolegalizados = $dt['tb_libros_nolegalizados'];
    $pendiente_cobro = $dt['tb_pendiente_cobro'];
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
<input name="action_legalizacionlibros" id="action_legalizacionlibros" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_legalizacionlibros_id" id="hdd_afp_id" type="hidden" value="<?php echo $_POST['legalizacionlibros_id'] ?>">
    <input name="hdd_empresa_id" id="hdd_empresa_id" type="hidden" value="<?php echo $id_empresa ?>">
    <input name="hdd_responsable_id" id="hdd_responsable_id" type="hidden" value="<?php echo $id_responsable ?>">

    <table>
        <tr>
            <td align="right" valign="top">Empresa:</td>
            <td>
                <input name="txt_doc_empresa" type="text" id="txt_doc_empresa" value="<?php echo $doc_empresa?>" size="10" maxlength="11">
                <input name="txt_nom_empresa" type="text" id="txt_nom_empresa" value="<?php echo $nom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Lugar Domicilio Fiscal</td>
            <td>
                <input name="txt_domicilio_fiscal" type="text" id="txt_domicilio_fiscal" value="<?php echo $domicilio_fiscal?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Recepción:</td>
            <td><input name="txt_fecha_recepcion" type="text" id="txt_fecha_recepcion" value="<?php echo $fecha_recepcion?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Notaria</td>
            <td>
                <input name="txt_notaria" type="text" id="txt_notaria" value="<?php echo $notaria?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Legalizacion:</td>
            <td><input name="txt_fecha_legalizacion" type="text" id="txt_fecha_legalizacion" value="<?php echo $fecha_legalizacion?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Fecha de Recojo:</td>
            <td><input name="txt_fecha_recojo" type="text" id="txt_fecha_recojo" value="<?php echo $fecha_recojo?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">NUMDOC:</td>
            <td><input name="txt_fecha_numdoc" type="text" id="txt_fecha_numdoc" value="<?php echo $numdoc?>" size="41" maxlength="10"></td>
        </tr>

        <tr>
            <td align="right" valign="top">Regimen Tributario:</td>
            <td>
                <select name="cmb_opcion_com" id="cmb_opcion_com">
                    <option value="1"<?php if($regimen==1)echo 'selected'?>>Regimen Especial</option>
                    <option value="2"<?php if($regimen==2)echo 'selected'?>>Regimen MYPE Tributario</option>
                    <option value="3"<?php if($regimen==3)echo 'selected'?>>Regimen General</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Cantidad de Libros:</td>
            <td><input name="txt_cantidad_libros" type="text" id="txt_cantidad_libros" value="<?php echo $cantidad_libros?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Responsable de Legalización:</td>
            <td>
                <input name="txt_doc_responsable" type="text" id="txt_doc_responsable" value="<?php echo $doc_empresa?>" size="10" maxlength="11">
                <input name="txt_nom_responsable" type="text" id="txt_nom_responsable" value="<?php echo $nom_empresa?>" size="30">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Libros Legalizados:</td>
            <td><input name="txt_libros_legalizados" type="text" id="txt_libros_legalizados" value="<?php echo $libros_legalizados?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Libros No Legalizados:</td>
            <td><input name="txt_libros_nolegalizados" type="text" id="txt_libros_nolegalizados" value="<?php echo $libros_nolegalizados?>" size="41" maxlength="10"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Pendiente Cobro:</td>
            <td><input name="txt_pendiente_cobro" type="text" id="txt_pendiente_cobro" value="<?php echo $pendiente_cobro?>" size="41" maxlength="10"></td>
        </tr>

        <tr>
            <td align="right" valign="top">Observaciones:</td>
            <td>
                <textarea name="txt_observaciones" type="textarea" id="txt_observaciones" rows="4" cols="50" maxlength="300"><?php echo $observaciones?></textarea>
            </td>
        </tr>
    </table>
</form>