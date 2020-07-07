<?php
require_once ("../../config/Cado.php");
require_once ("cProducto.php");
$oProducto = new cProducto();
require_once ("cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once ("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../formatos/formato.php");

	$dts= $oProducto->mostrarUno($_POST['pro_id']);
	$dt = mysql_fetch_array($dts);
		$pro_nom	=$dt['tb_producto_nom'];
		$pro_des	=$dt['tb_producto_des'];
		$cat_nom	=$dt['tb_categoria_nom'];
		$mar_nom	=$dt['tb_marca_nom'];
		$pro_est	=$dt['tb_producto_est'];
	mysql_free_result($dts);

	$dts= $oPresentacion->mostrarUno($_POST['pre_id']);
	$dt = mysql_fetch_array($dts);
		$pre_fecmod	=$dt['tb_presentacion_mod'];
		$pre_nom	=$dt['tb_presentacion_nom'];
		$pre_stomin	=$dt['tb_presentacion_stomin'];
		$pre_est	=$dt['tb_presentacion_est'];
	mysql_free_result($dts);

if($_POST['action']=="insertar"){
	$est='Activo';
}

if($_POST['action']=="editar"){
	$dts= $oCatalogoproducto->mostrarUno($_POST['cat_id']);
	$dt = mysql_fetch_array($dts);
	
		$fecmod		=mostrarFechaHora($dt['tb_catalogo_mod']);
		$cat_id_bas	=$dt['tb_unidad_id_bas'];
		$cat_id_equ	=$dt['tb_unidad_id_equ'];
		
		$mul		=$dt['tb_catalogo_mul'];
		
		$tipcam		=$dt['tb_catalogo_tipcam'];
		if($tipcam=='0.000')$tipcam="";
		
		$precosdol	=$dt['tb_catalogo_precosdol'];
		if($precosdol=='0.00')$precosdol="";
		
		$preunicom	=$dt['tb_catalogo_preunicom'];
		if($preunicom=='0.00')$preunicom="";
		
		$precos	=$dt['tb_catalogo_precos'];
		if($precos=='0.00')$precos="";
		
		$uti		=$dt['tb_catalogo_uti'];
		
		$preven		=$dt['tb_catalogo_preven'];
		if($preven=='0.00')$preven="";
		
		$vercom		=$dt['tb_catalogo_vercom'];
		$verven		=$dt['tb_catalogo_verven'];
		
		$igvcom		=$dt['tb_catalogo_igvcom'];
		$igvven		=$dt['tb_catalogo_igvven'];
		
		$unibas		=$dt['tb_catalogo_unibas'];
		
		$est		=$dt['tb_catalogo_est'];

		$valven = $dt['tb_catalogo_preven']/1.18;

	mysql_free_result($dts);

	$dts5 = $oProducto->mostrar_por_proveedor($_POST['pro_id']);
	$num_rows = mysql_num_rows($dts5);
	if($num_rows>0){
		$dt5 = mysql_fetch_array($dts5);
		$descprov=$dt5['tb_productoproveedor_desc'];
	}
	else{
		$descprov=0;
	}

}
?>

<script type="text/javascript">

$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.9999'
});
$('.moneda_cambio').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9.9999'
});
$('.porcentaje').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '999.99'
});
$('.cantidad').autoNumeric({
	aSep: ',',
	aDec: '.',
	vMin: '0.00',
	vMax: '999.00'
});

$('.btn_ir').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

function cmb_cat_uni_id_bas(ids)
{	
	$.ajax({
		type: "POST",
		url: "../unidad/cmb_cat_uni_bas.php",
		async:true,
		dataType: "html",                      
		data: ({
			uni_id_tip: '1',
			uni_id: ids
		}),
		beforeSend: function() {
			$('#cmb_cat_uni_id_bas').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cat_uni_id_bas').html(html);
		}
	});
}

function cmb_cat_uni_alt(ids)
{	
	$.ajax({
		type: "POST",
		url: "../unidad/cmb_cat_uni_alt.php",
		async:true,
		dataType: "html",                      
		data: ({
			uni_id_bas: '<?php if($_POST['action']=="insertar")echo $_POST['uni_id_bas']?>',
			uni_id:		ids
		}),
		beforeSend: function() {
			$('#cmb_cat_uni_alt').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cat_uni_alt').html(html);
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
			
			$("#btn_cmb_cat_uni_alt").click(function(e){
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
function chk_cat_com()
{  
	if($('#chk_cat_vercom').is(':checked')) {  
		$('#txt_cat_precos').removeAttr('disabled');
		$("#txt_cat_precos").removeClass("ui-state-disabled");

		$('#chk_cat_igvcom').removeAttr('disabled');
	}
	else
	{  
		$('#txt_cat_precos').attr('disabled', 'disabled');
		$("#txt_cat_precos").addClass("ui-state-disabled");

		$('#chk_cat_igvcom').attr('disabled', 'disabled');
	}
}

function chk_cat_ven()
{   
	if($('#chk_cat_verven').is(':checked')) {  
		datven=true;
		$('#txt_cat_preven').removeAttr('disabled');
		$("#txt_cat_preven").removeClass("ui-state-disabled");
		
		$('#chk_cat_igvven').removeAttr('disabled');  
	} else {  
		$('#txt_cat_preven').attr('disabled', 'disabled');
		$("#txt_cat_preven").addClass("ui-state-disabled");
		
		$('#chk_cat_igvven').attr('disabled', 'disabled');
	}
}
*/

$(function() {			
	
	cmb_cat_uni_id_bas(<?php echo $_POST['uni_id_bas']?>);
	cmb_cat_uni_alt(<?php echo $cat_id_equ?>);
	
	<?php //if($_POST['action']=='insertar'){?>
	//chk_cat_com();
	//chk_cat_ven();
	<?php //}?>
	
	$("#txt_cat_tipcam" ).keyup(function() {
		var tipcam		=parseFloat($("#txt_cat_tipcam" ).autoNumericGet());
		var precosdol	=parseFloat($("#txt_cat_precosdol" ).autoNumericGet());
		
		if(tipcam>0 & precosdol>0)
		{
			var calculo=tipcam*precosdol;
			$( "#txt_cat_precos" ).autoNumericSet(calculo.toFixed(2));
			
			var precos	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
			var uti		=parseFloat($("#txt_cat_uti" ).val());
			
			if(uti>=0)
			{
				var utilidad=uti/100;
				var calculo=precos/(1-utilidad);
				$( "#txt_cat_preven" ).autoNumericSet(calculo.toFixed(2));
			}
		}
	});
	
	$("#txt_cat_precosdol" ).keyup(function() {
		var tipcam		=parseFloat($("#txt_cat_tipcam" ).autoNumericGet());
		var precosdol	=parseFloat($("#txt_cat_precosdol" ).autoNumericGet());
		
		if(tipcam>0 & precosdol>0)
		{
			var calculo=tipcam*precosdol;
			$( "#txt_cat_precos" ).autoNumericSet(calculo.toFixed(2));
			
			
			var precos	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
			var uti		=parseFloat($("#txt_cat_uti" ).val());
			
			if(uti>=0)
			{
				var utilidad=uti/100;
				var calculo=precos/(1-utilidad);
				$( "#txt_cat_preven" ).autoNumericSet(calculo.toFixed(2));
			}
			
		}
	});

    $("#txt_cat_precos" ).keyup(function() {
        var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
        var uti		=parseFloat($("#txt_cat_uti" ).val());

        if(uti>=0)
        {
            var calculo=precom+(precom*uti/100);
            $( "#txt_cat_valven" ).autoNumericSet(calculo.toFixed(2));
            $( "#txt_cat_preven" ).autoNumericSet((calculo*1.18).toFixed(4));
        }
    });
    $("#txt_cat_descprov" ).keyup(function() {
        var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
        var desc =parseFloat($("#txt_cat_descprov" ).val());
        var uti		=parseFloat($("#txt_cat_uti" ).val());

        if(precom>=0 && precom!="")
        {
            var descuento=desc/100;
            var utilidad=uti/100;
            var costoneto=precom-(precom*descuento)
            var calculo=costoneto+(costoneto*utilidad);
            $( "#txt_cat_valven" ).autoNumericSet(calculo.toFixed(2));
            $( "#txt_cat_preven" ).autoNumericSet((calculo*1.18).toFixed(4));
        }
    });
    $("#txt_cat_uti" ).keyup(function() {
        var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
        var desc =parseFloat($("#txt_cat_descprov" ).val());
        var uti		=parseFloat($("#txt_cat_uti" ).val());

        if(precom>=0 && precom!="")
        {
            var descuento=desc/100;
            var utilidad=uti/100;
            var costoneto=precom-(precom*descuento)
            var calculo=costoneto+(costoneto*utilidad);
            $( "#txt_cat_valven" ).autoNumericSet(calculo.toFixed(2));
            $( "#txt_cat_preven" ).autoNumericSet((calculo*1.18).toFixed(4));
        }
    });

    $("#txt_cat_valven" ).keyup(function(){
        var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
        var preven		=parseFloat($("#txt_cat_preven" ).val());
        var prevalven	=parseFloat($("#txt_cat_valven" ).autoNumericGet());
        var desc =parseFloat($("#txt_cat_descprov" ).val());

        if(precom-desc>=0 && precom!="" && precom-desc<prevalven)
        {
            var descuento=desc/100;
            var costoneto=precom-(precom*descuento);
            var utilidad = (prevalven/costoneto)-1;

            $( "#txt_cat_uti" ).autoNumericSet((utilidad*100).toFixed(2));
            $( "#txt_cat_preven" ).autoNumericSet((prevalven*1.18).toFixed(4));
        }
    });

    $("#txt_cat_valven" ).blur(function() {
        var precom	=parseFloat($("#txt_cat_precos" ).autoNumericGet());
        var preven		=parseFloat($("#txt_cat_preven" ).val());
        var prevalven	=parseFloat($("#txt_cat_valven" ).autoNumericGet());
        var desc =parseFloat($("#txt_cat_descprov" ).val());
        if (precom != "" && preven != "" && desc != "" && preven != "") {
            if (prevalven < (precom - desc) ) {
                $("#txt_cat_valven").val('');
                $("#txt_cat_valven").focus();
            }
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
	$("#for_cat").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../producto/catalogo_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_cat").serialize(),
				beforeSend: function() {	
					$("#div_catalogo_form" ).dialog( "close" );
					$('#msj_presentacion_unidad').html("Guardando...");
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
		},
		rules: {
			cmb_cat_uni_alt: {
				required: true
			},								
			txt_cat_mul: {
				required: false
			},
			cmb_cat_est: {
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
		},
		messages: {
			cmb_cat_uni_alt: {
				required: '*'
			},
			txt_cat_mul: {
				required: '*'
			},
			cmb_cat_est: {
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
		}
	});						
});
</script>
<style>
	div#cuadro_cat_form { width: 100%; margin: 0 0;}
	div#cuadro_cat_form table { border-collapse: collapse; }
	div#cuadro_cat_form table td, div#cuadro_cat_form table th { border: 1px solid #eee; padding: 3px 5px; }
</style>
<div style="font-weight:bold; padding:5px;"><?php echo $pro_nom.' - '.$pre_nom?></div>
<form id="for_cat">
<input name="action_catalogo" id="action_catalogo" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_cat_id" id="hdd_cat_id" type="hidden" value="<?php echo $_POST['cat_id']?>">
<input name="hdd_cat_pre_id" id="hdd_cat_pre_id" type="hidden" value="<?php echo $_POST['pre_id']?>">
<input name="hdd_cat_uni_bas" id="hdd_cat_uni_bas" type="hidden" value="<?php echo $_POST['uni_id_bas']?>">
<input name="hdd_cat_unibas" id="hdd_cat_unibas" type="hidden" value="<?php echo $unibas?>">
  <fieldset><legend>Información de Unidad</legend>
    <table>
        <tr>
          <td><label for="cmb_cat_uni_alt">
          <?php if($_POST['action']=="insertar" or $unibas==0){?>
          Unidad de Medida Alternativa = Multiplo X <?php }?>Unidad de Medida Base</label></td>
        </tr>
        <tr>
          <td>
          <?php if($_POST['action']=="insertar" or $unibas==0){?>
          <a id="btn_cmb_cat_uni_alt" class="btn_ir" href="#" onClick="unidad_form('insertar','','cmb_cat_uni_alt')">Agregar Unidad</a>
          <select name="cmb_cat_uni_alt" id="cmb_cat_uni_alt" <?php if($_POST['action']=="editar" and $unibas==1)echo 'disabled'?>>
          </select>
            =
            <input name="txt_cat_mul" type="text" class="cantidad" id="txt_cat_mul" style="text-align:right" value="<?php echo $mul?>" size="10" maxlength="6" <?php if($_POST['action']=="editar" and $unibas==1)echo 'disabled'?>>
            X<?php }?>
            <select name="cmb_cat_uni_id_bas" id="cmb_cat_uni_id_bas" <?php if(($_POST['action']=="editar" and $unibas==0) or $_POST['action']=="insertar" ) echo 'disabled'?>>
          </select><?php if($_POST['action']=="editar" and $unibas==1){?><a id="btn_cmb_cat_uni_bas" class="btn_ir" href="#" onClick="unidad_form('insertar','','cmb_cat_uni_id_bas')">Agregar Unidad</a><?php }?>
          <div id="div_unidad_form">
			</div>
          </td>
        </tr>
        <tr>
          <td><label for="cmb_cat_est">Estado:</label>            
          <select name="cmb_cat_est" id="cmb_cat_est">
            <option value="">-</option>
            <option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
            <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option>
          </select></td>
        </tr>        
    </table>
  </fieldset>
  <fieldset><legend>Información de Precio y Catálogo</legend>
    <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div id="cuadro_cat_form" class="ui-widget">
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
    </div></td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">
    <div id="cuadro_cat_form" class="ui-widget">
    <table class="ui-widget ui-widget-content">
        <tr class="ui-widget-header">
            <th align="center">Precio Costo</th>
            <th align="center">Desc. Prov</th>
            <!--<th align="center">IGV</th>-->
            <th align="center">Utilidad (%)</th>
            <th align="center">Valor Venta</th>
            <th align="center">Precio Venta</th>
        </tr>
        <tr>
          <td align="center"><input name="txt_cat_precos" type="text" id="txt_cat_precos" class="moneda" style="text-align:right" size="10" maxlength="9" value="<?php echo $precos?>"></td>
            <td align="center"><input name="txt_cat_descprov" type="text" id="txt_cat_descprov" class="moneda" style="text-align:right" size="10" maxlength="9" value="<?php echo formato_decimal(abs($descprov),2)?>"></td>
          <!--<td align="center"><input name="chk_cat_igvcom" id="chk_cat_igvcom" type="checkbox" value="1" <?php //if($igvcom=="1") echo 'checked'?>></td>-->
          <td align="center"><input name="txt_cat_uti" type="text" id="txt_cat_uti" class="porcentaje" style="text-align:right" size="8" maxlength="6" value="<?php echo $uti; ?>"></td>
            <td align="center"><input name="txt_cat_valven" type="text" id="txt_cat_valven" class="moneda" style="text-align:right" size="10" maxlength="10" value="<?php echo formato_decimal($valven, 2)?>"></td>
          <td align="center"><input name="txt_cat_preven" type="text" id="txt_cat_preven" class="moneda" style="text-align:right" size="10" maxlength="10" value="<?php echo $preven?>"></td>
          <!--<td align="center"><input type="checkbox" name="chk_cat_igvven" id="chk_cat_igvven" value="1" <?php //if($igvven=="1") echo 'checked'?>></td>-->
        </tr>        
    </table>
    </div>
    </td>
    <td valign="top">
    <div id="cuadro_cat_form" class="ui-widget" style="margin-left:30px">
    <table class="ui-widget ui-widget-content">
        <tr class="ui-widget-header">
          <th title="Mostrar en Catálogo">Catálogo</th>
          </tr>
        <tr>
          <td nowrap="nowrap"><input name="chk_cat_vercom" id="chk_cat_vercom" type="checkbox" value="1" <?php if($_POST['action']=="insertar" or $vercom=="1") echo 'checked'?>> <label for="chk_cat_vercom">Compras</label>          </td>
          </tr>
        <tr>
          <td><input type="checkbox" name="chk_cat_verven" id="chk_cat_verven" value="1" <?php if($_POST['action']=="insertar" or $verven=="1") echo 'checked'?>> <label for="chk_cat_verven">Ventas</label>          </td>
          </tr>        
    </table>
    </div>
    </td>
  </tr>
</table>
  </fieldset>
</form>
<div style="margin-right:5px; text-align:right">
<?php 
if($_POST['action']=="editar"){
	echo 'Modificación: '.$fecmod;
}
?>
</div>