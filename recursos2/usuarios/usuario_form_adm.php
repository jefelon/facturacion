<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();
require_once ("cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();
require_once ("../formatos/formatos.php");

if($_POST['action']=="insertar")
{
	$emp_id=$_SESSION['empresa_id'];
	$usugru_id=2;
}

if($_POST['action']=="editar")
{
	$usu_id=$_POST['id'];
	$dts=$oUsuario->mostrarUno($_POST['id']);
	$dt = mysql_fetch_array($dts);
		$usugru_id	=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$nom		=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$use		=$dt['tb_usuario_use'];
		$ema		=$dt['tb_usuario_ema'];
		
		$emp_id		=$dt['tb_empresa_id'];

	mysql_free_result($dts);
	
	$dts=$oUsuariodetalle->mostrarUno($_POST['id']);
	$dt = mysql_fetch_array($dts);
	
		$dni		=$dt['tb_usuario_dni'];
		$punven_id	=$dt['tb_puntoventa_id'];
		$hor_id		=$dt['tb_horario_id'];

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

$('#btn_agregar_puntoventa').button({
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
		url: "../usuarios/cmb_usugru.php",
		async:true,
		dataType: "html",                      
		data: ({
			usugru: "<?php echo '2'?>"
		}),
		success: function(html){
			$('#cmb_usugru').html(html);
		}, 
	});
	$('#cmb_usugru').attr('disabled', 'disabled');
}

function cmb_emp_id(idf)
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
			$('#cmb_emp_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_emp_id').html(html);
		}, 
	});
}

function cmb_punven_id(empid,idf)
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
			$('#cmb_punven_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_punven_id').html(html);
		}
	});
}

function cargar_usuario_direccion_tabla()
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

function cargar_usuario_telefono_tabla()
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

function usuario_direccion_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "usuario_direccion_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			dir_id:	idf
		}),
		beforeSend: function() {
			$( "#div_usuario_direccion_form" ).dialog( "open" );
			$('#div_usuario_direccion_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_usuario_direccion_form').html(html);
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
			beforeSend: function() {
				$('#msj_usuario_form').html("Cargando...");
				$('#msj_usuario_form').show(100);
			},
			success: function(html){
				$('#msj_usuario_form').html(html);
			},
			complete: function(){			
				cargar_usuario_direccion_tabla();
			}
		});
	}
}


function usuario_telefono_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "usuario_telefono_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action	: act,
			id		: idf
		}),
		beforeSend: function() {
			$( "#div_usuario_telefono_form" ).dialog( "open" );
			$('#div_usuario_telefono_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_usuario_telefono_form').html(html);
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
			beforeSend: function() {
				$('#msj_usuario_form').html("Cargando...");
				$('#msj_usuario_form').show(100);
			},
			success: function(html){
				$('#msj_usuario_form').html(html);
			},
			complete: function(){			
				cargar_usuario_telefono_tabla();
			}
		});
	}
}

function usuario_puntoventa_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "../usuarios/usuario_puntoventa_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action		: act,
			usu_id		: $('#hdd_usu_id').val(),
			punven_id	: idf
		}),
		beforeSend: function() {
			$('#div_usuario_puntoventa_form').dialog( "open" );
			$('#div_usuario_puntoventa_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_usuario_puntoventa_form').html(html);
		}
	});
}
function eliminar_usuario_puntoventa(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "usuario_puntoventa_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			beforeSend: function() {
				$('#msj_usuario_form').html("Cargando...");
				$('#msj_usuario_form').show(100);
			},
			success: function(html){
				$('#msj_usuario_form').html(html);
			},
			complete: function(){			
				usuario_puntoventa_tabla();
			}
		});
	}
}
function usuario_puntoventa_tabla()
{	
	$.ajax({
		type: "POST",
		url: "../usuarios/usuario_puntoventa_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			usu_id: "<?php echo $usu_id?>"
		}),
		beforeSend: function() {
			$('#div_usuario_puntoventa_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_usuario_puntoventa_tabla').html(html);
		},
		complete: function(){			
			$('#div_usuario_puntoventa_tabla').removeClass("ui-state-disabled");
		}
	});       
}


//function
$(function() {
	
	tabsUsuario();	
	
	cargar_cmb_usugru();
	
	cmb_emp_id('<?php echo $emp_id?>');

	cargar_usuario_direccion_tabla();
	
	cargar_usuario_telefono_tabla();
	
	cmb_punven_id('<?php echo $emp_id?>','<?php echo $punven_id?>');
	
	usuario_puntoventa_tabla();
	
	$('#cmb_emp_id').change(function() {
		var empresa_id = $('#cmb_emp_id').val();
		cmb_punven_id(empresa_id,'<?php echo $punven_id?>');
	});
	
//dialogos
	
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
		}
	});

	$( "#div_usuario_puntoventa_form" ).dialog({
		title:'Información de Punto de Venta',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 'auto',
		modal: true,
		buttons: {
			Agregar: function() {
				$("#for_punven").submit();
			},
			Cancelar: function() {
				$('#for_punven').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
// propuesta de user
	<?php if($_POST['action']=="insertar")
	{ ?>
	$("#txt_ema").keyup(function() {
		$("#txt_use").attr("value", $("#txt_ema").val());
	});
	<?php }?>
	
	$("#txt_use").attr('readonly',true);
	$("#txt_pas").attr('readonly',true);
	

//formulario
	$("#for_usu").validate({
		submitHandler: function() {			
			$.ajax({
				type: "POST",
				url: "usuario_reg_adm.php",
				async:true,
				dataType: "html",
				data: $("#for_usu").serialize(),
				beforeSend: function() {
					if($('#action_usuario').val()=='editar')
					{
						$("#div_usuario_form" ).dialog( "close" );
					}
					else
					{
						blok_usuario_form();
					}
					$('#msj_usuario').html("Guardando...");
			        $('#msj_usuario').show(100);
				},
				success: function(html){
					var arrayDatos = html.split("-");
					
					if($('#action_usuario').val()=='insertar')
					{
						editar_usuario(arrayDatos[0],1);
					}
					else
					{
						$("#div_usuario_form" ).dialog( "close" );
					}
					
					$('#msj_usuario').html(arrayDatos[1]);

				},
				complete: function(){
					cargar_tabla_usuario();
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
			txt_apepat:{
            	required: true
            },
			txt_apemat:{
            	required: true
            },
			txt_nom:{
            	required: true
            },
			txt_dni:{
            	//required: true,
                digits: true
            },
			txt_ema:{
            	required: true,
                email: true
            },
			cmb_emp_id:{
            	required: true
            }
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
			},
			txt_apepat:{
            	required: '*'
            },
			txt_apemat:{
            	required: '*'
            },
			txt_nom:{
            	required: '*'
            },
			txt_dni:{
            	//required: true,
                //digits: '*'
            },
			txt_ema:{
            	required: '*',
                //email: true
            },
			cmb_emp_id:{
            	required: '*'
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
    <input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $emp_id?>">
    <input name="hdd_usugru_id" id="hdd_usugru_id" type="hidden" value="<?php echo $usugru_id?>">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Datos Logueo</a></li>
            <li><a href="#tabs-2">Información Personal</a></li>
            <li><a href="#tabs-3">Punto de Venta</a></li>
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
    <tr>
    <td align="right"><label for="cmb_emp_id">Mostrar Empresa por Defecto:</label></td>
    <td><select name="cmb_emp_id" id="cmb_emp_id">
    </select></td>
    </tr>
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
      <a id="btn_agregar_direccion" href="#" onClick="usuario_direccion_form('insertar')">Agregar Dirección</a>
      <div id="div_usuario_direccion_tabla">
      </div>
    </fieldset>
    <br>
    <fieldset>
      <legend>Teléfonos</legend>
      <a id="btn_agregar_telefono" href="#" onClick="usuario_telefono_form('insertar')">Agregar Teléfono</a>
      <div id="div_usuario_telefono_tabla">
      </div>
    </fieldset>
    </div>
   	<div id="tabs-3">
    <div id="div_horario_form">
	</div>
    <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><label for="cmb_punven_id">Punto de Venta:</label></td>
    <td><select name="cmb_punven_id" id="cmb_punven_id">
    </select></td>
  </tr>
</table>
<fieldset>
      <legend>Acceso a Puntos de Venta</legend>
      <a id="btn_agregar_puntoventa" href="#" onClick="usuario_puntoventa_form('insertar')">Agregar Punto de Venta</a>
      <div id="div_usuario_puntoventa_tabla">
      </div>
      <div id="div_usuario_puntoventa_form">
	  </div>
    </fieldset>

    </div>
   	
  </div>
</form>