<?php
require_once ("../../config/Cado.php");
require_once ("../producto/cProducto.php");
$oProducto = new cProducto();

require_once("../formatos/formatos.php");

$dts= $oProducto->mostrarUno($_POST['pro_id']);
$dt = mysql_fetch_array($dts);
		$pro_nom	=$dt['tb_producto_nom'];
		$pro_des	=$dt['tb_producto_des'];
		$cat_id		=$dt['tb_categoria_id'];
		$cat_nom	=$dt['tb_categoria_nom'];
		$mar_nom	=$dt['tb_marca_nom'];
		$pro_est	=$dt['tb_producto_est'];
mysql_free_result($dts);

if($_POST['vista']=='Presentacion')
{
	$ancho_acordion="auto";
}
else
{
	$ancho_acordion='620px';
}

?>

<script type="text/javascript">
function presentacion_tabla(){			
	$.ajax({
		type: "POST",
		url: "../producto/presentacion_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id:	<?php echo $_POST['pro_id']?>
		}),
		beforeSend: function() {
			$('#div_presentacion_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_presentacion_tabla').html(html);
		},
		complete: function(){			
			$('#div_presentacion_tabla').removeClass("ui-state-disabled");
		}
	});     
}
	
function presentacion_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../producto/presentacion_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			pre_id: idf,
			pro_id: <?php echo $_POST['pro_id']?>
		}),
		beforeSend: function() {
			$('#msj_presentacion').hide();
			$('#div_presentacion_form').dialog("open");
			$('#div_presentacion_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_presentacion_form').html(html);
		}
	});
}

function eliminar_presentacion(id)
{    
	$('#msj_presentacion').hide();  
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../producto/presentacion_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			beforeSend: function() {
				$('#msj_presentacion').html("Cargando...");
				$('#msj_presentacion').show(100);
			},
			success: function(html){
				$('#msj_presentacion').html(html);
			},
			complete: function(){			
				presentacion_tabla();
				presentacion_unidad();
				presentacion_stock();
				presentacion_tag();
				presentacion_catalogo();
			}
		});
	}
}

function catalogo_form(act,idf,preid,unibas){
	$.ajax({
		type: "POST",
		url: "../producto/catalogo_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			cat_id: idf,
			pre_id: preid,
			uni_id_bas: unibas,
			pro_id: <?php echo $_POST['pro_id']?>
		}),
		beforeSend: function() {
			$('#msj_presentacion_unidad').hide();
			$('#div_catalogo_form').dialog("open");
			$('#div_catalogo_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_catalogo_form').html(html);				
		}
	});
}

function eliminar_catalogo(id)
{  
	$('#msj_presentacion_unidad').hide();  
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../producto/catalogo_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				cat_id:		id
			}),
			beforeSend: function() {
				$('#msj_presentacion_unidad').html("Cargando...");
				$('#msj_presentacion_unidad').show(100);
			},
			success: function(html){
				$('#msj_presentacion_unidad').html(html);
			},
			complete: function(){			
				presentacion_unidad();
				presentacion_catalogo();
			}
		});
	}
}

function stock_form(act,preid,almid,stoid){
	$.ajax({
		type: "POST",
		url: "../producto/stock_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			pre_id: preid,
			alm_id: almid,
			sto_id: stoid,
			pro_id: <?php echo $_POST['pro_id']?>
		}),
		beforeSend: function() {
			$('#msj_presentacion_stock').hide();
			$('#div_stock_form').dialog("open");
			$('#div_stock_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_stock_form').html(html);				
		}
	});
}
function lote_form(act,preid,almid,stoid, msj){
    $.ajax({
        type: "POST",
        url: "../producto/lote_form.php",
        async:true,
        dataType: "html",
        data: ({
            action: act,
            pre_id: preid,
            alm_id: almid,
            sto_id: stoid,
            pro_id: <?php echo $_POST['pro_id']?>,
            msj_lote: msj
        }),
        beforeSend: function() {
            $('#msj_presentacion_lote').hide();
            $('#div_lote_form').dialog("open");
            $('#div_lote_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_lote_form').html(html);
        }
    });
}

function presentacion_tag(){			
	$.ajax({
		type: "POST",
		url: "../producto/presentacion_tag.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id:	<?php echo $cat_id?>,
			pro_id:	<?php echo $_POST['pro_id']?>
		}),
		beforeSend: function() {
			$('#div_presentacion_tag').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_presentacion_tag').html(html);
		},
		complete: function(){			
			$('#div_presentacion_tag').removeClass("ui-state-disabled");
		}
	});     
}

function tag_form(act,preid)
{
	$('#msj_presentacion_tag').hide();
	if($('#cmb_cat_id').val()>0)
	{
		$.ajax({
			type: "POST",
			url: "../producto/tag_form.php",
			async:true,
			dataType: "html",                      
			data: ({
				action: act,
				cat_id:	$('#cmb_cat_id').val(),
				pre_id: preid
			}),
			beforeSend: function() {
				//$("#btn_tag_form").click(function(e){
				  //x=e.pageX+20;
				  //y=e.pageY+10;
				  //$('#div_tag_form').dialog({ position: [x,y] });
				  $('#div_tag_form').dialog("open");
				//});
				//$('#msj_categoria').hide();
				$('#div_tag_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
			},
			success: function(html){
				$('#div_tag_form').html(html);				
			}
		});
	}
	else
	{
		alert('Seleccione categoría.');
	}
}

function eliminar_tag(id)
{  
	$('#msj_presentacion_tag').hide();  
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../producto/tag_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				tag_id:		id
			}),
			beforeSend: function() {
				$('#msj_presentacion_tag').html("Cargando...");
				$('#msj_presentacion_tag').show(100);
			},
			success: function(html){
				$('#msj_presentacion_tag').html(html);
			},
			complete: function(){			
				presentacion_tag();
			}
		});
	}
}

function cmb_precio_id(ids)
{
    $.ajax({
        type: "POST",
        url: "../listaprecio/cmb_precio_id.php",
        async:true,
        dataType: "html",
        data: ({
            precio_id: ids
        }),
        beforeSend: function() {
            $('#cmb_precio_id').html('<option value="">Cargando...</option>');
        },
        success: function(html){
            $('#cmb_precio_id').html(html);
        }
    });

}

function guardar_lista_precio() {
    $.ajax({
        type: "POST",
        url: "../listaprecio/lista_precio_reg.php",
        async: true,
        dataType: "html",
        data: ({
            action: "insertar",
            prod_id: $('#hdd_pro_id').val(),
            precos_alt: $('#txt_cat_precos_alt').val(),
            precio_id: $('#cmb_precio_id').val(),
            preven_alt: $('#txt_cat_preven_alt').val(),
            cat_uti_alt: $('#txt_cat_uti_alt').val()
        }),
        beforeSend: function () {
            $('#msj_lista_precio').html("Cargando...");
            $('#msj_lista_precio').show(100);
        },
        success: function (html) {
            $('#msj_lista_precio').html(html);
        },
        complete: function () {

        }
    });
}

function presentacion_unidad(){			
	$.ajax({
		type: "POST",
		url: "../producto/presentacion_unidad.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id:	<?php echo $_POST['pro_id']?>
		}),
		beforeSend: function() {
			$('#div_presentacion_unidad').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_presentacion_unidad').html(html);
		},
		complete: function(){			
			$('#div_presentacion_unidad').removeClass("ui-state-disabled");
		}
	});     
}


function producto_proveedor_tabla(){
    $.ajax({
        type: "POST",
        url: "../producto/producto_proveedor_tabla.php",
        async:true,
        dataType: "html",
        data: ({
            pro_id:	<?php echo $_POST['pro_id']?>
        }),
        beforeSend: function() {
            $('#div_proveedores_form').addClass("ui-state-disabled");
        },
        success: function(html){
            $('#div_proveedores_form').html(html);
        },
        complete: function(){
            $('#div_proveedores_form').removeClass("ui-state-disabled");
        }
    });
}

function presentacion_stock(){			
	$.ajax({
		type: "POST",
		url: "../producto/presentacion_stock.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id:	<?php echo $_POST['pro_id']?>
		}),
		beforeSend: function() {
			$('#div_presentacion_stock').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_presentacion_stock').html(html);
		},
		complete: function(){			
			$('#div_presentacion_stock').removeClass("ui-state-disabled");
		}
	});     
}

function presentacion_catalogo(){			
	$.ajax({
		type: "POST",
		url: "../producto/presentacion_catalogo.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id:	<?php echo $_POST['pro_id']?>
		}),
		beforeSend: function() {
			$('#div_presentacion_catalogo').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_presentacion_catalogo').html(html);
		},
		complete: function(){			
			$('#div_presentacion_catalogo').removeClass("ui-state-disabled");
		}
	});     
}

function lista_precio_detalle(){
    $.ajax({
        type: "POST",
        url: "../listaprecio/lista_precio_detalle.php",
        async:true,
        dataType: "json",
        data: ({
            prod_id:	<?php echo $_POST['pro_id']?>,
            precio_id:  $("#cmb_precio_id").val()
        }),
        beforeSend: function() {
            $('#div_precios_lista').addClass("ui-state-disabled");
        },
        success: function(data){
            $('#txt_cat_precos_alt').val(data.precos);
            $('#txt_cat_preven_alt').val(data.preven);
            $('#txt_cat_uti_alt').val(data.uti);
        },
        complete: function(){
            $('#div_precios_lista').removeClass("ui-state-disabled");
        }
    });
}
		
$(function() {
	
	/*$( "#accordion" ).accordion({
		autoHeight: false,
		navigation: true,
		collapsible: true
	});*/

	presentacion_tabla();
	//presentacion_tag();
	presentacion_unidad();
	presentacion_stock();
	presentacion_catalogo();
    producto_proveedor_tabla();
    cmb_precio_id();
	
	$( "#div_presentacion_form" ).dialog({
		title:'Información de Presentación de Producto',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 640,
		position: 'top',
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_pre").submit();
			},
			Cancelar: function() {
				$('#for_pre').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$("#div_presentacion_form").html('Cargando...');
		}
	});
	
	$( "#div_tag_form" ).dialog({
		title:'Agregar Atributo',
		autoOpen: false,
		resizable: false,
		height: 150,
		width: 265,
		modal: true,
		buttons: {
			Agregar: function() {
				$("#for_atragr").submit();
			},
			Cerrar: function() {
				$('#for_atragr').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$("#div_tag_form").html('Cargando...');
		}
	});
	
	$( "#div_catalogo_form" ).dialog({
		title:'Información de Unidad - Precios - Catálogo',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 600,
		position: 'top',
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_cat").submit();
			},
			Cancelar: function() {
				$('#for_cat').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$("#div_catalogo_form").html('Cargando...');
		}
	});
	
	$( "#div_stock_form" ).dialog({
		title:'Información de Stock',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 350,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_sto").submit();
			},
			Cancelar: function() {
				$('#for_sto').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$("#div_stock_form").html('Cargando...');
		}
	});
    $( "#div_lote_form" ).dialog({
        title:'Información de Lotes',
        autoOpen: false,
        resizable: false,
        height: 'auto',
        width: 650,
        modal: true,
        buttons: {
            Guardar: function() {
                $("#for_lot").submit();
            },
            Cancelar: function() {
                $('#for_lot').each (function(){this.reset();});
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            $("#div_lote_form").html('Cargando...');
        }
    });

    $( "#div_agregar_lote_form" ).dialog({
        title:'Lote',
        autoOpen: false,
        resizable: false,
        height: 'auto',
        width: 550,
        modal: true,
        buttons: {
            Guardar: function() {
                $("#for_agregar_lote").submit();
            },
            Cancelar: function() {
                $('#for_agregar_lote').each (function(){this.reset();});
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            $("#div_agregar_lote_form").html('Cargando...');
        }
    });

    $('#cmb_precio_id').change( function() {
        lista_precio_detalle();
    });

});

$('.btn_guardar_lista_precio').button({
    icons: {primary: "ui-icon-disk"},
    text: false
});

$('.moneda').autoNumeric({
    aSep: ',',
    aDec: '.',
    //aSign: 'S/. ',
    //pSign: 's',
    vMin: '0.00',
    vMax: '9999.99'
});

$('.porcentaje').autoNumeric({
    aSep: ',',
    aDec: '.',
    //aSign: 'S/. ',
    //pSign: 's',
    vMin: '0.00',
    vMax: '99.99'
});


</script>
<?php 
if($_POST['vista']=='Presentacion'){
?>
<style>
	div#tabla_pre { margin: 0 0; }
	div#tabla_pre table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#tabla_pre table td, div#tabla_pre table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#tabla_pre table th { height:18px }
	div#tabla_pre table td { height:17px }
</style>
<div id="tabla_pre" class="ui-widget">
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
<thead>
    <tr class="ui-widget-header">
      <th>PRODUCTO</th>
      <th>MARCA</th>
      <th>CATEGORIA</th>                    
    </tr>
</thead>
<tbody>
  <tr>
    <td><span style="font-weight: bold; font-size: 12px;"><?php echo $pro_nom?></span></td>
    <td><span style="font-weight:bold"><?php echo $mar_nom?></span></td>
    <td><span style="font-weight:bold"><?php echo $cat_nom?></span></td>
  </tr>
</tbody>
</table>
<br>
</div>
<?php }?>
<div id="accordion" style="width:<?php echo $ancho_acordion?>;">
	<h3><a href="#">Presentación</a></h3>
	<div>
    	<div id="msj_presentacion" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none">
        </div>
        <div id="div_presentacion_form">
        </div>
        <div id="div_presentacion_tabla">
        </div>
    </div>
    
    <?php /*?>
    <h3><a href="#">Atributos</a></h3>
	<div>
    	<div id="msj_presentacion_tag" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none">
        </div>
        <div id="div_tag_form">
        </div>
        <div id="div_presentacion_tag">
        </div>
    </div><?php */?>
    <br>
    <h3><a href="#">Unidad - Precios - Catálogo</a></h3>
    <div>
        <div id="msj_presentacion_unidad" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none">
        </div>
        <div id="div_catalogo_form">
        </div>
        <div id="div_presentacion_unidad">
        </div>
    </div>

    <br>
    <h3><a href="#">Unidad - Precios - Catálogo</a></h3>
    <div id="div_precios_lista">
        <div id="cuadro-contain" class="ui-widget">
            <table class="ui-widget ui-widget-content">
                <tr class="ui-widget-header">
                    <th align="center">Lista Precios:</th>
                    <th align="center">Precio Costo</th>
                    <!--<th align="center">IGV</th>-->
                    <th align="center">Utilidad (%)</th>
                    <th align="center">Precio Venta</th>
                    <!--<th align="center"> IGV</th>-->
                </tr>
                <tr>
                    <td>
                        <select name="cmb_precio_id" id="cmb_precio_id">
                        </select>
                    </td>
                    <td align="center"><input name="txt_cat_precos_alt" type="text" id="txt_cat_precos_alt" class="moneda" style="text-align:right" size="10" maxlength="9" value="<?php echo $precom?>"></td>
                    <!--<td align="center"><input name="chk_cat_igvcom" id="chk_cat_igvcom" type="checkbox" value="1" <?php //if($igvcom=="1") echo 'checked'?>></td>-->
                    <td align="center"><input name="txt_cat_uti_alt" type="text" id="txt_cat_uti_alt" class="porcentaje" style="text-align:right" size="8" maxlength="6" value="<?php echo $uti?>"></td>
                    <td align="center"><input name="txt_cat_preven_alt" type="text" id="txt_cat_preven_alt" class="moneda" style="text-align:right" size="10" maxlength="9" value="<?php echo $preven?>"></td>
                    <!--<td align="center"><input type="checkbox" name="chk_cat_igvven" id="chk_cat_igvven" value="1" <?php //if($igvven=="1") echo 'checked'?>></td>-->
                    <td align="center"><a onclick="guardar_lista_precio()" class="btn_guardar_lista_precio" id=""></a></td>
                    <div id="msj_lista_precio" style="display: none" class="ui-state-highlight ui-corner-all"></div>
                </tr>
            </table>
        </div>
    </div>

	<div style="width: 50%;float: left">
        <h3><a href="#">Stock</a></h3>
    	<div id="msj_presentacion_stock" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none">
        </div>
    	<div id="div_stock_form">
		</div>
		<div id="div_presentacion_stock" style="clear:both">
        </div>

        <div id="msj_presentacion_lote" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none">
        </div>
        <div id="div_lote_form">
        </div>
	</div>
    <h3><a href="#">Proveedores</a></h3>
    <div>
        <div id="msj_presentacion_proveedores" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none">
        </div>
        <div id="div_proveedores_form">
        </div>
    </div>
    <h3><a href="#">Como se muestra en catálogo</a></h3>
	<div>
    	<div id="msj_presentacion_catalogo" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none">
        </div>
		<div id="div_presentacion_catalogo" style="clear:both">
        </div>
	</div>
</div>