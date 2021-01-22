<?php
	session_start();
	if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
	require_once ("../../config/Cado.php");
	
	require_once ("../contenido/contenido.php");
	$oContenido = new cContenido();

require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

$pvs1=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv1 = mysql_fetch_array($pvs1);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Manifiesto de Pasajeros</title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery-ui-1.8.16.custom.js"></script>
<script src="../../js/jquery-ui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.position.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.dialog.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.tabs.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.autocomplete.js"></script>

<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/i18n/jquery.ui.datepicker-es.js"></script>
<script src="../../js/timepicker/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<script src="../../js/jquery-ui/development-bundle/external/jquery.metadata.js"></script>
<script src="../../js/Moneda/autoNumeric.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script src="../../js/ckeditor/ckeditor-standar/jquery.min.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/ckeditor.js"></script>
<script src="../../js/ckeditor/ckeditor-standar/adapters/jquery.js"></script>
<script> var $j = jQuery.noConflict(true); </script>

<script type="text/javascript">
function venta_filtro()
{
	$.ajax({
		type: "POST",
		url: "../venta/venta_manifiestoarmar_filtro_enc.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//venta: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_venta_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_filtro').html(html);
		},
		complete: function(){
			venta_tabla();
		}
	});
}
function venta_filtro_armado()
{
    $.ajax({
        type: "POST",
        url: "../venta/venta_manifiestoarmado_filtro_enc.php",
        async:true,
        dataType: "html",
        //data: ({
        //venta: $('#txt_fil_pro').val()
        //}),
        beforeSend: function() {
            $('#div_venta_filtro2').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_venta_filtro2').html(html);
        },
        complete: function(){
            venta_tabla_manifiesto_armado();
        }
    });

}

function venta_tabla()
{
	$.ajax({
		type: "POST",
		url: $('#hdd_modo').val(),
		async:true,
		dataType: "html",
		data: $("#for_fil_ven").serialize(),
		beforeSend: function() {
			$('#div_venta_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_venta_tabla').html(html);
		},
		complete: function(){			
			$('#div_venta_tabla').removeClass("ui-state-disabled");
		}
	});     
}
function venta_tabla_manifiesto_armado()
{
    $.ajax({
        type: "POST",
        url: $('#hdd_modo2').val(),
        async:true,
        dataType: "html",
        data: $("#for_fil_ven2").serialize(),
        beforeSend: function() {
            $('#div_venta_tabla2').addClass("ui-state-disabled");
        },
        success: function(html){
            $('#div_venta_tabla2').html(html);
        },
        complete: function(){
            $('#div_venta_tabla2').removeClass("ui-state-disabled");
        }
    });
}

function venta_impresion_man(idf){
    $.ajax({
        type: "POST",
        url: "../venta/venta_preimpresion_man.php",
        async:true,
        dataType: "html",
        data: ({
            ven_id:	idf

        }),
        beforeSend: function() {
            $('#div_venta_impresion').dialog("open");
            $('#div_venta_impresion').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_venta_impresion').html(html);
        }
    });
}
function pasar_encomieda(idf){
    if($("#cmb_fech_sal").val()==null)
    {
        alert('Cree un horario de salida y seleccione destino y la fecha.');
    }
    if($("#cmb_horario").val()=="")
    {
        alert('Seleccione la hora de salida.');
    }

    else{
        $.ajax({
            type: "POST",
            url: "../venta/venta_reg.php",
            async:true,
            dataType: "html",
            data: ({
                ven_id:	idf,
                action_venta:'pasar_encomienda',
                hdd_vi_ho:$("#hdd_vi_ho").val(),
                hdd_punven_id:<?php echo $_SESSION['puntoventa_id']?>,
                hdd_emp_id: <?php echo $_SESSION['empresa_id']?>
            }),
            beforeSend: function() {

            },
            success: function(html){
                venta_tabla_manifiesto_armado();
                venta_tabla();
                previaDatos(idf);
            }
        });
    }
}
function retornar_encomieda(idf){
    if($("#cmb_fech_sal").val()==null)
    {
        alert('Cree un horario de salida y seleccione destino y la fecha.');
    }
    if($("#cmb_horario").val()=="")
    {
        alert('Seleccione la hora de salida.');
    }

    else{
        $.ajax({
            type: "POST",
            url: "../venta/venta_reg.php",
            async:true,
            dataType: "html",
            data: ({
                ven_id:	idf,
                action_venta:'retornar_encomienda',
                hdd_vi_ho:0, //con 0 se quita el id del horario y vuelve al estado anterior
                hdd_punven_id:<?php echo $_SESSION['puntoventa_id']?>,
                hdd_emp_id: <?php echo $_SESSION['empresa_id']?>
            }),
            beforeSend: function() {

            },
            success: function(html){
                venta_tabla_manifiesto_armado();
                venta_tabla();
                previaDatos2(idf);
            }
        });
    }
}



function venta_reporte(url)
{	
	$("#for_fil_ven").attr("action", url);
	$("#for_fil_ven").submit();
}

function venta_reporte_xls(){
	$("#hdd_tabla").val( $("<div>").append( $("#tabla_venta").eq(0).clone()).html()); 
	$("#for_rep_xls").submit();
}
function modo(url){
	$('#hdd_modo').val(url);
	venta_tabla();
};
function cmb_conductor()
{
    $.ajax({
        type: "POST",
        url: "../conductor/cmb_con_id.php",
        async:true,
        dataType: "html",
        beforeSend: function() {
            $('#cmb_conductor_id').html('<option value="">Cargando...</option>');
        },
        success: function(html){
            $('#cmb_conductor_id').html(html);
        },
        complete: function(){

        }
    });
}

function cmb_lugar_llegada()
{
    $.ajax({
        type: "POST",
        url: "../lugar/cmb_lug_id.php",
        async:true,
        dataType: "html",
        beforeSend: function() {
            $('#cmb_destino_id').html('<option value="">Cargando...</option>');
        },
        success: function(html){
            $('#cmb_destino_id').html(html);
            $("#cmb_destino_id").find("option[value='<?php echo $pv1['tb_lugar_id']?>']").remove();
        },
        complete: function(){

        }
    });
}
function cmb_horario_vehiculo()
{
    $.ajax({
        type: "POST",
        url: "../lugar/cmb_veh_id.php",
        async:false,
        dataType: "json",
        data: ({
            salida_id: $('#cmb_salida_id').val(),
            llegada_id: $('#cmb_llegada_id').val(),
            horario: $('#cmb_horario').val(),
            fecha: $('#cmb_fech_sal').val()
        }),
        beforeSend: function() {
            $('#txt_placa_vehiculo').val('<option value="">Cargando...</option>');
        },
        success: function(data){
            $('#txt_placa_vehiculo').val(data.vehiculo_placa);
            $('#txt_modelo_vehiculo').val(data.vehiculo_marca);
            $('#txt_asientos_vehiculo').val(data.vehiculo_numasi);
            $('#hdd_vehiculo').val(data.vehiculo_id);
            $('#hdd_vi_ho').val(data.viajehorario_id);
            $('#hdd_vh_id').val(data.viajehorario_id);

        },
        complete: function(){

        }
    });
}
function cmb_fecha()
{
    $.ajax({
        type: "POST",
        url: "../lugar/cmb_fecha.php",
        async:true,
        dataType: "html",
        data: ({
            salida_id: $('#cmb_salida_id').val(),
            llegada_id: $('#cmb_llegada_id').val()
        }),
        beforeSend: function() {
            $('#cmb_fech_sal').html('<option value="">Cargando...</option>');
        },
        success: function(html){
            $('#cmb_fech_sal').html(html);
        },
        complete: function(){

        }
    });
}
function venta_horario_form(act,idf){
    $.ajax({
        type: "POST",
        url: "../venta/venta_horario_form.php",
        // url: "../venta/croquis.php",
        async:true,
        dataType: "html",
        data: ({
            action: act
        }),
        beforeSend: function() {
            $('#msj_venta').hide();
            $('#div_venta_horario_form').dialog("open");
            $('#div_venta_horario_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_venta_horario_form').html(html);
        }
    });
}
function venta_vh_vehiculo_form(act,idf){
    $.ajax({
        type: "POST",
        url: "../venta/venta_vh_vehiculo_form.php",
        // url: "../venta/croquis.php",
        async:true,
        dataType: "html",
        data: ({
            action: act,
            veh_id: $('#hdd_vehiculo').val(),
            vh_id: $('#hdd_vi_ho').val()
        }),
        beforeSend: function() {
            $('#msj_venta').hide();
            $('#div_venta_horario_form').dialog("open");
            $('#div_venta_horario_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_venta_horario_form').html(html);
        }
    });
}
function cmb_fecha_horario()
{
    $.ajax({
        type: "POST",
        url: "../lugar/cmb_hor_id.php",
        async:true,
        dataType: "html",
        data: ({
            salida_id: $('#cmb_salida_id').val(),
            llegada_id: $('#cmb_llegada_id').val(),
            fecha: $('#cmb_fech_sal').val()
        }),
        beforeSend: function() {
            $('#cmb_horario').html('<option value="">Cargando...</option>');
        },
        success: function(html){
            $('#cmb_horario').html(html);
        },
        complete: function(){

        }
    });
}

function previaDatos(id_venta){
    $.ajax({
        type: "POST",
        url: "../venta/venta_reg.php",
        async:true,
        dataType: "json",
        data: ({
            action: "obtener_datos",
            ven_id:id_venta
        }),
        beforeSend: function() {
            //$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(data){
            if($('#hdd_vehiculo').val()>0){
                enviarEncSistemaNuevo(data.header,data.detalle);
            }
        }
    });
}
function enviarEncSistemaNuevo(header,detalle){

    console.log(detalle);
    $.ajax({
        type: "POST",
        url: "http://165.227.52.2/api/encomiendas/store",
        async:true,
        dataType: "json",
        data: ({
            fecha_salida:header.fecha_salida,
            serie:header.serie,
            numero:header.numero,
            destinatario:header.destinatario,
            origen:header.origen,
            destino:header.destino,
            vehiculo:header.vehiculo,
            clave:header.clave,
            observacion:header.observacion,
            detalle:detalle
        }),
        beforeSend: function() {
            //$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(data){
            console.log(data);
        }
    });
}
function previaDatos2(id_venta){
    $.ajax({
        type: "POST",
        url: "../venta/venta_reg.php",
        async:true,
        dataType: "json",
        data: ({
            action: "obtener_datos",
            ven_id:id_venta
        }),
        beforeSend: function() {
            //$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(data){
            if($('#hdd_vehiculo').val()>0){
                retornarEncSistemaNuevo(data.header,data.detalle);
            }
        }
    });
}
function retornarEncSistemaNuevo(header,detalle){

    console.log(header,detalle);
    $.ajax({
        type: "POST",
        url: "http://165.227.52.2/api/encomiendas/delete",
        async:true,
        dataType: "json",
        data: ({
            fecha_salida:header.fecha_salida,
            serie:header.serie,
            numero:header.numero,
            destinatario:header.destinatario,
            origen:header.origen,
            destino:header.destino,
            vehiculo:header.vehiculo,
            clave:header.clave,
            observacion:header.observacion,
            detalle:detalle
        }),
        beforeSend: function() {
            //$('#div_proveedor_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(data){
            console.log(data);
        }
    });
}

$(function() {
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
	$('.btn_modo').button({
		icons: {primary: "ui-icon-document"},
		text: true
	});
	$('.imprimir_pdf').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});
	
	$('#btn_imprimir_xls').button({
		icons: {primary: "ui-icon-print"},
		text: true
	});

		
	venta_filtro();
    venta_filtro_armado();
    cmb_lugar_llegada();
    cmb_conductor();

	
	$( "#div_venta_form" ).dialog({
		title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?>',
		autoOpen: false,
		resizable: false,
		height: 550,
		width: 980,
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
		}
	});
	
	$( "#div_venta_check" ).dialog({
		title:'Verificando Venta...',
		autoOpen: false,
		resizable: false,
		height: 275,
		width: 500,
		modal: false,
		buttons: {
			OK: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_venta_impresion" ).dialog({
		title:'Desea Imprimir Documento?',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 370,
		modal: true,
		position: 'top'
	});

	$( "#div_venta_correo_form" ).dialog({
		title:'Enviar por Correo',
		autoOpen: false,
		resizable: false,
		//height: 600,
		width: 990,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Enviar: function() {
				//if(confirm("Confirmar envío de correo?"))
				//{
					$("#for_ven_cor").submit();
				//}
			},
			Cancelar: function() {
				$('#for_ven_cor').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});


	$( "#div_venta_email" ).dialog({
		title:'Detalle de Correos',
		autoOpen: false,
		resizable: false,
		height: 600,
		width: 990,
		modal: true,
		position: "top",
		closeOnEscape: true,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}
	});

    $( "#div_venta_horario_form" ).dialog({
        title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?>',
        autoOpen: false,
        resizable: false,
        height: 'auto',
        width: 'auto',
        zIndex: 1,
        modal: true,
        position: "center",
        closeOnEscape: false,
        buttons: {
            Guardar: function() {
                $("#for_hor").submit();
            },
            Cancelar: function() {
                $('#for_hor').each (function(){this.reset();});
                $( this ).dialog( "close" );
            }
        }
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
                    <td class="caption_cont">Arma el manifiesto de encomiendas</td>
                  </tr>
              </table>
			</div>

            <div id="caja1" style="width: 49%;float: left">
                <div id="div_venta_filtro" class="contenido_tabla">
                </div>
                <div id="div_venta_tabla" class="contenido_tabla">
                </div>
            </div>

            <div id="caja2" style="width: 49%;float: right">
                <div id="div_venta_filtro2" class="contenido_tabla">
                </div>
                <div id="div_venta_tabla2" class="contenido_tabla">
                </div>

            </div>
      	</div>
    </article>
    <div id="div_venta_horario_form">

    </div>
</div>

<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>