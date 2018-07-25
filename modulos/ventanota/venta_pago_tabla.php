<?php
require_once ("../../config/Cado.php");
require_once ("../ventanota/cVentanotapago.php");
$oVentanotapago = new cVentanotapago();

require_once ("../formatos/formato.php");

/*$dts= $oVenta->mostrarUno($_POST['ven_id']);
$dt = mysql_fetch_array($dts);
	$fec	=mostrarFecha($dt['tb_venta_fec']);
	$doc_id	=$dt['tb_documento_id'];
	$numdoc	=$dt['tb_venta_numdoc'];
	$cli_id	=$dt['tb_cliente_id'];
	$valven	=$dt['tb_venta_valven'];
	$igv	=$dt['tb_venta_igv'];
	$des	=$dt['tb_venta_des'];
	$tot	=$dt['tb_venta_tot'];
mysql_free_result($dts);*/

$dts1=$oVentanotapago->mostrar_pagos($_POST['ven_id']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn_agregar').button({
		icons: {primary: "ui-icon-plus"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	
	/*$("#tabla_pago_detalle").tablesorter({
		widgets: ['zebra'],
		headers: {
			//4: {sorter: 'shortDate' },
			//8: { sorter: false}
			},
		//sortForce: [[0,0]],
		//sortList: [[2,0]]
    });*/
}); 
</script>
<style>
	div#tabla_pago_detalle { margin: 0 0; }
	div#tabla_pago_detalle table { margin: 0 0; border-collapse: collapse;}
	div#tabla_pago_detalle table td, div#tabla_pago_detalle table th { border: 1px solid #eee; padding: 3px 8px; font-size:10px; }
	div#tabla_pago_detalle table th { height:16px }
</style>
<?php
	/*if($num_rows==0)echo $num_rows.' Ningún registro.';
	if($num_rows==1)echo $num_rows.' registro.';
	if($num_rows>=2)echo $num_rows.' registros.';*/
if($num_rows>0){
?>
<div id="tabla_pago_detalle" class="ui-widget">
        <table class="ui-widget ui-widget-content">
            <thead>
                <tr class="ui-widget-header">
                  <th>FECHA</th>
                  <th>FORMA DE PAGO</th>
                  <th>DETALLE</th>
                  <th align="right" nowrap="nowrap">MONTO</th>
                </tr>
            </thead>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>
                          <td><?php echo mostrarFecha($dt1['tb_ventapago_fec'])?></td>
                          <td><?php 
						  	if($dt1['tb_formapago_id']==1)echo 'CONTADO ';
							if($dt1['tb_formapago_id']==2)echo 'CREDITO '.$dt1['tb_ventapago_numdia'].'D | FV: '.mostrarFecha($dt1['tb_ventapago_fecven']);
							
							/*if($dt1['tb_modopago_id']==1)echo 'EFECTIVO';
							if($dt1['tb_modopago_id']==2)echo 'DEPOSITO';
							if($dt1['tb_modopago_id']==3)echo 'TARJETA';*/
							?></td>
                          <td><?php 
							if($dt1['tb_modopago_id']==1)echo 'EFECTIVO';
							if($dt1['tb_modopago_id']==2)echo 'DEPOSITO '.$dt1['tb_cuentacorriente_nom'].' N° Oper: '.$dt1['tb_ventapago_numope'];
							if($dt1['tb_modopago_id']==3)echo 'TARJETA '.$dt1['tb_tarjeta_nom'].' N° Oper: '.$dt1['tb_ventapago_numope'];
							?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_ventapago_mon'])?></td>
                        </tr>
                        <?php						
                	}
                mysql_free_result($dts1);
                ?>
                </tbody>
        </table>
</div>
<?php }?>