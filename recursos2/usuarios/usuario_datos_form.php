<?php

require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();
require_once ("cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();

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
	
		$dni	=$dt['tb_usuario_dni'];

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
	switch ($('#usuario_action').val())
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
		url: "../usuario/cmb_usugru.php",
		async:true,
		dataType: "html",                      
		data: ({
			usugru: "<?php echo $usugru?>"
		}),
		beforeSend: function() {
			$('#cmb_usugru').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_usugru').html(html);
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
		beforeSend: function() {
			$('#div_usuario_direccion_tabla').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_usuario_direccion_tabla').html(html);
		}
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
		beforeSend: function() {
			$('#div_usuario_telefono_tabla').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_usuario_telefono_tabla').html(html);
		}
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


//function
$(function() {
	
	tabsUsuario();	
	
	cargar_cmb_usugru();

	cargar_usuario_direccion_tabla();
	
	cargar_usuario_telefono_tabla();
	
	
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
	

//formulario
	$("#for_usu").validate({
		submitHandler: function() {			
			$.ajax({
				type: "POST",
				url: "usuario_datos_reg.php",
				async:true,
				dataType: "html",
				data: ({
					action: 	$('#usuario_action').val(),
					hdd_usu_id: $('#hdd_usu_id').val(),
					cmb_usugru: $('#cmb_usugru').val(),
					txt_apepat:	$('#txt_apepat').val(),
					txt_apemat:	$('#txt_apemat').val(),
					txt_nom:	$('#txt_nom').val(),
					//txt_use:	$('#txt_use').val(),
					//txt_pas:	$('#txt_pas').val(),
					txt_ema:	$('#txt_ema').val(),
					txt_dni:	$('#txt_dni').val()
					//hdd_emp:	$('#hdd_emp').val()			
				}),
				beforeSend: function() {
					$("#div_usuario_form" ).dialog( "close" );
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
			//cmb_usugru: "required",
			txt_use: {
				//required: true,
				//minlength: 3,
				//remote: "dao/users.php"
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
    <div id="msj_usuario_form" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
</div>
<form id="for_usu">
	<input name="usuario_action" id="usuario_action" type="hidden" value="<?php echo $_POST['action']?>">
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
    <td align="right"><!--<a class="btn_ir" href="#" onClick="insertarUsuariogrupo()">Ir</a> --><label>Grupo Asignado:</label></td>
    <td><?php echo $usugru_nom?></td>
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
 <!--   <tr>
    <td align="right">Nombre de usuario:</td>
    <td><label>
    <input name="txt_use" type="text" id="txt_use" value="<?php //echo $use?>" size="30">
    </label></td>
    </tr>
    <tr>
    <td align="right">Contrase&ntilde;a:</td>
    <td><input name="txt_pas" type="password" id = "txt_pas" value="<?php //echo '*******'?>" size="20" maxlength="16"></td>
    </tr>-->
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
   
  </div>
</form>