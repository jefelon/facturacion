<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cProducto.php");
$oProducto = new cProducto();
require_once ("cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once ("../formatos/formato.php");

	$dts= $oProducto->mostrarUno($_POST['pro_id']);
	$dt = mysql_fetch_array($dts);
		$pro_nom	=$dt['tb_producto_nom'];
		$pro_des	=$dt['tb_producto_des'];
		$cat_nom	=$dt['tb_categoria_nom'];
		$mar_nom	=$dt['tb_marca_nom'];
		$pro_est	=$dt['tb_producto_est'];
	mysql_free_result($dts);

if($_POST['action']=="insertar"){
	$est	='Activo';
	unset($_SESSION['atributo_car']);
}

if($_POST['action']=="editar"){
	$dts= $oPresentacion->mostrarUno($_POST['pre_id']);
	$dt = mysql_fetch_array($dts);
	
		$fecmod	=$dt['tb_presentacion_mod'];
		$nom	=$dt['tb_presentacion_nom'];
		$pre_cod=$dt['tb_presentacion_cod'];
		$stomin	=$dt['tb_presentacion_stomin'];
		$est	=$dt['tb_presentacion_est'];
		$pro_id	=$dt['tb_producto_id'];

	mysql_free_result($dts);
}
?>

<script type="text/javascript">

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
$('.cantidad').autoNumeric({
	aSep: '',
	aDec: '.',
	vMin: '0',
	vMax: '99999'
});

$('.btn_ir').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

function presentacion_tag_car(act,idf){
	$.ajax({
		type: "POST",
		url: "../producto/presentacion_tag_car.php",
		async:true,
		dataType: "html",                      
		data: ({
			action:	act,
			cmb_atr_id: idf
		}),
		beforeSend: function() {
			$('#div_presentacion_tag_car').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_presentacion_tag_car').html(html);				
		}
	});
}

function cmb_cat_uni_bas(ids)
{	
	$.ajax({
		type: "POST",
		url: "../unidad/cmb_cat_uni_bas.php",
		async:true,
		dataType: "html",                      
		data: ({
			uni_id_tip: '1',
			uni_id:	ids
		}),
		beforeSend: function() {
			$('#cmb_cat_uni_bas').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cat_uni_bas').html(html);
		}
	});
}

function unidad_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "../unidad/unidad_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			uni_id:	idf,
			vista:	'cmb_cat_uni_bas'
		}),
		beforeSend: function() {
			//$('#msj_unidad').hide();
			$("#btn_cmb_cat_uni_bas").click(function(e){
			  x=e.pageX+5;
			  y=e.pageY+15;
			  $('#div_unidad_form').dialog({ position: [x,y] });
			  $('#div_unidad_form').dialog("open");
		    });
			$('#div_unidad_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_unidad_form').html(html);				
		}
	});
}
/*
var datcom;
var datven;

function chk_cat_com()
{   
	if($('#chk_cat_vercom').is(':checked')) {  
		$('#txt_cat_precos').removeAttr('disabled');
		$("#txt_cat_precos").removeClass("ui-state-disabled");
		datcom=true;
		
		$('#chk_cat_igvcom').removeAttr('disabled');
	}
	else
	{  
		$('#txt_cat_precos').attr('disabled', 'disabled');
		$("#txt_cat_precos").addClass("ui-state-disabled");
		datcom=false;
		
		$('#chk_cat_igvcom').attr('disabled', 'disabled');
	}
}

function chk_cat_ven()
{   
	if($('#chk_cat_verven').is(':checked')) {  
		$('#txt_cat_preven').removeAttr('disabled');
		$("#txt_cat_preven").removeClass("ui-state-disabled");
		datven=true;
		
		$('#chk_cat_igvven').removeAttr('disabled');  
	} else {  
		$('#txt_cat_preven').attr('disabled', 'disabled');
		$("#txt_cat_preven").addClass("ui-state-disabled");
		datven=false;
		
		$('#chk_cat_igvven').attr('disabled', 'disabled');
	}
}
*/

$(function() {
	
	$( "#txt_pre_nom" ).autocomplete({
   		minLength: 1,
   		source: "../producto/presentacion_complete_nom.php"
    });
	
	$('#txt_pre_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});
	
	<?php if($_POST['action']=="insertar"){?>
	cmb_cat_uni_bas();
	presentacion_tag_car();
	//chk_cat_com();
	//chk_cat_ven();
	<?php }?>

	$("#txt_cat_precos" ).keyup(function() {
		var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
		var uti		=parseFloat($("#txt_cat_uti" ).val());
		
		if(uti>=0)
		{
			var utilidad=uti/100;
			var calculo=precom/(1-utilidad);
			//$( "#txt_cat_preven" ).val(calculo.toFixed(2));
			$( "#txt_cat_preven" ).autoNumericSet(calculo.toFixed(2));
		}
	});
	
	$("#txt_cat_uti" ).keyup(function() {
		var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
		var uti		=parseFloat($("#txt_cat_uti" ).val());
		
		if(precom>=0 && precom!="")
		{
			var utilidad=uti/100;
			var calculo=precom/(1-utilidad);
			//$( "#txt_cat_preven" ).val(calculo.toFixed(2));
			$( "#txt_cat_preven" ).autoNumericSet(calculo.toFixed(2));
		}
	});
	
	$("#txt_cat_preven" ).keyup(function(){
		var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
		var preven	=parseFloat($("#txt_cat_preven" ).autoNumericGet());
		
		if(precom!="" && preven>0)
		{
			var calculo=(1-precom/preven)*100;
			$( "#txt_cat_uti" ).val(calculo.toFixed(2));
		}
	});
	
	$( "#div_tag_car_form" ).dialog({
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
			$("#div_tag_car_form").html('Cargando...');
		}
	});
	
	//adicionales
	$( "#div_unidad_form" ).dialog({
		title:'Información de Unidad',
		autoOpen: false,
		resizable: false,
		height: 200,
		width: 400,
		//modal: true,
		buttons: {
			Guardar: function() {
				$("#for_uni").submit();
			},
			Cancelar: function() {
				$('#for_uni').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});

//formulario
	$("#for_pre").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../producto/presentacion_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_pre").serialize(),
				beforeSend: function() {			
					$("#div_presentacion_form" ).dialog( "close" );
					$('#msj_presentacion').html("Guardando...");
					$('#msj_presentacion').show(100);
				},
				success: function(html){						
					$('#msj_presentacion').html(html);
				},
				complete: function(){
					presentacion_tag();
					presentacion_unidad();
					presentacion_stock();
					presentacion_tabla();
					presentacion_catalogo();
				}
			});			
		},
		rules: {								
			txt_pre_nom: {
				required: true,
				maxlength: 50
			},
			txt_pre_stomin: {
				required: false,
				digits: true
			},
			cmb_pre_est: {
				required: true
			}
			<?php if($_POST['action']=="insertar"){?>
			,
			cmb_cat_uni_bas: {
				required: true
			},
			txt_cat_precos: {
				required: true
			},
			txt_cat_uti: {
				required: true
			},
			txt_cat_preven: {
				required: true
			}
			<?php }?>
		},
		messages: {
			txt_pre_nom: {
				required: '*'
			},
			cmb_pre_est: {
				required: '*'
			}
			<?php if($_POST['action']=="insertar"){?>
			,
			cmb_cat_uni_bas: {
				required: '*'
			},
			txt_cat_precos: {
				required: '*'
			},
			txt_cat_uti: {
				required: '*'
			},
			txt_cat_preven: {
				required: '*'
			}
			<?php }?>
		}
	});						
});
</script>
<style>
	div#cuadro_pre_form { width: 330px; margin: 0 0; }
	div#cuadro_pre_form table { margin: 0.3em 0; border-collapse: collapse; width: 100%; }
	div#cuadro_pre_form table td, div#cuadro_pre_form table th { border: 1px solid #eee; padding: 3px 5px; }
</style>
<div style="font-weight:bold; padding:5px;"><?php echo $pro_nom?></div>
<form id="for_pre">
<input name="action_presentacion" id="action_presentacion" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_pre_id" id="hdd_pre_id" type="hidden" value="<?php echo $_POST['pre_id']?>">
<input name="hdd_pre_pro_id" id="hdd_pre_pro_id" type="hidden" value="<?php echo $_POST['pro_id']?>">
<input name="num_alm" id="num_alm" type="hidden" value="<?php echo $num_rows?>">
  <fieldset>
    <legend>Presentación de producto</legend>
    <table>                
        <tr>
<!--          <td align="right" valign="top"><label for="txt_pre_nom">Nombre:</label></td>-->
          <td colspan="5"><input name="txt_pre_nom" type="text" id="txt_pre_nom" readonly value="<?php echo $nom?>" size="55" maxlength="50"></td>
        </tr>
        <tr>
          <td><label for="txt_pre_cod">Código:</label></td>
          <td><input type="text" name="txt_pre_cod" id="txt_pre_cod" value="<?php echo $pre_cod?>"></td>
<!--          <td align="right"><label for="txt_pre_stomin">Stock Mínimo:</label></td>-->
<!--          <td><input name="txt_pre_stomin" type="text" class="cantidad" id="txt_pre_stomin" style="text-align:right" size="10" maxlength="6" value="--><?php //echo $stomin?><!--"></td>-->
<!--          <td align="right"><label for="cmb_pre_est">Estado:</label></td>-->
          <td style="display: none"><select name="cmb_pre_est" id="cmb_pre_est">
            <option value="">-</option>
            <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
            <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option>
          </select></td>
        </tr>        
    </table>
  </fieldset>
  <?php if($_POST['action']=="insertar"){?>
  <fieldset><legend>Atributos</legend>
  <!--<a id="btn_tag_car_form" class="btn_ir" href="#" onClick="tag_car_form()">Agregar Atributo</a>-->
  	<div id="div_tag_car_form">
	</div>
    <div id="div_presentacion_tag_car">
	</div>
  </fieldset>
  <fieldset>
    <legend>Unidad Base, Precios y Catálogo</legend>
    <table>
        <tr>
          <td align="right"><label for="cmb_cat_uni_bas">Unidad de Medida Base:</label></td>
          <td><a id="btn_cmb_cat_uni_bas" class="btn_ir" href="#" onClick="unidad_form('insertar')">Agregar Unidad</a><select name="cmb_cat_uni_bas" id="cmb_cat_uni_bas">
          </select>
          <div id="div_unidad_form">
			</div>
          </td>
        </tr>        
    </table>
    </br>
    <div id="cuadro-contain" class="ui-widget">
    <table class="ui-widget ui-widget-content">
        <tr class="ui-widget-header">
          <th align="center">Precio Costo</th>
          <!--<th align="center">IGV</th>-->
          <th align="center">Utilidad (%)</th>
          <th align="center">Precio Venta</th>
          <!--<th align="center"> IGV</th>-->
        </tr>
        <tr>
          <td align="center"><input name="txt_cat_precos" type="text" id="txt_cat_precos" class="moneda" style="text-align:right" size="10" maxlength="9" value="<?php echo $precos?>"></td>
          <!--<td align="center"><input name="chk_cat_igvcom" id="chk_cat_igvcom" type="checkbox" value="1" <?php //if($igvcom=="1") echo 'checked'?>></td>-->
          <td align="center"><input name="txt_cat_uti" type="text" id="txt_cat_uti" class="porcentaje" style="text-align:right" size="8" maxlength="6" value="<?php echo $uti?>"></td>
          <td align="center"><input name="txt_cat_preven" type="text" id="txt_cat_preven" class="moneda" style="text-align:right" size="10" maxlength="9" value="<?php echo $preven?>"></td>
          <!--<td align="center"><input type="checkbox" name="chk_cat_igvven" id="chk_cat_igvven" value="1" <?php //if($igvven=="1") echo 'checked'?>></td>-->
        </tr>        
    </table>
    </br>
    <table class="ui-widget ui-widget-content">
        <tr class="ui-widget-header">
          <th title="Mostrar en Catálogo">Catálogo</th>
          </tr>
        <tr>
          <td><input name="chk_cat_vercom" id="chk_cat_vercom" type="checkbox" value="1" <?php if($_POST['action']=="insertar" or $vercom=="1") echo 'checked'?>> <label for="chk_cat_vercom">Compras</label>          </td>
          </tr>
        <tr>
          <td><input type="checkbox" name="chk_cat_verven" id="chk_cat_verven" value="1" <?php if($_POST['action']=="insertar" or $verven=="1") echo 'checked'?>> <label for="chk_cat_verven">Ventas</label>          </td>
          </tr>        
    </table>
</div>
    </fieldset>
    <?php /*
	INFORMACION DE ALMACEN Y STOCK
	?><fieldset>
    <legend>Información de  Stock</legend>
    <div id="cuadro_pre_form" class="ui-widget">
    <table class="ui-widget ui-widget-content">
        <tr class="ui-widget-header">
          <th>Almacén</th>
          <th align="center">Stock</th>
        </tr>
          <?php
		  $dts=$oAlmacen->mostrar_presentacion();
		  $num_rows= mysql_num_rows($dts);
		  if($num_rows>=1){
			  $num=0;
			  while($dt = mysql_fetch_array($dts)){
				  $num++;
		  ?>
        <tr>
          <td>
            <label for="txt_pre_sto_<?php echo $num?>"><?php echo $dt['tb_almacen_nom']?></label>
            <input name="alm_id_<?php echo $num?>" id="alm_id_<?php echo $num?>" type="hidden" value="<?php echo $dt['tb_almacen_id']?>">
          </td>
          <td align="center"><input name="txt_pre_sto_<?php echo $num?>" type="text" class="cantidad" id="txt_pre_sto_<?php echo $num?>" style="text-align:right" size="10" maxlength="6"></td>
        </tr>
          <?php
			  }
			  mysql_free_result($dts);
		  }
          ?>       
    </table>
</div>
  </fieldset><?php */?>
  <?php }?>
</form>