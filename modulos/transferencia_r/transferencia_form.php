<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTransferencia.php");
$oTransferencia = new cTransferencia();

require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../form/cForm.php");
$oForm = new cForm();

require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
	$est='CANCELADO';
	
	$dts= $oTransferencia->codigo();
	$dt = mysql_fetch_array($dts);
		$cod	=$dt['maximo'];
	mysql_free_result($dts);
	$cod=$cod+1;
	
	$caj_id_ori=$_POST['caj_id'];
}

if($_POST['action']=="editar"){
	$dts= $oTransferencia->mostrarUno($_POST['tra_id']);
	$dt = mysql_fetch_array($dts);
		$reg		=mostrarFechaHora($dt['tb_transferencia_reg']);
		$mod		=mostrarFechaHora($dt['tb_transferencia_mod']);

		$fec		=mostrarFecha($dt['tb_transferencia_fec']);
		$cod		=$dt['tb_transferencia_cod'];
		
		$des		=$dt['tb_transferencia_des'];
		
		$ref_id	=$dt['tb_referencia_id'];
		$entfin_id=$dt['tb_entfinanciera_id'];
		
		$modpag		=$dt['tb_transferencia_modpag'];
		$mon		=$dt['tb_transferencia_mon'];
		
		$caj_id_ori		=$dt['tb_caja_id_ori'];
		$caj_id_des		=$dt['tb_caja_id_des'];
		
		$mon_id		=$dt['tb_moneda_id'];
		
		$est		=$dt['tb_transferencia_est'];
		
		$usu_id_reg	=$dt['tb_usuario_id_reg'];
		$usu_id_mod	=$dt['tb_usuario_id_mod'];
	mysql_free_result($dts);
}

//usuarios
if($usu_id_reg>0)
{
	$dts=$oUsuario->mostrarUno($usu_id_reg);
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
if($usu_id_mod>0)
{
	$dts=$oUsuario->mostrarUno($usu_id_mod);
	$dt = mysql_fetch_array($dts);
		$usugru		=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$usu_nom		=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$ema		=$dt['tb_usuario_ema'];
	
	mysql_free_result($dts);
	
	$usuario_mod="$usu_nom $apepat $apemat";
}
?>
<script type="text/javascript">
$('.btn_imp').button({
	icons: {primary: "ui-icon-print"},
	text: false
});

$('#btn_seleccionar_factura').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});

$('.btn_ir').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999999.99'
});

$( "#txt_tra_fec" ).datepicker({
	//minDate: "-1M", 
	maxDate:"+0D",
	yearRange: 'c-1:c+0',
	changeMonth: true,
	changeYear: true,
	dateFormat: 'dd-mm-yy',
	//altField: fecha,
	//altFormat: 'yy-mm-dd',
	showOn: "button",
	buttonImage: "../../images/calendar.gif",
	buttonImageOnly: true
});
function cmb_caj_id_ori(ids)
{	
	$.ajax({
		type: "POST",
		url: "../caja/cmb_caj_id_tra.php",
		async:false,
		dataType: "html",                      
		data: ({
			caj_id: ids
		}),
		beforeSend: function() {
			$('#cmb_caj_id_ori').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_caj_id_ori').html(html);
		}
	});
}
function cmb_caj_id_des(ids)
{	
	$.ajax({
		type: "POST",
		url: "../caja_r/cmb_caj_id_tra.php",
		async:false,
		dataType: "html",                      
		data: ({
			caj_id: ids
		}),
		beforeSend: function() {
			$('#cmb_caj_id_des').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_caj_id_des').html(html);
		}
	});
}

function cmb_entfin_id()
{	
	$.ajax({
		type: "POST",
		url: "../entfinanciera/cmb_entfin_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			entfin_id: "<?php echo $entfin_id?>"
		}),
		beforeSend: function() {
			$('#cmb_entfin_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_entfin_id').html(html);
		}
	});
}

function cmb_ref_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../caja/cmb_ref_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			ref_id: ids
		}),
		beforeSend: function() {
			$('#cmb_ref_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_ref_id').html(html);
		}
	});
}

$(function() {
	cmb_caj_id_ori(<?php echo $caj_id_ori?>);
	cmb_entfin_id();
	cmb_ref_id(<?php echo $ref_id?>);
	
	
	<?php /*if($_POST['action']=='insertar'){?>
	$('#cmb_caj_id_ori').change(function(){
		cmb_caj_id_des(<?php echo $caj_id_des?>);
	});
	<?php }*/?>
	
	cmb_caj_id_des(<?php echo $caj_id_des?>);
		
	$( "#txt_tra_des" ).autocomplete({
		minLength: 1,
		source: "../transferencia/transferencia_complete_des.php"
	});
	
//formulario			
	$("#for_tra").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../transferencia_r/transferencia_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_tra").serialize(),
				beforeSend: function(){
					$('#div_transferencia_form').dialog("close");
					
					$('#msj_transferencia').html("Guardando...");
					$('#msj_transferencia').show(100);
				},
				success: function(data){
					$('#msj_transferencia').html(data.tra_msj);
				},
				complete: function(){
					<?php
					if($_POST['vista']=="transferencia_tabla")
					{
						echo $_POST['vista'].'();';
					}
					if($_POST['vista']=="caja_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			txt_tra_fec: {
				required: true,
				dateITA: true
			},
			txt_tra_des: {
				required: true
			},
			cmb_ref_id: {
				required: true
			},
			cmb_tra_modpag: {
				required: true
			},
			cmb_caj_id_ori: {
				required: true
			},
			cmb_caj_id_des: {
				required: true
			},
			txt_tra_cod: {
				required: false
			},
			txt_tra_mon: {
				required: true
			}
		},
		messages: {
			txt_tra_fec: {
				required: '*'
			},
			txt_tra_des: {
				required: '*'
			},
			cmb_ref_id: {
				required: '*'
			},
			cmb_tra_modpag: {
				required: '*'
			},
			cmb_caj_id_ori: {
				required: '*'
			},
			cmb_caj_id_des: {
				required: '*'
			},
			txt_tra_cod: {
				required: '*'
			},
			txt_tra_mon: {
				required: '*'
			}
		}
	});
	
	$(document).shortkeys({
		'a+p':       function () { catalogo_transferencia() }
		
		<?php
		if($_POST['action']=="editar"){
		?>
		,'Shift+p':   function () { transferencia_impresion('<?php echo $_POST['tra_id']?>') }
		<?php }?>
		
	});
	
});
</script>
<div>
<form id="for_tra">
<input name="action_transferencia" id="action_transferencia" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tra_id" id="hdd_tra_id" type="hidden" value="<?php echo $_POST['tra_id']?>">
<input name="hdd_usu_id_reg" id="hdd_usu_id_reg" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_usu_id_mod" id="hdd_usu_id_mod" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo '1' //$_SESSION['empresa_id']?>">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right"><label for="txt_tra_fec">Fecha:</label></td>
      <td><input name="txt_tra_fec" type="text" class="fecha" id="txt_tra_fec" value="<?php echo $fec?>" size="10" maxlength="10"></td>
      <td align="right"><label for="txt_tra_cod">Código:</label></td>
      <td><input name="txt_tra_cod" type="text" id="txt_tra_cod"  value="<?php echo $cod?>" style="text-align:right" size="10" maxlength="10" readonly></td>
      </tr>
    <tr>
      <td align="right"><label for="cmb_caj_id_ori">Caja General Origen:</label></td>
      <td><select name="cmb_caj_id_ori" id="cmb_caj_id_ori">
      </select></td>
      <td align="right"><label for="cmb_caj_id_des">Caja Tercero Destino:</label></td>
      <td><select name="cmb_caj_id_des" id="cmb_caj_id_des">
      </select></td>
      </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="top"><label for="txt_tra_des">Descripción:</label></td>
      <td colspan="3"><textarea name="txt_tra_des" cols="55" rows="4" id="txt_tra_des"><?php echo $des?></textarea></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td align="right"><label for="cmb_ref_id">Referencia:</label></td>
      <td><select name="cmb_ref_id" id="cmb_ref_id">
      </select></td>
      <td align="right"><label for="cmb_entfin_id">Entidad Financiera:</label></td>
      <td><select name="cmb_entfin_id" id="cmb_entfin_id">
      </select></td>
      </tr>
    <tr>
      <td align="right"><label for="cmb_mon_id">Moneda:</label></td>
      <td><select name="cmb_mon_id" id="cmb_mon_id">
        <option value="1" <?php if($mon_id==1)echo 'selected'?>>NUEVO SOL | S/.</option>
        <option value="2" <?php if($mon_id==2)echo 'selected'?>>DOLAR AME | US$</option>
      </select></td>
      <td align="right"><label for="cmb_tra_modpag">Modo:</label></td>
      <td><select name="cmb_tra_modpag" id="cmb_tra_modpag">
        <option value="">-</option>
        <?php
$rws=$oForm->mostrarTodos_des('Gastos','Modo Pago');
while($rw = mysql_fetch_array($rws))
{
?>
        <option value="<?php echo $rw['tb_form_des']?>" <?php if($rw['tb_form_des']==$modpag)echo 'selected'?>><?php echo $rw['tb_form_des']?></option>
        <?php 
}
mysql_free_result($rws);
?>
      </select></td>
      </tr>
    <tr>
      <td align="right"><label for="txt_tra_mon">Monto:</label></td>
      <td><input type="text" name="txt_tra_mon" id="txt_tra_mon" class="moneda" style="text-align:right" size="15" maxlength="12" value="<?php echo $mon?>"></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><?php 
	  if($_POST['action']=="insertar"){
		  echo 'Responsable: '.$_SESSION['usuario_nombre'];
	  }
	  if($_POST['action']=="editar"){
		  echo 'Registrado: '.$usuario_reg.', el '.$reg;
	  }
	  ?></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="4"><?php 
	  if($_POST['action']=="editar"){
		  echo 'Modificado: '.$usuario_mod.', el '.$mod;;
	  }
	  ?></td>
      </tr>
  </table>
<div id="div_cliente_form">
</div>
</form>

</div>