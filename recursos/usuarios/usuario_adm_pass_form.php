<script src="../../js/tablaButton.js" type="text/javascript"></script>
<script type="text/javascript">

$(function() {	
	$("#for_usu_pas").validate({
		submitHandler: function() {			
			$.ajax({
				type: "POST",
				url: "usuario_pass_reg.php",
				async:true,
				dataType: "html",
				data: ({					
					hdd_usu_id:		$('#hdd_usu_id').val(),
					txt_usu_newpas:	$('#txt_usu_newpas').val(),
					txt_usu_newpasrep:	$('#txt_usu_newpasrep').val()			
				}),
				beforeSend: function() {
					$("#div_usuario_pass_form" ).dialog( "close" );
					$('#msj_usuario').html("Guardando...");
			        $('#msj_usuario').show(100);
				},
				success: function(html){
					$('#msj_usuario').html(html);
				},
				complete: function(){			
					cargar_usuario_detalle();
				}
			});			
		},
		rules: {
			txt_usu_newpas: {
				required: true
			},			
			txt_usu_newpasrep: {
				required: true,
				equalTo: "#txt_usu_newpas"			
			}
		},
		messages: {
			txt_usu_newpasrep: {
				//required: "Por favor, escriba nuevamente la contraseña.",
				minlength: "Por favor, escriba la misma contraseña.",
				equalTo: "Por favor, escriba la misma contraseña."
			}
		}
	});		
});
</script>
<form id="for_usu_pas">
    <input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_POST['id']?>" />
    <table>
        <tr>
            <td align="right">Nueva Contraseña:</td>
            <td><input name="txt_usu_newpas" id="txt_usu_newpas" type="password" /></td>
        </tr>
        <tr>
            <td align="right">Repetir Contraseña:</td>
            <td><input name="txt_usu_newpasrep" id="txt_usu_newpasrep" type="password" /></td>
        </tr>             
    </table>
</form>