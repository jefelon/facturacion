<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Cuenta Cliente</title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.position.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.dialog.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.effects.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.autocomplete.js"></script>

<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/i18n/jquery.ui.datepicker-es.js"></script>

<script src="../../js/Moneda/autoNumeric.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript" src="../../js/jquery-shortkeys/shortkeys.js"></script>

<script type="text/javascript">
function clientecuenta_tabla(){	
	$.ajax({
		type: "POST",
		url: "../clientecuenta/clientecuenta_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			//pro_est:	$('#cmb_fil_pro_est').val()
		}),
		beforeSend: function() {
			$('#div_clientecuenta_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_clientecuenta_tabla').html(html);
		},
		complete: function(){			
			$('#div_clientecuenta_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function cliente_buscar(){	
	$.ajax({
		type: "POST",
		url: "../clientes/cliente_buscar.php",
		async:true,
		dataType: "html",                      
		data: ({
			//pro_est:	$('#cmb_fil_pro_est').val()
		}),
		beforeSend: function() {
			//$('#div_cliente_buscar').addClass("ui-state-disabled");
			$('#div_cliente_buscar').dialog("open");
			$('#div_cliente_buscar').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){			
			$('#div_cliente_buscar').html(html);
		},
		complete: function(){			
			//$('#div_cliente_buscar').removeClass("ui-state-disabled");
		}
	});     
}

function cliente_filtro_seleccionar(){
	$.ajax({
		type: "POST",
		url: "../clientes/cliente_filtro_seleccionar.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_clientecuenta_filtro_cliente').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){			
			$('#div_clientecuenta_filtro_cliente').html(html);
		},
		complete: function(html){
			$("#div_clientecuenta_tabla").html("");
		}
	});
}

function clientecuenta_form(act,act2,idf){
	if($("#hdd_fil_cli_id").val()>0)
	{
		$.ajax({
			type: "POST",
			url: "../clientecuenta/clientecuenta_form.php",
			async:true,
			dataType: "html",                      
			data: ({
				action: act,
				action2: act2,
				clicue_id:	idf,
				cli_id:	$("#hdd_fil_cli_id").val(),
				vista:	'clientecuenta_tabla'
			}),
			beforeSend: function() {
				$('#msj_clientecuenta').hide();
				$('#div_clientecuenta_form').dialog("open");
				$('#div_clientecuenta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
			},
			success: function(html){			
				$('#div_clientecuenta_form').html(html);
				$('#hdd_cli_id').val($('#hdd_fil_cli_id').val());
			}
		});
	}
	else
	{
		alert('Seleccione cliente');
	}
}

function clientecuenta_form_pago(act,act2,idf){
	if($("#hdd_fil_cli_id").val()>0)
	{
		$.ajax({
			type: "POST",
			url: "../clientecuenta/clientecuenta_form_pago.php",
			async:true,
			dataType: "html",                      
			data: ({
				action: act,
				action2: act2,
				clicue_id:	idf,
				cli_id:	$("#hdd_fil_cli_id").val(),
				vista:	'clientecuenta_tabla'
			}),
			beforeSend: function() {
				$('#msj_clientecuenta').hide();
				$('#div_clientecuenta_form').dialog("open");
				$('#div_clientecuenta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
			},
			success: function(html){			
				$('#div_clientecuenta_form').html(html);
				$('#hdd_cli_id').val($('#hdd_fil_cli_id').val());
			}
		});
	}
	else
	{
		alert('Seleccione cliente');
	}
}

function clientecuenta_form_pago_todos(act,act2,idf){
    if($("#hdd_fil_cli_id").val()>0)
    {
        $.ajax({
            type: "POST",
            url: "../clientecuenta/clientecuenta_form_pago_todos.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                action2: act2,
                clicue_id:	idf,
                cli_id:	$("#hdd_fil_cli_id").val(),
                vista:	'clientecuenta_tabla'
            }),
            beforeSend: function() {
                $('#msj_clientecuenta').hide();
                $('#div_clientecuenta_form').dialog("open");
                $('#div_clientecuenta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_clientecuenta_form').html(html);
                $('#hdd_cli_id').val($('#hdd_fil_cli_id').val());
            }
        });
    }
    else
    {
        alert('Seleccione cliente');
    }
}

function seleccionar_cliente(cli_id){
	$.ajax({
		type: "POST",
		url: "../clientecuenta/clientecuenta_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			cli_id:	$("#hdd_fil_cli_id").val(),
            cli_cobrar_varios:	$("#chk_cobrar_varios").val()
		}),
		beforeSend: function() {
			$('#div_clientecuenta_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_clientecuenta_tabla').html(html);
		},
		complete: function(){			
			$('#div_clientecuenta_tabla').removeClass("ui-state-disabled");
			$('#div_cliente_buscar').dialog("close");						
		}
	}); 
}

function eliminar_clientecuenta(id){   
	$('#msj_clientecuenta').hide();   
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "clientecuenta_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			beforeSend: function() {
				$('#msj_clientecuenta').html("Cargando...");
				$('#msj_clientecuenta').show(100);
			},
			success: function(html){
				$('#msj_clientecuenta').html(html);
			},
			complete: function(){
				seleccionar_cliente();
			}
		});
	}
}

function verificar_actualizacion_estado_entradas(){
	$.ajax({
		type: "POST",
		url: "../clientecuenta/clientecuenta_actualizarestado_entradas.php",
		async:true,
		dataType: "html",                      
		data: ({
			cli_id:	$("#hdd_fil_cli_id").val()
		}),
		beforeSend: function() {
			//$('#div_clientecuenta_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			//$('#div_clientecuenta_tabla').html(html);
			//alert(html);
		},
		complete: function(){			
			seleccionar_cliente($("#hdd_fil_cli_id").val());
		}
	}); 
}

function actualizar_estado_clientecuenta(idf,act){
	$.ajax({
		type: "POST",
		url: "../clientecuenta/clientecuenta_actualizar_estado.php",
		async:true,
		dataType: "html",                      
		data: ({
			clicue_id:	idf,
			action: act
		}),
		beforeSend: function() {
			//alert(idf);
			//$('#div_clientecuenta_tabla').addClass("ui-state-disabled");
    },
		success: function(html){
			//$('#div_clientecuenta_tabla').html(html);
			//alert(html);
		},
		complete: function(){			
			seleccionar_cliente($("#hdd_fil_cli_id").val());
		}
	}); 
}

//
function venta_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../venta/venta_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ven_id:	idf,
			vista:	'administrador'
		}),
		beforeSend: function() {
			$('#msj_venta').hide();
			$('#div_venta_form').dialog("open");
			$('#div_venta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_form').html(html);				
		}
	});
}
function ventanota_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../ventanota/venta_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			ven_id:	idf,
			vista:	'administrador'
		}),
		beforeSend: function() {
			$('#msj_ventanota').hide();
			$('#div_ventanota_form').dialog("open");
			$('#div_ventanota_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_ventanota_form').html(html);				
		}
	});
}
function recibo_impresion(idf){
	$.ajax({
		type: "POST",
		url: "recibo_preimpresion.php",
		async:true,
		dataType: "html",                      
		data: ({
			clicue_id:	idf
		}),
		beforeSend: function() {
			$('#div_recibo_impresion').dialog("open");
			$('#div_recibo_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_recibo_impresion').html(html);			
		}
	});
}

function venta_reporte_xls(){
	$("#hdd_cliente").val($("#hdd_fil_cli_id").val());
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_clientecuenta").eq(0).clone()).html()); 
	$("#for_rep_xls").submit();
}

$(function(){	
	$('#btn_actualizar').button({
		icons: {primary: "ui-icon-arrowrefresh-1-e"},
		text: true
		}).click(function() {
		location.reload();
	});
	
	$('#btn_agregar').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});
	
	$('#btn_imprimir_xls').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
	
	$('#btn_seleccionar_cliente').button({
		icons: {primary: "ui-icon-person"},
		text: true
	});

	//clientecuenta_tabla();
	
	$( "#div_clientecuenta_form" ).dialog({
		title:'Información de Cuenta Cliente',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 550,
		modal: true,
		position:'top',
		buttons: {
			Guardar: function() {
				if(confirm("Confirmar Operación?")){
					$("#for_clicue").submit();
				}
			},
			Cancelar: function() {
				$('#for_clicue').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_cliente_buscar" ).dialog({
		title:'Buscar Cliente',
		autoOpen: false,
		resizable: false,
		height: 500,
		width: 950,
		modal: true,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	cliente_filtro_seleccionar();
	//cliente_buscar();
	
	$( "#div_venta_form" ).dialog({
		title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 550,
		width: 940,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			/*Guardar: function() {
				if($('#hdd_ven_numite').val()>0)
				{
					venta_check();
				}
				else{
				$("#for_ven").submit();
				}
			},
			Cancelar: function() {
				$('#for_ven').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}*/
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$('#div_venta_form').html('venta_form');
		}
	});
	$( "#div_ventanota_form" ).dialog({
		title:'Información de Nota de Venta | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 550,
		width: 940,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			/*Guardar: function() {
				if($('#hdd_ven_numite').val()>0)
				{
					ventanota_check();
				}
				else{
				$("#for_ven").submit();
				}
			},
			Cancelar: function() {
				$('#for_ven').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}*/
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$('#div_venta_form').html('ventanota_form');
		}
	});
	$( "#div_recibo_impresion" ).dialog({
		title:'Desea Imprimir Documento?',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 370,
		modal: true
	});
});

</script>
</head>

<body>
<div class="container">
	<header>
    	<?php echo $oContenido->print_header()?>
	</header>
    <article class="content">
    	<div class="contenido">
            <div class="contenido_des">
            <table align="center" class="tabla_cont">
                  <tr>
                    <td class="caption_cont">CUENTA CLIENTE</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <?php /*?><td width="6%" align="left" valign="middle"><a id="btn_agregar" href="#" onClick="clientecuenta_form('insertar','','')">Agregar</a></td><?php */?>
                      <td width="6%" align="left" valign="middle"><a id="btn_actualizar" href="#">Actualizar</a></td>
                      <td width="6%" align="left" valign="middle">
                      <a class="btn_imprimir_xls" id="btn_imprimir_xls" href="#" onClick="venta_reporte_xls()" title="Imprimir en Excel">Excel</a>
                      <form action="clientecuenta_reporte_xls.php" method="post" target="_blank" id="for_rep_xls">
						<input type="hidden" id="hdd_tabla" name="hdd_tabla" />
            <input type="hidden" id="hdd_cliente" name="hdd_cliente" /> 
						</form> 
                      </td>
                      <td width="15%" align="right" valign="middle"><?php /*?><a id="btn_seleccionar_cliente" href="#" onClick="cliente_buscar()">Buscar Cliente</a><?php */?></td>
                      <td width="207" align="left" valign="middle">&nbsp;</td>
                      <td width="492" align="right"><div id="msj_clientecuenta" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div></td>
                    </tr>
                  </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    </td>
                  </tr>
              </table>
            <div id="div_clientecuenta_filtro_cliente"></div>
			</div>
        	<div id="div_clientecuenta_form">
			</div>
      <div id="div_ventanota_form">
			</div>
            <div id="div_venta_form">
			</div>
      <div id="div_recibo_impresion">
			</div>
        	<div id="div_clientecuenta_tabla" class="contenido_tabla">
      		</div>
            <!--<input type="hidden" id="hdd_cli_sel_id" name="hdd_cli_sel_id" /><!--Id del Cliente Seleccionado
            <div id="div_cliente_buscar"></div> -->           
      	</div>
    </article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>