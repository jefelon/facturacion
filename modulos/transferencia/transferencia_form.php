<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTransferencia.php");
$oTransferencia = new cTransferencia();

require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
	$est='1';
	
	/*$dts= $oTransferencia->codigo();
	$dt = mysql_fetch_array($dts);
		$cod	=$dt['maximo'];
	mysql_free_result($dts);
	$cod=$cod+1;
	*/
	$caj_id_ori=$_SESSION['caja_id'];
}

if($_POST['action']=="editar"){
	$dts= $oTransferencia->mostrarUno($_POST['tra_id']);
	$dt = mysql_fetch_array($dts);
		$reg		=mostrarFechaHora($dt['tb_transferencia_fecreg']);
		$mod		=mostrarFechaHora($dt['tb_transferencia_fecmod']);

		$fec		=mostrarFecha($dt['tb_transferencia_fec']);
		
		$det		=$dt['tb_transferencia_det'];
		$imp		=$dt['tb_transferencia_imp'];
		
		$caj_id_ori		=$dt['tb_caja_id_ori'];
		$caj_id_des		=$dt['tb_caja_id_des'];
		
		$mon_id		=$dt['tb_moneda_id'];
		
		$est		=$dt['tb_transferencia_est'];
		
		$usu_id_reg	=$dt['tb_transferencia_usureg'];
		$usu_id_mod	=$dt['tb_transferencia_usumod'];
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
		url: "../caja/cmb_caj_id.php",
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
		url: "../caja/cmb_caj_id_tra.php",
		async:false,
		dataType: "html",                      
		data: ({
			caj_id: ids,
			caj_id_ori: $('#cmb_caj_id_ori').val()
		}),
		beforeSend: function() {
			$('#cmb_caj_id_des').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_caj_id_des').html(html);
		}
	});
}

$(function() {
	cmb_caj_id_ori(<?php echo $caj_id_ori?>);

	<?php if($_POST['action']=='insertar'){?>
	$('#cmb_caj_id_ori').change(function(){
		cmb_caj_id_des(<?php echo $caj_id_des?>);
	});
	<?php }?>
	
	<?php //if($_POST['action']=='editar'){?>
		cmb_caj_id_des(<?php echo $caj_id_des?>);
	<?php //}?>
		
		
	$( "#txt_tra_det" ).autocomplete({
		minLength: 1,
		source: "../transferencia/transferencia_complete_det.php"
	});

	$('#txt_tra_det').change(function(){
		$(this).val($(this).val().toUpperCase());
	});
	
//formulario			
	$("#for_tra").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../transferencia/transferencia_reg.php",
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
					//if(data.tra_act=='imprime')
					//{
					//	transferencia_impresion(data.tra_id);
					//}
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
			txt_tra_det: {
				required: true
			},
			cmb_caj_id_ori: {
				required: true
			},
			cmb_caj_id_des: {
				required: true
			},
			txt_tra_imp: {
				required: true
			}
		},
		messages: {
			txt_tra_fec: {
				required: '*'
			},
			txt_tra_det: {
				required: '*'
			},
			cmb_caj_id_ori: {
				required: '*'
			},
			cmb_caj_id_des: {
				required: '*'
			},
			txt_tra_imp: {
				required: '*'
			}
		}
	});
	
	$(document).shortkeys({
	//	'a+p':       function () { catalogo_transferencia() }
	
	});
	
});
</script>
<div>
<form id="for_tra">
<input name="action_transferencia" id="action_transferencia" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tra_id" id="hdd_tra_id" type="hidden" value="<?php echo $_POST['tra_id']?>">
<input type="hidden" id="hdd_tra_usureg" name="hdd_tra_usureg" value="<?php echo $_SESSION['usuario_id']?>">
<input type="hidden" id="hdd_tra_usumod" name="hdd_tra_usumod" value="<?php echo $_SESSION['usuario_id']?>">
<input type="hidden" id="hdd_emp_id" name="hdd_emp_id" value="<?php echo $_SESSION['empresa_id']?>">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right"><label for="txt_tra_fec">Fecha:</label></td>
      <td><input name="txt_tra_fec" type="text" class="fecha" id="txt_tra_fec" value="<?php echo $fec?>" size="10" maxlength="10"></td>
      <td align="right"></td>
      <td></td>
      </tr>
    <tr>
      <td align="right"><label for="cmb_caj_id_ori">Caja Origen:</label></td>
      <td><select name="cmb_caj_id_ori" id="cmb_caj_id_ori">
      </select></td>
      <td align="right"><label for="cmb_caj_id_des">Caja Destino:</label></td>
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
      <td align="right" valign="top"><label for="txt_tra_det">Detalle:</label></td>
      <td colspan="3"><textarea name="txt_tra_det" cols="70" rows="2" id="txt_tra_det"><?php echo $det?></textarea></td>
    </tr>
    <tr>
      <td align="right"><label for="txt_tra_imp">Importe:</label></td>
      <td><input type="text" name="txt_tra_imp" id="txt_tra_imp" class="moneda" style="text-align:right" size="15" maxlength="12" value="<?php echo $imp?>"></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td colspan="4" align="right">
      <?php /*if($_POST['action']=="insertar"){?>
      <label for="chk_imprimir">Imprimir Documento</label>
        <input name="chk_imprimir" type="checkbox" id="chk_imprimir" value="1" checked="CHECKED">
        <?php }?>
        <?php
      if($_POST['action']=="editar"){
	  ?>
      <a class="btn_imp" title="Imprimir (Shift+P)" href="#" onClick="transferencia_impresion('<?php echo $_POST['tra_id']?>')">Imprimir</a>
      <?php }*/?></td>
    </tr>
    <tr>
      <td colspan="4"></td>
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