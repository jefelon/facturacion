<?php
require_once ("../../config/Cado.php");
require_once ("cAtributo.php");
$oAtributo = new cAtributo();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

if($_POST['action']=="insertar")
{
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
}

if($_POST['action']=="editar")
{
	$dts=$oAtributo->mostrarUno($_POST['atr_id']);
	$dt = mysql_fetch_array($dts);
		$atr_nom	=$dt['tb_atributo_nom'];
		$atr_idp	=$dt['tb_atributo_idp'];
		$cat_id		=$dt['tb_categoria_id'];
	mysql_free_result($dts);
	
	if($cat_id==0)$cat_id=$_POST['cat_id'];
}
?>

<script type="text/javascript">
function cmb_atr_idp()
{	
	$.ajax({
		type: "POST",
		url: "../atributo/cmb_atrval_idp.php",
		async:true,
		dataType: "html",                      
		data: ({
			atr_id: "<?php echo $_POST['atr_id']?>",
			atr_idp: "<?php echo $atr_idp?>",
			cat_id: "<?php echo $cat_id?>"
		}),
		beforeSend: function() {
			$('#cmb_atr_idp').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_atr_idp').html(html);
		}
	});
}

function cmb_atr_cat_id()
{	
	$.ajax({
		type: "POST",
		url: "../categoria/cmb_cat_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			cat_id: "<?php echo $cat_id?>"
		}),
		beforeSend: function() {
			$('#cmb_atr_cat_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_atr_cat_id').html(html);
		}
	});
}

$(function() {

	cmb_atr_idp();
	cmb_atr_cat_id();
	$("#for_atr").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../atributo/atributo_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_atr").serialize(),
				beforeSend: function() {
					$("#div_atributo_form" ).dialog( "close" );
					$('#msj_atributo').html("Guardando...");
					$('#msj_atributo').show(100);
				},
				success: function(data){						
					$('#msj_atributo').html(data.atr_msj);
					<?php
					if($_POST['vista']=="cmb_atr_id")
					{
						echo $_POST['vista'].'(data.atr_id);';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="atributo_tabla")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			cmb_atr_idp: {
				required: true
			},
			txt_atr_nom: {
				required: true
			}
		},
		messages: {
			cmb_atr_idp: {
				required: '*'
			},
			txt_atr_nom: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_atr">
<input name="action_atributo" id="action_atributo" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_atr_id" id="hdd_atr_id" type="hidden" value="<?php echo $_POST['atr_id']?>">
    <table>
        <!--<tr>
          <td align="right"><label for="cmb_atr_cat_id">Categoria:</label></td>
          <td><select name="cmb_atr_cat_id" id="cmb_atr_cat_id">
          </select></td>
        </tr>-->
        <tr>
          <td align="right"><label for="cmb_atr_idp">Atributo Padre:</label></td>
          <td><select name="cmb_atr_idp" id="cmb_atr_idp">
          </select></td>
        </tr>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_atr_nom" type="text" id="txt_atr_nom" value="<?php echo $atr_nom?>" size="55" maxlength="50"></td>
        </tr>
        
    </table>
</form>