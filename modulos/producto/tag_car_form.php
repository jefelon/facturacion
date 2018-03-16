<?php
require_once ("../../config/Cado.php");
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

$dts1=$oCategoria->mostrarUno($_POST['cat_id']);
$dt1 = mysql_fetch_array($dts1);
$idp1=$dt1['tb_categoria_idp'];
mysql_free_result($dts1);

if($idp1==0)
{
	$cat_id=$_POST['cat_id'];
}
else
{
	$dts1=$oCategoria->mostrarUno($idp1);
	$dt1 = mysql_fetch_array($dts1);
	$idp2=$dt1['tb_categoria_idp'];
	mysql_free_result($dts1);
	
	if($idp2==0)
	{
		$cat_id=$idp1;
	}
	else
	{
		$cat_id=$idp2;		
	}	
}

?>
<script type="text/javascript">
$('.btn_ir').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$(".btn_ir").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

function cmb_atr_id(idf)
{	
	$.ajax({
		type: "POST",
		url: "../atributo/cmb_atr_sel.php",
		async:true,
		dataType: "html",                      
		data: ({
			atr_id: idf,
			atr_idp: "<?php echo $atr_idp?>",
			cat_id: "<?php echo $cat_id?>"
		}),
		beforeSend: function() {
			$('#cmb_atr_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_atr_id').html(html);
		}
	});
}

$(function() {
	cmb_atr_id(<?php echo $_POST['atr_id']?>);

	$("#for_atragr").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../producto/presentacion_tag_car.php",
				async:true,
				dataType: "json",
				data: $("#for_atragr").serialize(),
				beforeSend: function() {
					//$("#div_atributo_agregar" ).dialog( "close" );
					//$('#msj_atributo').html("Guardando...");
					//$('#msj_atributo').show(100);
				},
				success: function(data){						
					//$('#msj_atributo').html(data.atr_msj);
					//presentacion_tag_car();
				},
				complete: function(){
					presentacion_tag_car();
				}
			});
		},
		rules: {
			cmb_atr_id: {
				required: true
			}
		},
		messages: {
			cmb_atr_id: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_atragr">
<input name="action" id="action" type="hidden" value="<?php echo $_POST['action']?>">
<!--<input name="hdd_atr_id" id="hdd_atr_id" type="hidden" value="<?php //echo $_POST['atr_id']?>">-->
    <table>
        <tr>
          <td align="right"><label for="cmb_atr_id">Atributo:</label></td>
          <td><select name="cmb_atr_id" id="cmb_atr_id">
          </select>
          <a id="btn_cmb_atr_id" class="btn_ir" href="#" onClick="atributo_val_form('insertar')">Agregar Atributo</a>
          </td>
        </tr>
    </table>
</form>