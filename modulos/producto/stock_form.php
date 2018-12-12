<?php
require_once ("../../config/Cado.php");
require_once ("../producto/cProducto.php");
$oProducto = new cProducto();
require_once ("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once("cStock.php");
$oStock = new cStock();
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
	
	$dts=$oAlmacen->mostrarUno($_POST['alm_id']);
	$dt = mysql_fetch_array($dts);
		$alm_nom=$dt['tb_almacen_nom'];
		$alm_ven=$dt['tb_almacen_ven'];
	mysql_free_result($dts);

if($_POST['action']=="editar"){
	$rws= $oStock->stock_por_presentacion($_POST['pre_id'],$_POST['alm_id']);
	$rw = mysql_fetch_array($rws);
		$stock_num=$rw['tb_stock_num'];
		
		if($stock_num==""){
			$stock_num='0';
		}
		
	mysql_free_result($rws);
}
?>

<script type="text/javascript">
$('.cantidad').autoNumeric({
	aSep: '',
	aDec: '.',
	vMin: '0',
	vMax: '99999'
});

$(function() {
	
	<?php 
	//if($_POST['action']=="insertar")
	//{
	?>
	$('#txt_sto_num').focus();
	<?php //}?>		

//formulario
	$("#for_sto").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../producto/stock_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_sto").serialize(),
				beforeSend: function() {			
					$("#div_stock_form" ).dialog( "close" );
					$('#msj_presentacion_stock').html("Guardando...");
					$('#msj_presentacion_stock').show(100);
				},
				success: function(html){						
					$('#msj_presentacion_stock').html(html);
				},
				complete: function(){
					presentacion_stock();
				}
			});			
		},
		rules: {
			txt_sto_num: {
				required: true
			}
		},
		messages: {
			txt_sto_num: {
				required: '*'
			}
		}
	});						
});
</script>
<style>
	div#cuadro_sto_form { margin: 0 0; }
	div#cuadro_sto_form table { margin: 0.1em 0; border-collapse: collapse; width: 100%; }
	div#cuadro_sto_form table td, div#cuadro_sto_form table th { border: 1px solid #eee; padding: 2px 3px; }
</style>
<span style="font-weight:bold"><?php echo $pro_nom.' - '.$pre_nom?></span>
<form id="for_sto">
<input name="action_stock" id="action_stock" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_pre_id" id="hdd_pre_id" type="hidden" value="<?php echo $_POST['pre_id']?>">
<input name="hdd_alm_id" id="hdd_alm_id" type="hidden" value="<?php echo $_POST['alm_id']?>">
<input name="hdd_sto_id" id="hdd_sto_id" type="hidden" value="<?php echo $_POST['sto_id']?>">
<div id="cuadro_sto_form" class="ui-widget">
    <table class="ui-widget ui-widget-content">
        <tr class="ui-widget-header">
          <th>ALMACEN</th>
          <th align="center">STOCK</th>
        </tr>
        <tr>
          <td><?php echo $alm_nom?></td>
          <td align="center"><input name="txt_sto_num" type="text" class="cantidad" id="txt_sto_num" style="text-align:right" size="10" maxlength="6" value="<?php echo $stock_num?>"></td>
        </tr>
    </table>
</div>