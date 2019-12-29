<?php
require_once ("../../config/Cado.php");
require_once ("cVehiculo.php");
$oVehiculo = new cVehiculo();

if($_POST['action']=="editar")
{
	$dts=$oVehiculo->mostrarUno($_POST['veh_id']);
	$dt = mysql_fetch_array($dts);
	$veh_pla=$dt['tb_vehiculo_placa'];
    $con_id=$dt['tb_conductor_id'];
    $veh_mar=$dt['tb_vehiculo_marca'];
    $veh_mod=$dt['tb_vehiculo_modelo'];
    $veh_num_asi=$dt['tb_vehiculo_numasi'];
    $veh_pis=$dt['tb_vehiculo_pisos'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">
    function cmb_conductor(ids)
    {
        $.ajax({
            type: "POST",
            url: "../conductor/cmb_con_id.php",
            async:false,
            dataType: "html",
            data: ({
                con_id:ids
            }),
            beforeSend: function() {
                $('#cmb_conductor').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_conductor').html(html);
            },
            complete: function(){

            }
        });
    }

$(function() {
	cmb_conductor(<?php echo $con_id;?>);
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_veh_nom').focus();
	<?php }?>
	
	$('#txt_veh_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#for_veh").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../vehiculo/vehiculo_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_veh").serialize(),
				beforeSend: function() {
					$("#div_vehiculo_form" ).dialog( "close" );
					$('#msj_vehiculo').html("Guardando...");
					$('#msj_vehiculo').show(100);
				},
				success: function(data){						
					$('#msj_vehiculo').html(data.veh_msj);
					<?php
					if($_POST['vista']=="cmb_veh_id")
					{
						echo $_POST['vista'].'(data.veh_id)';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="vehiculo_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
            txt_veh_pla: {
				required: true
			}
		},
		messages: {
            txt_veh_pla: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_veh">
<input name="action_vehiculo" id="action_vehiculo" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_veh_id" id="hdd_veh_id" type="hidden" value="<?php echo $_POST['veh_id']?>">
    <table>
        <tr>
            <td align="right" valign="top">Placa:</td>
            <td><input name="txt_veh_pla" type="text" id="txt_veh_pla" value="<?php echo $veh_pla?>" size="20"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Marca:</td>
            <td><input name="txt_veh_mar" type="text" id="txt_veh_mar" value="<?php echo $veh_mar?>" size="20"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Modelo:</td>
            <td><input name="txt_veh_mod" type="text" id="txt_veh_mod" value="<?php echo $veh_mod?>" size="20"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Num. Asientos:</td>
            <td><input name="txt_veh_numasi" type="text" id="txt_veh_numasi" value="<?php echo $veh_num_asi?>" size="20"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Pisos:</td>
            <td>
                <select name="cmb_pisos" id="cmb_pisos">
                    <option value="1" <?php if($veh_pis=='1')echo 'selected'?>> 1 Piso</option>
                    <option value="2" <?php if($veh_pis=='2')echo 'selected'?>> 2 Pisos</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">Conductor:</td>
            <td valign="top">
                <select name="cmb_conductor" id="cmb_conductor">
                </select>
            </td>
        </tr>
    </table>
</form>