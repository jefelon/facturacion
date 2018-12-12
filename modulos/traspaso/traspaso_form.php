<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTraspaso.php");
$oTraspaso = new cTraspaso();
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();

require_once("../formatos/formato.php");

if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
	$doc_id=2;
	
	/*$dts= $oTraspaso->mostrar_codigo();
	$dt = mysql_fetch_array($dts);
		$cod=$dt['numero']+1;
		$cod=str_pad($cod,4, "0", STR_PAD_LEFT);
	mysql_free_result($dts);*/
	//TALONARIO
	/*$dts= $oTalonariointerno->correlativo($_SESSION['empresa_id'],$doc_id);
	$num_rows= mysql_num_rows($dts);
	if($num_rows>0)
	{
			$dt = mysql_fetch_array($dts);
		$tal_id=$dt['tb_talonario_id'];
		$tal_ser=$dt['tb_talonario_ser'];
		$tal_fin=$dt['tb_talonario_fin'];
		$tal_num=$dt['tb_talonario_num'];
			mysql_free_result($dts);
	
		$numero=$tal_num+1;
		$largo=strlen($tal_fin);
		
		$numero=str_pad($numero,$largo, "0", STR_PAD_LEFT);
		
		$cod=$tal_ser.'-'.$numero;
		$display='none';
	}
	else
	{
		$msj='Debe actualizar talonario.';
		$display='block';
	}*/
}

if($_POST['action']=="editar"){
	$dts= $oTraspaso->mostrarUno($_POST['tra_id']);
	$dt = mysql_fetch_array($dts);
		$fec		=mostrarFecha($dt['tb_traspaso_fec']);
		$doc_id		=$dt['tb_documento_id'];
		$cod		=$dt['tb_traspaso_cod'];
		$alm_id_ori	=$dt['tb_almacen_id_ori'];
		$alm_id_des	=$dt['tb_almacen_id_des'];
		$ref=$dt['tb_traspaso_ref'];

	mysql_free_result($dts);
	$display='none';
}
?>
<script type="text/javascript">
$('.btn_imp').button({
	icons: {primary: "ui-icon-print"},
	text: false
});

$('.btn_ir').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$( "#txt_tra_fec" ).datepicker({
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
function cmb_tra_doc()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'5',
			doc_id: '<?php echo $doc_id?>',
			vista:	'<?php echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_tra_doc').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_tra_doc').html(html);
		},
		complete: function(){
			<?php if($_POST['action']=="insertar"){?>
			//txt_ven_numdoc();
			<?php }?>		
		}
	});
}

function cmb_tra_alm_ori()
{	
	$.ajax({
		type: "POST",
		url: "../almacen/cmb_alm_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			alm_id: '<?php echo $alm_id_ori?>'
		}),
		beforeSend: function() {
			$('#cmb_tra_alm_ori').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_tra_alm_ori').html(html);
		}
	});
}
function cmb_tra_alm_des()
{	
	$.ajax({
		type: "POST",
		url: "../almacen/cmb_alm_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			alm_id: '<?php echo $alm_id_des?>',
			alm_ori: $('#cmb_tra_alm_ori').val()
		}),
		beforeSend: function() {
			$('#cmb_tra_alm_des').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_tra_alm_des').html(html);
		}
	});
}

function traspaso_car(act,idf)
{
	if(act=='agregar')
	{
		var stouni=$('#hdd_cat_stouni_'+idf).val();
		var cantidad=$('#txt_cat_can_'+idf).val();
		
		var dif=$('#hdd_cat_stouni_'+idf).val()-$('#txt_cat_can_'+idf).val();
	}
	
	if(act=='agregar' & (dif < 0))
	{
		alert('Stock insuficiente. Diferencia en '+(cantidad-stouni)+'.');
		$('#txt_cat_can_'+idf).val(stouni);
	}
	else
	{
		$.ajax({
			type: "POST",
			url: "../traspaso/traspaso_car.php",
			async:true,
			dataType: "html",                      
			data: ({
				action:	 act,
				cat_id:	 idf,
				cat_can: $('#txt_cat_can_'+idf).val(),
				alm_ori: $('#cmb_tra_alm_ori').val()		
			}),
			beforeSend: function() {
				$('#div_traspaso_car_tabla').addClass("ui-state-disabled");
			},
			success: function(html){
				$('#div_traspaso_car_tabla').html(html);
			},
			complete: function(){			
				$('#div_traspaso_car_tabla').removeClass("ui-state-disabled");
			}
		});
	}
}

var vista_alm_cat=0;
function catalogo_traspaso(){
	if($('#cmb_tra_alm_ori').val()!='')
	{
		vista_alm_cat=1;
		$.ajax({
			type: "POST",
			url: "../catalogo/catalogo_traspaso.php",
			async:true,
			dataType: "html",                      
			data: ({
				//action: act,
				//tra_id:	idf
			}),
			beforeSend: function() {
				$('#msj_traspaso').hide();
				$('#div_catalogo_traspaso').dialog("open");
				$('#div_catalogo_traspaso').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
			},
			success: function(html){
				$('#div_catalogo_traspaso').html(html);				
			}
		});
	}
	else
	{
		alert('Por favor seleccione Almacén de Origen para mostrar catálogo.');
		$('#div_catalogo_traspaso').dialog("close");
	}
}

function editar_datos_item(idf, nom){	
	$.ajax({
		type: "POST",
		url: "../traspaso/traspaso_car_item.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id:	idf,
			action: "editar",
			pro_nom: nom,
			alm_id: $('#cmb_tra_alm_ori').val(),
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

function traspaso_detalle_tabla()
{
	$.ajax({
		type: "POST",
		url: "traspaso_detalle_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			tra_id:	'<?php echo $_POST['tra_id']?>'
		}),
		beforeSend: function() {
			$('#div_traspaso_detalle_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_traspaso_detalle_tabla').html(html);
		},
		complete: function(){			
			$('#div_traspaso_detalle_tabla').removeClass("ui-state-disabled");
		}
	});     
}

function txt_tra_cod(){	
	$.ajax({
		type: "POST",
		url: "../traspaso/traspaso_txt_cod.php",
		async:true,
		dataType: "json",                      
		data: ({
			alm_id: $('#cmb_tra_alm_ori').val(),
			doc_id: '2'
		}),
		beforeSend: function() {
			$('#txt_tra_cod').val('Cargando...');			
        },
		success: function(data){	
			$('#txt_tra_cod').val(data.numero);
			if(data.msj!="")
			{
				$('#msj_talonario').html(data.msj);
				$('#msj_talonario').show(100);
			}
			else
			{
				$('#msj_talonario').hide();
			}
		}
	});
}

$(function() {
	cmb_tra_doc();
	
	$("#txt_tra_cod").addClass("ui-state-active");
	cmb_tra_alm_ori();
	
	<?php
	if($_POST['action']=="insertar"){
	?>
	traspaso_car('restablecer');
	traspaso_car();
	$('#cmb_tra_alm_ori').change( function() {
		cmb_tra_alm_des();
		txt_tra_cod();
		if(vista_alm_cat==1)
		{
			traspaso_car('restablecer');
			catalogo_traspaso();
		}
	});
	
	<?php
	}
	if($_POST['action']=="editar"){
	?>
	cmb_tra_alm_des();
	$('#cmb_tra_alm_ori').attr('disabled', 'disabled');
	$('#cmb_tra_alm_des').attr('disabled', 'disabled');
	traspaso_detalle_tabla();
	
	<?php }?>
	
	$( "#div_catalogo_traspaso" ).dialog({
		title:'Catálogo de Transferencia',
		autoOpen: false,
		resizable: false,
		height: 300,
		width: 940,
		modal: false,
		position: "bottom"/*,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}*/
	});
	
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
	
//formulario			
	$("#for_tra").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../traspaso/traspaso_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_tra").serialize(),
				beforeSend: function(){
					$('#div_traspaso_form').dialog("close");
					$('#div_btn_agregar').hide(100);
					$('#msj_traspaso').html("Guardando...");
					$('#msj_traspaso').show(100);
				},
				success: function(data){
					if(data.redireccionar){
					 	alert("Traspaso No Registrado.\n Por Favor Inicie Sesión Nuevamente.");
					 	window.location.href = "../usuarios/cerrar_sesion.php";
					 	return;
					}

					$('#msj_traspaso').html(data.tra_msj);
					if(data.tra_act=='imprime')
					{
						traspaso_impresion(data.tra_id);
					}
				},
				complete: function(){
					$('#div_btn_agregar').show(100);
					traspaso_tabla();
				}
			});			
		},
		rules: {
			txt_tra_fec: {
				required: true,
				dateITA: true
			},
			cmb_tra_doc: {
				required: true
			},
			cmb_tra_alm_ori: {
				required: true
			},
			txt_tra_cod: {
				required: true
			},
			cmb_tra_alm_des: {
				required: true
			},
			hdd_tra_numite: {
				required: true
			},
		},
		messages: {
			txt_tra_fec: {
				required: '*'
			},
			cmb_tra_doc: {
				required: '*'
			},
			cmb_tra_alm_ori: {
				required: '*'
			},
			cmb_tra_alm_des: {
				required: '*'
			},
			txt_tra_cod: {
				required: '*'
			},
			hdd_tra_numite: {
				required: 'Agregue producto a detalle.'
			}
		}
	});
	
});
</script>
<div>
<form id="for_tra">
<input name="action_traspaso" id="action_traspaso" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tra_id" id="hdd_tra_id" type="hidden" value="<?php echo $_POST['tra_id']?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_SESSION['puntoventa_id']?>">
<input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $_SESSION['empresa_id']?>">
<fieldset>
  <legend>Datos Principales</legend>
<label for="txt_tra_fec">Fecha:</label>
        <input name="txt_tra_fec" type="text" class="fecha" id="txt_tra_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly>
        <label for="cmb_tra_doc">Documento:</label>
        <select name="cmb_tra_doc" id="cmb_tra_doc" <?php if($_POST['action']=='editar')echo 'disabled'?>>
        </select>
          <!--<label for="cmb_tra_est">Estado:</label>
          <select name="cmb_tra_est" id="cmb_tra_est">
            <option value="">-</option>
            <option value="EMITIDA" <?php //if($est=='CREDITO')echo 'selected'?>>EMITIDA</option>
            <option value="CANCELADA" <?php //if($est=='CANCELADA')echo 'selected'?>>CANCELADA</option>
          </select>-->
      <label for="cmb_tra_alm_ori">Origen:</label>
      <select name="cmb_tra_alm_ori" id="cmb_tra_alm_ori">
          </select>
          <label for="cmb_tra_alm_des">Destino:</label>
      <select name="cmb_tra_alm_des" id="cmb_tra_alm_des">
          </select>
      <label for="txt_tra_cod">Código:</label>
          <input name="txt_tra_cod" type="text" id="txt_tra_cod" size="12" maxlength="11" readonly value="<?php echo $cod?>" style="text-align:right; font-size:10pt">
          </br>
                    <label for="txt_tra_ref">Referencia:</label>
          <input name="txt_tra_ref" type="text" id="txt_tra_ref" value="<?php echo $ref?>" size="50" maxlength="100">
          <?php if($_POST['action']=="insertar"){?>
      <label for="chk_imprimir">Imprimir Documento</label>
        <input name="chk_imprimir" type="checkbox" id="chk_imprimir" value="1">
        <?php }?>
        <?php
      if($_POST['action']=="editar"){
	  ?>
      <a class="btn_imp" title="Imprimir (Shift+P)" href="#" onClick="traspaso_impresion('<?php echo $_POST['tra_id']?>')">Imprimir</a>
      <?php }?>
      <div id="msj_talonario" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php echo 'none'//$display?>"><?php //echo $msj?></div>
</fieldset>

<?php
if($_POST['action']=="insertar"){
?>
<div id="div_traspaso_car_tabla">
</div>
<div id="div_item_form">
</div>
<?php }?>
</form>
</div>
<?php
if($_POST['action']=="insertar"){
?>
<div id="div_catalogo_traspaso">
</div>
<?php
}
if($_POST['action']=="editar"){
?>
<br>
<div id="div_traspaso_detalle_tabla">
</div>
<?php }?>