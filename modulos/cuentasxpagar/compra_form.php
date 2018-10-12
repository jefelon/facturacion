<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../compra/cCompra.php");
$oCompra = new cCompra();

require_once("../formatos/formato.php");
require_once("../menu/acceso.php");

if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
	$fecven=date('d-m-Y');
	
	unset($_SESSION['precio_car']);
}

if($_POST['action']=="editar"){
	$dts= $oCompra->mostrarUno($_POST['com_id']);
	$dt = mysql_fetch_array($dts);
		$fec	=mostrarFecha($dt['tb_compra_fec']);
		$fecven	=mostrarFecha($dt['tb_compra_fecven']);
		
		$doc_id	=$dt['tb_documento_id'];
		$doc_abr=$dt['tb_documento_abr'];
		$numdoc	=$dt['tb_compra_numdoc'];
		
		$mon	=$dt['tb_compra_mon'];
		$tipcam	=$dt['tb_compra_tipcam'];
		$tipcam2	=$dt['tb_compra_tipcam2'];
		
		$pro_id	=$dt['tb_proveedor_id'];
		$subtot	=$dt['tb_compra_subtot'];
		$des	=$dt['tb_compra_des'];
		$descal	=$dt['tb_compra_descal'];
		$fle	=$dt['tb_compra_fle'];
		$tipfle	=$dt['tb_compra_tipfle'];
		$ajupos	=$dt['tb_compra_ajupos'];
		$ajuneg	=$dt['tb_compra_ajuneg'];
		$valven	=$dt['tb_compra_valven'];
		$igv	=$dt['tb_compra_igv'];
		$tot	=$dt['tb_compra_tot'];
		$alm_id	=$dt['tb_almacen_id'];
		$est	=$dt['tb_compra_est'];
	mysql_free_result($dts);
}
?>
<script type="text/javascript">
$('.btn_newwin').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$('#btn_pro_form_agregar').button({
	icons: {primary: "ui-icon-plus"},
	text: false
});
$('#btn_agregar_gasto').button({
	icons: {primary: "ui-icon-plus"},
	text: false
});

$("#btn_pro_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('#btn_pro_form_modificar').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});
$("#btn_pro_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$( "#txt_com_fec" ).datepicker({
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

$( "#txt_com_fecven" ).datepicker({
	minDate: "0D", 
	//maxDate:"+0D",
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

function cmb_pro_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../proveedor/cmb_pro_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id: ids
		}),
		beforeSend: function() {
			$('#cmb_pro_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_pro_id').html(html);
		}
	});
}

function cmb_com_doc()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'1',
			doc_id: '<?php echo $doc_id?>',
			vista:	'<?php echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_com_doc').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_com_doc').html(html);
		}
	});
}

function cmb_com_alm_id()
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
			$('#cmb_com_alm_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_com_alm_id').html(html);
		}
	});
}

function compra_detalle_tabla()
{
	$.ajax({
		type: "POST",
		url: "./compra_detalle_tabla.php",
		async:false,
		dataType: "html",                      
		data: ({
			com_id:	'<?php echo $_POST['com_id']?>'
		}),
		beforeSend: function() {
			$('#div_compra_detalle_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_compra_detalle_tabla').html(html);
		},
		complete: function(){			
			$('#div_compra_detalle_tabla').removeClass("ui-state-disabled");
		}
	});     
}

//adicionales

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
			$('#hdd_com_pro_id').val(idf);	
			$('#txt_com_pro_nom').val(data.nombre);	
			$('#txt_com_pro_doc').val(data.documento);			
			$('#txt_com_pro_dir').val(data.direccion);
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
			vista:	'hdd_pro_id'
		}),
		beforeSend: function() {
			//$('#msj_proveedor').hide();
			//$("#btn_cmb_pro_id").click(function(e){
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
					alert('Seleccione Proveedor');
				}
			}
		
			$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_proveedor_form').html(html);					
		}
	});
}

//REGISTRO DE PAGOS
function gasto_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../gasto_r/gasto_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			action2: 'pago',
			gas_id:	idf,
			com_id: '<?php echo $_POST['com_id']?>',
			glosa:	'<?php echo 'PAGO DE '.$doc_abr.' '.$numdoc?>',
			//com_tot: '<?php echo $tot*$tipcam?>',
			com_tot: $('#gasto_res').val(),
			vista: 'gasto_tabla'
		}),
		beforeSend: function() {
			//$('#msj_gasto').hide();
			$('#msj_gasto').hide();
			$('#div_gasto_form').dialog("open");
			$('#div_gasto_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_gasto_form').html(html);				
		}
	});
}
function gasto_eliminar(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../gasto_r/gasto_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				gas_id:		id
			}),
			beforeSend: function() {
				$('#msj_gasto').html("Cargando...");
				$('#msj_gasto').show(100);
			},
			success: function(html){
				$('#msj_gasto').html(html);
				$('#msj_gasto').show();
			},
			complete: function(){
				gasto_tabla();
			}
		});
	}
}
function gasto_tabla()
{
	$.ajax({
		type: "POST",
		url: "../cuentasxpagar/gasto_tabla.php",
		async:false,
		data: ({
			com_id: '<?php echo $_POST['com_id']?>',
			//com_tot: '<?php //echo $tot*$tipcam2?>',
			com_tot:	$('#txt_com_tot_sol').val(),
			com_est: '<?php echo $est?>'
		}),
		beforeSend: function() {
			$('#div_gasto_tabla').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_gasto_tabla').html(html);
		},
		complete: function(){			
			$('#div_gasto_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function compra_obs()
{
	var com_est	=$("#cmb_com_est").val();
	var gas_tot	=$("#gasto_total").val();
	//var com_tot	=<?php //if($tot*$tipcam2>0){ echo $tot*$tipcam2;} else {echo 0;}?>;
	var com_tot	=$('#txt_com_tot_sol').autoNumericGet();
	var mostrar=0;
	var msj;
	
	//alert(com_est);
	//alert(gas_tot);
	//alert(com_tot);
	
	if(com_est=='CREDITO')
	{
		if(gas_tot!='n')
		{
			msj='FACTURA EMITIDA. Factura tiene registro en Pagos. Debe tener estado de PAGO PARCIAL.';
			mostrar=1;
		}
		else
		{
			$('#msj_compra_obs').hide();
		}
		
		if(gas_tot==com_tot)
		{
			msj='Factura debe tener estado CANCELADA.';
			mostrar=1;
		}
		else
		{
			$('#msj_compra_obs').hide();
		}
	}
	
	if(com_est=='CANCELADA')
	{
		if(gas_tot=='n')
		{
			msj='FACTURA CANCELADA. Debe contener por lo menos un registro de Pago.';
			mostrar=1;
		}
		else
		{
			$('#msj_compra_obs').hide();
		}
		
		if(gas_tot<com_tot)
		{
			msj='Factura debe tener estado PAGO PARCIAL.';
			mostrar=1;
		}
		else
		{
			$('#msj_compra_obs').hide();
		}
	}
	
	if(com_est=='PAGO PARCIAL')
	{
		if(gas_tot=='n')
		{
			msj='FACTURA PAGO PARCIAL. Debe contener por lo menos un registro de Pago.';
			mostrar=1;
		}
		else
		{
			$('#msj_compra_obs').hide();
		}
		
		if(gas_tot==com_tot)
		{
			msj='Factura debe tener estado CANCELADA.';
			mostrar=1;
		}
		else
		{
			$('#msj_compra_obs').hide();
		}
	}
	
	if(com_est=='ANULADA')
	{
		if(gas_tot!='n')
		{
			msj='FACTURA ANULADA. No debe contener ningún registro de Pagos.';
			mostrar=1;
		}
		else
		{
			$('#msj_compra_obs').hide();
		}	
	}
	
	if(mostrar==1)
	{
		$('#msj_compra_obs').html(msj);
		$('#msj_compra_obs').show(100);
	}
}

$(function() {
	
	cmb_com_doc();
	cmb_com_alm_id();

	<?php
	if($_POST['action']=="editar"){
	?>
	proveedor_cargar_datos(<?php echo $pro_id?>);
	compra_detalle_tabla();
	$('#cmb_com_alm_id,#cmb_com_mon,#cmb_com_doc').attr('disabled', 'disabled');
	$('#txt_com_fec,#txt_com_fecven,#txt_com_numdoc,#txt_com_pro_nom,#txt_com_pro_doc,#txt_com_pro_dir,#txt_com_tipcam').attr('disabled', 'disabled');
	//$("#cmb_com_alm_id").addClass("ui-state-disabled");
	gasto_tabla();
	<?php }?>
	
	$( "#div_proveedor_form" ).dialog({
		title:'Información Proveedor',
		autoOpen: false,
		resizable: false,
		height: 300,
		width: 530,
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
	
	//pagos
	$( "#div_gasto_form" ).dialog({
		title:'Información de Pago - Salida Caja Terceros',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 690,
		modal: true,
		//position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_gas").submit();
			},
			Cancelar: function() {
				$('#for_gas').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			compra_obs();
		}
	});
	
//formulario			
	$("#for_com").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../cuentasxpagar/compra_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_com").serialize(),
				beforeSend: function(){
					$('#div_compra_form').dialog("close");
					$('#msj_compra').html("Guardando...");
					$('#msj_compra').show(100);
				},
				success: function(html){
					$('#msj_compra').html(html);
				},
				complete: function(){
					<?php if($_POST['action']=='insertar'){?>
					compra_precios();
					<?php }?>
					compra_tabla();
				}
			});			
		},
		rules: {
			txt_com_fec: {
				required: true,
				dateITA: true
			},
			txt_com_fecven: {
				required: true,
				dateITA: true
			},
			cmb_com_doc: {
				required: true
			},
			txt_com_numdoc: {
				required: true
			},
			hdd_com_pro_id: {
				required: true
			},
			cmb_com_mon: {
				required: true
			},
			txt_com_tipcam: {
				required: true
			},
			cmb_com_alm_id: {
				required: true
			},
			hdd_com_numite: {
				required: true
			},
			cmb_com_est: {
				required: true
			}
		},
		messages: {
			txt_com_fec: {
				required: '*'
			},
			txt_com_fecven: {
				required: '*'
			},
			cmb_com_doc: {
				required: '*'
			},
			txt_com_numdoc: {
				required: '*'
			},
			hdd_com_pro_id: {
				required: 'Seleccione Proveedor.'
			},
			cmb_com_mon: {
				required: '*'
			},
			txt_com_tipcam: {
				required: '*'
			},
			cmb_com_alm_id: {
				required: '*'
			},
			hdd_com_numite: {
				required: 'Agregue producto a detalle de compra.'
			},
			cmb_com_est: {
				required: '*'
			}
		}
	});
	
	$(document).shortkeys({
	  'a+p':       function () { catalogo_compra() },
	  'Ctrl+Alt+a':  function () { $("#txt_fil_pro_nom").val(''); $("#txt_fil_pro_nom").focus(); },
	  'Ctrl+Alt+n':  function () { $("#txt_fil_pro_nom").focus(); },
	  'Ctrl+Alt+v': function () { $('input[name*="txt_cat_precom_"]:first').focus(); }
	});
	
});
</script>
<style>
	.ui-cmb_pro_id {
		position: relative;
		display: inline-block;
	}
	.ui-cmb_pro_id-input {
		margin: 0;
		padding: 0.3em;
	}
	</style>
<form id="for_com">
<input name="action_compra" id="action_compra" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_com_id" id="hdd_com_id" type="hidden" value="<?php echo $_POST['com_id']?>">
<input name="hdd_com_est" id="hdd_com_est" type="hidden" value="<?php echo $est?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $_SESSION['empresa_id']?>">
<fieldset>
  <legend>Datos Principales</legend>
<label for="txt_com_fec">Fecha:</label>
          <input name="txt_com_fec" type="text" class="fecha" id="txt_com_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly>
    
    <label for="txt_com_fecven" title="Fecha de Vencimiento">Fecha Vcto:</label>
    <input name="txt_com_fecven" type="text" class="fecha" id="txt_com_fecven" value="<?php echo $fecven?>" size="10" maxlength="10" readonly>
    
    <label for="cmb_com_doc">Documento:</label>
    <select name="cmb_com_doc" id="cmb_com_doc">
    </select>
       <label for="txt_com_numdoc">N° Doc:</label>
       <input type="text" name="txt_com_numdoc" id="txt_com_numdoc"  value="<?php echo $numdoc?>">
    <?php
      $url=ir_principal($_SESSION['usuariogrupo_id']);
	  ?>
      <a class="btn_newwin" target="_blank" title="Saltar a otra pestaña" href="<?php echo $url?>">Saltar</a>
       <br />
    <label for="cmb_com_mon">Moneda:</label>
       <select name="cmb_com_mon" id="cmb_com_mon">
         <option value="1" <?php if($mon==1)echo 'selected'?>>NUEVO SOL | S/.</option>
         <option value="2" <?php if($mon==2)echo 'selected'?>>DOLAR AME | US$</option>
       </select>
       
	   <label for="txt_com_tipcam">Cambio:</label>
	   <input name="txt_com_tipcam" type="text" value="<?php echo $tipcam?>" id="txt_com_tipcam" size="5" maxlength="5" style="text-align:right" readonly>
	   <label for="cmb_com_alm_id">Colocar producto en:</label>
      <select name="cmb_com_alm_id" id="cmb_com_alm_id">
          </select>
  
          <label for="cmb_com_est" style="background:#EBEBEB">Estado:
    <select name="cmb_com_est" id="cmb_com_est">
            <option value="">-</option>
            <option value="EMITIDA" <?php if($est=='CREDITO')echo 'selected'?>>EMITIDA</option>
            <option value="CANCELADA" <?php if($est=='CANCELADA')echo 'selected'?>>CANCELADA</option>
          </select></label>
        <?php if($_POST['action']=='insertar'){?>
        <label for="cmb_com_tippre">Mostrar  con:</label>  
            <select name="cmb_com_tippre" id="cmb_com_tippre">
            <option value="1" selected="selected">Valor Venta</option>
            <option value="2">Precio Venta</option>
        </select> 
  		<?php }?>
        
    <?php //if($_POST['action']=='editar') echo 'COMPRA: '.$est?>
</fieldset>
<input type="hidden" id="hdd_com_pro_id" name="hdd_com_pro_id" value="<?php echo $pro_id?>" />
<fieldset>
	<legend>Datos Proveedor</legend>
    <div id="div_proveedor_form">
	</div>
    <?php if($_POST['action']=='insertar'){?>
    <a id="btn_pro_form_agregar" href="#" onClick="proveedor_form('insertar')">Agregar Proveedor</a>
    <a id="btn_pro_form_modificar" href="#" onClick='proveedor_form("editar",$("#hdd_com_pro_id").val())'>Modificar Proveedor</a>
    <?php }?>
    <label for="txt_com_pro_doc">RUC/DNI:</label>
    <input type="text" id="txt_com_pro_doc" name="txt_com_pro_doc" size="20" value="<?php echo $pro_doc?>" /> 
    <label for="txt_com_pro">Proveedor:</label>
    <input type="text" id="txt_com_pro_nom" name="txt_com_pro_nom" size="40" value="<?php echo $pro_nom?>" />
    <label for="txt_com_pro_dir">Dirección:</label>
    <input type="text" id="txt_com_pro_dir" name="txt_com_pro_dir" size="40" value="<?php echo $pro_dir?>" disabled="disabled"/>
</fieldset>
<?php
if($_POST['action']=="insertar"){
?>
<div id="div_compra_car_tabla">
</div>
<div id="div_item_form">
</div>
<?php }?>
</form>
<?php
if($_POST['action']=="editar"){
?>
<div id="div_compra_detalle_tabla">
</div>

<div id="div_btn_agregar_gasto" style="float:left">
<a id="btn_agregar_gasto" title="Agregar Pago" href="#addpago" onClick="gasto_form('insertar','factura')">Agregar</a>
</div>
<strong> PAGOS</strong>

<div id="msj_gasto" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
<div id="div_gasto_form">
</div>
<div id="div_gasto_tabla">
</div>
<br>
<div id="msj_compra_obs" class="ui-state-error ui-corner-all" style="width:auto; float:left; padding:2px; display:none"></div>
<?php }?>