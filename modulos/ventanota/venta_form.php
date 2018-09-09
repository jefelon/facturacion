<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVentanota.php");
$oVentanota = new cVentanota();
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();

require_once("../formatos/formato.php");
require_once("../menu/acceso.php");

if($_POST['action']=="insertar"){
	//$cli_id=1;
	$fec=date('d-m-Y');
	$est='CANCELADA';
	$venpag_fec=date('d-m-Y');
	
	$docc_id=1;
	
	$dts= $oTalonariointerno->correlativo_notven($_SESSION['puntoventa_id'],$docc_id);
	$num_rows= mysql_num_rows($dts);
	if($num_rows>0)
	{
			$dt = mysql_fetch_array($dts);
		$tal_id=$dt['tb_talonario_id'];
		$tal_ser=$dt['tb_talonario_ser'];
		$tal_fin=$dt['tb_talonario_fin'];
		$tal_num=$dt['tb_talonario_num'];
			mysql_free_result($dts);
	
		$numero=$tal_num+1;
		$largo=strlen($tal_fin);
		
		$numero=str_pad($numero,$largo, "0", STR_PAD_LEFT);
		
		$numdoc=$tal_ser.'-'.$numero;
		$display='none';
	}
	else
	{
		$msj='Debe actualizar talonario.';
		$display='block';
	}
}

if($_POST['action']=="editar"){
	$dts= $oVentanota->mostrarUno($_POST['ven_id']);
	$dt = mysql_fetch_array($dts);
		$reg	=mostrarFechaHora($dt['tb_venta_reg']);
		
		$fec	=mostrarFecha($dt['tb_venta_fec']);
		
		$doc_id	=$dt['tb_documento_id'];
		$doc_abr	=$dt['tb_documento_abr'];
		$numdoc	=$dt['tb_venta_numdoc'];
		
		$cli_id	=$dt['tb_cliente_id'];
		$cli_nom = $dt['tb_cliente_nom'];
		$cli_doc = $dt['tb_cliente_doc'];
		$cli_dir = $dt['tb_cliente_dir'];
		$subtot	=$dt['tb_venta_subtot'];
		$igv	=$dt['tb_venta_igv'];
		$tot	=$dt['tb_venta_tot'];
		$est	=$dt['tb_venta_est'];
	mysql_free_result($dts);
	
	$display='none';
}
?>
<script type="text/javascript">
$('.btn_imp').button({
	icons: {primary: "ui-icon-print"},
	text: false
});
$('.btn_cangear').button({
	//icons: {primary: "ui-icon-print"},
	text: true
});
$('.btn_ir').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$('.btn_venpag_agregar').button({
	icons: {primary: "ui-icon-plus"},
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

$('.venpag_moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.9999'
});

$( "#txt_ven_fec" ).datepicker({
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
function cmb_cuecor_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../cuentacorriente/cmb_cuecor_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			cuecor_id: ids
		}),
		beforeSend: function() {
			$('#cmb_cuecor_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cuecor_id').html(html);
		}
	});
}
function cmb_tar_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../tarjeta/cmb_tar_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			tar_id: ids
		}),
		beforeSend: function() {
			$('#cmb_tar_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_tar_id').html(html);
		}
	});
}

function cmb_ven_doc()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'3',
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
/*function txt_ven_numdoc(){	
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_txt_numdoc.php",
		async:true,
		dataType: "json",                      
		data: ({
			doc_id: $('#cmb_ven_doc').val()
		}),
		beforeSend: function() {
			$('#txt_ven_numdoc').val('Cargando...');			
        },
		success: function(data){			
			$('#txt_ven_numdoc').val(data.numero);
			if(data.msj!="")
			{
				$('#msj_venta_form').html(data.msj);
				$('#msj_venta_form').show(100);
			}
			else
			{
				$('#msj_venta_form').hide();
			}
		}
	});
}*/

function txt_venpag_fecven(){	
	$.ajax({
		type: "POST",
		url: "../venta/venta_txt_fecven.php",
		async:true,
		dataType: "json",                      
		data: ({
			ven_fec: 		$('#txt_ven_fec').val(),
			venpag_numdia: 	$('#txt_venpag_numdia').val()
		}),
		beforeSend: function() {
			//$('#txt_ven_numdoc').val('Cargando...');			
        },
		success: function(data){
			$('#txt_venpag_fecven').val(data.fecha);
		}
	});
}

function venta_car(act,idf){
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
		/*if($('#chk_cat_igv_'+idf).is(':checked')) {  
			var chk=1;  
		} else {  
			var chk=0;   
		}*/	
	
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_car.php",
		async:true,
		dataType: "html",                      
		data: ({
			action:	 act,
			cat_id:	 idf,
			cat_can: $('#txt_cat_can_'+idf).val(),
			cat_des: $('#txt_detven_des_'+idf).val(),//Descuento
			cat_tipdes: $("input[name='rad_cat_tip_des_"+idf+"']:checked").val(),//Radio Button
			cat_preven: $('#txt_cat_preven_'+idf).val()		
		}),
		beforeSend: function() {
			$("#txt_fil_pro_nom").val(''); $("#txt_fil_pro_nom").focus();
			$('#div_venta_car_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_venta_car_tabla').html(html);
		},
		complete: function(){			
			$('#div_venta_car_tabla').removeClass("ui-state-disabled");
		}
	});
	}
}

function venta_car_servicio(act,idf){	
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_car.php",
		async:true,
		dataType: "html",                      
		data: ({
			action:	 act,
			ser_id:	 idf,
			ser_nom: $('#hdd_ser_nom_'+idf).val(),
			ser_can: $('#txt_ser_can_'+idf).val(),
			ser_des: $('#txt_ser_detven_des_'+idf).val(),//Descuento
			ser_rad_tipdes: $("input[name='rad_ser_tip_des_"+idf+"']:checked").val(),
			ser_pre: $('#txt_servicio_pre_'+idf).val()		
		}),
		beforeSend: function() {
			$('#div_venta_car_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_venta_car_tabla').html(html);
		},
		complete: function(){			
			$('#div_venta_car_tabla').removeClass("ui-state-disabled");
		}
	});
	
}

function catalogo_venta(){	
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_venta.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//ven_id:	idf
		}),
		beforeSend: function() {
			//$('#msj_venta').hide();
			//$('#div_catalogo_venta').dialog("open");
			$('#div_tab_producto').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
		},
		success: function(html){
			$('#div_tab_producto').html(html);				
		}
	});
}
	
function catalogo_servicio(){
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_servicio.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//ven_id:	idf
		}),
		beforeSend: function() {
			//$('#msj_venta').hide();
			//$('#div_catalogo_venta').dialog("open");
			$('#div_tab_servicio').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_tab_servicio').html(html);				
		}
	});
}

function catalogo_venta_tab(){
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_venta_tab.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//ven_id:	idf
		}),
		beforeSend: function() {
			$('#msj_venta').hide();
			$('#div_catalogo_venta').dialog("open");
			$('#div_catalogo_venta').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_venta').html(html);				
		},
		complete: function(){
			catalogo_venta();
			catalogo_servicio();	
		}
	});	
}
function venta_pago_tabla()
{
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_pago_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			ven_id:	'<?php echo $_POST['ven_id']?>'
		}),
		beforeSend: function() {
			$('#div_venta_pago_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_venta_pago_tabla').html(html);
		},
		complete: function(){			
			$('#div_venta_pago_tabla').removeClass("ui-state-disabled");
		}
	});     
}
function venta_detalle_tabla()
{
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_detalle_tabla.php",
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

function editar_datos_item(act,idf){	
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_car_item.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ite_id:	idf
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

function cliente_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../clientes/cliente_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			cli_id:	idf,
			vista:	'hdd_cli_id'
		}),
		beforeSend: function() {
			//$('#msj_proveedor').hide();
			//$("#btn_cmb_pro_id").click(function(e){
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
			if(act=='insertar' & $('#hdd_ven_cli_id').val()=="")
			{
				$('#txt_cli_doc').val($('#txt_ven_cli_doc').val());
				$('#txt_cli_nom').val($('#txt_ven_cli_nom').val());
			}
			
		}
	});
}

function cliente_cargar_datos(idf){	
	$.ajax({
		type: "POST",
		url: "../clientes/cliente_reg.php",
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
			$('#hdd_ven_cli_id').val(idf);	
			$('#txt_ven_cli_nom').val(data.nombre);	
			$('#txt_ven_cli_doc').val(data.documento);						
			$('#txt_ven_cli_dir').val(data.direccion);
		}
	});		
}

function venta_pago_car(act,idf){	
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_pago_car.php",
		async:true,
		dataType: "html",                      
		data: ({
			action:	 act,
			item_id:	idf,
			venpag_mon: $('#txt_venpag_mon').val(),
			venpag_for: $('#cmb_forpag_id').val(),
			venpag_mod: $('#cmb_modpag_id').val(),
			venpag_cuecor: $('#cmb_cuecor_id').val(),
			venpag_tar: $('#cmb_tar_id').val(),
			venpag_numope: $('#txt_venpag_numope').val(),
			venpag_numdia: $('#txt_venpag_numdia').val(),
			venpag_fecven: $('#txt_venpag_fecven').val(),
			ven_tot: $('#txt_ven_tot').val()		
		}),
		beforeSend: function() {
			$('#div_venta_pago_car').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_venta_pago_car').html(html);
		},
		complete: function(){			
			$('#div_venta_pago_car').removeClass("ui-state-disabled");
		}
	});
}


$(function() {	
	cmb_cli_id(<?php echo $cli_id?>);
	cmb_ven_doc();
	$("#txt_ven_numdoc").addClass("ui-state-active");
	
	cmb_tar_id(<?php echo $tar_id?>);
	cmb_cuecor_id(<?php echo $cuecor_id?>);
	
	$( "#txt_ven_cli_nom" ).autocomplete({
   		minLength: 1,
   		source: "../clientes/cliente_complete_nom.php",
		select: function(event, ui){			
			$("#hdd_ven_cli_id").val(ui.item.id);							
			$("#txt_ven_cli_doc").val(ui.item.documento);
			$("#txt_ven_cli_dir").val(ui.item.direccion);			
		}
    });
	
	$( "#txt_ven_cli_doc" ).autocomplete({
   		minLength: 1,
   		source: "../clientes/cliente_complete_doc.php",
		select: function(event, ui){			
			$("#hdd_ven_cli_id").val(ui.item.id);							
			$("#txt_ven_cli_nom").val(ui.item.nombre);
			$("#txt_ven_cli_dir").val(ui.item.direccion);		
		}
    });
	
	<?php
	if($_POST['action']=="insertar"){
	?>
	$('#cmb_ven_doc').change( function() {
		//txt_ven_numdoc();
	});
	venta_car();
	$("#cmb_ven_est").change(function(){		
		var est = $("#cmb_ven_est").val();
		//efectivo
		if(est == 'ANULADA'){			
			$("#hdd_ven_numite").attr('disabled', 'disabled');
			$("#hdd_ven_cli_id").attr('disabled', 'disabled');	
		}
		if(est == 'CANCELADA'){			
			$("#hdd_ven_numite").attr('disabled', false);
			$("#hdd_ven_cli_id").attr('disabled', false);
		}
	});
	<?php }?>
	
	$("#chk_venpag_aut").change(function(){
		if($('#chk_venpag_aut').is(':checked')){  
			//var chk=1;
			$("#div_pago_agregar").hide(100);
			$("#hdd_ven_pag_numite").attr('disabled', 'disabled');
			//venta_pago_car('restablecer');
			$("#hdd_ven_pag_numite").attr('disabled', 'disabled');
			$("#hdd_venpag_tot").attr('disabled', 'disabled');
		} else {  
			//var chk=0;
			$("#div_pago_agregar").show(100);
			venta_pago_car('actualizar');
			$("#hdd_ven_pag_numite").attr('disabled', false);
			$("#hdd_venpag_tot").attr('disabled', false);
		}
	});
	
	$("#cmb_forpag_id").change(function(){		
		var tipo = $("#cmb_forpag_id").val();
		
		//$('#cmb_forpag_id').val();
		
		//$('#txt_venpag_mon').val('');
		//$('#cmb_modpag_id').val('');
		$('#cmb_cuecor_id').val('');
		$('#cmb_tar_id').val('');
		$('#txt_venpag_numope').val('');
		$('#txt_venpag_numdia').val('');
		$('#txt_venpag_fecven').val('');	
		
		//contado
		if(tipo == 1){			
			$("#div_dia").hide(100);
			$("#div_fecven").hide(100);	
		}
		//credito
		if(tipo == 2){			
			$("#div_dia").show(100);
			$("#div_fecven").show(100);
			//ocultar deposito y tarjeta
			$("#cmb_modpag_id option[value='2']").attr("disabled","disabled");
			$("#cmb_modpag_id option[value='3']").attr("disabled","disabled");
		}		
	});
	
	$("#cmb_modpag_id").change(function(){		
		var tipo = $("#cmb_modpag_id").val();
		
		$('#cmb_tar_id').val('');
		$('#cmb_cuecor_id').val('');
		$('#txt_venpag_numope').val('');
		$('#txt_venpag_numdia').val('');
		$('#txt_venpag_fecven').val('');
		
		//efectivo
		if(tipo == 1){
			$("#div_cuentacorriente").hide(100);			
			$("#div_tarjeta").hide(100);
			$("#div_operacion").hide(100);
		}
		//deposito
		if(tipo == 2){
			$("#div_cuentacorriente").show(100);
			$("#div_tarjeta").hide(100);
			$("#div_operacion").show(100);
		}
		//tarjeta
		if(tipo == 3){
			$("#div_cuentacorriente").hide(100);		
			$("#div_tarjeta").show(100);
			$("#div_operacion").show(100);
		}
	});
	
	$('#txt_venpag_numdia').change( function() {
		if($('#txt_venpag_numdia').val()!="")
		{
			txt_venpag_fecven();
		}
		else
		{
			$('#txt_venpag_fecven').val('');
		}
	});
	
	cmb_tar_id();
	
	<?php
	if($_POST['action']=="editar"){
	?>
	venta_pago_tabla();
	venta_detalle_tabla();
	$('#cmb_ven_est').attr('disabled','disabled');
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

	$( "#div_catalogo_venta" ).dialog({
		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).show(); },
		title:'Catálogo de Venta',
		autoOpen: false,
		resizable: false,
		height: 500,
		width: 980,
		zIndex: 2,
		modal: true,
		position: ["center",100]/*"center"/*,*/,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	//Formulario para actualizar Item de Detalle de Venta
	$( "#div_item_form" ).dialog({
		title:'Información de Item',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 220,
		zIndex: 3,
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
	$("#for_ven").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../ventanota/venta_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_ven").serialize(),
				beforeSend: function(){
					$('#div_ventanota_form').dialog("close");
					$('#msj_ventanota').html("Guardando...");
					$('#msj_ventanota').show(100);
				},
				success: function(data){
					$('#msj_ventanota').html(data.ven_msj);
					if(data.ven_act=='imprime')
					{
						ventanota_impresion(data.ven_id);
					}
				},
				complete: function(){
					ventanota_tabla();
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
			hdd_vennotpag_tot: {
				equalTo: "#txt_ven_tot"
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
			hdd_vennotpag_tot: {
				equalTo: "No es igual a Monto Total de Venta."
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
        <input name="txt_ven_numdoc" type="text" id="txt_ven_numdoc" style="text-align:right; font-size:14px"  value="<?php echo $numdoc?>" size="13" readonly>
        <?php //if($_POST['action']=="editar")echo $est?>
        <?php if($_POST['action']=="insertar"){?>
        <label for="chk_imprimir">Imprimir Documento</label>
        <input name="chk_imprimir" type="checkbox" id="chk_imprimir" value="1" checked="CHECKED">
        <?php }?>
        </td>
      <td align="right">
      <?php
      if($_POST['action']=="editar"){
	  ?>
      <a class="btn_imp" title="Imprimir (Shift+P)" href="#imprimir" onClick="ventanota_impresion('<?php echo $_POST['ven_id']?>')">Imprimir</a>
      <?php }?>
      <?php
      if($_POST['action']=="editar" and $est=="CANCELADA"){
	  ?>
	  <?php /*?>
      <a class="btn_cangear" title="Cangear Nota de Venta" href="#cange" onClick="ventanota_cange('<?php echo $_POST['ven_id']?>','<?php echo $doc_abr.' '.$numdoc?>')">Cangear</a><?php */?>
      <?php }
			$url=ir_principal($_SESSION['usuariogrupo_id']);
			?>
      <a class="btn_newwin" target="_blank" title="Saltar a otra pestaña" href="<?php echo $url?>">Saltar</a>
      </td>
    </tr>
    <tr>
      <td>
        <label for="cmb_ven_est">Estado:</label>
        <select name="cmb_ven_est" id="cmb_ven_est">
          <option value="">-</option>
          <option value="CANCELADA" <?php if($est=='CANCELADA')echo 'selected'?>>CANCELADA</option>
          <option value="ANULADA" <?php if($est=='ANULADA')echo 'selected'?>>ANULADA</option>
        </select>
        <div id="msj_venta_form" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
        <div id="msj_talonario" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php echo $display?>"><?php echo $msj?></div>
        </td>
      <td>
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
<fieldset><legend>Registro de Pagos</legend>
<?php if($_POST['action']=='insertar'){?>
<table border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td width="70" valign="top"><label for="chk_venpag_aut" title="Registrar Pago Automaticamente">Reg Auto</label></br>
    <input name="chk_venpag_aut" type="checkbox" id="chk_venpag_aut" value="1" checked="CHECKED">
    </td>
    <td width="40" valign="middle">
    <div id="div_pago_agregar" style="display:none">
    <a class="btn_venpag_agregar" href="#" onClick="venta_pago_car('agregar')">Agregar</a>
    </div>
    </td>
    <?php /*?><td>
    <label for="txt_venpag_fec">Fecha:</label>
      <input type="text" name="txt_venpag_fec" id="txt_venpag_fec" size="10" maxlength="10" value="<?php echo $venpag_fec?>" readonly>
    </td><?php */?>
    <td valign="top"><label for="txt_venpag_mon">Monto:</label></br>
      <input name="txt_venpag_mon" type="text" class="venpag_moneda" id="txt_venpag_mon" style="text-align:right;" size="10" maxlength="10"></td>
    <td valign="top">
    <label for="cmb_forpaf_id">Forma<!-- Pago-->:</label></br>
      <select name="cmb_forpag_id" id="cmb_forpag_id">
        <option value="1" selected="selected">CONTADO</option>
        <option value="2">CREDITO</option>
        </select>
    </td>
    <td valign="top"><!--<label for="cmb_modpaf_id">Modo Pago:</label>--></br>
      <select name="cmb_modpag_id" id="cmb_modpag_id">
        <option value="1" selected="selected">EFECTIVO</option>
        <option value="2">DEPOSITO</option>
        <option value="3">TARJETA</option>
        </select></td>
    <td valign="top">
    <div id="div_tarjeta" style="display:none">
    <label for="cmb_tar_id">Tarjeta:</label></br>
      <select name="cmb_tar_id" id="cmb_tar_id">
      </select>
    </div>
    <div id="div_cuentacorriente" style="display:none">
    <label for="cmb_cuecor_id">Cuenta Corriente:</label></br>
      <select name="cmb_cuecor_id" id="cmb_cuecor_id">
      </select>
    </div>
    </td>
    <td valign="top">
    <div id="div_operacion" style="display:none">
    <label for="txt_venpag_numope">N° Operación:</label></br>
      <input type="text" name="txt_venpag_numope" id="txt_venpag_numope" size="15">
    </div>
    </td>
    <td valign="top">
    <div id="div_dia" style="display:none">
    <label for="txt_venpag_numdia">N° Días:</label></br>
    <input name="txt_venpag_numdia" id="txt_venpag_numdia" type="text" class="dias" size="5" maxlength="3">
    </div>
    </td>
    <td valign="top">
    <div id="div_fecven" style="display:none">
    <label for="txt_venpag_fecven">Fec Vencto:</label></br>
      <input type="text" name="txt_venpag_fecven" id="txt_venpag_fecven" size="10" maxlength="10" readonly>
    </div>
    </td>
    </tr>
</table>
<div id="div_venta_pago_car">
</div>
<?php }?>
<div id="div_venta_pago_tabla">
</div>
</fieldset>
<input type="hidden" id="hdd_ven_cli_id" name="hdd_ven_cli_id" value="<?php echo $cli_id?>" />
<fieldset>
	<legend>Datos Cliente</legend>
    <div id="div_cliente_form">
	</div>
    <?php if($_POST['action']=='insertar'){?>
    <a id="btn_cli_form_agregar" href="#" onClick="cliente_form('insertar')">Agregar Cliente</a>
    <a id="btn_cli_form_modificar" href="#" onClick='cliente_form("editar",$("#hdd_ven_cli_id").val())'>Modificar Cliente</a>
    <?php }?>
    <label for="txt_ven_cli_doc">RUC/DNI:</label>
    <input type="text" id="txt_ven_cli_doc" name="txt_ven_cli_doc" size="20" value="<?php echo $cli_doc?>" /> 
    <label for="txt_ven_cli_nom">Cliente:</label>
    <input type="text" id="txt_ven_cli_nom" name="txt_ven_cli_nom" size="60" value="<?php echo $cli_nom?>" />
    <br>
    <label for="txt_ven_cli_dir">Dirección:</label>
    <input type="text" id="txt_ven_cli_dir" name="txt_ven_cli_dir" size="90" value="<?php echo $cli_dir?>" disabled="disabled"/>
</fieldset>

<?php
if($_POST['action']=="insertar"){
?>
<div id="div_venta_car_tabla">
</div>
<div id="div_item_form">
</div>
<?php }?>
</form>
</div>
<?php
if($_POST['action']=="insertar"){
?>
<div id="div_catalogo_venta">
</div>
<?php
}
if($_POST['action']=="editar"){
?>
<br>
<div id="div_venta_detalle_tabla">
</div>
<?php }?>