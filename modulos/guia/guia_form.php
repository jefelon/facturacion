<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../guia/cGuia.php");
$oGuia = new cGuia();

require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
}

if($_POST['action']=="editar"){
	$dts= $oGuia->mostrarUno($_POST['gui_id']);
	$dt = mysql_fetch_array($dts);
		$fec	=mostrarFecha($dt['tb_guia_fec']);		
		$rem	=$dt['tb_guia_rem'];//Remitente
		$des	=$dt['tb_guia_des'];//Destinatorio
		$punpar	=$dt['tb_guia_punpar'];//Punto de Partida
		$punlle	=$dt['tb_guia_punlle'];//Punto de Llegada
		$num	=$dt['tb_guia_num'];//Numero de guia
		$obs	=$dt['tb_guia_obs'];//Observacion
		$pla	=$dt['tb_guia_pla'];//Placa
		$mar	=$dt['tb_guia_mar'];//Marca del Vehículo
		$est	=$dt['tb_guia_est'];//Estado
		$tipope	=$dt['tb_guia_tipope'];//Tipo de Operacion
		$ven_id	=$dt['tb_venta_id'];//Venta Id
		$tras_id	=$dt['tb_traspaso_id'];//Transferencia Id
		$numdoc	=$dt['tb_guia_numdoc'];//Numero de Documento
		$con_id	=$dt['tb_conductor_id'];
		$con_doc	=$dt['tb_conductor_doc'];
		$con_nom	=$dt['tb_conductor_nom'];
		$con_dir	=$dt['tb_conductor_dir'];	
		$con_lic	=$dt['tb_conductor_lic'];		
		$con_cat	=$dt['tb_conductor_cat'];	
		$tra_id	=$dt['tb_transporte_id'];		
		$tra_ruc	=$dt['tb_transporte_ruc'];		
		$tra_razsoc	=$dt['tb_transporte_razsoc'];	
		$tra_dir	=$dt['tb_transporte_dir'];	
	mysql_free_result($dts);
}
?>
<script type="text/javascript">

$('.btn_ir').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$('.btn_tip_ope').button({
	icons: {primary: "ui-icon-plus"},
	text: "Agregar"
});
$(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$( "#txt_gui_fec" ).datepicker({
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

$('#btn_con_form_agregar').button({
	icons: {primary: "ui-icon-plus"},
	text: false
});
$("#btn_con_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('#btn_con_form_modificar').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});
$("#btn_con_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('#btn_tra_form_agregar').button({
	icons: {primary: "ui-icon-plus"},
	text: false
});
$("#btn_tra_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('#btn_tra_form_modificar').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});
$("#btn_tra_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

//Guia de Remision - Carrito de compra
function guia_car(act,idf)
{

    /*if($('#chk_cat_igv_'+idf).is(':checked')) {  
		var chk=1;  
	} else {  
		var chk=0;   
	}*/

	$.ajax({
		type: "POST",
		url: "guia_car.php",
		async:true,
		dataType: "html",                      
		data: ({
			action:	 act,
			cat_id:	 idf,
			cat_can: $('#txt_cat_can_'+idf).val()
		}),
		beforeSend: function() {
			$('#div_guia_car_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_guia_car_tabla').html(html);
		},
		complete: function(){			
			$('#div_guia_car_tabla').removeClass("ui-state-disabled");
			var tip_ope_id = $("#cbo_gui_tip_ope").val();		
			if(tip_ope_id == 1){
				$('#div_catalogo_traspaso').dialog("close");	
			}
			if(tip_ope_id == 2){
				$('#div_catalogo_venta').dialog("close");	
			}			
		}
	});   
}

function catalogo_guia(){
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_guia.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//gui_id:	idf
		}),
		beforeSend: function() {
			$('#msj_guia').hide();
			$('#div_catalogo_guia').dialog("open");
			$('#div_catalogo_guia').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_guia').html(html);				
		}
	});
}

//Antes de agregar el detalle de venta y/o transferencia al carrito se restablece la sessión para evitar inconsistencia en el detalle agregado
function restablecer_session(id){
	guia_car('restablecer', '');
	var tip_ope_id = $("#cbo_gui_tip_ope").val();		
	if(tip_ope_id == 1){
		traspaso_detalle_car(id);	
	}
	if(tip_ope_id == 2){
		venta_detalle_car(id);	
	}
}

function traspaso_detalle_car(tra_id){
	$.ajax({
		type: "POST",
		url: "../traspaso/traspaso_reg.php",
		async:true,
		dataType: "json",                      
		data: ({
			action_traspaso: "consultar",
			tra_id:	tra_id
		}),
		beforeSend: function() {
			/*$('#msj_guia').hide();
			$('#div_catalogo_traspaso').dialog("open");
			$('#div_catalogo_traspaso').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');*/
        },
		success: function(data){			
			$("#hdd_gui_tra_id").val(data.tra_id);			
			$('#txt_gui_tipope_num').val(""+data.tra_cod+"");				
		},
		complete: function(){			
			guia_car("consultar_detalle_trapaso", tra_id);
		}
	});
}

function venta_detalle_car(ven_id){
	$.ajax({
		type: "POST",
		url: "../guia/guia_numdoc_venta.php",
		async:true,
		dataType: "json",                      
		data: ({
			action_venta: "consultar",
			ven_id:	ven_id
		}),
		beforeSend: function() {
            $('#txt_gui_tipope_num').val('Cargando...');
			// $('#msj_guia').hide();
			// $('#div_catalogo_traspaso').dialog("open");
			// $('#div_catalogo_traspaso').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(data){			
			$("#hdd_gui_ven_id").val(data.ven_id);			
			$('#txt_gui_tipope_num').val(""+data.ven_numdoc+"");
		},
		complete: function(){
			guia_car("consultar_detalle_venta", ven_id);
		}
	});
}


function catalogo_traspaso(){		
	$.ajax({
		type: "POST",
		url: "../traspaso/traspaso_catalogo.html",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//gui_id:	idf
		}),
		beforeSend: function() {
			$('#msj_guia').hide();
			$('#div_catalogo_traspaso').dialog("open");
			$('#div_catalogo_traspaso').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_traspaso').html(html);				
		}
	});
}

function catalogo_venta(){		
	$.ajax({
		type: "POST",
		url: "../venta/venta_catalogo.html",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//gui_id:	idf
		}),
		beforeSend: function() {
			$('#msj_guia').hide();
			$('#div_catalogo_venta').dialog("open");
			$('#div_catalogo_venta').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_venta').html(html);				
		}
	});
}

function guia_detalle_tabla(){
	$.ajax({
		type: "POST",
		url: "../guia/guia_detalle_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			gui_id:	'<?php echo $_POST['gui_id']?>'
		}),
		beforeSend: function() {
			$('#div_guia_detalle_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_guia_detalle_tabla').html(html);
		},
		complete: function(){			
			$('#div_guia_detalle_tabla').removeClass("ui-state-disabled");
		}
	});     
}


function verificarAccionConductor(){
	var con_id = $("#txt_fil_gui_con_id").val();
	var accion;	
	if(con_id != ""){
		accion = "editar";
	}else{
		accion = "insertar";
	}	
	conductor_form(accion, con_id);	
}

function verificarAccionTransporte(){
	var tra_id = $("#txt_fil_gui_tra_id").val();
	var accion;	
	if(tra_id != ""){
		accion = "editar";
	}else{
		accion = "insertar";
	}	
	transporte_form(accion, tra_id);	
}

function conductor_form(act,idf){	
	$.ajax({
		type: "POST",
		url: "../conductor/conductor_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			con_id:	idf,
			vista:	'cmb_con_id'
		}),
		beforeSend: function() {
			//$('#msj_conductor').hide();
			$("#btn_con_form_agregar").click(function(e){
			  x=e.pageX+5;
			  y=e.pageY+15;
			  $('#div_conductor_form').dialog({ position: [x,y] });
			  $('#div_conductor_form').dialog("open");
		    });
			
			if(act=='editar'){
				if(idf>0){
					$("#btn_con_form_modificar").click(function(e){
					  x=e.pageX+5;
					  y=e.pageY+15;
					  $('#div_conductor_form').dialog({ position: [x,y] });
					  $('#div_conductor_form').dialog("open");
					});
				}
				else{
					alert('Seleccione Conductor');
				}
			}
			$('#div_conductor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_conductor_form').html(html);					
		}
	});
}

function actualizarDatosTransporte(){
	$.ajax({
		type: "POST",
		url: "../transporte/transporte_reg.php",
		async:true,
		dataType: "json",                      
		data: ({
			action: "obtener_datos",
			tra_id:	$("#txt_fil_gui_tra_id").val()
		}),
		beforeSend: function() {						
			//$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(data){			
			$('#txt_fil_gui_tra_razsoc').val(data.razonsocial);	
			$('#txt_fil_gui_tra_ruc').val(data.ruc);			
			$('#txt_fil_gui_tra_dir').val(data.direccion);
		}
	});		
}

function actualizarDatosConductor(){
	$.ajax({
		type: "POST",
		url: "../conductor/conductor_reg.php",
		async:true,
		dataType: "json",                      
		data: ({
			action: "obtener_datos",
			con_id:	$("#txt_fil_gui_con_id").val()
		}),
		beforeSend: function() {						
			//$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(data){			
			$('#txt_fil_gui_con_nom').val(data.nombre);	
			$('#txt_fil_gui_con_doc').val(data.documento);			
			$('#txt_fil_gui_con_dir').val(data.direccion);
		}
	});		
}

function transporte_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../transporte/transporte_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			tra_id:	idf,
			vista:	'cmb_tra_id'
		}),
		beforeSend: function() {
			//$('#msj_conductor').hide();
			$("#btn_tra_form_agregar").click(function(e){
			  x=e.pageX+5;
			  y=e.pageY+15;
			  $('#div_transporte_form').dialog({ position: [x,y] });
			  $('#div_transporte_form').dialog("open");
		    });
			
			if(act=='editar'){
				if(idf>0){
					$("#btn_tra_form_modificar").click(function(e){
					  x=e.pageX+5;
					  y=e.pageY+15;
					  $('#div_transporte_form').dialog({ position: [x,y] });
					  $('#div_transporte_form').dialog("open");
					});
				}
				else{
					alert('Seleccione Transporte');
				}
			}
			$('#div_transporte_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_transporte_form').html(html);					
		}
	});
}

function verificar_catalogo_apertura(){
	var tip_ope_id = $("#cbo_gui_tip_ope").val();		
	if(tip_ope_id == 1){
		catalogo_traspaso();		
	}
	if(tip_ope_id == 2){
		catalogo_venta();
	}
	
	if(tip_ope_id == '-'){
		$('#mensaje_dialogo').dialog("open");
	}
}

$(function() {
		
	<?php
	if($_POST['action']=="insertar"){
	?>
	guia_car();
	<?php
	}
	if($_POST['action']=="editar"){
	?>
	guia_detalle_tabla();
	<?php }?>
	
	$( "#div_conductor_form" ).dialog({
		title:'Información Conductor',
		autoOpen: false,
		resizable: false,
		height: 350,
		width: 530,
		//modal: true,
		buttons: {
			Guardar: function() {
				$("#for_con").submit();					
			},
			Cancelar: function() {
				$('#for_con').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_transporte_form" ).dialog({
		title:'Información Transporte',
		autoOpen: false,
		resizable: false,
		height: 300,
		width: 530,
		//modal: true,
		buttons: {
			Guardar: function() {
				$("#for_tra").submit();					
			},
			Cancelar: function() {
				$('#for_tra').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_catalogo_guia" ).dialog({
		title:'Catálogo de Guia',
		autoOpen: false,
		resizable: true,
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
	
	$( "#div_catalogo_traspaso" ).dialog({
		title:'Catálogo de Transferencias',
		autoOpen: false,
		resizable: true,
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
	
	$( "#div_catalogo_venta" ).dialog({
		title:'Catálogo de Ventas',
		autoOpen: false,
		resizable: true,
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

//formulario			
	$("#for_gui").validate({
		submitHandler: function() {						
			$.ajax({
				type: "POST",
				url: "../guia/guia_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_gui").serialize(),
				beforeSend: function(){
					$('#div_guia_form').dialog("close");
					$('#msj_guia').html("Guardando...");
					$('#msj_guia').show(100);
				},
				success: function(html){
					$('#msj_guia').html(html);
				},
				complete: function(){
					guia_tabla();
				}
			});			
		},
		rules: {
			txt_gui_fec: {
				required: true,
				dateITA: true
			},
			hdd_gui_numite: {
				required: true
			},
			txt_gui_num:{
				required: true
			},
			txt_gui_tipope_num: {
				required: true				
			},
			txt_fil_gui_tra_ruc:{
				required: true
			},
			txt_fil_gui_con_doc:{
				required: true	
			},
			txt_gui_punpar: {
				required: true	
			},
			txt_gui_punlle: {
				required: true	
			}
		},
		messages: {
			txt_gui_fec: {
				required: '*'
			},
			hdd_gui_numite: {
				required: 'Agregue producto a detalle de guia.'
			},
			txt_gui_num: {
				required: '*'
			},
			txt_gui_tipope_num: {
				required: '*'	
			},
			txt_fil_gui_tra_ruc: {
				required: '*'
			},
			txt_fil_gui_con_doc: {
				required: '*'
			},
			txt_gui_punpar: {
				required: '*'	
			},
			txt_gui_punlle: {
				required: '*'	
			}
		}
	});
	
	$(document).shortkeys({
	  'a+p':       function () { catalogo_guia() }
	});
	
	$( "#txt_fil_gui_con_nom" ).autocomplete({
   		minLength: 1,
   		//source: "../conductor/conductor_complete_nom.php",
		source: function(request, response){						
			$.ajax({
				url: "../conductor/conductor_complete_nom.php",
				dataType: "json",
				data:{
					term: request.term,
					tra_id: $("#txt_fil_gui_tra_id").val()
				},
				success: function(data){
					response(data);
				}
			});		
		},
		select: function(event, ui){			
			$("#txt_fil_gui_con_id").val(ui.item.id);							
			$("#txt_fil_gui_con_doc").val(ui.item.documento);
			$("#txt_fil_gui_con_dir").val(ui.item.direccion);		
		}
    });
	
	$( "#txt_fil_gui_con_doc" ).autocomplete({
   		minLength: 1,
   		//source: "../conductor/conductor_complete_doc.php?tra_id="+$("#txt_fil_gui_tra_id").val()+"",
		source: function(request, response){						
			$.ajax({
				url: "../conductor/conductor_complete_doc.php",
				dataType: "json",
				data:{
					term: request.term,
					tra_id: $("#txt_fil_gui_tra_id").val()
				},
				success: function(data){
					response(data);
				}
			});		
		},
		select: function(event, ui){			
			$("#txt_fil_gui_con_id").val(ui.item.id);							
			$("#txt_fil_gui_con_nom").val(ui.item.nombre);
			$("#txt_fil_gui_con_dir").val(ui.item.direccion);					
		}
    });
	
	
	$( "#txt_fil_gui_tra_razsoc" ).autocomplete({
   		minLength: 1,
   		source: "../transporte/transporte_complete_razsoc.php",
		select: function(event, ui){			
			$("#txt_fil_gui_tra_id").val(ui.item.id);							
			$("#txt_fil_gui_tra_ruc").val(ui.item.ruc);
			$("#txt_fil_gui_tra_dir").val(ui.item.direccion);	
			limpiar_cajas_conductor();
			$("#fset_conductor").removeAttr("disabled");//Habilito Fielset conductor
		}
    });
	
	$( "#txt_fil_gui_tra_ruc" ).autocomplete({
   		minLength: 1,
   		source: "../transporte/transporte_complete_ruc.php",
		select: function(event, ui){			
			$("#txt_fil_gui_tra_id").val(ui.item.id);							
			$("#txt_fil_gui_tra_razsoc").val(ui.item.razonsocial);
			$("#txt_fil_gui_tra_dir").val(ui.item.direccion);
			limpiar_cajas_conductor();
			$("#fset_conductor").removeAttr("disabled");//Habilito Fielset conductor		
		}
    });
	
	function limpiar_cajas_conductor(){
		$("#txt_fil_gui_con_id").val("");							
		$("#txt_fil_gui_con_doc").val("");			
		$("#txt_fil_gui_con_nom").val("");
		$("#txt_fil_gui_con_dir").val("");
	}
	
	$("#cbo_gui_tip_ope").change(function(){		
		var cbo_gui_tip_ope = $("#cbo_gui_tip_ope").val();
		if(cbo_gui_tip_ope == 1){			
			$("#lbl_gui_tipope_nom").text("Código de Transferencia:");	
		}else{
			$("#lbl_gui_tipope_nom").text("Número de Documento:");	
		}		
		$("#txt_gui_tipope_num").val("");
	});
	
	$( "#mensaje_dialogo" ).dialog({
		modal: true,
		autoOpen: false,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
</script>
<style>
	.ui-cmb_con_id {
		position: relative;
		display: inline-block;
	}
	.ui-cmb_con_id-input {
		margin: 0;
		padding: 0.3em;
	}
	</style>
<form id="for_gui">
<input name="action_guia" id="action_guia" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_gui_id" id="hdd_gui_id" type="hidden" value="<?php echo $_POST['gui_id']?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_gui_est" id="hdd_gui_est" type="hidden" value="<?php echo $est?>">
<fieldset>
  <legend>Datos Principales</legend>
  	
    <table>
    	<tr>
        	<td align="right"><label for="txt_gui_fec">Fecha:</label></td>
            <td><input name="txt_gui_fec" type="text" class="fecha" id="txt_gui_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly></td>
            <td align="right">&nbsp;</td>            
            <td align="right"><label for="txt_gui_rem">Remitente:</label></td> 
            <td><input type="text" name="txt_gui_rem" id="txt_gui_rem"  value="<?php echo $rem?>" size="50" /></td>                     
        </tr>
        <tr>
        	<td align="right"><label for="txt_gui_num">Número de Guía:</label></td>
            <td><input type="text" name="txt_gui_num" id="txt_gui_num"  value="<?php echo $num?>"></td>
            <td align="right">&nbsp;</td>                        
            <td align="right"><label for="txt_gui_des">Destinatario:</label></td> 
            <td><input name="txt_gui_des" type="text" id="txt_gui_des"  value="<?php echo $des?>" size="50" /></td>         
        </tr>
        <tr>
        	<td align="right"><label for="txt_gui_punpar">Punto de Partida:</label><br /></td>
            <td><input type="text" name="txt_gui_punpar" id="txt_gui_punpar"  value="<?php echo $punpar?>" size="50" /></td>
            <td>&nbsp;</td>
            <td align="right"><label for="txt_gui_obs">Observación:</label></td> 
            <td rowspan="2"><textarea id="txt_gui_obs" name="txt_gui_obs" rows="3" cols="50"><?php echo $obs?></textarea></td>
            
        </tr>
        
        <tr>
        	<td align="right"><label for="txt_gui_punlle">Punto de Llegada:</label><br /></td>
            <td><input type="text" name="txt_gui_punlle" id="txt_gui_punlle"  value="<?php echo $punlle?>" size="50" /></td>
            <td align="right">&nbsp;</td>
            
        </tr>              
    </table>      
       
       <?php if($_POST['action']=='editar') echo $est?>
         
        <!--<label for="txt_fil_gui_con">Conductor:</label>
     <select name="cmb_con_id" id="cmb_con_id">
          </select>
          <input type="hidden" id="txt_fil_gui_con_id" name="txt_fil_gui_con_id" value="<?php //echo $con_id?>" />
    		<input type="text" id="txt_fil_gui_con" name="txt_fil_gui_con" size="40" value="<?php //echo $con_nom?>" />-->
<br />      
          
          <div id="div_conductor_form"></div>  
            <div id="div_transporte_form"></div>         
          <!--<label for="cmb_gui_est">Estado:</label>
          <select name="cmb_gui_est" id="cmb_gui_est">
            <option value="">-</option>
            <option value="EMITIDA" <?php //if($est=='EMITIDA')echo 'selected'?>>EMITIDA</option>
            <option value="CANCELADA" <?php //if($est=='CANCELADA')echo 'selected'?>>CANCELADA</option>
          </select>-->
</fieldset>
<fieldset>
	<legend>Datos Operación</legend>
    <!--Tipo de Operacion-->
   	<label for="cbo_gui_tip_ope">Tipo:</label>
   	<select id="cbo_gui_tip_ope" name="cbo_gui_tip_ope" <?php if($_POST['action'] == "editar"){ echo "disabled";}?>>
    	<option value="-">-</option>
    	<option value="1" <?php if($tipope == 1){ echo "selected";}?>>Transferencia</option>
    	<option value="2" <?php if($tipope == 2){ echo "selected";}?>>Venta</option>
   	</select>
    <a id="btn_cmb_tip_ope" class="btn_tip_ope" href="#" onClick="verificar_catalogo_apertura()" <?php if($_POST['action'] == "editar"){ echo "style='display:none'";}?>>Agregar</a>
    <label for="txt_gui_tipope_num" id="lbl_gui_tipope_nom"><?php if($tipope == 1){ echo "Código de Transferencia";}else{ echo "Número de Documento";}?></label>
    <input type="text" id="txt_gui_tipope_num" readonly="readonly" name="txt_gui_tipope_num" size="10" value="<?php echo $numdoc?>" <?php if($_POST['action'] == "editar"){ echo "disabled";}?> />
    <input type="hidden" id="hdd_gui_tra_id" name="hdd_gui_tra_id" value="<?php echo $tras_id?>" />
    <input type="hidden" id="hdd_gui_ven_id" name="hdd_gui_ven_id" value="<?php echo $ven_id?>" />
    <div id="div_catalogo_traspaso"></div>
    <div id="div_catalogo_venta"></div>
</fieldset>

<fieldset>
	<legend>Datos Transporte</legend>
   	<?php if($_POST['action']=='insertar'){?>
    <!--Boton Editar/Registrar Conductor-->
    <a id="btn_tra_form_agregar" href="#" onClick="transporte_form('insertar')">Agregar Transporte</a>
    <a id="btn_tra_form_modificar" href="#" onClick='transporte_form("editar", $("#txt_fil_gui_tra_id").val())'>Modificar Transporte</a>
    <?php }?> 
    <input type="hidden" id="txt_fil_gui_tra_id" name="txt_fil_gui_tra_id" value="<?php echo $tra_id?>" />
    <label for="txt_fil_gui_tra_ruc">RUC:</label>
    <input type="text" id="txt_fil_gui_tra_ruc" name="txt_fil_gui_tra_ruc" size="15" value="<?php echo $tra_ruc?>" /> 
    <!--<a id="btn_cmb_tra_id" class="btn_ir" href="#" onClick="verificarAccionTransporte()">Agregar Transporte</a>-->
     <label for="txt_fil_gui_tra_razsoc">Transporte:</label>
    <input type="text" id="txt_fil_gui_tra_razsoc" name="txt_fil_gui_tra_razsoc" size="40" value="<?php echo $tra_razsoc?>" />
    <label for="txt_fil_gui_tra_dir">Direcci&oacute;n:</label>
    <input type="text" id="txt_fil_gui_tra_dir" name="txt_fil_gui_tra_dir" size="40" value="<?php echo $tra_dir?>" disabled="disabled"/>    
</fieldset>


<fieldset id="fset_conductor" disabled="disabled">
	<legend>Datos Conductor</legend>
	<?php if($_POST['action']=='insertar'){?>
    <!--Boton Editar/Registrar Conductor-->
    <a id="btn_con_form_agregar" href="#" onClick="conductor_form('insertar')">Agregar Conductor</a>
    <a id="btn_con_form_modificar" href="#" onClick='conductor_form("editar", $("#txt_fil_gui_con_id").val())'>Modificar Conductor</a>
    <?php }?>   
    <input type="hidden" id="txt_fil_gui_con_id" name="txt_fil_gui_con_id" value="<?php echo $con_id?>" />
    <label for="txt_fil_gui_con_doc">RUC/DNI:</label>
    <input type="text" id="txt_fil_gui_con_doc" name="txt_fil_gui_con_doc" size="15" value="<?php echo $con_doc?>" /> 
    <!--<a id="btn_cmb_con_id" class="btn_ir" href="#" onClick="verificarAccionConductor()">Agregar Conductor</a>-->
     <label for="txt_fil_gui_con_nom">Conductor:</label>
    <input type="text" id="txt_fil_gui_con_nom" name="txt_fil_gui_con_nom" size="40" value="<?php echo $con_nom?>" />
    <label for="txt_fil_gui_con_dir">Direcci&oacute;n:</label>
    <input type="text" id="txt_fil_gui_con_dir" name="txt_fil_gui_con_dir" size="40" value="<?php echo $con_dir?>" readonly="readonly"/>
    <label for="txt_fil_gui_con_lic">Licencia:</label>
    <input type="text" id="txt_fil_gui_con_lic" name="txt_fil_gui_con_lic" size="15" value="<?php echo $con_lic?>" readonly="readonly"/>
    <label for="txt_fil_gui_con_cat">Categoría:</label>
    <input type="text" id="txt_fil_gui_con_cat" name="txt_fil_gui_con_cat" size="10" value="<?php echo $con_cat?>" readonly="readonly"/>
</fieldset>

<fieldset>
	<legend>Datos Vehículo</legend>
   	<label for="txt_gui_mar">Marca:</label>
    <input type="text" id="txt_gui_mar" name="txt_gui_mar" value="<?php echo $mar?>" />
    <label for="txt_gui_pla">Placa:</label>
    <input type="text" name="txt_gui_pla" id="txt_gui_pla"  value="<?php echo $pla?>">
</fieldset>
<?php
if($_POST['action']=="insertar"){
?>
<div id="div_guia_car_tabla">
</div>

<div id="div_item_form">
</div>
<?php }?>
</form>
<?php
if($_POST['action']=="insertar"){
?>
<div id="div_catalogo_guia">
</div>
<?php
}
if($_POST['action']=="editar"){
?>
<div id="div_guia_detalle_tabla">
</div>
<?php }?>

<div id="mensaje_dialogo" title="Mensaje del Sistema">
    <p align="justify">
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Por favor, Seleccione un elemento del Combo "Tipo de Operación"
    </p>
    <p>
        <b>- Transferencia </b><br />
        <b>- Venta</b>
    </p>
</div>