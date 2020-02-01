<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../cotizacion/cCotizacion.php");
$oCotizacion = new cCotizacion();

require_once("../formatos/formato.php");
require_once("../menu/acceso.php");

if($_POST['action']=="insertar"){
	//$cli_id=1;
	$fec=date('d-m-Y');
	$est='COTIZADA';
	$venpag_fec=date('d-m-Y');

	$unico_id=uniqid();
}

if($_POST['action']=="editar"){
	$dts= $oCotizacion->mostrarUno($_POST['ven_id']);
	$dt = mysql_fetch_array($dts);
		$reg	=mostrarFechaHora($dt['tb_cotizacion_reg']);
		
		$fec	=mostrarFecha($dt['tb_cotizacion_fec']);
		
		$doc_id	=$dt['tb_documento_id'];
		//$numdoc	=$dt['tb_venta_numdoc'];
		$ser	=$dt['tb_cotizacion_ser'];
		$num	=$dt['tb_cotizacion_num'];
		$cli_id	=$dt['tb_cliente_id'];
		$cli_nom = $dt['tb_cliente_nom'];
		$cli_doc = $dt['tb_cliente_doc'];
		$cli_dir = $dt['tb_cliente_dir'];
		$cli_tip = $dt['tb_cliente_tip'];
		
		$subtot	=$dt['tb_cotizacion_subtot'];
		$igv	=$dt['tb_cotizacion_igv'];
		$tot	=$dt['tb_cotizacion_tot'];
		$est	=$dt['tb_cotizacion_est'];
		
		$punven_nom	=$dt['tb_puntoventa_nom'];
		$alm_nom	=$dt['tb_almacen_nom'];
		
		$lab1	=$dt['tb_cotizacion_lab1'];
		$lab2	=$dt['tb_cotizacion_lab2'];
		$lab3	=$dt['tb_cotizacion_lab3'];
		
		$may	=$dt['tb_cotizacion_may'];
	mysql_free_result($dts);
}
?>
<script type="text/javascript">
$('.btn_imp').button({
	icons: {primary: "ui-icon-print"},
	text: false
});

$('.btn_venpag_agregar').button({
	icons: {primary: "ui-icon-plus"},
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

$('.dias').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0',
	vMax: '365'
});

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

$( "#txt_venpag_fec" ).datepicker({
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

/*$( "#txt_venpag_fecven" ).datepicker({
	minDate: "-0D", 
	//maxDate:"+0D",
	yearRange: 'c-0:c+0',
	changeMonth: true,
	changeYear: false,
	dateFormat: 'dd-mm-yy',
	//altField: fecha,
	//altFormat: 'yy-mm-dd',
	//showOn: "button",
	buttonImage: "../../images/calendar.gif",
	buttonImageOnly: true
});*/

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
			doc_tip:	'11',
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
			txt_ven_numdoc();
			<?php }?>
		}
	});
}
function txt_ven_numdoc(){	
	$.ajax({
		type: "POST",
		url: "../venta/venta_txt_numdoc.php",
		async:false,
		dataType: "json",                      
		data: ({
			doc_id: $('#cmb_ven_doc').val()
		}),
		beforeSend: function() {
			$('#txt_ven_numdoc').val('Cargando...');
			
			if($('#cmb_ven_doc').val()*1==2 || $('#cmb_ven_doc').val()*1==11)//factura
			{
				$('#hdd_val_cli_tip').val('2');
			}
			if($('#cmb_ven_doc').val()*1==3 || $('#cmb_ven_doc').val()*1==12)//boleta
			{
				$('#hdd_val_cli_tip').val('1');
			}			
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
		},
		complete: function(){
			<?php if($_POST['action']=="insertar"){?>
			verificar_numdoc();
			<?php }?>
		}
	});
}
function verificar_numdoc(){	
	$.ajax({
		type: "POST",
		url: "../venta/venta_ver_numdoc.php",
		async:false,
		dataType: "json",                      
		data: ({
			doc_id: $('#cmb_ven_doc').val(),
			numdoc: $('#txt_ven_numdoc').val(),
			ven_est: $('#cmb_ven_est').val()
		}),
		beforeSend: function() {

        },
		success: function(data){			
			$('#hdd_ven_doc').val(data.valor);
			if(data.msj!="")
			{
				$('#div_venta_validar_form').dialog("open");			  
				$('#div_venta_validar_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
				$('#div_venta_validar_form').html(data.msj);
				//alert(data.msj);
				$('#msj_venta_form').html(data.msj);
				//$('#msj_venta_form').show(100);
			}
			else
			{
				//$('#msj_venta_form').hide();
			}
		}
	});
}
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
			//alert(data.fecha);
			$('#txt_venpag_fecven').val(data.fecha);
		}
	});
}

function venta_car(act,cat_id){
	if(act=='agregar') {
		var stouni=$('#hdd_bus_cat_stouni').val();
		var cantidad=$('#txt_bus_cat_can').val();
		
		var dif = stouni-$('#txt_bus_cat_can').val();

		// if($('#txt_bus_cat_preven').autoNumericGet()>0) {
			var precio=$('#txt_bus_cat_preven').autoNumericGet()-$('#hdd_bus_cat_cospro').autoNumericGet();
		// } else {
		// 	var precio=0;
		// }
	}
	if(act!='quitar'){
		cat_id =  $('#hdd_bus_cat_id').val();
	}


			$.ajax({
				type: "POST",
				url: "../cotizacion/venta_car.php",
				async:false,
				dataType: "html",                      
				data: ({
					action:	 act,
					unico_id: $('#unico_id').val(),
					cat_id:	 cat_id,
					cat_can: $('#txt_bus_cat_can').val(),
					cat_tip: 1,//Tipo Gravado/Exonerado/Inafecto/premio...  1=grabada
					cat_preven: $('#txt_bus_cat_preven').val()
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
                    if(!($('#chk_modo').is(':checked'))) {
                        $('#hdd_bus_cat_id').val('');
                        $('#hdd_bus_cat_stouni').val('');
                        $('#hdd_bus_cat_cospro').val('');
                        $('#txt_bus_pro_codbar').val('');
                        $('#txt_bus_pro_nom').val('');
                        $('#txt_bus_cat_preven').val('');
                        $('#txt_bus_cat_can').val('');
                        $('#txt_precio_min').val('');
                        $('#txt_precio_may').val('');
                    }
				}
			});
		
}

function venta_car_servicio(act,idf){	
	$.ajax({
		type: "POST",
		url: "../venta/venta_car.php",
		async:false,
		dataType: "html",                      
		data: ({
			action:	 act,
			unico_id: $('#unico_id').val(),
			ser_id:	 idf,
			ser_nom: $('#hdd_ser_nom_'+idf).val(),
			ser_can: $('#txt_ser_can_'+idf).val(),
			ser_tip: $('#cmb_detven_tip_'+idf).val(),
			ser_des: $('#txt_ser_detven_des_'+idf).val(),//Descuento
			ser_rad_tipdes: $("input[name='rad_ser_tip_des_"+idf+"']:checked").val(),
			ser_pre: $('#txt_servicio_pre_'+idf).val()		
		}),
		beforeSend: function() {
			$("#txt_fil_ser_nom").val(''); $("#txt_fil_ser_nom").focus();
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


function cotizacion_detalle_tabla()
{
	$.ajax({
		type: "POST",
		url: "../cotizacion/cotizacion_detalle_tabla.php",
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
		url: "../venta/venta_car_item.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			unico_id: $('#unico_id').val(),
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

function cliente_form_i(act,idf,nom,dir,con,tel,est){
	$.ajax({
		type: "POST",
		url: "../clientes/cliente_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: 		act,
			cli_id:			idf,
			cli_nom:		nom,
			cli_dir:		dir,
			cli_con:		con,
			cli_tel:		tel,
			cli_est:		est,
			vista:			'hdd_cli_id'
		}),
		beforeSend: function(a) {
			//$('#msj_proveedor').hide();
			//$("#btn_cmb_pro_id").click(function(e){
			$("#btn_cli_form_agregar").click(function(e){
			  //x=e.pageX+5;
			  //y=e.pageY+15;
			  //$('#div_cliente_form').dialog({ position: [x,y] });
			  $('#div_cliente_form').dialog("open");
		    });
			
			if(act=='editar'){
				if(idf>0){
					$("#btn_cli_form_modificar").click(function(e){
					  //x=e.pageX+5;
					  //y=e.pageY+15;
					  //$('#div_cliente_form').dialog({ position: [x,y] });
					  $('#div_cliente_form').dialog("open");
					});
				}
				else{
					alert('Seleccione Cliente');
				}
			}

			if(act=='editarSunat'){
				//x=a.pageX+5;
				//y=a.pageY+15;
				//$('#div_cliente_form').dialog({ position: [x,y] });
				$('#div_cliente_form').dialog("open");
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
			$("#hdd_ven_cli_tip").val(data.tipo);
			$('#txt_ven_cli_est').val(data.estado);
		}
	});		
}

function clientecuenta_detalle(ids)
{	
	$.ajax({
		type: "POST",
		url: "../clientecuenta/clientecuenta_detalle.php",
		async:true,
		dataType: "html",                    
		data: ({
			cli_id: ids,
			emp_id: '<?php echo $_SESSION[empresa_id]?>',
			vista: 0
		}),
		beforeSend: function() {
			$('#div_clientecuenta_detalle').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#div_clientecuenta_detalle').html(html);
		}
	});
	//$('#div_clientecuenta_detalle').html(ids);
}

function venta_pago_car(act,idf){	
	$.ajax({
		type: "POST",
		url: "../venta/venta_pago_car.php",
		async:true,
		dataType: "html",                      
		data: ({
			action:	 act,
			unico_id: $('#unico_id').val(),
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

function compararSunat(doc, nom, dir, id) {
	$.post('../../libreriasphp/consultaruc/index.php', {
		vruc: doc,
		vtipod: 6
	},
	function(data, textStatus){
		if(data == null){
			alert('Intente nuevamente...Sunat');
			$('#msj_busqueda_sunat').hide();
		}
		if(data.length==1){
			alert(data[0]);
		}else{
			var telefono = data['Telefonos'];
			telefono = telefono.replace(/ \/ /g, "/");
			telefono = telefono.replace("/ ", "");
			telefono = telefono.replace(/\//g, " / ");
			$('#txt_cli_tel').val(telefono);
			$("#txt_ven_cli_est").val(data['Estado']);
			if(data['RazonSocial'] != nom || data['Direccion'] != dir){
				cliente_form_i('editarSunat',id,data['RazonSocial'],data['Direccion'],data['Contacto'],telefono,data['Estado']);
			}
			$('#msj_busqueda_sunat').hide();
		}
	},"json");
}


$(function() {
	cmb_ven_doc();
	$("#txt_ven_numdoc").addClass("ui-state-active");
	
	$('#txt_ven_lab1').change(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$('#txt_ven_cli_nom').change(function(){
		$(this).val($(this).val().toUpperCase());
	});
	
	cmb_tar_id(<?php echo $tar_id?>);
	cmb_cuecor_id(<?php echo $cuecor_id?>);

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
	$('#cmb_ven_doc').change( function() {
		txt_ven_numdoc();
	});
	
	venta_car();

	$("#cmb_ven_est").change(function(){
		verificar_numdoc();	
		var est = $("#cmb_ven_est").val();

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
		$('#cmb_modpag_id').val('');
		$('#cmb_cuecor_id').val('');
		$('#cmb_tar_id').val('');
		$('#txt_venpag_numope').val('');
		$('#txt_venpag_numdia').val('');
		$('#txt_venpag_fecven').val('');

		$("#div_cuentacorriente").hide(100);			
		$("#div_tarjeta").hide(100);
		$("#div_operacion").hide(100);
		
		//contado
		if(tipo == 1){			
			$("#div_dia").hide(100);
			$("#div_fecven").hide(100);
			//ocultar deposito y tarjeta
			$("#cmb_modpag_id option[value='2']").attr("disabled",false);
			$("#cmb_modpag_id option[value='3']").attr("disabled",false);
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
	cotizacion_detalle_tabla();
	$('#cmb_ven_est').attr('disabled','disabled');
	$('#hdd_ven_doc').val('1');

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
	
	$( "#div_catalogo_venta" ).dialog({
		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).show(); },
		title:'Catálogo de Venta',
		autoOpen: false,
		resizable: false,
		height: 500,
		width: 980,
		zIndex: 2,
		modal: true,
		position: 'top',
		position: ["center",0],
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
	
	$( "#div_venta_validar_form" ).dialog({
		title:'Validar venta...',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 300,
		zIndex: 3,
		//modal: true,
		buttons: {
			OK: function() {
				$( this ).dialog( "close" );
			},
			Actualizar: function() {
				txt_ven_numdoc();
				$( this ).dialog( "close" );
			}
		}
	});
	
//formulario			
	$("#for_ven").validate({
		submitHandler: function(){
			$.ajax({
				type: "POST",
				url: "../cotizacion/cotizacion_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_ven").serialize(),
				beforeSend: function(){
						$('#div_venta_form').dialog("close");
						$('#msj_venta').html("Guardando...");
						$('#msj_venta').show(100);
				},
				success: function(data){
					if(data.redireccionar){
					 	alert("Cotización No Registrada.\n Por Favor Inicie Sesión Nuevamente.");
					 	window.location.href = "../usuarios/cerrar_sesion.php";
					 	return;
					}
					
					$('#msj_venta').html(data.ven_msj);	


						if(data.ven_act=='imprime')
						{
							cotizacion_impresion(data.ven_id);
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



    //botones agregar producto
    $('.btn_bus_agregar').button({
        icons: {
            //primary: "ui-icon-plusthick",
            //secondary:"ui-icon-cart"
        },
        text: true
    });

    $('.btn_bus_mas').button({
        icons: {
            primary: "ui-icon-plus"
        },
        text: false
    });
    $('.btn_bus_menos').button({
        icons: {
            primary: "ui-icon-minus"
        },
        text: false
    });

    $( "#txt_bus_pro_nom" ).autocomplete({
        minLength: 2,
        delay: 10,
        source: "../venta/catalogo_buscar_nom.php",
        select: function( event, ui ) {
            $("#txt_bus_pro_nom").val(ui.item.label);
            $("#hdd_bus_pro_nom").val(ui.item.value);
            catalogo_buscar(ui.item.catid);

        }
    });


    $('#txt_bus_pro_codbar').keypress(function(e){
        if(e.which == 13){
            catalogo_buscar_codigo();
            venta_car('agregar');
            $("#txt_bus_pro_nom").val('');
            $("#hdd_bus_pro_nom").val('');
            $('#hdd_bus_cat_id').val('');
            $('#hdd_bus_cat_stouni').val('');
            $('#hdd_bus_cat_cospro').val('');
            $('#txt_bus_pro_codbar').val('');
            $('#txt_bus_cat_preven').val('');
            $('#txt_bus_cat_can').val('');
            $('#txt_precio_min').val('');
            $('#txt_precio_may').val('');
            $("#txt_bus_pro_codbar").focus();
        }
    });
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function catalogo_buscar(cat_id) {
    $.ajax({
        type: "POST",
        url: "../venta/catalogo_buscar.php",
        async:false,
        dataType: "json",
        data: ({
            action:	 'dato',
            unico_id: $('#unico_id').val(),
            txt_bus_pro_codbar: $('#txt_bus_pro_codbar').val(),
            txt_bus_pro_nom: $('#hdd_bus_pro_nom').val(),
            cmb_listaprecio_id: $('#cmb_listaprecio_id').val(),
            cat_id: cat_id
        }),
        beforeSend: function() {
            //$('#div_venta_pago_car').addClass("ui-state-disabled");
            $('#msj_venta_det').html("Buscando...");
            $('#msj_venta_det').show(100);
        },
        success: function(data){

            if(data.accion==0)
            {
                $('#hdd_bus_cat_id').val('');
                $('#hdd_bus_cat_stouni').val('');
                $('#hdd_bus_cat_cospro').val('');
                //$('#txt_bus_pro_codbar').val('');
                $('#txt_bus_pro_nom').val('');
                $('#txt_bus_cat_preven').val('');
                $('#txt_bus_cat_can').val('');

                $('#txt_precio_min').val('');
                $('#txt_precio_may').val('');
            }

            if (data.accion == 1) {
                if ($('#che_mayorista').is(':checked')) {
                    data.cat_preven = data.cat_premay;
                }

                $('#hdd_bus_cat_id').val(data.cat_id);
                $('#hdd_bus_cat_stouni').val(data.cat_stouni);
                $('#hdd_bus_cat_cospro').val(data.cat_cospro);
                $('#txt_bus_pro_nom').val(data.pro_nom);
                $('#txt_bus_cat_preven').val(data.cat_preven);
                $('#txt_bus_cat_can').val(data.cat_can);

                $('#txt_precio_min').val(data.cat_premin);
                $('#txt_precio_may').val(data.cat_premay);

                if ($('#chk_modo').is(':checked')) {
                    venta_car('agregar');

                    $('#hdd_bus_cat_id').val('');
                    $('#hdd_bus_cat_stouni').val('');
                    $('#hdd_bus_cat_cospro').val('');
                    $('#txt_bus_pro_codbar').val('');
                    $('#txt_bus_pro_nom').val('');
                    $('#txt_bus_cat_preven').val('');
                    $('#txt_bus_cat_can').val('');

                    $('#txt_precio_min').val('');
                    $('#txt_precio_may').val('');

                    $('#txt_bus_pro_codbar').focus();
                } else {
                    $('#txt_bus_pro_codbar').val(data.pro_codbar);
                    $('#txt_bus_cat_can').focus();
                }
                //precios_min_may($('#hdd_bus_cat_id').val());
            }
            if (data.accion == 2) {
                //$('#txt_bus_pro_codbar').val(data.pro_codbar);

                ///catalogo_venta_tab1();
                //alert(data.pro_codbar);
                //$('#txt_fil_pro_codbar').val('hola');
            }
        },
        complete: function(){
            //$('#div_venta_pago_car').removeClass("ui-state-disabled");
            $('#msj_venta_det').hide(100);
        }
    });
}
function catalogo_buscar_codigo(cat_id) {
    $.ajax({
        type: "POST",
        url: "../venta/catalogo_buscar_codigo.php",
        async:false,
        dataType: "json",
        data: ({
            action:	 'dato',
            unico_id: $('#unico_id').val(),
            txt_bus_pro_codbar: $('#txt_bus_pro_codbar').val(),
            txt_bus_pro_nom: $('#hdd_bus_pro_nom').val(),
            cmb_listaprecio_id: $('#cmb_listaprecio_id').val(),
            cat_id: cat_id
        }),
        beforeSend: function() {
            //$('#div_venta_pago_car').addClass("ui-state-disabled");
            $('#msj_venta_det').html("Buscando...");
            $('#msj_venta_det').show(100);
        },
        success: function(data){
            if(data.accion==0)
            {
                $('#hdd_bus_cat_id').val('');
                $('#hdd_bus_cat_stouni').val('');
                $('#hdd_bus_cat_cospro').val('');
                //$('#txt_bus_pro_codbar').val('');
                $('#txt_bus_pro_nom').val('');
                $('#txt_bus_cat_preven').val('');
                $('#txt_bus_cat_can').val('');
                $('#txt_precio_min').val('');
                $('#txt_precio_may').val('');
                $('#hdd_detven_tip').val('');
            }
            if (data.accion == 1) {
                if ($('#che_mayorista').is(':checked')) {
                    data.cat_preven = data.cat_premay;
                }else{
                    if ($('#cmb_listaprecio_id').val()!='') {
                        data.cat_preven = data.cat_prelista;
                    }
                }
                $('#hdd_bus_cat_id').val(data.cat_id);
                $('#hdd_bus_cat_stouni').val(data.cat_stouni);
                $('#hdd_bus_cat_cospro').val(data.cat_cospro);
                $('#txt_bus_pro_nom').val(data.pro_nom);
                $('#txt_bus_cat_preven').val(data.cat_preven);
                $('#txt_bus_cat_can').val(data.cat_can);
                $('#txt_precio_min').val(data.cat_premin);
                $('#txt_precio_may').val(data.cat_premay);
                $('#hdd_detven_tip').val(data.ven_tip);
                var cat_tipo= $('#hdd_detven_tip').val();
                $("#cmb_afec_id option[value="+ cat_tipo +"]").attr("selected",true);
                if ($('#chk_modo').is(':checked')) {
                    venta_car('agregar');
                    $('#hdd_bus_cat_id').val('');
                    $('#hdd_bus_cat_stouni').val('');
                    $('#hdd_bus_cat_cospro').val('');
                    $('#txt_bus_pro_codbar').val('');
                    $('#txt_bus_cat_preven').val('');
                    $('#txt_bus_cat_can').val('');
                    $('#txt_precio_min').val('');
                    $('#txt_precio_may').val('');
                    $('#hdd_bus_pro_nom').val('');
                    $('#txt_bus_pro_nom').val('');
                    $('#txt_bus_pro_nom').focus();
                } else {
                    $('#txt_bus_pro_codbar').val(data.pro_codbar);
                    $('#hdd_bus_pro_nom').val('');
                    $('#txt_bus_cat_preven').focus();
                }
                //precios_min_may($('#hdd_bus_cat_id').val());
            }
            if (data.accion == 2) {
                if ($('#cmb_listaprecio_id').val()) {
                    data.cat_preven = data.cat_prelista;
                }
                //$('#txt_bus_pro_codbar').val(data.pro_codbar);
                ///catalogo_venta_tab1();
                //alert(data.pro_codbar);
                //$('#txt_fil_pro_codbar').val('hola');
            }
        },
        complete: function(){
            //$('#div_venta_pago_car').removeClass("ui-state-disabled");
            $('#msj_venta_det').hide(100);
        }
    });
}

function foco() {
    if($('#chk_modo').is(':checked')) {
        $('#txt_bus_pro_codbar').focus();
    }else{
        $('#txt_bus_pro_nom').focus();
    }

}

function bus_cantidad(act)
{
    if($('#hdd_bus_cat_id').val()*1 > 0)
    {
        var can=($('#txt_bus_cat_can').val())*1;
        var sto=($('#hdd_bus_cat_stouni').val())*1;
        var valor=0;
        var sum=1;

        if(act=='mas')
        {
            valor=can+sum;
            if(valor<=sto)$('#txt_bus_cat_can').val(valor);
        }

        if(act=='menos')
        {
            valor=can-sum;
            if(valor>=1)$('#txt_bus_cat_can').val(valor);
        }
    }

}

</script>
<div>
<form id="for_ven">
<input name="action_venta" id="action_venta" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_ven_id" id="hdd_ven_id" type="hidden" value="<?php echo $_POST['ven_id']?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_SESSION['puntoventa_id']?>">
<input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $_SESSION['empresa_id']?>">
    <input name="hdd_ven_est" id="hdd_ven_est" type="hidden" value="<?php echo $est?>">

<input name="unico_id" id="unico_id" type="hidden" value="<?php echo $unico_id?>">

<fieldset>
  <legend>Datos Principales</legend>
  <table width="100%" border="0" cellspacing="0" cellpadding="0ESTADO SUNAT:">
    <tr>
      <td style="width:80%;"><label for="txt_ven_fec">Fecha:</label>
        <input name="txt_ven_fec" type="text" class="fecha" id="txt_ven_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly>
        <label for="cmb_ven_doc">Documento:</label>
        <select name="cmb_ven_doc" id="cmb_ven_doc" <?php if($_POST['action']=='editar')echo 'disabled'?>>
        </select>
        <label for="txt_ven_numdoc">N° Doc:</label>
        <input name="txt_ven_numdoc" type="text" id="txt_ven_numdoc" style="text-align:right; font-size:14px"  value="<?php echo $ser.'-'.$num?>" size="10" readonly>
        <?php //if($_POST['action']=="editar")echo $est?>
        <?php if($_POST['action']=="insertar"){?>
        <label for="chk_imprimir"> Imprimir Documento</label>
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
      <a class="btn_imp" title="Imprimir" href="#imprimir" onClick="cotizacion_impresion('<?php echo $_POST['ven_id']?>')">Imprimir</a>
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
                  <option value="COTIZADA" <?php if($est=='COTIZADA')echo 'selected'?>>COTIZADA</option>
                  <option value="VENDIDA" <?php if($est=='VENDIDA')echo 'selected'?>>VENDIDA</option>
              </select>
          </td>
      </tr>
    <tr>
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

    <td valign="top">
        <input name="txt_venpag_mon" type="hidden" class="venpag_moneda" id="txt_venpag_mon" style="text-align:right;" size="10" maxlength="10">
    </td>

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

    <fieldset><legend>Agregar Producto</legend>

        <label for="txt_ven_fec" style="display: none;">Fecha:</label>
        <input name="txt_ven_fec" type="hidden" class="fecha" id="txt_ven_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly>

        <input name="hdd_bus_cat_id" id="hdd_bus_cat_id"  type="hidden" value="">
        <input name="hdd_bus_cat_stouni" id="hdd_bus_cat_stouni"  type="hidden" value="">
        <input name="hdd_bus_cat_cospro" id="hdd_bus_cat_cospro"  type="hidden" value="">

        <label for="txt_bus_pro_codbar">COD</label>
        <input name="txt_bus_pro_codbar" type="text" id="txt_bus_pro_codbar" size="15">
        <label for="txt_bus_pro_nom">NOM</label>
        <input name="txt_bus_pro_nom" type="text" id="txt_bus_pro_nom" size="35" style="font-size:13px; font-weight:bold">
        <input name="hdd_bus_pro_nom" type="hidden" id="hdd_bus_pro_nom">

        <label for="txt_bus_cat_preven">S/.</label>
        <input name="txt_bus_cat_preven" type="text" id="txt_bus_cat_preven" value="" size="8" maxlength="9" style="text-align:right; font-size:13px; font-weight:bold" class="moneda">

        <label for="txt_bus_cat_can">CAN</label>
        <input name="txt_bus_cat_can" type="text" id="txt_bus_cat_can" class="cantidad_cat_ven" value="" size="5" maxlength="6" style="text-align:right; font-size:13px; font-weight:bold">

        <a class="btn_bus_mas" href="#mas" onClick="bus_cantidad('mas')">Aumentar</a>
        <a class="btn_bus_menos" href="#menos" onClick="bus_cantidad('menos')">Disminuir</a>

        <a class="btn_bus_agregar" href="#" onClick="foco(); venta_car('agregar')">Agregar</a>

        <br>
        <!--a class="btn_agregar_producto" title="Abrir Catálogo" href="#" onClick="catalogo_venta_tab1()">Catálogo</a -->
        <a class="btn_rest_act" href="#" onClick="foco(); venta_car('actualizar')">Actualizar</a>
        <a class="btn_rest_car" href="#" onClick="foco(); venta_car('restablecer')">Vaciar</a>

        <label for="chk_modo">Automático</label>
        <input name="chk_modo" type="checkbox" id="chk_modo" value="1" <?php if($modo_automatico==1)echo "checked"?>>

        <label for="txt_precio_min">P.MIN.</label>
        <input type="text" name="txt_precio_min" id="txt_precio_min" size="10" readonly>

        <label for="txt_precio_min" style="color: red;">P.MAY.</label>
        <input type="text" name="txt_precio_may" id="txt_precio_may" size="10" readonly>

        <label for="che_mayorista">Precio Mayorista</label>
        <input type="checkbox" id="che_mayorista" style="margin-top: 5px;">

        <div id="msj_venta_det" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>

    </fieldset>

<?php
if($_POST['action']=="insertar"){
?>
<div id="div_venta_car_tabla">
</div>
<div id="div_item_form">
</div>
<div id="div_venta_validar_form">
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
<script type="text/javascript">
//catalogo_venta_tab();
</script>