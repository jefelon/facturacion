<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../gasto/cGasto.php");
$oGasto = new cGasto();
require_once ("../form/cForm.php");
$oForm = new cForm();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	//$pro_id=1;
	$fec=date('d-m-Y');
	$est='CANCELADO';
	$caj_id=$_POST['caj_id'];
	$ref_id=1;
}

if($_POST['action']=="editar"){
	$dts= $oGasto->mostrarUno($_POST['gas_id']);
	$dt = mysql_fetch_array($dts);
		$fecreg		=mostrarFechaHora($dt['tb_gasto_fecreg']);
		$fecmod		=mostrarFechaHora($dt['tb_gasto_fecmod']);
	
		$fec		=mostrarFecha($dt['tb_gasto_fec']);
		$doc		=$dt['tb_gasto_doc'];

		$des		=$dt['tb_gasto_des'];
		
		$cue_id		=$dt['tb_cuenta_id'];
		$subcue_id	=$dt['tb_subcuenta_id'];
		$pro_id		=$dt['tb_proveedor_id'];
		
		$entfin_id	=$dt['tb_entfinanciera_id'];
		
		$imp		=formato_money($dt['tb_gasto_imp']);
		
		$modpag		=$dt['tb_gasto_modpag'];
		$numope		=$dt['tb_gasto_numope'];
		
		$est		=$dt['tb_gasto_est'];
		
		$caj_id		=$dt['tb_caja_id'];
		$mon_id		=$dt['tb_moneda_id'];
		$ref_id		=$dt['tb_referencia_id'];
		
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
	vMax: '99999.9999'
});

$( "#txt_gas_fec" ).datepicker({
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
function cmb_pro_id(idf)
{	
	$.ajax({
		type: "POST",
		url: "../proveedor/cmb_pro_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id: idf
		}),
		beforeSend: function() {
			$('#cmb_pro_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_pro_id').html(html);
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

function cmb_cue_id()
{	
	$.ajax({
		type: "POST",
		url: "../cuentas/cmb_cue_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			elemento:"2",
			orden: "ord",
			cue_id: "<?php echo $cue_id?>"
		}),
		beforeSend: function() {
			$('#cmb_cue_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cue_id').html(html);
		}
	});
}

function cmb_subcue_id(cuenta_id)
{	
	$.ajax({
		type: "POST",
		url: "../cuentas/cmb_subcue_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			cue_id: cuenta_id,
			subcue_id: "<?php echo $subcue_id?>"
		}),
		beforeSend: function() {
			$('#cmb_subcue_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_subcue_id').html(html);
		}
	});
}

function proveedor_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../proveedor/proveedor_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			pro_id:	idf,
			vista:	'cmb_pro_id'
		}),
		beforeSend: function() {
			//$('#msj_proveedor').hide();
			/*$("#btn_cmb_pro_id").click(function(e){
			  x=e.pageX-300;
			  y=e.pageY+12;
			  $('#div_proveedor_form').dialog({ position: [x,y] });
			  $('#div_proveedor_form').dialog("open");
		    });*/
			//$('#div_proveedor_form').dialog({ position: 'top' });
			$('#div_proveedor_form').dialog("open");
			$('#div_proveedor_form').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_proveedor_form').html(html);				
		}
	});
}


$(function() {
	
	cmb_pro_id(<?php echo $pro_id?>);
	cmb_caj_id(<?php echo $caj_id?>);
	cmb_ref_id(<?php echo $ref_id?>);
	
	cmb_entfin_id();
	cmb_cue_id();
	cmb_subcue_id(<?php echo $cue_id?>);
	
	$('#cmb_cue_id').change(function(){
		cmb_subcue_id($('#cmb_cue_id').val());
	});
	
	$( "#txt_gas_des" ).autocomplete({
		minLength: 1,
		source: "../gasto/gasto_complete_des.php"
	});
	
	$( "#div_proveedor_form" ).dialog({
		title:'Información de Proveedor',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 690,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_pro").submit();
			},
			Cancelar: function() {
				$('#for_pro').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
//formulario			
	$("#for_gas").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../gasto/gasto_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_gas").serialize(),
				beforeSend: function(){
					$('#div_gasto_form').dialog("close");
					
					$('#msj_gasto').html("Guardando...");
					$('#msj_gasto').show(100);
				},
				success: function(data){
					$('#msj_gasto').html(data.gas_msj);
				},
				complete: function(){
					<?php
					if($_POST['vista']=="gasto_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			txt_gas_fec: {
				required: true,
				dateITA: true
			},
			cmb_caj_id: {
				required: true
			},
			cmb_ref_id: {
				required: true
			},
			txt_gas_doc: {
				required: false
			},
			txt_gas_des: {
				required: true
			},
			cmb_cue_id: {
				required: true
			},
			cmb_entfin_id: {
				required: false
			},
			txt_gas_imp: {
				required: true
			},
			cmb_gas_modpag: {
				required: true
			},
			cmb_gas_est: {
				required: true
			}
		},
		messages: {
			txt_gas_fec: {
				required: '*'
			},
			cmb_caj_id: {
				required: '*'
			},
			cmb_ref_id: {
				required: '*'
			},
			txt_gas_doc: {
				required: '*'
			},
			txt_gas_des: {
				required: '*'
			},
			cmb_cue_id: {
				required: '*'
			},
			cmb_entfin_id: {
				required: '*'
			},
			txt_gas_imp: {
				required: '*'
			},
			cmb_gas_modpag: {
				required: '*'
			},
			cmb_gas_est: {
				required: '*'
			}
		}
	});
	
});
</script>
<form id="for_gas">
<input name="action_gasto" id="action_gasto" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_gas_id" id="hdd_gas_id" type="hidden" value="<?php echo $_POST['gas_id']?>">
<input name="hdd_usu_id_reg" id="hdd_usu_id_reg" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_usu_id_mod" id="hdd_usu_id_mod" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo '1'//$_SESSION['empresa_id']?>">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right"><label for="txt_gas_fec">Fecha:</label></td>
      <td><input name="txt_gas_fec" type="text" class="fecha" id="txt_gas_fec" value="<?php echo $fec?>" size="10" maxlength="10"></td>
      <td align="right"><label for="cmb_caj_id">Caja:</label></td>
      <td><select name="cmb_caj_id" id="cmb_caj_id">
      </select></td>
    </tr>
    <tr>
      <td align="right"><label for="txt_gas_doc">Documento:</label></td>
      <td><input name="txt_gas_doc" type="text" id="txt_gas_doc"  value="<?php echo $doc?>"></td>
      <td align="right"><label for="cmb_ref_id">Referencia:</label></td>
      <td><select name="cmb_ref_id" id="cmb_ref_id">
      </select></td>
    </tr>
    <tr>
      <td align="right" valign="top"><label for="txt_gas_des">Descripción:</label></td>
      <td colspan="3"><textarea name="txt_gas_des" cols="55" rows="4" id="txt_gas_des"><?php echo $des?></textarea></td>
    </tr>
    <?php /*?><tr>
      <td align="right"><label for="cmb_pro_id">Proveedor:</label></td>
      <td colspan="3"><select name="cmb_pro_id" id="cmb_pro_id">
      </select>
        <a id="btn_cmb_pro_id" class="btn_ir" href="#addproveedor" onClick="proveedor_form('insertar')">Agregar Proveedor</a>
        </td>
    </tr><?php */?>
    <tr>
      <td align="right"><label for="cmb_cue_id">Cuenta:</label></td>
      <td><select name="cmb_cue_id" id="cmb_cue_id">
      </select></td>
      <td align="right"><label for="cmb_subcue_id">Sub Cuenta:</label></td>
      <td><select name="cmb_subcue_id" id="cmb_subcue_id">
      </select></td>
    </tr>
    <tr>
      <td align="right"><label for="cmb_gas_modpag">Modo Pago:</label></td>
      <td><select name="cmb_gas_modpag" id="cmb_gas_modpag" tabindex="9">
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
      <td align="right"><label for="cmb_entfin_id">Banco:</label></td>
      <td><select name="cmb_entfin_id" id="cmb_entfin_id">
      </select></td>
    </tr>
    <tr>
      <td align="right"><label for="cmb_mon_id">Moneda:</label></td>
      <td><select name="cmb_mon_id" id="cmb_mon_id">
        <option value="1" <?php if($mon_id==1)echo 'selected'?>>NUEVO SOL | S/.</option>
        <option value="2" <?php if($mon_id==2)echo 'selected'?>>DOLAR AME | US$</option>
      </select></td>
      <td align="right"><label for="txt_gas_imp">Importe:</label></td>
      <td><input type="text" name="txt_gas_imp" id="txt_gas_imp" class="moneda" style="text-align:right" size="15" maxlength="12" value="<?php echo $imp?>"></td>
    </tr>
    <tr>
      <td align="right"><label for="cmb_gas_est">Estado:</label></td>
      <td><select name="cmb_gas_est" id="cmb_gas_est">
        <option value="">-</option>
        <?php
        $rws=$oForm->mostrarTodos_des_ord('Gastos','Estado','ord');
        while($rw = mysql_fetch_array($rws))
        {
        	if($_GET['action']=="insertar")
        	{
				if($rw['tb_form_des']=="EMITIDA" or $rw['tb_form_des']=="ANULADA")
				{
        ?>
        <option value="<?php echo $rw['tb_form_des']?>" <?php if($rw['tb_form_des']==$est)echo 'selected'?>><?php echo $rw['tb_form_des']?></option>
        <?php
				}
        	}
			else
			{
				//if($rw['tb_form_des']=="EMITIDO")
				//{
        ?>
        <option value="<?php echo $rw['tb_form_des']?>" <?php if($rw['tb_form_des']==$est)echo 'selected'?>><?php echo $rw['tb_form_des']?></option>
        <?php
				//}
        	}
        }
        mysql_free_result($rws);
        ?>
      </select></td>
      <td align="right"><label for="txt_gas_numope">N° Operación:</label></td>
      <td><input type="text" name="txt_gas_numope" id="txt_gas_numope" size="15" maxlength="12" value="<?php echo $numope?>"></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><?php 
	  if($_POST['action']=="insertar"){
		  echo 'Responsable: '.$_SESSION['usuario_nombre'];
	  }
	  if($_POST['action']=="editar"){
		  echo 'Registrado: '.$usuario_reg.', el '.$fecreg;
	  }
	  ?></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><?php 
	  if($_POST['action']=="editar"){
		  echo 'Modificado: '.$usuario_mod.', el '.$fecmod;;
	  }
	  ?></td>
    </tr>
  </table>
<div id="div_proveedor_form">
</div>
</form>