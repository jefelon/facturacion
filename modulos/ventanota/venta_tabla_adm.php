<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVentanota.php");
$oVentanota = new cVentanota();
require_once ("../formatos/formato.php");

$dts1=$oVentanota->mostrar_filtro_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id']);

$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(function() {	
	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	$('.btn_anular').button({
		icons: {primary: "ui-icon-cancel"},
		text: false
	});
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
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
                  <th>DOCUMENTO</th>
                  <th>CLIENTE</th>
                    <th>RUC/DNI</th>
                    <th align="right">SUB TOTAL</th>
                    <th align="right">IGV</th>
                    <!--<th align="right" title="Descuento">DESC</th>-->
                    <th align="right">TOTAL</th>
                    <th align="right">ESTADO</th>
                    <th align="right">VENDEDOR</th>
                    <th align="right">PUNTO VENTA</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
					if($dt1['tb_venta_est']=='CANCELADA'){
						$total_valven+=$dt1['tb_venta_valven'];
						$total_igv+=$dt1['tb_venta_igv'];
						$total_des+=$dt1['tb_venta_des'];
						$total_ventas+=$dt1['tb_venta_tot'];
					}
				?>
                    <tr>
                      <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                      <td nowrap="nowrap" title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_numdoc']?></td>
                      <td><?php echo $dt1['tb_cliente_nom']?></td>
                      <td><?php echo $dt1['tb_cliente_doc']?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_venta_valven'])?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_venta_igv'])?></td>
                      <!--<td align="right"><?php //echo $dt1['tb_venta_des']?></td>-->
                      <td align="right"><?php echo formato_money($dt1['tb_venta_tot'])?></td>
                      <td align="right"><?php echo $dt1['tb_venta_est']?></td>
                      <td align="right"><?php echo $dt1['tb_usuario_nom'].' '.$dt1['tb_usuario_apepat']?></td>
                      <td align="right"><?php echo $dt1['tb_puntoventa_nom']?></td>
                      <td align="center">
                      <a class="btn_editar" href="#update" onClick="ventanota_form('editar','<?php echo $dt1['tb_venta_id']?>')">Editar</a> 
                      <?php if($dt1['tb_venta_est']!='ANULADA' and $_POST['chk_ven_anu']==1 and $_SESSION['usuariogrupo_id']==2){?>
                      <a class="btn_anular" href="#anular" onClick="ventanota_anular('<?php echo $dt1['tb_venta_id']?>','<?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_numdoc']?>')">Anular</a> 
                      <?php }?>
                      <!--<a class="btn_eliminar" href="#delete" onClick="eliminar_venta('<?php //echo $dt1['tb_venta_id']?>')">Eliminarr</a>-->
                      </td>
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
                  <td colspan="4">TOTAL</td>
                  <td align="right"><strong><?php echo formato_money($total_valven)?></strong></td>
                  <td align="right"><strong><?php echo formato_money($total_igv)?></strong></td>
                  <!--<td align="right"><strong><?php //echo formato_money($total_des)?></strong></td>-->
                  <td align="right"><strong><?php echo formato_money($total_ventas)?></strong></td>
                  <td colspan="3" align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="12"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>