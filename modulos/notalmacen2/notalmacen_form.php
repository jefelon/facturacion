<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();

require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
	
	/*$dts= $oNotalmacen->mostrar_codigo();
	$dt = mysql_fetch_array($dts);
		$cod=$dt['numero']+1;
		$cod=str_pad($cod,4, "0", STR_PAD_LEFT);
	mysql_free_result($dts);*/
	
}

if($_POST['action']=="editar"){
	$dts= $oNotalmacen->mostrarUno($_POST['notalm_id']);
	$dt = mysql_fetch_array($dts);
		
		$tipreg	=$dt['tb_notalmacen_tipreg'];
	
		$fec	=mostrarFecha($dt['tb_notalmacen_fec']);
		$cod	=$dt['tb_notalmacen_cod'];
		$tip	=$dt['tb_notalmacen_tip'];
		
		$doc_id	=$dt['tb_documento_id'];
		$numdoc	=$dt['tb_notalmacen_numdoc'];
		
		$tipope =$dt['tb_tipoperacion_id'];
		
		$ope_id =$dt['tb_operacion_id'];
		
		$des	=$dt['tb_notalmacen_des'];
		$alm_id	=$dt['tb_almacen_id'];

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
$(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$( "#txt_notalm_fec" ).datepicker({
	//minDate: "-1M", 
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

function cmb_alm_id()
{	
	$.ajax({
		type: "POST",
		url: "../almacen/cmb_alm_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			alm_id: '<?php echo $alm_id?>'
		}),
		beforeSend: function() {
			$('#cmb_alm_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_alm_id').html(html);
		}
	});
}

function notalmacen_car(act,idf)
{
	if(act=='agregar')
	{
		var stouni=$('#hdd_cat_stouni_'+idf).val();
		var cantidad=$('#txt_cat_can_'+idf).val();
		
		var dif=$('#hdd_cat_stouni_'+idf).val()-$('#txt_cat_can_'+idf).val();
	}
	
	
	if(act=='agregar' & (dif < 0))
	{
		alert('Stock insuficiente. Diferencia en '+(cantidad-stouni)+'.');
		$('#txt_cat_can_'+idf).val(stouni);
	}
	else
	{
		$.ajax({
			type: "POST",
			url: "../notalmacen/notalmacen_car.php",
			async:true,
			dataType: "html",                      
			data: ({
				action:	 act,
				cat_id:	 idf,
				cat_can: $('#txt_cat_can_'+idf).val(),
				alm_id: $('#cmb_alm_id').val(),
				tipo:	$('#cmb_notalm_tip').val()	
			}),
			beforeSend: function() {
				$('#div_notalmacen_car_tabla').addClass("ui-state-disabled");
			},
			success: function(html){			
				$('#div_notalmacen_car_tabla').html(html);
			},
			complete: function(){			
				$('#div_notalmacen_car_tabla').removeClass("ui-state-disabled");
			}
		});
	}
}

var vista_alm_cat=0;

function catalogo_notalmacen(){
	if($('#cmb_alm_id').val()!='' & $('#cmb_notalm_tip').val()!='')
	{
		vista_alm_cat=1;		
		$.ajax({
			type: "POST",
			url: "../catalogo/catalogo_notalmacen.php",
			async:true,
			dataType: "html",                      
			data: ({
				//action: act,
				//tipo:	$('#cmb_notalm_tip').val()
			}),
			beforeSend: function() {
				$('#msj_notalmacen').hide();
				$('#div_catalogo_notalmacen').dialog("open");
				$('#div_catalogo_notalmacen').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
			},
			success: function(html){
				$('#div_catalogo_notalmacen').html(html);				
			}
		});
	}
	else
	{
		alert('Por favor seleccione Almacén y Tipo para mostrar Catálogo.');
		$('#div_catalogo_notalmacen').dialog("close");
	}
}

function editar_datos_item(idf, nom){	
	$.ajax({
		type: "POST",
		url: "../notalmacen/notalmacen_car_item.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id:	idf,
			action: "editar",
			alm_id: $('#cmb_alm_id').val(),
			pro_nom: nom
		}),
		beforeSend: function() {			
			//$('#msj_proveedor').hide();
			$(".btn_item").click(function(e){
			  x=e.pageX-200;
			  y=e.pageY+15;
			  $('#div_item_form').dialog({ position: [x,y] });
			  $('#div_item_form').dialog("open");			  
		    });
			$('#div_item_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
		},
		success: function(html){						
			$('#div_item_form').html(html);				
		}
	});
}
function txt_notalm_cod(){	
	$.ajax({
		type: "POST",
		url: "../notalmacen/notalmacen_txt_cod.php",
		async:true,
		dataType: "json",                      
		data: ({
			alm_id: $('#cmb_alm_id').val(),
			doc_id: '3'
		}),
		beforeSend: function() {
			$('#txt_notalm_cod').val('Cargando...');			
        },
		success: function(data){	
			$('#txt_notalm_cod').val(data.numero);
			if(data.msj!="")
			{
				$('#msj_talonario').html(data.msj);
				$('#msj_talonario').show(100);
			}
			else
			{
				$('#msj_talonario').hide();
			}
		}
	});
}
function cmb_doc_id(tip,idf)
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:tip,
			doc_id: idf,
			vista:	'<?php echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_doc_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_doc_id').html(html);
		}
	});
}
function cmb_tipope_id(man,tip,idf)
{	
	$.ajax({
		type: "POST",
		url: "../tipoperacion/cmb_tipope_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			tipope_man:	man,
			tip_id:	tip,
			tipope_id: idf
		}),
		beforeSend: function() {
			$('#cmb_tipope_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_tipope_id').html(html);
		}
	});
}
function notalmacen_detalle_tabla()
{
	$.ajax({
		type: "POST",
		url: "notalmacen_detalle_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			notalm_id:	'<?php echo $_POST['notalm_id']?>'
		}),
		beforeSend: function() {
			$('#div_notalmacen_detalle_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_notalmacen_detalle_tabla').html(html);
		},
		complete: function(){			
			$('#div_notalmacen_detalle_tabla').removeClass("ui-state-disabled");
		}
	});     
}

$(function() {
	
	$("#txt_notalm_cod").addClass("ui-state-active");
	
	cmb_alm_id();
	
	<?php
	if($_POST['action']=="insertar"){
	?>
	
	cmb_doc_id('4','');
	
	notalmacen_car('restablecer');
	notalmacen_car();
	$('#cmb_alm_id').change( function() {
		txt_notalm_cod();
		
		if(vista_alm_cat==1)
		{
			notalmacen_car('restablecer');
			catalogo_notalmacen();
		}
	});
	$('#cmb_notalm_tip').change( function() {
		
		cmb_tipope_id('1',$('#cmb_notalm_tip').val(),'');
		
		if(vista_alm_cat==1)
		{
			notalmacen_car('restablecer');
			catalogo_notalmacen();
		}
	});
	<?php
	}
	if($_POST['action']=="editar"){
	?>
	cmb_alm_id();
	cmb_tipope_id('',$('#cmb_notalm_tip').val(),<?php echo $tipope?>);
	
	cmb_doc_id('','<?php echo $doc_id?>');
	
	$('#cmb_alm_id').attr('disabled', 'disabled');
	$('#cmb_notalm_tip').attr('disabled', 'disabled');
	
	$('#cmb_tipope_id').attr('disabled', 'disabled');
	
	$('#txt_notalm_des').attr('disabled', 'disabled');
	$('#txt_notalm_numdoc').attr('disabled', 'disabled');
	
	notalmacen_detalle_tabla();
	<?php }?>
	
	$( "#div_catalogo_notalmacen" ).dialog({
		title:'Catálogo de Nota de Almacén',
		autoOpen: false,
		resizable: false,
		height: 350,
		width: 900,
		modal: false,
		position: "bottom"/*,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}*/
	});
	
	$( "#div_item_form" ).dialog({
		title:'Información de Item',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 220,
		//modal: true,
		buttons: {
			Actualizar: function() {
				$("#for_item").submit();
			},
			Cancelar: function() {
				$('#for_item').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
//formulario			
	$("#for_notalm").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../notalmacen/notalmacen_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_notalm").serialize(),
				beforeSend: function(){
					$('#div_notalmacen_form').dialog("close");
					$('#msj_notalmacen').html("Guardando...");
					$('#msj_notalmacen').show(100);
				},
				success: function(data){
					$('#msj_notalmacen').html(data.notalm_msj);
					if(data.notalm_act=='imprime')
					{
						notalmacen_impresion(data.notalm_id);
					}
				},
				complete: function(){
					notalmacen_tabla();
				}
			});			
		},
		rules: {
			txt_notalm_fec: {
				required: true,
				dateITA: true
			},
			cmb_alm_id: {
				required: true
			},
			txt_notalm_cod: {
				required: true
			},
			cmb_notalm_tip: {
				required: true
			},
			cmb_tipope_id: {
				required: true
			},
			cmb_doc_id: {
				required: true
			},
			txt_notalm_numdoc: {
				required: true
			},
			txt_notalm_des: {
				required: true
			},
			hdd_notalm_numite: {
				required: true
			},
		},
		messages: {
			txt_notalm_fec: {
				required: '*'
			},
			cmb_alm_id: {
				required: '*'
			},
			txt_notalm_cod: {
				required: '*'
			},
			cmb_notalm_tip: {
				required: '*'
			},
			cmb_tipope_id: {
				required: '*'
			},
			cmb_doc_id: {
				required: '*'
			},
			txt_notalm_numdoc: {
				required: '*'
			},
			txt_notalm_des: {
				required: '*'
			},
			hdd_notalm_numite: {
				required: 'Agregue producto a detalle.'
			}
		}
	});
	
	$(document).shortkeys({
		'a+p':       function () { catalogo_notalmacen() }
		
		<?php
		if($_POST['action']=="editar"){
		?>
		,'Shift+p':   function () { notalmacen_impresion('<?php echo $_POST['notalm_id']?>') }
		<?php }?>
	});
	
});
</script>
<div>
<form id="for_notalm">
<input name="action_notalmacen" id="action_notalmacen" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_notalm_id" id="hdd_notalm_id" type="hidden" value="<?php echo $_POST['notalm_id']?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $_SESSION['empresa_id']?>">
<fieldset>
  <legend>Datos Principales</legend>
  <!--<label for="cmb_notalm_est">Estado:</label>
          <select name="cmb_notalm_est" id="cmb_notalm_est">
            <option value="">-</option>
            <option value="EMITIDA" <?php //if($est=='EMITIDA')echo 'selected'?>>EMITIDA</option>
            <option value="CANCELADA" <?php //if($est=='CANCELADA')echo 'selected'?>>CANCELADA</option>
          </select>-->
      <table border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td align="right" valign="top"><label for="txt_notalm_fec">Fecha:</label></td>
    <td valign="top"><input name="txt_notalm_fec" type="text" class="fecha" id="txt_notalm_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly></td>
    <td align="right" valign="top"><label for="cmb_alm_id">Almacén:</label></td>
    <td valign="top"><select name="cmb_alm_id" id="cmb_alm_id">
    </select></td>
    <td align="right" valign="top"><label for="txt_notalm_cod">Código:</label></td>
    <td valign="top"><input name="txt_notalm_cod" type="text" id="txt_notalm_cod" size="15" maxlength="15" readonly value="<?php echo $cod?>" style="text-align:right; font-size:10pt;">
      <div id="msj_talonario" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
    </tr>
  <tr>
    <td align="right" valign="top"><label for="cmb_notalm_tip">Tipo:</label></td>
    <td valign="top"><select name="cmb_notalm_tip" id="cmb_notalm_tip">
      <option value="">-</option>
      <option value="1" <?php if($tip==1)echo 'selected'?>>ENTRADA (Aumentar Stock)</option>
      <option value="2" <?php if($tip==2)echo 'selected'?>>SALIDA (Disminuir Stock)</option>
      </select></td>
    <td align="right" valign="top"><label for="cmb_tipope_id">Tipo Operación:</label></td>
    <td valign="top"><select name="cmb_tipope_id" id="cmb_tipope_id">
      </select></td>
    <td align="right" valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="top"><label for="cmb_doc_id">Documento:</label></td>
    <td valign="top"><select name="cmb_doc_id" id="cmb_doc_id" <?php if($_POST['action']=='editar')echo 'disabled'?>>
    </select></td>
    <td rowspan="2" align="right" valign="top"><label for="txt_notalm_des">Descripción:</label></td>
    <td rowspan="2" valign="top"><textarea name="txt_notalm_des" cols="50" rows="2" id="txt_notalm_des"><?php echo $des?></textarea></td>
    <td colspan="2" align="right" valign="top"><?php if($_POST['action']=="insertar"){?>
      <label for="chk_imprimir">Imprimir Documento</label>
      <input name="chk_imprimir" type="checkbox" id="chk_imprimir" value="1">
      <?php }?>
      <?php
      if($_POST['action']=="editar"){
	  ?>
      <a class="btn_imp" title="Imprimir (Shift+P)" href="#" onClick="notalmacen_impresion('<?php echo $_POST['notalm_id']?>')">Imprimir</a>
      <?php }?></td>
    </tr>
  <tr>
    <td align="right" valign="top"><label for="txt_notalm_numdoc">N° Doc:</label></td>
    <td valign="top"><input type="text" name="txt_notalm_numdoc" id="txt_notalm_numdoc" value="<?php echo $numdoc?>"></td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
      </table>
</fieldset>

<?php
if($_POST['action']=="insertar"){
?>
<div id="div_notalmacen_car_tabla">
</div>
<div id="div_item_form">
</div>
<?php }?>
</form>
</div>
<?php
if($_POST['action']=="insertar"){
?>
<div id="div_catalogo_notalmacen">
</div>
<?php
}
if($_POST['action']=="editar"){
?>
<br>
<div id="div_notalmacen_detalle_tabla">
</div>
<?php }?>