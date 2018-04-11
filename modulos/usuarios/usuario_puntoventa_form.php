<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTelefono.php");
$oTelefono = new cTelefono();

if($_POST['action']=="insertar")
{
    $dts=$oUsuario->mostrarUno($_POST['usu_id']);
    $dt = mysql_fetch_array($dts);
    $emp_id		=$dt['tb_empresa_id'];
}
?>

<script type="text/javascript">
function cmb_pv_emp_id(idf)
{	
	$.ajax({
		type: "POST",
		url: "../empresa/cmb_emp_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			emp_id: idf
		}),
		beforeSend: function() {
			$('#cmb_pv_emp_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_pv_emp_id').html(html);
		}, 
	});
}

function cmb_pv_punven_id(empid,idf)
{	
	$.ajax({
		type: "POST",
		url: "../puntoventa/cmb_punven_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			emp_id: empid,
			punven_id: idf
		}),
		beforeSend: function() {
			$('#cmb_pv_punven_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_pv_punven_id').html(html);
		}
	});
}
$(function(){
	
	cmb_pv_emp_id('<?php echo $emp_id?>');
	cmb_pv_punven_id('<?php echo $emp_id?>','<?php echo $punven_id?>');
	
	$('#cmb_pv_emp_id').change(function() {
		var empresa_id = $('#cmb_pv_emp_id').val();
		cmb_pv_punven_id(empresa_id);
	});

	$("#for_punven").validate({
		
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "usuario_puntoventa_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_punven").serialize(),
				beforeSend: function() {
					$('#msj_usuario_form').html("Guardando...");
					$('#msj_usuario_form').show(100);
					$("#div_usuario_puntoventa_form" ).dialog( "close" );
				},
				success: function(html){
					$('#msj_usuario_form').html(html);
					$('#for_punven').each (function(){this.reset();});
				},
				complete: function(){
					usuario_puntoventa_tabla();
				}
			});
		},
		rules: {
			cmb_pv_emp_id: {
				required: true
			},
			cmb_pv_punven_id: {
				required: true
			}
		},
		messages: {
			cmb_pv_emp_id: {
				required: '*'
			},
			cmb_pv_punven_id: {
				required: '*'
			}
		}
	});
	
});
</script>
<form id="for_punven">
<input name="action_punven" id="action_punven" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_POST['id']?>">
<input name="hdd_pv_usu_id" id="hdd_pv_usu_id" type="hidden" value="<?php echo $_POST['usu_id']?>">
    <table>
        <tr>
          <td align="right"><label for="cmb_pv_emp_id">Empresa:</label></td>
          <td><select name="cmb_pv_emp_id" id="cmb_pv_emp_id">
          </select></td>
        </tr>
        <tr>
          <td><label for="cmb_pv_punven_id">Punto de Venta:</label></td>
          <td><select name="cmb_pv_punven_id" id="cmb_pv_punven_id">
          </select></td>
        </tr>
    </table>
</form>