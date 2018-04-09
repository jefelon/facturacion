<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoProducto = new cCatalogoProducto();
require_once ("../servicio/cServicio.php");
$oServicio = new cServicio();
require_once ("../catalogo/cst_producto.php");

require_once("../formatos/formato.php");

$unico_id=$_POST['unico_id'];

if($_POST['action']=="editar_producto"){
	
	$almacen_venta=$_SESSION['almacen_id'];
	
	//producto por catalogo y stock y almacen
	$dts= $oCatalogoProducto->presentacion_catalogo_stock_almacen($_POST['ite_id'],$almacen_venta);
	$dt = mysql_fetch_array($dts);
		$pro_nom=$dt['tb_producto_nom'];
		$pre_nom=$dt['tb_presentacion_nom'];
		$pre_id	=$dt['tb_presentacion_id'];
		$sto_num=$dt['tb_stock_num'];
		$cat_mul=$dt['tb_catalogo_mul'];
		$cat_precos=$dt['tb_catalogo_precos'];
		$nombre_articulo=$pro_nom.' '.$pre_nom;
	mysql_free_result($dts);
	
	$can 	= $_SESSION['venta_car'][$unico_id][$_POST['ite_id']];
	$preven = $_SESSION['venta_preven'][$unico_id][$_POST['ite_id']];
    $serie  = $_SESSION['venta_serial'][$unico_id][$_POST['ite_id']];
	
	//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
	$tipdes = $_SESSION['venta_tipdes'][$unico_id][$_POST['ite_id']];				
	if($tipdes == 1){
		$des = ($_SESSION['venta_des'][$unico_id][$_POST['ite_id']]);//Descuento Venta Detalle
	}
	if($tipdes == 2){
		$des = $_SESSION['venta_des'][$unico_id][$_POST['ite_id']];//Descuento Venta Detalle	
	}

	//costo promedio
	$stock_kardex=stock_kardex($_POST['ite_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
        
    $costo_ponderado_array=costo_ponderado_empresa($_POST['ite_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$cat_precos,$precosdol,$_SESSION['empresa_id']);
    
    $costo_ponderado=$costo_ponderado_array['soles'];
    $costo_ponderado1=formato_money($costo_ponderado);
    $costo_ponderado2=moneda_mysql($costo_ponderado1);
}

if($_POST['action']=="editar_servicio"){
	
	$dts=$oServicio->mostrarUno($_POST['ite_id']);
	$dt = mysql_fetch_array($dts);
		$ser_nom=$dt['tb_servicio_nom'];
		$nombre_articulo=$ser_nom;
	mysql_free_result($dts);
	
	$sto_num=999;
	
	$can 	= $_SESSION['servicio_car'][$unico_id][$_POST['ite_id']];
	$preven = $_SESSION['servicio_preven'][$unico_id][$_POST['ite_id']];	
	
	//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
	$tipdes = $_SESSION['servicio_tipdes'][$unico_id][$_POST['ite_id']];				
	if($tipdes == 1){
		$des = ($_SESSION['servicio_des'][$unico_id][$_POST['ite_id']]);//Descuento Venta Detalle
	}
	if($tipdes == 2){
		$des = $_SESSION['servicio_des'][$unico_id][$_POST['ite_id']];//Descuento Venta Detalle	
	}

	$costo_ponderado=0;
}
?>

<script type="text/javascript">
$('.moneda4').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '999999.99'
});
$('.porcentaje3').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99.99'
});
$('.cantidad3').autoNumeric({
	aSep: ',',
	aDec: '.',
	vMin: '1',
	vMax: '<?php echo $sto_num?>'
});

$(function() {
	$("#for_item").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../venta/venta_car_item_reg.php",
				async:false,
				dataType: "json",
				data: $("#for_item").serialize(),
				beforeSend: function(){
					$('#div_item_form').dialog("close");
					$('#msj_venta_car_item').html("Cargando...");
					$('#msj_venta_car_item').show(100);				
				},
				success: function(data){
					$('#msj_venta_car_item').html(data.ite_msj);
				},
				complete: function(){
					venta_car('actualizar');			
				}
			});			
		},
		rules: {
			txt_item_can: {
				required: true
			},
			txt_item_preven: {
				required: true,
				min: '<?php echo $costo_ponderado2?>'
			},
            txt_item_serie: {
                required: false
            },
			txt_item_des: {
				required: false
			}
		},
		messages: {
			txt_item_can: {
				required: '*'
			},
			txt_item_preven: {
				required: '*'
			},
            txt_item_serie: {
                required: '*'
            },
			txt_item_des: {
				required: '*'
			}
		}
	});	
	
	$( "#rad_tip_des" ).buttonset();	
});
</script>
<div>
<?php echo $nombre_articulo?>
</div>
<hr>
<form id="for_item">
<input name="action_item" id="action_item" type="hidden" value="<?php echo $_POST['action']?>">
<input name="unico_id" id="unico_id" type="hidden" value="<?php echo $unico_id?>">
<?php if($_POST['action']=='editar_producto'){?>
<input name="hdd_catalogo_id" id="hdd_catalogo_id" type="hidden" value="<?php echo $_POST['ite_id']?>">
    <table>
    	<tr>
    	  <td>Stock:</td>
    	  <td><?php echo $sto_num?></td>
  	  </tr>
    	<tr>
    	  <td><label for="txt_item_can">Cantidad:</label></td>
    	  <td><input name="txt_item_can" id="txt_item_can" type="text" class="cantidad3" value="<?php echo $can?>" size="10" style="text-align:right"></td>
  	  </tr>
    	<tr>
    	  <td nowrap="nowrap"><label for="txt_item_preven">Precio Venta:</label></td>
    	  <td><input name="txt_item_preven" id="txt_item_preven" type="text" value="<?php echo formato_money($preven)?>" size="10" maxlength="11"  class="moneda4" style="text-align:right; font-size:11px; font-weight:bold"></td>
  	  </tr>
  	  <tr>
    	  <td nowrap="nowrap">Promedio:</td>
    	  <td><?php echo formato_money($costo_ponderado1)?></td>
  	  </tr>
        <tr>
            <td nowrap="nowrap"><label for="txt_item_serie">Serie:</label></td>
            <td><input name="txt_item_serie" id="txt_item_serie" type="text" value="<?php echo formato_money($serie)?>" size="10" maxlength="11" style="text-align:right; font-size:11px; font-weight:bold;"></td>
        </tr>
    	<!-- <tr>
    	  <td valign="top"><label for="txt_item_des">Descuento:</label></td>
    	  <td>
          	<div id="rad_tip_des" style="width:100px; float:left">
            	<?php /*<label for="rad_tip_des_1" title="Descuento en Porcentaje">%</label>
                <input name="rad_tip_des" type="radio" id="rad_tip_des_1" value="1" <?php if($tipdes == 1) echo "checked"; ?> /> */ ?>
                <label for="rad_tip_des_2" title="Descuento en Soles">S/.</label>
                <input name="rad_tip_des" type="radio" id="rad_tip_des_2" value="2" checked readonly/>
            </div>
          	<input name="txt_item_des" id="txt_item_des" class="moneda3" type="text" value="<?php //if($tipdes == 1){	echo $des;}if($tipdes == 2){echo formato_money($des);}?>" size="10" style="text-align:right">
          </td>
  	  </tr> -->    
       
    </table>
<?php 
}

if($_POST['action']=='editar_servicio'){
?>
<input name="hdd_servicio_id" id="hdd_servicio_id" type="hidden" value="<?php echo $_POST['ite_id']?>">
    <table>
    	<tr>
    	  <td><label for="txt_item_can">Cantidad:</label></td>
    	  <td><input name="txt_item_can" id="txt_item_can" type="text" class="cantidad3" value="<?php echo $can?>" size="10" style="text-align:right"></td>
  	  </tr>
    	<tr>
    	  <td nowrap="nowrap"><label for="txt_item_preven">Precio:</label></td>
    	  <td><input name="txt_item_preven" id="txt_item_preven" type="text" value="<?php echo formato_money($preven)?>" size="10" maxlength="11"  class="moneda4" style="text-align:right; font-size:11px; font-weight:bold"></td>
  	  </tr>
    	<!-- <tr>
    	  <td valign="top"><label for="txt_item_des">Descuento:</label></td>
    	  <td>
          	<div id="rad_tip_des" style="width:100px; float:left">
            	<label for="rad_tip_des_1" title="Descuento en Porcentaje">%</label>
                <input name="rad_tip_des" type="radio" id="rad_tip_des_1" value="1" <?php //if($tipdes == 1) echo "checked"; ?> />
                <label for="rad_tip_des_2" title="Descuento en Soles">S/.</label>
                <input name="rad_tip_des" type="radio" id="rad_tip_des_2" value="2" <?php //if($tipdes == 2) echo "checked"; ?>/>
            </div>
          	<input name="txt_item_des" id="txt_item_des" class="moneda3" type="text" value="<?php //if($tipdes == 1){	echo $des;}if($tipdes == 2){echo formato_money($des);}?>" size="10" style="text-align:right">
            </td>
  	  </tr>  -->   
       
    </table>
<?php }?>
</form>