<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../form/cForm.php");
$oForm = new cForm();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	//$cli_id=1;
	$feccon=date('d-m-Y');
	$est='CANCELADO';
	$caj_id=$_POST['caj_id'];
}

if($_POST['action2']=="caja"){
	$feccon=$_POST['ven_fec1'];
	$est='CANCELADO';
	
	$des=$_POST['ing_des'];
	$mon=formato_money($_POST['ing_mon']);
	
	$cue_id=22;
	
	if($_SESSION['empresa_id']==1)$subcue_id=157;
	if($_SESSION['empresa_id']==2)$subcue_id=158;
	
	$ref_id=$_POST['ref_id'];
	$caj_id=$_POST['caj_id'];
	$entfin_id=$_POST['entfin_id'];
}

if($_POST['action2']=="caja_nv"){
	$feccon=$_POST['ven_fec1'];
	$est='CANCELADO';
	
	$des=$_POST['ing_des'];
	$mon=formato_money($_POST['ing_mon']);
	
	$cue_id=23;
	
	if($_SESSION['empresa_id']==1)$subcue_id=159;
	if($_SESSION['empresa_id']==2)$subcue_id=160;
	
	$ref_id=$_POST['ref_id'];
	$caj_id=$_POST['caj_id'];
	$entfin_id=$_POST['entfin_id'];
}

if($_POST['action']=="editar"){
	$dts= $oIngreso->mostrarUno($_POST['ing_id']);
	$dt = mysql_fetch_array($dts);
		$fecreg		=mostrarFechaHora($dt['tb_ingreso_fecreg']);
		$fecmod		=mostrarFechaHora($dt['tb_ingreso_fecmod']);
		
		$fecemi		=mostrarFecha($dt['tb_ingreso_fecemi']);
		$feccon		=mostrarFecha($dt['tb_ingreso_feccon']);
		$doc		=$dt['tb_ingreso_doc'];
		
		$ref_id		=$dt['tb_referencia_id'];
		
		$des		=$dt['tb_ingreso_des'];
		
		$cue_id		=$dt['tb_cuenta_id'];
		$subcue_id	=$dt['tb_subcuenta_id'];
		$cli_id		=$dt['tb_cliente_id'];
		
		$entfin_id	=$dt['tb_entfinanciera_id'];
		$numope		=$dt['tb_ingreso_numope'];
		$mon		=formato_money($dt['tb_ingreso_mon']);
		
		$caj_id		=$dt['tb_caja_id'];
		$mon_id		=$dt['tb_moneda_id'];
		
		$est		=$dt['tb_ingreso_est'];
		
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

$( "#txt_ing_fecemi, #txt_ing_feccon" ).datepicker({
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
function cmb_cli_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../clientes/cmb_cli_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			cli_id: ids
		}),
		beforeSend: function() {
			$('#cmb_cli_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cli_id').html(html);
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
			elemento:"1",
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

function cliente_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../clientes/cliente_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			cli_id:	idf,
			vista:	'cmb_cli_id'
		}),
		beforeSend: function() {
			//$('#msj_cliente').hide();
			$("#btn_cmb_cli_id").click(function(e){
			  x=e.pageX-300;
			  y=e.pageY+12;
			  $('#div_cliente_form').dialog({ position: [x,y] });
			  $('#div_cliente_form').dialog("open");
		    });
			$('#div_cliente_form').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_cliente_form').html(html);				
		}
	});
}

$(function() {
	
	cmb_cli_id(<?php echo $cli_id?>);
	cmb_caj_id(<?php echo $caj_id?>);
	cmb_ref_id(<?php echo $ref_id?>);
	cmb_entfin_id();
	cmb_cue_id();
	cmb_subcue_id(<?php echo $cue_id?>);
	
	$('#cmb_cue_id').change(function(){
		cmb_subcue_id($('#cmb_cue_id').val());
	});
	
	$( "#txt_ing_des" ).autocomplete({
		minLength: 1,
		source: "../ingreso/ingreso_complete_des.php"
	});
	
	$( "#div_cliente_form" ).dialog({
		title:'Información de Cliente',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 'auto',
		//modal: true,
		buttons: {
			Guardar: function() {
				$("#for_cli").submit();
			},
			Cancelar: function() {
				$('#for_cli').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
//formulario			
	$("#for_ing").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../ingreso/ingreso_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_ing").serialize(),
				beforeSend: function(){
					$('#div_ingreso_form').dialog("close");
					
					$('#msj_ingreso').html("Guardando...");
					$('#msj_ingreso').show(100);
				},
				success: function(data){
					$('#msj_ingreso').html(data.ing_msj);
				},
				complete: function(){
					<?php
					if($_POST['vista']=="ingreso_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			/*txt_ing_fecemi: {
				required: true,
				dateITA: true
			},*/
			txt_ing_feccon: {
				required: true,
				dateITA: true
			},
			txt_ing_des: {
				required: true
			},
			cmb_caj_id: {
				required: true
			},
			txt_ing_doc: {
				required: false
			},
			cmb_cue_id: {
				required: true
			},
			cmb_entfin_id: {
				required: false
			},
			txt_ing_mon: {
				required: true
			},
			cmb_ing_est: {
				required: true
			},
			cmb_ref_id: {
				required: true
			}
		},
		messages: {
			/*txt_ing_fecemi: {
				required: '*'
			},*/
			txt_ing_feccon: {
				required: '*'
			},
			txt_ing_des: {
				required: '*'
			},
			cmb_caj_id: {
				required: '*'
			},
			txt_ing_doc: {
				required: '*'
			},
			cmb_cue_id: {
				required: '*'
			},
			cmb_entfin_id: {
				required: '*'
			},
			txt_ing_mon: {
				required: '*'
			},
			cmb_ing_est: {
				required: '*'
			},
			cmb_ref_id: {
				required: '*'
			}
		}
	});
	
	$(document).shortkeys({
		'a+p':       function () { catalogo_ingreso() }
		
		<?php
		if($_POST['action']=="editar"){
		?>
		,'Shift+p':   function () { ingreso_impresion('<?php echo $_POST['ing_id']?>') }
		<?php }?>
		
	});
	
});
</script>
<div>
<form id="for_ing">
<input name="action_ingreso" id="action_ingreso" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_ing_id" id="hdd_ing_id" type="hidden" value="<?php echo $_POST['ing_id']?>">
<input name="hdd_usu_id_reg" id="hdd_usu_id_reg" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_usu_id_mod" id="hdd_usu_id_mod" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo '1' //$_SESSION['empresa_id']?>">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right"><label for="txt_ing_feccon">Fecha:</label></td>
      <td><input name="txt_ing_feccon" type="text" class="fecha" id="txt_ing_feccon" value="<?php echo $feccon?>" size="10" maxlength="10"></td>
      <td align="right"><label for="cmb_caj_id">Caja:</label></td>
      <td>
        <select name="cmb_caj_id" id="cmb_caj_id">
        </select></td>
    </tr>
    <?php /*?><tr>
      <td align="right"><label for="txt_ing_fecemi">Fecha Emisión:</label></td>
      <td><input name="txt_ing_fecemi" type="text" class="fecha" id="txt_ing_fecemi" value="<?php echo $fecemi?>" size="10" maxlength="10"></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
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
      <td align="right"><label for="txt_ing_doc">Documento:</label></td>
      <td><input name="txt_ing_doc" type="text" id="txt_ing_doc"  value="<?php echo $doc?>"></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php /*?><tr>
      <td align="right"><label for="cmb_cli_id">Cliente:</label></td>
      <td colspan="3">
        <select name="cmb_cli_id" id="cmb_cli_id">
        </select>
        <?php if($fac_id>0 and $_POST['vista']!="factura_ingreso_tabla"){?>
        <a id="btn_cmb_cli_id" class="btn_ir" href="#addcliente" onClick="cliente_form('insertar')">Agregar Cliente</a>
      	<?php }?>
      </td>
      </tr><?php */?>
    <tr>
      <td align="right" valign="top"><label for="txt_ing_des">Descripción:</label></td>
      <td colspan="3"><textarea name="txt_ing_des" cols="55" rows="4" id="txt_ing_des"><?php echo $des?></textarea></td>
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
      <td align="right"><label for="txt_ing_mon">Monto:</label></td>
      <td><input type="text" name="txt_ing_mon" id="txt_ing_mon" class="moneda" style="text-align:right" size="15" maxlength="12" value="<?php echo $mon?>" <?php if($_POST['action2']=='caja' or $_POST['action2']=='caja_nv')echo 'readonly'?>></td>
      </tr>
    <tr>
      <td align="right"><label for="cmb_ing_est">Estado:</label></td>
      <td><select name="cmb_ing_est" id="cmb_ing_est">
        <option value="">-</option>
        <?php
        $rws=$oForm->mostrarTodos_des_ord('Ingresos','Estado','ord');
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
      <td align="right"><label for="txt_ing_numope">N° Operación:</label></td>
      <td><input type="text" name="txt_ing_numope" id="txt_ing_numope" size="15" maxlength="12" value="<?php echo $numope?>"></td>
      </tr>
    <tr>
      <td colspan="4" align="right">&nbsp;</td>
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
<div id="div_cliente_form">
</div>
</form>

</div>