<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVentacanje.php");
$oVentacanje = new cVentacanje();
require_once ("../formatos/formato.php");

$dts1=$oVentacanje->mostrar_filtro_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id']);

$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(function() {	
	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-newwin"},
		text: false
	});

	$("#tabla_venta").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		headers: {
			0: {sorter: 'shortDate' },
			11: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0],[1,0]]
    });
	
}); 
</script>
        <table cellspacing="1" id="tabla_venta" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th>NOTA DE VENTA</th>
                  <th>VENTA</th>
                    <!--<th align="right" title="Descuento">DESC</th>-->
                    <th align="right">VENDEDOR</th>
                    <th align="right">PUNTO VENTA</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
				?>
                    <tr>
                      <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_ventacanje_fec'])?></td>
                      <td nowrap="nowrap">
					  <?php echo $dt1['doc_abr1'].' '.$dt1['numdoc1']?>
					  <a class="btn_editar" href="#update" onClick="ventanota_form('editar','<?php echo $dt1['tb_ventanota_id']?>')">Ver</a></td>
                      <td><?php echo $dt1['doc_abr2'].' '.$dt1['numdoc2']?>
					  <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">Ver</a></td>
                      <td align="right"><?php echo $dt1['tb_usuario_nom'].' '.$dt1['tb_usuario_apepat']?></td>
                      <td align="right"><?php echo $dt1['tb_puntoventa_nom']?></td>
                    </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
			}
		    ?>
                <tr class="even">
                  <td colspan="3">TOTAL</td>
                  <!--<td align="right"><strong><?php //echo formato_money($total_des)?></strong></td>-->
                  <td colspan="2" align="right">&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="6"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>