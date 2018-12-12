<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoProducto = new cCatalogoProducto();
require_once("../formatos/formato.php");

if($_POST['action']=="editar"){
	$can 	= $_SESSION['notalmacen_car'][$_POST['cat_id']];
	
	//producto por catalogo y stock y almacen
	$dts= $oCatalogoProducto->presentacion_catalogo_stock_almacen($_POST['cat_id'],$_POST['alm_id']);
	$dt = mysql_fetch_array($dts);
		$pro_nom=$dt['tb_producto_nom'];
		$pre_nom=$dt['tb_presentacion_nom'];
		$pre_id	=$dt['tb_presentacion_id'];
		$sto_num=$dt['tb_stock_num'];
		$cat_mul=$dt['tb_catalogo_mul'];
		$nombre_articulo=$pro_nom.' '.$pre_nom;
	mysql_free_result($dts);
}
?>

<script type="text/javascript">
$('.cantidad2').autoNumeric({
	aSep: ',',
	aDec: '.',
	vMin: '1',
	vMax: '<?php if($sto_num!=""){ echo $sto_num; } else { echo '99999';}?>'
});

$(function() {
	$("#for_item").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../notalmacen/notalmacen_car_item_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_item").serialize(),
				beforeSend: function(){
					$('#div_item_form').dialog("close");
					$('#msj_notalmacen_car_item').html("Cargando...");
					$('#msj_notalmacen_car_item').show(100);				
				},
				success: function(data){
					$('#msj_notalmacen_car_item').html(data.ite_msj);
				},
				complete: function(){
					notalmacen_car('actualizar');			
				}
			});			
		},
		rules: {
			txt_item_can: {
				required: true
			}
		},
		messages: {
			txt_item_can: {
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
    	  <td>Stock:</td>
    	  <td><?php echo $sto_num?></td>
  	  </tr>
    	<tr>
    	  <td><label for="txt_item_can">Cantidad:</label></td>
    	  <td><input name="txt_item_can" id="txt_item_can" type="text" class="cantidad2" value="<?php echo $can?>" size="10" style="text-align:right"></td>
  	  </tr>
        
       
    </table>
</form>