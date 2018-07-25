<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cServicio.php");
$oServicio = new cServicio();
require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	$est='Activo';
}

if($_POST['action']=="editar"){
	$dts= $oServicio->mostrarUno($_POST['ser_id']);
	$dt = mysql_fetch_array($dts);
		$nom	=$dt['tb_servicio_nom'];
		$des	=$dt['tb_servicio_des'];
		$pre	=formato_money($dt['tb_servicio_pre']);
		$cat_id	=$dt['tb_categoria_id'];		
		$est	=$dt['tb_servicio_est'];
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
	vMax: '99999.99'
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

/*function cmb_mar_id(ids)
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
}*/

/*function cmb_cat_uni_bas(ids)
{	
	$.ajax({
		type: "POST",
		url: "dao/cmb_cat_uni_bas.php",
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

function servicio_presentacion_vista(){
	$.ajax({
		type: "POST",
		url: "presentacion_vista.php",
		async:true,
		dataType: "html",                      
		data: ({
			pro_id:	'<?php //echo $_POST['pro_id']?>'
		}),
		beforeSend: function() {
			$('#div_servicio_presentacion_vista').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_servicio_presentacion_vista').html(html);				
		}
	});
}*/

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

/*function marca_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "marca_form.php",
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
			$('#div_marca_form').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_marca_form').html(html);				
		}
	});
}*/

/*function unidad_form(act,idf,vis)
{
	$.ajax({
		type: "POST",
		url: "unidad_form.php",
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
			$('#div_unidad_form').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_unidad_form').html(html);				
		}
	});
}*/

/*var datcom;
var datven;

function chk_cat_com()
{   
	if($('#chk_cat_vercom').is(':checked')) {  
		$('#txt_cat_precom').removeAttr('disabled');
		$("#txt_cat_precom").removeClass("ui-state-disabled");
		datcom=true;
		
		$('#chk_cat_igvcom').removeAttr('disabled');
	}
	else
	{  
		$('#txt_cat_precom').attr('disabled', 'disabled');
		$("#txt_cat_precom").addClass("ui-state-disabled");
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
}*/


$(function() {
	
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_ser_nom').focus();
	<?php }?>
	
	$( "#txt_ser_nom" ).autocomplete({
   		minLength: 2,
   		source: "servicio_complete_nom.php"
    });
	
	$('#txt_ser_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});
    <?php if($_POST['action']=="insertar"){?>
        $("#txt_ser_valor" ).keyup(function() {
            var prevalor	=parseFloat($("#txt_ser_valor" ).autoNumericGet());
            var igv		=prevalor*0.18;
            $( "#txt_ser_igv" ).autoNumericSet(igv.toFixed(2));

            if(prevalor>=0)
            {
                var calculo=prevalor+igv;
                //$( "#txt_cat_preven" ).val(calculo.toFixed(2));
                $( "#txt_ser_pre" ).autoNumericSet(calculo.toFixed(2));
            }
        });
    <?php }?>
    <?php if($_POST['action']=="editar"){?>
        $(document ).ready(function() {
            var ser_pre	=parseFloat($("#txt_ser_pre" ).autoNumericGet());

            if(ser_pre>=0)
            {
                var valor=ser_pre/1.18;
                var igv		=ser_pre-(ser_pre/1.18);
                //$( "#txt_cat_preven" ).val(calculo.toFixed(2));
                $( "#txt_ser_valor" ).autoNumericSet(valor.toFixed(2));
                $( "#txt_ser_igv" ).autoNumericSet(igv.toFixed(2));
            }
        });
    <?php }?>

	/*$( "#txt_pre_nom" ).autocomplete({
   		minLength: 1,
   		source: "dao/presentacion_complete_nom.php"
    });*/
	
	cmb_cat_id(<?php echo $cat_id?>);
	
	
	//adicionales

	$( "#txt_ser_nom" ).autocomplete({
   		minLength: 1,
   		source: "../servicio/servicio_complete_nom.php",
		select: function( event, ui ) {
			$("#txt_ser_nom").val(ui.item.label)
			catalogo_servicio_tabla();
		}
    });
	
	
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
	
	
//formulario			
	$("#for_ser").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../servicio/servicio_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_ser").serialize(),
				beforeSend: function(){
					$('#div_servicio_form').dialog("close");
					$('#msj_servicio').html("Guardando...");
					$('#msj_servicio').show(100);
				},
				success: function(data){
					$('#msj_servicio').html(data.ser_msj);
					$('#txt_fil_ser_nom').val(data.ser_nom);
					catalogo_servicio_tabla();
					if(data.ser_act=='editar_presentacion')
					{
						servicio_form('editar',data.ser_id);
					}
				},
				complete: function(){
					<?php
					if($_POST['vista']=="servicio_tabla")
					{
						echo $_POST['vista'].'()';
					}
					
					?>
				}
			});			
		},
		rules: {
			txt_ser_nom: {
				required: true,
				minlength: 1,
				maxlength: 50
			},
			txt_ser_des: {
				maxlength: 250
			},
			txt_ser_pre: {
				required: true,
			},
			cmb_cat_id: {
				required: true
			},
			cmb_ser_est: {
				required: true
			}
		},
		messages: {
			txt_ser_nom: {
				required: '*'
			},
			cmb_cat_id: {
				required: '*'
			},			
			cmb_ser_est: {
				required: '*'
			},						
			txt_ser_pre: {
				required: '*'
			}
		}
	});	
});
</script>
<style>
	div#cuadro-contain { width: 330px; margin: 0 0; }
	div#cuadro-contain table { margin: 0.3em 0; border-collapse: collapse; width: 100%; }
	div#cuadro-contain table td, div#cuadro-contain table th { border: 1px solid #eee; padding: 3px 5px; }
</style>
<form id="for_ser">
<input name="action_servicio" id="action_servicio" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_ser_id" id="hdd_ser_id" type="hidden" value="<?php echo $_POST['ser_id']?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_ser_aut" id="hdd_ser_aut" type="hidden" value="<?php echo $_POST['aut']?>">
<div style="float:left">
  <!--<fieldset>-->
    <!--<legend>Servicio</legend>-->
    <table>
        <tr>
          <td><label for="txt_ser_nom">Nombre:</label></td>
          <td><input type="text" name="txt_ser_nom" size='41' id="txt_ser_nom" value="<?php echo $nom?>" />
          </td>
        </tr>        
        <tr>
          <td valign="top"><label for="txt_ser_des">Descripción:</label></td>
          <td><textarea name="txt_ser_des" cols="40" id="txt_ser_des"><?php echo $des?></textarea></td>
        </tr>
        <tr>
            <td><label for="txt_ser_valor" title="Valor del servicio">Valor sin IGV.:</label></td>
            <td><input type="text" name="txt_ser_valor" size='10' rows="4" id="txt_ser_valor" value="<?php echo $pre/1.18?>" class="moneda" style="text-align:right" /></td>
        </tr>
        <tr>
            <td><label for="txt_ser_igv" title="IGV">IGV:</label></td>
            <td><input type="text" name="txt_ser_igv" size='10' rows="4" id="txt_ser_igv" value="<?php echo $pre-($pre/1.18)?>" class="moneda" style="text-align:right" /></td>
        </tr>
        <tr>
          <td><label for="txt_ser_pre" title="Precio Referencial">Precio Ref.:</label></td>
          <td><input type="text" name="txt_ser_pre" size='10' rows="4" id="txt_ser_pre" value="<?php echo $pre?>" class="moneda" style="text-align:right" /></td>
        </tr>
        <tr>
          <td><label for="cmb_cat_id">Categoría:</label></td>
          <td>
          <select name="cmb_cat_id" id="cmb_cat_id">
          </select>
          <a id="btn_cmb_cat_id" class="btn_ir" href="#" onClick="categoria_form('insertar')">Agregar Categoría</a>  
          </td>
        </tr>
        
        <tr>
          <td>
           
          <div id="div_categoria_form">
			</div>
          </td>
        </tr>
        <tr>
          <td><label for="cmb_ser_est">Estado:</label></td>
          <td><select name="cmb_ser_est" id="cmb_ser_est">
          		<option value="">-</option>
              	<option value="Activo" <?php if($est=='Activo')echo 'selected'?>>Activo</option>
                <option value="Inactivo" <?php if($est=='Inactivo')echo 'selected'?>>Inactivo</option>
          </select></td>
        </tr>
       
    </table>
<!--</fieldset>-->
</div>

</form>
