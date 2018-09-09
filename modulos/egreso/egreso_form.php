<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../egreso/cEgreso.php");
$oEgreso = new cEgreso();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	//$pro_id=1;
	$fec=date('d-m-Y');
	$est='1';
	//$caj_id=$_POST['caj_id'];
	$caj_id=$_SESSION['caja_id'];

	if($_POST['vista']=='gasto_egreso_tabla'){
		$gas_id 	=$_POST['gas_id'];
		$cue_id 	=$_POST['cue_id'];
		$subcue_id 	=$_POST['subcue_id'];
		$pro_id 	=$_POST['pro_id'];
		$pro_doc 	=$_POST['pro_doc'];
		$pro_nom 	=$_POST['pro_nom'];
		$det 		=$_POST['det'];

		$imp 		=moneda_mysql($_POST['imp']);
		$egr_tot 	=moneda_mysql($_POST['egr_tot']);

		$imp=$imp-$egr_tot;

		$imp_max=$imp;
	}
}

if($_POST['action2']=="caja"){
	$fec=$_POST['ven_fec1'];
	$est='1';
	
	$des=$_POST['egr_des'];
	$mon=formato_money($_POST['egr_mon']);
	
	$cue_id=22;
	
	if($_SESSION['empresa_id']==1)$subcue_id=157;
	if($_SESSION['empresa_id']==2)$subcue_id=158;
	
	$ref_id=$_POST['ref_id'];
	$caj_id=$_POST['caj_id'];
	$entfin_id=$_POST['entfin_id'];
}

if($_POST['action']=="editar"){
	$dts= $oEgreso->mostrarUno($_POST['egr_id']);
	$dt = mysql_fetch_array($dts);
		$fecreg		=mostrarFechaHora($dt['tb_egreso_fecreg']);
		$fecmod		=mostrarFechaHora($dt['tb_egreso_fecmod']);
		$usureg		=$dt['tb_egreso_usureg'];
		$usumod		=$dt['tb_egreso_usumod'];
		
		$fec		=mostrarFecha($dt['tb_egreso_fec']);
		$doc_id 	=$dt['tb_documento_id'];
		$numdoc		=$dt['tb_egreso_numdoc'];
		
		$det		=$dt['tb_egreso_det'];
		
		$cue_id		=$dt['tb_cuenta_id'];
		$subcue_id	=$dt['tb_subcuenta_id'];

		$pro_id		=$dt['tb_proveedor_id'];
		$pro_nom 	=$dt['tb_proveedor_nom'];
		$pro_doc 	=$dt['tb_proveedor_doc'];
		$pro_dir 	=$dt['tb_proveedor_dir'];
		$pro_tip 	=$dt['tb_proveedor_tip'];
		
		$imp		=$dt['tb_egreso_imp'];
		
		$caj_id		=$dt['tb_caja_id'];

		$gas_id		=$dt['tb_gasto_id'];
		
		$est		=$dt['tb_egreso_est'];
		
	mysql_free_result($dts);

	if($_POST['vista']=='gasto_egreso_tabla'){
		$gas_imp	=moneda_mysql($_POST['imp']);
		$egr_tot 	=moneda_mysql($_POST['egr_tot']);

		$imp_max=$gas_imp-$egr_tot+$imp;
	}
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

$('#btn_pro_form_agregar').button({
	icons: {primary: "ui-icon-plus"},
	text: false
});
$("#btn_pro_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('#btn_pro_form_modificar').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});
$("#btn_pro_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('.moneda2').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999999.9999'
});

$("#txt_egr_fec").datepicker({
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
			//egreso_txt_numdoc();
			<?php }?>
		}
	});
}
function egreso_txt_numdoc(){	
	$.ajax({
		type: "POST",
		url: "../egreso/egreso_txt_numdoc.php",
		async:false,
		dataType: "json",                      
		data: ({
			doc_id: $('#cmb_doc_id').val()
		}),
		beforeSend: function() {
			$('#txt_egr_numdoc').val('...');
        },
		success: function(data){		
			$('#txt_egr_numdoc').val(data.correlativo);
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

function proveedor_form_i(act,idf){
	$.ajax({
		type: "POST",
		url: "../proveedor/proveedor_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			pro_id:	idf,
			vista:	'hdd_pro_id'
		}),
		beforeSend: function() {
			//$('#msj_proveedor').hide();
			$("#btn_pro_form_agregar").click(function(e){
			  x=e.pageX+5;
			  y=e.pageY+15;
			  $('#div_proveedor_form').dialog({ position: [x,y] });
			  $('#div_proveedor_form').dialog("open");
		    });
			
			if(act=='editar'){
				if(idf>0){
					$("#btn_pro_form_modificar").click(function(e){
					  x=e.pageX+5;
					  y=e.pageY+15;
					  $('#div_proveedor_form').dialog({ position: [x,y] });
					  $('#div_proveedor_form').dialog("open");
					});
				}
				else{
					alert('Seleccione Anexo');
				}
			}
		
			$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_proveedor_form').html(html);					
		},
		complete: function(){
			if(act=='insertar' & $('#hdd_pro_id').val()=="")
			{
				$('#txt_pro_doc').val($('#txt_pro_doc').val());
				$('#txt_pro_nom').val($('#txt_pro_nom').val());
			}
			
		}
	});
}

function proveedor_cargar_datos(idf){	
	$.ajax({
		type: "POST",
		url: "../proveedor/proveedor_reg.php",
		async:true,
		dataType: "json",                      
		data: ({
			action: "obtener_datos",
			pro_id:	idf
		}),
		beforeSend: function() {
			//$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(data){
			$('#hdd_pro_id').val(idf);	
			$('#txt_pro_nom').val(data.nombre);	
			$('#txt_pro_doc').val(data.documento);						
			$('#txt_pro_dir').val(data.direccion);
			$("#hdd_pro_tip").val(data.tipo);
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

$(function() {

	<?php if($_POST['action']=="insertar"){ ?>
	$('#cmb_cue_id').focus();;
	<?php }?>
	
	cmb_caj_id(<?php echo $caj_id?>);
	cmb_cue_id();
	cmb_subcue_id(<?php echo $cue_id?>);

	cmb_doc_id('7','<?php echo $doc_id?>','<?php echo $_POST['action']?>');
	$('#cmb_doc_id').change(function(event) {
		//egreso_txt_numdoc();
	});
	//$('#txt_egr_numdoc').attr('readonly', 'readonly');

	$( "#txt_pro_doc" ).autocomplete({
   		minLength: 1,
   		source: "../proveedor/proveedor_complete_doc.php",
		select: function(event, ui){			
			$("#hdd_pro_id").val(ui.item.id);
			$("#txt_pro_nom").val(ui.item.nombre);
			$("#txt_pro_dir").val(ui.item.direccion);
			$("#hdd_pro_tip").val(ui.item.tipo);
		}
    });

	$( "#txt_pro_nom" ).autocomplete({
   		minLength: 1,
   		source: "../proveedor/proveedor_complete_nom.php",
		select: function(event, ui){			
			$("#hdd_pro_id").val(ui.item.id);							
			$("#txt_pro_doc").val(ui.item.documento);
			$("#txt_pro_dir").val(ui.item.direccion);
			$("#hdd_pro_tip").val(ui.item.tipo);	
		}
    });
	
	$('#cmb_cue_id').change(function(){
		cmb_subcue_id($('#cmb_cue_id').val());
	});
	
	$('#txt_egr_det').autocomplete({
		minLength: 1,
		source: "../egreso/egreso_complete_det.php"
	});

	$('#txt_egr_det').change(function(){
		$(this).val($(this).val().toUpperCase());
	});

	<?php if($_POST['vista']=='gasto_egreso_tabla'){ ?>
		$('#txt_egr_imp').change(function(){
			//alert($('#txt_egr_imp').autoNumericGet());
			//alert(<?php echo $imp_max?>);
			if($('#txt_egr_imp').autoNumericGet()><?php echo $imp_max?>)
			{
				alert('<?php echo "Importe debe ser menor o igual a: ".formato_money($imp_max);?>');
				$('#txt_egr_imp').val('<?php echo formato_money($imp_max);?>');
			}
		});

	<?php }?>

	<?php if($_POST['action']=="editar"){ ?>

	$('#txt_pro_doc,#txt_pro_nom,#cmb_doc_id,#txt_egr_numdoc').attr('disabled','disabled');

	<?php }?>

	$( "#div_proveedor_form" ).dialog({
		title:'Información de Anexo',
		autoOpen: false,
		resizable: false,
		height: 330,
		width: 530,
		zIndex: 4,
		//modal: true,
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
	$("#for_egr").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../egreso/egreso_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_egr").serialize(),
				beforeSend: function(){
					$('#div_egreso_form').dialog("close");
					$('#div_gasto_egreso_form').dialog("close");
					$('#msj_egreso').html("Guardando...");
					$('#msj_egreso').show(100);
				},
				success: function(data){
					$('#msj_egreso').html(data.egr_msj);
					if(data.egr_act=='imprimir')
					{
						egreso_impresion(data.egr_id);
					}
				},
				complete: function(){
					<?php
					if($_POST['vista']=="egreso_tabla")
					{
						echo $_POST['vista'].'();';
					}
					if($_POST['vista']=="gasto_egreso_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			txt_egr_fec: {
				required: true,
				dateITA: true
			},
			cmb_doc_id: {
				required: true
			},
			txt_egr_numdoc: {
				required: true
			},
			txt_egr_det: {
				required: true
			},
			hdd_pro_id: {
				required: true
			},
			cmb_caj_id: {
				required: true
			},
			cmb_cue_id: {
				required: true
			},
			txt_egr_imp: {
				required: true
			},
			cmb_egr_est: {
				required: true
			}
		},
		messages: {
			txt_egr_fec: {
				required: '*'
			},
			cmb_doc_id: {
				required: '*'
			},
			txt_egr_numdoc: {
				required: '*'
			},
			txt_egr_det: {
				required: '*'
			},
			hdd_pro_id: {
				required: 'Seleccione Anexo.'
			},
			cmb_caj_id: {
				required: '*'
			},
			cmb_cue_id: {
				required: '*'
			},
			txt_egr_imp: {
				required: '*'
			},
			cmb_egr_est: {
				required: '*'
			}
		}
	});

});
</script>
<div>
<form id="for_egr">
<input type="hidden" id="action_egreso" name="action_egreso" value="<?php echo $_POST['action']?>">
<input type="hidden" id="hdd_egr_id" name="hdd_egr_id" value="<?php echo $_POST['egr_id']?>">
<input type="hidden" id="hdd_egr_usureg" name="hdd_egr_usureg" value="<?php echo $_SESSION['usuario_id']?>">
<input type="hidden" id="hdd_egr_usumod" name="hdd_egr_usumod" value="<?php echo $_SESSION['usuario_id']?>">
<input type="hidden" id="hdd_emp_id" name="hdd_emp_id" value="<?php echo $_SESSION['empresa_id']?>">
<input type="hidden" id="hdd_gas_id" name="hdd_gas_id" value="<?php echo $gas_id?>">
<input type="hidden" id="hdd_tra_id" name="hdd_tra_id" value="<?php echo $tra_id?>">

  <table border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td align="right"><label for="txt_egr_fec">Fecha:</label></td>
      <td><input name="txt_egr_fec" type="text" class="fecha" id="txt_egr_fec" value="<?php echo $fec?>" size="10" maxlength="10"></td>
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
    	<td align="right">
    	<?php if($_POST['action']=='insertar'){?>
    		<a id="btn_pro_form_agregar" href="#" onClick="proveedor_form_i('insertar')">Agregar Anexo</a>
    	<?php }?>
    		<a id="btn_pro_form_modificar" href="#" onClick="proveedor_form_i('editar',$('#hdd_pro_id').val())">Modificar Anexo</a>
    	<label for="txt_pro_doc">RUC/DNI:</label>
    	</td>
    	<td colspan="3">
    		<input name="txt_pro_doc" type="text" id="txt_pro_doc" value="<?php echo $pro_doc?>" size="12" maxlength="11" /> 
    		<label for="txt_pro_nom">Anexo:</label>
    		<input type="text" id="txt_pro_nom" name="txt_pro_nom" size="61" value="<?php echo $pro_nom?>" />
    		<input type="hidden" id="hdd_pro_id" name="hdd_pro_id" value="<?php echo $pro_id?>" />
    	</td>
    </tr>
    <tr>
      <td align="right"><label for="cmb_doc_id">Documento:</label></td>
      <td><select name="cmb_doc_id" id="cmb_doc_id">
        </select></td>
      <td align="right"><label for="txt_egr_numdoc">N°. Doc.:</label></td>
      <td><input name="txt_egr_numdoc" type="text" id="txt_egr_numdoc"  value="<?php echo $numdoc?>"></td>
    </tr>
    <tr>
      <td align="right" valign="top"><label for="txt_egr_det">Detalle:</label></td>
      <td colspan="3"><textarea name="txt_egr_det" cols="80" rows="3" id="txt_egr_det"><?php echo $det?></textarea></td>
    </tr>

    <tr>
      <td align="right"><label for="txt_egr_imp">Importe:</label></td>
      <td><input type="text" name="txt_egr_imp" id="txt_egr_imp" class="moneda2" style="text-align:right" size="15" maxlength="12" value="<?php echo formato_money($imp)?>" <?php if($_POST['action2']=='caja')echo 'readonly'?>></td>
      <td align="right"><label for="cmb_egr_est">Estado:</label></td>
      <td><select name="cmb_egr_est" id="cmb_egr_est">
        <option value="">-</option>
        <option value="1" <?php if($est==1)echo 'selected'?>>CANCELADO</option>
        <option value="2" <?php if($est==2)echo 'selected'?>>EMITIDO</option>
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
	<div id="div_proveedor_form">
	</div>

</div>