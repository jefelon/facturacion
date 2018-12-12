<?php require_once ("../../config/Cado.php");
require_once ("cCatalogoimagen.php");
$oCatimagen = new cCatalogoimagen();

if($_POST['action']=="editar")
{
	$dts=$oCatimagen->mostrarUno($_POST['catimg_id']);
	$dt = mysql_fetch_array($dts);
		$catimg_tit =$dt['tb_catalogoimagen_tit'];
		$catimg_des =$dt['tb_catalogoimagen_des'];		
		
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

function catalogoimagen_file_form()
{
    $.ajax({
        type: "POST",
        url: "../catalogoimagen/catalogoimagen_file_form.php",
        async:true,
        dataType: "html",                      
        data: ({           
            catimg_id: $("#hdd_catimg_id").val()            
        }),
        beforeSend: function() {
            $('#msj_catimg').hide();
            $('#div_catalogo_imagenes').dialog("open");
            $('#div_catalogo_imagenes').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_catalogo_imagenes').html(html);        
        }
    });
}

function catalogoimagen_file_eliminar(id)
{   
    $('#msj_catimg').hide();   
    if(confirm("Realmente desea eliminar archivo?")){
        $.ajax({
            type: "POST",
            url: "../catalogoimagen/catalogoimagen_file_reg.php",
            async:true,
            dataType: "html",
            data: ({
                action: "eliminar",
                imgfil_id:  id
            }),
            beforeSend: function() {
                $('#msj_catimg').html("Cargando...");
                $('#msj_catimg').show(100);
            },
            success: function(html){
                $('#msj_catimg').html(html);
            },
            complete: function(){			
				catalogo_imagen_tabla();
			}
        });
    }
}

// Función para el boton "Abrir formulario de imagenes"
function catalogoimagen_file_form_abrir(){
	if($('#txt_catimg_tit').val()!="")
	{
		$("#for_catimg").submit();
		catalogoimagen_file_form();	
	}
	else
	{
		alert('Complete datos.');
		$('#txt_catimg_tit').focus();
	}
}


function catalogo_imagen_tabla()
{	
	$.ajax({
		type: "POST",
		url: "../catalogoimagen/catalogo_imagen_tabla.php",
		async:false,
		dataType: "html",                      
		data: ({
			 catimg_id: $("#hdd_catimg_id").val()		
		}),
		beforeSend: function() {
			//alert($("#hdd_catimg_id").val());
			$('#div_catalogo_imagen_tabla').addClass("ui-state-disabled");
        },
		success: function(html){			
			$('#div_catalogo_imagen_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogo_imagen_tabla').removeClass("ui-state-disabled");
		}
	});     
}

// Catalogo de Productos
// ===========================

function catalogo_catalogoimagen(){	
	$.ajax({
		type: "POST",
		url: "../catalogo/catalogo_catalogoimagen.php",
		async:true,
		dataType: "html",                      
		data: ({
			//action: act,
			//tippre:	$('#cmb_com_tippre').val()
		}),
		beforeSend: function() {
			$('#div_catalogo_catalogoimagen').dialog("open");
			$('#div_catalogo_catalogoimagen').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_catalogoimagen').html(html);				
		}
	});
}

// funcion para registarr catalogo imagen detalle
function catalogoimagendetalle_reg(act,idf){	
	$.ajax({
		type: "POST",
		url: "../catalogoimagen/catalogoimagendetalle_reg.php",
		async:true,
		dataType: "html",                      
		data: ({
			action:	 act,
			cat_id:	 idf,
			catimg_id:  $('#hdd_catimg_id').val()						
		}),
		beforeSend: function() {
				$('#msj_catimg').html("Cargando...");
				$('#msj_catimg').show(100);
		},
		success: function(html){
			$('#msj_catimg').html(html);
		},
		complete: function(){			
			// $('#div_catalogoimagendetalle_tabla').removeClass("ui-state-disabled");
			catalogoimagen_detalle_tabla();
		}
	});
	}


function catalogoimagen_detalle_tabla()
{
	$.ajax({
		type: "POST",
		url: "../catalogoimagen/catalogoimagen_detalle_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			catimg_id:	$('#hdd_catimg_id').val()
		}),
		beforeSend: function() {
			$('#div_catalogoimagen_detalle_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_catalogoimagen_detalle_tabla').html(html);
		},
		complete: function(){			
			$('#div_catalogoimagen_detalle_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function eliminar_catalogoimagendetalle(id)
{   
	$('#msj_catimg').hide();   
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../catalogoimagen/catalogoimagen_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action_det: "eliminar",
				id:	id
			}),
			beforeSend: function() {
				$('#msj_catimg').html("Cargando...");
				$('#msj_catimg').show(100);
			},
			success: function(html){
				$('#msj_catimg').html(html);
			},
			complete: function(){			
				catalogoimagen_detalle_tabla();
			}
		});
	}
}


$(function() {
			
	$('#btn_subir_imagen').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});

	$('#btn_agregar_producto').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});


	<?php if($_POST['action']=="insertar"){	?>

		$('#txt_catimg_tit').focus();

	<?php }?>

	<?php if($_POST['action']=="editar"){?>
		catalogo_imagen_tabla();
		// catalogoimagendetalle_reg();
		catalogoimagen_detalle_tabla();
	<?php }?>

	$('#txt_catimg_tit').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});


	 $( "#div_catalogo_imagenes" ).dialog({
        title:'Subir Archivo - Catalogo imagenes',
        autoOpen: false,
        resizable: false,
        height: 'auto',
        width: 700,
        modal: true,
        position: 'top',
        buttons: {        	
            Terminar: function() {
                //$('#for_pro').each (function(){this.reset();});
                $( this ).dialog( "close" );
            }
        }
    });

	$( "#div_catalogo_catalogoimagen" ).dialog({
		title:'Catálogo de Productos',
		autoOpen: false,
		resizable: true,
		height: 300,
		width: 950,
		modal: true,
		position: "top"/*,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}*/
	});
	
	
	$("#for_catimg").validate({
		submitHandler: function() {
			var datos1=CKEDITOR.instances.txt_catimg_des.getData();
			$("#txt_catimg_des").val(datos1);

			$.ajax({
				type: "POST",
				url: "../catalogoimagen/catalogoimagen_reg.php",
				async:false,
				dataType: "json",
				data: $("#for_catimg").serialize(),
				beforeSend: function() {
					// $("#div_catalogoimagen_form" ).dialog( "close" );
					$('#msj_catimg').html("Guardando...");
					$('#msj_catimg').show(100);
				},
				success: function(data){						
					$('#msj_catimg').html(data.catimg_msj);
					//alert(data.catimg_id);
					$("#hdd_catimg_id").val(data.catimg_id);
					$("#action_catalogoimagen").val("editar");				
				},
				complete: function(){
					//catalogoimagen_file_form_abrir();
					//catalogoimagen_tabla();												
				}			
			});
		},
		rules: {
			txt_catimg_tit: {
				required: true
			}			
		},
		messages: {
			txt_catimg_tit: {
				required: '*'
			}			
		}
	});
});
</script>

<script>
/*CKEDITOR.config.toolbar = [
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	{ name: 'editing', items: ['Scayt' ] },
	{ name: 'links', items: [ 'Link', 'Unlink'] },
	{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule'] },
	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks', '-', 'Source'] },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', '-', 'RemoveFormat' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] }
];*/
CKEDITOR.config.toolbar = [
	{ name: 'basicstyles', items: [ 'Bold', 'Italic', '-', 'RemoveFormat' ] },
	{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
	{ name: 'links', items: [ 'Link', 'Unlink' ] },
	{ name: 'insert', items: [ 'Image','Table', 'HorizontalRule' ] },
	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	{ name: 'document', items: ['Maximize','-','Source' ] }
];

	CKEDITOR.config.height = 200;
	CKEDITOR.config.width = 800;  
	CKEDITOR.replace('txt_catimg_des');

</script>

<form id="for_catimg">

<input name="action_catalogoimagen" id="action_catalogoimagen" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_catimg_id" id="hdd_catimg_id" type="hidden" value="<?php echo $_POST['catimg_id']?>">

<fieldset><legend>Datos Principales</legend>
    <table> 
    	<tr>
	        <td align="right" valign="top">Título:</td>
	        <td>
				<input name="txt_catimg_tit" type="text" id="txt_catimg_tit" value="<?php echo $catimg_tit; ?>" size="50" maxlength="50">
	        </td>
        </tr>
    	<tr>
	        <td align="right" valign="top">Descripción:</td>
	        <td><textarea name="txt_catimg_des" class="jqte-test" cols="130" rows="10" id="txt_catimg_des"><?php echo $catimg_des;?></textarea></td>
        </tr>              
    </table>
</fieldset>


<?php //if($_POST['action']=="insertar"){	?>

<a id="btn_subir_imagen" href="#imagen" onClick="catalogoimagen_file_form_abrir();">Subir Imagen</a>
<div id="div_catalogo_imagenes"></div>

<br>

<?php //}?>

<?php //if($_POST['action']=="editar"){	?>

<div id="div_catalogo_imagen_tabla"></div>
<br>
<br>

<a href="#producto" id="btn_agregar_producto" title="Abrir Catálogo" onClick="catalogo_catalogoimagen();">Seleccionar Producto</a>

<div id="div_catalogo_catalogoimagen"></div>

<div id="div_catalogoimagen_detalle_tabla"></div>

<?php //}?>

</form>