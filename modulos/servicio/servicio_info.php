<?php
require_once ("../../config/Cado.php");
require_once ("cProducto.php");
$oProducto = new cProducto();

require_once("../formatos/formatos.php");

$dts= $oProducto->mostrarUno($_POST['pro_id']);
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
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_proveedor").tablesorter({ 
		headers: {
		},
		//sortForce: [[0,0]],
		//sortList: [[0,0]]
    });
});
</script>
<style>
	div#tabla_pre { margin: 0 0; }
	div#tabla_pre table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#tabla_pre table td, div#tabla_pre table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#tabla_pre table th { height:18px }
	div#tabla_pre table td { height:17px }
</style>
<div id="tabla_pre" class="ui-widget">
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
<thead>
    <tr class="ui-widget-header">
      <th>PRODUCTO</th>
      <th>MARCA</th>
      <th>CATEGORIA</th>                    
    </tr>
</thead>
<tbody>
  <tr>
    <td><span style="font-weight: bold; font-size: 12px;"><?php echo $pro_nom?></span></td>
    <td><span style="font-weight:bold"><?php echo $mar_nom?></span></td>
    <td><span style="font-weight:bold"><?php echo $cat_nom?></span></td>
  </tr>
</tbody>
</table>
<br>
</div>
<fieldset><legend>Proveedor(es) de producto</legend>
<?php
$dts1=$oProducto->mostrar_proveedor_por_producto($_POST['pro_id']);
$num_rows= mysql_num_rows($dts1);
if($num_rows>0){
	while($dt1 = mysql_fetch_array($dts1))
	{
    	$total+=$dt1['numero'];
	}
    mysql_free_result($dts1);
}

$dts1=$oProducto->mostrar_proveedor_por_producto($_POST['pro_id']);
$num_rows= mysql_num_rows($dts1);

?>
<table cellspacing="1" id="tabla_proveedor" class="tablesorter">
            <thead>
                <tr>
                  <th>PROVEEDOR</th>               
                    <th>RUC/DNI</th>
                    <th>DIRECCION</th>
                    <th>CONTACTO</th>
                    <th>TELEFONO</th>
                    <th>EMAIL</th>
                    <th align="right" title="Representatividad en Compras">REP</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
						$resultado=($dt1['numero']/$total)*100;
				?>
                        <tr>
                          <td><?php echo $dt1['tb_proveedor_nom']?></td>                            
                            <td><?php echo $dt1['tb_proveedor_doc']?></td>
                            <td><?php echo $dt1['tb_proveedor_dir']?></td>
                            <td><?php echo $dt1['tb_proveedor_con']?></td>                     
                            <td><?php echo $dt1['tb_proveedor_tel']?></td>
                            <td><?php echo $dt1['tb_proveedor_ema']?></td>
                            <td align="right"><?php echo number_format($resultado, 1).'%'?></td>
                        </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
                </tbody>
            <?php }?>
        </table>
</fieldset>