<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");

if($_POST['action']=="editar"){
	$can 	= $_SESSION['compra_car'][$_POST['cat_id']];
	
	//$precom = $_SESSION['compra_linea_preuni'][$_POST['cat_id']];
	$precom	=$_SESSION['compra_linea_precom'][$_POST['cat_id']];
	
	$des	= $_SESSION['compra_linea_des'][$_POST['cat_id']];
	$fle 	= $_SESSION['compra_linea_fle'][$_POST['cat_id']];
	
	if($_SESSION['compra_linea_tippre'][$_POST['cat_id']]==1)
	{
		$texto_precio='Valor Venta';	
	}
	
	if($_SESSION['compra_linea_tippre'][$_POST['cat_id']]==2)
	{
		$texto_precio='Precio Venta';
	}
}
?>

<script type="text/javascript">
$('.moneda2').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999.99'
});
$('.porcentaje2').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99.99'
});
$('.cantidad2').autoNumeric({
	aSep: ',',
	aDec: '.',
	vMin: '1',
	vMax: '99999'
});

$(function() {
	$("#for_item").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../compra/compra_car_item_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_item").serialize(),
				beforeSend: function(){
					$('#div_item_form').dialog("close");
					$('#msj_compra_car_item').html("Cargando...");
					$('#msj_compra_car_item').show(100);				
				},
				success: function(data){
					$('#msj_compra_car_item').html(data.ite_msj);
				},
				complete: function(){
					compra_car('actualizar');			
				}
			});			
		},
		rules: {
			txt_item_can: {
				required: true
			},
			txt_item_des: {
				required: true
			},
			txt_item_fle: {
				required: true
			}
		},
		messages: {
			txt_item_can: {
				required: '*'
			},
			txt_item_des: {
				required: '*'
			},
			txt_item_fle: {
				required: '*'
			}
		}
	});		
});
</script>
<div>
<?php echo $_POST['pro_nom']?>
</div>
<hr>
<form id="for_item">
<input name="action_item" id="action_item" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_catalogo_id" id="hdd_catalogo_id" type="hidden" value="<?php echo $_POST['cat_id']?>">

    <table>
    	<tr>
    	  <td><label for="txt_item_can">Cantidad:</label></td>
    	  <td><input name="txt_item_can" id="txt_item_can" type="text" class="cantidad2" value="<?php echo $can?>" size="10" style="text-align:right"></td>
  	  </tr>
    	<tr>
    	  <td><label for="txt_item_precom"><?php echo $texto_precio?>:</label></td>
    	  <td><input name="txt_item_precom" id="txt_item_precom" type="text" value="<?php echo formato_money($precom)?>" size="10" maxlength="11"  class="moneda2" style="text-align:right"></td>
  	  </tr>
    	<tr>
    	  <td><label for="txt_item_des">Descuento (%):</label></td>
    	  <td><input name="txt_item_des" id="txt_item_des" type="text" class="porcentaje2" value="<?php echo formato_money($des)?>" size="10" style="text-align:right"></td>
  	  </tr>
    	<tr>
            <td><label for="txt_item_fle">Flete (S/.):</label></td>
          <td><input name="txt_item_fle" id="txt_item_fle" type="text" value="<?php echo formato_money($fle)?>" size="10" maxlength="11"  class="moneda2" style="text-align:right"></td>
        </tr>
        
       
    </table>
</form>