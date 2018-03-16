<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
$oCompra = new cCompra();
require_once ("../formatos/formato.php");
require_once ("../formatos/operaciones.php");

$dts1=$oCompra->mostrar_filtro(fecha_mysql($_POST['com_fec1']),fecha_mysql($_POST['com_fec2']),$_POST['com_mon'],$_POST['pro_id'],$_POST['com_est'],$_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts1);
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

	$("#tabla_compra").tablesorter({
		widgets : ['zebra','zebraHover'],
		headers: {
			0: {sorter: 'shortDate' },
			10: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_compra" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th title="FECHA DE VENCIMIENTO">FECHA VCTO</th>
                  <th title="DOCUMENTO">DOC</th>
                  <th title="NUMERO DE DOCUMENTO">NUM DOC</th>                    
                  <th>PROVEEDOR</th>
                  <th>RUC/DNI</th>
                  <th>ALMACEN</th>
                  <th align="right" title="MONEDA">MON</th>
                  <th align="right">VALOR VENTA</th>
                  <th align="right">IGV</th>
                  <th align="right">PERC</th>
                  <th align="right">TOTAL</th>
                  <th align="right">ESTADO</th>
                  <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
					
					if($dt1['tb_compra_est']=='CANCELADA' or $dt1['tb_compra_est']=='EMITIDA'){
						$total_valven+=$dt1['tb_compra_valven'];
						$total_igv+=$dt1['tb_compra_igv'];
						$total_per+=$dt1['tb_compra_per'];
						$total_compras+=$dt1['tb_compra_tot'];
					}
					$diferencia_días=0;
					$estilo="";
					//dia vencimiento - dia actual
					if(mostrarFecha($dt1['tb_compra_fecven'])!="")$diferencia_días=restaFechas(date('d-m-Y'),mostrarFecha($dt1['tb_compra_fecven']));
					
					if($diferencia_días>0 and $dt1['tb_compra_est']=='EMITIDA')
					{
						$estilo='style="color:#298A08; font-weight:bold;"';
					}
					
					if($diferencia_días<=0 and $dt1['tb_compra_est']=='EMITIDA')
					{
						$estilo='style="color:#F00; font-weight:normal;"';
					}
				?>
                    <tr>
                      <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_compra_fec'])?></td>
                      <td nowrap="nowrap">
					  <span <?php echo $estilo?>>
					  <?php echo mostrarFecha($dt1['tb_compra_fecven'])?>
                      </span>
                      </td>
                      <td title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr']?></td>
                      <td><?php echo $dt1['tb_compra_numdoc']?></td>
                      <td><?php echo $dt1['tb_proveedor_nom']?></td>
                      <td><?php echo $dt1['tb_proveedor_doc']?></td>
                      <td><?php echo $dt1['tb_almacen_nom']?></td>
                      <td align="right"><?php if($dt1['tb_compra_mon']==1)echo "S/."; if($dt1['tb_compra_mon']==2)echo "US$";?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compra_valven'])?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compra_igv'])?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compra_per'])?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compra_tot'])?></td>
                      <td align="right"><?php echo $dt1['tb_compra_est']?></td>
                      <td align="left" nowrap="nowrap">
                      <?php if($dt1['tb_compra_est']!='ANULADA'){?>
                      <a class="btn_editar" href="#update" onClick="compra_form('editar','<?php echo $dt1['tb_compra_id']?>')">Editar</a> 
                      <a class="btn_anular" href="#anular" onClick="compra_anular('<?php echo $dt1['tb_compra_id']?>')">Anular</a> 
                      <?php }?>
                      <!--<a class="btn_eliminar" href="#delate" onClick="eliminar_compra('<?php //echo $dt1['tb_compra_id']?>')">Eliminarr</a>-->
                      </td>
                    </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
			}
			
			//ocultar cuando no se selecciona moneda
			if($_POST['com_mon']>0){
		    ?>
                <tr class="even">
                  <td colspan="8">TOTAL</td>
                  <td align="right"><strong><?php echo formato_money($total_valven)?></strong></td>
                  <td align="right"><strong><?php echo formato_money($total_igv)?></strong></td>
                  <td align="right"><strong><?php echo formato_money($total_per)?></strong></td>
                  <td align="right"><strong><?php echo formato_money($total_compras)?></strong></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
             <?php }?>
                <tr class="even">
                  <td colspan="14"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>