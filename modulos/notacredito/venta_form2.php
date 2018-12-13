<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();

require_once("../formatos/formato.php");
require_once("../menu/acceso.php");

if($_POST['action']=="insertar"){
	//$cli_id=1;
	$fec=date('d-m-Y');
	$est='CANCELADA';
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
$('.btn_newwin').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});

$(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$( "#txt_ven_fec" ).datepicker({
	minDate: "-0D", 
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


function cmb_ven_doc()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'9',
			doc_id: '<?php echo $doc_id?>',
			vista:	'<?php echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_ven_doc').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_ven_doc').html(html);
		},
		complete: function(){
			<?php if($_POST['action']=="insertar"){?>
			//txt_ven_numdoc();
			<?php }?>
		}
	});
}

// function txt_ven_numdoc(){	
// 	$.ajax({
// 		type: "POST",
// 		url: "../venta/venta_txt_numdoc.php",
// 		async:false,
// 		dataType: "json",                      
// 		data: ({
// 			doc_id: $('#cmb_ven_doc').val()
// 		}),
// 		beforeSend: function() {
// 			$('#txt_ven_numdoc').val('Cargando...');
			
// 			if($('#cmb_ven_doc').val()*1==2 || $('#cmb_ven_doc').val()*1==11)//factura
// 			{
// 				$('#hdd_val_cli_tip').val('2');
// 			}
// 			if($('#cmb_ven_doc').val()*1==3 || $('#cmb_ven_doc').val()*1==12)//boleta
// 			{
// 				$('#hdd_val_cli_tip').val('1');
// 			}			
//         },
// 		success: function(data){			
// 			$('#txt_ven_numdoc').val(data.numero);
// 			if(data.msj!="")
// 			{
// 				$('#msj_venta_form').html(data.msj);
// 				$('#msj_venta_form').show(100);
// 			}
// 			else
// 			{
// 				$('#msj_venta_form').hide();
// 			}
// 		},
// 		complete: function(){
// 			<?php if($_POST['action']=="insertar"){?>
// 			verificar_numdoc();
// 			<?php }?>
// 		}
// 	});
// }


$(function() {
	cmb_ven_doc();
	
	<?php if($_POST['action']=="insertar"){ ?>
		// $('#cmb_ven_doc').change( function() {
		// 	txt_ven_numdoc();
		// });
	<?php }?>

	$('#txt_ven_ser').change(function(){
		$(this).val($(this).val().toUpperCase());
	});

	//formulario			
	$("#for_ven").validate({
		submitHandler: function(){
			$.ajax({
				type: "POST",
				url: "venta_reg2.php",
				async:true,
				dataType: "json",
				data: $("#for_ven").serialize(),
				beforeSend: function(){
						$('#div_venta_form2').dialog("close");
						$('#msj_venta').html("Guardando...");
						$('#msj_venta').show(100);
				},
				success: function(data){
					$('#msj_venta').html(data.ven_msj);	

					if(data.ven_sun=='enviar')
					{
						enviar_sunat(data.ven_id,data.ven_act);
					}
					else
					{
						if(data.ven_act=='imprime')
						{
							venta_impresion(data.ven_id);
						}
					}
								
				},
				complete: function(){
					venta_tabla();
				}
			});			
		},
		rules: {
			txt_ven_fec: {
				required: true,
				dateITA: true
			},
			cmb_ven_doc: {
				required: true
			},
			cmb_ven_tip: {
				required: true
			},
			txt_ven_ser: {
				required: true
			},
			txt_ven_num: {
				required: true
			}
		},
		messages: {
			txt_ven_fec: {
				required: '*'
			},
			cmb_ven_doc: {
				required: '*'
			},
			cmb_ven_tip: {
				required: '*'
			},
			txt_ven_ser: {
				required: '*'
			},
			txt_ven_num: {
				required: '*'
			}
		}
	});
	
});
</script>

<form id="for_ven">
<input name="action_venta" id="action_venta" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_ven_id" id="hdd_ven_id" type="hidden" value="<?php echo $_POST['ven_id']?>">
<input name="hdd_usu_id" id="hdd_usu_id" type="hidden" value="<?php echo $_SESSION['usuario_id']?>">
<input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_SESSION['puntoventa_id']?>">

 <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      	<td>
      		<label for="txt_ven_fec">Fecha:</label>
        	<input name="txt_ven_fec" type="text" class="fecha" id="txt_ven_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly>
    	</td>
        <td>
        	<label for="cmb_ven_doc">Documento:</label>
        	<select name="cmb_ven_doc" id="cmb_ven_doc">
        	</select>
        </td>
        <td>
        	<label for="chk_imprimir">Imprimir Documento</label>
        	<input name="chk_imprimir" type="checkbox" id="chk_imprimir" value="1" checked="CHECKED">
        </td>
    </tr>
    <tr>
      <td>&nbsp</td>
    </tr>
    <tr>
      <td>
        <label for="cmb_ven_tip">Tipo:</label>
        <select name="cmb_ven_tip" id="cmb_ven_tip">
        	<option value="1" selected="selected">ANULACIÓN DE LA OPERACIÓN</option>
        </select>
      </td>
      <td>
          <label for="cmb_ven_docRel">Vinculado a:</label>
          <select name="cmb_ven_docRel" id="cmb_ven_docRel">
              <option value="2" selected="selected">FACTURA</option>
              <option value="3" selected="selected">BOLETA</option>
          </select>

      	<label for="txt_ven_ser">Serie:</label>
        <input name="txt_ven_ser" type="text" id="txt_ven_ser" style="text-align:right; font-size:14px"  value="" maxlength="4" size="6">
        <label for="txt_ven_num">Número:</label>
        <input name="txt_ven_num" type="text" id="txt_ven_num" style="text-align:right; font-size:14px"  value="" maxlength="8" size="8">
      </td>
    </tr>
</table>

</form>