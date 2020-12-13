<?php
require_once("../../config/Cado.php");
require_once("../asiento/cAsiento.php");
$oAsiento = new cAsiento();

if($_POST['action']=="insertar")
{

}
if($_POST['action']=="editar")
{
    $dts=$oAsiento->mostrar_distribucionasiento($_POST['fila'],$_POST['piso'], $_POST['veh_id']);
    $dt = mysql_fetch_array($dts);
    $distribucion=$dt['tb_distribucionasiento_lugar'];

	mysql_free_result($dts);
}
?>

<script type="text/javascript">

function cmb_vehiculo(ids)
{
    $.ajax({
        type: "POST",
        url: "../vehiculo/cmb_veh_id.php",
        async:false,
        dataType: "html",
        data: ({
            veh_id: ids
        }),
        beforeSend: function() {
            $('#cmb_vehiculo').html('<option value="">Cargando...</option>');
        },
        success: function(html){
            $('#cmb_vehiculo').html(html);

        },
        complete: function(){

        }
    });
}

$(function() {
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_cat_nom').focus();
	<?php }?>
	
	$('#txt_cat_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

    cmb_vehiculo(<?php echo $veh_id ?>);

	$("#for_ediasi").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../croquis/croquis_agregar_asiento_reg.php",
                async:true,
                dataType: "html",
                data: $("#for_ediasi").serialize(),
				beforeSend: function() {
					$("#div_agregar_asiento_form" ).dialog( "close" );
					$('#msj_agregar_asiento').html("Guardando...");
					$('#msj_agregar_asiento').show(100);
				},
				success: function(html){
                    $('#msj_agregar_asiento').html(html);
				},
				complete: function(){
                    croquis_filtro(<?php echo $_POST['veh_id'] ?>,<?php echo $_POST['piso'] ?>);
				}
			});
		},
		rules: {
            distribucion: {
				required: true
			}
		},
		messages: {
            distribucion: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_ediasi"  method="post">
    <input name="action_croquis" id="action_croquis" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_veh_id" id="hdd_veh_id" type="hidden" value="<?php echo $_POST['veh_id']?>">
    <input name="hdd_piso" id="hdd_piso" type="hidden" value="<?php echo $_POST['piso']?>">
    <input name="hdd_fila" id="hdd_fila" type="hidden" value="<?php echo $_POST['fila']?>">
    <table>
        <tr>
            <td><textarea cols="127" rows="3" name="distribucion" id="distribucion"><?php echo $distribucion ?></textarea></td>
        </tr>
    </table>
</form>