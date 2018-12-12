<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	//$cli_id=1;
	$fec=date('d-m-Y');
	$est='1';
	//$caj_id=$_POST['caj_id'];
	$caj_id=$_SESSION['caja_id'];
	$ven_id=0;
	$tra_id=0;

	if($_POST['vista']=='venta_ingreso_tabla'){
		$ven_id 	=$_POST['ven_id'];
		$cue_id 	=$_POST['cue_id'];
		$subcue_id 	=$_POST['subcue_id'];
		$cli_id 	=$_POST['cli_id'];
		$cli_doc 	=$_POST['cli_doc'];
		$cli_nom 	=$_POST['cli_nom'];
		$det 		=$_POST['det'];

		$imp 		=moneda_mysql($_POST['imp']);
		$ing_tot 	=moneda_mysql($_POST['ing_tot']);

		$imp=$imp-$ing_tot;

		$imp_max=$imp;

		$imp=formato_money($imp);
	}
}

if($_POST['action2']=="caja"){
	$fec=$_POST['ven_fec1'];
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

if($_POST['action']=="editar"){
	$dts= $oIngreso->mostrarUno($_POST['ing_id']);
	$dt = mysql_fetch_array($dts);
		$fecreg		=mostrarFechaHora($dt['tb_ingreso_fecreg']);
		$fecmod		=mostrarFechaHora($dt['tb_ingreso_fecmod']);
		$usureg		=$dt['tb_ingreso_usureg'];
		$usumod		=$dt['tb_ingreso_usumod'];
		
		$fec		=mostrarFecha($dt['tb_ingreso_fec']);
		$doc_id 	=$dt['tb_documento_id'];
		$numdoc		=$dt['tb_ingreso_numdoc'];
		
		$det		=$dt['tb_ingreso_det'];
		
		$cue_id		=$dt['tb_cuenta_id'];
		$subcue_id	=$dt['tb_subcuenta_id'];

		$cli_id		=$dt['tb_cliente_id'];
		$cli_nom 	=$dt['tb_cliente_nom'];
		$cli_doc 	=$dt['tb_cliente_doc'];
		$cli_dir 	=$dt['tb_cliente_dir'];
		$cli_tip 	=$dt['tb_cliente_tip'];
		
		$imp		=$dt['tb_ingreso_imp'];
		
		$caj_id		=$dt['tb_caja_id'];

		$ven_id		=$dt['tb_venta_id'];
		
		$est		=$dt['tb_ingreso_est'];
		
	mysql_free_result($dts);

	if($_POST['vista']=='venta_ingreso_tabla'){
		$ven_imp	=moneda_mysql($_POST['imp']);
		$ing_tot 	=moneda_mysql($_POST['ing_tot']);

		$imp_max=$ven_imp-$ing_tot+$imp;
	}

	$imp=formato_money($imp);
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

$('#btn_cli_form_agregar').button({
	icons: {primary: "ui-icon-plus"},
	text: false
});
$("#btn_cli_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('#btn_cli_form_modificar').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});
$("#btn_cli_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('.moneda2').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.00'
	//vMax: '<?php echo $imp_max?>'
});

$("#txt_ing_fec").datepicker({
	//minDate: "-1M", 
	maxDate:"+0D",
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

function cmb_doc_id(tipo,docid,vis)
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	tipo,
			doc_id: 	docid,
			vista:		vis
		}),
		beforeSend: function() {
			$('#cmb_doc_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_doc_id').html(html);
		},
		complete: function(){
			<?php if($_POST['action']=="insertar"){?>
			//ingreso_txt_numdoc();
			<?php }?>
		}
	});
}
function ingreso_txt_numdoc(){	
	$.ajax({
		type: "POST",
		url: "../ingreso/ingreso_txt_numdoc.php",
		async:false,
		dataType: "json",                      
		data: ({
			doc_id: $('#cmb_doc_id').val()
		}),
		beforeSend: function() {
			$('#txt_ing_numdoc').val('...');
        },
		success: function(data){			
			$('#txt_ing_numdoc').val(data.correlativo);
			/*if(data.msj!="")
			{
				$('#msj_venta_form').html(data.msj);
				$('#msj_venta_form').show(100);
			}
			else
			{
				$('#msj_venta_form').hide();
			}*/
		},
		complete: function(){
			<?php if($_POST['action']=="insertar"){?>
			//verificar_numdoc();
			<?php }?>
		}
	});
}
function cliente_form_i(act,idf){
	$.ajax({
		type: "POST",
		url: "../cliente/cliente_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			cli_id:	idf,
			vista:	'hdd_cli_id'
		}),
		beforeSend: function() {
			//$('#msj_proveedor').hide();
			$("#btn_cli_form_agregar").click(function(e){
			  x=e.pageX+5;
			  y=e.pageY+15;
			  $('#div_cliente_form').dialog({ position: [x,y] });
			  $('#div_cliente_form').dialog("open");
		    });
			
			if(act=='editar'){
				if(idf>0){
					$("#btn_cli_form_modificar").click(function(e){
					  x=e.pageX+5;
					  y=e.pageY+15;
					  $('#div_cliente_form').dialog({ position: [x,y] });
					  $('#div_cliente_form').dialog("open");
					});
				}
				else{
					alert('Seleccione Cliente');
				}
			}
		
			$('#div_cliente_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_cliente_form').html(html);					
		},
		complete: function(){
			if(act=='insertar' & $('#hdd_cli_id').val()=="")
			{
				$('#txt_cli_doc').val($('#txt_cli_doc').val());
				$('#txt_cli_nom').val($('#txt_cli_nom').val());
			}
			
		}
	});
}

function cliente_cargar_datos(idf){	
	$.ajax({
		type: "POST",
		url: "../cliente/cliente_reg.php",
		async:true,
		dataType: "json",                      
		data: ({
			action: "obtener_datos",
			cli_id:	idf
		}),
		beforeSend: function() {
			//$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(data){
			$('#hdd_cli_id').val(idf);	
			$('#txt_cli_nom').val(data.nombre);	
			$('#txt_cli_doc').val(data.documento);						
			$('#txt_cli_dir').val(data.direccion);
			$("#hdd_cli_tip").val(data.tipo);
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

$(function() {

	<?php if($_POST['action']=="insertar"){ ?>
	$('#cmb_cue_id').focus();;
	<?php }?>

	cmb_caj_id(<?php echo $caj_id?>);
	cmb_cue_id();
	cmb_subcue_id(<?php echo $cue_id?>);
	cmb_doc_id('6','<?php echo $doc_id?>','<?php echo $_POST['action']?>');

	$('#cmb_doc_id').change(function(event) {
		//ingreso_txt_numdoc();
	});
	
	//$('#txt_ing_numdoc').attr('readonly', 'readonly');

	$( "#txt_cli_doc" ).autocomplete({
   		minLength: 1,
   		source: "../clientes/cliente_complete_doc.php",
		select: function(event, ui){			
			$("#hdd_cli_id").val(ui.item.id);
			$("#txt_cli_nom").val(ui.item.nombre);
			$("#txt_cli_dir").val(ui.item.direccion);
			$("#hdd_cli_tip").val(ui.item.tipo);
		}
    });

	$( "#txt_cli_nom" ).autocomplete({
   		minLength: 1,
   		source: "../clientes/cliente_complete_nom.php",
		select: function(event, ui){			
			$("#hdd_cli_id").val(ui.item.id);							
			$("#txt_cli_doc").val(ui.item.documento);
			$("#txt_cli_dir").val(ui.item.direccion);
			$("#hdd_cli_tip").val(ui.item.tipo);	
		}
    });
	
	$('#cmb_cue_id').change(function(){
		cmb_subcue_id($('#cmb_cue_id').val());
	});
	
	$('#txt_ing_det').autocomplete({
		minLength: 1,
		source: "../ingreso/ingreso_complete_det.php"
	});

	$('#txt_ing_det').change(function(){
		$(this).val($(this).val().toUpperCase());
	});

	<?php if($_POST['vista']=='venta_ingreso_tabla'){ ?>
		$('#txt_ing_imp').change(function(){
			//alert($('#txt_ing_imp').autoNumericGet());
			//alert(<?php echo $imp_max?>);
			if($('#txt_ing_imp').autoNumericGet()><?php echo $imp_max?>)
			{
				alert('<?php echo "Importe debe ser menor o igual a: ".formato_money($imp_max);?>');
				$('#txt_ing_imp').val('<?php echo formato_money($imp_max);?>');
			}
		});

	<?php }?>
	<?php if($_POST['action']=="editar"){ ?>

	$('#txt_cli_doc,#txt_cli_nom,#cmb_doc_id,#txt_ing_numdoc').attr('disabled','disabled');

	<?php }?>

	$( "#div_cliente_form" ).dialog({
		title:'Información de Cliente',
		autoOpen: false,
		resizable: false,
		height: 300,
		width: 530,
		zIndex: 4,
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
					$('#div_venta_ingreso_form').dialog("close");
					$('#msj_ingreso').html("Guardando...");
					$('#msj_ingreso').show(100);
				},
				success: function(data){
					$('#msj_ingreso').html(data.ing_msj);
					if(data.ing_act=='imprimir')
					{
						ingreso_impresion(data.ing_id);
					}
				},
				complete: function(){
					<?php
					if($_POST['vista']=="ingreso_tabla")
					{
						echo $_POST['vista'].'();';
					}
					if($_POST['vista']=="venta_ingreso_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			txt_ing_fec: {
				required: true,
				dateITA: true
			},
			cmb_doc_id: {
				required: true
			},
			txt_ing_numdoc: {
				required: true
			},
			txt_ing_det: {
				required: true
			},
			hdd_cli_id: {
				required: true
			},
			cmb_caj_id: {
				required: true
			},
			cmb_cue_id: {
				required: true
			},
			txt_ing_imp: {
				required: true
			},
			cmb_ing_est: {
				required: true
			}
		},
		messages: {
			txt_ing_fec: {
				required: '*'
			},
			cmb_doc_id: {
				required: '*'
			},
			txt_ing_numdoc: {
				required: '*'
			},
			txt_ing_det: {
				required: '*'
			},
			hdd_cli_id: {
				required: 'Seleccione Cliente.'
			},
			cmb_caj_id: {
				required: '*'
			},
			cmb_cue_id: {
				required: '*'
			},
			txt_ing_imp: {
				required: '*'
			},
			cmb_ing_est: {
				required: '*'
			}
		}
	});

});
</script>
<div>
<form id="for_ing">
<input type="hidden" id="action_ingreso" name="action_ingreso" value="<?php echo $_POST['action']?>">
<input type="hidden" id="hdd_ing_id" name="hdd_ing_id" value="<?php echo $_POST['ing_id']?>">
<input type="hidden" id="hdd_ing_usureg" name="hdd_ing_usureg" value="<?php echo $_SESSION['usuario_id']?>">
<input type="hidden" id="hdd_ing_usumod" name="hdd_ing_usumod" value="<?php echo $_SESSION['usuario_id']?>">
<input type="hidden" id="hdd_emp_id" name="hdd_emp_id" value="<?php echo $_SESSION['empresa_id']?>">
<input type="hidden" id="hdd_ven_id" name="hdd_ven_id" value="<?php echo $ven_id?>">
<input type="hidden" id="hdd_tra_id" name="hdd_tra_id" value="<?php echo $tra_id?>">

  <table border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td align="right"><label for="txt_ing_fec">Fecha:</label></td>
      <td><input name="txt_ing_fec" type="text" class="fecha" id="txt_ing_fec" value="<?php echo $fec?>" size="10" maxlength="10"></td>
      <td align="right"><label for="cmb_caj_id">Caja:</label></td>
      <td>
        <select name="cmb_caj_id" id="cmb_caj_id">
        </select></td>
    </tr>
    <tr>
      <td align="right"><label for="cmb_cue_id">Cuenta:</label></td>
      <td><select name="cmb_cue_id" id="cmb_cue_id">
        </select></td>
      <td align="right"><label for="cmb_subcue_id">Sub Cuenta:</label></td>
      <td><select name="cmb_subcue_id" id="cmb_subcue_id">
        </select></td>
    </tr>
    <tr>
    	<td align="right" valign="top">
    	<?php if($_POST['action']=='insertar'){?>
    		<a id="btn_cli_form_agregar" href="#" onClick="cliente_form_i('insertar')">Agregar Cliente</a>
    	<?php }?>
    		<a id="btn_cli_form_modificar" href="#" onClick="cliente_form_i('editar',$('#hdd_cli_id').val())">Modificar Cliente</a>
    	<label for="txt_cli_doc">RUC/DNI:</label>
    	</td>
    	<td colspan="3">
    		<input name="txt_cli_doc" type="text" id="txt_cli_doc" value="<?php echo $cli_doc?>" size="12" maxlength="11" /> 
    		<label for="txt_cli_nom">Cliente:</label>
    		<input type="text" id="txt_cli_nom" name="txt_cli_nom" size="61" value="<?php echo $cli_nom?>" />
    		<br>
    		<input type="hidden" id="hdd_cli_id" name="hdd_cli_id" value="<?php echo $cli_id?>" />
    	</td>
    </tr>
    <tr>
      <td align="right"><label for="cmb_doc_id">Documento:</label></td>
      <td><select name="cmb_doc_id" id="cmb_doc_id">
        </select></td>
      <td align="right"><label for="txt_ing_numdoc">N°. Doc.:</label></td>
      <td><input name="txt_ing_numdoc" type="text" id="txt_ing_numdoc"  value="<?php echo $numdoc?>"></td>
    </tr>
    <tr>
      <td align="right" valign="top"><label for="txt_ing_det">Detalle:</label></td>
      <td colspan="3"><textarea name="txt_ing_det" cols="80" rows="3" id="txt_ing_det"><?php echo $det?></textarea></td>
    </tr>

    <tr>
      <td align="right"><label for="txt_ing_imp">Importe:</label></td>
      <td><input type="text" name="txt_ing_imp" id="txt_ing_imp" class="moneda2" style="text-align:right" size="15" maxlength="12" value="<?php echo formato_money($imp)?>" <?php if($_POST['action2']=='caja')echo 'readonly'?>></td>
      <td align="right"><label for="cmb_ing_est">Estado:</label></td>
      <td><select name="cmb_ing_est" id="cmb_ing_est">
        <option value="">-</option>
        <option value="1" <?php if($est==1)echo 'selected'?>>CANCELADO</option>
        <?php if($_POST['vista']!='venta_ingreso_tabla'){?>
        <option value="2" <?php if($est==2)echo 'selected'?>>EMITIDO</option>
        <?php }?>
      </select></td>
      </tr>

      <tr>
      <td align="right"></td>
      <td>
      	<?php if($_POST['action']=="insertar"){?>
        <label for="chk_imprimir">Imprimir Documento</label>
        <input name="chk_imprimir" type="checkbox" id="chk_imprimir" value="1">
        <?php }?>
      </td>
      <td align="right"></td>
      <td></td>
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
		  echo 'Registrado por: '.$usuario_reg.', el '.$fecreg;
	  }
	  ?></td>
      </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
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
	<div id="div_cliente_form">
	</div>

</div>