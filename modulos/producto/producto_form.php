<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cProducto.php");
$oProducto = new cProducto();

require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	$est	='Activo';
	unset($_SESSION['atributo_car']);
}

if($_POST['action']=="editar"){
	$dts= $oProducto->mostrarUno($_POST['pro_id']);
	$dt = mysql_fetch_array($dts);
		$nom	=$dt['tb_producto_nom'];
		$des	=$dt['tb_producto_des'];
		$cat_id	=$dt['tb_categoria_id'];
		$mar_id	=$dt['tb_marca_id'];
		$est	=$dt['tb_producto_est'];
        $img    =$dt['tb_producto_imagen'];
	mysql_free_result($dts);
}
?>

    <script type="text/javascript">
        $(function() {
            $("#file").change(function (){
                var prodId = document.getElementById('hdd_pro_id').value;
                var fileInput = document.getElementById('file');
                var fileName = 'img_products/'+prodId+'_'+fileInput.files[0].name;
                $("#hdd_prod_img").val(fileName);
            });
        });
    </script>


<script type="text/javascript">
$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.99'
});
$('.moneda_cambio').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9.999'
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

function cmb_cat_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../categoria/cmb_cat_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id: ids
		}),
		beforeSend: function() {
			$('#cmb_cat_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cat_id').html(html);
		}
	});
}

function cmb_mar_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../marca/cmb_mar_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			mar_id: ids
		}),
		beforeSend: function() {
			$('#cmb_mar_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_mar_id').html(html);
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

function producto_presentacion_vista(){
	$.ajax({
		type: "POST",
		url: "../producto/presentacion_vista.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id:	'<?php echo $_POST['pro_id']?>'
		}),
		beforeSend: function() {
			$('#div_producto_presentacion_vista').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_producto_presentacion_vista').html(html);				
		}
	});
}

//adicionales

function categoria_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "../categoria/categoria_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			cat_id:	idf,
			vista:	'cmb_cat_id'
		}),
		beforeSend: function() {
			$("#btn_cmb_cat_id").click(function(e){
			  x=e.pageX+5;
			  y=e.pageY+15;
			  $('#div_categoria_form').dialog({ position: [x,y] });
			  $('#div_categoria_form').dialog("open");
		    });
			//$('#msj_categoria').hide();
			$('#div_categoria_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_categoria_form').html(html);				
		}
	});
}

function marca_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "../marca/marca_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			mar_id:	idf,
			vista:	'cmb_mar_id'
		}),
		beforeSend: function() {
			$("#btn_cmb_mar_id").click(function(e){
			  x=e.pageX+5;
			  y=e.pageY+15;
			  $('#div_marca_form').dialog({ position: [x,y] });
			  $('#div_marca_form').dialog("open");
		   });
			//$('#msj_marca').hide();
			$('#div_marca_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_marca_form').html(html);				
		}
	});
}

function tag_car_form(act)
{
	if($('#cmb_cat_id').val()>0)
	{
		$.ajax({
			type: "POST",
			url: "../producto/tag_car_form.php",
			async:true,
			dataType: "html",                      
			data: ({
				action: act,
				cat_id:	$('#cmb_cat_id').val()
			}),
			beforeSend: function() {
				$("#btn_tag_car_form").click(function(e){
				  x=e.pageX-270;
				  y=e.pageY+13;
				  $('#div_tag_car_form').dialog({ position: [x,y] });
				  $('#div_tag_car_form').dialog("open");
				});
				//$('#msj_categoria').hide();
				$('#div_tag_car_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
			},
			success: function(html){
				$('#div_tag_car_form').html(html);				
			}
		});
	}
	else
	{
		alert('Seleccione categoría.');
	}
}

function atributo_val_form(act,idf,catid)
{
	$.ajax({
		type: "POST",
		url: "../atributo/atributo_val_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			atr_id:	idf,
			cat_id: $('#cmb_cat_id').val(),
			vista:	'cmb_atr_id'
		}),
		beforeSend: function() {
			//$('#msj_atributo').hide();
			$('#div_atributo_form').dialog("open");
			$('#div_atributo_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_atributo_form').html(html);				
		}
	});
}

function unidad_form(act,idf,vis)
{
	$.ajax({
		type: "POST",
		url: "../unidad/unidad_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			uni_id:	idf,
			vista:	vis
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

/*var datcom;
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
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_pro_nom').focus();
	<?php }?>
	
	$( "#txt_pro_nom" ).autocomplete({
   		minLength: 2,
   		source: "../producto/producto_complete_nom.php"
    });
	
	$( "#txt_pre_nom" ).autocomplete({
   		minLength: 1,
   		source: "../producto/presentacion_complete_nom.php"
    });
	
	$('#txt_pro_nom, #txt_pre_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});
	
	cmb_cat_id(<?php echo $cat_id?>);
	cmb_mar_id(<?php echo $mar_id?>);
	
	<?php if($_POST['action']=="insertar"){?>
	
	cmb_cat_uni_bas();
	
	presentacion_tag_car();
	
	//chk_cat_com();
	//chk_cat_ven();
	<?php }?>
	
	$("#txt_cat_tipcam" ).change(function() {
		var tipcam		=parseFloat($("#txt_cat_tipcam" ).autoNumericGet());
		var precosdol	=parseFloat($("#txt_cat_precosdol" ).autoNumericGet());
		
		if(tipcam>0 & precosdol>0)
		{
			var calculo=tipcam*precosdol;
			//$( "#txt_cat_preven" ).val(calculo.toFixed(2));
			$( "#txt_cat_precos" ).autoNumericSet(calculo.toFixed(2));
			
			var precos	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
			var uti		=parseFloat($("#txt_cat_uti" ).val());
			
			if(uti>=0)
			{
				var utilidad=uti/100;
				var calculo=precos/(1-utilidad);
				//$( "#txt_cat_preven" ).val(calculo.toFixed(2));
				$( "#txt_cat_preven" ).autoNumericSet(calculo.toFixed(1));
			}
		}
	});
	
	$("#txt_cat_precosdol" ).change(function() {
		var tipcam		=parseFloat($("#txt_cat_tipcam" ).autoNumericGet());
		var precosdol	=parseFloat($("#txt_cat_precosdol" ).autoNumericGet());
		
		if(tipcam>0 & precosdol>0)
		{
			var calculo=tipcam*precosdol;
			//$( "#txt_cat_preven" ).val(calculo.toFixed(2));
			$( "#txt_cat_precos" ).autoNumericSet(calculo.toFixed(2));
			
			
			var precos	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
			var uti		=parseFloat($("#txt_cat_uti" ).val());
			
			if(uti>=0)
			{
				var utilidad=uti/100;
				var calculo=precos/(1-utilidad);
				//$( "#txt_cat_preven" ).val(calculo.toFixed(2));
				$( "#txt_cat_preven" ).autoNumericSet(calculo.toFixed(1));
			}
			
		}
	});
	
	$("#txt_cat_precos" ).change(function() {
		var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
		var uti		=parseFloat($("#txt_cat_uti" ).val());
		
		if(uti>=0)
		{
			var utilidad=uti/100;
			var calculo=precom/(1-utilidad);
			//$( "#txt_cat_preven" ).val(calculo.toFixed(2));
			$( "#txt_cat_preven" ).autoNumericSet(calculo.toFixed(1));
		}
	});
	
	$("#txt_cat_uti" ).change(function() {
		var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
		var uti		=parseFloat($("#txt_cat_uti" ).val());
		
		if(precom>=0 && precom!="")
		{
			var utilidad=uti/100;
			var calculo=precom/(1-utilidad);
			//$( "#txt_cat_preven" ).val(calculo.toFixed(2));
			$( "#txt_cat_preven" ).autoNumericSet(calculo.toFixed(1));
		}
	});
	
	$("#txt_cat_preven" ).change(function(){
		var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
		var preven	=parseFloat($("#txt_cat_preven" ).autoNumericGet());
		
		if(precom!="" && preven>0)
		{
			var calculo=(1-precom/preven)*100;
			$( "#txt_cat_uti" ).val(calculo.toFixed(2));
		}
	});
	
	<?php if($_POST['action']=="editar"){?>
	producto_presentacion_vista();
	<?php }?>
	
	//adicionales
	
	
	$( "#div_categoria_form" ).dialog({
		title:'Información de Categoría',
		autoOpen: false,
		resizable: false,
		height: 200,
		width: 500,
		//modal: true,
		buttons: {
			Guardar: function() {
				$("#for_cat").submit();
			},
			Cancelar: function() {
				$('#for_cat').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#div_marca_form" ).dialog({
		title:'Información de Marca',
		autoOpen: false,
		resizable: false,
		height: 180,
		width: 500,
		//modal: true,
		buttons: {
			Guardar: function() {
				$("#for_mar").submit();
			},
			Cancelar: function() {
				$('#for_mar').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
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
	
	$( "#div_atributo_form" ).dialog({
		title:'Información de Atributo',
		autoOpen: false,
		resizable: false,
		height: 200,
		width: 500,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_atr").submit();
			},
			Cancelar: function() {
				$('#for_atr').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
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
	$("#for_pro").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../producto/producto_reg.php",
                async: true,
                cache: false,
                contentType: false,
                processData: false,
				dataType: "json",
                data: new FormData($('#for_pro')[0]),
				beforeSend: function(){
					$('#div_producto_form').dialog("close");
					$('#msj_producto').html("Guardando...");
					$('#msj_producto').show(100);
                    console.log('succes1');
				},
				success: function(data){
				    console.log('succes');
					$('#msj_producto').html(data.pro_msj);
					if(data.pro_act=='editar_presentacion')
					{
						producto_form('editar',data.pro_id);
					}
				},
				complete: function(){
					<?php
					if($_POST['vista']=="producto_tabla")
					{
						echo $_POST['vista'].'()';
					}
					
					if($_POST['vista']=="catalogo_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});			
		},
		rules: {
			txt_pro_nom: {
				required: true,
				minlength: 1,
				maxlength: 50
			},
			txt_pro_des: {
				maxlength: 250
			},
			cmb_cat_id: {
				required: true
			},
			cmb_mar_id: {
				required: true
			},
			cmb_pro_est: {
				required: true
			}
			<?php if($_POST['action']=="insertar"){?>
			,
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
			},
			cmb_cat_uni_bas: {
				required: true
			}/*,
			txt_cat_precos: {
				required: true
			},
			txt_cat_preven: {
				required: true
			}*/
			<?php }?>
		},
		messages: {
			txt_pro_nom: {
				required: '*'
			},
			cmb_cat_id: {
				required: '*'
			},
			cmb_mar_id: {
				required: '*'
			},
			cmb_pro_est: {
				required: '*'
			}
			<?php if($_POST['action']=="insertar"){?>
			,
			txt_pre_nom: {
				required: '*'
			},
			cmb_pre_est: {
				required: '*'
			},
			cmb_cat_uni_bas: {
				required: '*'
			}/*,
			txt_cat_precos: {
				required: '*'
			},
			txt_cat_preven: {
				required: '*'
			}*/
			<?php }?>

		}
	});
	
});
</script>
<style>
	div#cuadro-contain { width: 330px; margin: 0 0; }
	div#cuadro-contain table { margin: 0.3em 0; border-collapse: collapse; width: 100%; }
	div#cuadro-contain table td, div#cuadro-contain table th { border: 1px solid #eee; padding: 3px 5px; }
</style>
<form id="for_pro">
<input name="action_producto" id="action_producto" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_pro_id" id="hdd_pro_id" type="hidden" value="<?php echo $_POST['pro_id']?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="num_alm" id="num_alm" type="hidden" value="<?php echo $num_rows?>">
<div style="float:left">
  <fieldset>
    <legend>Producto</legend>
    <table>
        <tr>
          <td><label for="txt_pro_nom">Nombre:</label></td>
        </tr>
        <tr>
            <td><textarea name="txt_pro_nom" cols="40" rows="2" id="txt_pro_nom"><?php echo $nom?></textarea>
          </td>
        </tr>
        <tr>
          <td><label for="txt_pro_des">Descripción:</label></td>
        </tr>
        <tr>
          <td><textarea name="txt_pro_des" cols="40" rows="4" id="txt_pro_des"><?php echo $des?></textarea></td>
        </tr>
        <tr>
          <td><label for="cmb_cat_id">Categoría:</label></td>
        </tr>
        <tr>
          <td>
          <a id="btn_cmb_cat_id" class="btn_ir" href="#" onClick="categoria_form('insertar')">Agregar Categoría</a><select name="cmb_cat_id" id="cmb_cat_id">
          </select>
            
          </td>
        </tr>
        <tr>
          <td><label for="cmb_mar_id">Marca:</label>
          <div id="div_marca_form">
			</div>
          </td>
        </tr>
        <tr>
          <td>
            <a id="btn_cmb_mar_id" class="btn_ir" href="#" onClick="marca_form('insertar')">Agregar Marca</a><select name="cmb_mar_id" id="cmb_mar_id">
          </select>
          <div id="div_categoria_form">
			</div>
          </td>
        </tr>
        <tr>
          <td><label for="cmb_pro_est">Estado:</label></td>
        </tr>
        <tr>
          <td><select name="cmb_pro_est" id="cmb_pro_est">
          		<option value="">-</option>
              	<option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
                <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option>
          </select></td>
        </tr>
        <tr>
            <td><label for="ctxt_prod_img">Imagen:</label></td>
        </tr>
        <tr>
            <td><input id="file" name="file" size="12" type="file" /></td>
        </tr>
        <tr>
            <td><input name="prod_img" id="prod_img" type="image" src="<?php echo $img?>" width="80px" height="auto" alt="Imagen"></td>
            <input name="hdd_prod_img" id="hdd_prod_img" type="hidden" value="">
        </tr>
    </table>
    <div id="div_atributo_form">
	</div>
</fieldset>
<div id="msj_producto_check" class="ui-state-error ui-corner-all" style="width:auto; float:left; padding:4px; display:none"></div>
</div>
<?php if($_POST['action']=="insertar"){?>
<div style="float:left; margin-left:15px">
  <fieldset><legend>Presentación de producto</legend>
    <table>                
        <tr>
          <td align="right" valign="top"><label for="txt_pre_nom">Nombre:</label></td>
          <td colspan="5"><input name="txt_pre_nom" type="text" id="txt_pre_nom" value="<?php echo $nom?>" size="55" maxlength="50"></td>
        </tr>
        <tr>
          <td><label for="txt_pre_cod">Código:</label></td>
          <td><input type="text" name="txt_pre_cod" id="txt_pre_cod"></td>
          <td align="right"><label for="txt_pre_stomin">Stock Mínimo:</label></td>
          <td><input name="txt_pre_stomin" type="text" class="cantidad" id="txt_pre_stomin" style="text-align:right" size="10" maxlength="6" value="<?php echo $stomin?>"></td>
          <td align="right"><label for="cmb_pre_est">Estado:</label></td>
          <td><select name="cmb_pre_est" id="cmb_pre_est">
            <option value="">-</option>
            <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
            <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option>
          </select></td>
        </tr>        
    </table>
  </fieldset>
  
  <?php /*?><fieldset><legend>Atributos</legend>
  <!--<a id="btn_tag_car_form" class="btn_ir" href="#" onClick="tag_car_form()">Agregar Atributo</a>-->
  	<div id="div_tag_car_form">
	</div>
    <div id="div_presentacion_tag_car">
	</div>
  </fieldset><?php */?>
  
  <fieldset><legend>Unidad Base, Precios y Catálogo</legend>
    <table>
        <tr>
          <td align="right"><label for="cmb_cat_uni_bas">Unidad de Medida Base:</label></td>
          <td><a id="btn_cmb_cat_uni_bas" class="btn_ir" href="#" onClick="unidad_form('insertar','','cmb_cat_uni_bas')">Agregar Unidad</a><select name="cmb_cat_uni_bas" id="cmb_cat_uni_bas">
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
          <th align="center" nowrap="nowrap">Cambio US$</th>
          <th align="center" nowrap="nowrap">Precio Costo US$</th>
        </tr>
        <tr>
          <td align="center"><input name="txt_cat_tipcam" type="text" id="txt_cat_tipcam" class="moneda_cambio" style="text-align:right" size="10" maxlength="9" value="<?php echo $tipcam?>"></td>
          <td align="center"><input name="txt_cat_precosdol" type="text" id="txt_cat_precosdol" class="moneda" style="text-align:right" size="10" maxlength="9" value="<?php echo $precosdol?>"></td>
        </tr>        
    </table>
    </div>
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
          <td align="center"><input name="txt_cat_precos" type="text" id="txt_cat_precos" class="moneda" style="text-align:right" size="10" maxlength="9" value="<?php echo $precom?>"></td>
          <!--<td align="center"><input name="chk_cat_igvcom" id="chk_cat_igvcom" type="checkbox" value="1" <?php //if($igvcom=="1") echo 'checked'?>></td>-->
          <td align="center"><input name="txt_cat_uti" type="text" id="txt_cat_uti" class="porcentaje" style="text-align:right" size="8" maxlength="5" value="<?php echo $uti?>"></td>
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
  <label for="editar_presentacion">Guardar y Seguir Editando</label>
  <input name="editar_presentacion" id="editar_presentacion" type="checkbox" value="1">
</div>
<?php }?>
</form>
<?php if($_POST['action']=="editar"){?>
<div id="div_producto_presentacion_vista" style="float:left; margin-left:5px; width:300px">
</div>
<?php }?>