<?php
require_once ("../../config/Cado.php");
require_once ("cDireccion.php");
$oDireccion = new cDireccion();

if($_POST['action']=="editar")
{
	$dts=$oDireccion->mostrarUno($_POST['dir_id']);
	$dt = mysql_fetch_array($dts);
		$ubigeo	=$dt['tb_ubigeo_cod'];
		$dir	=$dt['tb_direccion_dir'];
	mysql_free_result($dts);
	
	$coddep=substr($ubigeo, 0, 2);
	$codpro=substr($ubigeo, 2, 2);
	$coddis=substr($ubigeo, 4, 2);
}
?>

<script type="text/javascript">
function cargar_cmb_ubigeo_dep($ubigeo_dep)
{	
	$.ajax({
		type: "POST",
		url: "../ubigeo/cmb_ubigeo.php",
		async:true,
		dataType: "html",                      
		data: ({
			tip: "Departamento",
			coddep: '00',
			codpro: '00',
			ubigeo: $ubigeo_dep
		}),
		beforeSend: function() {
			$('#cmb_ubigeo_dep').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_ubigeo_dep').html(html);
		}, 
	});
}

function cargar_cmb_ubigeo_pro(ubigeo_dep,ubigeo_pro)
{	
	$.ajax({
		type: "POST",
		url: "../ubigeo/cmb_ubigeo.php",
		async:true,
		dataType: "html",                      
		data: ({
			tip:	'Provincia',
			coddep: ubigeo_dep,
			codpro: '00',
			ubigeo: ubigeo_pro
		}),
		beforeSend: function() {
			$('#cmb_ubigeo_pro').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_ubigeo_pro').html(html);
		}, 
	});
}

function cargar_cmb_ubigeo_dis(ubigeo_dep,ubigeo_pro,ubigeo_dis)
{	
	$.ajax({
		type: "POST",
		url: "../ubigeo/cmb_ubigeo.php",
		async:true,
		dataType: "html",                      
		data: ({
			tip:	'Distrito',
			coddep: ubigeo_dep,
			codpro: ubigeo_pro,
			ubigeo: ubigeo_dis
		}),
		beforeSend: function() {
			$('#cmb_ubigeo_dis').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_ubigeo_dis').html(html);
		}, 
	});
}

<?php
if($_POST['action']=="editar")
{
	echo "
	cargar_cmb_ubigeo_dep($coddep);
	cargar_cmb_ubigeo_pro($coddep,$codpro);
	cargar_cmb_ubigeo_dis($coddep,$codpro,$coddis);
	";
}
else
{
	echo "
	cargar_cmb_ubigeo_dep();
	";
}
?>

$(function() {
//cargar
	//cargar_cmb_ubigeo_dep();
	
	$('#cmb_ubigeo_dep').change(function() {
		cargar_cmb_ubigeo_pro($('#cmb_ubigeo_dep').val());
		cargar_cmb_ubigeo_dis();
	});
	
	$('#cmb_ubigeo_pro').change(function() {
		cargar_cmb_ubigeo_dis($('#cmb_ubigeo_dep').val(),$('#cmb_ubigeo_pro').val());
	});

//formulario
	$("#for_dir").validate({
		
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "usuario_direccion_reg.php",
				async:true,
				dataType: "html",
				data: ({
					action:			$('#action_direccion').val(),
					hdd_dir_id:		$('#hdd_dir_id').val(),
					cmb_ubigeo_dep:	$('#cmb_ubigeo_dep').val(),
					cmb_ubigeo_pro:	$('#cmb_ubigeo_pro').val(),
					cmb_ubigeo_dis:	$('#cmb_ubigeo_dis').val(),
					txt_dir:		$('#txt_dir').val(),
					hdd_usu_id:		$('#hdd_usu_id').val()
				}),
				beforeSend: function() {
					$("#div_usuario_direccion_form" ).dialog( "close" );
				},
				success: function(html){
					$('#for_dir').each (function(){this.reset();});
				},
				complete: function(){
					cargar_usuario_direccion_tabla();
				}
			});
		},
		rules: {
			cmb_ubigeo_dep: {
				required: true
			},
			cmb_ubigeo_pro: {
				required: true
			},
			cmb_ubigeo_dis: {
				required: true
			},
			txt_dir: {
				required: true
			}
		},
		messages: {
			cmb_dir_tip: {
				//remote: jQuery.format("El nombre de usuario: '{0}', no está disponible.")
				//remote: "Este nombre de usuario, no está disponible."
			},
			cmb_dir_ope: {
				//minlength: "Por favor, escriba la misma contraseña.",
				//equalTo: "Por favor, escriba la misma contraseña."
			},
			txt_dir_num: {
				//required: "Por favor, escriba nuevamente la contraseña."
			}
		}
	});
	
});
</script>
<form id="for_dir">
<input name="action_direccion" id="action_direccion" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_dir_id" id="hdd_dir_id" type="hidden" value="<?php echo $_POST['dir_id']?>">
<table align="center">
    <tr>
      <td><label for="cmb_ubigeo_dep">Departamento:</label></td>
      <td><select name="cmb_ubigeo_dep" id="cmb_ubigeo_dep">
      </select></td>
    </tr>
  <tr>
    <td><label for="cmb_ubigeo_pro">Provincia:</label></td>
    <td><select name="cmb_ubigeo_pro" id="cmb_ubigeo_pro">
    </select></td>
    </tr>
  <tr>
    <td><label for="cmb_ubigeo_dis">Distrito:</label></td>
    <td><select name="cmb_ubigeo_dis" id="cmb_ubigeo_dis">
    </select></td>
    </tr>
  <tr>
    <td valign="top">Dirección:</td>
    <td><textarea name="txt_dir" cols="40" rows="3" id="txt_dir"><?php echo $dir?></textarea></td>
    </tr>
</table>
</form>