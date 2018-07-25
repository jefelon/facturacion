<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../notadebito/cNotadebito.php");
$oNotadebito = new cNotadebito();

require_once("../formatos/formato.php");
require_once("../menu/acceso.php");

if($_POST['action']=="insertar"){
	//$cli_id=1;
	$fec=date('d-m-Y');
	$est='CANCELADA';
	$venpag_fec=date('d-m-Y');
}

if($_POST['action']=="editar"){
	$dts= $oNotadebito->mostrarUno($_POST['ven_id']);
	$dt = mysql_fetch_array($dts);
		$reg	=mostrarFechaHora($dt['tb_venta_reg']);
		
		$fec	=mostrarFecha($dt['tb_venta_fec']);
		
		$doc_id	=$dt['tb_documento_id'];
		//$numdoc	=$dt['tb_venta_numdoc'];
		$ser	=$dt['tb_venta_ser'];
		$num	=$dt['tb_venta_num'];
		$cli_id	=$dt['tb_cliente_id'];
		$cli_nom = $dt['tb_cliente_nom'];
		$cli_doc = $dt['tb_cliente_doc'];
		$cli_dir = $dt['tb_cliente_dir'];
		$cli_tip = $dt['tb_cliente_tip'];
		
		$subtot	=$dt['tb_venta_subtot'];
		$igv	=$dt['tb_venta_igv'];
		$tot	=$dt['tb_venta_tot'];
		$est	=$dt['tb_venta_est'];
		
		$punven_nom	=$dt['tb_puntoventa_nom'];
		$alm_nom	=$dt['tb_almacen_nom'];
		
		$vennumdoc	=$dt['tb_venta_vennumdoc'];
		$mot	=$dt['tb_venta_mot'];
		$lab3	=$dt['tb_venta_lab3'];
		
		$may	=$dt['tb_venta_may'];
	mysql_free_result($dts);
}
?>
<script type="text/javascript">
$('.btn_imp').button({
	icons: {primary: "ui-icon-print"},
	text: false
});

$('.btn_ir').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});

$('.btn_newwin').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});

$('.btn_cli_reg').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});
$(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

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

$( "#txt_ven_fec" ).datepicker({
	minDate: "-0D", 
	maxDate:"+0D",
	yearRange: 'c-0:c+0',
	changeMonth: true,
	changeYear: false,
	dateFormat: 'dd-mm-yy',
	//altField: fecha,
	//altFormat: 'yy-mm-dd',
	showOn: "button",
	buttonImage: "../../images/calendar.gif",
	buttonImageOnly: true
});

function cmb_ven_doc()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'10',
			doc_id: '<?php echo $doc_id?>',
			vista:	'<?php echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_ven_doc').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_ven_doc').html(html);
		},
		complete: function(){
			<?php if($_POST['action']=="insertar"){?>
			//txt_ven_numdoc();
			<?php }?>
		}
	});
}

function venta_detalle_tabla()
{
	$.ajax({
		type: "POST",
		url: "../notadebito/venta_detalle_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			ven_id:	'<?php echo $_POST['ven_id']?>'
		}),
		beforeSend: function() {
			$('#div_venta_detalle_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_venta_detalle_tabla').html(html);
		},
		complete: function(){			
			$('#div_venta_detalle_tabla').removeClass("ui-state-disabled");
		}
	});     
}


$(function() {
	
	cmb_ven_doc();

	$("#txt_ven_numdoc").addClass("ui-state-active");
	
	$('#txt_ven_cli_nom').change(function(){
		$(this).val($(this).val().toUpperCase());
	});
	

	$( "#txt_ven_cli_doc" ).autocomplete({
   		minLength: 1,
   		source: "../clientes/cliente_complete_doc.php",
		select: function(event, ui){			
			$("#hdd_ven_cli_id").val(ui.item.id);
			$("#txt_ven_cli_nom").val(ui.item.nombre);
			$("#txt_ven_cli_dir").val(ui.item.direccion);
			$("#hdd_ven_cli_tip").val(ui.item.tipo);
			clientecuenta_detalle(ui.item.id);
			//alert(ui.item.value);
			$('#msj_busqueda_sunat').html("Buscando en Sunat...");
			$('#msj_busqueda_sunat').show(100);
			compararSunat(ui.item.value, ui.item.nombre, ui.item.direccion, ui.item.id);
		}
    });
	
	$( "#txt_ven_cli_nom" ).autocomplete({
   		minLength: 1,
   		source: "../clientes/cliente_complete_nom.php",
		select: function(event, ui){			
			$("#hdd_ven_cli_id").val(ui.item.id);							
			$("#txt_ven_cli_doc").val(ui.item.documento);
			$("#txt_ven_cli_dir").val(ui.item.direccion);
			$("#hdd_ven_cli_tip").val(ui.item.tipo);
			clientecuenta_detalle(ui.item.id);
			//alert(ui.item.value);
			$('#msj_busqueda_sunat').html("Buscando en Sunat...");
			$('#msj_busqueda_sunat').show(100);
			compararSunat(ui.item.documento, ui.item.value, ui.item.direccion, ui.item.id);
		}
    });
	
	<?php
	if($_POST['action']=="insertar"){
	?>
	// $('#cmb_ven_doc').change( function() {
	// 	txt_ven_numdoc();
	// });
	
	// $("#cmb_ven_est").change(function(){
	// 	verificar_numdoc();	
	// 	var est = $("#cmb_ven_est").val();

	// 	if(est == 'ANULADA'){			
	// 		$("#hdd_ven_numite").attr('disabled', 'disabled');
	// 		$("#hdd_ven_cli_id").attr('disabled', 'disabled');	
	// 	}
	// 	if(est == 'CANCELADA'){			
	// 		$("#hdd_ven_numite").attr('disabled', false);
	// 		$("#hdd_ven_cli_id").attr('disabled', false);
	// 	}
	// });
	<?php }?>
	
		
	<?php
	if($_POST['action']=="editar"){
	?>
	venta_detalle_tabla();
	$('#cmb_ven_est').attr('disabled','disabled');
	//$('#hdd_ven_doc').val('1');

	<?php }?>
	
	$( "#div_cliente_form" ).dialog({
		title:'Información de Cliente',
		autoOpen: false,
		resizable: false,
		height: 330,
		width: 530,
		zIndex: 4,
		modal: true,
		position: ["center",0],
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
	$("#for_ven").validate({
		submitHandler: function(){
			$.ajax({
				type: "POST",
				url: "../venta/venta_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_ven").serialize(),
				beforeSend: function(){
						$('#div_venta_form').dialog("close");
						$('#msj_venta').html("Guardando...");
						$('#msj_venta').show(100);
				},
				success: function(data){
					$('#msj_venta').html(data.ven_msj);	

					if(data.ven_sun=='enviar')
					{
						enviar_sunat(data.ven_id,data.ven_act);
					}
					else
					{
						if(data.ven_act=='imprime')
						{
							venta_impresion(data.ven_id);
						}
					}
								
				},
				complete: function(){
					venta_tabla();
				}
			});			
		},
		rules: {
			txt_ven_fec: {
				required: true,
				dateITA: true
			},
			cmb_ven_doc: {
				required: true
			},
			txt_ven_numdoc: {
				required: true
			},
			hdd_ven_cli_id: {
				required: true
			},
			hdd_ven_numite: {
				required: true
			},
			cmb_ven_est: {
				required: true
			},
			hdd_ven_pag_numite: {
				required: true
			},
			hdd_venpag_tot: {
				equalTo: "#txt_ven_tot"
			},
			hdd_ven_cli_tip: {
				equalTo: "#hdd_val_cli_tip"
			},
			hdd_ven_doc: {
				required: true
			}
		},
		messages: {
			txt_ven_fec: {
				required: '*'
			},
			cmb_ven_doc: {
				required: '*'
			},
			txt_ven_numdoc: {
				required: '*'
			},
			hdd_ven_cli_id: {
				required: 'Seleccione Cliente.'
			},
			hdd_ven_numite: {
				required: 'Agregue producto a detalle de venta.'
			},
			cmb_ven_est: {
				required: '*'
			},
			hdd_ven_pag_numite: {
				required: 'Agregue registro de pagos.'
			},
			hdd_venpag_tot: {
				equalTo: "No es igual a Monto Total de Venta."
			},
			hdd_ven_cli_tip: {
				equalTo: "Tipo de cliente no concuerda con tipo de documento."
			},
			hdd_ven_doc: {
				required: "Existe registro con mismo N° Documento."
			}
		}
	});
	
});
</script>
<div>
<form id="for_ven">
<input name="action_venta" id="action_venta" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_ven_id" id="hdd_ven_id" type="hidden" value="<?php echo $_POST['ven_id']?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_SESSION['puntoventa_id']?>">
<input name="hdd_ven_est" id="hdd_ven_est" type="hidden" value="<?php echo $est?>">
<fieldset>
  <legend>Datos Principales</legend>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><label for="txt_ven_fec">Fecha:</label>
        <input name="txt_ven_fec" type="text" class="fecha" id="txt_ven_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly>
        <label for="cmb_ven_doc">Documento:</label>
        <select name="cmb_ven_doc" id="cmb_ven_doc" <?php if($_POST['action']=='editar')echo 'disabled'?>>
        </select>
        <label for="txt_ven_numdoc">N° Doc:</label>
        <input name="txt_ven_numdoc" type="text" id="txt_ven_numdoc" style="text-align:right; font-size:14px"  value="<?php echo $ser.'-'.$num?>" size="13" readonly>
        <?php //if($_POST['action']=="editar")echo $est?>
        <?php if($_POST['action']=="insertar"){?>
        <label for="chk_imprimir">Imprimir Documento</label>
        <input name="chk_imprimir" type="checkbox" id="chk_imprimir" value="1" checked="CHECKED">
        <?php }?>
        </td>
      <td align="right">
      <?php
      if($_POST['action']=="editar")
			{
	  	echo "<span title='PUNTO DE VENTA'>PV: ".$punven_nom."</span>";
			//echo " | A: ".$alm_nom;
	  	}?>
      <?php
      if($_POST['action']=="editar"){
	  ?>
      <a class="btn_imp" title="Imprimir" href="#imprimir" onClick="venta_impresion('<?php echo $_POST['ven_id']?>')">Imprimir</a>
      <?php }?>
      <?php
      $url=ir_principal($_SESSION['usuariogrupo_id']);
	  ?>
      <a class="btn_newwin" target="_blank" title="Saltar a otra pestaña" href="<?php echo $url?>">Saltar</a>
      </td>
    </tr>
    <tr>
      <td height="27">
        <label for="cmb_ven_est">Estado:</label>
        <select name="cmb_ven_est" id="cmb_ven_est">
          <option value="">-</option>
          <option value="CANCELADA" <?php if($est=='CANCELADA')echo 'selected'?>>CANCELADA</option>
          <option value="ANULADA" <?php if($est=='ANULADA')echo 'selected'?>>ANULADA</option>
        </select>

		<label for="txt_ven_vennumdoc">Vinculado:</label>
        <input name="txt_ven_vennumdoc" type="text" id="txt_ven_vennumdoc" style=""  value="<?php echo $vennumdoc?>" size="13" readonly>

        <label for="txt_ven_mot">Motivo:</label>
        <input name="txt_ven_mot" type="text" id="txt_ven_mot" style=""  value="<?php echo $mot?>" size="40" readonly>

        <div id="msj_venta_form" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
        </td>
      <td align="right">
      <?php
      if($_POST['action']=="insertar"){
	  	echo "PV: ".$_SESSION['puntoventa_nom'];
		echo " | A: ".$_SESSION['almacen_nom'];
	  }
	  if($_POST['action']=="editar"){
	  	echo "Registro: $reg";
	  }
	  ?>
      </td>
    </tr>
  </table>
</fieldset>

<input type="hidden" id="hdd_ven_cli_id" name="hdd_ven_cli_id" value="<?php echo $cli_id?>" />
<input type="hidden" id="hdd_ven_cli_tip" name="hdd_ven_cli_tip" value="<?php echo $cli_tip?>" />
<input type="hidden" id="hdd_val_cli_tip" name="hdd_val_cli_tip" value="<?php if($_POST['action']=='editar')echo $cli_tip;?>" />
<fieldset>
	<legend>Datos Cliente</legend>
	<div id="div_cliente_form">
	</div>
	<table>
		<tr>
			<td align="right"><?php if($_POST['action']=='insertar'){?>
				<a id="btn_cli_form_agregar" href="#" onClick="cliente_form_i('insertar')">Agregar Cliente</a>
				<a id="btn_cli_form_modificar" href="#" onClick="cliente_form_i('editar',$('#hdd_ven_cli_id').val())">Modificar Cliente</a>
				<?php }?>
				<label for="txt_ven_cli_doc">RUC/DNI:</label>
			</td>
			<td>
				<input name="txt_ven_cli_doc" type="text" id="txt_ven_cli_doc" value="<?php echo $cli_doc?>" size="12" maxlength="11" /> 
				<label for="txt_ven_cli_nom">Cliente:</label>
				<input type="text" id="txt_ven_cli_nom" name="txt_ven_cli_nom" size="64" value='<?php echo $cli_nom?>' />
			</td>
			<td rowspan="2" valign="top">
				<div id="div_clientecuenta_detalle">
				</div>
			</td>
		</tr>
		<tr>
			<td align="right"><label for="txt_ven_cli_dir">Dirección:</label></td>
			<td><input type="text" id="txt_ven_cli_dir" name="txt_ven_cli_dir" style="width:616px" value="<?php echo $cli_dir?>" disabled="disabled"/></td>
		</tr>
		<tr>
			<td align="right"><label for="txt_ven_cli_est">Estado:</label></td>
			<td>
				<input type="text" id="txt_ven_cli_est" name="txt_ven_cli_est" size="40" value="" disabled="disabled"/>
				<div id="msj_busqueda_sunat" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
			</td>
		</tr>
	</table>
</fieldset>
</form>
</div>

<?php
if($_POST['action']=="editar"){
?>
<br>
<div id="div_venta_detalle_tabla">
</div>
<?php }?>
