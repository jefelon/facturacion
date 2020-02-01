<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();
require_once ("cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();
require_once ("../formatos/formatos.php");


if($_POST['action']=="editar")
{
	$usu_id=$_POST['id'];
	$dts=$oUsuario->mostrarUno($_POST['id']);
	$dt = mysql_fetch_array($dts);
		$usugru		=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$nom		=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$use		=$dt['tb_usuario_use'];
		$ema		=$dt['tb_usuario_ema'];

	mysql_free_result($dts);
	
	$dts=$oUsuariodetalle->mostrarUno($_POST['id']);
	$dt = mysql_fetch_array($dts);
	
		$dni		=$dt['tb_usuario_dni'];

	mysql_free_result($dts);
}

?>

<script type="text/javascript">
//botones y vista

$('.btn_ir').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$(".btn_ir").css({width: "14px", height: "15px" });

$('#btn_agregar_telefono').button({
	icons: {primary: "ui-icon-plus"},
	text: false
});
$('#btn_agregar_direccion').button({
	icons: {primary: "ui-icon-plus"},
	text: false
});


function tabsUsuario()
{
	switch ($('#action_usuario').val())
	{ 
		case 'insertar': 
			 $("#tabs").tabs({disabled:[1,2]}); 
			 break 
		case 'editar':
			 $("#tabs").tabs({disabled:[]});
			 $("#txt_use").attr('readonly',true);
			 $("#txt_pas").attr('readonly',true);
			 break 
		//default: 
			 //Sentencias a ejecutar si el valor no es ninguno de los anteriores 
	}
}


//cargar

function cargar_cmb_usugru()
{	
	$.ajax({
		type: "POST",
		url: "dao/cmb_usugru.php",
		async:true,
		dataType: "html",                      
		data: ({
			usugru: "<?php echo '1'?>"
		}),
		success: function(html){
			$('#cmb_usugru').html(html);
		}, 
	});
	$('#cmb_usugru').attr('disabled', 'disabled');
}

function cargarTabla_usuario_direccion()
{	
	$.ajax({
		type: "POST",
		url: "usuario_direccion_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			usu_id: "<?php echo $usu_id?>"
		}),
		success: function(html){
			//$( "#i_loader" ).dialog( "open" );
			$('#div_usuario_direccion_tabla').html(html);
			//$( "#i_loader" ).dialog( "close" );
		}/*,
		complete: function(){	
			$( "#i_loader" ).dialog( "close" );
		}*/
	});       
}

function cargarTabla_usuario_telefono()
{	
	$.ajax({
		type: "POST",
		url: "usuario_telefono_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			usu_id: "<?php echo $usu_id?>"
		}),
		success: function(html){
			//$( "#i_loader" ).dialog( "open" );
			$('#div_usuario_telefono_tabla').html(html);
			//$( "#i_loader" ).dialog( "close" );
		}/*,
		complete: function(){	
			$( "#i_loader" ).dialog( "close" );
		}*/
	});       
}


//ediciones
function insertarUsuariogrupo()
{
	$.ajax({
		type: "POST",
		url: "usuarioGrupo_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "insertar"
		}),
		success: function(html){
			$('#div_usuarioGrupo_form').html(html);
		},
		complete: function(){			
			$( "#div_usuarioGrupo_form" ).dialog( "open" );
		}
	});
}


function insertar_usuario_direccion()
{
	$.ajax({
		type: "POST",
		url: "usuario_direccion_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: 'insertar'
		}),
		success: function(html){
			$('#div_usuario_direccion_form').html(html);
		},
		complete: function(){			
			$( "#div_usuario_direccion_form" ).dialog( "open" );
		}
	});
}

function editar_usuario_direccion(id)
{
	$.ajax({
		type: "POST",
		url: "usuario_direccion_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "editar",
			id:	id
		}),
		success: function(html){
			$('#div_usuario_direccion_form').html(html);
		},
		complete: function(){			
			$( "#div_usuario_direccion_form" ).dialog( "open" );
		}
	});
}

function eliminar_usuario_direccion(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "usuario_direccion_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			success: function(html){
				//$('#i_loader').html(html);
				//$( "#i_loader" ).dialog( "close" );
			},
			complete: function(){			
				cargarTabla_usuario_direccion();
			}
		});
	}
}


function insertar_usuario_telefono()
{
	$.ajax({
		type: "POST",
		url: "usuario_telefono_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "insertar"
		}),
		success: function(html){
			$('#div_usuario_telefono_form').html(html);
		},
		complete: function(){			
			$( "#div_usuario_telefono_form" ).dialog( "open" );
		}
	});
}

function editar_usuario_telefono(id)
{
	$.ajax({
		type: "POST",
		url: "usuario_telefono_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: "editar",
			id:	id
		}),
		success: function(html){
			$('#div_usuario_telefono_form').html(html);
		},
		complete: function(){			
			$( "#div_usuario_telefono_form" ).dialog( "open" );
		}
	});
}

function eliminar_usuario_telefono(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "usuario_telefono_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			success: function(html){
				//$('#i_loader').html(html);
				//$( "#i_loader" ).dialog( "close" );
			},
			complete: function(){			
				cargarTabla_usuario_telefono();
			}
		});
	}
}


//function
$(function() {
	
	tabsUsuario();	
	
	cargar_cmb_usugru();

	cargarTabla_usuario_direccion();
	
	cargarTabla_usuario_telefono();
	
	
//dialogos
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "#div_usuarioGrupo_form" ).dialog({
		title:'Form Grupo de Usuarios',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 'auto',
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_usugru").submit();
			},
			Cancelar: function() {
				$('#for_usugru').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			cargar_cmb_usugru();
		}
	});
	
	$( "#div_usuario_direccion_form" ).dialog({
		title:'Form Dirección',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 400,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_dir").submit();
			},
			Cancelar: function() {
				$('#for_dir').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			cargarTabla_usuario_direccion();
		}
	});
	
	$( "#div_usuario_telefono_form" ).dialog({
		title:'Form Teléfono',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 'auto',
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_tel").submit();
			},
			Cancelar: function() {
				$('#for_tel').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			cargarTabla_usuario_telefono();
		}
	});

// propuesta de user
	$("#txt_ema").keyup(function() {
		$("#txt_use").attr("value", $("#txt_ema").val());
	});
	
	$("#txt_use").attr('readonly',true);
	$("#txt_pas").attr('readonly',true);
	

//formulario
	$("#for_usu").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "usuario_reg_sup.php",
				async:true,
				dataType: "html",
				data: ({
					action: 	$('#action_usuario').val(),
					hdd_usu_id: $('#hdd_usu_id').val(),
					//cmb_usugru: $('#cmb_usugru').val(),
					cmb_usugru:	'1',
					txt_apepat:	$('#txt_apepat').val(),
					txt_apemat:	$('#txt_apemat').val(),
					txt_nom:	$('#txt_nom').val(),
					txt_use:	$('#txt_use').val(),
					txt_pas:	$('#txt_pas').val(),
					txt_ema:	$('#txt_ema').val(),
					txt_dni:	$('#txt_dni').val()
					//hdd_emp:	$('#hdd_emp').val()			
				}),
				success: function(html){
					var arrayDatos = html.split("-");
					
					if($('#action_usuario').val()=='insertar')
					{
						editar_usuario(arrayDatos[0]);
					}
					else
					{
						$("#div_usuario_form" ).dialog( "close" );
					}
					$("#i_loader" ).dialog( "open" );
					$('#i_loader').html(arrayDatos[1]);
					//$("#i_loader" ).dialog( "close" );
					

				}
			});
		},
		rules: {
			//cmb_usugru: "required",
			txt_use: {
				//required: true,
				//minlength: 3,
				<?php if($_POST['action']=="insertar")echo 'remote: "../usuarios/users.php"'?>
			},
			txt_pas:{
            	//required: true,
				minlength: 5
            },
			txt_apepat: "required",
			txt_apemat: "required",
			txt_nom: "required",
			txt_dni:{
            	//required: true,
                digits: true
            },
			txt_ema:{
            	required: true,
                email: true
            }//,
			//cmb_emp: "required"
		},
		messages: {
			txt_use: {
				//remote: jQuery.format("El nombre de usuario: '{0}', no está disponible.")
				remote: "Este nombre de usuario, no está disponible."
			},
			txt_repass: {
				//required: "Por favor, escriba nuevamente la contraseña.",
				minlength: "Por favor, escriba la misma contraseña.",
				equalTo: "Por favor, escriba la misma contraseña."
			}
		}
	});

});

</script>

<div id="div_usuarioGrupo_form">
</div>
<div id="div_usuario_direccion_form">
</div>
<div id="div_usuario_telefono_form">
</div>
<div style="padding:2px">
	<strong><?php echo $apepat.' '.$apemat.' '.$nom?></strong>
</div>
<form id="for_usu">
	<input name="action_usuario" id="action_usuario" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_POST['id']?>">
    <input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $_SESSION['empresa_id']?>">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Datos Logueo</a></li>
            <li><a href="#tabs-2">Información Personal</a></li>
        </ul>
    <div id="tabs-1">
    <table>
    <tr>
    <td align="right"><!--<a class="btn_ir" href="#" onClick="insertarUsuariogrupo()">Ir</a> -->Grupo Asignado:</td>
    <td><select name="cmb_usugru" id="cmb_usugru">
    </select></td>
    </tr>
    <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="right">Nombres:</td>
    <td><input name="txt_nom" type="text" id = "txt_nom" onChange="this.value=this.value.toUpperCase()" value="<?php echo $nom?>" size="30"></td>
    </tr>
    <tr>
    <td align="right">Apellido Paterno:</td>
    <td><input name="txt_apepat" type="text" id = "txt_apepat" onChange="this.value=this.value.toUpperCase()" value="<?php echo $apepat?>" size="30"></td>
    </tr>
    <tr>
    <td align="right">Apellido Materno:</td>
    <td><input name="txt_apemat" type="text" id = "txt_apemat" onChange="this.value=this.value.toUpperCase()" value="<?php echo $apemat?>" size="30"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Correo Electrónico:</td>
      <td><label>
        <input name="txt_ema" type="text" id="txt_ema" value="<?php echo $ema?>" size="30">
      </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="right">Nombre de usuario:</td>
    <td><label>
    <input name="txt_use" type="text" id="txt_use" value="<?php echo $use?>" size="30">
    </label></td>
    </tr>
    <tr>
    <td align="right"><!--Contrase&ntilde;a:--></td>
    <td><input name="txt_pas" type="hidden" id = "txt_pas" value="<?php if($_POST['action']=="insertar") { echo GeneraPassword(6);}else { echo '*******';}?>" size="20" maxlength="16"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php
    /*
    <tr>
    <td align="right"><a class="btn_ir" href="javascript:popUp('Empresa',800,400,'manEmpresa.php?vista=form')">Ir</a> Mostrar Empresa por Defecto:</td>
    <td><select name="cmb_emp" id="cmb_emp">
    <option value="">-</option>
    <?php
    $dts=$oEmpresa->mostrarTodos();
    while($dt = mysql_fetch_array($dts))
    {
    ?>
    <option value="<?php echo $dt['tb_empresa_id']?>" <?php if($dt['tb_empresa_id']==$emp)echo 'selected'?>><?php echo $dt['tb_empresa_razsoc']?></option>
    <?php 
    }
    mysql_free_result($dts);
    ?>
    </select></td>
    </tr>
    */
    ?>
    <tr>
    <td colspan="2" align="right">&nbsp;</td>
    </tr>
    </table>
    </div>
    <div id="tabs-2">
    <table>
    <tr>
    <td align="right">DNI:</td>
    <td><input name="txt_dni" type="text" id = "txt_dni" value="<?php echo $dni?>" size="10" maxlength="8"></td>
    </tr>
    </table>
    <fieldset>
      <legend>Dirección</legend>
      <a id="btn_agregar_direccion" href="#" onClick="insertar_usuario_direccion()">Agregar Dirección</a>
      <div id="div_usuario_direccion_tabla">
      </div>
    </fieldset>
    <br>
    <fieldset>
      <legend>Teléfonos</legend>
      <a id="btn_agregar_telefono" href="#" onClick="insertar_usuario_telefono()">Agregar Teléfono</a>
      <div id="div_usuario_telefono_tabla">
      </div>
    </fieldset>
    </div>
   
  </div>
</form>