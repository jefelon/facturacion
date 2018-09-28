<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
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
		$numdoc	=$dt['tb_compra_numdoc'];
		$mon	=$dt['tb_compra_mon'];
		$tipcam	=$dt['tb_compra_tipcam'];
		
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
		
		$tipper	=$dt['tb_compra_tipper'];
		$per	=$dt['tb_compra_per'];		
		
		$alm_id	=$dt['tb_almacen_id'];
		$est	=$dt['tb_compra_est'];
        $numorden	=$dt['tb_compra_orden'];
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
$("#btn_pro_form_agregar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('#btn_pro_form_modificar').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});
$("#btn_pro_form_modificar").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('#btn_compra_precio_form').button({
	icons: {primary: "ui-icon-newwin"},
	text: true
});



$( "#txt_com_fec" ).datepicker({
	minDate: "-1Y",
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
	//minDate: "0D", 
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

function compra_car(act,idf,pre)
{
    /*if($('#chk_cat_igv_'+idf).is(':checked')) {  
		var chk=1;  
	} else {  
		var chk=0;   
	}*/
	if($('#chk_com_tipper').is(':checked')) {  
		var tipper=1;  
	} else {  
		var tipper=0;   
	}
	$.ajax({
		type: "POST",
		url: "compra_car.php",
		async:true,
		dataType: "html",                      
		data: ({
			action:	 act,
			cat_id:	 idf,
			cat_can: 		$('#txt_cat_can_'+idf).val(),
			cat_precom: 	$('#txt_cat_precom_'+idf).val(),
			cat_des: 		$('#txt_detcom_des_'+idf).val(),
			cat_fle:	 	$('#txt_detcom_fle_'+idf).val(),
			tipo_cambio: 	$('#txt_com_tipcam').val(),
			tipo_precio:	pre,
            cmb_afec_id: 	$('#cmb_afec_id_'+idf).val(),
			com_tipper:	tipper
		}),
		beforeSend: function() {
			//$("#txt_fil_pro_nom").val(''); $("#txt_fil_pro_nom").focus();
			$('#div_compra_car_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_compra_car_tabla').html(html);
		},
		complete: function(){			
			$('#div_compra_car_tabla').removeClass("ui-state-disabled");
		}
	});   
}

function compra_car_prorrateo()
{
	$.ajax({
		type: "POST",
		url: "compra_car_prorrateo.php",
		async:true,
		dataType: "json",                      
		data: ({
			com_des: 	$('#txt_com_des').val(),
			com_fle:	$('#txt_com_fle').val(),
			com_ajupos:	$('#txt_com_ajupos').val(),
			com_ajuneg:	$('#txt_com_ajuneg').val(),
			com_tipfle: $('#cmb_com_tipfle').val()		
		}),
		beforeSend: function(){
			$('#msj_compra_car_item').html("Cargando...");
			$('#msj_compra_car_item').show(100);				
		},
		success: function(data){
			$('#msj_compra_car_item').html(data.msj);
		},
		complete: function(){
			compra_car('actualizar');			
		}
	});   
}

function catalogo_compra(){
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_compra.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//tippre:	$('#cmb_com_tippre').val()
		}),
		beforeSend: function() {
			$('#msj_compra').hide();
			$('#div_catalogo_compra').dialog("open");
			$('#div_catalogo_compra').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_compra').html(html);				
		}
	});
}

function compra_detalle_tabla()
{
	$.ajax({
		type: "POST",
		url: "../compra/compra_detalle_tabla.php",
		async:true,
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

function catalogo_compra_tab(){
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
            $('#div_catalogo_compra').dialog("open");
            $('#div_catalogo_compra').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_catalogo_compra').html(html);
        },
        complete: function(){
            catalogo_venta();
            catalogo_servicio();
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

function editar_datos_item(idf, nom){	
	$.ajax({
		type: "POST",
		url: "../compra/compra_car_item.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id:	idf,
			action: "editar",
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

function tipo_cambio(mon){
	$.ajax({
		type: "POST",
		url: "../tipocambio/tipocambio_reg.php",
		async:true,
		dataType: "json",                      
		data: ({
			action: "obtener_dato",
			fecha:	$('#txt_com_fec').val(),
			moneda:	mon
		}),
		beforeSend: function() {						
			//$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(data){
			$('#txt_com_tipcam').val(data.tipcam);	
		},
		complete: function(){
		    //catalogo_compra_tab(); //NI IDEA
		}
	});		
}

function verificar_duplicidad_compra(com_doc,com_numdoc,com_numruc){
	$.ajax({
		type: "POST",
		url: "../compra/compra_duplicidad.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc: com_doc,				
			numdoc:	com_numdoc,
            numruc:	com_numruc
		}),
		beforeSend: function(){				

		},
		success: function(html){
			$('#div_duplicidad').dialog("open");	
			$('#div_duplicidad').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
			$('#div_duplicidad').html(html);
		}
	});	
}

$(function() {
	
	cmb_com_doc();
	cmb_com_alm_id();
	
	<?php
	if($_POST['action']=="insertar"){
	?>
	compra_car('restablecer');
	compra_car();
	
	tipo_cambio($('#cmb_com_mon').val());
	
	$('#cmb_com_mon').change(function(e) {
		compra_car('restablecer');
		tipo_cambio($('#cmb_com_mon').val());
        //catalogo_compra_tabla();
    });
	$('#txt_com_fec').change(function(e) {
		tipo_cambio($('#cmb_com_mon').val());
    });
		
	$('#chk_com_tipper').change( function() {
		compra_car('actualizar');
	});

    $("#cmb_com_doc").change(function() {
        if ($(this).val()=='20' || $(this).val()=='21'){
            $('#nota-debito-credito').show();
            $("#txt_com_ser_nota").attr('disabled', false);
            $("#txt_com_num_nota").attr('disabled', false);
            $("#cmb_com_tip").attr('disabled', false);

        }else{
            $('#nota-debito-credito').hide();
            $("#txt_com_ser_nota").attr('disabled', true);
            $("#txt_com_num_nota").attr('disabled', true);
            $("#cmb_com_tip").attr('disabled', true);
        }
    });

	$("#txt_com_numdoc").change(function() {

        if($('#txt_com_pro_doc').val()>0 && $('#txt_com_numdoc').val()!="")
        {
            verificar_duplicidad_compra($('#cmb_com_doc').val(),$('#txt_com_numdoc').val(),$('#txt_com_pro_doc').val());

        }

	});

	<?php
	}
	if($_POST['action']=="editar"){
	?>
	proveedor_cargar_datos(<?php echo $pro_id?>);
	compra_detalle_tabla();
	$('#cmb_com_alm_id').attr('disabled', 'disabled');
	$('#txt_com_pro_nom,#txt_com_pro_doc,#txt_com_pro_dir,#cmb_com_mon,#txt_com_tipcam').attr('disabled', 'disabled');
	//$("#cmb_com_alm_id").addClass("ui-state-disabled");
	$('#chk_com_tipper').attr('disabled', 'disabled');
	<?php }?>
	
	$( "#txt_com_pro_nom").autocomplete({
   		minLength: 1,
   		source: "../proveedor/proveedor_complete_nom.php",
		select: function(event, ui){			
			$("#hdd_com_pro_id").val(ui.item.id);							
			$("#txt_com_pro_doc").val(ui.item.documento);
			$("#txt_com_pro_dir").val(ui.item.direccion);
            if($('#txt_com_pro_doc').val()>0 && $('#txt_com_numdoc').val()!="")
            {
                verificar_duplicidad_compra($('#cmb_com_doc').val(),$('#txt_com_numdoc').val(),$('#txt_com_pro_doc').val());
            }
		}

    });
	
	$( "#txt_com_pro_doc" ).autocomplete({
   		minLength: 1,
   		source: "../proveedor/proveedor_complete_doc.php",
		select: function(event, ui){			
			$("#hdd_com_pro_id").val(ui.item.id);							
			$("#txt_com_pro_nom").val(ui.item.nombre);
			$("#txt_com_pro_dir").val(ui.item.direccion);
            if($('#txt_com_pro_doc').val()>0 && $('#txt_com_numdoc').val()!="")
            {
                verificar_duplicidad_compra($('#cmb_com_doc').val(),$('#txt_com_numdoc').val(),$('#txt_com_pro_doc').val());
            }
		}

    });
	
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
	
	$( "#div_catalogo_compra" ).dialog({
		title:'Catálogo de Compra',
		autoOpen: false,
		resizable: true,
		height: 300,
		width: 950,
		modal: false,
		position: "bottom"/*,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}*/
	});
	
	//Formulario para actualizar Item de Detalle de Compra
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
	
	//Duplicidad de compra
	$( "#div_duplicidad" ).dialog({
		title:'Consulta de registro de compras por N° de Documento.',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 850,
		modal: true,
        open: function(event, ui) { $(this).parent().find(".ui-dialog-titlebar-close").remove(); },
		buttons: {
			OK: function() {
				$( this ).dialog( "close" );
                $('#txt_com_numdoc').val('');
                $('#hdd_com_pro_id').val('');
                $('#txt_com_pro_doc').val('');
                $('#txt_com_pro_nom').val('');
                $('#txt_com_pro_dir').val('');
                $('#txt_com_numdoc').focus();
			}
		}
	});

    $(function() {
        $( "#dialog" ).dialog({
            open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
        });

    });


	
//formulario			
	$("#for_com").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../compra/compra_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_com").serialize(),
				beforeSend: function(){
					$('#div_compra_form').dialog("close");
					$('#msj_compra').html("Guardando...");
					$('#msj_compra').show(100);
				},
				success: function(data){
					if(data.redireccionar){
					 	alert("Compra No Registrada.\n Por Favor Inicie Sesión Nuevamente.");
					 	window.location.href = "../usuarios/cerrar_sesion.php";
					 	return;
					}

					$('#msj_compra').html(data.com_msj);
					
					<?php if($_POST['action']=='insertar'){?>
                    if (data.com_id){
                        compra_precio_form('insertar',data.com_id);
                    }
					<?php }?>
				},
				complete: function(){
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
	  //'a+p':       function () { catalogo_compra() },
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
<input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_SESSION['puntoventa_id']?>">
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
       <input style="width:90px" type="text" name="txt_com_numdoc" id="txt_com_numdoc"  value="<?php echo $numdoc?>">
    <label for="txt_com_numorden">N° Orden:</label>
    <input style="width:90px" type="text" name="txt_com_numorden" id="txt_com_numorden"  value="<?php echo $numorden?>">
    <?php /*?>
    <label for="chk_com_tipper">Percepción(2%)</label><input name="chk_com_tipper" type="checkbox" id="chk_com_tipper" value="1" <?php if($tipper==1)echo 'checked'?>><?php */?>
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
       <?php if($_POST['action']=='insertar'){?>
     <a class="btn_newwin" target="_blank" title="Tipo de Cambio" href="../tipocambio">Tipo de Cambio</a>
     <?php }?>
	   <label for="txt_com_tipcam">Cambio:</label>
	   <input name="txt_com_tipcam" type="text" value="<?php echo $tipcam?>" id="txt_com_tipcam" size="5" maxlength="5" style="text-align:right" readonly>
	   <label for="cmb_com_alm_id">Colocar producto en:</label>
      <select name="cmb_com_alm_id" id="cmb_com_alm_id">
          </select>

          <label for="cmb_com_est">Estado:</label>
    <select name="cmb_com_est" id="cmb_com_est">
            <option value="">-</option>
            <option value="CREDITO" <?php if($est=='EMITIDA')echo 'selected'?>>CREDITO</option>
            <option value="CONTADO" <?php if($est=='CANCELADA')echo 'selected'?>>CONTADO</option>
          </select>
        <?php if($_POST['action']=='insertar'){?>
        <label for="cmb_com_tippre">Mostrar  con:</label>
            <select name="cmb_com_tippre" id="cmb_com_tippre">
            <option value="1" selected="selected">Valor Venta(sin IGV)</option>
            <option value="2">Precio Venta(con IGV)</option>
        </select>
            <div id="nota-debito-credito" style="display:none;">
                <label for="cmb_com_tip">Tipo:</label>
                <select name="cmb_com_tip" id="cmb_com_tip">
                    <option value="1" selected="selected">ANULACIÓN DE LA OPERACIÓN</option>
                    <option value="6" selected="selected">DEVOLUCIÓN TOTAL</option>
                    <option value="9" selected="selected">DISMINUICIÓN EN EL VALOR</option>
                </select>
                <label for="txt_com_ser_nota">Serie:</label>
                <input name="txt_com_ser_nota" type="text" id="txt_com_ser_nota" disabled
                       style="text-align:right; font-size:14px" value=""
                       maxlength="4" size="6">
                <label for="txt_com_num_nota">Número:</label>
                <input name="txt_com_num_nota" type="text" id="txt_com_num_nota" disabled
                       style="text-align:right; font-size:14px" value=""
                       maxlength="8" size="10">
            </div>
  		<?php }?>
    <?php //if($_POST['action']=='editar') echo 'COMPRA: '.$est?>
    <?php if($_POST['action']=='editar'){?>
    <a id="btn_compra_precio_form" href="#precio" onClick="compra_precio_form('insertar','<?php echo $_POST['com_id']?>')">Actualizar Precios</a>
		<?php }?>

    </table>
</fieldset>
<input type="hidden" id="hdd_com_pro_id" name="hdd_com_pro_id" value="<?php echo $pro_id?>" />
<fieldset>
	<legend>Datos Proveedor</legend>
    <div id="div_proveedor_form">
	</div>
    <?php if($_POST['action']=='insertar'){?>
    <a id="btn_pro_form_agregar" href="#" onClick="proveedor_form_i('insertar')">Agregar Proveedor</a>
    <a id="btn_pro_form_modificar" href="#" onClick='proveedor_form_i("editar",$("#hdd_com_pro_id").val())'>Modificar Proveedor</a>
    <?php }?>
    <label for="txt_com_pro_doc">RUC/DNI:</label>
    <input type="text" id="txt_com_pro_doc" name="txt_com_pro_doc" size="11" value="<?php echo $pro_doc?>" /> 
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
if($_POST['action']=="insertar"){
?>
<div id="div_catalogo_compra">
</div>
<div id="div_duplicidad">
</div>
<?php
}
if($_POST['action']=="editar"){
?>
<div id="div_compra_detalle_tabla">
</div>
<?php }?>