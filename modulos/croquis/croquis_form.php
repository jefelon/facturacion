<?php
require_once ("../../config/Cado.php");
require_once ("cCroquis.php");
$oCroquis = new cCroquis();

if($_POST['action']=="insertar")
{

}
if($_POST['action']=="editar")
{
	$dts=$oCroquis->mostrarUno($_POST['cro_id']);
	$dt = mysql_fetch_array($dts);
        $veh_id=$dt['tb_vehiculo_id'];
        $est=$dt['tb_croquis_estado'];
        $fon=$dt['tb_croquis_fondo'];
        $def=$dt['tb_croquis_def'];
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
    $("#file").change(function (){
        if(checkFile())
        {
            var empId = document.getElementById('hdd_cro_id').value;
            var fileInput = document.getElementById('file');
            var fileName = 'fondos/'+empId+'_'+fileInput.files[0].name;
            $("#txt_croquis_fondo").val(fileName);
        }
        else {
            $("#file").val("");
        }
    });
    function checkFile() {
        var fileElement = document.getElementById("file");
        var fileExtension = "";
        if (fileElement.value.lastIndexOf(".") > 0) {
            fileExtension = fileElement.value.substring(fileElement.value.lastIndexOf(".") + 1, fileElement.value.length);
        }
        if (fileExtension.toLowerCase() == "jpg") {
            return true;
        }
        else if (fileExtension.toLowerCase() == "jpeg") {
            return true;
        }
        else if (fileExtension.toLowerCase() == "png") {
            return true;
        }
        else {
            alert("Solo puede subir imágenes en .png .jpg . jpeg");
            return false;
        }
    }
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

	$("#for_cro").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../croquis/croquis_reg.php",
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                data: new FormData($('#for_cro')[0]),
				beforeSend: function() {
					$("#div_croquis_form" ).dialog( "close" );
					$('#msj_croquis').html("Guardando...");
					$('#msj_croquis').show(100);
				},
				success: function(html){
                    $('#msj_croquis').html(html);
				},
				complete: function(){
					croquis_tabla();
				}
			});
		},
		rules: {
            cmb_vehiculo: {
				required: true
			}
		},
		messages: {
            cmb_vehiculo: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_cro" action="javascript:;" enctype="multipart/form-data" method="post" >
<input name="action_croquis" id="action_croquis" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_cro_id" id="hdd_cro_id" type="hidden" value="<?php echo $_POST['cro_id']?>">
    <table>
        <tr>
            <td valign="top">
                <label for="cmb_vehiculo"><b>Vehículo:</b></label><br>
                <select name="cmb_vehiculo" id="cmb_vehiculo">
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="txt_croquis_fondo"><b>Fondo:</b></label><br>
                <input type="file" id="file" name="file">
                <input type="text" name="txt_croquis_fondo" id="txt_croquis_fondo" value="<?php echo $fon ?>">
                <input name="txt_cro_fon" id="txt_cro_fon" type="image" src="<?php echo $fon ?>" width="400" height="200" alt="Logo" >

            </td>
        </tr>

        <tr>
            <td valign="top">
                <label for="cmb_croquis"><b>Croquis:</b></label><br>
                <select name="cmb_croquis_def" id="cmb_croquis_def" title="Se insertará esta distribución por defecto, luego puede modificar en editar croquis.">
                    <option value="49" <?php if($def==49)echo 'selected'?>>49 ASIENTOS</option>
                    <option value="56" <?php if($def==56)echo 'selected'?>>56 ASIENTOS</option>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="cmb_estado"><b>Estado:</b></label><br>
                <select name="cmb_estado" id="cmb_estado">
                    <option value="1" <?php if($est=="1")echo 'selected'?>>Activo</option>
                    <option value="0" <?php if($est=="0")echo 'selected'?>>Inactivo</option>
                </select>
            </td>
        </tr>
    </table>
</form>