<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
$oCompra = new cCompra();
require_once ("../gasto_r/cGasto.php");
$oGasto = new cGasto();
require_once ("../formatos/formato.php");
require_once ("../formatos/operaciones.php");
require_once ("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();

$pvs=$oProveedor->mostrarTodos();
$num_pvrows= mysql_num_rows($pvs);

?>

<script type="text/javascript">
$(function() {	
	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	
	$('.btn_anular').button({
		icons: {primary: "ui-icon-cancel"},
		text: false
	});

	$.tablesorter.defaults.widgets = ['zebra'];
	//$.tablesorter.defaults.sortList = [[0,0]];
	$("#tabla_compra").tablesorter({
		widgets : ['zebra','zebraHover'],
		headers: {
			1: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_compra" class="tablesorter">
            <thead>
                <tr>
                  <th>PROVEEDOR</th>
                  <th>RUC/DNI</th>
                  <th align="right">TOTAL</th>
                  <th align="right">PAGOS S/.</th>
                </tr>
            </thead>
            <?php

			if($num_pvrows>0){
			?>
            <tbody>
                <?php
				while($pv = mysql_fetch_array($pvs)){
                    $dts1=$oCompra->mostrar_filtro(fecha_mysql($_POST['com_fec1']),fecha_mysql($_POST['com_fec2']),$_POST['com_mon'],$pv['tb_proveedor_id'],$_POST['com_est'],$_SESSION['empresa_id']);
                    $num_rows= mysql_num_rows($dts1);
                    $total=0;
                    $total_pagos=0;
                    while($dt1 = mysql_fetch_array($dts1)) {
                        $total=$total+$dt1['tb_compra_tot'];
                        //pagos
                        $dts2=$oGasto->mostrar_por_compra($dt1['tb_compra_id']);
                        $sum_importe=0;
                        while($dt2 = mysql_fetch_array($dts2)){
                            if($dt2['tb_gasto_est']=='CANCELADO')
                            {
                                $sum_importe+=$dt2['tb_gasto_imp'];
                            }
                        }
                        mysql_free_result($dts2);
                        $total_pagos+=$sum_importe;
                    }
				?>
                    <tr>
                      <td><?php echo $pv['tb_proveedor_nom']?></td>
                      <td><?php echo $pv['tb_proveedor_doc']?></td>
                      <td align="right"><?php echo formato_money($total)?></td>
                      <td align="right"><?php echo formato_money($total_pagos)?></td>
                    </tr>
                <?php
				}
                mysql_free_result($pvs);
                ?>
            </tbody>
            <?php
			}

		    ?>
                <tr class="even">
                  <td colspan="12"><?php echo $num_pvrows.' registros'?></td>
                </tr>
        </table>