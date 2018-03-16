<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVale.php");
$oVale = new cVale();
require_once ("../formatos/formatos.php");

if($_POST['action']=="insertar")
{

}

if($_POST['action']=="editar")
{
	$usu_id=$_POST['id'];
	$dts=$oVale->mostrarUno($_POST['id']);
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
}
?>

<script type="text/javascript">
//botones y vista

$('.btn_guardar').button({
	//icons: {primary: "ui-icon-save"},
	text: true
});
$(".btn_guardar").css({width: "90px", height: "25px", padding: ".5em 1em" });

$(function() {

//formulario
	$("#for_cli").validate({
		submitHandler: function() {			
			$.ajax({
				type: "POST",
				url: "../vale/usuario_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_cli").serialize(),
				beforeSend: function() {
					$('#div_usuario_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
				},
				success: function(html){
					$('#div_usuario_form').html(html);
					//alert(html);
				},
				complete: function(){
					//cargar_tabla_usuario();
				}
			});
		},
		rules: {
			txt_nom:{
            	required: true,
							letterswithbasicpunc: true
            },
			txt_dni:{
							required: true,
            	minlength: 8,
							maxlength: 8,
              digits: true
							<?php //if($_POST['action']=="insertar")echo 'remote: "../usuarios/users.php"'?>
            },
			txt_ema:{
            	required: true,
              email: true
							<?php //if($_POST['action']=="insertar")echo 'remote: "../usuarios/users.php"'?>
            },
			txt_ema2:{
							required: true,
              email: true,
            	equalTo: '#txt_ema'
							<?php //if($_POST['action']=="insertar")echo 'remote: "../usuarios/users.php"'?>
            }
		},
		messages: {
			txt_nom:{
            	required: 'Por favor, ingresa tu nombre real.',
							letterswithbasicpunc: 'Por favor, ingrese sólo letras.'
            },
			txt_dni:{
            	required: 'Por favor, ingresa tu DNI.',
              digits: 'Por favor, ingrese sólo números.'
            },
			txt_ema:{
            	required: 'Por favor, ingresa tu correo electrónico.'
              //email: true
            },
			txt_ema2:{
            	required: 'Por favor, ingresa el mismo correo electrónico.',
                //email: true,
							equalTo: 'Por favor, ingresa el mismo correo electrónico.'
            }
		}
	});

});

</script>
<div style="padding:2px">
	<strong><?php echo $apepat.' '.$apemat.' '.$nom?></strong>
</div>
<form id="for_cli">
	<input name="action_usuario" id="action_usuario" type="hidden" value="<?php echo $_POST['action']?>">
    <table width="100%">
    <tr>
      <td colspan="2">&nbsp;</td>
      </tr>
    <tr>
      <td width="220"><div class="_title">Nombre</div></td>
      <td><input class="_input" name="txt_nom" type="text" id = "txt_nom" onChange="this.value=this.value.toUpperCase()" value="<?php echo $nom?>" size="50" style="font-size: 16px;"></td>
    </tr>
    <tr>
      <td><div class="_title">DNI</div></td>
      <td><input class="_input" name="txt_dni" type="text" id = "txt_dni" value="<?php echo $dni?>" size="15" maxlength="8" style="font-size: 16px;"></td>
    </tr>
    <tr>
      <td><div class="_title">Correo Electrónico</div></td>
      <td><label>
        <input class="_input" name="txt_ema" type="text" id="txt_ema" value="<?php echo $ema?>" size="50" style="font-size: 16px;">
      </label></td>
    </tr>
    <tr>
      <td><div class="_title">Repetir Correo Electrónico</div></td>
      <td><label>
        <input class="_input" name="txt_ema2" type="text" id="txt_ema2" value="<?php //echo $ema?>" size="50" style="font-size: 16px;">
      </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input class="btn_guardar" type="submit" name="boton" id="boton" value="Guardar"></td>
      </tr>
    </table>
</form>