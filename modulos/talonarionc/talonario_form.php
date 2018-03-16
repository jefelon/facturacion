<?php
require_once ("../../config/Cado.php");
require_once ("cTalonario.php");
$oTalonario = new cTalonario();

if($_POST['action']=="insertar")
{
	$ini=1;
	$num=0;
}

if($_POST['action']=="editar")
{
	$dts=$oTalonario->mostrarUno($_POST['tal_id']);
	$dt = mysql_fetch_array($dts);
		$doc_id=$dt['tb_documento_id'];
		$punven_id=$dt['tb_puntoventa_id'];
		$ser=$dt['tb_talonario_ser'];
		$ini=$dt['tb_talonario_ini'];
		$fin=$dt['tb_talonario_fin'];
		$num=$dt['tb_talonario_num'];
		$est=$dt['tb_talonario_est'];
	mysql_free_result($dts);
}

?>

<script type="text/javascript">
$('.cantidad').autoNumeric({
	aSep: '',
	aDec: '.',
	vMin: '0',
	vMax: '99999999'
});

function cmb_punven_id()
{	
	$.ajax({
		type: "POST",
		url: "../puntoventa/cmb_punven_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			punven_id: "<?php echo $punven_id?>"
		}),
		beforeSend: function() {
			$('#cmb_punven_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_punven_id').html(html);
		}
	});
}

function cmb_doc_id()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'2',
			doc_id: '<?php echo $doc_id?>',
			vista:	'<?php //echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_doc_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_doc_id').html(html);
		}
	});
}

$(function() {
	
	cmb_punven_id();
	cmb_doc_id();

	$("#for_tal").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../talonarionc/talonario_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_tal").serialize(),
				beforeSend: function() {
					$("#div_talonario_form" ).dialog( "close" );
					$('#msj_talonario').html("Guardando...");
					$('#msj_talonario').show(100);
				},
				success: function(html){						
					$('#msj_talonario').html(html);
				},
				complete: function(){
					talonario_tabla();
				}
			});
		},
		rules: {
			cmb_punven_id: {
				required: true
			},
			cmb_doc_id: {
				required: true
			},
			txt_tal_ser: {
				required: true
			},
			txt_tal_ini: {
				required: true
			},
			txt_tal_fin: {
				required: true
			},
			txt_tal_num: {
				required: true
			},
			cmb_tal_est: {
				required: true
			}
		},
		messages: {
			cmb_punven_id: {
				required: '*'
			},
			cmb_doc_id: {
				required: '*'
			},
			txt_tal_ser: {
				required: '*'
			},
			txt_tal_ini: {
				required: '*'
			},
			txt_tal_fin: {
				required: '*'
			},
			txt_tal_num: {
				required: '*'
			},
			cmb_tal_est: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_tal">
<input name="action_talonario" id="action_talonario" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tal_id" id="hdd_tal_id" type="hidden" value="<?php echo $_POST['tal_id']?>">
    <table>
        <tr>
          <td><label for="cmb_punven_id">Punto de Venta:</label></td>
    	  <td colspan="3"><select name="cmb_punven_id" id="cmb_punven_id">
    </select>
    	  </td>
        </tr>
        <tr>
          <td align="right"><label for="cmb_doc_id">Documento:</label></td>
          <td colspan="3">
        <select name="cmb_doc_id" id="cmb_doc_id">
        </select></td>
        </tr>
        <tr>
          <td align="right"><label for="txt_tal_ser">Serie:</label></td>
          <td colspan="3"><input name="txt_tal_ser" type="text" id="txt_tal_ser" size="20" maxlength="10" value="<?php echo $ser?>"></td>
        </tr>
        <tr>
          <td align="right"><label for="txt_tal_ini">Inicio</label> - <label for="txt_tal_fin">Fin</label>:</td>
          <td colspan="3"><input type="text" name="txt_tal_ini" id="txt_tal_ini" class="cantidad" style="text-align:right" size="10" maxlength="8" value="<?php echo $ini?>">
            -
            <input type="text" name="txt_tal_fin" id="txt_tal_fin" class="cantidad" style="text-align:right" size="10" maxlength="8" value="<?php echo $fin?>"></td>
        </tr>
        <tr>
          <td align="right"><label for="txt_tal_num" title="Último utilizado">Número:</label></td>
          <td><input type="text" name="txt_tal_num" id="txt_tal_num" class="cantidad" style="text-align:right" size="10" maxlength="8" value="<?php echo $num?>"></td>
          <td align="right"><label for="cmb_tal_est">Estado:</label></td>
          <td><select name="cmb_tal_est" id="cmb_tal_est">
            <option value="">-</option>
            <option value="ACTIVO" <?php if($est=='ACTIVO')echo 'selected'?>>ACTIVO</option>
            <option value="ESPERA" <?php if($est=='ESPERA')echo 'selected'?>>ESPERA</option>
            <option value="INACTIVO" <?php if($est=='INACTIVO')echo 'selected'?>>INACTIVO</option>
          </select></td>
        </tr>
    </table>
</form>