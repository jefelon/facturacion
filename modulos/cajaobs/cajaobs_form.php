<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../cajaobs/cCajaobs.php");
$oCajaobs = new cCajaobs();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
	$est='2';
	$caj_id=$_SESSION['caja_id'];
}

if($_POST['action']=="editar"){
	$dts= $oCajaobs->mostrarUno($_POST['cajobs_id']);
	$dt = mysql_fetch_array($dts);
		$fecreg		=mostrarFechaHora($dt['tb_cajaobs_fecreg']);
		$fecmod		=mostrarFechaHora($dt['tb_cajaobs_fecmod']);
		$usureg		=$dt['tb_cajaobs_usureg'];
		$usumod		=$dt['tb_cajaobs_usumod'];
	
		$fec 		=mostrarFecha($dt['tb_cajaobs_fec']);
		$det		=$dt['tb_cajaobs_det'];
		
		$caj_id		=$dt['tb_caja_id'];
	
		$est		=$dt['tb_cajaobs_est'];
		
	mysql_free_result($dts);
}

//usuarios
if($usureg>0)
{
	$dts=$oUsuario->mostrarUno($usureg);
	$dt = mysql_fetch_array($dts);
		$usugru		=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$usu_nom	=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$ema		=$dt['tb_usuario_ema'];
	
	mysql_free_result($dts);
	
	$usuario_reg="$usu_nom $apepat $apemat";
}
if($usumod>0)
{
	$dts=$oUsuario->mostrarUno($usumod);
	$dt = mysql_fetch_array($dts);
		$usugru		=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$usu_nom	=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$ema		=$dt['tb_usuario_ema'];
	
	mysql_free_result($dts);
	
	$usuario_mod="$usu_nom $apepat $apemat";
}
?>
<script type="text/javascript">
<?php if($_POST['action']=="insertar"){?>
$("#txt_cajobs_fec").datepicker({
	//minDate: "-1M", 
	//maxDate:"+0D",
	yearRange: 'c-0:c+0',
	changeMonth: true,
	changeYear: true,
	dateFormat: 'dd-mm-yy',
	//altField: fecha,
	//altFormat: 'yy-mm-dd',
	showOn: "button",
	buttonImage: "../../images/calendar.gif",
	buttonImageOnly: true
});
<?php }?>
function cmb_caj_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../caja/cmb_caj_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			caj_id: ids
		}),
		beforeSend: function() {
			$('#cmb_caj_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_caj_id').html(html);
		}
	});
}

$(function() {

	<?php if($_POST['action']=='insertar'){?>
		$('#txt_cajobs_det').focus();
	<?php }?>

	cmb_caj_id(<?php echo $caj_id?>);
	
	$('#txt_cajobs_det').autocomplete({
		minLength: 1,
		source: "../cajaobs/cajaobs_complete_det.php"
	});

	$('#txt_cajobs_det').change(function(){
		$(this).val($(this).val().toUpperCase());
	});

//formulario			
	$("#for_cajobs").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../cajaobs/cajaobs_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_cajobs").serialize(),
				beforeSend: function(){
					$('#div_cajaobs_form').dialog("close");
					$('#msj_cajaobs').html("Guardando...");
					$('#msj_cajaobs').show(100);
				},
				success: function(data){
					$('#msj_cajaobs').html(data.cajobs_msj);
				},
				complete: function(){
					<?php
					if($_POST['vista']=="cajaobs_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			txt_cajobs_fec: {
				required: true,
				dateITA: true
			},
			txt_cajobs_det: {
				required: false
			},
			cmb_cajobs_est: {
				required: true
			}
		},
		messages: {
			txt_cajobs_fec: {
				required: '*'
			},
			txt_cajobs_det: {
				required: '*'
			},
			cmb_cajobs_est: {
				required: '*'
			}
		}
	});

});
</script>
<div>
<form id="for_cajobs">
<input type="hidden" id="action_cajaobs" name="action_cajaobs" value="<?php echo $_POST['action']?>">
<input type="hidden" id="hdd_cajobs_id" name="hdd_cajobs_id" value="<?php echo $_POST['cajobs_id']?>">
<input type="hidden" id="hdd_cajobs_usureg" name="hdd_cajobs_usureg" value="<?php echo $_SESSION['usuario_id']?>">
<input type="hidden" id="hdd_cajobs_usumod" name="hdd_cajobs_usumod" value="<?php echo $_SESSION['usuario_id']?>">
<input type="hidden" id="hdd_emp_id" name="hdd_emp_id" value="<?php echo $_SESSION['empresa_id']?>">

  <table border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td align="right"><label for="txt_cajobs_fec">Fecha:</label></td>
      <td><input name="txt_cajobs_fec" type="text" class="fecha" id="txt_cajobs_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly></td>
      <td align="right"><label for="cmb_caj_id">Caja:</label></td>
      <td>
        <select name="cmb_caj_id" id="cmb_caj_id">
        </select></td>
      <td align="right"><label for="cmb_cajobs_est">Estado:</label></td>
      <td><select name="cmb_cajobs_est" id="cmb_cajobs_est">
        <option value="">-</option>
        <?php if($_SESSION['usuariogrupo_id']=='2'){?>
        <option value="1" <?php if($est==1)echo 'selected'?>>ABIERTA</option>
        <?php }?>
        <option value="2" <?php if($est==2)echo 'selected'?>>CERRADA</option>
      </select>
      </td>
    </tr>
    <tr>
      <td align="right" valign="top"><label for="txt_cajobs_det">Observación:</label></td>
      <td colspan="5"><textarea name="txt_cajobs_det" cols="80" rows="3" id="txt_cajobs_det"><?php echo $det?></textarea></td>
    </tr>
    <tr>
      <td colspan="6" align="right">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="6"><?php 
	  if($_POST['action']=="insertar"){
		  echo 'Responsable: '.$_SESSION['usuario_nombre'];
	  }
	  if($_POST['action']=="editar"){
		  echo 'Registrado por: '.$usuario_reg.', el '.$fecreg;
	  }
	  ?></td>
      </tr>
    <tr>
      <td colspan="4"><?php 
	  if($_POST['action']=="editar"){
		  echo 'Modificado por: '.$usuario_mod.', el '.$fecmod;;
	  }
	  ?></td>
      </tr>
  </table>

</form>

</div>