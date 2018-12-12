<?php
require_once ("../../config/Cado.php");
require_once ("cProducto.php");
$oProducto = new cProducto();

require_once("../formatos/formatos.php");

$dts= $oProducto->mostrarUno($_GET['pro_id']);
$dt = mysql_fetch_array($dts);
		$pro_nom	=$dt['tb_producto_nom'];
		$pro_des	=$dt['tb_producto_des'];
		$cat_nom	=$dt['tb_categoria_nom'];
		$mar_nom	=$dt['tb_marca_nom'];
		$pro_est	=$dt['tb_producto_est'];
mysql_free_result($dts);

?>
<script type="text/javascript">
		
$(function() {	

});
</script>
<style>
	div#tabla_pre { margin: 0 0; }
	div#tabla_pre table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#tabla_pre table td, div#tabla_pre table th { border: 1px solid #eee; padding: 2px 3px; font-size:9pt; }
	div#tabla_pre table th { height:18px }
	div#tabla_pre table td { height:17px }
</style>
<div id="tabla_pre" class="ui-widget">
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ui-widget ui-widget-content">
<!--<thead>
    <tr class="ui-widget-header">
      <th>PRODUCTO</th>
      <th>MARCA</th>
      <th>CATEGORIA</th>                    
    </tr>
</thead>-->
<tbody>
  <tr>
    <td><span style="font-size: 7pt;"><?php echo $pro_nom?></span></td>
    </tr>
  <tr>
    <td><span style="font-size: 7pt;"><?php echo $mar_nom?></span></td>
    </tr>
  <tr>
    <td><span style="font-size: 7pt;"><?php echo $cat_nom?></span></td>
    </tr>
</tbody>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="ui-widget ui-widget-content">
<thead>
  <tr class="ui-widget-header">
    <th><span style="font-size: 7pt;">Descripción</span></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td><span style="font-size: 7pt;"><?php echo $pro_des?></span></td>
  </tr>
</tbody>
</table>